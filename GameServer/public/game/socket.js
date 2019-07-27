
var theUser = this;

theUser.rooms = {};

var randomSabstacles = [];
var minHeight = 20;
var maxHeight = 200;
var minGap = 50;
var maxGap = 200;

for (var i=0; i<30; i++){
    randomSabstacles.push({
        height: Math.floor(Math.random()*(maxHeight-minHeight+1)+minHeight),
        gap: Math.floor(Math.random()*(maxGap-minGap+1)+minGap)
    });
}

exports.socketConnection = function(http){
    var io = require('socket.io')(http);
    console.log("we waiting for user Connection");
    io.on('connection', function(socket){
        socket.on('room', function(room) {

            if (!theUser.rooms[room] || !theUser.rooms[room].onGame) theUser.rooms[room] = {
                onGame: true,
                gameScores: [],
                deadPlayers: [],
                numConnectedPlayers: 0,
                numReadyPlayers: 0
            };
            theUser.rooms[room].numConnectedPlayers++;

            console.log('user connected to room ', room, ', there are ', theUser.rooms[room].numConnectedPlayers,' connected users');
            socket.join(room);

            io.sockets.in(room).emit('numofPlayersConnected', theUser.rooms[room].numConnectedPlayers);
        });

        socket.on('UpdateDataFromAllClients', function (data){
            socket.broadcast.emit('UpdateDataFromAllClients', data);
        });

        socket.on('Ready', function (room){
            theUser.rooms[room].numReadyPlayers++;
            io.sockets.in(room).emit('numReadyPlayers', theUser.rooms[room].numReadyPlayers);

            if (theUser.rooms[room].numConnectedPlayers != 0 && theUser.rooms[room].numConnectedPlayers == theUser.rooms[room].numReadyPlayers) {
                io.sockets.in(room).emit('startGame', randomSabstacles);
            }
        });

        socket.on("playerDead", function(data){
            var room = data.room;
            theUser.rooms[room].gameScores.push(data);


            if (theUser.rooms[room].gameScores.length == theUser.rooms[room].numReadyPlayers) {
                theUser.rooms[room].onGame = false;
                io.emit("showScores");
            }
        });

        socket.on('disconnect', function(){
            var currentRoom = socket.rooms[Object.keys(socket.rooms)[0]];
            console.log('The User disconnected from room', currentRoom);

            if (!theUser.rooms[currentRoom] || !theUser.rooms[currentRoom].numConnectedPlayers) return;
            theUser.rooms[currentRoom].numConnectedPlayers--;
            io.sockets.in(currentRoom).emit('numofPlayersConnected',theUser.rooms[currentRoom].numConnectedPlayers);
        });

    });
}