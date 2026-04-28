<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $num = $_GET["num"] ?? "";
    $mode = $_GET["mode"] ?? "";
    $userid = $_SESSION["userid"] ?? "";

    if (!$userid) {
        die("<script>alert('로그인 후 이용해 주세요!'); history.go(-1);</script>");
    }

    require('db.php');
    $level = get_security_level();

    // Ownership check only for Level 4+
    if ($level >= 4) {
        if ($mode == "send") {
            $sql = "SELECT send_id FROM message WHERE num = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $num);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            if (!$row || $row['send_id'] !== $userid) {
                die("<script>alert('삭제 권한이 없습니다!'); history.go(-1);</script>");
            }
        } else {
            $sql = "SELECT rv_id FROM message WHERE num = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $num);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            if (!$row || $row['rv_id'] !== $userid) {
                die("<script>alert('삭제 권한이 없습니다!'); history.go(-1);</script>");
            }
        }
    }

    if ($level <= 1) {
        // Level 1: Vulnerable SQL
        $sql = "DELETE FROM message WHERE num=$num";
        $result = mysqli_query($con, $sql);
    } elseif ($level <= 3) {
        // Level 2/3: Escaping
        $num_esc = mysqli_real_escape_string($con, $num);
        $sql = "DELETE FROM message WHERE num=$num_esc";
        $result = mysqli_query($con, $sql);
    } else {
        // Level 4/5: Prepared
        $sql = "DELETE FROM message WHERE num=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $num);
        $result = mysqli_stmt_execute($stmt);
    }

    mysqli_close($con);

    $url = ($mode == "send") ? "./message_box.php?mode=send" : "./message_box.php?mode=rv";

    echo "<script>location.href = '$url';</script>";
?>
