<?php
  session_start();
  $servername = "localhost";
  $username = "apache";
  $password = "apache";
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

  $token = $_SESSION['token'];
  $unix_time = time();
  $unix_time_formatted = date('Y-m-d H:i:s', $unix_time);
  $last_activity = $_SESSION['Time'];

  if (isSet($_SESSION['Access_Level']) && $_SESSION['Access_Level'] == 2) {
    if ($unix_time - $last_activity < 1200) {
      $_SESSION['time'] = $unix_time;
    } else {
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $sql = "UPDATE logins SET loggedOut = '$unix_time_formatted' WHERE token = '$token'";
      if ($conn->query($sql) === TRUE) {
        setcookie('Authentication', '', time() - 3600);
        $_SESSION = array();
        session_destroy();
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
      $conn->close();
      session_unset();
      session_destroy();
      setcookie('Authentication', '', time() - (7200), "/");
      header('Location: ../index.php');
    }
  } else {
    session_unset();
    session_destroy();
    setcookie('Authentication', '', time() - (7200), "/");
    header('Location: ../index.php');
  }
?>