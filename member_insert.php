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

// Name must be 6 characters or less
if (mb_strlen($name) > 6) {
    die("이름은 6자 이하로 입력해 주세요.");
}

$email = $email1."@".$email2;

// Check if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("이메일 형식이 올바르지 않습니다.");
}

$regist_day = date("Y-m-d (H:i)");

// Password hashing based on level
if ($level <= 2) {
    $pass_to_store = $pass;
} elseif ($level == 3) {
    $pass_to_store = md5($pass);
} else {
    // Level 4/5: Strong password policy and hashing
    if ($level >= 4 && !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{10,}$/", $pass)) {
        die("비밀번호는 최소 10자리, 대소문자, 숫자, 특수문자를 포함해야 합니다!");
    }
    $pass_to_store = password_hash($pass, PASSWORD_DEFAULT);
}

if ($level <= 1) {
    // Level 1: Vulnerable SQL
    $sql = "insert into members(id, pass, name, email, address, regist_day, level, point) ";
    $sql .= "values('$id', '$pass_to_store', '$name', '$email', '$address', '$regist_day', 1, 0)";
    $result = mysqli_query($con, $sql);
} elseif ($level <= 3) {
    // Level 2/3: Escaping
    $id = mysqli_real_escape_string($con, $id);
    $name = mysqli_real_escape_string($con, $name);
    $email = mysqli_real_escape_string($con, $email);
    $address = mysqli_real_escape_string($con, $address);
    
    $sql = "insert into members(id, pass, name, email, address, regist_day, level, point) ";
    $sql .= "values('$id', '$pass_to_store', '$name', '$email', '$address', '$regist_day', 1, 0)";
    $result = mysqli_query($con, $sql);
} else {
    // Level 4/5: Prepared Statements
    $sql = "insert into members(id, pass, name, email, address, regist_day, level, point) values(?, ?, ?, ?, ?, ?, 1, 0)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $id, $pass_to_store, $name, $email, $address, $regist_day);
    $result = mysqli_stmt_execute($stmt);
}

if (!$result) {
    die('회원가입에 실패했습니다: ' . mysqli_error($con));
}

mysqli_close($con);

echo "
      <script>
          location.href = 'index.php';
      </script>
  ";
?>
