<?php
	session_start();
	$username = $_SESSION["userName"];
	$sql=@mysqli_connect("localhost","root","") or die("<BR>ERROR: cannot connect to MySQL server!");  //connect to MySQL server
	@mysqli_select_db($sql,"faceafeka") or die("<BR>ERROR: cannot use the DB!");  //selects the DB
	
	if($_POST['searchword'] == '*')
		$res=@mysqli_query($sql,"SELECT * FROM users WHERE (userName!='".$username."')") or die("<BR>ERROR: incorrect query!");
	else
		$res=@mysqli_query($sql,"SELECT * FROM users WHERE (userName!='".$username."' AND userName like '%".$_POST['searchword']."%')") or die("<BR>ERROR: incorrect query!");
	//if we got a row, then we got a match
	if (mysqli_num_rows($res)>0)
	{
		while ($post_row=mysqli_fetch_array($res))  //as long as there are rows in the result
		{
			echo "<div class='display_box' align='left' onclick='addFriend(".$post_row['user_id'].")'>";
			echo "<img style='width:25px; float:left; margin-right:6px' src='".$post_row["img"]."' id='pic' />&nbsp;<span>".$post_row["userName"]."</span>";
			echo "</div>";
		}
	}
	
	//return json data
	@mysqli_close($sql);
	//echo json_encode($data);
	
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/mainPageActions.js"></script>