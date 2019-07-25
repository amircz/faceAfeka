<?php
//include 'MainPage.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	session_start();
	$user_id = $_SESSION["user_id"];
	$post_id = $_POST["post_id"];
	$num_like = $_POST["num_like"];
	if(checkIfAlreadyLike($post_id, $user_id))
	{
		updateLikeInDB($post_id, $num_like+1, $user_id);
		echo 'true';
	}
	else
		echo 'false';
}

function checkIfAlreadyLike($post_id, $user_id)
{
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the d!");  //selects the DB
	
	$res=@mysqli_query($sql,"SELECT * FROM likes WHERE (user_id = '".$user_id."' AND post_id = '".$post_id."')") or die("<BR>ERROR: incorrect query!");
	
	if (mysqli_num_rows($res)>0)
		return false;
		
		return true;
}

function updateLikeInDB($post_id, $num_like, $user_id)
{
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DATABASE!");  //selects the DB
	
	$update_query="UPDATE posts SET likes = '".$num_like."' WHERE post_id = '".$post_id."'";
	$result=@mysqli_query($sql,$update_query);  //execute the query
	
	$insert_query="INSERT INTO likes (user_id, post_id) VALUES ('".$user_id."', '".$post_id."')";
	$result=@mysqli_query($sql,$insert_query);  //execute the query
	
	if (mysqli_affected_rows()==0)//if insertion was ok
		return false;
		
		else
			return true;
}