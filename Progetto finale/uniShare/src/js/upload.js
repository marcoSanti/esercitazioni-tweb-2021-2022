
function uploadData(){
    //upload dei dati
    var universita = $("#UploadNoteUniversita").val();
    var annoCorso = $("#UploadNoteAnnoCorso").val();
    var insegnamento = $("#UploadNoteInsegnamento").val();
    var tipoDiAppunti = $("#UploadNoteTipoAppunti").val();
    var titoloAppunti = $("#UploadNoteNomeAppunti").val();
    var nomeDelDocente = $("#UploadNoteNomeDocente").val();
    var file = $("#UploadNoteFile")[0].files[0];

    var form = new FormData();
    form.append("universita", universita);
    form.append("titoloAppunti", titoloAppunti);
    form.append("annoCorso", annoCorso);
    form.append("insegnamento",insegnamento);
    form.append("tipoDiAppunti",tipoDiAppunti);
    form.append("nomeDelDocente", nomeDelDocente);
    form.append("uploadFile",file);

    $.ajax({
        url: 'api/ApiUpload.php',
        type: 'post',
        data: form,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data){
           if(data["Ok"]!== undefined){
               $("#UploadAppunti").hide("slide",{direction : "left"}, 300, function (){
                    $("#UploadAppuntiFinish").fadeIn();
               });
           }else{
               console.log(data);
           }
        }
    });


}


function loadPageDefaults(){
    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "get_university_list", "payload" : [] }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
           $.each(data, function(index, item){
                $("#UniversitaDataList").append("<option>" + item["item"] + "</option>");
           });
        }
    });


    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "get_teaching_list", "payload" : [] }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            $.each(data, function(index, item){
                $("#InsegnamentoDatalist").append("<option>" + item["item"] + "</option>");
            });
        }
    });
}


$(function(){
    //se utente non è loggato faccio un redirect a login
    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "log_in_check", "payload" : [] }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            if( data["Status"] !== "logged"){
               window.location.href = "./login.php";
            }else{
                $("#caricaDatiBtn").click(uploadData);
            }
        }
    });

    loadPageDefaults();

})