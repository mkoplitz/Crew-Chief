<?php
  session_start();
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = 'DB_' . $_SESSION['Company_ID'];

  $year = $_GET['year'];
  $month = $_GET['month'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbdbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT Emp_Job_Bridge.Job_ID, Employees.Employee_ID, Employees.First_Name, Employees.Last_Name FROM Employees INNER JOIN Emp_Job_Bridge ON Employees.Employee_ID = Emp_Job_Bridge.Employee_ID WHERE Year = '$year' && Month = '$month'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo $row["Job_ID"] . "/" . $row["Employee_ID"] . "/" . $row['First_Name'] . "/" . $row["Last_Name"] . "<newrecord>";
    }
  } else {
    echo "0 results";
  }
  $conn->close();
?>