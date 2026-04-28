<meta charset='utf-8'>
<?php

session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";

    if ( $userlevel != 100 )
    {
        echo("
                    <script>
                    alert('관리자가?�닙?�다!');
                    history.go(-1)
                    </script>
        ");
                exit;
    }
	$num = $_GET["num"];
	$page = $_GET["page"];
?>
<Script type="text/javascript">
function delete_confirm(){
	answer = confirm("물건????��?�시겠습?�까?");
	if (answer){
		location.href='point_mall_delete_02.php?num=<?=$num?>&page=<?=$page?>';
	}
	else{
		history.back();
	}
}
</script>
<body onload="delete_confirm()">
</body>
