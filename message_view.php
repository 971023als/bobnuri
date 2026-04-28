<?php require('lib/top.php'); ?>
<?php require('lib/copy.php'); ?>
<section>
   	<div id="message_box">
	    <h3 class="title">
<?php
	$mode = $_GET["mode"];
	$num  = $_GET["num"];

	require('db.php');
	$sql = "select * from message where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$send_id    = $row["send_id"];
	$rv_id      = $row["rv_id"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];

	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);

	if ($mode=="send")
		$result2 = mysqli_query($con, "select name from members where id='$rv_id'");
	else
		$result2 = mysqli_query($con, "select name from members where id='$send_id'");

	$record = mysqli_fetch_array($result2);
	$msg_name = $record["name"];

	if ($mode=="send")	    	
	    echo "?¡ì‹  ìª½ì???";
	else
		echo "?˜ì‹  ìª½ì???";
?>
		</h3>
	    <ul id="view_content">
			<li>
				<span class="col1"><b>?œëª© :</b> <?=$subject?></span>
				<span class="col2"><?=$msg_name?> | <?=$regist_day?></span>
			</li>
			<li>
				<?=$content?>
			</li>		
	    </ul>
	    <ul class="buttons">
				<li><button onclick="location.href='./message_box.php?mode=rv'">?˜ì‹  ìª½ì???/button></li>
				<li><button onclick="location.href='./message_box.php?mode=send'">?¡ì‹  ìª½ì???/button></li>
				<li><button onclick="location.href='./message_response_form.php?num=<?=$num?>'">?µë? ìª½ì?</button></li>
				<li><button onclick="location.href='./message_delete.php?num=<?=$num?>&mode=<?=$mode?>'">?? œ</button></li>
		</ul>
	</div> <!-- message_box -->
</section> 
<?php require('lib/bottom.php'); ?>
