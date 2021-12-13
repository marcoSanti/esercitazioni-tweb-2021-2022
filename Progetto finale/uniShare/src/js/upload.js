var notesAreDigital = false;

function showStep2(){
    if(!notesAreDigital){
        $("#FileUploadAppuntiBlock").remove();
    }
    $("#UploadAppunti0").hide("slide",{direction : "left"}, 300, function (){
        $("#UploadAppunti1").fadeIn(200);
    });

}

function showStep3(){
    $("#UploadAppunti1").hide("slide",{direction : "left"}, 300, function (){
        if(!notesAreDigital){
            $("#UploadAppunti2").fadeIn(200);
        }else{
            done();
        }
    });
}

function done(){
    //upload dei dati
    $("#UploadAppunti2").hide("slide",{direction : "left"}, 300, function (){
        $("#UploadAppunti3").fadeIn(200);
    });
}


$(function(){
    //se utente non è loggato mostro un div che dice che devi esser loggato!
    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "log_in_check", "payload" : [] }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            if( data["Status"] !== "logged"){
                $("#UploadAppunti0").css("display", "none");
                $("#LoginUploadAppunti").fadeIn();
            }
        }
    });


    $("#UploadAppunti0").fadeIn(300);

    $("#UploadDigitalNotes").click(function(){
        notesAreDigital = true;
        showStep2();
    });

    $("#UploadPaperNotes").click(function(){
        notesAreDigital = false;
        showStep2();
    });

    $("#Continua1").click(showStep3);
    $("#Continua2").click(done);
})