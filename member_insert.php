<?php
require('security_config.php');
require('db.php');

$id = $_POST["id"];
$pass = $_POST["pass"];
$name = $_POST["name"];
$email1 = $_POST["email1"];
$email2 = $_POST["email2"];
$address = $_POST["address"];

$level = get_security_level();

if (mb_strlen($name) > 6) die("Name too long");
$email = $email1."@".$email2;
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) die("Invalid email");
$regist_day = date("Y-m-d (H:i)");

if ($level <= 2) {
    $pass_to_store = $pass;
} elseif ($level == 3) {
    $pass_to_store = md5($pass);
} else {
    if ($level >= 4 && !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{10,}$/", $pass)) {
        die("Password too weak");
    }
    $pass_to_store = password_hash($pass, PASSWORD_DEFAULT);
}

if ($level <= 1) {
    $sql = "insert into members(id, pass, name, email, address, regist_day, level, point) values('$id', '$pass_to_store', '$name', '$email', '$address', '$regist_day', 1, 0)";
    $result = mysqli_query($con, $sql);
} elseif ($level <= 3) {
    $id = mysqli_real_escape_string($con, $id);
    $name = mysqli_real_escape_string($con, $name);
    $email = mysqli_real_escape_string($con, $email);
    $address = mysqli_real_escape_string($con, $address);
    $sql = "insert into members(id, pass, name, email, address, regist_day, level, point) values('$id', '$pass_to_store', '$name', '$email', '$address', '$regist_day', 1, 0)";
    $result = mysqli_query($con, $sql);
} else {
    $sql = "insert into members(id, pass, name, email, address, regist_day, level, point) values(?, ?, ?, ?, ?, ?, 1, 0)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $id, $pass_to_store, $name, $email, $address, $regist_day);
    $result = mysqli_stmt_execute($stmt);
}

if (!$result) die("Insert failed: " . mysqli_error($con));
mysqli_close($con);
echo "<script>location.href = 'index.php';</script>";
?>
