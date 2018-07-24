<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

  $fname = $_GET['fname'];
  $lname = $_GET['lname'];
  $phone = $_GET['phone'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO Employees (First_Name, Last_Name, Mobile_Phone)
  VALUES ('$fname', '$lname', '$phone')";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>