<?php
require('security_config.php');
require('db.php');
$id = $_POST["id"];
$pass = $_POST["pass"];
$level = get_security_level();
if ($level <= 1) {
    $sql = "select * from members where id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if ($row && $pass != $row["pass"]) $row = null;
} elseif ($level == 2) {
    $id = mysqli_real_escape_string($con, $id);
    $sql = "select * from members where id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if ($row && $pass != $row["pass"]) $row = null;
} elseif ($level == 3) {
    $id = mysqli_real_escape_string($con, $id);
    $sql = "select * from members where id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if ($row && md5($pass) != $row["pass"] && $pass != $row["pass"]) $row = null;
} else {
    $sql = "select * from members where id=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if ($row) {
        if (!password_verify($pass, $row["pass"]) && md5($pass) != $row["pass"] && $pass != $row["pass"]) {
            $row = null;
        }
    }
}
if (!$row) {
    echo("<script>alert('Login failed'); history.go(-1);</script>");
    exit;
}
session_start();
$_SESSION["userid"] = $row["id"];
$_SESSION["username"] = xss_check($row["name"]);
$_SESSION["userlevel"] = $row["level"];
$_SESSION["userpoint"] = $row["point"];
mysqli_close($con);
echo("<script>location.href = 'index.php';</script>");
?>
