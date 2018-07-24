<?php
  session_start();
  $servername = "localhost";
  $username = "apache";
  $password = "apache";
  $dbname = "02-Authentication";

  $token = $_SESSION['token'];
  $unix_time = time();
  $time = date('Y-m-d H:i:s', $unix_time);

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "UPDATE logins SET `Logged Out` = '$time' WHERE token = '$token'";

  if ($conn->query($sql) === TRUE) {
    setcookie('Authentication', '', time() - 3600);
    $_SESSION = array();
    session_destroy();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>