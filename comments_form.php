<h6 class="common_style">?“ê? ?‘ì„±</h6>
<div id="comment_box" class="common_style">
<ul class='buttons common_style'>
    <form action="comments_insert.php" method="post">
        <input type="hidden" name="board_num" value="<?=$num?>">
        <input type="hidden" name="page" value="<?=$page?>">
        <textarea name="comment" id="comment" placeholder="?´ìš©"></textarea>
        <button class="button_style" type="submit" value="?œì¶œ">?œì¶œ</button> <!-- Modified line -->
    </form>
    </ul>
</div>


<h6 class="common_style">?“ê? ë³´ê¸°</h6>
<div id="comment_list" class="common_style">
    
<?php
// ?¸ì…˜?ì„œ ë¡œê·¸?¸ëœ ?¬ìš©???´ë¦„ ê°€?¸ì˜¤ê¸?
session_start();
$loggedInUsername = $_SESSION['username'];

$stmt = $con->prepare("SELECT * FROM comments WHERE board_num = ? ORDER BY regist_day DESC");
$stmt->bind_param('i', $num);
$stmt->execute();
$commentResult = $stmt->get_result();
while($commentRow = $commentResult->fetch_assoc()) {
    $commentNum = $commentRow['nums'];
    $commentName = $commentRow['post_name'];
    $commentText = $commentRow['comment'];
    $commentRegistDay = $commentRow['regist_day'];
    
    $page = isset($_GET['page']) ? $_GET['page'] : 1;  

    // ë¡œê·¸?¸ëœ ?¬ìš©?ê? ?“ê? ?‘ì„±?ì? ?™ì¼?œì? ?•ì¸
    if ($loggedInUsername == $commentName) {
        // ?™ì¼???¬ìš©?ë¼ë©??˜ì • ë°??? œ ë²„íŠ¼??ë³´ì—¬ì¤€??
        echo "
            <div class='buttons common_style' style='display: flex; justify-content: space-between; align-items: center;'>
                <p><strong>{$commentName}</strong> ({$commentRegistDay}): {$commentText} </p>
                <div>
                    <button class='editButton button_style' data-num='{$commentNum}' data-boardnum='{$num}' data-comment='{$commentText}'>?˜ì •</button>
                    <div id='editForm{$commentNum}' style='display:none;'>
                        <form action='comments_edit.php' method='post'>
                            <input type='hidden' name='nums' value='{$commentNum}'>
                            <input type='hidden' name='board_num' value='{$num}'>
                            <input type='hidden' name='page' value='{$page}'>
                            <textarea name='comment' id='comment'>{$commentText}</textarea>
                            <button class='button_style' type='submit' value='?˜ì • ?•ì¸'>?˜ì • ?•ì¸</button>
                        </form>
                    </div>
                    <button class='deleteButton button_style' onclick=\"location.href='comments_delete.php?nums={$commentNum}&num={$num}&page={$page}'\">?? œ</button>
                </div>
            </div>
        ";
    } else {
        // ?™ì¼???¬ìš©?ê? ?„ë‹ˆ?¼ë©´ ?˜ì • ë°??? œ ë²„íŠ¼??ë³´ì—¬ì£¼ì? ?ŠëŠ”??
        echo "
            <div class='buttons common_style' style='display: flex; justify-content: space-between; align-items: center;'>
                <p><strong>{$commentName}</strong> ({$commentRegistDay}): {$commentText} </p>
            </div>
        ";
    }
}

?>


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.editButton').on('click', function() {
        var commentNum = $(this).data('num');
        $(this).hide(); 
        $('#editForm' + commentNum).toggle(); 
    });
    
    // '?˜ì • ?•ì¸' ë²„íŠ¼ ?´ë¦­ ??'?˜ì •' ë²„íŠ¼ ?¤ì‹œ ë³´ì´ê²??˜ëŠ” ì½”ë“œ
    $(document).on('click', "button[value='?˜ì • ?•ì¸']", function() {
        var commentNum = $(this).closest('form').find("input[name='nums']").val(); // get commentNum from hidden input field
        $('button[data-num=' + commentNum + ']').show();
    });

});
</script>







