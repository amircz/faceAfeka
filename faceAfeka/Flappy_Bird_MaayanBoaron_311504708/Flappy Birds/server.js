var express = require('express');
var http = require('http');
var path = require('path');
var socketIO = require('socket.io');
const db_utils = require('./demo_db_connection');
// var cors = require('cors');
var app = express();
var server = http.Server(app);
var io = socketIO(server);
var players = [];
let colors = ["red", "blue", "pink"];
var num_of_players = 0;
var num_of_players_finish = 0;
app.set('port', 5000);
app.use('/static', express.static(__dirname + '/static'));
// app.use(cors);
app.get('/', function (request, response) {
    response.sendFile(path.join(__dirname, 'Game View.html'));
});

app.get("/users/:userName",function(request,response){
    var comboBoxDetails = db_utils.getFriendsByUserName(request.params.userName);
    console.log("comboBoxDetails = " +comboBoxDetails)
    // response.send(comboBoxDetails);
    return comboBoxDetails;
});

io.on("connection", socket => {
    socket.on('new player', function (name) {
        var color = colors[num_of_players];
        socket.emit('color', color);
        players[socket.id] = new player(name, color, 0);
        num_of_players++;
        if (3 - num_of_players > 0) {
            io.sockets.emit('waiting', 3 - num_of_players)
        } else {
            io.sockets.emit('start game');
        }

    });

    socket.on('end game', points => {
        players[socket.id].score = points;
        num_of_players_finish++
        if (num_of_players_finish == 3) {
            var list = [];
            for (var key in players) {
                list.push(players[key]);
            }
            io.sockets.emit('finish', list);
            num_of_players = 0;
            num_of_players_finish = 0;
            players = [];
        }

    });
});

server.listen(5000, function () {
    console.log('Starting server on port 5000');
});

function player(name, color, score) {
    this.name = name;
    this.color = color;
    this.score = score;
}