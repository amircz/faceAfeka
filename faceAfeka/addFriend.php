<?php
session_start();
$friend_user_id = $_POST['user_id'];
$current_user_id = $_SESSION["user_id"];

$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB

$res=@mysqli_query($sql,"SELECT * FROM friends WHERE (followed_user ='".$friend_user_id."' AND following_user = '".$current_user_id."')") or die("<BR>ERROR: incorrect query!");

if (mysqli_num_rows($res) == 0)
{
	$insert_query="INSERT INTO friends (followed_user, following_user) VALUES ('".$friend_user_id."', '".$current_user_id."')";
	$result=@mysqli_query($sql,$insert_query);  //execute the query
	
	$insert_query="INSERT INTO friends (followed_user, following_user) VALUES ('".$current_user_id."', '".$friend_user_id."')";
	$result=@mysqli_query($sql,$insert_query);  //execute the query
}