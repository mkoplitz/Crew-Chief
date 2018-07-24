employeeData = [];
allowNewClientSubmit = true;
dudesName = "";

$(document).ready(function() {
  $('#new-employee, #this-employee, #confirmation').css('display', 'none');
  getEmployees();
  listEmployees();
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
  employeeList.open("get", "php/get-emps.php", false);
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

function displayEmployee(id) {
  $('.selected-employee').removeClass('selected-employee');
  document.getElementById(id).className += " selected-employee";
  $('#boilerplate, #new-employee, #confirmation').css('display', 'none');
  $('#this-employee').empty().css('display', 'grid');
  $('#this-employee').append('<div id="employee-data-container"></div>');

  thisEmployee = employeeData.filter(function(obj) {
    return obj.id == id;
  });

  console.log(thisEmployee);
  dudesName = thisEmployee[0].f_name;

  $('#employee-data-container').append('<h2>' + thisEmployee[0].f_name + ' ' + thisEmployee[0].l_name + '</h2>');

  $('#this-employee').append('<div class="submit-button" id="delete-client" onclick="deleteClient(' + thisEmployee[0].id + ');"><h3>Delete</h3></div>');
  if (thisEmployee[0].phone1.length !== 0) {
    $('#this-employee').append('<div class="call-button" id="call-employee" onclick="callEmployee(' + thisEmployee[0].phone1 + ');"><h3>Call</h3></div>');
  }
}

function addClientWindow() {
  $('.selected-employee').removeClass('selected-employee');
  $('#boilerplate, #confirmation').css('display', 'none');
  $('#this-employee').empty().css('display', 'none');
  $('#new-employee').css('display', 'grid');
}

function submitNewClient() {
  if (allowNewClientSubmit === true) {
    $('#loader-container').css('display', 'block');
    allowNewClientSubmit = false;
    parseNewClientData();
  } else {
    alert('You just submitted this one!');
  }
}

function parseNewClientData() {
  name = document.getElementsByName("name")[0].value;
  addr1 = document.getElementsByName("addr1")[0].value;
  addr2 = document.getElementsByName("addr2")[0].value;
  city = document.getElementsByName("city")[0].value;
  state = document.getElementsByName("state")[0].value;
  zip = document.getElementsByName("zip")[0].value;
  phone = document.getElementsByName("phone")[0].value;
  notes = document.getElementsByName("notes")[0].value;
  sendIt(name, addr1, addr2, city, state, zip, phone, notes);
}

function sendIt(name, addr1, addr2, city, state, zip, phone, notes) {
  var oReq = new XMLHttpRequest();
  oReq.open("get", "php/add-employees.php?name=" + name + "&addr1=" + addr1 + "&addr2=" + addr2 + "&city=" + city + "&state=" + state + "&zip=" + zip + "&phone=" + phone + "&notes=" + notes, false);
  oReq.send();
  getClients();
  $('#list-of-employees ul').empty();
  listClients();
  $('#new-employee').css('display', 'none');
  $('#confirmation').css('display', 'block');
  $('#loader-container').css('display', 'none');
  document.getElementById('new-employee-form').reset();
  allowNewClientSubmit = true;
}

function deleteClient(id) {
  result = window.confirm('Are you sure?');
    if (result === true) {
    $('#loader-container').css('display', 'block');
    var oReq = new XMLHttpRequest();
    oReq.open("get", "php/delete-clients.php?id=" + id, false);
    oReq.send();
    getClients();
    $('#list-of-employees ul').empty();
    listClients();
    $('#this-employee').empty().css('display', 'none');
    $('#confirmation').css('display', 'block');
    $('#loader-container').css('display', 'none');
  }
}

function searchAndFilterClients() {
  var input, filter, ul, li, a;
  input = document.getElementById('search-clients-text-field');
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

function callEmployee(phone1) {
  pretty = phone1.toString().split("").splice(1);
  pretty.splice(3, 0, '-');
  pretty.splice(7, 0, '-');
  confirm = confirm('Call ' + dudesName + ' at ' + pretty.join('') + '?');
  if (confirm === true) {
    var oReq = new XMLHttpRequest();
    oReq.onload = function() {
      result = (this.responseText);
      console.log(result);
    }
    oReq.open("get", "php/call-emps.php?phone1=" + phone1, true);
    oReq.send();
  }
}

function callEverybody() {
  numbersToCall = [];
  for (i = 0; i < employeeData.length; i++) {
    if (employeeData[i].phone1.length !== 0) {
      numbersToCall.push(employeeData[i].phone1);
    }
  }
  console.log(numbersToCall);
}