<meta charset='utf-8'>
<?php
    $send_id = $_GET["send_id"];

    $rv_id = $_POST['rv_id'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];
	$subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);
	$regist_day = date("Y-m-d (H:i)");  // ?„ì¬??'????????ë¶????€??

	if(!$send_id) {
		echo("
			<script>
			alert('ë¡œê·¸?????´ìš©??ì£¼ì„¸?? ');
			history.go(-1)
			</script>
			");
		exit;
	}

	require('db.php');
	$sql = "select * from members where id='$rv_id'";
	$result = mysqli_query($con, $sql);
	$num_record = mysqli_num_rows($result);

	if($num_record)
	{
		$sql = "insert into message (send_id, rv_id, subject, content,  regist_day) ";
		$sql .= "values('$send_id', '$rv_id', '$subject', '$content', '$regist_day')";
		mysqli_query($con, $sql);  // $sql ???€?¥ëœ ëª…ë ¹ ?¤í–‰
	} else {
		echo("
			<script>
			alert('?˜ì‹  ?„ì´?”ê? ?˜ëª» ?˜ì—ˆ?µë‹ˆ??');
			history.go(-1)
			</script>
			");
		exit;
	}

	mysqli_close($con);                // DB ?°ê²° ?Šê¸°

	echo "
	   <script>
	    location.href = './message_box.php?mode=send';
	   </script>
	";
?>

  
