<?php
  include('php/supervisor-session.php');
?>

<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/snow-call.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/clean-document.js"></script>
    <script src="../js/bowser.js"></script>
    <script src="js/snow-call.js"></script>
		<title>Snow Call</title>
  </head>
  
	<body>
    <div id="bg-image"></div>
    <div id="bg-curtain"></div>
    
    <?php
      include('php-includes/nav-bar.php');
    ?>
    
    <div id="snow-call-container">

      <div id="call-everybody">
        <image src="../images/siren.svg" onclick="callEverybody();"></image>
      </div>

      <div id="main">
        <div class="each-side" id="employees-on-the-left">
          <ul></ul>
        </div>
        <div class="each-side" id="status-on-the-right">
          <ul></ul>
        </div>
      </div>

    </div>
  </body>
</html>