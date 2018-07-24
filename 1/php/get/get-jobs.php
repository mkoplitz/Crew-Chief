<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = 'DB_' . $_SESSION['Company_ID'];

  $id = $_GET['id'];
  $jobType = $_GET['jobType'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM jobTypes";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo $row["ID"]. "/" . $row["JobType"].  "<newrecord>";
      }
  } else {
      echo "0 results";
  }
  $conn->close();
?>