<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["userid"], $_SESSION["username"])) {
        echo "<script>
              alert('원데이 클래스는 로그인 후 이용해 주세요!');
              history.go(-1);
              </script>";
        exit;
    }

    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    $num = $_GET["num"] ?? "";
    $page = $_GET["page"] ?? "1";

    $product_name = $_POST["product_name"] ?? "";
    $point = $_POST["point"] ?? "";
    
    $level = get_security_level();

    // XSS Protection only for Level 5
    if (is_level5()) {
        $product_name = htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');
        $point = htmlspecialchars($point, ENT_QUOTES, 'UTF-8');
    }

    $regist_day = date("Y-m-d (H:i)");
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
            die("<script>alert('업로드 파일 크기 초과!'); history.go(-1);</script>");
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
        $sql = "UPDATE oneday_class SET product_name='$product_name', point='$point'";
        if ($upfile_name) {
            $sql .= ", file_name='$upfile_name', file_type='$file_ext', file_copied='$copied_file_name'";
        }
        $sql .= " WHERE num=$num";
        $result = mysqli_query($con, $sql);
    } elseif ($level <= 3) {
        // Level 2/3: Escaping
        $p_name_esc = mysqli_real_escape_string($con, $product_name);
        $point_esc = mysqli_real_escape_string($con, $point);
        $sql = "UPDATE oneday_class SET product_name='$p_name_esc', point='$point_esc'";
        if ($upfile_name) {
            $sql .= ", file_name='$upfile_name', file_type='$file_ext', file_copied='$copied_file_name'";
        }
        $sql .= " WHERE num=$num";
        $result = mysqli_query($con, $sql);
    } else {
        // Level 4/5: Prepared
        if ($upfile_name) {
            $sql = "UPDATE oneday_class SET product_name=?, point=?, file_name=?, file_type=?, file_copied=? WHERE num=?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssssi", $product_name, $point, $upfile_name, $file_ext, $copied_file_name, $num);
        } else {
            $sql = "UPDATE oneday_class SET product_name=?, point=? WHERE num=?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $product_name, $point, $num);
        }
        $result = mysqli_stmt_execute($stmt);
    }

    if (!$result) die("수정 실패: " . mysqli_error($con));

    mysqli_close($con);

    echo "<script>
          location.href = 'oneday_class_buy.php?num=$num';
          </script>";
?>
