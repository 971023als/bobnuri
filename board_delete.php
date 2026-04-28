<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $userid = $_SESSION["userid"] ?? "";
    $num = $_GET["num"] ?? "";
    $page = $_GET["page"] ?? "1";

    if (!$userid) {
        die("<script>alert('로그인 후 이용해 주세요!'); history.go(-1);</script>");
    }

    require('db.php');
    $level = get_security_level();

    // Check ownership only for Level 4+
    if ($level >= 4) {
        $sql = "SELECT id FROM board WHERE num = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $num);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        
        if (!$row || $row['id'] !== $userid) {
            die("<script>alert('삭제 권한이 없습니다!'); history.go(-1);</script>");
        }
    }

    if ($level <= 1) {
        // Level 1: Vulnerable to SQL Injection and IDOR
        $sql = "DELETE FROM board WHERE num = $num";
        $result = mysqli_query($con, $sql);
    } elseif ($level <= 3) {
        // Level 2/3: Basic Escaping (Still vulnerable to IDOR)
        $num_esc = mysqli_real_escape_string($con, $num);
        $sql = "DELETE FROM board WHERE num = $num_esc";
        $result = mysqli_query($con, $sql);
    } else {
        // Level 4/5: Prepared Statements & Ownership check
        $sql = "DELETE FROM board WHERE num = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $num);
        $result = mysqli_stmt_execute($stmt);
    }

    if (!$result) die("삭제 실패: " . mysqli_error($con));

    mysqli_close($con);

    echo "
         <script>
             location.href = 'board_list.php?page=$page';
         </script>
       ";
?>
