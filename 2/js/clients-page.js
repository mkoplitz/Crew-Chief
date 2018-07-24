clientData = [];
allowNewClientSubmit = true;

$(document).ready(function() {
  $('#new-client, #this-client, #confirmation').css('display', 'none');
  getClients();
  listClients();
})

// Pulls the clients from the database
function getClients() {
  clientData = [];
  var clientList = new XMLHttpRequest();
  clientList.onload = function() {
    rawClientData = (this.responseText).split("<newrecord>");
    for (i = 0; i < rawClientData.length - 1; i++) {
      each = rawClientData[i].split("/");
      clientData.push({
        id: each[0],
        name: each[1],
        addr1: each[2],
        addr2: each[3],
        city: each[4],
        state: each[5],
        zip: each[6],
        phoneNum: each[7]
      });
    }
  }
  clientList.open("get", "php/get/get-clients.php", false);
  clientList.send();
}

// Draws them on the page
function listClients() {
  for (i = 0; i < clientData.length; i++) {
    $('#list-of-clients ul').append('<li class="individual-clients" id="' + clientData[i].id + '" onclick="displayClient(' + clientData[i].id + ')"><p>' + clientData[i].name + '</p></li>');
  }
}

function displayClient(id) {
  $('.selected-client').removeClass('selected-client');
  document.getElementById(id).className += " selected-client";
  $('#boilerplate, #new-client, #confirmation').css('display', 'none');
  $('#this-client').empty().css('display', 'grid');
  $('#this-client').append('<div id="client-data-container"></div>');

  thisClient = clientData.filter(function(obj) {
    return obj.id == id;
  });

  $('#client-data-container').append('<h2>' + thisClient[0].name + '</h2>');
  $('#client-data-container').append('<h2>' + thisClient[0].phoneNum + '</h2><br>');
  $('#client-data-container').append('<h2>' + thisClient[0].addr1 + '</h2>');
  $('#client-data-container').append('<h2>' + thisClient[0].addr2 + '</h2>');
  $('#client-data-container').append('<h2>' + thisClient[0].city + ', ' + thisClient[0].state + ' ' + thisClient[0].zip + '</h2><br>');

  $('#this-client').append('<div class="submit-button" id="delete-client" onclick="deleteClient(' + thisClient[0].id + ');"><h3>Delete</h3></div>');
}

function addClientWindow() {
  $('.selected-client').removeClass('selected-client');
  $('#boilerplate, #confirmation').css('display', 'none');
  $('#this-client').empty().css('display', 'none');
  $('#new-client').css('display', 'grid');
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
  oReq.open("get", "php/insert/insert-new-client.php?name=" + name + "&addr1=" + addr1 + "&addr2=" + addr2 + "&city=" + city + "&state=" + state + "&zip=" + zip + "&phone=" + phone + "&notes=" + notes, false);
  oReq.send();
  getClients();
  $('#list-of-clients ul').empty();
  listClients();
  $('#new-client').css('display', 'none');
  $('#confirmation').css('display', 'block');
  $('#loader-container').css('display', 'none');
  document.getElementById('new-client-form').reset();
  allowNewClientSubmit = true;
}

function deleteClient(id) {
  result = window.confirm('Are you sure?');
    if (result === true) {
    $('#loader-container').css('display', 'block');
    var oReq = new XMLHttpRequest();
    oReq.open("get", "php/delete/delete-client.php?id=" + id, false);
    oReq.send();
    getClients();
    $('#list-of-clients ul').empty();
    listClients();
    $('#this-client').empty().css('display', 'none');
    $('#confirmation').css('display', 'block');
    $('#loader-container').css('display', 'none');
  }
}

function searchAndFilterClients() {
  var input, filter, ul, li, a;
  input = document.getElementById('search-clients-text-field');
  filter = input.value.toUpperCase();
  ul = document.getElementById('the-actual-list-of-clients');
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