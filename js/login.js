function check_input()
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