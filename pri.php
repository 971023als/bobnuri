<?php require('lib/top.php'); ?>
<?php require('lib/copy.php'); ?> 
<!-- 이 위치에 2024_04_19 파일의 내용이 삽입됩니다. -->
<form action="" method="post">
    <button type="submit" name="content" value="content1">2023_07_17</button>
    <button type="submit" name="content" value="content2">2024_04_19</button>
</form>

<?php
if (isset($_POST['content'])) {
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
    if ($content == 'content1') {
        include('2023_07_17.html');
    } elseif ($content == 'content2') {
        include('2024_04_19.html');
    }
} else {
    // 기본 페이지 로드 시 기본 파일 포함
    include('2024_04_19.html');
}
?>
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php require('lib/bottom.php'); ?>

