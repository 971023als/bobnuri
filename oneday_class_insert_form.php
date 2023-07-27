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
        alert("상품명을 입력하세요!");
        document.product_form.product_name.focus();
        return;
    }
    if (!document.product_form.point.value)
    {
        alert("포인트를 입력하세요!");
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
                alert('관리자가 아닙니다!');
                history.go(-1)
                </script>
    ");
            exit;
}
	if (!$userid )
	{
		echo("<script>
				alert('로그인 후 이용해주세요!');
				history.go(-1);
				</script>
			");
		exit;
	}
?>
<section>
   	<div id="product_box">
	    <h3 id="product_title">
      원데이 > 추가
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
			        <span class="col1"> 첨부 파일</span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>		
	    		<li>
	    			<span class="col1">상품명 :  </span>
	    			<span class="col2"><input name="product_name" type="text"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">포인트  </span>
	    			<span class="col2"><input name="point" type="text"></span>
	    		</li>
           </ul>
	    	<ul class="buttons">
				<li><button type="button"  onclick="check_product()">추가하기</button></li>
				<li><button type="button" onclick="location.href='oneday_class_index.php'">목록</button></li>
			</ul>
	    </form>
	</div>
</section>
<?php require('lib/bottom.php'); ?>


