<?php
  include('php/employee-session.php');
?>

<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/landing-page.css">
    <link rel="stylesheet" type="text/css" href="css/timeclock.css">
    <script src="../js/clean-document.js"></script>
    <script src="../js/bowser.js"></script>
    <script src="../js/landing-page.js"></script>
    <script src="js/time.js"></script>
    <title>Home</title>
  </head>

  <body>
    <div id="loader-container">
      <image id="loader" src="../images/loader.svg"></image>
    </div>
    <div id="bg-image"></div>
    <div id="bg-curtain"></div>
    
<?php
  include('php-includes/nav-bar.php');
?>

<?php
  include('php-includes/generate-buttons.php');
?>
<!--
    <h1 id="welcome" style="font-size: 3rem; text-align: center; color: white; margin-top: 20vh;">Time clock</h1>

    <div>
      <h1 id="welcome" style="font-size: 3rem; text-align: center; color: white; margin-top: 20vh;">Submit</h1>
    </div>
-->
  </body>
</html>