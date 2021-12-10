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