<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = 'DB_' . $_SESSION['Company_ID'];

  $Job_ID = $_GET['id'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $Delete_Job = "DELETE FROM Jobs WHERE Job_ID = $Job_ID";
  $Delete_Job_Employee_Bridge = "DELETE FROM Emp_Job_Bridge WHERE JobID = $Job_ID";

  $conn->query($Delete_Job);
  $conn->close();
  $conn->query($Delete_Job_Employee_Bridge);
  $conn->close();
?>