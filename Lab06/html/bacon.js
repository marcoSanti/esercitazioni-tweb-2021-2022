
function searchKevin(){
    var name = $("#searchkevin input[name=firstname]").val();
    var surname = $("#searchkevin input[name=lastname]").val();
    var endpoint = "./queryDb.php?firstname="+name+"&lastname="+surname + "&kevin";
    if(name != "" && surname != ""){
        $.ajax({
            url : endpoint,
            type: "GET",
            dataType: 'json',
            success: function(results){
                $("#results").css("display", "block");
                $("#kevinphoto").css("display", "none");
                $("#firstN").text(name);
                $("#lastN").text(surname);
                console.log(results);
                for(var i = 0; i<results.length; i++){
                    $("#list").append("<tr><td>" + i + "</td><td>" + results[i]['name'] +"</td><td>"+ results[i]['year']+"</td></tr>");
                }
            },

            error: function(result){
                $("#errMsg").textContent(result);
            }
        });
    }else{
        $("#errMsg").textContent("Error: some fields were not completed!");
    }

}

function searchNotKevin(){
    var name = $("#searchall input[name=firstname]").val();
    var surname = $("#searchall input[name=lastname]").val();
    var endpoint = "./queryDb.php?firstname="+name+"&lastname="+surname;
    if(name != "" && surname != ""){
    $.ajax({
        url : endpoint,
        type: "GET",
        dataType: 'json',
        success: function(results){
            $("#results").css("display", "block");
            $("#kevinphoto").css("display", "none");
            $("#firstN").text(name);
            $("#lastN").text(surname);

            for(var i = 0; i<results.length; i++){
                $("#list").append("<tr><td>" + i + "</td><td>" + results[i]['name'] +"</td><td>"+ results[i]['year']+"</td></tr>");
            }
        },

        error: function(result){
            $("#errMsg").textContet(result);
        }
    });
}else{
    $("#errMsg").textContent("Error: some fields were not completed!");
}
}

$(function(){
    $("#results").css("display", "none");
    $("#searchall input[type=submit]").click(searchNotKevin);
    $("#searchkevin input[type=submit]").click(searchKevin);

});

