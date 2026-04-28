<?php require('lib/top.php'); ?>
<?php require('lib/copy.php'); ?>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/member.css">
<link rel="stylesheet" href="./css/bootstrap.min.css">
<link rel="stylesheet" href="./css/bar.css">
<script>
function check_user()
{
   if (!document.find_password_form.id.value)
   {
       alert("?ÑÏù¥?îÎ? ?ÖÎ†•?òÏÑ∏??");
       document.find_password_form.id.focus();
       return;
   }

   if (!document.find_password_form.name.value)
   {
       alert("?¥Î¶Ñ???ÖÎ†•?òÏÑ∏??");
       document.find_password_form.name.focus();
       return;
   }

   if (!document.find_password_form.address.value)
   {
       alert("Ï£ºÏÜåÎ•??ÖÎ†•?òÏÑ∏??");
       document.find_password_form.address.focus();
       return;
   }



   document.find_password_form.submit();
}

function reset_all()
{
   document.find_password_form.id.value = "";
   document.find_password_form.name.value = "";
   document.find_password_form.address.value = "";

   document.find_password_form.id.focus();

   return;
}


</script>
<body>
	
	<section>
        <div id="main_content">
      		<div id="join_box">
          	<form  name="find_password_form" method="post" action="find_password.php">
			    <h2>ÎπÑÎ?Î≤àÌò∏ Ï∞æÍ∏∞</h2>
    		    	<div class="form id">
				        <div class="col1">?ÑÏù¥??/div>
				        <div class="col2"><input type="text" name="id" value="">
				        </div>
			       	</div>

			       	<div class="form">
				        <div class="col1">?¥Î¶Ñ</div>
				        <div class="col2">
							<input type="text" name="name" value="">
				        </div>
			       	</div>

							<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">Ï£ºÏÜå</div>
				        <div class="col2">
							<input type="text" name="address" value="">
				        </div>
			       	</div>
			       	<div class="clear"></div>
			       	<div class="bottom_line"> </div>
			       	<div class="buttons">
	                	<input type="button" value="Ï∞æÏïÑÎ≥¥Í∏∞" onclick="check_user()">&nbsp;
                  		<input type="button" value="Ï∑®ÏÜå?òÍ∏∞" onclick="reset_all()">
	           		</div>
           	</form>
        	</div>
        </div>
	</section>
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<?php require('lib/bottom.php'); ?>
