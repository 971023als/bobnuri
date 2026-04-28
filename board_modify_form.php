<?php require('lib/top.php'); ?>
<?php require('lib/copy.php'); ?>
<link rel="stylesheet" type="text/css" href="./css/board.css">
<?php
if ( !$userid )
    {
        echo("
                    <script>
                    alert('ê²Œì‹œ??ê¸€?°ê¸°??ë¡œê·¸?????´ìš©??ì£¼ì„¸??');
                    history.go(-1)
                    </script>
        ");
                exit;
    }
	?>
<script>
  function check_input() {
      if (!document.board_form.subject.value)
      {
          alert("?œëª©???…ë ¥?˜ì„¸??");
          document.board_form.subject.focus();
          return;
      }
      if (!document.board_form.content.value)
      {
          alert("?´ìš©???…ë ¥?˜ì„¸??");    
          document.board_form.content.focus();
          return;
      }
      document.board_form.submit();
   }
</script>  
<section>
	
   	<div id="board_box">
	    <h3 id="board_title">
	    		ë¯¼ì› > ê¸€ ë³€ê²?
		</h3>
<?php
	$num  = $_GET["num"];
	$page = $_GET["page"];
	
	require('db.php');
	$sql = "select * from board where num=$num";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$name       = $row["name"];
	$subject    = $row["subject"];
	$content    = $row["content"];		
?>
	    <form  name="board_form" method="post" action="board_modify.php?num=<?=$num?>&page=<?=$page?>" enctype="multipart/form-data">
	    	 <ul id="board_form">
			 <li>
			        <span class="col1"> ì²¨ë? ?Œì¼ : </span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>
				<li>
					<span class="col1">?´ë¦„ : </span>
					<span class="col2"><?=$name?></span>
				</li>		
	    		<li>
	    			<span class="col1">?œëª© : </span>
	    			<span class="col2"><input name="subject" type="text" value="<?=$subject?>"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">?´ìš© : </span>
	    			<span class="col2">
	    				<textarea name="content"style="height:130px;font-size:15px;"><?=$content?></textarea>
	    			</span>
	    		</li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">?˜ì •?˜ê¸°</button></li>
				<li><button type="button" onclick="location.href='board_list.php'">ëª©ë¡</button></li>
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
<?php require('lib/bottom.php'); ?>