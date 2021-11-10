var freeTile = [
    [0, 0, 0, 0],
    [0, 0, 0, 0],
    [0, 0, 0, 0],
    [0, 0, 0, 1]
];

$(document).ready(function(){
    $("#puzzlearea").children().each(function(){
        var elementNumber = parseInt($(this).html());
        $(this).click(move)
                .css("left", ((elementNumber-1) % 4)*100 )
                .css("background-image", "url('background.png')")
                .css("background-repeat", "no-repeat")
                .css("background-position-x", -(((elementNumber-1) % 4)*100))
                .css("top", elementNumber <= 4 ? "0" : 
                            elementNumber <= 8 ? "100px" :
                            elementNumber <= 12 ? "200px" : "300px" )
                .css("background-position-y",   elementNumber <= 4 ? "0" : 
                                                elementNumber <= 8 ? "-100px" :
                                                elementNumber <= 12 ? "-200px" : "-300px");
    });
    updateMovableTiles();
    $("#shufflebutton").click(shuffleTiles);
});

function shuffleTiles(){

    var positionAvailable = [
        [[0,0]],
        [[0,1]],
        [[0,2]],
        [[0,3]],
        [[1,0]],
        [[1,1]],
        [[1,2]],
        [[1,3]],
        [[2,0]],
        [[2,1]],
        [[2,2]],
        [[2,3]],
        [[3,0]],
        [[3,1]],
        [[3,2]],
        [[3,3]]
    ];

        $("#puzzlearea").children().each(function(){
            var position = parseInt(Math.random() * positionAvailable.length);
            var nextPosition = positionAvailable[position];
            positionAvailable.splice(position, 1);
            
            $(this).css("top", 100*nextPosition[0][0])
                    .css("left", 100*nextPosition[0][1]);
        });
        
        var oldFree = findMoveDest();
        freeTile[oldFree[0]][oldFree[1]] = 0;
        freeTile[positionAvailable[0][0][0]][positionAvailable[0][0][1]] = 1;

        updateMovableTiles();
    }

function isMovable(item){
        var i = (item.position().top)/100;
        var j = (item.position().left)/100;
        if(
            freeTile[i+1 > 3 ? i : i+1][j] ||
            freeTile[i-1 < 0 ? i : i-1][j] ||
            freeTile[i][j+1 > 3 ? j : j+1] ||
            freeTile[i][j-1 < 0 ? j : j-1]
        ){
            return true;
        }else{
            return false;
        }
}

function findMoveDest(){
    for(var i = 0; i<4; i++)
        for(var j = 0; j<4; j++)
            if(freeTile[i][j])
                return [i,j];
}

function move(){
    if(isMovable($(this))){
        
        var NewPosition = findMoveDest();
        //now in i, j i have the destination of the new tile!
        var oldj = ($(this).position().left)/100;
        var oldi = ($(this).position().top)/100;
        
        freeTile[oldi][oldj] = 1;
        freeTile[NewPosition[0]][NewPosition[1]] = 0;
        
        $(this).animate({
            opacity: 1,
            top: NewPosition[0]*100,
            left: NewPosition[1]*100
        }, 100, function(){
            checkIfFinished();
            updateMovableTiles();
        });
        
    }
}


function updateMovableTiles(){
    $("#puzzlearea").children().each(function(){
            if(isMovable($(this)))
                $(this).addClass("hoverTileMovable");
            else 
                if($(this).hasClass("hoverTileMovable")) 
                    $(this).removeClass("hoverTileMovable");   
    });
}


function checkIfFinished(){
    var i = 0, j = 0, puzzleCorrect = true;

    $("#puzzlearea").children().each(function(){
       puzzleCorrect = puzzleCorrect && 
                       ($(this).position().left/100) == i%4 &&
                       ($(this).position().top/100) == Math.trunc(j);
        
        j+=0.25;i++;
    });

    if(puzzleCorrect)
        alert("Congratulations! you have solved the puzzle!");

}