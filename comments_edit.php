<?php
ini_set('display_errors', 0);
session_start();

require('db.php');

$nums = $_POST['nums'];
$board_num = $_POST['board_num'];
$page = $_POST['page'];
$comment = $_POST['comment'];

// Prepare the statement
$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE nums = ?");

// Bind the parameters
$stmt->bind_param('si', $comment, $nums);

// Execute the statement
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['message'] = "Execution Successful.";
    header('Location: board_view.php?num='.$board_num.'&page='.$page);
    exit();
} else {
    $_SESSION['message'] = "Not all required POST variables have been set.";
    header('Location: board_view.php?num='.$board_num.'&page='.$page);
    exit();
}

?>




