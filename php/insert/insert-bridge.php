<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

  $Job_ID = $_GET['Job_ID'];
  $Employee_ID = $_GET['Employee_ID'];
  $Client = $_GET['Client'];
  $Job_Type = $_GET['Job_Type'];
  $year = $_GET['y'];
  $month = $_GET['m'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO Emp_Job_Bridge (Job_ID, Employee_ID, Year, Month) VALUES ('$Job_ID', '$Employee_ID', '$year', '$month')";

  if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
?>