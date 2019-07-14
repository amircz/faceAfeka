<?php
session_start();
if($_SESSION["added"] == 'true')
{
	echo "<h2>user added!</h2> <h4>redirect to login page</h4>";
	header( "refresh:3;url=login.php" );
}
else
	header( "url=login.php" );
