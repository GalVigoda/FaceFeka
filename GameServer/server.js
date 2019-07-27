var express = require('express');
var bodyParser = require('body-parser')
var app = express();
var path = require('path');
var http = require('http').Server(app);

var CONFIG = require('./config');
var socket = require('./public/game/socket');


app.set('port', CONFIG.SERVER_PORT);
app.set('views', path.join(__dirname, 'views'));
app.use(express.static(path.join(__dirname, 'public')));
app.set('view engine', 'jade');
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());



app.get('/', function(req, res){
    res.sendFile(__dirname + '/views/lobby.html');
});

app.post('/game', function(req, res){

    res.render('game', {
        name: req.body.firstName,
        color: req.body.color,
        numReadyPlayers: socket.rooms[req.body.roomNumber]?socket.rooms[req.body.roomNumber].numReadyPlayers : 0,
        numConnectedPlayers: socket.rooms[req.body.roomNumber]?socket.rooms[req.body.roomNumber].numConnectedPlayers : 1,
        roomNumber: req.body.roomNumber
    });
});

app.get('/invite', function(req, res){

    res.render('game', {
        name: req.query.firstName,
        color: req.query.color,
        numReadyPlayers: socket.rooms[req.query.roomNumber]?socket.rooms[req.query.roomNumber].numReadyPlayers : 0,
        numConnectedPlayers: socket.rooms[req.query.roomNumber]?socket.rooms[req.query.roomNumber].numConnectedPlayers : 1,
        roomNumber: req.query.roomNumber
    });
});

app.get('/scores', function(req, res){
    var scores = socket.rooms[req.query.roomNumber].gameScores;

    //sort by score descending
    scores.sort(function(a, b) {
        return parseFloat(b.score) - parseFloat(a.score);
    });

    res.render('scores', {scores: scores});
});


http.listen(app.get('port'), function(){
    console.log('server listening on port ' + app.get('port'));
    socket.socketConnection(http);
});

