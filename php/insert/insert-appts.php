<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

  $Job_ID = $_GET['Job_ID'];
  $Client = $_GET['Client'];
  $Job_Type = $_GET['Job_Type'];
  $jobStartTime = $_GET['jobStartTime'];
  $jobEndTime = $_GET['jobEndTime'];
  $y = $_GET['y'];
  $m = $_GET['m'];
  $d = $_GET['d'];
  $notes = $_GET['notes'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO Jobs (Job_ID, Client, Job_Type, JobStartTime, JobEndTime, Year, Month, Day, Notes) VALUES ('$Job_ID', '$Client', '$Job_Type', '$jobStartTime', '$jobEndTime', '$y', '$m', '$d', '$notes')";

  if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
?>