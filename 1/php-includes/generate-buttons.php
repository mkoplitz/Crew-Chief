<?php
  $servername = 'localhost';
  $dbusername = 'apache';
  $dbpassword = 'apache';
  $dbname = '05-Company_' . $_SESSION['Company_ID'];
  $GLOBALS['Employee_ID'] = $_SESSION['Employee_ID'];

  $GLOBALS['clock_connection'] = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Get most recent shift punch
  $sql_last_punch = "SELECT * FROM Recorded_Hours WHERE Employee_ID = $Employee_ID ORDER BY Start_Time DESC LIMIT 1";

  $result_last_punch = $clock_connection->query($sql_last_punch);

  if ($result_last_punch->num_rows > 0) {
    while($row = $result_last_punch->fetch_assoc()) {
      $Recorded_Hours_ID = $row['Recorded_Hours_ID'];
      $Start_Time = $row['Start_Time'];
      $End_Time = $row['End_Time'];
      $_SESSION['Recorded_Hours_ID'] = $Recorded_Hours_ID;

      if ($End_Time === NULL) {
// If clocked in for the shift
        checkBreakStatus();
      } else {
// Show button to clock in for the shift
        echo "<div class='punch-button' id='clock-in'>Punch the fuck in</div>";
      }
    }
  } else {
// Show button to clock in for the shift
    echo "<div class='punch-button' id='clock-in'>Punch the fuck in</div>";
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
      }

      if ($End_Time === NULL && $Break_Type === 'Break') {
// If they're on break, display button to clock back in from break
        echo "<div class='punch-button' id='break-in'>Clock in from break</div>";
      } else if ($End_Time === NULL && $Break_Type === 'Lunch') {
// If they're on lunch, display button to clock back in from lunch
        echo "<div class='punch-button' id='lunch-in'>Clock in from lunch</div>";
      } else {
// If they're not on lunch or break, give them the option to do all three items.
        echo "<div class='punch-button' id='lunch-out'>Take a lunch</div><br>
              <div class='punch-button' id='break-out'>Take a break</div>
              <div class='punch-button' id='clock-out'>Clock out for the day</div>";
      }
    } else {
// If there's no record of a break and they're clocked in:
      echo "<div class='punch-button' id='lunch-out'>Take a lunch</div>
            <div class='punch-button' id='break-out'>Take a break</div>
            <div class='punch-button' id='clock-out'>Clock out for the day</div>";
    }
  }
?>