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
    <title>BoB??리 진흥공단</title>

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
        <?php

    $logged = ""; // $logged 변??초기??   

    if(!$userid) {
?>     
            <div class="header__top__right__language">
                <a href="/member_form.php"><i class="arrow_carrot-down"></i> ??원가??/a>
            </div>
            <div class="header__top__right__auth">
                <a href="/login_form.php"><i class="fa fa-user"></i> 로그??/a>
                <a href="/logout.php"><i class="fa fa-user"></i> 로그??웃</a>
            </div>
            <?php
    } else {
                $logged = $username."(".$userid.")??Level:".$userlevel.", Point:".$userpoint."]";
    }
?>
                        <li><a><?=$logged?></a> </li>
                          <li><a href="logout.php">로그??웃</a> </li>
                          <li><a href="member_modify_form.php">??보 ??정</a></li>
                          <li><a href="pri.php" ></i>개인??보처리방침</a></li>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="order_list.php">주문??황</a></li>
                <li><a href="bobnuri.php">조직??/a></li>
                <li><a href="message_form.php">메시지</a></li>
                <li><a href="#">??비??/a>
                    <ul class="header__menu__dropdown">
                                    <li><a href="board_form.php">민원??록</a></li>
                                    <li><a href="board_list.php">민원목록</a></li>
                                    <li><a href="oneday_class_index.php">??데??클??스</a></li>
                                    <li><a href="point_mall_index.php">??품??/a></li>
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
                <li>BoB??리 진흥공단</li>
            </ul>
            <div class="header__container">
                    <div class="header__logo">
                        <a href="/test/index.php"><img src="img/bob.png" alt=""></a>
                    </div>
            </div>
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
                                <li>BoB??리 진흥공단</li>
                            </ul>
                            <div class="header__container">
                                 <div class="header__logo">
                                    <a href="/test/index.php"><img src="img/bob.png" alt=""></a>
                                </div>
                            </div>
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
            <li><a href="/member_form.php">??원가??/a></li>
            <li><a href="/login_form.php">로그??/a></li>
            <li><a href="pri.php">개인??보처리방침</a></li>
            <?php
    } else {
                $logged = $username."(".$userid.")??[Level: ".$userlevel.", Point: ".$userpoint."]";
?>
                <li><?=$logged?></li>
                <li><a href="logout.php">로그??웃</a></li>
                <li><a href="member_modify_form.php">??보??정</a></li>
                <li><a href="pri.php">개인??보처리방침</a></li>
                <?php
    } 
?>
                    </div>
                </div>
            </div>
        </div>
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
                            <li><a href="blog.php">??사??/a></li>
                            <li><a href="bobnuri.php">조직??/a></li>
                            <li><a href="message_form.php">메시지</a></li>
                            <li><a href="#">??비??/a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="board_form.php">민원??록</a></li>
                                    <li><a href="board_list.php">민원목록</a></li>
                                    <li><a href="oneday_class_index.php">??데??클??스</a></li>
                                    <li><a href="point_mall_index.php">??품??/a></li>
                                </ul>
                            </li>
                        </ul>
                        
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                        <p><a href="pri.php" ></i>개인??보처리방침</a></p>
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
    
    <!-- 로고 ??검??창 !-->


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
                                ??목
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" name="search" placeholder="??요????검??!">
                            <button type="submit" name="tool" class="site-btn">검??/button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    !-->

    <hr class="hz" style="height: 2px;">

    <div class="menu">
        <div class="button1">
            <button type="button" onclick="location.href='point_mall_index.php'"><b>??품??/b></button>
        </div>
        <div class="button2">
            <button type="button" onclick="location.href='oneday_class_index.php'"><b>??데??클??스</b></button>
        </div>
        <div class="button3">
            <button type="button" onclick="location.href='message_form.php'"><b>문의</b></button>
        </div>
        <div class="button4">
            <button type="button" onclick="location.href='bobnuri.php'"><b>조직??/b></button>
        </div>
        <div class="button5">
            <button type="button" onclick="location.href='blog.php'"><b>공단??개</b></button>
        </div>
    </div>

    <div class="main">
        <div class="image">
        </div>
    </div>
    <hr>   

    <!-- Header Section End -->


