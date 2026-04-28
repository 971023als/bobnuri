   function check_input()
   {
      if (!document.member_form.pass.value)
      {
          alert("ë¹„ë?ë²ˆí˜¸ë¥??…ë ¥?˜ì„¸??");    
          document.member_form.pass.focus();
          return;
      }

      if (!document.member_form.pass_confirm.value)
      {
          alert("ë¹„ë?ë²ˆí˜¸?•ì¸???…ë ¥?˜ì„¸??");    
          document.member_form.pass_confirm.focus();
          return;
      }

      if (!document.member_form.name.value)
      {
          alert("?´ë¦„???…ë ¥?˜ì„¸??");    
          document.member_form.name.focus();
          return;
      }

      if (!document.member_form.email1.value)
      {
          alert("?´ë©”??ì£¼ì†Œë¥??…ë ¥?˜ì„¸??");    
          document.member_form.email1.focus();
          return;
      }

      if (!document.member_form.email2.value)
      {
          alert("?´ë©”??ì£¼ì†Œë¥??…ë ¥?˜ì„¸??");    
          document.member_form.email2.focus();
          return;
      }

      if (document.member_form.pass.value != 
            document.member_form.pass_confirm.value)
      {
          alert("ë¹„ë?ë²ˆí˜¸ê°€ ?¼ì¹˜?˜ì? ?ŠìŠµ?ˆë‹¤.\n?¤ì‹œ ?…ë ¥??ì£¼ì„¸??");
          document.member_form.pass.focus();
          document.member_form.pass.select();
          return;
      }

      document.member_form.submit();
   }

   function reset_form()
   {
      document.member_form.id.value = "";  
      document.member_form.pass.value = "";
      document.member_form.pass_confirm.value = "";
      document.member_form.name.value = "";
      document.member_form.email1.value = "";
      document.member_form.email2.value = "";
	  
      document.member_form.id.focus();

      return;
   }
