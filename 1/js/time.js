$(document).ready(function() {
  if (document.getElementById('clock-in') !== null) {
    document.getElementById('clock-in').onclick = function() {
      logThePunch('clock', 'in');
    }
  }

  if (document.getElementById('clock-out') !== null) {
    document.getElementById('clock-out').onclick = function() {
      logThePunch('clock', 'out');
    }
  }

  if (document.getElementById('lunch-in') !== null) {
    document.getElementById('lunch-in').onclick = function() {
      logThePunch('lunch', 'in');
    }
  }

  if (document.getElementById('lunch-out') !== null) {
    document.getElementById('lunch-out').onclick = function() {
      logThePunch('lunch', 'out');
    }
  }

  if (document.getElementById('break-in') !== null) {
    document.getElementById('break-in').onclick = function() {
      logThePunch('break', 'in');
    }
  }

  if (document.getElementById('break-out') !== null) {
    document.getElementById('break-out').onclick = function() {
      logThePunch('break', 'out');
    }
  }

  function logThePunch(a, b) {
    var logPunch = new XMLHttpRequest();
    logPunch.onload = function() {
      console.log(this.responseText);
      //window.location.replace('time.php');
    }
    logPunch.open("post", "php/timeclock/enter_punch.php?a=" + a + "&b=" + b, false);
    logPunch.send();
  }
});