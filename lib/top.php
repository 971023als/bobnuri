<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";
    if (isset($_SESSION["userpoint"])) $userpoint = $_SESSION["userpoint"];
    else $userpoint = "";
?>		
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><a href="index.php">BoB누리 진흥공단</a></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/sub.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <link rel="stylesheet" type="text/css" href="css/message.css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/bob.png"></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
            <p><a href="pri.php" ></i>개인정보처리방침</a></p>
            </ul>
        </div>
                  
        <?php

    $logged = ""; // $logged 변수 초기화    

    if(!$userid) {
?>     
            <div class="header__top__right__language">
                <i class="arrow_carrot-down"><a href="/member_form.php"></i> 회원가입</a>
            </div>
            <div class="header__top__right__auth">
                <i class="fa fa-user"><a href="/login_form.php"></i> 로그인</a>
                <i class="fa fa-user"><a href="/logout.php" ></i>로그아웃</a>
               </div>
            <?php
    } else {
                $logged = $username."(".$userid.")님[Level:".$userlevel.", Point:".$userpoint."]";
    }
?>
                        <li><a><?=$logged?></a> </li>
                          <li><a href="logout.php">로그아웃</a> </li>
                          <li><a href="member_modify_form.php">정보 수정</a></li>
<?php
	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;

        require('db.php');

        // Set the character set to UTF-8
        mysqli_set_charset($con, "utf8");
	$sql = "select * from board order by num desc";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수

	$scale = 10;

	// 전체 페이지 수($total_page) 계산 
	if ($total_record % $scale == 0)     
		$total_page = floor($total_record/$scale);      
	else
		$total_page = floor($total_record/$scale) + 1; 
 
	// 표시할 페이지($page)에 따라 $start 계산  
	$start = ($page - 1) * $scale;      

	$number = $total_record - $start;

   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
   {
      mysqli_data_seek($result, $i);
      // 가져올 레코드로 위치(포인터) 이동
      $row = mysqli_fetch_array($result);
      // 하나의 레코드 가져오기
	  $num         = $row["num"];
	  $id          = $row["id"];
	  $name        = $row["name"];
	  $subject     = $row["subject"];
      $regist_day  = $row["regist_day"];
      $hit         = $row["hit"];
      if ($row["file_name"])
      	$file_image = "<img src='/img/file.gif'>";
      else
      	$file_image = " ";
?>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="order_list.php">주문현황</a></li>
                <li><a href="bobnuri.php">조직도</a></li>
                <li><a href="message_form.php">메시지</a></li>
                <li><a href="#">서비스</a>
                    <ul class="header__menu__dropdown">
                                    <li><a href="board_form.php">민원등록</a></li>
                                    <li><a href="board_list.php">민원목록</a></li>
                                    <li><a href="oneday_class_index.php">원데이클래스</a></li>
                                    <li><a href="point_mall_index.php">상품권</a></li>
                    </ul>
                </li>
            </ul>
            <?php
   	   $number--;
   }
   mysqli_close($con);

?>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> BoBnuri@BoBnuri.ac.kr</li>
                <li>BoB누리 진흥공단</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> BoBnuri@BoBnuri.ac.kr</li>
                                <li>BoB누리 진흥공단</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>         
                            <?php
    if(!$userid) {
?>     
            <li><a href="/member_form.php"></i> 회원가입</a>
            <li><a href="/login_form.php"></i> 로그인</a></li>
            <?php
    } else {
                $logged = $username."(".$userid.")님[Level:".$userlevel.", Point:".$userpoint."]";
?>
                <li><?=$logged?></li>
                <li><a href="logout.php" ></i>로그아웃</a></li>
                <li><a href="member_modify_form.php" ></i>정보수정</a></li>
                <?php
    } 
?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="/index.php"><img src="img/bob.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="/index.php">Home</a></li>
                            <li><a href="blog.php">인사말</a></li>
                            <li><a href="bobnuri.php">조직도</a></li>
                            <li><a href="message_form.php">메시지</a></li>
                            <li><a href="#">서비스</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="board_form.php">민원등록</a></li>
                                    <li><a href="board_list.php">민원목록</a></li>
                                    <li><a href="oneday_class_index.php">원데이클래스</a></li>
                                    <li><a href="point_mall_index.php">상품권</a></li>
                                </ul>
                            </li>
                        </ul>
                        
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                        <p><a href="pri.php" ></i>개인정보처리방침</a></p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
        <!--
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="/index.php"><img src="img/bob.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="/index.php">Home</a></li>
                            <li><a href="blog.php">인사말</a></li>
                            <li><a href="bobnuri.php">조직도</a></li>
                            <li><a href="message_form.php">메시지</a></li>
                            <li><a href="#">서비스</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="board_form.php">민원등록</a></li>
                                    <li><a href="board_list.php">민원목록</a></li>
                                    <li><a href="oneday_class_index.php">원데이클래스</a></li>
                                    <li><a href="point_mall_index.php">상품권</a></li>
                                </ul>
                            </li>
                        </ul>
                        
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                        <p><a href="pri.php" ></i>개인정보처리방침</a></p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    !-->
    
    <!-- 로고 및 검색창 !-->


    <!-- 메인 test
    <div id="main_visual" class="mainItem type1">

        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__container">
                        <div class="header__logo">
                            <a href="/test/index.php"><img src="img/bob.png" alt=""></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero__search__form">
                        <form name="search" action="/search_main.php" text-align="center" method="post">
                            <div class="hero__search__categories">
                                제목
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" name="search" placeholder="필요한 거 검색!!">
                            <button type="submit" name="tool" class="site-btn">검색</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    !-->

    <div class="boblogo">
        
    </div>

    <hr class="hz" style="height: 2px;">

    <div class="menu">
        <div class="button1">
            <button type="button" onclick="location.href='point_mall_index.php'"><b>상품권</b></button>
        </div>
        <div class="button2">
            <button type="button" onclick="location.href='oneday_class_index.php'"><b>원데이클래스</b></button>
        </div>
        <div class="button3">
            <button type="button" onclick="location.href='message_form.php'"><b>문의</b></button>
        </div>
        <div class="button4">
            <button type="button" onclick="location.href='bobnuri.php'"><b>조직도</b></button>
        </div>
        <div class="button5">
            <button type="button" onclick="location.href='blog.php'"><b>공단소개</b></button>
        </div>
    </div>

    <div class="main">
        <div class="image">
        </div>
    </div>
    <hr>   

    <!-- Header Section End -->