<?php
session_start();
require 'Post.php';
require 'Comment.php';
$username;
$user_id;
$user_pic;
$posts = array();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
	header('Location: login.php');
}

else
{
	$username = $_SESSION["userName"];
	$user_id = $_SESSION["user_id"];
	$user_pic = getUserPic($user_id);
	GetPost($username, $user_id, $posts);
}

function getUserPic($user_id)
{
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
	
	
	$res=@mysqli_query($sql,"SELECT img FROM users WHERE user_id='".$user_id."'") or die("<BR>ERROR: incorrect query! - getUserPic");
	//if we got a row, then we got a match
	if (mysqli_num_rows($res)>0)
	{
		$post_row=mysqli_fetch_array($res);
		@mysqli_close($sql);
		return $post_row["img"];
	}
}

function getCommentsTxt($num)
{
	if($num == 0)
		return "No comments to show";
		return "This post has ".$num." comments";
}


function GetCurPerm($private)
{
	if($private == 1)
		return "This post is private";
		return "This post is public";
}

function GetPost($username, $user_id, &$posts)
{
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to mysqli server!");  //connect to mysqli server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
	
	
	$res=@mysqli_query($sql,"SELECT distinct posts.post_id, posts.user_id, posts.date, posts.private,
					   posts.content, posts.images, posts.likes,
					   posts.location,posts.comments, users.userName FROM posts, friends, users
					   WHERE posts.user_id='".$user_id."' AND users.user_id='".$user_id."' OR (friends.following_user='".$user_id."'
					   AND posts.user_id=friends.followed_user AND users.user_id=posts.user_id)
					   ORDER BY date DESC
					   LIMIT 8") or die("<BR>ERROR: incorrect query! - GetPost");
	//if we got a row, then we got a match
	if (mysqli_num_rows($res)>0)
	{
		while ($post_row=mysqli_fetch_array($res))  //as long as there are rows in the result
		{
			$post_username = $post_row["userName"];
			$post_id = $post_row["post_id"];
			$post_user_id = $post_row["user_id"];
			$date = $post_row["date"];
			$private = $post_row["private"];
			$content = $post_row["content"];
			$images = $post_row["images"];
			$likes = $post_row["likes"];
			$location = $post_row["location"];
			$comments_num = $post_row["comments"];
			
			array_push($posts, new Post($post_username, $post_id, $post_user_id, $date,
					$private, $content, $images, $likes, $location,$comments_num));
		}
	}
	
	
	else
		//echo "Username or password are inncorect";//if we got to here, we got no row, then there is no match
		
		@mysqli_close($sql);
}

function GetComments($postId,$userId,&$comments)
{
	$sqlQ=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to mysqli server!");  //connect to mysqli server
	@mysqli_select_db($sqlQ,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
	
	$result = @mysqli_query("SELECT comments.comment_id, comments.post_id, comments.user_id, comments.content,
							comments.date FROM comments
					  		WHERE comments.post_id = '".$postId."' ORDER BY date DESC",$sqlQ) or die("<BR>ERROR: incorrect query! - GetComments");
	
	if (mysqli_num_rows($result)>0)
	{
		while ($com_row=mysqli_fetch_array($result))  //as long as there are rows in the result
		{
			$sqlQ=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to mysqli server!");  //connect to mysqli server
			@mysqli_select_db($sqlQ,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
			$user_id = $com_row["user_id"];
			$name1 = @mysqli_query("SELECT users.userName FROM users WHERE users.user_id = '".$user_id."'",$sqlQ) or die("<BR>ERROR: incorrect query!");
			$name = mysqli_fetch_array($name1);
			$comment_id = $com_row["comment_id"];
			$post_id = $com_row["post_id"];			
			$content = $com_row["content"];
			$date = $com_row["date"];
			$userImg = getUserPic($user_id);
			
			array_push($comments, new Comment($comment_id, $post_id, $user_id, $name["userName"], $content, $date,$userImg));
		}
	}
	
	
	else
		echo "pull comments failed";//if we got to here, we got no row, then there is no match
		
		
}

function buildCommentsTables($username1,$post_id,$comments)
{
	foreach ($comments as $com)
	{
		echo "<table align='center' class = 'table-content' style = 'border-style: solid;' width = '500px'>";
		if($com->getPost_id() == $post_id)
		{
			echo "<tr colspan = '2'>";
			echo "<td>".$com->getDate()."</td>
				  </tr>";
			echo "<tr>";
			echo "<td><img src = '".$com->getImg()."' height = '20px' width = '20px'>".$com->getUser_name()." says:</td>
					</tr>";
			echo "<tr>
					<td colspan = '2'>".$com->getContent()."</td>
				  </tr>";			
		}
		echo "</table>";
	}	
}


function buildPostsTables($username, $posts)
{
	foreach ($posts as $post) {
		if($post->getPost_username() == $username ||
				($post->getPost_username() != $username && !$post->getPrivate()))
		{
			$comments = array();
			if($post->getcomments_num()>0)
				GetComments($post->getPost_id(),$post->getPost_user_id(),$comments);
				
				
				
				echo "<table align='center'  class = 'table-content' style = 'border-style: solid;' width='900'>";
				
				//username & date
				echo "<tr>
					  	<td><p style='text-align:left;'><h3 style = 'display:inline'>".$post->getPost_username().
					  	"</h3><span name = 'result' style='float:right;'><h5 style = 'display:inline'>".GetCurPerm($post->getPrivate())." - ".$post->getDate()."</h5></span></p><hr></td>
				</tr>";
				
				//content
				echo "<tr>
					   <td style = 'word-wrap:break-word; max-width: 330px;'><h3><font color = 'blue'>".$post->getContent()."</font></h3><hr></td>
				  </tr>";
				
				//images
				$index = 1;
				foreach ($posts as $curPost)
				{
					if($curPost->getPost_id() == $post->getPost_id()){
						if($post->getImagesPath()!= ""){
							echo "<tr>";
							echo "<td align='center'>";
							$counter = 0;
							$pathThumbs = "PostsImages/".$post->getPost_username()."/thumbs";
							$pathImages = "PostsImages/".$post->getPost_username()."/img";
							$dir = opendir($pathThumbs);
							$curImg = explode("@",$post->getImagesPath());
							
							foreach ($curImg as $img){
								if($img != "")
								{
									
									echo "<a href = ".$pathImages.'/'.$img." data-lightBox = 'gallery".$index."' data-title = 'Images'>";
									echo "<img src = ".$pathThumbs.'/'.$img." height = '150px' width = '150px'/>";
									echo "</a>&nbsp&nbsp";
									
									$counter += 1;
									if($counter %3 == 5)
										break;
								}
							}
							echo "<hr></td>";
							echo "</tr>";
							closedir($dir);
						}						
					}
					$index++;					
				}
				
				//likes & comments
				echo "<FORM action='addLike.php' method='POST' id='like'>";
				echo "<tr>";
				
				echo "<td> <a class = 'hideLikes'>
								<element id='like".$post->getPost_id()."'>".$post->getLikes_num()."</element>
								<span class = 'showHideLikes'>Likes List:</br>
									<span class = 'showBodyHideLikes'>".buildLikeList($post)."</span>
								</span>
						   </a>
							  <input type= 'image' src = 'images/likeBlue.png' class='like' onClick='likeClicked()' value='".$post->getLikes_num()."' id='like' name = '".$post->getPost_id()."' height = '30px' width = '30px'></input></td>
								<input type='hidden' name='post_id' id='post_id' value='".$post->getPost_id()."'>
								<input type='hidden' name='num_like' id='num_like' value='".$post->getLikes_num()."'>";
				if($post->getPost_user_id() != $_SESSION["user_id"])
					echo "</tr>";
					echo "</FORM>";
					if($post->getPost_user_id() == $_SESSION["user_id"])	
						echo "<tr><td><input type = 'image' src = 'images/permBlue.png' id = 'perm' class= 'perm' name = '".$post->getPost_id()."' width = '150px' height ='30px' ></input></td></tr>";
					
					
					echo "<tr>";
					echo "<form action = 'addComment.php' method = 'POST' id = 'comment'>";
					echo "<tr>
								<td>
							
									<div id = 'comDiv'>
										<p id = 'show' name = '".$post->getPost_id()."Show' ><u><font color = 'blue'>".getCommentsTxt($post->getcomments_num())."</font></u></p>	
									</div>";
					
					
					echo " </td>
							  </tr>";
					echo  "<tr align = 'left'>
								<td>
									<div id = 'comm'>
										<p><font color= 'blue'>New comment:</font></p></td></tr>
										<tr align = 'right'><td>
										<input type='hidden' name='post_id' id='post_id' value='".$post->getPost_id()."'>
										<textArea class = 'commCont' id ='commCont' rows='4' cols = '50' name = '".$post->getPost_id()."'></textArea>
										<input type = 'image' src = 'images/commentBlue.png' id = 'post' class='post' height = '30px' width = '100px' name = '".$post->getPost_id()."'></input>
									</div>
								</td>
								</tr>";
					if($post->getcomments_num()>0)
					{
						echo "<tr>
								<td align = 'center'>
						    		<div class ='exposeDiv' name = '".$post->getPost_id()."Div'>";	
									buildCommentsTables($post->getPost_username(),$post->getPost_id(), $comments);
						
						echo	   "</div>
								</td>
							   </tr>";
					}
						echo "</form>";
						echo "</tr>";
						echo "</table>";
						echo "</br></br>";						
		}
	}	
}

function buildLikeList($post)
{
	$str = "";
	$likes = array();
	if($post->getLikes_num()>0)
	{
		GetLikes($post->getPost_id(),$likes); 
		foreach ($likes as $like)
		{
			$str = $str."<img style='width:25px; float:left; margin-right:6px' src='".$like[1]."'/>";
			$str = $str.$like[0]."</br>";
		}
		return $str;
	}		
}

function GetLikes($postId, &$likes)
{
	$sqlQ=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to mysqli server!");  //connect to mysqli server
	@mysqli_select_db($sqlQ,"faceafeka") or die("<BR>ERROR: cannot use the DB likes!");  //selects the DB
	
	$result = @mysqli_query($sqlQ,"SELECT users.userName, users.img FROM users, likes WHERE users.user_id = likes.user_id AND 
							likes.post_id = '".$postId."'") or die("<BR>ERROR: incorrect query!");
	
	if (mysqli_num_rows($result)>0)
	{
		while ($like_row=mysqli_fetch_array($result))  //as long as there are rows in the result
		{
			$arr = array();
			$user_name = $like_row["userName"];
			$user_pic = $like_row["img"];
			array_push($arr, $user_name);
			array_push($arr, $user_pic);
			array_push($likes, $arr);
			unset($arr);
		}
	}	
	
	else
		echo "pull comments failed!";//if we got to here, we got no row, then there is no match		
}
?>

<html>
	<head>
		<title>FaceAfeka</title>
		<link rel ="stylesheet" type="text/css" href="designMain.css"/>
		<link rel ="stylesheet" href="lightbox.css"/>	
		<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
		<meta charset = "utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body id = "b">
	<div id = "header">	
		<table style = "align-self: center; border:1; height: 50px;">
			<tr>
				<td width = "45px"><img src= "images/fpic.png" height = "45px" width="45px"></td>
				
				<FORM action="#" method="POST" id="searchUser">
					<td><input type="text" class="search" id="searchbox" rowspan = "3" placeholder = "Search your friends..." size = "50px" /></td>
				</FORM>
				
				<td width = "1100px"></td>
				<td width= "50px"><label for = "name" ><?php echo $username; ?></label></td>
				<td><img src= "<?php echo $user_pic; ?>" height = "45px" width="45px" ></td>
				<td>				
					<form action="logout.php" method="POST" id="formLog">
						<div id="submitForm">
							<input type="image" src = 'images/newlog.png' height = "45px" width = "45px"  name = "log" id = "log"/>
						</div>
					</form >		
				</td>
			</tr>	
		</table>
		<div id="display">
	</div>
	</div>
	
	<div class = "scroller">
	<FORM action="addPost.php" method="POST" id="addPost">
	<table align="center">	
		<tr>
			<td colspan = "4" id = "posts">
				<textarea class="fill-form-font" name = "textArea" id = "textArea" cols = "60" rows = "5" placeholder = "Write new post..."></textarea>
			</td>
		</tr>
		<tr align="center">
			<td><font color = "blue">Insert images to post:</font>
			<input type="file" name="files[]" id ="files[]"  multiple />
			</td>
		</tr>
		<tr align="center">
			<td><font color = "blue">Add Check In?</font>
				<input type = "radio" name = "check" value = "no" checked id = "no"><font color= "blue">No</font></input>
				<input type = "radio" name = "check" value = "yes" id = "yes"><font color= "blue">Yes</font></input>
			</td>
		
		</tr>
		<tr align="center">
			<td>
				<p>
					<input type = "radio" name = "radio" value = "public" checked id = "public"><font color= "blue">Public</font></input>
					<input type = "radio" name = "radio" value = "private" id = "private"><font color= "blue">Private</font></input>
					<input type="image" src = "images/bluePost.jpg" value = "Post" name = "addPostBtn" id = "addPostBtn" width = "70px" height= "30px"/></p>
			</td>			
		</tr>	
	</table>
	</FORM>
	<div id = "postsList" class = "postsList">
		<?php
		buildPostsTables($username, $posts);
		?>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type = "text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="js/jquery.js"></script>
	<script type = "text/javscript" src = "http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/lightbox.min.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/mainPageActions.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/logout.js"></script>

	</body>
</html>