$(document).ready(function() {
  clean(document);
  $('#drop-nav').css('display' ,'none');
  $('#burger-button').css('filter', 'invert(100%)');
});

function clean(node) {
  for(var n = 0; n < node.childNodes.length; n ++) {
    var child = node.childNodes[n];
    if (child.nodeType === 8 || (child.nodeType === 3 && !/\S/.test(child.nodeValue))) {
      node.removeChild(child);
      n --;
    } else if(child.nodeType === 1) {
      clean(child);
    }
  }
}

usingMobile = false;

function mobileNavBar() {
  if (usingMobile === false) {
    usingMobile = true;
    $('#drop-nav').css('display', 'block');
    $('#burger-button').css('filter', 'invert(60%)');
  } else {
    usingMobile = false;
    $('#drop-nav').css('display', 'none');
    $('#burger-button').css('filter', 'invert(100%)');
  }
}

function logOff() {
  var logThemOff = new XMLHttpRequest();
  logThemOff.onload = function() {
    window.location.assign('../index.php');
  }
  logThemOff.open("post", "../php/authentication/log-off.php", true);
  logThemOff.send();
}