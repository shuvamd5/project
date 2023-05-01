<?php
$host="localhost";
$user="root";
$pass='';
$conn=mysqli_connect($host,$user,$pass);
if(!$conn)
{
	die("\nconnection error".mysqli_connect_error());
}
echo("\nconnection successful");
$sql="CREATE DATABASE OBTS";
if(mysqli_query($conn,$sql))
{
	echo("\n databse creation successful!!!!");
}
else
{
	echo("\nError in databse creation!!".mysqli_error($conn));
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Database</title>
</head>
<body>
<a href="../database/table.php">create table</a>
</body>
</html>