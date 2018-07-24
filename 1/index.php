<?php
  include('php/employee-session.php');
?>

<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/landing-page.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/clean-document.js"></script>
    <script src="../js/bowser.js"></script>
    <script src="../js/landing-page.js"></script>
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

    <h1 id="welcome" style="font-size: 3rem; text-align: center; color: white; margin-top: 20vh;">Welcome back,&nbsp;</h1>

  </body>
</html>