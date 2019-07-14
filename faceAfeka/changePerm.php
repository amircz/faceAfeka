<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	session_start();
	$user_id = $_SESSION["user_id"];
	$post_id = $_POST["post_id"];
	updatePermInDb($post_id);
}

function updatePermInDb($postId)
{
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
	
	
	$res=@mysqli_query($sql,"SELECT posts.private FROM posts WHERE post_id='".$postId."'") or die("<BR>ERROR: incorrect query!");
	//if we got a row, then we got a match
	if (mysqli_num_rows($res)>0)
	{
		$post_row=mysqli_fetch_array($res);
		@mysqli_close($sql);
		$oldVal = $post_row["private"];
	}
	
	if($oldVal == 1)
		$newVal = 0;
	else
		$newVal = 1;
	
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
		
		
	$update_query="UPDATE posts SET private = '".$newVal."' WHERE post_id = '".$postId."'";
	$result=@mysqli_query($sql,$update_query);  //execute the query
		
		
	if (mysqli_affected_rows()==0)  //if insertion was ok
			return false;
		else
			return true;
}