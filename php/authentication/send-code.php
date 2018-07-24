<?php
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = '05-Company' . $_GET['Company_ID'];

  $Company_ID = $_GET['Company_ID'];
  $First_Name = $_GET['First_Name'];
  $Last_Name = $_GET['Last_Name'];
  $Mobile_Phone = $_GET['Mobile_Phone'];
  $Unique_ID = (string)time();
  $Code_Base = sha1($First_Name . $Last_Name . $Unique_ID);
  $Code_to_Send = substr($Code_Base, -6);

  $conn_check_if_employee = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  $sql_check_if_employee = "SELECT * FROM Employees WHERE First_Name = '$First_Name' && Last_Name = '$Last_Name' && Mobile_Phone = '$Mobile_Phone'";

  $result = $conn_check_if_employee->query($sql_check_if_employee);

  while($row = $result->fetch_assoc()) {
    $Registered = $row['Registered'];
    $Employee_ID = $row['Employee_ID'];
    if ($Registered == '1') {
      echo json_encode(['3']);
    } else {
      // If this employee exists and is not yet registered, send the code and log it in the database
      if ($result->num_rows === 1) {
        $send_text = 'aws sns publish --subject "Temporary Code" --phone-number ' . $phone . ' --message "Your six digit code is: ' . $Code_to_Send . '. This code will expire in 10 minutes.';
        shell_exec($send_text);

        $conn_log_sent_code = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        $sql_log_sent_code = "INSERT INTO Reg_Codes_Sent (Unique_ID, Company_ID, Employee_ID, First_Name, Last_Name, Mobile_Phone, Code_Sent) VALUES ('$Unique_ID', '$Company_ID', '$Employee_ID', '$First_Name', '$Last_Name', '$Mobile_Phone', '$Code_to_Send')";

        $Response_Array = array('2', $Company_ID, $Employee_ID, $Unique_ID);

        if ($conn_log_sent_code->query($sql_log_sent_code) === TRUE) {
          echo json_encode($Response_Array);
        } else {
          echo json_encode(['1']);
        }
      $conn_log_sent_code->close();
      } else {
        // If the information entered does not match any employee on file
        echo json_encode(['0']);
      }
    $conn_check_if_employee->close();
    }
  }
?>