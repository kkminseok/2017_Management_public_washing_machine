<?
  include("./dbconnect.php");
  $sql = "SELECT *, IF( now() BETWEEN starttime AND endtime , '1','2') as test FROM wm";
  //$sql = "SELECT * FROM wm;";

  $result = mysqli_query($mysql,$sql);
  /*
	while($row = $result->fetch_array())
	{
		print_r($row);
      	echo '<br>';
	}

	*/
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
    window.setTimeout('window.location.reload()',5000); //60초마다 리플리쉬 시킨다 1000이 1초가 된다. 
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
              echo '<div class="card-image">';
                echo'<img src="./'.$row['test'].'.png" style="width:200px" >';
              echo '</div>';
                //echo '  <div class="progress"><div class="indeterminate"></div></div>';
              echo '<div class="card-stacked">';
                  echo '<div class="card-content white-text">';
                    echo '<span class="card-title">NO : '.$row['no'].'</span>';
                    echo '<p style="color:#ffab40;">NFC ID : '.$row['id'].'</p>';
                    echo '<p style="color:#ffab40;">STATE  : '.$row['test'].'</p>';
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
