<?php
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '02-Authentication';

  $Current_Time = time();

  $Code_Entered = $_GET['Code_Entered'];
  $Company_ID_Received = $_GET['Company_ID_Received'];
  $Employee_ID_Received = $_GET['Employee_ID_Received'];
  $Unique_ID_Received = $_GET['Unique_ID_Received'];

  $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

  $check_code = "SELECT * FROM Reg_Codes_Sent WHERE Company_ID = $Company_ID_Received && Employee_ID = $Employee_ID_Received && Unique_ID = $Unique_ID_Received";

  $result = $conn->query($check_code);

  if (($result->num_rows > 0) === TRUE) {
    while($row = $result->fetch_assoc()) {
      $Code_Sent = $row['Code_Sent'];
      //echo 'Code Sent: ' . $Code_Sent;
    }

    if ($Current_Time - $Unique_ID_Received > 600) {
      // Code has expired after 10 minute timeout
      echo '9';
    } else {
      $sql = "UPDATE Reg_Codes_Sent SET Successful = 'True' WHERE Company_ID = '$Company_ID_Received' && Employee_ID = '$Employee_ID_Received' && Unique_ID = '$Unique_ID_Received'";
      if ($conn->query($sql) === TRUE) {
        echo '1';
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
      $conn->close();
    }
  } else {
    // Codes did not match
    $Response_Array = array('0', $Company_ID_Received, $Employee_ID_Received, $Unique_ID_Received);
    echo json_encode($Response_Array);
  }
  $conn->close();
?>