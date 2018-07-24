<?php
  session_start();
  $servername = 'localhost';
  $dbusername = 'Employee_Clocker';
  $dbpassword = 'Employee_Clocker';
  $dbname = '04-Recorded_Time_' . $_SESSION['Company_ID'];
  $GLOBALS['Employee_ID'] = $_SESSION['Employee_ID'];

  $GLOBALS['clock_connection'] = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Get most recent shift punch
  $sql_last_punch = "SELECT * FROM Recorded_Hours WHERE Employee_ID = $Employee_ID ORDER BY Recorded_Hours_ID DESC LIMIT 1";

  $result_last_punch = $clock_connection->query($sql_last_punch);

// Punch codes:
// 1 = allow shift clock in
// 2 = allow shift clock out
// 3 = allow break/lunch clock in
// 4 = allow break clock out
// 5 = allow lunch clock out

  if ($result_last_punch->num_rows > 0) {
    while($row = $result_last_punch->fetch_assoc()) {
      $Recorded_Hours_ID = $row['Recorded_Hours_ID'];
      $Start_Time = $row['Start_Time'];
      $End_Time = $row['End_Time'];
      $_SESSION['Recorded_Hours_ID'] = $Recorded_Hours_ID;

      if ($End_Time === NULL) {
        checkBreakStatus();
        echo '2';
      } else {
        ?><h1>You can clock in</h1><?php;
      }
    }
  } else {
    echo '1';
  }

  function checkBreakStatus() {
    global $clock_connection, $Employee_ID;

    $sql_last_break = "SELECT * FROM Recorded_Breaks WHERE Employee_ID = $Employee_ID ORDER BY Start_Time DESC LIMIT 1";
    $result_last_break = $clock_connection->query($sql_last_break);
  
    if ($result_last_break->num_rows > 0) {
      while($row = $result_last_break->fetch_assoc()) {
        $Recorded_Break_ID = $row['Recorded_Break_ID'];
        $Break_Type = $row['Break_Type'];
        $Start_Time = $row['Start_Time'];
        $End_Time = $row['End_Time'];
        $_SESSION['Recorded_Break_ID'] = $Recorded_Break_ID;
      }
      if ($End_Time === NULL && $Break_Type === 'Break') {
        echo '4';
      } else if ($End_Time === NULL && $Break_Type === 'Lunch') {
        echo '5';
      } else {
        echo '3';
      }
    } else {
      echo '3';
    }
  }
?>