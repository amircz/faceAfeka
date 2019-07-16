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
var nodemailer = require('nodemailer');

app.set('port', 5000);
app.use('/static', express.static(__dirname + '/static'));
app.use(function (req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});

//var selected_option_value = oSelectOne.options[index].value;

var mysql = require('mysql');

var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  database: "faceAfeka"
});

var transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: 'faceafeka1@gmail.com',
      pass: 'afeka2016'
    }
  });

// app.use(cors);
app.get('/', function (request, response) {
    response.sendFile(path.join(__dirname, 'Game View.html'));
});

app.get("/:mail",function(req, res){

    var mail=req.params.mail;
    
    var mailOptions = {
        from: 'faceafeka1@gmail.com',
        to: mail,
        subject: 'Sending Email using Node.js',
        text: 'Play with me. Go to link: http://localhost:5000'
      };

    transporter.sendMail(mailOptions, function(err, info){
        console.log('Email sent: ' + info.response);
      });
      res.send("success");
});

app.get("/users/:userName",function(request,response){
    var userId;
    console.log("request.params.userName = " + request.params.userName);
    con.connect(function(err) {
        if (err) throw err;
        con.query("SELECT user_id FROM users WHERE username='" + request.params.userName + "'", function (err, result, fields) {
            if (err) throw err;
            else{
                userId = result[0].user_id;
                con.query('SELECT following_user FROM friends WHERE followed_user=' + userId, function (err, result, fields) {
                    if (err) throw err;
                    else{
                        var friendsId = [];
                        result.map((friend) => {
                            var friendId = friend.following_user;
                            friendsId.push('"' + friendId + '"');
                            // friends.push();
                        });
                        con.query('SELECT username FROM users WHERE user_id IN (' + friendsId.join(',') + ')', function (err, result, fields) {
                            if (err) throw err;
                            else{
                                var comboBoxDetails = [];
                                result.map((friend) => {
                                    var friendUsername = friend.username;
                                    comboBoxDetails.push(friendUsername);
                                });
                                response.send(comboBoxDetails);
                            }
                        });
                        
                        // async.map(result,(friend) => {})
                        // con.query('SELECT username FROM users WHERE user_id=' + , function (err, result, fields) {});
                    }
                });
            }
        });
      });  
      
    // var comboBoxDetails = db_utils.getFriendsByUserName(request.params.userName);
    // console.log("comboBoxDetails = " +comboBoxDetails);
    
    // return comboBoxDetails;
});

  

io.on("connection", socket => {
    socket.on('new player', function (name) {
        var color = colors[num_of_players];
        socket.emit('color', color);
        players[socket.id] = new player(name, color, 0);
        num_of_players++;
        if (2 - num_of_players > 0) {
            io.sockets.emit('waiting', 2 - num_of_players)
        } else {
            io.sockets.emit('start game');
        }

    });

    socket.on('end game', points => {
        players[socket.id].score = points;
        num_of_players_finish++
        if (num_of_players_finish == 2) {
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