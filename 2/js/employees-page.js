employeeData = [];
allowNewClientSubmit = true;
dudesName = "";

$(document).ready(function() {
  document.getElementById('new-employee-form').reset();
  getEmployees();
  listEmployees();
  $('#new-employee, #this-employee, #confirmation').css('display', 'none');
})

// Pulls the employees from the database
function getEmployees() {
  employeeData = [];
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

// Sorts them alphabetically
function sortByKey(array, key) {
  array.sort(function(a, b) {
    var x = a[key].toLowerCase(); var y = b[key].toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
  });
}

// Draws them as a list on the left side of the page
function listEmployees() {
  sortByKey(employeeData, "f_name");
  for (i = 0; i < employeeData.length; i++) {
    $('#list-of-employees ul').append('<li class="individual-employees" id="' + employeeData[i].id + '" onclick="displayEmployee(' + employeeData[i].id + ')"><p>' + employeeData[i].f_name + ' ' + employeeData[i].l_name + '</p></li>');
  }
}

// Pulls the info and displays it for selected employee
function displayEmployee(id) {
  $('.selected-employee').removeClass('selected-employee');
  document.getElementById(id).className += " selected-employee";
  $('#boilerplate, #new-employee, #confirmation').css('display', 'none');
  $('#this-employee').empty().css('display', 'grid');
  $('#this-employee').append('<div id="employee-data-container"></div>');

  thisEmployee = employeeData.filter(function(obj) {
    return obj.id == id;
  });

  thisEmployee = thisEmployee[0];

  console.log(thisEmployee);
  dudesName = thisEmployee.f_name;

  $('#employee-data-container').append('<h2>' + dudesName + ' ' + thisEmployee.l_name + '</h2>');

  $('#this-employee').append('<div class="submit-button" id="delete-client" onclick="deleteEmployee(' + thisEmployee.id + ');"><h3>Delete</h3></div>');
  if (thisEmployee.phone1.length === 11) {
    formattedNumber = thisEmployee.phone1.toString().split("").splice(1);
    formattedNumber.splice(3, 0, '-');
    formattedNumber.splice(7, 0, '-');
    $('#employee-data-container').append('<br><h2>' + formattedNumber.join("") + '</h2>');
    /* Not yet...
    $('#this-employee').append('<div class="call-button" id="call-employee" onclick="callEmployee(' + thisEmployee.phone1 + ');"><h3>Call</h3></div>');
    */
  }
}

function addEmployeeWindow() {
  $('.selected-employee').removeClass('selected-employee');
  $('#boilerplate, #confirmation').css('display', 'none');
  $('#this-employee').empty().css('display', 'none');
  $('#new-employee').css('display', 'grid');
}

function submitNewEmployee() {
  if (allowNewClientSubmit === true) {
    allowNewClientSubmit = false;
    validateNewEmployeeData();
  } else {
    alert('You just submitted this one!');
  }
}

function validateNewEmployeeData() {
  fname = document.getElementsByName("fname")[0].value;
  lname = document.getElementsByName("lname")[0].value;
  phone0 = document.getElementsByName("phone0")[0].value;
  phone1 = document.getElementsByName("phone1")[0].value;
  phone2 = document.getElementsByName("phone2")[0].value;
  phone = "1" + phone0.toString() + phone1.toString() + phone2.toString();
  if (fname !== "" && lname !== "" && phone.length === 11) {
    if (phone.length !== 11) {
      alert('Not a valid phone number.');
      $('#loader-container').css('display', 'none');
      allowNewClientSubmit = true;
    } else {
      sendIt(fname, lname, phone);
    }
  } else {
    alert('Please make sure all information is filled in.');
    $('#loader-container').css('display', 'none');
    allowNewClientSubmit = true;
  }
}

function sendIt(fname, lname, phone) {
  $('#loader-container').css('display', 'block');
  var oReq = new XMLHttpRequest();
  oReq.open("get", "php/insert/insert-new-emp.php?fname=" + fname + "&lname=" + lname + "&phone=" + phone, false);
  oReq.send();
  getEmployees();
  $('#list-of-employees ul').empty();
  listEmployees();
  $('#new-employee').css('display', 'none');
  $('#confirmation').css('display', 'block');
  $('#loader-container').css('display', 'none');
  document.getElementById('new-employee-form').reset();
  allowNewClientSubmit = true;
}

function deleteEmployee(id) {
  result = window.confirm('Are you sure?');
    if (result === true) {
    $('#loader-container').css('display', 'block');
    var oReq = new XMLHttpRequest();
    oReq.open("get", "php/delete/delete-emp.php?id=" + id, false);
    oReq.send();
    getEmployees();
    $('#list-of-employees ul').empty();
    listEmployees();
    $('#this-employee').empty().css('display', 'none');
    $('#confirmation').css('display', 'block');
    $('#loader-container').css('display', 'none');
  }
}

function searchAndFilterEmployees() {
  var input, filter, ul, li, a;
  input = document.getElementById('search-employees-text-field');
  filter = input.value.toUpperCase();
  ul = document.getElementById('the-actual-list-of-employees');
  li = ul.getElementsByTagName('li');

  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("p")[0];
    if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
    } else {
        li[i].style.display = "none";
    }
  }
}