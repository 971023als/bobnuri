<?php
    try {
        $num = filter_input(INPUT_GET, 'num', FILTER_VALIDATE_INT);

        require('db.php');

        $stmt = $con->prepare("SELECT * FROM oneday_class WHERE num = ?");
        $stmt->bind_param("i", $num);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $num          = $row["num"];
            $product_name = htmlspecialchars($row["product_name"]);
            $point        = htmlspecialchars($row["point"]);
            $file_name    = $row["file_name"];
            $file_type    = $row["file_type"];
            $file_copied  = $row["file_copied"];
        } else {
            throw new Exception("No rows returned from the database");
        }

        $stmt->close();
        $con->close();
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
?>

<!-- ...the rest of your HTML and PHP code... -->

<?php 
    require('lib/top.php'); 
    require('lib/copy.php'); 
?>

<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" href="./css/bootstrap.min.css">
<link rel="stylesheet" href="./css/bar.css">

<?php
    if (!$userid) {
        echo("<script>
            alert('Î°úÍ∑∏?????¥Ïö©?¥Ï£º?∏Ïöî!');
            history.go(-1);
            </script>"
        );
        exit;
    }
?>
  <center>
    <form name="wantbasket" method="post" action="oneday_class_buy_02.php">
      <input type="hidden" name="num" value="<?=$num?>">
      <table border="0" cellspacing="50" cellpadding="10">
        <tr>
          <td> <?php
               if($file_name) {
                $real_name = $file_copied;
                $file_path = "./data/".$real_name;
                $file_size = filesize($file_path);
            
                if(file_exists($file_path)) {
                    echo "<img src='./data/$real_name' alt='Attached Image'><br><br><br>";
                } else {
                    echo "?¥Î?ÏßÄÎ•?Ï∞æÏùÑ ???ÜÏäµ?àÎã§.<br><br><br>";
                }
            }
            
            ?>
            </td>
          <td><b><?=$product_name?></b><br><br>
                  <?=number_format($point)?>P<br><br>
                  <select name="count">
                    <option value="1">1</option>
                    <script type="text/javascript">
                    for(var i = 2; i < 11; i++){
                      document.write("<option value="+i+">"+i+"</option>");
                    }
                    </script>
                    </select><br><br>

                <input type="submit" value="Íµ¨Îß§?òÍ∏∞"><br><br>
                  </tr>
                  <tr>
        <button type="button" onclick="location.href='oneday_class_index.php'"><b>Î™©Î°ù?ºÎ°ú</b></button>
        </tr>
        <?php
            if ($userlevel == 100) {
                $num = $_GET["num"] ?? "";
                $page = $_GET["page"] ?? "";
        ?>
        <tr>
        <button type="button" onclick="location.href='oneday_class_modify_form.php?num=<?=$num?>'"><b>?òÏ†ï</b></button> 
        </tr>
        <tr>
        <button type="button" onclick="location.href='oneday_class_delete.php?num=<?=$num?>'"><b>??†ú</b></button>  
        </tr>
        <tr>
        <button type="button" onclick="location.href='oneday_class_insert_form.php'"><b>Ï∂îÍ?</b></button>
        </tr>
        <?php
            }
        ?>
    </div> <!-- Closing the div here -->
                      
                  </tr>
                </table><br><br>
              </form>
            </center>
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <?php require('lib/bottom.php'); ?>
