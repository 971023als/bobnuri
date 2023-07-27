<?php
    $id   = $_POST["id"];
    $pass = $_POST["pass"];

    require('db.php');
    $stmt = $con->prepare("SELECT * FROM members WHERE id = ?");
    $stmt->bind_param("s", $id); // 's' specifies the variable type => 'string'

    $stmt->execute();

    $result = $stmt->get_result();
    $num_match = $result->num_rows;
 
    if(!$num_match)
    {
        echo("
            <script>
              window.alert('등록되지 않은 아이디입니다!')
              history.go(-1)
            </script>
        ");
    }
    else
    {
        $row = $result->fetch_assoc();
        $db_pass = $row["pass"];
 
        mysqli_close($con);
 
        if($pass != $db_pass)
        {
            echo("
               <script>
                 window.alert('비밀번호가 틀립니다!')
                 history.go(-1)
               </script>
            ");
            exit;
        }
        else
        {
            session_start();
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $row["name"];
            $_SESSION["userlevel"] = $row["level"];
            $_SESSION["userpoint"] = $row["point"];
 
            echo("
              <script>
                location.href = 'index.php';
              </script>
            ");
        }
    }
?>



