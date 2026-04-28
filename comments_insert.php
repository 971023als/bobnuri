<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION["username"])) {
        die("로그인 후 이용해 주세요.");
    }

    require('db.php');

    if(isset($_POST['board_num'], $_POST['page'], $_POST['comment'])) {
        $board_num = $_POST['board_num'];
        $page = $_POST['page'];
        $username = $_SESSION["username"];
        $comment = $_POST['comment'];
        
        $level = get_security_level();

        // XSS Protection only for Level 5
        if (is_level5()) {
            $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
        }

        if ($level <= 1) {
            // Level 1: Vulnerable SQL
            $sql = "INSERT INTO comments (board_num, page, post_name, comment, regist_day) ";
            $sql .= "VALUES ($board_num, $page, '$username', '$comment', NOW())";
            $result = mysqli_query($con, $sql);
        } elseif ($level <= 3) {
            // Level 2/3: Escaping
            $bn_esc = mysqli_real_escape_string($con, $board_num);
            $pg_esc = mysqli_real_escape_string($con, $page);
            $un_esc = mysqli_real_escape_string($con, $username);
            $cm_esc = mysqli_real_escape_string($con, $comment);
            $sql = "INSERT INTO comments (board_num, page, post_name, comment, regist_day) ";
            $sql .= "VALUES ($bn_esc, $pg_esc, '$un_esc', '$cm_esc', NOW())";
            $result = mysqli_query($con, $sql);
        } else {
            // Level 4/5: Prepared
            $sql = "INSERT INTO comments (board_num, page, post_name, comment, regist_day) VALUES (?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "iiss", $board_num, $page, $username, $comment);
            $result = mysqli_stmt_execute($stmt);
        }

        mysqli_close($con);
        header('Location: board_view.php?num='.$board_num.'&page='.$page);
        exit();
    } else {
        die("필수 변수가 누락되었습니다.");
    }
?>
