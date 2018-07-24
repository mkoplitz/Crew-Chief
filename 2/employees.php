<?php
  include('php/supervisor-session.php');
?>

<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/employees.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/clean-document.js"></script>
    <script src="../js/bowser.js"></script>
    <script src="js/employees-page.js"></script>
		<title>Employees</title>
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

    <div id="employees-container"> <!-- Entire page below the navbar -->

      <div id="employees-list">

        <div id="add-employee" onclick="addEmployeeWindow();">
          <h3>Add an employee</h3>
        </div>

        <div id="search-employees">
          <input type="text" id="search-employees-text-field" onkeyup="searchAndFilterEmployees();" placeholder="Search">
        </div>

        <div id="list-of-employees">
          <ul id="the-actual-list-of-employees"></ul>
        </div>

      </div>

      <div class="content-container">
        <div class="content" id="boilerplate">
          <h1>Employee Dashboard</h1><br>
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

        <div class="content" id="new-employee">
          <h1 style="grid-area: 1 / 2 / span 1 / span 1;">Add an employee</h1>

          <form class="first" id="new-employee-form">
            <input type="text" name="fname" placeholder="First Name">
            <input type="text" name="lname" placeholder="Last Name">
            <input type="text" name="phone0" id="phone0" maxlength="3" placeholder="123">
            <input type="text" name="phone1" id="phone1" maxlength="3" placeholder="456">
            <input type="text" name="phone2" id="phone2" maxlength="4" placeholder="7890">
          </form>

          <div class="submit-button" id="new-employee-button" onclick="submitNewEmployee();">
            <h3>Submit</h3>
          </div>
        </div> <!-- .content #new-employee -->

        <div class="content" id="this-employee"></div>

        <div class="content" id="confirmation">
          <h1>Great Success</h1>
        </div>

      </div> <!-- content-container -->
    </div> <!-- clients-container -->
  </body>
</html>