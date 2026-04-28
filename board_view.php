<?php
session_start();

require('lib/top.php');
require('lib/copy.php');
?>

<link rel="stylesheet" type="text/css" href="./css/board.css">

<?php
require('db.php');
require_once('security_config.php');

$num = $_GET["num"] ?? "";
$page = $_GET["page"] ?? "1";
$level = get_security_level();

if ($level <= 1) {
    // Level 1: Vulnerable to SQL Injection
    $sql = "SELECT * FROM board WHERE num = $num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
} elseif ($level <= 3) {
    // Level 2/3: Basic Escaping
    $num_esc = mysqli_real_escape_string($con, $num);
    $sql = "SELECT * FROM board WHERE num = $num_esc";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
} else {
    // Level 4/5: Prepared Statements
    $sql = "SELECT * FROM board WHERE num = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $num);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
}

if (!$row) {
    die("<script>alert('존재하지 않는 게시글입니다.'); history.go(-1);</script>");
}

$id = $row["id"];
$name = xss_check($row["name"]);
$regist_day = $row["regist_day"];
$subject = xss_check($row["subject"]);
$content = xss_check($row["content"]);
$file_name = $row["file_name"];
$file_type = $row["file_type"];
$file_copied = $row["file_copied"];
$hit = $row["hit"];

$content = str_replace(" ", "&nbsp;", $content);
$content = str_replace("\n", "<br>", $content);

if (!isset($_SESSION['viewed_'.$num])) {
    $new_hit = $hit + 1;
    if ($level >= 4) {
        $stmt = mysqli_prepare($con, "UPDATE board SET hit = ? WHERE num = ?");
        mysqli_stmt_bind_param($stmt, 'ii', $new_hit, $num);
        mysqli_stmt_execute($stmt);
    } else {
        mysqli_query($con, "UPDATE board SET hit = $new_hit WHERE num = $num");
    }
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
                       }

                  echo "<img src='./data/$file_copied'><br><br><br>";
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




