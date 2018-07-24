<?php
  session_start();
  $servername = "localhost";
  $dbusername = "autodialer";
  $dbpassword = "autodialer";
  $dbname = '04-Calls';

  $Company_Table = 'Company_' . $_SESSION['Company_ID'];

  $Call_Timestamp = $_GET['Call_Timestamp'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  $sql = "SELECT * FROM $Company_Table WHERE Call_Timestamp == $Call_Timestamp";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo $row['Employee_Response'];
    }
  } else {
    echo "0 results";
  }

  $conn->close();
?>
