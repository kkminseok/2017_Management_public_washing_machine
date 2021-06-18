<?
  $state = $_GET['state'];
  $id = $_GET['id'];
  $no = $_GET['no'];
  //update yoonshen.wm SET state = 3 where idx = 11;
  include("./dbconnect.php");
  //$sql = "INSERT INTO wm (no, id, state, starttime, endtime) VALUES ('$no', '$id', '$state', now(),now()+INTERVAL 30 MINUTE)";
  $sql = "DELETE FROM wm WHERE no = '$no'";
  $mysql->query($sql);
  $sql = "INSERT INTO wm (no, id, state, starttime, endtime) VALUES ('$no', '$id', '$state', now(),now()+INTERVAL 1 MINUTE)";
  if($mysql->query($sql) ===TRUE)
  {
    echo"<script>alert(\"db입력성공\"); </script>";
    mysqli_close($mysql);
    echo "<script> document.location.href = 'test.php'</script>";
  }
  else
  {
    echo"<script>alert(\"db입력실패\"); </script>";
    mysqli_close($mysql);
    echo "<script> document.location.href = 'http://www.google.com'</script>";
  }

?>
