employeeData = [];
numbersToCall = [];

$(document).ready(function() {
  getEmployees();
  listEmployees();
});

// Pulls the employees from the database
function getEmployees() {
  var employeeList = new XMLHttpRequest();
  employeeList.onload = function() {
    rawEmployeeData = (this.responseText).split("<newrecord>");
    for (i = 0; i < rawEmployeeData.length - 1; i++) {
      each = rawEmployeeData[i].split("/");
      employeeData.push({
        id: each[0],
        f_name: each[1],
        l_name: each[2],
        phone1: each[3]
      });
    }
  }
  employeeList.open("get", "php/get/get-emps.php", false);
  employeeList.send();
}

// Draws them as a list on the left side of the page
function listEmployees() {
  for (i = 0; i < employeeData.length; i++) {
    if (employeeData[i].phone1.length === 11) {
      $('#employees-on-the-left ul').append('<li class="individual-employees" id="' + employeeData[i].id + '"><p>' + employeeData[i].f_name + ' ' + employeeData[i].l_name + '</p><div class="phone-icon" onclick="getParams(' + employeeData[i].id + ');"><image src="../images/phone.svg"></image></div></li>');

      $('#status-on-the-right ul').append('<li id="' + employeeData[i].id + 'a"><p>\<-- Hit it</p></li>');

      numbersToCall.push(employeeData[i].phone1);
    }
  }
}

function callEverybody() {
  // Working on it :)
}

function getParams(id) {
  thisGuy = document.getElementById(id + 'a');
  thisEmployee = employeeData.filter(x => x.id == id);
  params = Object.values(thisEmployee[0]);
  timestamp = new Date().getTime();

  document.getElementById(id + 'a').className += timestamp.toString();

  formattedNumber = params[3].toString().split("").splice(1);
  formattedNumber.splice(3, 0, '-');
  formattedNumber.splice(7, 0, '-');
  userResponse = confirm('Call ' + params[1] + ' at ' + formattedNumber.join('') + '?');

  if (userResponse === true) {
    thisGuy.removeChild(thisGuy.lastChild);
    thisGuy.append('Calling...');
    logCall(id, params[3], timestamp);
  }
}

// Logs the call attempt in the database
function logCall(Employee_ID, phone, timestamp) {
  console.log('Call ID: ', timestamp);
  thisGuy = document.getElementById(Employee_ID + 'a');
  var oReq = new XMLHttpRequest();
  oReq.onload = function() {
    console.log(oReq.response);
    if (oReq.response === '0a') {
      thisGuy.removeChild(thisGuy.lastChild);
      thisGuy.append('Call Logging Failure');
    } else if (oReq.response === '0b') {
      thisGuy.removeChild(thisGuy.lastChild);
      thisGuy.append('AWS Failure');
    } else {
      updateStatus(Employee_ID, timestamp);
    }
  }
  oReq.open("get", "php/snow-call/log-call.php?Employee_ID=" + Employee_ID + "&Number_Dialed=" + phone + "&Call_Timestamp=" + timestamp, true);
  oReq.send();
}

/*
function makeTheCall(Employee_ID, phone, timestamp) {
  thisGuy = document.getElementById(Employee_ID + 'a');
  var oReq = new XMLHttpRequest();
  oReq.onload = function() {
    rawResponse = oReq.response;
    contactId = rawResponse.substring(20, rawResponse.length-4);
    console.log(contactId);
    updateStatus(Employee_ID, timestamp);
  }
  oReq.open("get", "php/snow-call/make-call.php?phone=" + phone + "&timestamp=" + timestamp, true);
  oReq.send();
}

// Grabs the ContactId returned by AWS and updates the call records
function insertContactId(id, phone, timestamp, contactId) {
  var oReq = new XMLHttpRequest();
  oReq.onload = function() {
    console.log(oReq.response);
    if (oReq.response === "CID=1") {
      setTimeout(function() {
        updateStatus(id, phone, timestamp);
      }, 4000);
    } else {
      thisGuy.removeChild(thisGuy.lastChild);
      thisGuy.append('ContactId DB Error');
    }
  }
  oReq.open("get", "php/snow-call/insert-contactId.php?timestamp=" + timestamp + "&contactId=" + contactId, true);
  oReq.send();
}
*/

function updateStatus(id, Call_Timestamp) {
  thisGuy = document.getElementById(id + 'a');
  j = 0;
  looking = setInterval(function() {
    if (j < 45) {
      j = j + 1;
      var oReq = new XMLHttpRequest();
      oReq.onload = function() {
        if (oReq.response == 0) {
          void(0);
        } else if (oReq.response == 1) {
          clearInterval(looking);
          thisGuy.removeChild(thisGuy.lastChild);
          thisGuy.append('Answered');
          setTimeout(function() {
            updateResponse(id, Call_Timestamp);
          }, 4000);
        } else {
          console.log('Status: ', oReq.response);
          clearInterval(looking);
          thisGuy.removeChild(thisGuy.lastChild);
          thisGuy.append('Status Error');
        }
      }
      oReq.open("get", "php/snow-call/check-status.php?Call_Timestamp=" + Call_Timestamp, true);
      oReq.send();
    } else {
      clearInterval(looking);
      thisGuy.removeChild(thisGuy.lastChild);
      thisGuy.append('No answer');
    }
  }, 2000);
}

function updateResponse(id, timestamp) {
  thisGuy = document.getElementById(id + 'a');
  k = 0;
  checking = setInterval(function() {
    if (k < 40) {
      k = k + 1;
      var oReq = new XMLHttpRequest();
      oReq.onload = function() {
        if (oReq.response == 0) {
          void(0);
        } else if (oReq.response == 9) {
          clearInterval(checking);
          thisGuy.removeChild(thisGuy.lastChild);
          thisGuy.append('Nah');
        } else if (oReq.response == 1) {
          clearInterval(checking);
          thisGuy.removeChild(thisGuy.lastChild);
          thisGuy.append('Fuck yeah!');
        } else if (oReq.response == 5) {
          clearInterval(checking);
          thisGuy.removeChild(thisGuy.lastChild);
          thisGuy.append('Did not respond');
        } else {
          clearInterval(checking);
          thisGuy.removeChild(thisGuy.lastChild);
          thisGuy.append('Response Error');
        }
      }
      oReq.open("get", "php/snow-call/check-response.php?Call_Timestamp=" + timestamp, false);
      oReq.send();
    } else {
      clearInterval(checking);
      thisGuy.removeChild(thisGuy.lastChild);
      thisGuy.append('Did not respond');
    }
  }, 2000);
}