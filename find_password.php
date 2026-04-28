<!DOCTYPE html>
<head>
<meta charset="utf-8">
<style>
h3 {
   padding-left: 5px;
   border-left: solid 5px #edbf07;
}
#close {
   margin:20px 0 0 80px;
   cursor:pointer;
}
</style>
</head>
<body>
<p>
<?php
   $id = $_POST["id"];
   $name = $_POST["name"];
   $address = $_POST["address"];


   require('db.php');


      $sql = "select * from members where id='$id' and name='$name' and address='$address'";
      $result = mysqli_query($con, $sql);
      $row    = mysqli_fetch_array($result);


      $num_record = mysqli_num_rows($result);

      if ($num_record)
      {
        $pass = $row["pass"];
         echo "
       	      <script>
               alert('?”ì²­?˜ì‹  ?„ì´?”ì˜ ë¹„ë?ë²ˆí˜¸??.$pass." ?…ë‹ˆ??');
       	          location.href = 'login_form.php';
       	      </script>
       	  ";

      }
      else
      {
         echo "
         <script>
          alert('ë¹„ë?ë²ˆí˜¸ë¥?ì°¾ì?ëª»í–ˆ?µë‹ˆ??');
             history.go(-1);
         </script>";
      }

      mysqli_close($con);

?>
</p>

</body>
</html>

