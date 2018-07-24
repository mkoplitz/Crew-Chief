$(document).ready(function() {
  welcomeHome();
});

function welcomeHome() {
  var getName = new XMLHttpRequest();
  getName.onload = function() {
    $('#welcome').append(this.responseText);
  }
  getName.open("get", "../php/get/get-name.php", false);
  getName.send();
}