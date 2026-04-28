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
        alert("?¬ì¸?¸ë? ?…ë ¥?˜ì„¸??");
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
                alert('ê´€ë¦¬ìê°€ ?„ë‹™?ˆë‹¤!');
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
      ?ë°??> ì¶”ê?
		</h3>
    <?php
	$num  = $_GET["num"];
	$page = $_GET["page"];

	require('db.php');
  $result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
?>
	    <form  name="product_form" method="post" action="./oneday_class_insert.php" enctype="multipart/form-data">
        <ul id="product_form">
        <li>
			        <span class="col1"> ì²¨ë? ?Œì¼</span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>		
	    		<li>
	    			<span class="col1">?í’ˆëª?:  </span>
	    			<span class="col2"><input name="product_name" type="text"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">?¬ì¸?? </span>
	    			<span class="col2"><input name="point" type="text"></span>
	    		</li>
           </ul>
	    	<ul class="buttons">
				<li><button type="button"  onclick="check_product()">ì¶”ê??˜ê¸°</button></li>
				<li><button type="button" onclick="location.href='oneday_class_index.php'">ëª©ë¡</button></li>
			</ul>
	    </form>
	</div>
</section>
<?php require('lib/bottom.php'); ?>


