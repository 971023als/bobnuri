// validation.js

function check_input(){
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
         document.member_form.address.focus();
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
      document.member_form.id.focus();
      document.member_form.id.select();
      return;
  }

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

  document.member_form.submit();
}

function reset_form() {
    document.member_form.id.value = "";
    document.member_form.pass.value = "";
    document.member_form.pass_confirm.value = "";
    document.member_form.name.value = "";
    document.member_form.email1.value = "";
    document.member_form.email2.value = "";
    
    var radios = document.getElementsByName('agree');
    for(var i = 0; i < radios.length; i++) {
      radios[i].checked = false;
    }
  
    document.member_form.checked_id.value = "";
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
 }
 function check_id() {
    window.open("member_check_id.php?id=" + document.member_form.id.value,
    "IDcheck",
    "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes");
}

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // This prevents the form from being submitted before all checks are complete
    var id = document.getElementById('id').value;
    var pass = document.getElementById('pass').value;
    var name = document.getElementById('name').value;
    var email1 = document.getElementById('email1').value;
    var email2 = document.getElementById('email2').value;
    var email = email1 + "@" + email2;

    // Name must be 6 characters or less
    if (name.length > 6) {
        alert("이름은 6자 미만로 입력해 주세요.");
        document.member_form.name.focus();
        document.member_form.name.select();
        window.history.back();
        return;
    }

    // Check if email is valid
    var emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailFormat.test(email)) {
        alert("이메일 형식이 올바르지 않습니다.");
        document.member_form.email1.focus();
        document.member_form.email1.select();
        window.history.back();
        return;
    }

    // Password validation: At least 8 characters, contains lower and uppercase letters, numbers, and special characters
    var passwordFormat = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordFormat.test(pass)) {
        alert("비밀번호는 최소 8자리, 특수문자, 대소문자를 포함해야 합니다!");
        document.member_form.pass.focus();
        document.member_form.pass.select();
        window.history.back();
        return;
    }

    // If all the checks are passed, submit the form
    event.target.submit();
});
