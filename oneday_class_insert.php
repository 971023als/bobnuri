<?php
    session_start();

    if (!isset($_SESSION["userlevel"]) || $_SESSION["userlevel"] != 100) {
        echo("
            <script>
            alert('관리자가 아닙니다!');
            history.go(-1);
            </script>
        ");
        exit;
    }

    $product_name = htmlspecialchars($_POST["product_name"] ?? "", ENT_QUOTES);
    $point = htmlspecialchars($_POST["point"] ?? "", ENT_QUOTES);

    $upload_dir = './data/';

    $upfile_name     = $_FILES["upfile"]["name"] ?? "";
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"] ?? "";
    $upfile_size     = $_FILES["upfile"]["size"] ?? 0;
    $upfile_error    = $_FILES["upfile"]["error"] ?? UPLOAD_ERR_NO_FILE;

    if ($upfile_error != UPLOAD_ERR_NO_FILE && $upfile_error != UPLOAD_ERR_OK) {
        die("파일 업로드 중 오류가 발생했습니다. 오류 코드: $upfile_error");
    }

    if ($upfile_name && !$upfile_error) {
        $file_ext = pathinfo($upfile_name, PATHINFO_EXTENSION);

        $new_file_name = date("Y_m_d_H_i_s");
        $copied_file_name = $new_file_name.".".$file_ext;      
        $uploaded_file = $upload_dir.$copied_file_name;

        $check = getimagesize($upfile_tmp_name);
        if($check === false) {
            die('업로드한 파일이 이미지가 아닙니다.');
        }

        if ($upfile_size  > 1000000) {
            die('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요!');
        }

        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
            die('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
        }
    } else {
        $upfile_name = "";
        $file_ext = "";
        $copied_file_name = "";
    }

    require('db.php');

    $sql = "INSERT INTO oneday_class (product_name, point,  file_name, file_type, file_copied) VALUES (?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, "sisss", $product_name, $point, $upfile_name, $file_ext, $copied_file_name);
        
        if(mysqli_stmt_execute($stmt)){
            echo "Records inserted successfully.";
        } else{
            die("ERROR: Could not execute query: $sql. " . mysqli_error($con));
        }
    } else{
        die("ERROR: Could not prepare query: $sql. " . mysqli_error($con));
    }
     
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    
    echo "
       <script>
        location.href = 'oneday_class_index.php';
       </script>
    ";
?>


