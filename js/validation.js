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
