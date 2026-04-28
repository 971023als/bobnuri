<?php
      $totalpoint = $_GET["totalpoint"];
      $count = $_GET["count"];
      $product_name = $_GET["product_name"];
 ?>
<script>
if(confirm("?•ë§ êµ¬ë§¤?˜ì‹œê² ìŠµ?ˆê¹Œ?\n???í’ˆ?€ êµí™˜/?˜ë¶ˆ??ë¶ˆê??©ë‹ˆ??")){
  location.href="point_mall_buy_05.php?totalpoint=<?=$totalpoint?>&count=<?=$count?>&product_name=<?=$product_name?>";
}else{
  location.href="point_mall_index.php";
}
</script>
