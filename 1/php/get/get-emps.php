<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = 'DB_' . $_SESSION['Company_ID'];

  $ID = $_GET['ID'];
  $f_name = $_GET['f_name'];
  $l_name = $_GET['l_name'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT Employee_ID, First_Name, Last_Name, Mobile_Phone FROM Employees";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo $row["Employee_ID"] . "/" . $row["First_Name"] . "/" . $row['Last_Name'] . "/" . $row['Mobile_Phone'] . "<newrecord>";
      }
  } else {
      echo "0 results";
  }
  $conn->close();
?>