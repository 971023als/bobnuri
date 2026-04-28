<?php
session_start();

if (!isset($_SESSION["id"])) {
    echo("<script>
            alert('ë¡œê·¸?????´ìš©?´ì£¼?¸ìš”!');
            history.go(-1);
          </script>");
    exit;
} else {
    $userid = $_SESSION["id"];
}

$num = intval($_GET["num"]);

require('db.php');

$stmt = $con->prepare("SELECT * FROM point_mall WHERE num = ?");
$stmt->bind_param("i", $num);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$product_name = htmlspecialchars($row["product_name"]);
$point = intval($row["point"]);

$stmt->close();
$con->close();

// Get totalpoint and count from session (or wherever they were stored)
$totalpoint = $_SESSION["totalpoint"];
$count = $_SESSION["count"];
?>

<?php require('lib/top.php'); ?>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/basket.css">
<link rel="stylesheet" href="./css/bootstrap.min.css">
<link rel="stylesheet" href="./css/bar.css">

<body>

<section>
   	<div id="basket_box">
	    <h3 id="basket_title">ë²ˆí˜¸?…ë ¥</h3>
	    <form  name="basket_order_form" method="post" action="point_mall_buy_04.php" enctype="multipart/form-data">
        <input type="hidden" name="totalpoint" value="<?=$totalpoint?>">
        <input type="hidden" name="count" value="<?=$count?>">
        <input type="hidden" name="product_name" value="<?=$product_name?>">
	    	 <ul id="basket_form">
				<li><span class="col1">?í’ˆëª?: </span><span class="col2"><?=$product_name?></span></li>
	    		<li><span class="col1">?˜ëŸ‰ : </span><span class="col2"><?=$count?>ê°?/span></li>
          <li><span class="col1">ê°€ê²?: </span><span class="col2"><?=number_format($totalpoint)?>P</span></li>
          <li><span class="col1">?´ë?ë²ˆí˜¸ : </span><span class="col2"><input type="text" name="phone"></span></li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_order()">?„ë£Œ</button></li>
				<li><button type="button" onclick="location.href='point_mall_index.php'">ëª©ë¡</button></li>
			</ul>
	    </form>
	</div>
</section>
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
function check_order() {
    var phoneRegex = /^[0-9]{3}-[0-9]{4}-[0-9]{4}$/; // Adjust this if needed
    var phone = document.basket_order_form.phone.value;
    if (!phone || !phoneRegex.test(phone)) {
        alert("?¬ë°”ë¥??´ë?ë²ˆí˜¸ë¥??…ë ¥?˜ì„¸??");
        document.basket_order_form.phone.focus();
        return;
    }
    document.basket_order_form.submit();
}
</script>
<?php require('lib/bottom.php'); ?>


  