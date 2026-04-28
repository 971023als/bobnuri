<?php
    session_start();

    if (!isset($_SESSION["userlevel"]) || $_SESSION["userlevel"] != 100) {
        echo("
            <script>
            alert('ê´€ë¦¬ìê°€ ?„ë‹™?ˆë‹¤!');
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
        die("?Œì¼ ?…ë¡œ??ì¤??¤ë¥˜ê°€ ë°œìƒ?ˆìŠµ?ˆë‹¤. ?¤ë¥˜ ì½”ë“œ: $upfile_error");
    }

    if ($upfile_name && !$upfile_error) {
        $file_ext = pathinfo($upfile_name, PATHINFO_EXTENSION);

        $new_file_name = date("Y_m_d_H_i_s");
        $copied_file_name = $new_file_name.".".$file_ext;      
        $uploaded_file = $upload_dir.$copied_file_name;

        $check = getimagesize($upfile_tmp_name);
        if($check === false) {
            die('?…ë¡œ?œí•œ ?Œì¼???´ë?ì§€ê°€ ?„ë‹™?ˆë‹¤.');
        }

        if ($upfile_size  > 1000000) {
            die('?…ë¡œ???Œì¼ ?¬ê¸°ê°€ ì§€?•ëœ ?©ëŸ‰(1MB)??ì´ˆê³¼?©ë‹ˆ??<br>?Œì¼ ?¬ê¸°ë¥?ì²´í¬?´ì£¼?¸ìš”!');
        }

        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
            die('?Œì¼??ì§€?•í•œ ?”ë ‰? ë¦¬??ë³µì‚¬?˜ëŠ”???¤íŒ¨?ˆìŠµ?ˆë‹¤.');
        }
    } else {
        $upfile_name = "";
        $file_ext = "";
        $copied_file_name = "";
    }

    require('db.php');

    $sql = "INSERT INTO point_mall (product_name, point,  file_name, file_type, file_copied) VALUES (?, ?, ?, ?, ?)";

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
        location.href = 'point_mall_index.php';
       </script>
    ";
?>



