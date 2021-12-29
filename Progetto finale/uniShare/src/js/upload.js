/**
 * Questa funzione ottiene tutte le informazioni e va a inviarle al 
 * server. NB: non ho potuto usare ajaxCall() in quanto qua la codifica
 * deve essere form-encoded in quando vado a caricare un documento pdf
 * Il funzionamento del metodo è semplice:
 * ottengo tutti i valori del form, successivamente li aggiungo a un form fittizio e invio quello
 */
function uploadData() {
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
    form.append("insegnamento", insegnamento);
    form.append("tipoDiAppunti", tipoDiAppunti);
    form.append("nomeDelDocente", nomeDelDocente);
    form.append("uploadFile", file);

    $.ajax({
        url: 'api/ApiUpload.php',
        type: 'post',
        data: form,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data) {
            if (data["Ok"] !== undefined) {
                $("#UploadAppunti").hide("slide", { direction: "left" }, 300, function() {
                    $("#UploadAppuntiFinish").fadeIn();
                });
            } else {
                showAlert("error", "Errore", "Un errore lato server è stao generato");
                console.log(data);
            }
        }
    });


}

/**
 * Questa funzione carica le informazioni di default della pagina. in particolare le informazioni 
 * sull'autocompletamento delle informazioni sulle università e sugli insegnamenti
 */
function loadPageDefaults() {
    ajaxCall("get_university_list", {}, function(data) {
        $.each(data, function(index, item) {
            $("#UniversitaDataList").append("<option>" + item["item"] + "</option>");
        });
    });

    ajaxCall("get_teaching_list", {}, function(data) {
        $.each(data, function(index, item) {
            $("#InsegnamentoDatalist").append("<option>" + item["item"] + "</option>");
        });
    });
}


$(function() {
    //se utente non è loggato faccio un redirect a login
    userLoginCheck();
    $("#caricaDatiBtn").click(uploadData);
    loadPageDefaults();

})