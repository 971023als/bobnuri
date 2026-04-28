<?php
    // ensure $page is an integer and is not less than 1
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $page = $page > 0 ? $page : 1;

    require('db.php');

    $sql = "SELECT * FROM oneday_class ORDER BY num DESC";
    $result = mysqli_query($con, $sql);
    $total_record = mysqli_num_rows($result);

    $scale = 16;

    $total_page = (int)($total_record / $scale);
    if ($total_record % $scale !== 0)
        $total_page++;

    $start = ($page - 1) * $scale;

?>
<center>
    <table border="0" cellspacing="15" cellpadding="15">
        <?php
            $number = $total_record - $start;

            for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
            {
                mysqli_data_seek($result, $i);

                $row = mysqli_fetch_array($result);

                $num            = $row["num"];
                $product_name   = htmlspecialchars($row["product_name"], ENT_QUOTES);
                $point          = htmlspecialchars($row["point"], ENT_QUOTES);
                $file_copied    = htmlspecialchars($row["file_copied"], ENT_QUOTES);
        ?>

        <td style="text-align:center;">
            <a href="oneday_class_buy.php?num=<?= $num ?>">
            <img src="./data/<?= $file_copied ?>" width="200px" height="200px"><br>
            <?= $product_name ?><br>
            <?= number_format($point) ?>P
            </td>
            <?php
                if(($i+1)%4==0){
            ?>
            <tr></tr>
            <?php
                }
            ?>

        <?php
            $number--;
            }
        ?>
    </table>
</center>
<?php
    mysqli_close($con);
?>

<ul id="page_num" >
<?php
    if ($total_page>=2 && $page >= 2)
    {
        $new_page = $page-1;
        echo "<li><a href='oneday_class_index.php?page=$new_page'>◀ 이전</a> </li>";
    }
    else
        echo "<li>&nbsp;</li>";

    for ($i=1; $i<=$total_page; $i++)
    {
        if ($page == $i)
        {
            echo "<li><b> $i </b></li>";
        }
        else
        {
            echo "<li><a href='oneday_class_index.php?page=$i'> $i </a><li>";
        }
    }
    if ($total_page>=2 && $page != $total_page)
    {
        $new_page = $page+1;
        echo "<li> <a href='oneday_class_index.php?page=$new_page'>다음 ▶</a> </li>";
    }
    else
        echo "<li>&nbsp;</li>";
?>
</ul>

