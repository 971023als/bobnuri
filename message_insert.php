<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $send_id = $_SESSION["userid"] ?? "";
    $rv_id = $_POST['rv_id'] ?? "";
    $subject = $_POST['subject'] ?? "";
    $content = $_POST['content'] ?? "";

    if(!$send_id) {
        echo("
            <script>
            alert('로그인 후 이용해 주세요!');
            history.go(-1)
            </script>
            ");
        exit;
    }

    $level = get_security_level();

    // XSS Protection only for Level 5
    if (is_level5()) {
        $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    }

    $regist_day = date("Y-m-d (H:i)");

    require('db.php');

    if ($level <= 1) {
        // Level 1: Vulnerable SQL
        $sql = "SELECT * FROM members WHERE id='$rv_id'";
        $result = mysqli_query($con, $sql);
    } else {
        // Level 2+: Escaping or Prepared
        $rv_id_esc = mysqli_real_escape_string($con, $rv_id);
        $sql = "SELECT * FROM members WHERE id='$rv_id_esc'";
        $result = mysqli_query($con, $sql);
    }
    
    $num_record = mysqli_num_rows($result);

    if($num_record)
    {
        if ($level <= 1) {
            // Level 1: Vulnerable Insert
            $sql = "INSERT INTO message (send_id, rv_id, subject, content, regist_day) ";
            $sql .= "VALUES ('$send_id', '$rv_id', '$subject', '$content', '$regist_day')";
            mysqli_query($con, $sql);
        } elseif ($level <= 3) {
            // Level 2/3: Escaping
            $rv_id_esc = mysqli_real_escape_string($con, $rv_id);
            $subject_esc = mysqli_real_escape_string($con, $subject);
            $content_esc = mysqli_real_escape_string($con, $content);
            $sql = "INSERT INTO message (send_id, rv_id, subject, content, regist_day) ";
            $sql .= "VALUES ('$send_id', '$rv_id_esc', '$subject_esc', '$content_esc', '$regist_day')";
            mysqli_query($con, $sql);
        } else {
            // Level 4/5: Prepared
            $sql = "INSERT INTO message (send_id, rv_id, subject, content, regist_day) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $send_id, $rv_id, $subject, $content, $regist_day);
            mysqli_stmt_execute($stmt);
        }
    } else {
        echo("
            <script>
            alert('수신 아이디가 잘못 되었습니다!');
            history.go(-1)
            </script>
            ");
        exit;
    }

    mysqli_close($con);

    echo "
       <script>
        location.href = './message_box.php?mode=send';
       </script>
    ";
?>
