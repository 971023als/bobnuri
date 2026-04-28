<?php
session_start();
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
} else {
    // Handle unauthenticated user here
    exit;
}

$num   = intval($_POST["num"]);
$count = intval($_POST["count"]);

require('db.php');

$stmt = $con->prepare("SELECT * FROM oneday_class WHERE num = ?");
$stmt->bind_param("i", $num);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$product_name = htmlspecialchars($row["product_name"]);
$point = intval($row["point"]);

$totalpoint = $count * $point;

$stmt = $con->prepare("SELECT * FROM members WHERE id = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$userpoint = intval($row["point"]);

$stmt->close();
$con->close();

if($userpoint < $totalpoint){
  echo("<script>
      alert('보유포인트가 부족합니다!');
      history.go(-1);
      </script>
    ");
} else {
  ?>
  <script>
		location.href="oneday_class_buy_03.php?num=<?=$num?>&id=<?=$userid?>&totalpoint=<?=$totalpoint?>&count=<?=$count?>";
  </script>
<?php }
?>
