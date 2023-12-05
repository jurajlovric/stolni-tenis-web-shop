var LoginForm = document.getElementById("LoginForm");
var RegForm = document.getElementById("RegForm");
var indicator = document.getElementById("indicator");
    function register(){
        RegForm.style.transform = "translateX(0px)";
        LoginForm.style.transform = "translateX(0px)";
        indicator.style.transform = "translateX(60px)";
    }
    function login(){
        RegForm.style.transform = "translateX(350px)";
        LoginForm.style.transform = "translateX(350px)";
        indicator.style.transform = "translateX(-60px)";
    }