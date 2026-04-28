<!DOCTYPE html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
   require_once('security_config.php');
   require('db.php');

   $id = $_POST["id"] ?? "";
   $name = $_POST["name"] ?? "";
   $address = $_POST["address"] ?? "";

   $level = get_security_level();

   if ($level <= 1) {
       // Level 1: Vulnerable SQL
       $sql = "SELECT * FROM members WHERE id='$id' AND name='$name' AND address='$address'";
       $result = mysqli_query($con, $sql);
       $row = mysqli_fetch_array($result);
   } elseif ($level <= 3) {
       // Level 2/3: Escaping
       $id_esc = mysqli_real_escape_string($con, $id);
       $name_esc = mysqli_real_escape_string($con, $name);
       $addr_esc = mysqli_real_escape_string($con, $address);
       $sql = "SELECT * FROM members WHERE id='$id_esc' AND name='$name_esc' AND address='$addr_esc'";
       $result = mysqli_query($con, $sql);
       $row = mysqli_fetch_array($result);
   } else {
       // Level 4/5: Prepared
       $sql = "SELECT * FROM members WHERE id=? AND name=? AND address=?";
       $stmt = mysqli_prepare($con, $sql);
       mysqli_stmt_bind_param($stmt, "sss", $id, $name, $address);
       mysqli_stmt_execute($stmt);
       $result = mysqli_stmt_get_result($stmt);
       $row = mysqli_fetch_array($result);
   }

   if ($row) {
       $pass = $row["pass"];
       // In Level 4+, $pass is a hash, so it's "safe" to show (it's a mock site)
       // But in Level 5, we might want to say "Check your email" instead.
       if ($level >= 5) {
           $msg = "비밀번호 재설정 링크가 이메일로 발송되었습니다. (보안 레벨 5 모드)";
       } else {
           $msg = "요청하신 아이디의 비밀번호(또는 해시)는 [ ".$pass." ] 입니다.";
       }
       echo "
             <script>
               alert('$msg');
               location.href = 'login_form.php';
             </script>
         ";
   } else {
       echo "
       <script>
        alert('일치하는 회원 정보를 찾지 못했습니다.');
           history.go(-1);
       </script>";
   }

   mysqli_close($con);
?>
</body>
</html>
