<?php
    require('db.php');

    $id   = mysqli_real_escape_string($con, $_POST["id"]);
    $pass = mysqli_real_escape_string($con, $_POST["pass"]);
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email1  = mysqli_real_escape_string($con, $_POST["email1"]);
    $email2  = mysqli_real_escape_string($con, $_POST["email2"]);
    $address  = mysqli_real_escape_string($con, $_POST["address"]);

    // Name must be 6 characters or less
    if (mb_strlen($name) > 6) {
        die("이름은 6자 미만로 입력해 주세요.");
    }

    $email = $email1."@".$email2;
    
    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("이메일 형식이 올바르지 않습니다.");
    }

    $regist_day = date("Y-m-d (H:i)");

    // 비밀번호 유효성 검사: 최소 10자리, 대소문자, 숫자, 특수문자를 포함하고 있는지 확인
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{10,}$/", $pass)) {
        die("비밀번호는 최소 10자리, 숫자 ,특수문자, 대소문자를 포함해야 합니다!");
    }
    
    $sql = "insert into members(id, pass, name, email, address, regist_day, level, point) ";
    $sql .= "values('$id', '$pass', '$name', '$email', '$address', '$regist_day', 1, 0)";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('SQL 쿼리 실행에 실패했습니다: ' . mysqli_error($con));
    }

    mysqli_close($con);

    echo "
          <script>
              location.href = 'index.php';
          </script>
      ";
?>
