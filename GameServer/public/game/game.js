var myGamePiece;
var myObstacles = [];
var myScore;

var socket = io();
var arrayColor = ['red','pink','yellow','black','blue','green','gray'];
var gameStarted = false;
var theUserReadyToPlay = false;

var myRoom;
var createConnection = function (roomNumber){
    myRoom = roomNumber;
    socket.emit('room', roomNumber);
}
document.getElementById("createConnectionBtn").click(); //TODO: get the roomNumber in a different way!

var drawQueue = [];
socket.on('UpdateDataFromAllClients', function (data){
    drawQueue.push(data);
});

var obstaclesRands = [];

socket.on('startGame', function (obstacles) {
    obstaclesRands = obstacles;

    if (!theUserReadyToPlay) return;
    if (!gameStarted) {
        gameStarted = true;
        startGame(playerColor);
    }
});

var initiatedPlayers;
var connectedPlayers;

socket.on('numReadyPlayers', function (numReadyPlayers) {
    initiatedPlayers = numReadyPlayers;
    document.getElementById("numReadyPlayers").innerText = numReadyPlayers;
});

socket.on('numofPlayersConnected', function (numConnectedPlayers) {
    connectedPlayers = numConnectedPlayers;
    document.getElementById("numConnectedPlayers").innerText = numConnectedPlayers;
});

var myGameArea = {
    canvas : document.createElement("canvas"),
    initiate : function() {
        this.canvas.width = 1000;
        this.canvas.height = 500;
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.frameNo = 0;
    },
    start : function() {
        this.interval = setInterval(updateGameArea, 20);
    },
    clear : function() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
}


var startGame = function(color) {

    myGamePiece = new component(30, 30, color, 10, 120, "gamePiece");
    myGamePiece.gravity = 0.05;
    myScore = new component("30px", "Consolas", "black", 500, 40, "text");

    document.getElementById("readyBtn").style.display = 'none';
    document.getElementById("instructions").style.display = 'none';

    myGameArea.start();
}

var playerColor;
var playerName;

var ready = function(color, name){
    playerColor = color;
    playerName = name;
    theUserReadyToPlay = true;
    myGameArea.initiate();
    socket.emit("Ready", myRoom);
    document.getElementById("readyBtn").style.display = 'none';

}

function component(width, height, color, x, y, type) {
    this.type = type;
    this.score = 0;
    this.width = width;
    this.height = height;
    this.speedX = 0;
    this.speedY = 0;
    this.x = x;
    this.y = y;
    this.gravity = 0;
    this.gravitySpeed = 0;
    this.update = function() {
        ctx = myGameArea.context;
        if (this.type == "text") {
            ctx.font = this.width + " " + this.height;
            ctx.fillStyle = color;
            ctx.fillText(this.text, this.x, this.y);
        } else {
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);

            if (this.type == "gamePiece") {
                socket.emit('UpdateDataFromAllClients', {
                    color: color,
                    x: this.x,
                    y: this.y,
                    width: this.width,
                    height: this.height
                });
            }
        }
    }
    this.newPos = function() {
        this.gravitySpeed += this.gravity;
        this.x += this.speedX;
       // this.y += this.speedY + this.gravitySpeed;
        this.y += this.speedY;
        this.hitBottom();
    }
    this.hitBottom = function() {
        var rockbottom = myGameArea.canvas.height - this.height;
        if (this.y > rockbottom) {
            this.y = rockbottom;
            this.gravitySpeed = 0;
        }
    }
    this.crashWith = function(otherobj) {
        var myleft = this.x;
        var myright = this.x + (this.width);
        var mytop = this.y;
        var mybottom = this.y + (this.height);
        var otherleft = otherobj.x;
        var otherright = otherobj.x + (otherobj.width);
        var othertop = otherobj.y;
        var otherbottom = otherobj.y + (otherobj.height);
        var crash = true;
        if ((mybottom < othertop) || (mytop > otherbottom) || (myright < otherleft) || (myleft > otherright)) {
            crash = false;
        }
        return crash;
    }
}

function gameOver(){
    clearInterval(myGameArea.interval);

    socket.emit("playerDead", {
        name: playerName,
        color: playerColor,
        room: myRoom,
        score: myGameArea.frameNo
    });


    gameOverText = new component("200px", "Consolas", "black", 20, 140, "text");
    gameOverText.text = "GAME OVER!";
    gameOverText.update();

    gameOverText2 = new component("20px", "Consolas", "black", 30, 200, "text");
    gameOverText2.text = "Wait for the rest of the player to die";
    gameOverText2.update();


    socket.on("showScores", function(){
        window.location = "http://127.0.0.1:5000/scores?roomNumber="+myRoom
    })

}

var index = 0;

function updateGameArea() {
    var x;
    for (i = 0; i < myObstacles.length; i += 1) {
        if (myGamePiece.crashWith(myObstacles[i])) {
            return gameOver();
        }
    }
    myGameArea.clear();
    myGameArea.frameNo += 1;

    if (myGameArea.frameNo == 1 || everyinterval(150)) {
        x = myGameArea.canvas.width;
        myObstacles.push(new component(30, obstaclesRands[index%30].height, arrayColor[Math.floor(Math.random() * 6)], x, 0));
        myObstacles.push(new component(30, x - obstaclesRands[index%30].height - obstaclesRands[index%30].gap, arrayColor[Math.floor(Math.random() * 6)], x, obstaclesRands[index%30].height + obstaclesRands[index%30].gap));
        index++


    }

    for (i = 0; i < myObstacles.length; i += 1) {
        myObstacles[i].x += -1;
        myObstacles[i].update();
    }
    myScore.text="SCORE: " + myGameArea.frameNo;
    myScore.update();
    myGamePiece.newPos();
    myGamePiece.update();
    updateForDrawPlayers();
}

function updateForDrawPlayers() {
    ctx = myGameArea.context;


    for(var i=0; i<drawQueue.length; i++){
        var data = drawQueue[i];

        ctx.globalAlpha = 1;
        ctx.strokeStyle = "black";
        ctx.strokeRect(data.x, data.y, data.width, data.height);

        ctx.globalAlpha = 0.5;
        ctx.fillStyle = data.color;
        ctx.fillRect(data.x, data.y, data.width, data.height);
    }
    drawQueue = [];
    ctx.globalAlpha = 1;
}

function everyinterval(n) {
    if ((myGameArea.frameNo / n) % 1 == 0) {return true;}
    return false;
}

function accelerate(n) {
    myGamePiece.gravity = n;
}

var movement = {
    up: false,
    down: false,
    left: false,
    right: false
}

document.addEventListener('keydown', function (event) {
    switch (event.keyCode) {
        case 65: // A
            movement.left = true;
            myGamePiece.speedX = -1;
            break;
        case 87: // W
            movement.up = true;
            myGamePiece.speedY = -1;

            break;
        case 68: // D
            movement.right = true;
            myGamePiece.speedX = 1;
            break;
        case 83: // S
            movement.down = true;
            myGamePiece.speedY = 1;
            break;
    }
});