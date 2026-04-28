<?php
      $totalpoint = $_GET["totalpoint"];
      $count = $_GET["count"];
      $product_name = $_GET["product_name"];
 ?>
<script>
if(confirm("정말 구매하시겠습니까?\n위 상품은 교환/환불이 불가합니다.")){
  location.href="point_mall_buy_05.php?totalpoint=<?=$totalpoint?>&count=<?=$count?>&product_name=<?=$product_name?>";
}else{
  location.href="point_mall_index.php";
}
</script>
