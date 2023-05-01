<?php
$host="localhost";
$user="root";
$pass='';
$db="OBTS";
$conn=mysqli_connect($host,$user,$pass,$db);
if(!$conn)
{
	die("\nconnection error".mysqli_connect_error());
}
echo("\nconnection successful<br/>");
$sql="CREATE TABLE user(
		uid int(10) not null auto_increment primary key,
		udate date not null,
		utime time not null,
		uname varchar(25) not null,
		upass varchar(50) not null,
		ugender varchar(10) not null,
		uemail varchar(100) not null,
		umobile bigint(10) not null,
		ustatus varchar(15) not null,
		totaltc int(10) not null,
		reservedtc int(10) not null,
		pendingtc int(10) not null,
		payment int(10) not null,
		due int(10) not null,
		points int(10) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
$sql="CREATE TABLE bus(
		bid int(10) not null auto_increment primary key,
		bcd varchar(25) not null,
		bno int(10) not null,
		bname varchar(100) not null,
		btype varchar(15) not null ,
		nseat int(5) not null,
		stype varchar(15) not null,
		bstatus varchar(15) not null,
		bsapby varchar(25) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
$sql="CREATE TABLE busschedule(
		bsid int(10) not null auto_increment primary key,
		bid int(10) not null,
		trdate date not null,
		trtime time not null,
		bsstatus varchar(15) not null,
		bssapby varchar(25) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
$sql="CREATE TABLE addroute(
		arid int(10) not null auto_increment primary key,
		bsid int(10) not null,
		rid int(10) not null,
		price int(10) not null,
		arstatus varchar(15) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
$sql="CREATE TABLE sales(
		sid int(10) not null auto_increment primary key,
		bid int(10) not null,
		bsid int(10) not null,
		trdate date not null,
		trtime time not null,
		sales int(10) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
$sql="CREATE TABLE seats(
		sid int(10) not null auto_increment primary key,
		arid int(10) not null,
		sno int(5) not null,
		sp varchar(15) not null,
		spcpid int(5) not null,
		fp varchar(15) not null,
		fpcpid int(5) not null,
		price int(10) not null,
		uid int(10) not null,
		status varchar(15) not null,
		trdate date not null,
		trtime time not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
/*$sql="CREATE TABLE seatstatus(
		ssid int(10) not null auto_increment primary key,
		bid int(10) not null,
		bsid int(10) not null,
		seats int(5) not null,
		status varchar(15) not null,
		sreby varchar(25) not null,
		sdate date not null,
		stime time not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}*/
$sql="CREATE TABLE ticket(
		tid int(10) not null auto_increment primary key,
		arid int(10) not null,
		ssid int(10) not null,
		trdate date not null,
		trtime time not null,
		sno int(5) not null,
		blc varchar(5) not null,
		sna varchar(5) not null,
		price int(15) not null,
		uid int(10) not null,
		treby varchar(25) not null,
		tstatus varchar(15) not null,
		payment varchar(15) not null,
		pyreby varchar(25) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
$sql="CREATE TABLE route(
		rid int(10) not null auto_increment primary key,
		sp varchar(25) not null,
		fp varchar(25) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
$sql="CREATE TABLE checkpoint(
		cpid int(10) not null auto_increment primary key,
		rid int(10) not null,
		route varchar(25) not null,
		price int(10) not null
		)";
if(mysqli_query($conn,$sql))
{
	echo "table is creation successful <br/>";
}
else
{
	echo "table creation failed <br/>".mysqli_error($conn)."<br/>";
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DB/Table</title>
</head>
<body>
<a href="http://localhost/phpmyadmin/">see database</a><br>
<a href="../home/home.php">home</a>
</body>
</html>