<?php
    require_once('security_config.php');
    require('db.php');

    $id = $_GET["id"] ?? "";
    $pass = $_POST["pass"] ?? "";
    $name = $_POST["name"] ?? "";
    $email1 = $_POST["email1"] ?? "";
    $email2 = $_POST["email2"] ?? "";
    $address = $_POST["address"] ?? "";

    $level = get_security_level();
    $email = $email1."@".$email2;

    // Password policy and hashing based on level
    if ($level >= 4) {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $pass)) {
            die("비밀번호는 최소 8자리, 특수문자, 대소문자를 포함해야 합니다!");
        }
        $pass_to_store = password_hash($pass, PASSWORD_DEFAULT);
    } elseif ($level == 3) {
        $pass_to_store = md5($pass);
    } else {
        $pass_to_store = $pass;
    }

    if ($level <= 1) {
        // Level 1: Vulnerable SQL
        $sql = "UPDATE members SET pass='$pass_to_store', name='$name', email='$email', address='$address' WHERE id='$id'";
        mysqli_query($con, $sql);
    } elseif ($level <= 3) {
        // Level 2/3: Escaping
        $id_esc = mysqli_real_escape_string($con, $id);
        $name_esc = mysqli_real_escape_string($con, $name);
        $email_esc = mysqli_real_escape_string($con, $email);
        $address_esc = mysqli_real_escape_string($con, $address);
        $sql = "UPDATE members SET pass='$pass_to_store', name='$name_esc', email='$email_esc', address='$address_esc' WHERE id='$id_esc'";
        mysqli_query($con, $sql);
    } else {
        // Level 4/5: Prepared
        $sql = "UPDATE members SET pass=?, name=?, email=?, address=? WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $pass_to_store, $name, $email, $address, $id);
        mysqli_stmt_execute($stmt);
    }

    mysqli_close($con);

    echo "
          <script>
              location.href = 'index.php';
          </script>
      ";
?>
