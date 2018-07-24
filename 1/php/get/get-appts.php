<?php
  session_start();
  $Employee_ID = $_SESSION['Employee_ID'];
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
    $Month = $_GET['Month'];
    $Year = $_GET['Year'];
    //$sql = "SELECT * FROM Jobs WHERE year=:year and month=:month";
    $sql = "SELECT * FROM Jobs INNER JOIN Emp_Job_Bridge ON Jobs.Job_ID = Emp_Job_Bridge.Job_ID WHERE Employee_ID = $Employee_ID AND Jobs.Month = $Month AND Jobs.Year = $Year";

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
    echo $Entry["Job_ID"] . "/" . $Entry["Client"] . "/" . $Entry["Job_Type"] . "/" . $Entry["JobStartTime"] . "/" . $Entry["JobEndTime"] . "/" . $Entry["Year"] . "/" . $Entry["Month"] . "/" . $Entry["Day"] . "/" . $Entry["Notes"] . "<newrecord>";
  }
?>