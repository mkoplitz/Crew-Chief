<?php
  include('php/employee-session.php');
?>

<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/clean-document.js"></script>
    <script src="../js/bowser.js"></script>
    <script src="js/employee-cal.js"></script>
		<title>Schedule Manager</title>
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

    <div id="day-editor-container">
      <div class="day-editor">
        <div class="day-editor-top" id="day-overview">
        </div>
        <div class="job-details-container"></div>
      </div>
    </div>

    <div id="add-job-container">
      <div id="add-job">
        <div class="day-editor-top" id="new-appt">
          <div class="exit" onclick="closeNewAppointmentWindow();">
            <image class="day-editor-button" src="../images/return.svg">
          </div>
          <div class="month-and-day"></div>
        </div>

        <div class="day-editor-main">

          <div id="client-dropdown">
            <h3>Client:</h3>
            <select class="dropdowns" name="client-dropdown"></select>
          </div>

          <div id="job-dropdown">
            <h3>Job Type:</h3>
            <select class="dropdowns" name="job-dropdown"></select>
          </div>
            
          <select class="dropdowns" name="start-time-dropdown" id="start-time-dropdown">
            <option disabled>Start Time</option>
          </select>
          <select class="dropdowns" name="end-time-dropdown" id="end-time-dropdown">
            <option disabled>End Time</option>
          </select>

          <div class="dropdowns" id="employee-container">
            <h3>Available</h3>
            <div multiple="multiple" id="employee-field"></div>
          </div>
          <div class="dropdowns" id="employee-insert-container">
            <h3>Selected</h3>
            <div multiple="multiple" id="employee-insert-field"></div>
          </div>

          <form class="dropdowns" id="initial-job-notes">
            <h3>Notes</h3>
            <textarea name="initial-job-notes" id="initial-job-notes-field" wrap="soft"></textarea>
          </form>

        </div>
        
      </div>
    </div>

    <div id="calendar-container">
      <div id="day-header-container">
        <div class="day-header">Sunday</div>
        <div class="day-header">Monday</div>
        <div class="day-header">Tuesday</div>
        <div class="day-header">Wednesday</div>
        <div class="day-header">Thursday</div>
        <div class="day-header">Friday</div>
        <div class="day-header">Saturday</div>
      </div>
		  <div id="calendar"></div>
    </div>
  </body>
</html>