<?


  include("./dbconnect.php");
  //1. 세탁기 no 와 state 쌍으로 그냥 다가져와
  $sqlnow="SELECT state,no from kms_vm ORDER BY  'no' ASC ";
  $resultnow = mysqli_query($mysql,$sqlnow);
  $nowstate=array();
  $nowno=array();
  while($row=mysqli_fetch_array($resultnow))
  {
       $nowno[]= $row['no'];
    $nowstate[]= $row['state'];



  }
    print_r($nowno);
  print_r($nowstate);




  //$test = $_SESSION['id'];
  //$sql = "SELECT * FROM kms_vm where id='$test'";
  //$result = mysqli_query($mysql,$sql);
  $nolist = array();
  //while($row = mysqli_fetch_array($result)){
  //  array_push($nolist,$row['no']);
//  }

  //2. prevstate 랑 전체를 다가져와서 비교를해
  $sql="SELECT state,vm_no from kms_prevstate ORDER BY 'no' ASC" ;
  $result = mysqli_query($mysql,$sql);
  $prestate=array();
  $preno=array();
  while($row=mysqli_fetch_array($result))
  {
       $preno[]= $row['vm_no'];
    $prestate[]= $row['state'];



  }
  //print_r($preno);
  //print_r($prestate);
  $idlist=array();
  $tokenlist=array();

  for($i=0;$i<3;$i++)
  {
    if($prestate[$i]!=$nowstate[$i])
    {
          //echo $i;

        $sql= "SELECT id FROM kms_vm where no=".($i+1);
        $result = mysqli_query($mysql,$sql);
        while($row=mysqli_fetch_array($result))
              {
                   $idlist[]= $row['id'];
                   //echo $row['id'];
                   $sql2="SELECT cpassword FROM kms_users where id= '".$row['id']."'";
                   $result2=mysqli_query($mysql,$sql2);
                   //echo $sql2."<Br>";
                   while($row2=mysqli_fetch_array($result2))
                   {
                     $tokenlist[]=$row2['cpassword'];
                    // echo $tokenlist[0];
                    $sqlsert="INSERT INTO kms_fcm(TOKEN) values("."'".$tokenlist[0]."'".")";
                     $resultsert=mysqli_query($mysql,$sqlsert);
                     $sqlsert="INSERT INTO kms_fcm(TOKEN) values("."'".$tokenlist[1]."'".")";
                      $resultsert=mysqli_query($mysql,$sqlsert);
                  //  echo$sqlsert;
                //    echo $prestate[0];
                    $sqlstate="INSERT INTO kms_fcm(state) values("."'".$prestate[0]."'".")";
                    $resultstate=mysqli_query($mysql,$sqlstate);
                    //echo $prestate[$i];
                     echo "<script>location.href='push_notification.php'</script>";
                    //  echo "<script>alert(\"푸시보낸다\");</script>";

                      //    $test = $_SESSION['token'];

                        //  echo "<script>alert('$test');</script>";
                  //  echo $row2['cpassword'];
                    //-----------------------------------------------------알람 코드
                  //  echo "</br>";
                    //echo json_encode($row2);


                    //알람후 db변경 코드
                    $sqlup3="UPDATE kms_prevstate SET state=".$nowstate[$i]." WHERE vm_no=".($i+1);
                    $resultup3=mysqli_query($mysql,$sqlup3);


                  //  $sqldelete="DELETE FROM kms_fcm WHERE id>3";
                  //  $resultdele=mysqli_query($mysql,$sqldelete);






                   }


              }


              //$test = $_SESSION['token'];

      //echo "<script>alert('$test');</script>";
      //echo "<script>location.href='push_notification.php'</script>";






    }

  }

//    print_r($tokenlist);


  foreach ($nolist as &$value) {

    //prev db 항상 갱신이 되는거
    $sql = "SELECT state FROM kms_prevstate where vm_no=".$value;
    $result = mysqli_query($mysql,$sql);
    $row = mysqli_fetch_array($result);
    $prev = $row['state'];
    //echo $prev;

    $sql = "SELECT *, IF( now() BETWEEN starttime AND endtime , '1','2') as test FROM kms_vm where no =".$value;
    $result = mysqli_query($mysql,$sql);
    $row = mysqli_fetch_array($result);
    $now = $row['state'];





?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
    <script language="javascript">
  //  window.setTimeout("phj()",5000); //60초마다 리플리쉬 시킨다 1000이 1초가 된다.
    function phj(){

      window.location.reload();
    }
    </script>
    <title>test</title>
</head>
<body style="width:80%;margin-left:auto;margin-right: auto">



    <div id="root">

        <!-- Modal Trigger -->
        <!-- Modal Structure -->

        <div id="modal1" class="modal">
          <div class="modal-content">
            <h4>변경완료</h4>
            <p>알림이 변경되었습니다.</p>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">확인</a>
          </div>
        </div>

        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo center">세탁소관리</a>
            </div>
        </nav>
        <?
        $cnt=1;
        while($row = mysqli_fetch_array($result)){
          if ( $row['state'] == '3')
          {
            $row['test'] = 3;
            $row['starttime'] = "available";
            $row['endtime'] = "available";
          }

        echo '<div class="row">';
          echo '<div class="col s12 m12">';
            echo '<div class="card  horizontal blue-grey darken-1">';
              echo '<div class="card-image modaltest">';
                echo'<img src="./'.$row['test'].'.png" style="width:200px" >';
              echo '</div>';
                //echo '  <div class="progress"><div class="indeterminate"></div></div>';
              echo '<div class="card-stacked">';
                  echo '<div class="card-content white-text">';
                    echo '<span class="card-title">NO : '.$row['no'].'</span>';
                    echo '<p style="color:#ffab40;">NFC ID : '.$row['id'].'</p>';
                    echo '<p style="color:#ffab40;">STATE  : '.$row['test'].'</p>';

                    $sqlup="UPDATE kms_vm SET state=".$row['test']." where no =".$cnt;
                    $resultup=mysqli_query($mysql,$sqlup);

                    $cnt+=1;



                    echo '<p >START TIME　: '.$row['starttime'].'</p>';
                    echo '<p >END TIME　　: '.$row['endtime'].'</p>';
                  echo '</div>';
                  echo '<div class="card-action">';
                  echo '</div>';
              echo '</div>';
            echo '</div>';

          echo '</div>';
        echo '</div>';
        }

        mysqli_close($mysql);
        ?>


    </div>
    <!--script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script-->
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.form.min.js"></script>



    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    <script>
    function changehour(_var,_idx){
      //alert(_idx);
      //alert(_var);
        $.ajax({
          type: "GET", // POST형식으로 폼 전송
          url: "DB/modifyhour.php", // 목적지
          data: ({idx: _idx,hour:_var}),
          dataType: "text",
          success: function(data) {
            alert("시간변경완료");
          },
          error: function(xhr, textStatus, errorThrown) { // 전송 실패
            alert("전송에 실패했습니다.");
          }
        });
    }
    function changeminute(_var,_idx){
      $.ajax({
          type: "GET", // POST형식으로 폼 전송
          url: "DB/modifymin.php", // 목적지
          data: ({idx: _idx,min:_var}),
          dataType: "text",
          success: function(data) {
            alert("분변경완료");
          },
          error: function(xhr, textStatus, errorThrown) { // 전송 실패
            alert("전송에 실패했습니다.");
          }
        });
    }
    function change(_var) {
      //alert(_var);
        $.ajax({
          type: "GET", // POST형식으로 폼 전송
          url: "DB/modifyalarm.php", // 목적지
          data: ({idx: _var}),
          dataType: "text",
          success: function(data) {
            alert("변경완료");
          },
          error: function(xhr, textStatus, errorThrown) { // 전송 실패
            alert("전송에 실패했습니다.");
          }
        });
      }
        $(document).ready(function() {

          $('select').material_select();

          $('.modal').modal();
            $('.modaltest').click(function(){
            $('#modal1').modal('open');
          })

        });
    </script>
</body>

</html>
