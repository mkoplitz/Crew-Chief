<?php
  session_start();
  $servername = "localhost";
  $dbusername = "autodialer";
  $dbpassword = "autodialer";
  $dbname = '04-Calls';
  $Company_ID = $_SESSION['Company_ID'];

  $Employee_ID = $_GET['Employee_ID'];
  $Number_Dialed = $_GET['Number_Dialed'];
  $Call_Timestamp = $_GET['Call_Timestamp'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  logCallAttempt($Employee_ID, $Number_Dialed, $Call_Timestamp, $Company_Table, $conn);

  //

  function logCallAttempt($Employee_ID, $Number_Dialed, $Call_Timestamp, $Company_Table, $conn) {
    $sql = "INSERT INTO $Company_Table (Call_Timestamp, Employee_ID, Number_Dialed) VALUES ('$Call_Timestamp', '$Employee_ID', '$Number_Dialed')";

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query($sql) === TRUE) {
      makeCall($Number_Dialed, $Call_Timestamp, $Company_Table, $conn);
    } else {
      echo '0a';
      $conn->close();
    }
  }

  function makeCall($Number_Dialed, $Call_Timestamp, $Company_Table, $conn) {
    $command = 'aws connect start-outbound-voice-contact --contact-flow-id bff932ab-eb98-47a3-8b82-50e3db36b19f --instance-id 4a485781-4405-46df-83f2-8357bcc4ea8e --source-phone-number +19203280787 --destination-phone-number +' . $Number_Dialed . ' --attributes Call_Timestamp=' . $Call_Timestamp . ',table=Company_' . $Company_ID;

    $AWS_Response = shell_exec($command);

    $sql = "UPDATE $Company_Table SET AWS_Response = '$AWS_Response' WHERE Call_Timestamp = $Call_Timestamp";

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query($sql) === TRUE) {
      echo 'AWS_Response updated successfully';
    } else {
      echo '0b';
    }
    $conn->close();
  }
?>