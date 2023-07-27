<?php require('lib/top.php'); ?>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bar.css">
  <link rel="stylesheet" href="css/member_style.css">
  <script>
  function check_member()
  {
     if (!document.member_form.id.value) {
         alert("아이디를 입력하세요!");
         document.member_form.id.focus();
         return;
     }

     if (!document.member_form.pass.value) {
         alert("비밀번호를 입력하세요!");
         document.member_form.pass.focus();
         return;
     }

     if (!document.member_form.pass_confirm.value) {
         alert("비밀번호확인을 입력하세요!");
         document.member_form.pass_confirm.focus();
         return;
     }

     if (!document.member_form.name.value) {
         alert("이름을 입력하세요!");
         document.member_form.name.focus();
         return;
     }

     if (!document.member_form.email1.value) {
         alert("이메일 주소를 입력하세요!");
         document.member_form.email1.focus();
         return;
     }

     if (!document.member_form.email2.value) {
         alert("이메일 주소를 입력하세요!");
         document.member_form.email2.focus();
         return;
     }

     if (!document.member_form.address.value) {
         alert("주소를 입력하세요!");
         document.member_form.name.focus();
         return;
     }

     if (document.member_form.pass.value !=
           document.member_form.pass_confirm.value) {
         alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
         document.member_form.pass.focus();
         document.member_form.pass.select();
         return;
     }

     if (document.member_form.checked_id.value !="y") {
         alert("중복확인을 해주세요");
         document.member_form.pass.focus();
         document.member_form.pass.select();
         return;
     }

     // other checks omitted for brevity
    var radios = document.getElementsByName('agree');

    var formValid = false;

    var i = 0;
    while (!formValid && i < radios.length) {
        if (radios[i].checked) formValid = true;
        i++;        
    }

    if (!formValid) {
        alert("개인정보 수집에 대한 동의가 필요합니다");
        return;
    }

    if (document.member_form.agree.value != "yes") {
        alert("개인정보 수집에 대한 동의가 필요합니다");
        return;
    }

     document.member_form.submit();
  }

  function reset_form() {
     document.member_form.id.value = "";
     document.member_form.pass.value = "";
     document.member_form.pass_confirm.value = "";
     document.member_form.name.value = "";
     document.member_form.email1.value = "";
     document.member_form.email2.value = "";
     document.member_form.address.value = "";
     document.member_form.id.focus();
     return;
  }

  function check_login()
  {
      if (!document.login_form.id.value)
      {
          alert("아이디를 입력하세요");
          document.login_form.id.focus();
          return;
      }

      if (!document.login_form.pass.value)
      {
          alert("비밀번호를 입력하세요");
          document.login_form.pass.focus();
          return;
      }
      document.login_form.submit();
  }
  function check_id() {
    window.open("member_check_id.php?id=" + document.member_form.id.value,
        "IDcheck",
         "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes");
         document.member_form.checked_id.value = "y";
       }


  </script>

<body>
  

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <a href="./login_form.php"  id="login-form-link">로그인</a>
              </div>
              <div class="col-xs-6">
                <a href="./member_form.php" class="active" id="register-form-link">회원가입</a>
              </div>
            </div>
            <hr>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <form id="login-form" name="login_form" method="post" action="login.php" role="form" style="display: none;">
                  <div class="form-group">
                    <input type="text" name="id" id="userID" tabindex="1" class="form-control" placeholder="아이디" value="">
                  </div>
                  <div class="form-group">
                    <input type="password" name="pass" id="password" tabindex="2" class="form-control" placeholder="비밀번호">
                  </div>
                  <div class="form-group text-center">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                    <label for="remember">아이디 기억하기</label>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="button" onclick="check_login()" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="로그인">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-center">
                          <a href="find_password_form.php" tabindex="5" class="forgot-password">비밀번호를 잊어버리셨나요?</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>


                <form id="register-form" name="member_form" method="post" action="member_insert.php" role="form" style="display: block;">
                  <div class="form-group">

                    <input type="hidden" name="checked_id" value="">

                    <div class="row">
                      <div class="col-sm-9">
                    <input type="text" name="id" id="username" tabindex="1" class="form-control" placeholder="아이디" value="" >
                  </div>
                  <div class="col-sm-3">
                    <input type="button" onclick="check_id()" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="중복확인">
                  </div>
                </div>
              </div>
                  <div class="form-group">
                    <input type="password" name="pass" id="password" tabindex="2" class="form-control" placeholder="비밀번호">
                  </div>
                  <div class="form-group">
                    <input type="password" name="pass_confirm" id="confirm-password" tabindex="2" class="form-control" placeholder="비밀번호 확인">
                  </div>
                  <div class="form-group">
                    <input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="이름" value="">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <input type="text" name="email1" id="email1" tabindex="1" class="form-control" placeholder="이메일1(사용자계정)" value="">
                      </div>
                    <div class="col-sm-1 text-center">
                      <p>@</p>
                    </div>
                  <div class="col-sm-5">
                    <input type="text" name="email2" id="email2" tabindex="1" class="form-control" placeholder="이메일2(이메일서버)" value="">
                  </div>
                </div>
              </div>

                  <div class="form-group">
                    <input type="text" name="address" id="address" tabindex="1" class="form-control" placeholder="주소" value="">
                  </div>
                  <div class="center-text">
                    <h3><b>BoB누리홈페이지 이용을 위한<br> 개인정보 수집‧이용 동의서</b></h3>
                    <p>BoB누리홈페이지 이용을 위하여 아래와 같이 개인정보를 수집 및 이용을 하고자 합니다. 내용을 자세히 읽으신 후, 동의 여부를 결정하여 주십시오.</p>

                    <h4>□ 개인정보 수집 이용 내역(필수사항)</h4>
                    <table>
                      <thead>
                        <tr>
                          <th style="text-align: center">항 목</th>
                          <th style="text-align: center">수집 및 이용 목적</th>
                          <th style="text-align: center">보유기간</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            성명, 이메일주소, 집주소
                          </td>
                            <td>BoB누리홈페이지 서비스 제공</td>
                            <td>1. 계정 해지 시까지<br>2. 최종 로그인부터 1년까지</td>
                          </tr>
                        <tr>
                          <td>
                            법정대리인 성명, 생년월일, 이메일주소
                          </td>
                            <td>미성년자 이용자의 서비스 이용에 대한 동의 및 관리</td>
                            <td>1. 계정 해지 시까지<br>2. 최종 로그인부터 1년까지</td>
                          </tr>
                        </tbody>
                      </table>


                <p><strong>※ 위의 개인정보 수집 이용에 대한 동의를 거부할 권리가 있습니다.<br>동의를 거부할 경우 원활한 서비스 제공에 일부 제한을 받을 수 있습니다.</strong></p>
              </div>


              <div class="form-group text-center">
                  <label>위와 같이 개인정보를 수집·이용하는데 동의하십니까? </label>
                  <label>예 </label>
                  <input type="radio" tabindex="3" class="" name="agree" id="agree" value="yes">
                  <label>아니요 </label>
                  <input type="radio" tabindex="3" class="" name="agree" id="disagree" value="no">
              </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="button" onclick="check_member()" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="가입하기">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(function() {

      $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
      });
      $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
      });

    });
  </script>
 <?php require('lib/bottom.php'); ?>
