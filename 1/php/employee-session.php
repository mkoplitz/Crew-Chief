<?php
  session_start();
  if(isSet($_SESSION['Access_Level']) && $_SESSION['Access_Level'] !== '1') {
    header('location: ../index.php');
    exit;
  }
?>