<html>
<head>
	<link rel ="stylesheet" type="text/css" href="designLogin.css"/>
</head>

<body>
</br></br></br></br></br></br></br></br></br>
<h1><font color= "green">User Registeration</font></h1>

<h3><font color= "green">Please fill all the fields</font></h3>
<div id="ack" style="color: red;"></div></br>
<FORM action="authUser.php" method="POST" id="form">
	<table width = "300px">
		<tr align = "center"><td><INPUT type="text" name="un" id="un" style="width:200px;" placeholder = "Enter new user name"></td></tr>
		<tr align = "center"><td><INPUT type="password" name="pass" id="pass" style="width:200px;" placeholder = "Enter new password"></td></tr>
		<tr align = "center"><td><INPUT type="password" name="rpass" id="rpass" style="width:200px;" placeholder = "Enter your password again"></td></tr>
		<tr><td><font color = "green">User Image:</font></td><td><input type="file" name= "img" id = "img" ><font color = "green">(optional)</font></td></tr>
		<tr><td><input type="image" src = "images/create.png" value="submit" id="submit" width = "150px" height = "50px"></td></tr>
	</table>
</FORM>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/register_script.js"></script>
</body>
</html>