var twit = require('twit');  
var config = require('./config.js');  
var Twitter = new twit(config);  
var fs = require('fs');

var stream = Twitter.stream('user');
var trackHash = '#Karin_FaceAfeka_Avi';

//watson
var ToneAnalyzerV3 = require('watson-developer-cloud/tone-analyzer/v3');
var tone_analyzer = new ToneAnalyzerV3({
	username: "a13bc1aa-3c17-4c66-b420-2e9046b204a0",
	password: "ISRwOcTHHO4i",
	version_date: '2017-06-11',
	headers: {
		'X-Watson-Learning-Opt-Out': 'true'
	}
});

// FOLLOW-Reply BOT ===========================

// when someone follows
stream.on('follow', followed);

// ...trigger the callback
function followed(event) {  
  console.log('Follow Event is running');
  //get their twitter handler (screen name)
  var
    name = event.source.name,
    screenName = event.source.screen_name;
  // function that replies back to the user who followed
  tweetNow('@' + screenName + ' Thank you for the follow up.');
}

var stream = Twitter.stream('statuses/filter', { track: trackHash })
 
stream.on('tweet', function (tweet) {
  console.log("Found")
  //var params = { id: tweet.id_str, status: "i tweet back"}
  console.log(tweet.text)
  processTweet(tweet.text)
})

function processTweet(tweetText) {
	tweetText = tweetText.substring(0,tweetText.length - trackHash.length);
	console.log(tweetText);
	
	//var tone_analyzer = new ToneAnalyzerV3(auth.ToneAnalyzerV3);
	var params = {
	// Get the text from the JSON file.
	text: tweetText,
	// tones: 'emotion'
	};
	tone_analyzer.tone(params, function(error, response) {
		if (error){
			console.log('error:', error);
		}
		//console.log(JSON.stringify(response, null, 2));
		var cats=response.document_tone.tone_categories;
		var emo;
		var count = 0;
		
		cats[0].tones.forEach(function(tone){
			//console.log(cat.category_name);
			//cat.tones.forEach(function(tone){
				console.log(" %s: %s",tone.tone_name,tone.score)
				if(tone.score > count)
				{
					count = tone.score;
					emo = tone.tone_name;
				}
			})
		
		
		console.log("emo = " + emo + ": " + count);
		googleSearch(emo, tweetText);
	}); 
}

function googleSearch(emo, tweetText)
{
	var child_process = require('child_process');
	var search = tweetText + " " + emo;
    var child = child_process.execSync("powershell.exe fim '" + search + "' -d pic -n 3").toString();
    var arr = child.trim().split("\n");
	console.log(arr);
	addToDB(arr, tweetText);
}

function addToDB(arr, tweetText)
{
	const path = require('path');
	var mysql = require('mysql')
	var connection = mysql.createConnection({
		host : 'localhost',
		user : 'root',
		password : '',
		database : 'faceafeka'
	});
	var img;
	for (var i = 0; i < arr.length; i ++)
	{
		if(i == 0 )
			img = makeid(arr[i]) + "@";
		else
			img += makeid(arr[i]) + "@";
		console.log("after :" + img);
	}
		
	connection.connect();
	connection.query("INSERT INTO posts (user_id, private, content, images, likes, location,comments) VALUES ('1', '0', '" + tweetText + "', '" + img + "', '0', '', '0')", function (err, rows, fields)
	{
		if (err) throw err
		console.log('insert secussesful');
	})
	connection.end();	
}

function makeid(file) {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var path = require('path');
  var fs = require('fs');
  var Jimp = require("jimp");
	
	file = file.trim().split("\\");
	file = file[1];
	
	for (var i = 0; i < 5; i++)
		text += possible.charAt(Math.floor(Math.random() * possible.length));

	var filename = text + '.jpg';	

	fs.createReadStream('pic/' + file).pipe(fs.createWriteStream('PostsImages/avi/img/'+filename));
	
	Jimp.read('pic/' + file, function (err, lenna) {
		if (err) throw err;
		lenna.resize(200, 200)            // resize
			 .write('PostsImages/avi/thumbs/'+filename); // save
	});
	console.log(filename);
  return filename;
}

