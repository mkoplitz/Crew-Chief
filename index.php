<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/landing-page.css">
    <script src="js/jquery.js"></script>
    <script src="js/clean-document.js"></script>
    <script src="js/bowser.js"></script>
    <script src="js/client.min.js"></script>
    <script src="js/authentication.js"></script>
		<title>Welcome</title>
  </head>
  
	<body>
    <div id="loader-container">
      <image id="loader" src="images/loader.svg"></image>
    </div>
    <div id="bg-image"></div>
    <div id="bg-curtain"></div>

    <div id="banner"></div>

    <div id="login-container">

      <!-- Login image and form -->
      <image class="login" src="images/sky.svg" id="logo"></image>
      <form class="login" id="form-verify-user">
        <input class="text" id="user" type="text" name="username-field" placeholder="Username" autofocus>
        <input class="text" id="pass" type="password" name="password-field" placeholder="Password">
        <div class="submit" id="login-button" onclick="logIn();">Log In</div>
      </form>
      <div class="login small-nav-button" id="register-button" onclick="loadRegistrationForm();">Register</div>

      <!-- Registration form -->
      <p class="registration" id="send-code-instructions">Select your company, then enter your first name, last name, and phone number.</p>
      <form class="registration" id="form-register-user">
        <select class="registration" id="select-company-dropdown"><option disabled>Select</option></select>
        <input class="text" id="fname" type="text" name="fname" placeholder="First Name">
        <input class="text" id="lname" type="text" name="lname" placeholder="Last Name">
        <div id="phone-fields">
          <input class="text" id="phone0" type="text" name="phone0" placeholder="123" maxlength="3" >
          <input class="text" id="phone1" type="text" name="phone1" placeholder="456" maxlength="3">
          <input class="text" id="phone2" type="text" name="phone2" placeholder="7890" maxlength="4">
        </div>
        <div class="submit" id="send-code-button" onclick="sendRegistrationCode();">Send Code</div>
      </form>
      <div class="registration small-nav-button" id="register-button" onclick="backToLanding();">Back</div>

      <!-- Enter the temporary code -->
      <p class="temp-code" id="enter-code-instructions">Please enter the code you received.</p>
      <form class="temp-code" id="form-temp-code">
        <input class="temp-code text" id="temp-code-field" type="text" name="code" maxlength="6">
        <div class="submit" id="enter-code-button" onclick="checkTempCode();">Submit</div>
      </form>
      <div class="temp-code small-nav-button" id="register-button" onclick="backToLanding();">Back</div>

      <!-- Create the login credentials -->
      <form class="create-login-creds" id="form-temp-code">
        <input class="create-login-creds text" id="new-user" type="text" name="new-user" placeholder="Username">
        <input class="create-login-creds text" id="new-pass" type="password" name="new-pass" placeholder="Password">
        <input class="create-login-creds text" id="new-pass-confirm" type="password" name="new-pass-confirm" placeholder="Confirm Password">
        <div class="submit" id="enter-code-button" onclick="submitRegistration();">Submit</div>
      </form>
      
    </div>

  </body>
</html>