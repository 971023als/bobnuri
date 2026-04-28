<?php
    require('db.php');
    $id = mysqli_real_escape_string($con, $_GET["id"]);

    $pass = mysqli_real_escape_string($con, $_POST["pass"]);
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email1  = mysqli_real_escape_string($con, $_POST["email1"]);
    $email2  = mysqli_real_escape_string($con, $_POST["email2"]);
    $address  = mysqli_real_escape_string($con, $_POST["address"]);

    $email = $email1."@".$email2;

    // 비밀번호 유효성 검사: 최소 8자리, 대소문자, 숫자, 특수문자를 포함하고 있는지 확인
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $pass)) {
        die("비밀번호는 최소 8자리, 특수문자, 대소문자를 포함해야 합니다!");
    }

    $sql = "update members set pass='$pass', name='$name' , email='$email', address='$address'";
    $sql .= " where id='$id'";
    mysqli_query($con, $sql);

    mysqli_close($con);

    echo "
          <script>
              location.href = 'index.php';
          </script>
      ";
?>


