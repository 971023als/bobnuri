<?php
session_start();

// Ensure the session userid is set
if (!isset($_SESSION["userid"])) {
    // Redirect or error handling code
    die("Session is not set.");
}

$userid = $_SESSION["userid"];

require('db.php');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Using prepared statements to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM members WHERE id = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$point = intval($row["point"]);

$totalpoint = filter_input(INPUT_GET, 'totalpoint', FILTER_SANITIZE_NUMBER_INT);
$count = filter_input(INPUT_GET, 'count', FILTER_SANITIZE_NUMBER_INT);
$product_name = filter_input(INPUT_GET, 'product_name', FILTER_SANITIZE_STRING);

$newpoint = $point - $totalpoint;

if ($newpoint < 0) {
    die("Not enough points.");
}

// Update member's point
$stmt = $con->prepare("UPDATE members SET point = ? WHERE id = ?");
$stmt->bind_param("is", $newpoint, $userid);
$stmt->execute();

$_SESSION["userpoint"] = $newpoint;

$stmt = $con->prepare("INSERT INTO oneday_class_buy(product_name, pin_number, id, order_check) VALUES (?, ?, ?, 'Íµ¨Îß§?ÑÎ£å')");

for ($i = 0; $i < $count; $i++) {
    $value1 = rand(1000, 9999);
    $value2 = rand(1000, 9999);
    $value3 = rand(1000, 9999);
    $value4 = rand(100000, 999999);

    $pin_number = $value1 . " " . $value2 . " " . $value3 . " " . $value4;

    // Insert the purchase into the oneday_class_buy table
    $stmt->bind_param("sss", $product_name, $pin_number, $userid);
    $stmt->execute();
}

$stmt->close();
$con->close();

echo "
      <script>
    alert('?¨Ïö©?êÏùò Î≤àÌò∏Î°?PINÎ≤àÌò∏Î•?Î≥¥ÎÇ¥?úÎ†∏?µÎãà??');
          location.href = 'oneday_class_index.php';
      </script>
  ";
?>


