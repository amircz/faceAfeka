<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	session_start();
	$user_id = $_SESSION["user_id"];
	$post_id = $_POST["post_id"];
	$content = $_POST["commCont"];
	addCommentToDb($post_id,$user_id,$content);
	updateCommentInDB($post_id);
	
}

function addCommentToDb($post_id,$user_id,$content)
{
	$sql = @mysqli_connect ( "localhost", "root", "" ) or die ( "<BR>ERROR: cannot connect to MySQL server!" ); // connect to MySQL server
	@mysqli_select_db ($sql,"faceafeka") or die ( "<BR>ERROR: cannot use the DB!" ); // selects the DB
	$date = new DateTime ( '', new DateTimeZone ( 'Asia/Jerusalem' ) );
	$r = $date->format ( 'Y-m-d H:i:s' );
	
	$insert_query = "INSERT INTO comments (post_id, user_id, content,date)
					VALUES ('" . $post_id . "', '" . $user_id . "', '" . $content."','" . ( string ) $r . "' )";
	$result = @mysqli_query ($sql,$insert_query,);
	if (mysqli_affected_rows () == 0) // if insertion was ok
		return false;
	else
		return true;
	
}

function updateCommentInDB($post_id)
{
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB

	
	$res=@mysqli_query($sql,"SELECT comments FROM posts WHERE post_id='".$post_id."'") or die("<BR>ERROR: incorrect query!");
	//if we got a row, then we got a match
	if (mysqli_num_rows($res)>0)
	{
		$post_row=mysqli_fetch_array($res);
		@mysqli_close($sql);
		$oldVal = $post_row["comments"];
	}
	
	$newVal = $oldVal +1;
	
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
	
	
	$update_query="UPDATE posts SET comments = '".$newVal."' WHERE post_id = '".$post_id."'";
	$result=@mysqli_query($sql,$update_query);  //execute the query

	
	if (mysqli_affected_rows()==0)  //if insertion was ok
			return false;
		else
			return true;
	
}