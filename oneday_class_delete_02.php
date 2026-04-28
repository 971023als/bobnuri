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
                alert('관리자가아닙니다!');
                history.go(-1)
                </script>
    ");
            exit;
}

    $num   = $_GET["num"];
    $page   = $_GET["page"];

    require('db.php');
    $sql = "delete from oneday_class where num = $num";
    mysqli_query($con, $sql);
    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'oneday_class_index.php';
	     </script>
	   ";
?>
