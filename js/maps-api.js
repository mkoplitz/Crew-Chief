window.onload = function() {
  // Check to see if the browser supports the GeoLocation API.
  if (navigator.geolocation) {

  } else {
    // Print out a message to the user.
    console.log('Your browser does not support GeoLocation');
  }
}