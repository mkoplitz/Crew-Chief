<?php
  session_start();
  $servername = 'localhost';
  $dbusername = 'apache';
  $dbpassword = 'apache';
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

// Variables make the world go round
  $GLOBALS['clock_connection'] = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  $now = date('m/d/Y h:i:s a', time());
  $Employee_ID = $_SESSION['Employee_ID'];
  $Punch_Type = $_REQUEST['a'];
  $In_Out = $_REQUEST['b'];

// Get the ID of the last clock punch
  /*
  $sql_last_punch = "SELECT Recorded_Hours_ID FROM `Recorded_Hours` WHERE `Employee_ID` = '$Employee_ID' ORDER BY `Recorded_Hours_ID` DESC LIMIT 1;";
  $result_clock = $clock_connection->query($sql_last_punch);

  while($row = $result_clock->fetch_assoc()) {
    $Recorded_Hours_ID = $row['Recorded_Hours_ID'];
    echo $Recorded_Hours_ID;
  }
*/
// Get the ID of the last break punch
  $sql_last_break = "SELECT Recorded_Break_ID FROM `Recorded_Breaks` WHERE `Employee_ID` = '$Employee_ID' ORDER BY `Recorded_Break_ID` DESC LIMIT 1;";
  $result_break = $clock_connection->query($sql_last_break);

  while($row = $result_break->fetch_assoc()) {
    $Recorded_Break_ID = $row['Recorded_Break_ID'];
    echo $Recorded_Break_ID;
  }

// Run the query based on the type of punch
  if ($Punch_Type === 'clock') {
    if ($In_Out === 'in') {
      $sql_clock = "INSERT INTO `Recorded_Hours` (Employee_ID) VALUES ('$Employee_ID')";
      $clock_connection->query($sql_clock);
    } else {
      $sql_clock = "UPDATE `Recorded_Hours` SET End_Time = '$now' WHERE Employee_ID = '$Employee_ID' && Recorded_Hours_ID = '$Recorded_Hours_ID';";
      $clock_connection->query($sql_clock);
    }
  } else if ($Punch_Type === 'lunch' || $Punch_Type === 'break') {
    if ($In_Out === 'out') {
      $sql_break = "INSERT INTO `Recorded_Breaks` (Employee_ID, Break_Type) VALUES ('$Employee_ID', '$Punch_Type')";
      $clock_connection->query($sql_break);
    } else {
      $sql_break = "UPDATE `Recorded_Breaks` SET End_Time = $now WHERE Employee_ID = $Employee_ID && Recorded_Break_ID = $Recorded_Break_ID; WHERE Recorded_Break_ID = '$Recorded_Break_ID';";
      $clock_connection->query($sql_break);
    }
  } else {
    echo 'Something broke';
  }
  $clock_connection->close();
?>