function register(){
    var nome = $("#InputNome").val();
    var cognome = $("#InputCognome").val();
    var email= $("#InputEmail").val();
    var password1= $("#InputPassword1").val();
    var password2 = $("#InputPassword2").val();

    function validateMail(mail){
        return mail.toLowerCase().match(
            /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g
        );
    }

    if(nome==="" || cognome ===""||email===""||password1===""||password2===""){
        $("#ErrorRegisterDivContent").html("Inserire tutti i campi!");
        $("#ErrorRegisterDiv").fadeIn();
        return;
    }

    if(password2 != password1){
        $("#ErrorRegisterDivContent").html("Le password non coincidono!");
        $("#ErrorRegisterDiv").fadeIn();
        return;
    }

    if(!validateMail(email)){
        $("#ErrorRegisterDivContent").html("L'indirizzo email non è valido!");
        $("#ErrorRegisterDiv").fadeIn();
        return;
    }

    var sendData = JSON.stringify({"api" : "sign_up", "payload" : {"name":nome,"surname":cognome, "email" : email, "password" : password1} });
    $.ajax("./api/index.php",{
        data: sendData ,
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            if(data["Ok"]!==undefined){
                window.location.href="./";
            }else{
                $("#ErrorLoginDivContent").html(data["Error"]);
                $("#ErrorLoginDiv").fadeIn();
            }
        }
    });

}


$(function(){
    $("#RegisterFormSubmit").click(register);
})