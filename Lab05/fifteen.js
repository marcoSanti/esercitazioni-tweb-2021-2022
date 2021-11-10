/**
 * this var stores the position of the missing
 * tile! where a zero is present, a tile is present
 * where a 1 is present, the free tile is present
 */

var freeTile = [
    [0, 0, 0, 0],
    [0, 0, 0, 0],
    [0, 0, 0, 0],
    [0, 0, 0, 1]
];

$(document).ready(function(){
    $("#puzzlearea").children().each(function(){
        var elementNumber = parseInt($(this).html());
        $(this).click(move) //setting the click action and the varius aspect of the aspect
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

/**
 * This function shuffles the tiles of the game
 */
function shuffleTiles(){

    //this saves all possible locations that a tile can have on the grid
    var positionAvailable = [
        [[0,0]],[[0,1]],[[0,2]],[[0,3]],
        [[1,0]],[[1,1]],[[1,2]],[[1,3]],
        [[2,0]],[[2,1]],[[2,2]],[[2,3]],
        [[3,0]],[[3,1]],[[3,2]],[[3,3]]
    ];

        $("#puzzlearea").children().each(function(){
            var position = parseInt(Math.random() * positionAvailable.length); //choosing a random next position
            var nextPosition = positionAvailable[position]; //getting new position from random index 
            positionAvailable.splice(position, 1); //removing the position from the available ones
            
            $(this).css("top", 100*nextPosition[0][0])
                    .css("left", 100*nextPosition[0][1]); //moving the tile to new position
        });
        
        //updating free map to show the free location wich is the one not choosen from the
        //available position in map (by setting the old one to 0 first!)
        var oldFree = findMoveDest(); 
        freeTile[oldFree[0]][oldFree[1]] = 0;
        freeTile[positionAvailable[0][0][0]][positionAvailable[0][0][1]] = 1;

        updateMovableTiles(); 
    }

    /**
     * This function tells whether a tile can be moved.
     * @param {} item  the tile
     * @returns true if a tile can be moved
     */
function isMovable(item){
    //getting the position in terms of row and column
        var i = (item.position().top)/100;
        var j = (item.position().left)/100;
        if(
            freeTile[i+1 > 3 ? i : i+1][j] ||  //checking whether the free tile is up, down, left, right and if it has one allows it to move
            freeTile[i-1 < 0 ? i : i-1][j] ||  //a ternary operator is used to avoid accessing a place outside of the freeTile map
            freeTile[i][j+1 > 3 ? j : j+1] ||
            freeTile[i][j-1 < 0 ? j : j-1]
        ){
            return true;
        }else{
            return false;
        }
}

/**
 * This function returns the position of the 
 * free tile into the var freeTile
 * @returns an array of [x,y] of the position of the free tile
 */
function findMoveDest(){
    for(var i = 0; i<4; i++)
        for(var j = 0; j<4; j++)
            if(freeTile[i][j])
                return [i,j];
}

/**
 * This function moves the tile
 * it is the handler of the click event for the tiles
 */
function move(){
    if(isMovable($(this))){
        
        var NewPosition = findMoveDest();
        //now in i, j i have the destination of the new tile!
        var oldj = ($(this).position().left)/100;
        var oldi = ($(this).position().top)/100;
        
        freeTile[oldi][oldj] = 1;                       //setting the origin position of the tile to free
        freeTile[NewPosition[0]][NewPosition[1]] = 0;   //setting the destination position of the tile to not free
        
        $(this).animate({
            opacity: 1,
            top: NewPosition[0]*100,
            left: NewPosition[1]*100
        }, 100, function(){
            checkIfFinished();       //control if the game is completed
            updateMovableTiles();    
        });
        
    }
}

/**
 * this function updates all the tiles so that only those wich have a empty space up down left or right
 * amd if so a class hoverTitleMovable is added. Removed otherwise
 */
function updateMovableTiles(){
    $("#puzzlearea").children().each(function(){
            if(isMovable($(this)))
                $(this).addClass("hoverTileMovable");
            else 
                if($(this).hasClass("hoverTileMovable")) 
                    $(this).removeClass("hoverTileMovable");   
    });
}

/**
 * this function checks wheter the the game is over.
 * it is done by checking that all of the tiles are in the 
 * original places
 */
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