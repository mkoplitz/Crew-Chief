<?php
  session_start();
  $servername = "localhost";
  $username = "apache";
  $password = "apache";
  $dbname = '05-Company_' . $_SESSION['Company_ID'];

  $name = $_GET['name'];
  $address1 = $_GET['addr1'];
  $address2 = $_GET['addr2'];
  $city = $_GET['city'];
  $state = $_GET['state'];
  $zip = $_GET['zip'];
  $phoneNum = $_GET['phone'];

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO Clients (Name, Address1, Address2, City, State, Zip, Phone_Number)
  VALUES ('$name', '$address1', '$address2', '$city', '$state', '$zip', '$phoneNum')";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>