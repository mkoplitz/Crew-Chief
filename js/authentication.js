$(document).ready(function() {
  getCompanies();
  $('.registration, .temp-code, .create-login-creds').css('display', 'none');
  document.getElementById('form-verify-user').reset();
  document.getElementById('form-temp-code').reset();

  client = new ClientJS();
  OSName = client.getBrowserData().os.name;
  OSVersion = client.getBrowserData().os.version;
  cpuArchitecture = client.getBrowserData().cpu.architecture;
  browserName = client.getBrowserData().browser.name;
  browserVersion = client.getBrowserData().browser.version;
  deviceType = client.getBrowserData().device.type;
  deviceModel = client.getBrowserData().device.model;
  deviceVendor = client.getBrowserData().device.vendor;
})

loggingIn = true;

// Allows the user to press 'Enter' at the login screen
document.onkeypress = function (e) {
  e = e || window.event;
  if (e.keyCode === 13 && loggingIn === true) {
    logIn();
  }
};

// Grabs the active companies from the database and builds the dropdown menu
function getCompanies() {
  var companyList = new XMLHttpRequest();
  companyList.onload = function() {
    companyRawData = JSON.parse(this.responseText);
    for (i = 0; i <= (companyRawData.length / 2); i += 2) {
      $('#select-company-dropdown').append('<option value="' + companyRawData[i] + '">' + companyRawData[i+1] + '</option>');
    }
  }
  companyList.open("get", "php/authentication/get-companies.php", true);
  companyList.send();
}

// Validates the credentials, then forwards the user based on Company_ID, Employee_ID and Access_Level
function logIn() {
  user = document.getElementsByName('username-field')[0].value;
  pass = document.getElementsByName('password-field')[0].value;

  var validate = new XMLHttpRequest();
  validate.onload = function() {
    result = this.responseText;
    if (result == 2) {
      window.location.assign('2/index.php');
    } else if (result == 1) {
      window.location.assign('1/index.php');
    } else {
      alert(this.responseText);
      document.getElementById('form-verify-user').reset();
    }
  }
  validate.open("post", "php/authentication/validate.php?user=" + user + "&pass=" + pass + "&OSName=" + OSName + "&OSVersion=" + OSVersion + "&cpuArchitecture=" + cpuArchitecture + "&browserName=" + browserName + "&browserVersion=" + browserVersion + "&deviceType=" + deviceType + "&deviceModel=" + deviceModel + "&deviceVendor=" + deviceVendor, true);
  validate.send();
}

// Registration Globals
Unique_ID_Received = 0;
Company_ID_Received = 0;
Employee_ID_Received = 0;
first_name = '';
last_name = '';
empID = 0;

function loadRegistrationForm() {
  loggingIn = false;
  $('.login').fadeOut(200);
  setTimeout(function() {
    $('.registration').fadeIn(200);
  }, 400);
}

function backToLanding() {
  loggingIn = true;
  $('.registration, .temp-code').fadeOut(200);
  setTimeout(function() {
    $('.login').fadeIn(200);
  }, 400);
}

function sendRegistrationCode() {
  Company_ID = document.getElementById('select-company-dropdown').value;
  fname = document.getElementsByName("fname")[0].value.toString();
  lname = document.getElementsByName("lname")[0].value.toString();
  phone0 = document.getElementsByName("phone0")[0].value;
  phone1 = document.getElementsByName("phone1")[0].value;
  phone2 = document.getElementsByName("phone2")[0].value;
  phone = "1" + phone0.toString() + phone1.toString() + phone2.toString();

  var sendCode = new XMLHttpRequest();
  sendCode.onload = function() {
    result = JSON.parse(this.responseText);
    console.log(result);
    if (result[0] == 2) {
      Company_ID_Received = parseInt(result[1]);
      Employee_ID_Received = parseInt(result[2]);
      Unique_ID_Received = parseInt(result[3]);
      loadTempCodeForm();
    } else if (result[0] == 1) {
      alert('Internal Server Error 500');
    } else if (result[0] == 3) {
      alert('You are already registered');
    } else {
      alert('Employee not found');
    }
  }
  sendCode.open("post", "php/authentication/send-code.php?Company_ID=" + Company_ID + "&First_Name=" + fname + "&Last_Name=" + lname + "&Mobile_Phone=" + phone, false);
  sendCode.send();
}

function loadTempCodeForm() {
  $('.registration').fadeOut(200);
  setTimeout(function() {
    $('.temp-code').fadeIn(200);
  }, 400);
}

function checkTempCode() {
  console.log(result);
  Code_Entered = document.getElementsByName("code")[0].value;
  console.log(Code_Entered, Company_ID_Received, Employee_ID_Received, Unique_ID_Received);

  var checkCode = new XMLHttpRequest();
  checkCode.onload = function() {
    response = this.responseText;
    console.log(response);
    if (response == 1) {
      loadCredentialsForm();
    } else if (response == 9) {
      alert('Your code expired, homeslice');
    } else {
      alert('Nah');
    }
  }
  checkCode.open("post", "php/authentication/check-code.php?Company_ID_Received=" + Company_ID_Received + "&Employee_ID_Received=" + Employee_ID_Received + "&Unique_ID_Received=" + Unique_ID_Received + "&Code_Entered=" + Code_Entered, false);
  checkCode.send();
}

function loadCredentialsForm() {
  $('.temp-code').fadeOut(200);
  setTimeout(function() {
    $('.create-login-creds').fadeIn(200);
  }, 400);
}

function submitRegistration() {
  newUsername = document.getElementsByName("new-user")[0].value.toString();
  newPassword = document.getElementsByName("new-pass")[0].value.toString();
  newPasswordConfirm = document.getElementsByName("new-pass-confirm")[0].value.toString();

  if (newPassword !== newPasswordConfirm) {
    alert('Passwords do not match');
  } else {
    $('#loader-container').css('display', 'block');
    var finishRegistration = new XMLHttpRequest();
    finishRegistration.onload = function() {
      console.log(this.responseText);
      $('#loader-container').css('display', 'none');
      window.location.assign('employee/index.php');
    }
    finishRegistration.open("post", "php/authentication/register.php?user=" + newUsername + "&pass=" + newPassword + "&fname=" + fname + "&lname=" + lname + "&Employee_ID=" + Employee_ID_Received + "&Company_ID=" + Company_ID_Received, true);
    finishRegistration.send();
  }
}