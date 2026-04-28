<!DOCTYPE html>
<head>
<meta charset="utf-8">
<style>
h3 { padding-left: 5px; border-left: solid 5px #edbf07; }
#close { margin:20px 0 0 80px; cursor:pointer; }
</style>
</head>
<body>
<h3>아이디 중복체크</h3>
<p>
<?php
   require_once('security_config.php');
   $id = $_GET["id"] ?? "";

   if(!$id) {
      echo("<li>아이디를 입력해 주세요!</li>");
   } else {
      require('db.php');
      $level = get_security_level();

      if ($level <= 1) {
          // Level 1: Vulnerable SQL and XSS
          $sql = "SELECT * FROM members WHERE id='$id'";
          $result = mysqli_query($con, $sql);
          $display_id = $id;
      } elseif ($level <= 3) {
          // Level 2/3: Escaping
          $id_esc = mysqli_real_escape_string($con, $id);
          $sql = "SELECT * FROM members WHERE id='$id_esc'";
          $result = mysqli_query($con, $sql);
          $display_id = $id;
      } else {
          // Level 4/5: Prepared and XSS protection
          $sql = "SELECT * FROM members WHERE id=?";
          $stmt = mysqli_prepare($con, $sql);
          mysqli_stmt_bind_param($stmt, "s", $id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $display_id = xss_check($id);
      }

      $num_record = mysqli_num_rows($result);

      if ($num_record) {
         echo "<li>".$display_id." 아이디는 중복됩니다.</li>";
         echo "<li>다른 아이디를 사용해 주세요!</li>";
      } else {
         echo "<li>".$display_id." 아이디는 사용 가능합니다.</li>";
      }
      mysqli_close($con);
   }
?>
</p>
<div id="close">
   <button type="button" onclick="self.close()">닫기</button>
</div>
</body>
</html>
