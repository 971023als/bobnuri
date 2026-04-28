<?php
session_start();

require('db.php');


$nums = isset($_GET['nums']) ? $_GET['nums'] : null;
$num = isset($_GET['num']) ? $_GET['num'] : null;
$page = isset($_GET['page']) ? $_GET['page'] : null;

if ($nums) {
    $stmt = $con->prepare("DELETE FROM comments WHERE nums = ?");
    $stmt->bind_param('i', $nums);
    $result = $stmt->execute();

    if ($result) {
        echo "<script>alert('?? œ ?„ë£Œ.'); location.href='board_view.php?num={$num}&page={$page}';</script>";
    } else {
        echo "<script>alert('?? œ ?¤íŒ¨.'); history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); history.back();</script>";
}
?>



