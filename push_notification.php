<?php

	function send_notification ($tokens, $message)
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			 'registration_ids' => $tokens,
			 'data' => $message
			);

		$headers = array(
			'Authorization:key =' .GOOGLE_API_KEY,
			'Content-Type: application/json'
			);

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	}


	//데이터베이스에 접속해서 토큰들을 가져와서 FCM에 발신요청
	  include("./dbconnect.php");
		include("./DB/confing.php");

	  $tokenlist=array();
		$sqltoken="SELECT Token FROM kms_fcm";
		$resulttoken=mysqli_query($mysql,$sqltoken);


		  while($row=mysqli_fetch_array($resulttoken))
			{
				//echo$row['Token'];
				$tokenlist[]=$row['Token'];
				//echo$tokenlist[0];

			}
				$tokens=array();
	//$tokens = array('c34go4wDt4I:APA91bEmdmcrceIwMZ3FxdzPUpB0Zs5xjbrw-QOJE0bkkTM4pnZiqEdy5SKwIrYSX4zPJUDoSpEcBe-ptqb4OzRK36OfsmWXTmHtVGi3_LhrNy0gmbsP5n-ETx9oohbnKxK68Bz8hdjI');

		$tokens=array();
	for($i=0;$i<10;$i++)
	{
		$tokens[$i]=$tokenlist[$i];

	}
	print_r($tokens);
        $myMessage = $_POST['message']; //폼에서 입력한 메세지를 받음


	$sqlstate="SELECT state FROM kms_fcm ";
	$resultstate=mysqli_query($mysql,$sqlstate);
//	if ($myMessage == ""){
//		$myMessage = "세탁이 변경되었습니다.";
//	}
	while($row=mysqli_fetch_array($resultstate))
	{
		echo$row['state'];
		//echo$row['Token'];
		if($row['state']==1)
		{

				if ($myMessage == ""){
				$myMessage = "세탁이 완료되었습니다.";
				}
		}
		//echo$tokenlist[0];
		else if($row['state']==3)
		{
			if ($myMessage == ""){
			$myMessage = "세탁이 돌아갑니다.";
			}
		}
		else if($row['state'==2])
		{
			if ($myMessage == ""){
			$myMessage = "세탁을 수거하였습니다.";
			}

		}
	}
	$message = array("message" => $myMessage);
	$message_status = send_notification($tokens, $message);
	echo $message_status;

	$sqldelete="DELETE FROM kms_fcm WHERE id>3";
	$resultdele=mysqli_query($mysql,$sqldelete);
	echo$sqldelete;

$prevPage = $_SERVER['HTTP_REFERER'];
// 변수에 이전페이지 정보를 저장

//header('location:'.$prevPage);
// 페이지 이동


 ?>
