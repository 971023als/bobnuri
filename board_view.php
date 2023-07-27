<?php
session_start();

require('lib/top.php');
require('lib/copy.php');
?>

<link rel="stylesheet" type="text/css" href="./css/board.css">

<?php

require('db.php');

$num  = filter_var($_GET["num"], FILTER_SANITIZE_NUMBER_INT);
$page  = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT);

$stmt = $con->prepare("SELECT * FROM board WHERE num = ?");
$stmt->bind_param('i', $num);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$id      = $row["id"];
$name      = $row["name"];
$regist_day = $row["regist_day"];
$subject    = $row["subject"];
$content    = $row["content"];
$file_name    = $row["file_name"];
$file_type    = $row["file_type"];
$file_copied  = $row["file_copied"];
$hit          = $row["hit"];

$content = str_replace(" ", "&nbsp;", $content);
$content = str_replace("\n", "<br>", $content);

if (!isset($_SESSION['viewed_'.$num])) {
    $new_hit = $hit + 1;
    $stmt = $con->prepare("UPDATE board SET hit = ? WHERE num = ?");
    $stmt->bind_param('ii', $new_hit, $num);
    $stmt->execute();

    $_SESSION['viewed_'.$num] = true;
}
?>

<section>
    <div id="board_box" class="common_style">
        <h3 class="title">
            민원등록 > 내용보기
        </h3>
        <ul id="view_content">
            <li>
                <span class="col1"><b>제목 :</b> <?=$subject?></span>
                <span class="col2"><?=$name?> | <?=$regist_day?></span>
            </li>
            <li>
            <?php
               if($file_name) {
                $real_name = $file_copied;
                $file_path = "./data/".$real_name;
                $file_size = filesize($file_path);
            
                echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
            
                if(file_exists($file_path)) {
                    echo "<img src='./data/$real_name' alt='Attached Image'><br><br><br>";
                } else {
                    echo "이미지를 찾을 수 없습니다.<br><br><br>";
                }
            }
            
            ?>
                <?=$content?>
            </li>       
        </ul>
        <?php require('comments_form.php'); ?>
        <!-- Comment list -->
        <ul class="buttons common_style">
            <li><button onclick="location.href='board_list.php?page=<?=$page?>'">목록</button></li>
            <li><button onclick="location.href='board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
            <li><button onclick="location.href='board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
            <li><button onclick="location.href='board_form.php'">글쓰기</button></li>
        </ul>
</section>
		
<?php require('lib/bottom.php'); ?>




