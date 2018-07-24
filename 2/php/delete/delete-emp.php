<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

  $id = $_GET['id'];
  
  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "DELETE FROM Employees WHERE Employee_ID = $id;";

  if ($conn->query($sql) === TRUE) {
    echo "Great Success";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>