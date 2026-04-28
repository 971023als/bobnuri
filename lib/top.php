<?php
    require_once('security_config.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BoB누리 진흥공단</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/bar.css" type="text/css">
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
            <a href="index.php"><img src="img/bob.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
            <?php
    if(!$userid) {
?>     
            <a href="login_form.php"><i class="fa fa-user"></i> 로그인</a>
            <a href="member_form.php"><i class="fa fa-user"></i> 회원가입</a>
            <?php
    } else {
                $logged = $username."(".$userid.")님 [Level:".$userlevel.", Point:".$userpoint."]";
?>
                <span><?=$logged?></span>
                <a href="logout.php"><i class="fa fa-user"></i> 로그아웃</a>
                <a href="member_modify_form.php"><i class="fa fa-user"></i> 정보수정</a>
                <?php
    } 
?>
            </div>
        </div>
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
                <li><a href="#" style="color: #d63031;">보안 레벨 [Lv. <?php echo get_security_level(); ?>]</a>
                    <ul class="header__menu__dropdown">
                        <li>
                            <form action="change_security.php" method="post">
                                <select name="level" onchange="this.form.submit()" style="width: 100%; padding: 10px;">
                                    <option value="1" <?php if(get_security_level()==1) echo "selected"; ?>>Level 1</option>
                                    <option value="2" <?php if(get_security_level()==2) echo "selected"; ?>>Level 2</option>
                                    <option value="3" <?php if(get_security_level()==3) echo "selected"; ?>>Level 3</option>
                                    <option value="4" <?php if(get_security_level()==4) echo "selected"; ?>>Level 4</option>
                                    <option value="5" <?php if(get_security_level()==5) echo "selected"; ?>>Level 5</option>
                                </select>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
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
                            <div class="header__top__right__auth">
                            <?php
    if(!$userid) {
?>     
            <a href="login_form.php"><i class="fa fa-user"></i> 로그인</a>
            <a href="member_form.php"><i class="fa fa-user"></i> 회원가입</a>
            <?php
    } else {
                $logged = $username."(".$userid.")님 [Level:".$userlevel.", Point:".$userpoint."]";
?>
                <span><?=$logged?></span>
                <a href="logout.php"><i class="fa fa-user"></i> 로그아웃</a>
                <a href="member_modify_form.php"><i class="fa fa-user"></i> 정보수정</a>
                <?php
    } 
?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.php"><img src="img/bob.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="./index.php">Home</a></li>
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
                            <li><a href="#" style="color: #d63031;">보안 레벨 [Lv. <?php echo get_security_level(); ?>]</a>
                                <ul class="header__menu__dropdown" style="width: 200px;">
                                    <li>
                                        <form action="change_security.php" method="post" id="securityForm">
                                            <select name="level" onchange="this.form.submit()" style="width: 100%; padding: 10px; border: none; background: #f5f5f5;">
                                                <option value="1" <?php if(get_security_level()==1) echo "selected"; ?>>Level 1 (Beginner)</option>
                                                <option value="2" <?php if(get_security_level()==2) echo "selected"; ?>>Level 2 (Easy)</option>
                                                <option value="3" <?php if(get_security_level()==3) echo "selected"; ?>>Level 3 (Medium)</option>
                                                <option value="4" <?php if(get_security_level()==4) echo "selected"; ?>>Level 4 (Hard)</option>
                                                <option value="5" <?php if(get_security_level()==5) echo "selected"; ?>>Level 5 (Secure)</option>
                                            </select>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

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