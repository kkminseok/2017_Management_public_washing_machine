<!DOCTYPE html>

<?php
  $host = "localhost";
  $user = "root";
  $password = "autoset";
  $DB_name = "yoonshen";

  $mysql = mysqli_connect($host, $user, $password, $DB_name);
  if(mysqli_connect_errno($mysql))
  {
    echo "DB 접속 실패";
  }
 ?>
