<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '06-Calls';

  $Company_Table = date('Y') . '_Company_' . $_SESSION['Company_ID'];

  $contactId = $_GET['contactId'];
  $timestamp = $_GET['timestamp'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "UPDATE $Company_Table SET AWS_Contact_ID = '$contactId' WHERE timestamp = $timestamp";

  if ($conn->query($sql) === TRUE) {
    echo "CID=1";
  } else {
    echo "CID=0";
  }
  $conn->close();
?>