<?php
    session_start();

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

    $subject = htmlspecialchars($_POST["subject"] ?? "", ENT_QUOTES);
    $content = htmlspecialchars($_POST["content"] ?? "", ENT_QUOTES);
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
        $upfile_type      = "";
        $copied_file_name = "";
    }

    require('db.php');

    if($con === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $sql = "INSERT INTO board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
     
    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, "sssssisss", $param_id, $param_name, $param_subject, $param_content, $param_regist_day, $param_hit, $param_file_name, $param_file_type, $param_file_copied);
        
        $param_id = $userid;
        $param_name = $username;
        $param_subject = $subject;
        $param_content = $content;
        $param_regist_day = $regist_day;
        $param_hit = 0;
        $param_file_name = $upfile_name;
        $param_file_type = $file_ext;
        $param_file_copied = $copied_file_name;

        if(mysqli_stmt_execute($stmt)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not execute query: $sql. " . mysqli_error($con);
        }
    } else{
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($con);
    }
     
    mysqli_stmt_close($stmt);
    
    $point_up = 100;

    $sql = "UPDATE members SET point=point + ? WHERE id= ?";
    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, "is", $param_point_up, $param_userid);
        $param_point_up = $point_up;
        $param_userid = $userid;
        if(mysqli_stmt_execute($stmt)){
            echo "Points updated successfully.";
        } else{
            echo "ERROR: Could not execute query: $sql. " . mysqli_error($con);
        }
    } else{
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($con);
    }

    mysqli_close($con);

    echo "
       <script>
        location.href = 'board_list.php';
       </script>
    ";
?>




  
