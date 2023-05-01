<?php
session_unset();
session_start();
function settingcookie($a,$b){
	setcookie("id",$a,time()+(86400*30),"/");
	setcookie("name",$b,time()+(86400*30),"/");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../access/access.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title>SIGNUP/LOGIN</title>
</head>
<body>
	<?php
	$_SESSION['uid']=0;
	$_SESSION['uname']="";
	$_SESSION['ustatus']="";
	$uname=$upass=$ugender=$uemail=$umobile="";
	$logid=$logpass=$remember="";
	$host="localhost";
	$user="root";
	$pass='';
	$db="OBTS";
	$conn=mysqli_connect($host,$user,$pass,$db);
	if(!$conn)
	{
		die("connection error".mysqli_connect_error());
	}
	$d=date_create(date("Y-m-d"));
	date_add($d,date_interval_create_from_date_string("-1 day"));
	$d=date_format($d,"Y-m-d");

	$sql="UPDATE addroute INNER JOIN busschedule on addroute.bsid=busschedule.bsid set arstatus='Expired' where trdate<='$d'";
	if(mysqli_query($conn,$sql)){
				//echo "schedule deleted";
	}else{
		echo "error updating.. ".mysqli_error($conn);
	}
	$sql="UPDATE busschedule set bsstatus='Expired' where trdate<='$d'";
	if(mysqli_query($conn,$sql)){
				//echo "schedule deleted";
	}else{
		echo "error updating.. ".mysqli_error($conn);
	}

	$sql="DELETE from seats where trdate<'$d'";
	if(mysqli_query($conn,$sql)){
			//	echo "seats deleted";
	}else{
				//echo "error updating.. ".mysqli_error($conn);
	}
	$sql="SELECT * from seats";
	$result=mysqli_query($conn,$sql);
	$j=1;
	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			$sid=$row['sid'];
			if($sid>$j){
				$sql1="UPDATE seats set sid='$j' where sid='$sid' ";
				if(mysqli_query($conn,$sql1)){
						//echo "schedule";
				}else{
					echo "error updating.. ".mysqli_error($conn);
				}
			}
			$j++;
		}
	}
	$sql="ALTER TABLE seats auto_increment=1 ";
	if(mysqli_query($conn,$sql)){
			//echo "schedule deleted";
	}else{
		echo "error updating.. ".mysqli_error($conn);
	}

	$sql="DELETE from ticket where trdate<'$d'";
	if(mysqli_query($conn,$sql)){
			//	echo "seats deleted";
	}else{
				//echo "error updating.. ".mysqli_error($conn);
	}
	$sql="SELECT * from ticket";
	$result=mysqli_query($conn,$sql);
	$j=1;
	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			$tid=$row['tid'];
			if($tid>$j){
				$sql1="UPDATE ticket set tid='$j' where tid='$tid' ";
				if(mysqli_query($conn,$sql1)){
						//echo "schedule";
				}else{
					echo "error updating.. ".mysqli_error($conn);
				}
			}
			$j++;
		}
	}
	$sql="ALTER TABLE ticket auto_increment=1 ";
	if(mysqli_query($conn,$sql)){
			//echo "schedule deleted";
	}else{
		echo "error updating.. ".mysqli_error($conn);
	}

	/*$dx=date_create(date("Y-m-d"));
	date_add($dx,date_interval_create_from_date_string("-30 day"));
	$dx=date_format($dx,"Y-m-d");

	$sql="DELETE from addroute INNER JOIN busschedule on addroute.arid=busschedule.bsid where trdate<'$dx'";
	if(mysqli_query($conn,$sql)){
			//	echo "seats deleted";
	}else{
				//echo "error updating.. ".mysqli_error($conn);
	}
	$sql="SELECT * from addroute";
	$result=mysqli_query($conn,$sql);
	$j=1;
	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			$arid=$row['arid'];
			if($arid>$j){
				$sql1="UPDATE addroute set arid='$j' where arid='$arid' ";
				if(mysqli_query($conn,$sql1)){
						//echo "schedule";
				}else{
					echo "error updating.. ".mysqli_error($conn);
				}
			}
			$j++;
		}
	}
	$sql="ALTER TABLE addroute auto_increment=1 ";
	if(mysqli_query($conn,$sql)){
			//echo "schedule deleted";
	}else{
		echo "error updating.. ".mysqli_error($conn);
	}
	
	$sql="DELETE from busschedule where trdate<'$dx'";
	if(mysqli_query($conn,$sql)){
			//	echo "seats deleted";
	}else{
				//echo "error updating.. ".mysqli_error($conn);
	}
	$sql="SELECT * from busschedule";
	$result=mysqli_query($conn,$sql);
	$j=1;
	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			$bsid=$row['bsid'];
			if($bsid>$j){
				$sql1="UPDATE busschedule set bsid='$j' where bsid='$bsid' ";
				if(mysqli_query($conn,$sql1)){
						//echo "schedule";
				}else{
					echo "error updating.. ".mysqli_error($conn);
				}
			}
			$j++;
		}
	}
	$sql="ALTER TABLE busschedule auto_increment=1 ";
	if(mysqli_query($conn,$sql)){
			//echo "schedule deleted";
	}else{
		echo "error updating.. ".mysqli_error($conn);
	}*/

	?>
	<div class="connection" id="connection"><p>Connected to OBTS</p></div>
	<div class="welcome" id="welcome"><p>Welcome to OBTS</p></div>
	<?php
	function check_data($data){
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
	?>
	<div class="header">
		<header>
			<a href="../home/home.php">
				<i class='fas fa-bus-alt' style='font-size:36px; color: blue;'></i>
			</a>
			<h3><a href="../home/home.php">OBTS</a></h3>
		</header>
		<a href="../home/home.php" id="home">home</a>
	</div>
	<div class="container" id="container">
		<div class="container1l" id="l">
			<fieldset id="login">
				<legend class="display">Login</legend>
				<form id="logform" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
					<fieldset>
						<input type="text" name="logid" id="logid" placeholder="E-mail/Mobile" autocomplete="off" required>
						<legend>Email/Mobile</legend>
					</fieldset>
					<fieldset>
						<input type="password" name="logpass" id="logpass" placeholder="Password" autocomplete="off" maxlength="16" required>
						<label class="visibility" id="logineyeslash"><i class='far fa-eye-slash'></i></label>
						<label class="visibility" id="logineye"><i class='far fa-eye'></i></label>
						<legend>Password</legend>
					</fieldset>
					<fieldset>
						<button name="login">Submit</button>
					</fieldset>
					<fieldset class="logextra">
						<label>or</label>
						<label>create</label>
						<label>new account</label>
						<button id="signup">register</button>
						<label>and</label>
						<label>join obts</label>
					</fieldset>
				</form>
			</fieldset>
		</div>
		<div class="container2l" id="lb">
			<fieldset class="lextra">
				<h2>Welcome back</h2>
				<label>to stay connected with us please</label>
				<label>login</label>
				<button id="signupbutton">signup</button>
				<fieldset class="logphp">
					<?php
					if($_SERVER['REQUEST_METHOD']=='POST'){
						if(isset($_POST['login'])){
							$logid=check_data($_POST['logid']);
							$logpass=md5(check_data($_POST['logpass']));
							$r=compare($conn,$logid,$logpass);
							if($r=="true"){
								echo "Login successful<br/>";
								finduser($logid,$conn);
							}else{
								echo "login falied<br/>";
							}
						}
					}
					function compare($conn,$a,$b){
						$sql="SELECT uemail,umobile,upass from user where (uemail='$a' && upass='$b') || (umobile='$a' && upass='$b') ";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							return "true";
						}else{
							return "false";
						}
					}
					function finduser($a,$conn){
						$sql="SELECT uid,uname,ustatus from user where uemail='$a' || umobile='$a' ";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								settingsession($row['uid'],$row['uname']);
								isadmin($row['ustatus'],$conn);
							}
						}
					}
					function isadmin($a,$conn){
						?><p>Welcome 	<?php echo $a; ?></p><?php
						if($a=="Admin"||$a=="Manager"){
							$_SESSION['ustatus']=$a;
							?>
							<script>
								window.location.assign("http://localhost/newobts/admin/admin.php")
							</script>
							<?php
						}else{
							$_SESSION['ustatus']=$a;
							?>
							<script>
								window.location.assign("http://localhost/newobts/home/home.php")
							</script>
							<a href="../home/home.php" id="link">start</a>
							<?php
						}	
					}
					function settingsession($a,$b){
						$_SESSION['uid']=$a;
						$_SESSION['uname']=$b;
					}
					?>
				</fieldset>
			</fieldset>
		</div>
		<div class="container1r" id="s">
			<fieldset id="register">
				<legend class="display">Register</legend>
				<form id="registerform" name="registerform" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
					<fieldset>
						<input type="text" name="uname" id="uname" placeholder="Fullname" autocomplete="off" required onfocus="validateuname()" oninput="validateuname()">
						<legend>fullname</legend>
					</fieldset>
					<fieldset>
						<input type="email" name="uemail" id="uemail" placeholder="E-mail" autocomplete="off" required onfocus="validateuemail()" oninput="validateuemail()">
						<legend>email</legend>
					</fieldset>
					<fieldset>
						<input type="tel" name="umobile" id="umobile" placeholder="Mobile" pattern="[0-9]{10}" autocomplete="off" required onfocus="validateumobile()" oninput="validateumobile()">
						<legend>mobile</legend>
					</fieldset>
					<fieldset>
						<input type="password" name="upass" id="upass" placeholder="Password" maxlength="25" autocomplete="off" required onfocus="validateupass()" oninput="validateupass()">
						<label class="visibility" id="signupeyeslash"><i class='far fa-eye-slash'></i></label>
						<label class="visibility" id="signupeye"><i class='far fa-eye'></i></label>
						<legend>password</legend>
					</fieldset>
					<fieldset class="gender" style="color: white;">
						<input type="radio" name="ugender" value="Female" required>&nbspFEMALE&nbsp&nbsp
						<input type="radio" name="ugender" value="Male">&nbspMALE&nbsp&nbsp
						<input type="radio" name="ugender" value="Other">&nbspOTHER 
						<legend>gender</legend>
					</fieldset>
					<fieldset style="margin: -4% auto 0 auto;">
						<button name="submit" id="submit" onfocus="valdiate()">Submit</button>
						<span id="info"></span>
					</fieldset>
					<fieldset class="extra" style="margin: -3% auto 0 auto;">
						<label>join us</label>
						<label>and</label>
						<label>enjoy our services</label>
					</fieldset>
				</form>
			</fieldset>
		</div>
		<div class="container2r" id="sb">
			<fieldset class="rextra">
				<h2>welcome</h2>
				<label>to start the journey with us</label>
				<label>sign up</label>
				<button id="loginbutton">login</button>
				<fieldset class="supphp">
					<?php
					if($_SERVER['REQUEST_METHOD']=='POST'){
						if(isset($_POST['submit'])){
							?>
							<script>
								var s=document.getElementById('s');
								var sb=document.getElementById('sb');
								var l=document.getElementById('l');
								var lb=document.getElementById('lb');
								l.style.display='none';
								lb.style.display='none';
								s.style.display='flex';
								sb.style.display='flex';
							</script>
							<?php
							$uname=check_data($_POST['uname']);
							$uname=ucfirst($uname);
							$upass=check_data($_POST['upass']);
							$ugender=check_data($_POST['ugender']);
							$uemail=check_data($_POST['uemail']);
							$umobile=check_data($_POST['umobile']);
							if(!preg_match("/^[a-zA-Z-' ]*$/", $uname)) {
								echo "Error in username<br/>only name and white<br/>space are allowed";
							}else if(strlen($upass)<8 || strlen($upass)>25){
								echo "Error in password<br/>length must be<br/>between 8 to 25.";
							}else if(!preg_match('`[A-Z]`',$upass)){
								echo "Error in password<br/>must contain<br/>atleast one uppercase.";
							}else if(!preg_match('`[a-z]`',$upass)){
								echo "Error in password<br/>must contain<br/>atleast one lowercase.";
							}else if(!preg_match('`[0-9]`',$upass)){
								echo "Error in password<br/>must contain<br/>atleast one number.";
							}else if(!preg_match('`[\$\*\.,+\-=@]`',$upass)){
								echo "Error in password<br/>must contain<br/>atleast one symbol.";
							}else{
								$upass=md5($upass);
								store($uname,$upass,$ugender,$uemail,$umobile,$conn);
							}
						}
					}
					function store($a,$b,$c,$d,$e,$conn){
						$check=repeat($conn,$d,$e);
						if($check=="false"){
							$f=date("Y-m-d");
							$g=date("H:i:s");
							$h='User';
							$sql="INSERT INTO user(udate,utime,uname,upass,ugender,uemail,umobile,ustatus,totaltc,reservedtc,pendingtc,payment,due,points) 
							VALUES('$f','$g','$a','$b','$c','$d','$e','$h',0,0,0,0,0,0)";
							if($conn->query($sql)===TRUE){
								echo "User ".$a."<br/>has been<br/> registered<br/>to obts.";
							}else{
								echo "registration error<br/>".$sql.$conn->error;
							}
						}
					}
					function repeat($conn,$a,$b){
						$sql="SELECT uemail,umobile from user where uemail='$a' || umobile='$b' ";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							echo "the email/mobile has already been registered";
							return "true";
						}else{
							return "false";
						}
					}	
					?>
				</fieldset>
			</fieldset>
		</div>

	</div>
	<script src="../access/access.js"></script>
</body>
</html>