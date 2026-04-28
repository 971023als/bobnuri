<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $userlevel = $_SESSION["userlevel"] ?? 0;
    if ($userlevel != 100) {
        die("<script>alert('관리자가 아닙니다!'); history.go(-1);</script>");
    }

    $num = $_GET["num"] ?? "";
    $level = get_security_level();

    require('db.php');

    if ($level <= 1) {
        // Level 1: Vulnerable SQL
        $sql = "DELETE FROM oneday_class WHERE num = $num";
        $result = mysqli_query($con, $sql);
    } elseif ($level <= 3) {
        // Level 2/3: Escaping
        $num_esc = mysqli_real_escape_string($con, $num);
        $sql = "DELETE FROM oneday_class WHERE num = $num_esc";
        $result = mysqli_query($con, $sql);
    } else {
        // Level 4/5: Prepared
        $sql = "DELETE FROM oneday_class WHERE num = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $num);
        $result = mysqli_stmt_execute($stmt);
    }

    mysqli_close($con);
    echo "<script>location.href = 'oneday_class_index.php';</script>";
?>
