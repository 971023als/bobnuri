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
</head>  
<section>
    </div>
   	<div id="board_box">
	    <h3 id="board_title">
	    		ë¯¼ì›?±ë¡ > ê¸€ ?°ê¸°
		</h3>
	    <form  name="board_form" method="post" action="./board_insert.php" enctype="multipart/form-data">
	    	 <ul id="board_form">
			 <li>
			        <span class="col1"> ì²¨ë? ?Œì¼</span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>
				<li>
					<span class="col1">?´ë¦„ : </span>
					<span class="col2"><?=$username?></span>
				</li>		
	    		<li>
	    			<span class="col1">?œëª© : </span>
	    			<span class="col2"><input name="subject" type="text"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">?´ìš© : </span>
	    			<span class="col2">
	    				<textarea name="content"style="height:130px;font-size:20px;"></textarea>
	    			</span>
	    		</li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">?„ë£Œ</button></li>
				<li><button type="button" onclick="location.href='./board_list.php'">ëª©ë¡</button></li>
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
<?php require('lib/bottom.php'); ?>
