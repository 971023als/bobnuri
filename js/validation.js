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
