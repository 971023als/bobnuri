<?php
    require('db.php');
    $id = mysqli_real_escape_string($con, $_GET["id"]);

    $pass = mysqli_real_escape_string($con, $_POST["pass"]);
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email1  = mysqli_real_escape_string($con, $_POST["email1"]);
    $email2  = mysqli_real_escape_string($con, $_POST["email2"]);
    $address  = mysqli_real_escape_string($con, $_POST["address"]);

    $email = $email1."@".$email2;

    // ë¹„ë?ë²ˆí˜¸ ? íš¨??ê²€?? ìµœì†Œ 8?ë¦¬, ?€?Œë¬¸?? ?«ìž, ?¹ìˆ˜ë¬¸ìžë¥??¬í•¨?˜ê³  ?ˆëŠ”ì§€ ?•ì¸
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $pass)) {
        die("ë¹„ë?ë²ˆí˜¸??ìµœì†Œ 8?ë¦¬, ?¹ìˆ˜ë¬¸ìž, ?€?Œë¬¸?ë? ?¬í•¨?´ì•¼ ?©ë‹ˆ??");
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


