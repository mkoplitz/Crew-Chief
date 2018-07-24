<?php
  $servername = "localhost";
  $dbusername = "apache";
  $dbpassword = "apache";
  $dbname = "02-Authentication";
  
  $Username = $_GET['user'];
  $Password = $_GET['pass'];
  $First_Name = $_GET['fname'];
  $Last_Name = $_GET['lname'];
  $Employee_ID = $_GET['Employee_ID'];
  $Company_ID = $_GET['Company_ID'];

  $Hashed_Password = password_hash($Password, PASSWORD_BCRYPT, array("cost" => 18));

  // Add user's credentials to the Authentication database
  $conn_add_credentials = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if ($conn_add_credentials->connect_error) {
    die("Connection failed: " . $conn_add_credentials->connect_error);
  }

  $add_credentials = "INSERT INTO User_Credentials (Company_ID, Employee_ID, First_Name, Last_Name, Access, Username, Password) VALUES ('$Company_ID', '$Employee_ID', '$First_Name', '$Last_Name', '1', '$Username', '$Hashed_Password')";
  if ($conn_add_credentials->query($add_credentials) === TRUE) {
    echo '1';
  } else {
    echo "Error: " . $add_credentials . "<br>" . $conn_add_credentials->error;
  }
  $conn_add_credentials->close();


  // Update the employee's record to reflect that they are registered
  $Company_DB = 'DB_' . $Company_ID;
  $conn_update_employee_table = new mysqli($servername, $dbusername, $dbpassword, $Company_DB);
  if ($conn_update_employee_table->connect_error) {
    die("Connection failed: " . $conn_update_employee_table->connect_error);
  }

  $update_employee_table = "UPDATE Employees SET Registered = '1' WHERE Employee_ID = $Employee_ID";
  if ($conn_update_employee_table->query($update_employee_table) === TRUE) {
    echo '1';
  } else {
    echo "Error: " . $update_employee_table . "<br>" . $conn->error;
  }
  $conn_update_employee_table->close();
?>