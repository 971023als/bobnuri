<?php
session_start();
if (isset($_POST['level'])) {
    $_SESSION['security_level'] = (int)$_POST['level'];
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
