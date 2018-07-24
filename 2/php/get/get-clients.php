<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM Clients ORDER BY Name";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo $row["Client_ID"]. "/" . $row["Name"]. "/" . $row["Address1"]. "/" . $row["Address2"]. "/" . $row["City"]. "/" . $row["State"]. "/" . $row["Zip"]. "/" . $row["phoneNum"]. "<newrecord>";
    }
  } else {
    echo '0 results';
  }
  $conn->close();
?>