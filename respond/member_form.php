<?php require('lib/top.php'); ?>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bar.css">
  <link rel="stylesheet" href="css/member_style.css">
  <script>
  function check_member()
  {
     if (!document.member_form.id.value) {
         alert("?„ì´?”ë? ?…ë ¥?˜ì„¸??");
         document.member_form.id.focus();
         return;
     }

     if (!document.member_form.pass.value) {
         alert("ë¹„ë?ë²ˆí˜¸ë¥??…ë ¥?˜ì„¸??");
         document.member_form.pass.focus();
         return;
     }

     if (!document.member_form.pass_confirm.value) {
         alert("ë¹„ë?ë²ˆí˜¸?•ì¸???…ë ¥?˜ì„¸??");
         document.member_form.pass_confirm.focus();
         return;
     }

     if (!document.member_form.name.value) {
         alert("?´ë¦„???…ë ¥?˜ì„¸??");
         document.member_form.name.focus();
         return;
     }

     if (!document.member_form.email1.value) {
         alert("?´ë©”??ì£¼ì†Œë¥??…ë ¥?˜ì„¸??");
         document.member_form.email1.focus();
         return;
     }

     if (!document.member_form.email2.value) {
         alert("?´ë©”??ì£¼ì†Œë¥??…ë ¥?˜ì„¸??");
         document.member_form.email2.focus();
         return;
     }

     if (!document.member_form.address.value) {
         alert("ì£¼ì†Œë¥??…ë ¥?˜ì„¸??");
         document.member_form.name.focus();
         return;
     }

     if (document.member_form.pass.value !=
           document.member_form.pass_confirm.value) {
         alert("ë¹„ë?ë²ˆí˜¸ê°€ ?¼ì¹˜?˜ì? ?ŠìŠµ?ˆë‹¤.\n?¤ì‹œ ?…ë ¥??ì£¼ì„¸??");
         document.member_form.pass.focus();
         document.member_form.pass.select();
         return;
     }

     if (document.member_form.checked_id.value !="y") {
         alert("ì¤‘ë³µ?•ì¸???´ì£¼?¸ìš”");
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
        alert("ê°œì¸?•ë³´ ?˜ì§‘???€???™ì˜ê°€ ?„ìš”?©ë‹ˆ??);
        return;
    }

    if (document.member_form.agree.value != "yes") {
        alert("ê°œì¸?•ë³´ ?˜ì§‘???€???™ì˜ê°€ ?„ìš”?©ë‹ˆ??);
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
          alert("?„ì´?”ë? ?…ë ¥?˜ì„¸??);
          document.login_form.id.focus();
          return;
      }

      if (!document.login_form.pass.value)
      {
          alert("ë¹„ë?ë²ˆí˜¸ë¥??…ë ¥?˜ì„¸??);
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
                <a href="./login_form.php"  id="login-form-link">ë¡œê·¸??/a>
              </div>
              <div class="col-xs-6">
                <a href="./member_form.php" class="active" id="register-form-link">?Œì›ê°€??/a>
              </div>
            </div>
            <hr>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <form id="login-form" name="login_form" method="post" action="login.php" role="form" style="display: none;">
                  <div class="form-group">
                    <input type="text" name="id" id="userID" tabindex="1" class="form-control" placeholder="?„ì´?? value="">
                  </div>
                  <div class="form-group">
                    <input type="password" name="pass" id="password" tabindex="2" class="form-control" placeholder="ë¹„ë?ë²ˆí˜¸">
                  </div>
                  <div class="form-group text-center">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                    <label for="remember">?„ì´??ê¸°ì–µ?˜ê¸°</label>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="button" onclick="check_login()" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="ë¡œê·¸??>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-center">
                          <a href="find_password_form.php" tabindex="5" class="forgot-password">ë¹„ë?ë²ˆí˜¸ë¥??Šì–´ë²„ë¦¬?¨ë‚˜??</a>
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
                    <input type="text" name="id" id="username" tabindex="1" class="form-control" placeholder="?„ì´?? value="" >
                  </div>
                  <div class="col-sm-3">
                    <input type="button" onclick="check_id()" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="ì¤‘ë³µ?•ì¸">
                  </div>
                </div>
              </div>
                  <div class="form-group">
                    <input type="password" name="pass" id="password" tabindex="2" class="form-control" placeholder="ë¹„ë?ë²ˆí˜¸">
                  </div>
                  <div class="form-group">
                    <input type="password" name="pass_confirm" id="confirm-password" tabindex="2" class="form-control" placeholder="ë¹„ë?ë²ˆí˜¸ ?•ì¸">
                  </div>
                  <div class="form-group">
                    <input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="?´ë¦„" value="">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <input type="text" name="email1" id="email1" tabindex="1" class="form-control" placeholder="?´ë©”??(?¬ìš©?ê³„??" value="">
                      </div>
                    <div class="col-sm-1 text-center">
                      <p>@</p>
                    </div>
                  <div class="col-sm-5">
                    <input type="text" name="email2" id="email2" tabindex="1" class="form-control" placeholder="?´ë©”??(?´ë©”?¼ì„œë²?" value="">
                  </div>
                </div>
              </div>

                  <div class="form-group">
                    <input type="text" name="address" id="address" tabindex="1" class="form-control" placeholder="ì£¼ì†Œ" value="">
                  </div>
                  <div class="center-text">
                    <h3><b>BoB?„ë¦¬?ˆí˜?´ì? ?´ìš©???„í•œ<br> ê°œì¸?•ë³´ ?˜ì§‘?§ì´???™ì˜??/b></h3>
                    <p>BoB?„ë¦¬?ˆí˜?´ì? ?´ìš©???„í•˜???„ë˜?€ ê°™ì´ ê°œì¸?•ë³´ë¥??˜ì§‘ ë°??´ìš©???˜ê³ ???©ë‹ˆ?? ?´ìš©???ì„¸???½ìœ¼???? ?™ì˜ ?¬ë?ë¥?ê²°ì •?˜ì—¬ ì£¼ì‹­?œì˜¤.</p>

                    <h4>??ê°œì¸?•ë³´ ?˜ì§‘ ?´ìš© ?´ì—­(?„ìˆ˜?¬í•­)</h4>
                    <table>
                      <thead>
                        <tr>
                          <th style="text-align: center">??ëª?/th>
                          <th style="text-align: center">?˜ì§‘ ë°??´ìš© ëª©ì </th>
                          <th style="text-align: center">ë³´ìœ ê¸°ê°„</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            ?±ëª…, ?´ë©”?¼ì£¼?? ì§‘ì£¼??
                          </td>
                            <td>BoB?„ë¦¬?ˆí˜?´ì? ?œë¹„???œê³µ</td>
                            <td>1. ê³„ì • ?´ì? ?œê¹Œì§€<br>2. ìµœì¢… ë¡œê·¸?¸ë???1?„ê¹Œì§€</td>
                          </tr>
                        <tr>
                          <td>
                            ë²•ì •?€ë¦¬ì¸ ?±ëª…, ?ë…„?”ì¼, ?´ë©”?¼ì£¼??
                          </td>
                            <td>ë¯¸ì„±?„ì ?´ìš©?ì˜ ?œë¹„???´ìš©???€???™ì˜ ë°?ê´€ë¦?/td>
                            <td>1. ê³„ì • ?´ì? ?œê¹Œì§€<br>2. ìµœì¢… ë¡œê·¸?¸ë???1?„ê¹Œì§€</td>
                          </tr>
                        </tbody>
                      </table>


                <p><strong>???„ì˜ ê°œì¸?•ë³´ ?˜ì§‘ ?´ìš©???€???™ì˜ë¥?ê±°ë???ê¶Œë¦¬ê°€ ?ˆìŠµ?ˆë‹¤.<br>?™ì˜ë¥?ê±°ë???ê²½ìš° ?í™œ???œë¹„???œê³µ???¼ë? ?œí•œ??ë°›ì„ ???ˆìŠµ?ˆë‹¤.</strong></p>
              </div>


              <div class="form-group text-center">
                  <label>?„ì? ê°™ì´ ê°œì¸?•ë³´ë¥??˜ì§‘Â·?´ìš©?˜ëŠ”???™ì˜?˜ì‹­?ˆê¹Œ? </label>
                  <label>??</label>
                  <input type="radio" tabindex="3" class="" name="agree" id="agree" value="yes">
                  <label>?„ë‹ˆ??</label>
                  <input type="radio" tabindex="3" class="" name="agree" id="disagree" value="no">
              </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="button" onclick="check_member()" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="ê°€?…í•˜ê¸?>
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
