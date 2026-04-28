<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $userid = $_SESSION["userid"] ?? "";
    $username = $_SESSION["username"] ?? "";

    if ( !$userid )
    {
        echo("
            <script>
            alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
            history.back();
            </script>
        ");
        exit;
    }

    $subject = $_POST["subject"] ?? "";
    $content = $_POST["content"] ?? "";
    
    $level = get_security_level();

    // XSS Protection only for Level 5
    if (is_level5()) {
        $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    }

    $regist_day = date("Y-m-d (H:i)");  

    $upload_dir = './data/';

    $upfile_name     = $_FILES["upfile"]["name"] ?? "";
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"] ?? "";
    $upfile_size     = $_FILES["upfile"]["size"] ?? 0;
    $upfile_error    = $_FILES["upfile"]["error"] ?? UPLOAD_ERR_NO_FILE;

    $file_ext = pathinfo($upfile_name, PATHINFO_EXTENSION);

    $new_file_name = date("Y_m_d_H_i_s");
    $copied_file_name = $new_file_name.".".$file_ext;      
    $uploaded_file = $upload_dir.$copied_file_name;

    if ($upfile_name && !$upfile_error)
    {
        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) )
        {
            echo("
                <script>
                alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                history.back();
                </script>
            ");
            exit;
        }
    }
    else 
    {
        if($upfile_error != UPLOAD_ERR_NO_FILE) {
            echo("
                <script>
                alert('파일 업로드 중 오류가 발생했습니다. 오류 코드: ".$upfile_error."');
                history.back();
                </script>
            ");
            exit;
        }

        $upfile_name      = "";
        $copied_file_name = "";
    }

    require('db.php');

    if ($level <= 1) {
        // Level 1: Vulnerable to SQL Injection
        $sql = "INSERT INTO board (id, name, subject, content, regist_day, hit, file_name, file_type, file_copied) ";
        $sql .= "VALUES ('$userid', '$username', '$subject', '$content', '$regist_day', 0, '$upfile_name', '$file_ext', '$copied_file_name')";
        $result = mysqli_query($con, $sql);
    } elseif ($level <= 3) {
        // Level 2/3: Basic Escaping
        $id_esc = mysqli_real_escape_string($con, $userid);
        $name_esc = mysqli_real_escape_string($con, $username);
        $subject_esc = mysqli_real_escape_string($con, $subject);
        $content_esc = mysqli_real_escape_string($con, $content);
        $sql = "INSERT INTO board (id, name, subject, content, regist_day, hit, file_name, file_type, file_copied) ";
        $sql .= "VALUES ('$id_esc', '$name_esc', '$subject_esc', '$content_esc', '$regist_day', 0, '$upfile_name', '$file_ext', '$copied_file_name')";
        $result = mysqli_query($con, $sql);
    } else {
        // Level 4/5: Prepared Statements
        $sql = "INSERT INTO board (id, name, subject, content, regist_day, hit, file_name, file_type, file_copied) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        $hit = 0;
        mysqli_stmt_bind_param($stmt, "sssssisss", $userid, $username, $subject, $content, $regist_day, $hit, $upfile_name, $file_ext, $copied_file_name);
        $result = mysqli_stmt_execute($stmt);
    }

    if (!$result) {
        die("게시글 등록 실패: " . mysqli_error($con));
    }

    // Point update also based on level (keeping it simple for now)
    $point_up = 100;
    if ($level >= 4) {
        $sql = "UPDATE members SET point=point + ? WHERE id= ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "is", $point_up, $userid);
        mysqli_stmt_execute($stmt);
    } else {
        $sql = "UPDATE members SET point=point + $point_up WHERE id= '$userid'";
        mysqli_query($con, $sql);
    }

    mysqli_close($con);

    echo "
       <script>
        location.href = 'board_list.php';
       </script>
    ";
?>
