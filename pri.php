<?php require('lib/top.php'); ?>
<?php require('lib/copy.php'); ?> 
<!-- ???„ì¹˜??2024_04_19 ?Œì¼???´ìš©???½ìž…?©ë‹ˆ?? -->
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
    // ê¸°ë³¸ ?˜ì´ì§€ ë¡œë“œ ??ê¸°ë³¸ ?Œì¼ ?¬í•¨
    include('2024_04_19.html');
}
?>
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php require('lib/bottom.php'); ?>

