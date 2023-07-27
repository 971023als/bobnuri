<h6 class="common_style">댓글 작성</h6>
<div id="comment_box" class="common_style">
<ul class='buttons common_style'>
    <form action="comments_insert.php" method="post">
        <input type="hidden" name="board_num" value="<?=$num?>">
        <input type="hidden" name="page" value="<?=$page?>">
        <textarea name="comment" id="comment" placeholder="내용"></textarea>
        <button class="button_style" type="submit" value="제출">제출</button> <!-- Modified line -->
    </form>
    </ul>
</div>


<h6 class="common_style">댓글 보기</h6>
<div id="comment_list" class="common_style">
    
<?php
// 세션에서 로그인된 사용자 이름 가져오기
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

    // 로그인된 사용자가 댓글 작성자와 동일한지 확인
    if ($loggedInUsername == $commentName) {
        // 동일한 사용자라면 수정 및 삭제 버튼을 보여준다.
        echo "
            <div class='buttons common_style' style='display: flex; justify-content: space-between; align-items: center;'>
                <p><strong>{$commentName}</strong> ({$commentRegistDay}): {$commentText} </p>
                <div>
                    <button class='editButton button_style' data-num='{$commentNum}' data-boardnum='{$num}' data-comment='{$commentText}'>수정</button>
                    <div id='editForm{$commentNum}' style='display:none;'>
                        <form action='comments_edit.php' method='post'>
                            <input type='hidden' name='nums' value='{$commentNum}'>
                            <input type='hidden' name='board_num' value='{$num}'>
                            <input type='hidden' name='page' value='{$page}'>
                            <textarea name='comment' id='comment'>{$commentText}</textarea>
                            <button class='button_style' type='submit' value='수정 확인'>수정 확인</button>
                        </form>
                    </div>
                    <button class='deleteButton button_style' onclick=\"location.href='comments_delete.php?nums={$commentNum}&num={$num}&page={$page}'\">삭제</button>
                </div>
            </div>
        ";
    } else {
        // 동일한 사용자가 아니라면 수정 및 삭제 버튼을 보여주지 않는다.
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
    
    // '수정 확인' 버튼 클릭 시 '수정' 버튼 다시 보이게 하는 코드
    $(document).on('click', "button[value='수정 확인']", function() {
        var commentNum = $(this).closest('form').find("input[name='nums']").val(); // get commentNum from hidden input field
        $('button[data-num=' + commentNum + ']').show();
    });

});
</script>







