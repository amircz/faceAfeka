var mysql = require('mysql');

var con = mysql.createConnection({
  host: "localhost ",
  user: "root",
  database: "faceAfeka"
});


exports.getFriendsByUserName =  function(username){
    var friends = [];
    var userId;
    
    var comboBoxDetails = [];
    
    con.connect(function(err) {
        if (err) throw err;
        con.query("SELECT user_id FROM users WHERE username='" + username + "'", function (err, result, fields) {
            if (err) throw err;
            else{
                userId = result[0].user_id;
                con.query('SELECT following_user FROM friends WHERE followed_user=' + userId, function (err, result, fields) {
                    if (err) throw err;
                    else{
                        result.map((friend) => {
                            var friendId = friend.following_user;
                            // friends.push();
                            con.query('SELECT username FROM users WHERE user_id=' + friendId, function (err, result, fields) {
                                if (err) throw err;
                                else{
                                    console.log("result = " + JSON.stringify(result));
                                    comboBoxDetails.push(result[0].username);
                                    comboBoxDetails.push("zafrir.freits@gmail.com")
                                    console.log("comboBoxDetails = " + comboBoxDetails);
                                }
                            });

                        });
                        // async.map(result,(friend) => {})
                        // con.query('SELECT username FROM users WHERE user_id=' + , function (err, result, fields) {});
                    }
                });
            }
        });
      });    
}

// con.connect(function(err) {
//   var friends;
//   if (err) throw err;
//   con.query("SELECT user_id FROM users WHERE username=", function (err, result, fields) {
//     if (err) throw err;
//     let friends = result;
//     console.log(result);
//   });
//   con.query("SELECT user_id FROM users WHERE username=", function (err, result, fields) {
//     if (err) throw err;
//     console.log(result);
//   });
// });