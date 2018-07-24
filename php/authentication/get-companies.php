<?php
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '00-Main';

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT Company_ID, Company_Name FROM Companies WHERE Active = '1'";
  $result = $conn->query($sql);

  $companies_array = array();

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      array_push($companies_array, $row['Company_ID'], $row['Company_Name']);
    }
    echo json_encode($companies_array);
  } else {
      echo "0 results";
  }
  $conn->close();
?>