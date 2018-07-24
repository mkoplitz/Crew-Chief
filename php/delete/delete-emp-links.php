<?php
  $servername = "localhost";
  $username = "apache";
  $password = "apache";
  $dbname = "people";

  $id = $_GET['id'];

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "DELETE FROM empJobBridge WHERE jobFK=$id";
  
  $result = $conn->query($sql);
  $conn->close();
?>