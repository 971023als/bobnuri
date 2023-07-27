<?php require('lib/top.php'); ?>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bar.css">
<link rel="stylesheet" href="css/styles.css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
function validateLoginForm(form) {
  const requiredFields = ['id', 'pass'];
  const fieldNames = {
    'id': '아이디',
    'pass': '비밀번호'
  };

  for (let field of requiredFields) {
    if (!form[field].value) {
      alert(`${fieldNames[field]}를 입력하세요!`);
      form[field].focus();
      return false;
    }
  }
  return true;
}

function validateRegisterForm(form) {
  const requiredFields = ['id', 'pass', 'pass_confirm', 'name', 'email1', 'email2', 'address'];
  const fieldNames = {
    'id': '아이디',
    'pass': '비밀번호',
    'pass_confirm': '비밀번호 확인',
    'name': '이름',
    'email1': '이메일1',
    'email2': '이메일2',
    'address': '주소'
  };

  for (let field of requiredFields) {
    if (!form[field].value) {
      alert(`${fieldNames[field]}를 입력하세요!`);
      form[field].focus();
      return false;
    }
  }

  if (form['pass'].value !== form['pass_confirm'].value) {
    alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
    form['pass'].focus();
    form['pass'].select();
    return false;
  }

  if (form['checked_id'].value !== "y") {
    alert("중복확인을 해주세요");
    form['id'].focus();
    form['id'].select();
    return false;
  }
  return true;
}

function check_login() {
  let form = document.forms['login_form'];
  if (validateLoginForm(form)) {
    form.submit();
  }
}

function check_member() {
  let form = document.forms['member_form'];
  if (validateRegisterForm(form)) {
    form.submit();
  }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function check_login() {
    let form = document.forms['login_form'];
    if (validateLoginForm(form)) {
        if(document.querySelector("#remember").checked) {
            setCookie("username", form['id'].value, 30);
        } else {
            setCookie("username", "", -1); //delete cookie
        }
        form.submit();
    }
}

// Now let's populate the user field with cookie value if it exists
window.onload = function() {
    var username = getCookie("username");
    if(username != "") {
        document.querySelector("#userID").value = username;
        document.querySelector("#remember").checked = true;
    }
}



document.querySelector('#register-id-check').addEventListener('click', function(event) {
  event.preventDefault();
  window.open("member_check_id.php?id=" + document.forms['member_form']['id'].value,
      "IDcheck",
      "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes");
});

document.querySelector('#login-form-link').addEventListener('click', function(e) {
  e.preventDefault();
  document.querySelector("#login-form").style.display = 'block';
  document.querySelector("#register-form").style.display = 'none';
  document.querySelector('#register-form-link').classList.remove('active');
  this.classList.add('active');
});

document.querySelector('#register-form-link').addEventListener('click', function(e) {
  e.preventDefault();
  document.querySelector("#register-form").style.display = 'block';
  document.querySelector("#login-form").style.display = 'none';
  document.querySelector('#login-form-link').classList.remove('active');
  this.classList.add('active');
});

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

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="login_form.php" class="active" id="login-form-link">로그인</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="member_form.php" id="register-form-link">회원가입</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" name="login_form" method="post" action="login.php" role="form" style="display: block;">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



 <?php require('lib/bottom.php'); ?>