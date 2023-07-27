<?php
    require('db.php');

    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $email1 = filter_input(INPUT_POST, "email1", FILTER_SANITIZE_EMAIL);
    $email2 = filter_input(INPUT_POST, "email2", FILTER_SANITIZE_EMAIL);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
    $email = $email1 . "@" . $email2;

    // 비밀번호 해싱
    $pass_hash = password_hash($pass, PASSWORD_BCRYPT);

    $stmt = $con->prepare("INSERT INTO members(id, pass, name, email, address, regist_day, level, point) VALUES (?, ?, ?, ?, ?, NOW(), 1, 0)");
    $stmt->bind_param("sssss", $id, $pass_hash, $name, $email, $address);

    $stmt->execute();

    mysqli_close($con);

    echo "
          <script>
              location.href = 'index.php';
          </script>
      ";
?>







