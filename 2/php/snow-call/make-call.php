<?php
  session_start();
  $servername = "localhost";
  $dbusername = "autodialer";
  $dbpassword = "autodialer";
  $dbname = '06-Calls';

  $Company_Table = date('Y') . '_Company_' . $_SESSION['Company_ID'];

  $phone = $_GET['phone'];
  $timestamp = $_GET['timestamp'];

  $command = 'aws connect start-outbound-voice-contact --contact-flow-id bff932ab-eb98-47a3-8b82-50e3db36b19f --instance-id 4a485781-4405-46df-83f2-8357bcc4ea8e --source-phone-number +19203280787 --destination-phone-number +' . $phone . ' --attributes thisCall=' . $timestamp . ',table=' . $Company_Table;

  $contactId = shell_exec($command);

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "UPDATE $Company_Table SET AWS_Response = '$contactId' WHERE Call_Timestamp = $timestamp";

  if ($conn->query($sql) === TRUE) {
    echo "CID=1";
  } else {
    echo "CID=0";
  }
  $conn->close();
?>