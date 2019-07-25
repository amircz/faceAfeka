<?php 
//include 'MainPage.php';
//addPostBtn
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	session_start();
	$post_username = $_SESSION["userName"];
	$post_user_id = $_SESSION["user_id"];
	//$date;
	$private = getPrivatePublic($_POST["radio"]);
	$content = $_POST["textArea"];
	$images = "";

	$images = getImagePath($post_username,$_FILES);
	$loca = $_POST["check"];
	if(getCheckIn($loca) == 1){
		$location = getLocation();
		$content .= "- At ".$location;
	}
	echo "Adding post to db";
	addPostToDB($post_username, $post_user_id, $private, $content, $images, $location);
}


function getCheckIn($loca)
{
	if($loca == 'yes')
		return 1;

		return 0;
}




function getPrivatePublic($private)
{
	if($private == 'private')
		return 1;
		
		return 0;
}

function getLocation()
{
	
	$ipAddress = explode(' ',explode(':',explode('inet addr',explode('wlan0',trim(`ifconfig`))[1])[1])[1])[0];
	$url = 'http://ipinfo.io/'.$ipAddress;
	$ch = curl_init($url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$ret_array = json_decode($data,TRUE);
	$add = $ret_array['city'].','.$ret_array['country'];
	return $add;
}



function addPostToDB($post_username, $post_user_id, $private, $content, $imagesPath, $location) {
	$sql = @mysqli_connect ( "localhost", "root", "" ) or die ( "<BR>ERROR: cannot connect to MySQL server!" ); // connect to MySQL server
	@mysqli_select_db ($sql, "faceafeka" ) or die ( "<BR>ERROR: cannot use the DB!" ); // selects the DB
	$d = new DateTime ( '', new DateTimeZone ( 'Asia/Jerusalem' ) );
	$r = $d->format ( 'Y-m-d H:i:s' );
	$insert_query = "INSERT INTO posts (user_id, date, private, content, images, likes, location,comments)
					VALUES ('" . $post_user_id . "', '" . ( string ) $r . "', '" . $private . "', '" . $content . "', '" . $imagesPath . "', '0', '" . $location . "', '0')";
	echo $r;
	echo $insert_query;
	$result = @mysqli_query ($sql,$insert_query ); // execute the query
	
	if (mysqli_affected_rows () == 0) // if insertion was ok
		return false;
		else
			return true;
			// buildPosts();
}

function getImagePath($post_username,$img)
{
	echo "<script>alert('a');</script>";
	$imagesPath = "";
	if (! file_exists ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username ))
		mkdir ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages");
	if (! file_exists ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username ))
		mkdir ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username );
	if (! file_exists ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username . "/img" ))
		mkdir ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username . "/img" );
	if (! file_exists ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username . "/thumbs" ))
		mkdir ( $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username . "/thumbs" );
				
	$target_path = $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username . "/img/";
	$pathToThumbs = $_SERVER ['DOCUMENT_ROOT'] . "/faceAfeka/PostsImages/" . $post_username . "/thumbs/";
				if(is_array($img))
				{
					foreach($_FILES['files']['name'] as $name => $value)
					{
						$validextensions = array("jpeg", "jpg", "png");      // Extensions which are allowed.
						$ext = explode('.', basename($_FILES['files']['name'][$name]));   // Explode file name from dot(.)
						$file_extension = end($ext); // Store extensions in the variable.
						$imagesPath .= basename($_FILES['files']['name'][$name])."@";
						if(in_array($file_extension, $validextensions))
						{
							move_uploaded_file($_FILES['files']['tmp_name'][$name], $target_path.$_FILES['files']['name'][$name]);
						}
					}
				}
				createThumbs($target_path, $pathToThumbs, 200);
				return $imagesPath;
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
?>