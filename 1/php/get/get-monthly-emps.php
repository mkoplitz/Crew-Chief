<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = 'DB_' . $_SESSION['Company_ID'];

  $month = $_GET['month'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbdbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT empJobBridge.jobFK, Employees.ID, Employees.f_name, Employees.l_name, empJobBridge.day FROM Employees INNER JOIN empJobBridge ON Employees.ID = empJobBridge.emp_id WHERE month = $month";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo $row["jobFK"]. "/" . $row["ID"]. "/" . $row['f_name']. "/" . $row["l_name"]. "/" . $row['day']. "<newrecord>";
    }
  } else {
    echo "0 results";
  }
  $conn->close();
?>