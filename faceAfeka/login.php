<html>
<head>
	<link rel ="stylesheet" type="text/css" href="designLogin.css"/>
</head>

<body>
</br></br></br></br></br></br></br></br></br>
<h1><font color = 'green'>Welcome To FaceAfeka</font></h1>

<h3><font color = 'green'>Please enter username and password</font></h3>
<div id="ack" style="color: red;"></div></br>
<FORM action="authUser.php" method="POST" id="form">
	<table width = "250px">
		<tr align = "center"><td><INPUT type="TEXT" placeholder ="Enter your user name" name="un" id="un" style="width:150px;"></td></tr>
		<tr align = "center"><td><INPUT type="password" placeholder ="Enter your password" name="pass" id="pass" style="width:150px;"></td></tr>
		
		<tr align = "center"><td>		</br></br>
		<input type="image" src ="images/login.png" value="submit" id="submit" width = "150px" height = "50px"></td></tr>
	</table>
</FORM>

<font color= "green">Don't have user - </font><a href="newUser.php" id="newUser"><font color= "green"> Click Here</font></a>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/auth_script.js"></script>
</body>
</html>