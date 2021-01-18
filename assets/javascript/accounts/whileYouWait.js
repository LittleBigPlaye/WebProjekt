var canvas = document.getElementById("snakeCan");
var gc = canvas.getContext("2d");
var lastDate = new Date();
var timeSinceLastTick = 0;
var berechner = 0;
var TIMEBETWEENTICKS = 0.1;
var TIMEFURITGONEBAD = 10;

var fruitIsBad = false;

var x = 0;
var y = 0;

var LEFT = 65;
var UP = 87;
var RIGHT = 68;
var DOWN = 83;

var dir = RIGHT;

var CELLSIZE = 10;

var GRIDWIDTH = 40;
var GRIDHEIGHT = 40;

var foodX = 0;
var foodY = 0;

var badFoodX = 0;
var badFoodY = 0;

var segments = [];

var gameOver = false;

var counter = 0;
var speedCounter = 0;

var foodBad = [];


function randomNumber(range) {
    return Math.floor(Math.random() * range);
}

function placeFood() {
    while(true) {
        foodX = randomNumber(GRIDWIDTH);
        foodY = randomNumber(GRIDHEIGHT);

        var isOnSnake = false;

        for(var i = 0; i < segments.length; i++) {
            if(foodX === segments[i].x && foodY === segments[i].y){
                isOnSnake = true;
            }
        }

        if(!isOnSnake){
            break;
        }
    }
}

function placeBadFood(foodX, foodY) {
    while(true) {
        badFoodX = foodX;
        badFoodY = foodY;

        var isOnSnake = false;

        for(var i = 0; i < segments.length; i++) {
            if(foodX === segments[i].x && foodY === segments[i].y){
                isOnSnake = true;
            }
        }

        if(!isOnSnake){
            break;
        }
    }
}

function GAMEOVER(){
    gc.fillStyle = "#ffffff";
    gc.font = "48px serif";
    gc.fillText("Game Over!", 90, 200, 300);
    gc.font = "15px serif";
    gc.fillText("Druecke F5 um nochmal zu spielen!", 100, 250, 300);
}


placeFood();


function Segment(x, y) {
    this.x = x;
    this.y = y;
    segments.push(this);
}

for (var i = 0; i < 6; i++) {
    new Segment(-100, -100);
}

var controlQueue = [];

document.addEventListener("keydown", function(event){
    var kc = event.keyCode;
    if(controlQueue.length < 5 && (kc === LEFT || kc === RIGHT || kc === UP || kc === DOWN )) {
        controlQueue.push(kc);
    }
});

function updateLoop() {
    var thisDate = new Date();
    var timeBetween = (thisDate.getTime() - lastDate.getTime()) / 1000;
    lastDate = thisDate;


    timeSinceLastTick += timeBetween;
    berechner += timeBetween;

    if (gameOver === false && timeSinceLastTick > TIMEBETWEENTICKS) {

        if (berechner > TIMEFURITGONEBAD) {

            berechner -= TIMEFURITGONEBAD;

            console.log("Hallo");

            fruitIsBad = true;

            foodBad = placeBadFood(foodX, foodY);

            gc.fillStyle = "#ff0fff";
            gc.fillRect(badFoodX * CELLSIZE, badFoodY * CELLSIZE, CELLSIZE, CELLSIZE);


            timeSinceLastTick -= TIMEBETWEENTICKS;


            gc.fillStyle = "#000000";
            gc.fillRect(0, 0, canvas.width, canvas.height - 200);


            gc.fillStyle = "#ffffff";
            gc.fillRect(0, 400, canvas.width, 200);


            gc.fillStyle = "#000000";
            gc.font = "bold 20px Arial";
            gc.fillText("Punkte:  " + counter, 10, 420, 150);


            if (controlQueue.length > 0) {

                switch (controlQueue[0]) {
                    case(LEFT):
                        if (dir === UP || dir === DOWN) {
                            dir = LEFT;
                        }
                        break;
                    case(RIGHT):
                        if (dir === UP || dir === DOWN) {
                            dir = RIGHT;
                        }
                        break;
                    case(DOWN):
                        if (dir === LEFT || dir === RIGHT) {
                            dir = DOWN;
                        }
                        break;
                    case(UP):
                        if (dir === LEFT || dir === RIGHT) {
                            dir = UP;
                        }
                        break;
                }

                controlQueue.splice(0, 1);
            }


            switch (dir) {
                case(LEFT):
                    x--;
                    break;

                case(RIGHT):
                    x++;
                    break;

                case(UP):
                    y--;
                    break;

                case(DOWN):
                    y++;
                    break;
            }

            if (x < 0) {
                x = GRIDWIDTH - 1;
            }

            if (x >= GRIDWIDTH) {
                x = 0;
            }

            if (y < 0) {
                y = GRIDHEIGHT - 1;
            }

            if (y >= GRIDHEIGHT) {
                y = 0;
            }


            for (i = 0; i < segments.length; i++) {
                if (segments[i].x === x && segments[i].y === y) {
                    gameOver = true;
                    GAMEOVER();
                }
            }

            for (var i = segments.length - 1; i > 0; i--) {
                segments[i].x = segments[i - 1].x;
                segments[i].y = segments[i - 1].y;
            }


            segments[0].x = x;
            segments[0].y = y;

            if (x === foodX && y === foodY) {
                new Segment(-100, -100);
                counter++;
                speedCounter++;
                placeFood();

            }


            if (speedCounter === 10) {
                speedCounter = 0;
                TIMEBETWEENTICKS -= 0.01;

            }

            gc.fillStyle = "#ff6600";

            for (var i = 0; i < segments.length; i++) {

                gc.fillRect(segments[i].x * CELLSIZE, segments[i].y * CELLSIZE, CELLSIZE, CELLSIZE);

            }


            gc.fillStyle = "#0000ff";
            gc.fillRect(foodX * CELLSIZE, foodY * CELLSIZE, CELLSIZE, CELLSIZE);

        }
    }


    window.setInterval(updateLoop, 1);
}