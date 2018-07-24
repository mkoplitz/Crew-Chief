<?php
// date('Y-m-d H:i:s');

  $GLOBALS['servername'] = "localhost";
  $GLOBALS['dbusername'] = "authenticator";
  $GLOBALS['dbpassword'] = "authenticator";
  $GLOBALS['dbname'] = "02-Authentication";

// Stuff
  $username_entered = $_REQUEST['user'];
  $password_entered = $_REQUEST['pass'];

// IDENTIFY YOURSELF!
  $ip_address = $_SERVER['REMOTE_ADDR'];
  $OSName = $_REQUEST['OSName'];
  $OSVersion = $_REQUEST['OSVersion'];
  $cpuArchitecture = $_REQUEST['cpuArchitecture'];
  $browserName = $_REQUEST['browserName'];
  $browserVersion = $_REQUEST['browserVersion'];
  $deviceType = $_REQUEST['deviceType'];
  $deviceModel = $_REQUEST['deviceModel'];
  $deviceVendor = $_REQUEST['deviceVendor'];

// Connect to the database
  $GLOBALS['auth_connection'] = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if ($auth_connection->connect_error) {
    die("Connection failed: " . $auth_connection->connect_error);
  }

// Grab the info based on the username entered
  $sql_verify_user = "SELECT * FROM User_Credentials WHERE Username = '$username_entered'";
  $result_verify_user = $auth_connection->query($sql_verify_user);
  $auth_connection->close();

// If the username matches
  if ($result_verify_user->num_rows > 0) {
// Declare a shitload of variables based on that username
    while($row = $result_verify_user->fetch_assoc()) {
      $company_ID = $row['Company_ID'];
      $employee_ID = $row['Employee_ID'];
      $GLOBALS['first_name'] = $row['First_Name'];
      $GLOBALS['last_name'] = $row['Last_Name'];
      $access_level = $row['Access_Level'];
      $GLOBALS['failed_attempts'] = $row['Failed_Attempts'];
      $locked = $row['Locked'];
      $suspended = $row['Suspended'];
      $disabled = $row['Disabled'];
      $hashed_password = $row['Password'];
    }
// If any of these paramaters are flagged as true, call the correct function and tell the user to eat shit
    if ($disabled == 1) {
      accountDisabled();
      echo 'Sorry, your account has been disabled.';
    } else if ($suspended == 1) {
      accountSuspended();
      echo 'Sorry, your account is currently suspended.';
    } else if ($locked == 1) {
      accountLocked();
      echo 'Sorry, your account is currently locked.';
    } else if (password_verify($password_entered, $hashed_password) === FALSE) {
      failedPassword();
      echo 'Incorrect Username or Password';
// If username/password are good to go, start the session.
// Javascript redirects the user based on the access level echoed by this script
    } else if (password_verify($password_entered, $hashed_password)) {
      session_start();
      $_SESSION['Company_ID'] = $company_ID;
      $_SESSION['Employee_ID'] = $employee_ID;
      $_SESSION['First_Name'] = $first_name;
      $_SESSION['Last_Name'] = $last_name;
      $_SESSION['Access_Level'] = $access_level;
      $_SESSION['Time'] = time();
      successfulLogin();
      echo $access_level;
    }
  } else {
// If the username doesn't match
    epicFail();
    echo 'Incorrect Username or Password';
  }

// Log a successful login, and so on for the functions afterwards
  function successfulLogin() {
    global $servername, $dbusername, $dbpassword, $company_ID, $employee_ID, $first_name, $last_name, $ip_address, $OSName, $OSVersion, $cpuArchitecture, $browserName, $browserVersion, $deviceType, $deviceModel, $deviceVendor;

    $dbname = '05-Company_' . $company_ID;

    $auth_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    $sql_log_login = "INSERT INTO Logins (Employee_ID, First_Name, Last_Name, IP_Address, Browser_Name, Browser_Version, OS_Name, OS_Version, Device_Type, Device_Model, Device_Vendor, CPU_Architecture) VALUES ('$employee_ID', '$first_name', '$last_name', '$ip_address', '$browserName', '$browserVersion', '$OSName', '$OSVersion', '$deviceType', '$deviceModel', '$deviceVendor', '$cpuArchitecture')";

    $auth_connection->query($sql_log_login);
    $auth_connection->close();
  }

  function accountDisabled() {
    global $servername, $dbusername, $dbpassword, $dbname, $company_ID, $employee_ID, $username_entered, $password_entered, $ip_address, $OSName, $OSVersion, $cpuArchitecture, $browserName, $browserVersion, $deviceType, $deviceModel, $deviceVendor;

    $auth_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    $sql_log_disabled = "INSERT INTO Failed_Logins (Type, Company_ID, Employee_ID, Username_Entered, Password_Entered, IP_Address, Browser_Name, Browser_Version, OS_Name, OS_Version, Device_Type, Device_Model, Device_Vendor, CPU_Architecture) VALUES ('Disabled', '$company_ID', '$employee_ID', '$username_entered', '$password_entered', '$ip_address', '$browserName', '$browserVersion', '$OSName', '$OSVersion', '$deviceType', '$deviceModel', '$deviceVendor', '$cpuArchitecture')";

    $auth_connection->query($sql_log_disabled);
    $auth_connection->close();
  }

  function accountSuspended() {
    global $servername, $dbusername, $dbpassword, $dbname, $company_ID, $employee_ID, $username_entered, $password_entered, $ip_address, $OSName, $OSVersion, $cpuArchitecture, $browserName, $browserVersion, $deviceType, $deviceModel, $deviceVendor;

    $auth_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    $sql_log_suspended = "INSERT INTO Failed_Logins (Type, Company_ID, Employee_ID, Username_Entered, Password_Entered, IP_Address, Browser_Name, Browser_Version, OS_Name, OS_Version, Device_Type, Device_Model, Device_Vendor, CPU_Architecture) VALUES ('Suspended', '$company_ID', '$employee_ID', '$username_entered', '$password_entered', '$ip_address', '$browserName', '$browserVersion', '$OSName', '$OSVersion', '$deviceType', '$deviceModel', '$deviceVendor', '$cpuArchitecture')";

    $auth_connection->query($sql_log_suspended);
    $auth_connection->close();
  }

  function accountLocked() {
    global $servername, $dbusername, $dbpassword, $dbname, $company_ID, $employee_ID, $username_entered, $password_entered, $ip_address, $OSName, $OSVersion, $cpuArchitecture, $browserName, $browserVersion, $deviceType, $deviceModel, $deviceVendor;

    $auth_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    $sql_log_locked = "INSERT INTO Failed_Logins (Type, Company_ID, Employee_ID, Username_Entered, Password_Entered, IP_Address, Browser_Name, Browser_Version, OS_Name, OS_Version, Device_Type, Device_Model, Device_Vendor, CPU_Architecture) VALUES ('Locked', '$company_ID', '$employee_ID', '$username_entered', '$password_entered', '$ip_address', '$browserName', '$browserVersion', '$OSName', '$OSVersion', '$deviceType', '$deviceModel', '$deviceVendor', '$cpuArchitecture')";

    $auth_connection->query($sql_log_locked);
    $auth_connection->close();
  }

  function failedPassword() {
    global $servername, $dbusername, $dbpassword, $dbname, $company_ID, $employee_ID, $username_entered, $password_entered, $ip_address, $OSName, $OSVersion, $cpuArchitecture, $browserName, $browserVersion, $deviceType, $deviceModel, $deviceVendor, $failed_attempts;

    $auth_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    $sql_log_failed_password = "INSERT INTO Failed_Logins (Type, Company_ID, Employee_ID, Username_Entered, Password_Entered, IP_Address, Browser_Name, Browser_Version, OS_Name, OS_Version, Device_Type, Device_Model, Device_Vendor, CPU_Architecture) VALUES ('Password Failed', '$company_ID', '$employee_ID', '$username_entered', '$password_entered', '$ip_address', '$browserName', '$browserVersion', '$OSName', '$OSVersion', '$deviceType', '$deviceModel', '$deviceVendor', '$cpuArchitecture')";

    $incremented_failed_attempts = $failed_attempts + 1;

    $sql_increment_failed_attempts = "UPDATE User_Credentials SET Failed_Attempts = $incremented_failed_attempts WHERE Employee_ID = $employee_ID";

    $auth_connection->query($sql_log_failed_password);
    $auth_connection->query($sql_increment_failed_attempts);
    $auth_connection->close();

    if ($failed_attempts > 5) {
      lockTheAccount();
    }
  }

  function epicFail() {
    global $servername, $dbusername, $dbpassword, $dbname, $username_entered, $password_entered, $ip_address, $OSName, $OSVersion, $cpuArchitecture, $browserName, $browserVersion, $deviceType, $deviceModel, $deviceVendor;

    $auth_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    $sql_log_catastrophic_failure = "INSERT INTO Failed_Logins (Type, Username_Entered, Password_Entered, IP_Address, Browser_Name, Browser_Version, OS_Name, OS_Version, Device_Type, Device_Model, Device_Vendor, CPU_Architecture) VALUES ('Epic Fail', '$username_entered', '$password_entered', '$ip_address', '$browserName', '$browserVersion', '$OSName', '$OSVersion', '$deviceType', '$deviceModel', '$deviceVendor', '$cpuArchitecture')";

    $auth_connection->query($sql_log_catastrophic_failure);
    if ($auth_connection->connect_error) {
      die("Connection failed: " . $auth_connection->connect_error);
    }
    $auth_connection->close();
  }

// If the idiot at the keyboard can't get it right after six tries
  function lockTheAccount() {
    global $servername, $dbusername, $dbpassword, $dbname, $employee_ID;

    $auth_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    $sql_lock_the_account = "UPDATE User_Credentials SET Locked = 1 WHERE Employee_ID = $employee_ID";
    $auth_connection->query($sql_lock_the_account);
    $auth_connection->close();
  }
?>