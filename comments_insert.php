<?php
session_start();

if(!isset($_SESSION["username"])) {
    echo "User session is not set.";
    exit();
}

require('db.php');

if(isset($_POST['board_num'], $_POST['page'], $_POST['comment'])) {
    $board_num = mysqli_real_escape_string($con, $_POST['board_num']);
    $page = mysqli_real_escape_string($con, $_POST['page']);
    $post_name = mysqli_real_escape_string($con, $_SESSION["username"]);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);

    $stmt = $con->prepare("INSERT INTO comments (board_num, page ,post_name, comment, regist_day) VALUES ( ?, ? ,?, ?, NOW())");

    if ($stmt === false) {
        error_log('prepare() failed: ' . htmlspecialchars($con->error));
        echo "Failed to prepare the statement. Please try again later.";
        exit();
    }

    $bind = $stmt->bind_param('iiss', $board_num, $page, $post_name, $comment);
    if ($bind === false) {
        error_log('bind_param() failed: ' . htmlspecialchars($stmt->error));
        echo "Failed to bind the parameters. Please try again later.";
        exit();
    }

    $exec = $stmt->execute();
    if ($exec === false) {
        error_log('execute() failed: ' . htmlspecialchars($stmt->error));
        echo "Failed to execute the statement. Please try again later.";
        exit();
    }

    $stmt->close();
    mysqli_close($con);

    header('Location: board_view.php?num='.$board_num.'&page='.$page);
    exit();
} else {
    echo "Not all required POST variables have been set.";
    exit();
}
?>













