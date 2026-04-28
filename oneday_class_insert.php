<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["userlevel"]) || $_SESSION["userlevel"] != 100) {
        die("<script>alert('관리자가 아닙니다!'); history.go(-1);</script>");
    }

    $product_name = $_POST["product_name"] ?? "";
    $point = $_POST["point"] ?? "";
    
    $level = get_security_level();

    // XSS Protection only for Level 5
    if (is_level5()) {
        $product_name = htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');
        $point = htmlspecialchars($point, ENT_QUOTES, 'UTF-8');
    }

    $upload_dir = './data/';
    $upfile_name = $_FILES["upfile"]["name"] ?? "";
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"] ?? "";
    $upfile_size = $_FILES["upfile"]["size"] ?? 0;
    $upfile_error = $_FILES["upfile"]["error"] ?? UPLOAD_ERR_NO_FILE;

    if ($upfile_name && !$upfile_error) {
        $file_ext = pathinfo($upfile_name, PATHINFO_EXTENSION);
        $new_file_name = date("Y_m_d_H_i_s");
        $copied_file_name = $new_file_name.".".$file_ext;      
        $uploaded_file = $upload_dir.$copied_file_name;

        if ($upfile_size > 1000000) {
            die("<script>alert('파일 크기 초과!'); history.go(-1);</script>");
        }

        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
            die("<script>alert('파일 복사 실패'); history.go(-1);</script>");
        }
    } else {
        $upfile_name = "";
        $file_ext = "";
        $copied_file_name = "";
    }

    require('db.php');

    if ($level <= 1) {
        // Level 1: Vulnerable SQL
        $sql = "INSERT INTO oneday_class (product_name, point, file_name, file_type, file_copied) ";
        $sql .= "VALUES ('$product_name', '$point', '$upfile_name', '$file_ext', '$copied_file_name')";
        $result = mysqli_query($con, $sql);
    } elseif ($level <= 3) {
        // Level 2/3: Escaping
        $p_name_esc = mysqli_real_escape_string($con, $product_name);
        $point_esc = mysqli_real_escape_string($con, $point);
        $sql = "INSERT INTO oneday_class (product_name, point, file_name, file_type, file_copied) ";
        $sql .= "VALUES ('$p_name_esc', '$point_esc', '$upfile_name', '$file_ext', '$copied_file_name')";
        $result = mysqli_query($con, $sql);
    } else {
        // Level 4/5: Prepared
        $sql = "INSERT INTO oneday_class (product_name, point, file_name, file_type, file_copied) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sisss", $product_name, $point, $upfile_name, $file_ext, $copied_file_name);
        $result = mysqli_stmt_execute($stmt);
    }

    if (!$result) die("등록 실패: " . mysqli_error($con));

    mysqli_close($con);
    echo "<script>location.href = 'oneday_class_index.php';</script>";
?>
