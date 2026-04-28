<?php require('lib/top.php'); ?>
<?php require('lib/copy.php'); ?>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/product.css">
<link rel="stylesheet" href="./css/bootstrap.min.css">
<link rel="stylesheet" href="./css/bar.css">
<script>
function check_product() {
    if (!document.product_form.product_name.value)
    {
        alert("?í’ˆëª…ì„ ?…ë ¥?˜ì„¸??");
        document.product_form.product_name.focus();
        return;
    }
    if (!document.product_form.point.value)
    {
        alert("?¬ì¸?¸ì„ ?…ë ¥?˜ì„¸??");
        document.product_form.point.focus();
        return;
    }
    document.product_form.submit();
 }
</script>
<?php
session_start();
if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
else $userid = "";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else $username = "";
if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
else $userlevel = "";

if ( $userlevel != 100 )
{
    echo("
                <script>
                alert('ê´€ë¦¬ìê°€?„ë‹™?ˆë‹¤!');
                history.go(-1)
                </script>
    ");
            exit;
}
	if (!$userid )
	{
		echo("<script>
				alert('ë¡œê·¸?????´ìš©?´ì£¼?¸ìš”!');
				history.go(-1);
				</script>
			");
		exit;
	}
?>
<section>
   	<div id="product_box">
	    <h3 id="product_title">
	    		?ë°?´í´?˜ìŠ¤ ?˜ì •
		</h3>
<?php
	$num  = $_GET["num"];
	$page = $_GET["page"];

	require('db.php');
	$sql = "select * from oneday_class where num=$num";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$product_name    = $row["product_name"];
  $point            = $row["point"];
	$file_name       = $row["file_name"];
?>
	    <form  name="product_form" method="post" action="oneday_class_modify.php?num=<?=$num?>&page=<?=$page?>" enctype="multipart/form-data">
        <ul id="product_form">
         <li>
           <span class="col1">?í’ˆëª?: </span>
           <span class="col2"><input name="product_name" type="text" value="<?=$product_name?>"></span>
         </li>
         <li>
           <span class="col1">?¬ì¸??: </span>
           <span class="col2"><input name="point" type="text" value="<?=$point?>"></span>
         </li>
         <li>
			        <span class="col1"> ì²¨ë? ?Œì¼ : </span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>
           </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_product()">?˜ì •?˜ê¸°</button></li>
				<li><button type="button" onclick="location.href='oneday_class_index.php'">ëª©ë¡</button></li>
			</ul>
	    </form>
	</div>
</section>
<?php require('lib/bottom.php'); ?>
