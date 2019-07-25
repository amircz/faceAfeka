<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST["rpass"]))
{
	// echo "post successful";
	$user =$_POST["un"];
	$pass =CalculatePassword($_POST["pass"]);
	// echo $pass; 
	CheckUserPassword($user, $pass);
}

else if (($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["rpass"])))
{
	$user =$_POST["un"];
	$pass =CalculatePassword($_POST["pass"]);
	$pic;
	if(!empty($_FILES['files']))
		$pic = 'a';
	
	else 
		$pic = "";
	
	if(CheckUserExsits($user))
		echo "username already exsit";
	else
		AddNewUser($user, $pass, $pic);		
}

function CalculatePassword($pass)
{
	$pass=$pass[0].$pass.$pass[0];  //adding the first letter of the password to the begining and ending of the password string. (For example: "1234" => "112341")
	$pass=md5($pass);  //encrypts the password
	return $pass;
}

/* Checks the user and password for match. */
function CheckUserPassword($user,$pass)
{
	if ($user=="" || $pass=="")  //if empty user or password
		return false;
		
		/*** CHANGE: host, user, password and db ***/
		$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to mysqli server!");  //connect to mysqli server
		@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
		
		
		$res=@mysqli_query($sql,"SELECT user_id, userName FROM users WHERE (userName='".$user."' AND password='".$pass."')") or die("<BR>ERROR: incorrect query! - CheckUserPassword");
		//if we got a row, then we got a match
		if (mysqli_num_rows($res)==1)
		{
			$us=mysqli_fetch_array($res);
			echo "login seccesful";
			session_start();
			$_SESSION["authenticated"] = 'true';
			$_SESSION["userName"] = $us["userName"];
			$_SESSION["user_id"] = $us["user_id"];
			//header('Location: MainPage.php');
			return true;
		}
		else
			//echo "Username or password are inncorect";//if we got to here, we got no row, then there is no match
			return false;

		@mysqli_close($sql);
}

function CheckUserExsits($user)
{
	if ($user=="")  //if empty user or password
		return false;
		
		$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to mysqli server!");  //connect to mysqli server
		@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
				
		$res=@mysqli_query($sql,"SELECT userName FROM users WHERE (userName='".$user."')") or die("<BR>ERROR: incorrect query! - CheckUserExsits");
		//if we got a row, then we got a match
		if (mysqli_num_rows($res)==1)	
			return true;
		else
			return false;
		
		@mysqli_close($sql);
}

function AddNewUser($user, $pass, $pic)
{
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to mysqli server!");  //connect to mysqli server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
	if($pic != "")
	{
		$imagesPath =getImagePath($user);
		$insert_query="INSERT INTO users (userName, password, img) VALUES ('".$user."', '".$pass."', '".$imagesPath."')";
	}
	else
		$insert_query="INSERT INTO users (userName, password) VALUES ('".$user."', '".$pass."')";
	$result=@mysqli_query($sql,$insert_query);  //execute the query
	
	if (mysqli_affected_rows($sql)==1)  //if insertion was ok
	{
		session_start();
		$_SESSION["added"] = 'true';
		// echo "<BR><B>Student data saved successfully.</B><BR>";
		header("Location: http://localhost/faceAfeka/login.php");
		die();
	}

	else  //if insertion was not ok
		echo "insert faild";

}

function getImagePath($user) {
	$imagesPath = "";
	$target_path = "faceAfeka/userPic/";
	
	
		$validextensions = array (
				"jpeg",
				"jpg",
				"png" 
		); // Extensions which are allowed.
		$ext = explode ( '.', basename ( $_FILES ['files'] ['name'] ) ); // Explode file name from dot(.)
		$file_extension = end ( $ext ); // Store extensions in the variable.
		$imagesPath = $target_path . $user.".".$file_extension;
		if (in_array ( $file_extension, $validextensions )) {
			move_uploaded_file ( $_FILES ['files'] ['tmp_name'] , $_SERVER ['DOCUMENT_ROOT']."/".$imagesPath);
		}
	

		createThumbs ( $_SERVER ['DOCUMENT_ROOT']."/".$target_path, $_SERVER ['DOCUMENT_ROOT']."/".$target_path, 200 );
		return "userPic/".$user.".".$file_extension;
}


function createThumbs($pathToImages, $pathToThumbs, $thumbWidth)
{
	$dir = opendir( $pathToImages );
	while (false !== ($fname = readdir( $dir ))) {
		$info = pathinfo($pathToImages . $fname);
		$img = false;
		if (strtolower($info['extension']) == 'jpg') {
			$img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		} elseif (strtolower($info['extension']) == 'png') {
			$img = imagecreatefrompng( "{$pathToImages}{$fname}" );
		} elseif (strtolower($info['extension']) == 'gif') {
			$img = imagecreatefromgif( "{$pathToImages}{$fname}" );
		}
		if ($img) {
			$width = imagesx( $img );
			$height = imagesy( $img );
			$new_width = $thumbWidth;
			$new_height = floor( $height * ( $thumbWidth / $width ) );
			$tmp_img = imagecreatetruecolor( $new_width, $new_height );
			imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
			
			if (strtolower($info['extension']) == 'jpg') {
				imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
			}
			else if (strtolower($info['extension']) == 'png') {
				imagepng( $tmp_img, "{$pathToThumbs}{$fname}" );
			}
			else if (strtolower($info['extension']) == 'gif') {
				imagegif( $tmp_img, "{$pathToThumbs}{$fname}" );
			}
			imagedestroy($img);
			imagedestroy($tmp_img);
		}
	}
	closedir( $dir );
}