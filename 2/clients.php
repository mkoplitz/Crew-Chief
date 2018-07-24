<?php
  include('php/supervisor-session.php');
?>

<html>

	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/clients.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/clean-document.js"></script>
    <script src="../js/bowser.js"></script>
    <script src="js/clients-page.js"></script>
		<title>Clients</title>
  </head>

	<body>
    <div id="loader-container">
      <image id="loader" src="images/loader.svg"></image>
    </div>
    <div id="bg-image"></div>
    <div id="bg-curtain"></div>
    
    <?php
      include('php-includes/nav-bar.php');
    ?>

    <div id="clients-container"> <!-- Entire page below the navbar -->

      <div id="clients-list">

        <div id="add-client" onclick="addClientWindow();">
          <h3>Add a new client</h3>
        </div>

        <div id="search-clients">
          <input type="text" id="search-clients-text-field" onkeyup="searchAndFilterClients();" placeholder="Search">
        </div>

        <div id="list-of-clients">
          <ul id="the-actual-list-of-clients"></ul>
        </div>

      </div>

      <div class="content-container">
        <div class="content" id="boilerplate">
          <h1>Client Dashboard</h1><br>
          <h3>Basically, view and manage all clients of the company. Still very much a work in progress. Stuff that works right meow:<br><br>
            <ul>
              <li>Add/Delete clients</li>
              <li>View all clients in sidebar</li>
              <li>View detailed information on clients</li>
            </ul>
            <br>
            Scheduled for this week:<br><br>
            <ul>
              <li>Add ability to view notes on each client</li>
              <li>Ability to edit/update clients</li>
              <li>Build this page to work on mobile devices</li>
            </ul>
          </h3>
        </div>

        <div class="content" id="new-client">
          <h1 style="grid-area: 1 / 2 / span 1 / span 1;">Add a new client</h1>

          <form class="first" id="new-client-form">
            <h3>Name:</h3>
            <input type="text" name="name">
            <h3>Phone Number:</h3>
            <input type="text" name="phone">
            <h3>Address Line 1:</h3>
            <input type="text" name="addr1">
            <h3>Address Line 2:</h3>
            <input type="text" name="addr2">
          </form>

          <form class="second">
            <h3>City:</h3>
            <input type="text" name="city">
            <h3>State:</h3>
            <input type="text" name="state" style="width: 28px;">
            <h3>ZIP:</h3>
            <input type="text" name="zip" style="width: 52px;">
          </form>
          
          <form class="third">
            <h3>Notes:</h3>
            <textarea id="notes" name="notes"></textarea>
          </form>

          <div class="submit-button" id="new-client-button" onclick="submitNewClient();">
            <h3>Submit</h3>
          </div>
        </div> <!-- .content #new-client -->

        <div class="content" id="this-client">

        </div>

        <div class="content" id="confirmation">
          <h1>Great Success</h1>
        </div>

      </div> <!-- content-container -->
    </div> <!-- clients-container -->

  </body>
</html>