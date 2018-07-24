<?php
  session_start();
  try
  {
  $dsn= 'mysql:host=localhost; dbname=DB_' . $_SESSION['Company_ID'];
  $username='apache';
  $password= 'apache';
  $db= new PDO($dsn, $username, $password); // PDO object.
  }
  catch(PDOException $e)
  {
  $error_message=$e->getMessage();
  echo "<p>Error message: $error_message</p>";
  }
    global $db;
    $month = $_GET['m'];
    $year = $_GET['y'];
    $sql = "SELECT * FROM Jobs WHERE year=:year and month=:month";
    $result = $db->prepare($sql);
  try
  {
    $result->bindValue(':month',$month);
    $result->bindValue(':year',$year);
    $result->execute();
  }
  catch(PDOException $e)
  {
    $error_message=$e->getMessage();
    echo "<p>Failed message: $error_message</p>";
  }

  foreach ($result as $Entry) 
  {
    // Automaticly goes through the collection of results.
        echo $Entry["Job_ID"]. "/" . $Entry["Client"]. "/" . $Entry["Job_Type"]. "/" . $Entry["JobStartTime"]. "/" . $Entry["JobEndTime"]. "/" . $Entry["Year"]. "/" . $Entry["Month"]. "/" . $Entry["Day"]. "/" . $Entry["Notes"]. "<newrecord>";
  }
?>