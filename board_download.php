<?php
    session_start();  // 세션 시작

    $real_name = $_GET["real_name"];
    $file_name = $_GET["file_name"];
    $file_type = $_GET["file_type"];
    $file_path = "./data/".$real_name;

    $ie = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || 
        (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false && 
            strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false);

    //IE인경우 한글파일명이 깨지는 경우를 방지하기 위한 코드 
    if( $ie ){
         $file_name = iconv('utf-8', 'euc-kr', $file_name);
    }

    // 로그인 상태가 아닌 경우, 본인 파일만 다운로드 가능
    if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] != $real_name) {
        die('로그인 상태가 아니면 다운로드 불가합니다.');
    }

    if( file_exists($file_path) )
    { 
        $fp = fopen($file_path,"rb"); 
        Header("Content-type: application/x-msdownload"); 
        Header("Content-Length: ".filesize($file_path));     
        Header("Content-Disposition: attachment; filename=".$file_name);   
        Header("Content-Transfer-Encoding: binary"); 
        Header("Content-Description: File Transfer"); 
        Header("Expires: 0");       
    } 
    
    if(!fpassthru($fp)) 
        fclose($fp); 
?>


  
