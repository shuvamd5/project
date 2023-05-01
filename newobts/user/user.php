<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../user/user.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title>OBTS/USER</title>
</head>
<body>
	
	<?php
	if(isset($_SESSION['uid'])){
		$userid=$_SESSION['uid'];
		$username="";
		$userstatus="";
	}else{
		$userid=0;
		$username="";
		$userstatus="";
	}

	$location = array("Kathmandu","Lalitpur","Bhaktapur","Pokhara","Biratnagar","Dharan","Birgunj","Butwal","Hetauda","Janakpur","Dhangadhi","Bhairahawa","Mahendranagar","Nepalgunj","Ilam","Kirtipur","Tansen","Damauli","Gulariya","Tikapur","Damak","Birtamod","Mechinagar","Dipayal","Dadeldhura","Gaur","Darchula","Baglung","Rupandehi","Gorkha","Arghakhanchi","Dhankuta","Dolakha","Bhojpur","Gulmi","Tulsipur","Khandbari","Kohalpur","Bara","Sindhuli","Ramechhap","Syangja","Lamjung","Tanahun","Dolpa","Parbat","Pyuthan","Rolpa","Salyan","Sankhuwasabha","Udayapur","Okhaldhunga","Saptari","Sarlahi","Siraha","Khotang","Kalikot","lamhai");
	sort($location);
	$host="localhost";
	$user="root";
	$pass='';
	$db="OBTS";
	$conn=mysqli_connect($host,$user,$pass,$db);

	if(!$conn){
		die("connection error".mysqli_connect_error());
	}
	$sql="SELECT * from user where uid='$userid' ";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			$username=$row['uname'];
			$userstatus=$row['ustatus'];
		}
	}else{
		session_unset();
		session_destroy();
	}
	?>
	<div class="connection" id="connection"><p>Connected to OBTS</p></div>
	<div class="welcome" id="welcome">
		<p>
			Welcome 
			<?php 
			if(isset($_SESSION['uid'])){
				echo $username;
			}else{
				?>to Obts<?php
			}
			?>
		</p>
	</div>
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
			<a href="home.php">
				<i class='fas fa-bus-alt' style='font-size:36px; color: blue;'></i>
			</a>
			<h3><a href="home.php">OBTS</a></h3>
		</header>
	</div>
	<div class="status">
		<?php 
		if(isset($_SESSION['uid'])){
			?>
			<label><?php echo $userstatus; ?></label>
			<?php
		}
		?>
	</div>
	<div class="nav">
		<nav>
			<?php
			if(isset($_SESSION['uid'])){
				?>
				<button class="log" id="face">&nbsp&nbsp^_^&nbsp&nbsp</button>
				<?php
			}else{
				?>
				<button class="log" id="face"><a href="../access/access.php">login</a></button>
				<?php
			}
			?>
		</nav>
	</div>

	<div class="arrows">
		<div class="leftside">
			<i class='fas fa-angle-left' id="ls" style='font-size:25px;'></i>
		</div>
		<div class="rightside">
			<i class='fas fa-angle-right' id="rs" style='font-size:25px;'></i>
		</div>
		<div class="leftside">
			<i class='fas fa-angle-left' id="ls1" style='font-size:25px;'></i>
		</div>
		<div class="rightside">
			<i class='fas fa-angle-right' id="rs1" style='font-size:25px;'></i>
		</div>
		<div class="leftside">
			<i class='fas fa-angle-left' id="ls2" style='font-size:25px;'></i>
		</div>
		<div class="rightside">
			<i class='fas fa-angle-right' id="rs2" style='font-size:25px;'></i>
		</div>
		<div class="leftside">
			<i class='fas fa-angle-left' id="ls3" style='font-size:25px;'></i>
		</div>
		<div class="rightside">
			<i class='fas fa-angle-right' id="rs3" style='font-size:25px;'></i>
		</div>
	</div>

	<div class="container1" id="c5">
		<fieldset id="phpmethod">
			<?php
			if($_SERVER['REQUEST_METHOD']=='POST'){
				if(isset($_POST['uedit'])){
					$uid=check_data($_POST['uid']);
					$ustatus=check_data($_POST['ustatus']);
					$sql="SELECT ustatus from user where uid='$uid' ";
					$result=mysqli_query($conn,$sql);
					if(mysqli_num_rows($result)>0){
						while($row=mysqli_fetch_assoc($result)){
							$us=$row['ustatus'];
							if($us==$ustatus){
										//echo "already edited ";
							}else{
								$sql1="UPDATE user set ustatus='$ustatus' where uid='$uid' ";
								if(mysqli_query($conn,$sql1)){
									echo "updated data";
								}else{
									echo "error updating.. ".mysqli_error($conn);
								}
							}
						}
					}
				}
			}
			?>
		</fieldset>
	</div>

	<div class="container">
		<?php
		if($userstatus=="Admin"){
			?>
			<div class="container1" id="c1">
				<script>
					var c1=document.getElementById('c1');
					var ls=document.getElementById('ls');
					var rs=document.getElementById('rs');
					c1.style.display="flex";
					ls.style.display='flex';
					rs.style.display='flex';
				</script>
				<fieldset id="buttons" style="position: absolute; top: 15%; left: 30%; right: 30%;">
					<button id="p">Admin</button>
					<button id="r">manager</button>
					<button id="q">user</button>
				</fieldset>
				<fieldset id="pending">
					<div id="overflow">
						<?php
						$sql="SELECT * from user WHERE ustatus='Admin' ORDER BY uname ASC";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$ustatus=$row['ustatus'];
								?>
								<fieldset id="c11">
									<label><?php echo $row['uname']; ?></label>
									<label><?php echo $row['uemail']; ?></label>
									<label><?php echo $row['umobile']; ?></label>
									<label><?php echo $row['ugender']; ?></label>
									<div style="display: flex; justify-content: space-between;">
										<label style="color: green; cursor: pointer;" title="Payment">Rs <?php echo $row['payment']; ?></label>
										<label style="color: red; cursor: pointer;" title="Due">Rs <?php echo $row['due']; ?></label>
										<label style="color: blue; cursor: pointer;" title="Points"><?php echo $row['points']; ?> points</label>
									</div>
									<label>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="uid" value="<?php echo $row['uid']; ?>" hidden>
											<select name="ustatus">
												<option value="User">User</option>
												<option value="Admin">Admin</option>
												<option value="Manager">Manager</option>
											</select>
											<button name="uedit">edit</button>
										</form>
									</label>
									<legend><?php echo $ustatus; ?></legend>
								</fieldset>
								<?php
							}
						}
						?>
					</div>
					<legend>Admin</legend>
				</fieldset>
				<fieldset id="reserved">
					<div id="overflow">
						<?php
						$sql="SELECT * from user WHERE ustatus='Manager' ORDER BY uname ASC";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$ustatus=$row['ustatus'];
								?>
								<fieldset id="c11">
									<label><?php echo $row['uname']; ?></label>
									<label><?php echo $row['uemail']; ?></label>
									<label><?php echo $row['umobile']; ?></label>
									<label><?php echo $row['ugender']; ?></label>
									<div style="display: flex; justify-content: space-between;">
										<label style="color: green; cursor: pointer;" title="Payment">Rs <?php echo $row['payment']; ?></label>
										<label style="color: red; cursor: pointer;" title="Due">Rs <?php echo $row['due']; ?></label>
										<label style="color: blue; cursor: pointer;" title="Points"><?php echo $row['points']; ?> points</label>
									</div>
									<label>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="uid" value="<?php echo $row['uid']; ?>" hidden>
											<select name="ustatus">
												<option value="User">User</option>
												<option value="Admin">Admin</option>
												<option value="Manager">Manager</option>
											</select>
											<button name="uedit">edit</button>
										</form>
									</label>
									<legend><?php echo $ustatus; ?></legend>
								</fieldset>
								<?php
							}
						}
						?>
					</div>
					<legend>Manager</legend>
				</fieldset>
				<fieldset id="paid">
					<div id="overflow">
						<?php
						$sql="SELECT * from user WHERE ustatus='User' ORDER BY uname ASC";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$ustatus=$row['ustatus'];
								?>
								<fieldset id="c11">
									<label><?php echo $row['uname']; ?></label>
									<label><?php echo $row['uemail']; ?></label>
									<label><?php echo $row['umobile']; ?></label>
									<label><?php echo $row['ugender']; ?></label>
									<div style="display: flex; justify-content: space-between;">
										<label style="color: green; cursor: pointer;" title="Payment">Rs <?php echo $row['payment']; ?></label>
										<label style="color: red; cursor: pointer;" title="Due">Rs <?php echo $row['due']; ?></label>
										<label style="color: blue; cursor: pointer;" title="Points"><?php echo $row['points']; ?> points</label>
									</div>
									<label>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="uid" value="<?php echo $row['uid']; ?>" hidden>
											<select name="ustatus">
												<option value="User">User</option>
												<option value="Admin">Admin</option>
												<option value="Manager">Manager</option>
											</select>
											<button name="uedit">edit</button>
										</form>
									</label>
									<legend><?php echo $ustatus; ?></legend>
								</fieldset>
								<?php
							}
						}
						?>
					</div>
					<legend>User</legend>
				</fieldset>
				<!--<fieldset style="width: 100%;">
					<div id="overflow">
						<?php
						$sql="SELECT * from user";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$ustatus=$row['ustatus'];
								?>
								<fieldset id="c11">
									<label><?php echo $row['uname']; ?></label>
									<label><?php echo $row['uemail']; ?></label>
									<label><?php echo $row['umobile']; ?></label>
									<label><?php echo $row['ugender']; ?></label>
									<label>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="uid" value="<?php echo $row['uid']; ?>" hidden>
											<select name="ustatus">
												<option value="User">User</option>
												<option value="Admin">Admin</option>
												<option value="Manager">Manager</option>
											</select>
											<button name="uedit">edit</button>
										</form>
									</label>
									<legend><?php echo $ustatus; ?></legend>
								</fieldset>
								<?php
							}
						}
						?>
					</div>
					<legend>Edit status</legend>
				</fieldset>-->
			</div>
			<?php
		}else{
			?>
			<div class="container2" id="c1">
				<script>
					var c1=document.getElementById('c1');
					var ls=document.getElementById('ls');
					var rs=document.getElementById('rs');
					c1.style.display="none";
					ls.style.display='none';
					rs.style.display='none';
				</script>
				<div class="side2" id="side2">
					<div class="image">
						<div class="img" id="img1"></div>
						<div class="img" id="img2"></div>
						<div class="img" id="img3"></div>
						<div class="img" id="img4"></div>
						<div class="img" id="img5"></div>
						<div class="img" id="img6"></div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<?php
		if($userstatus=="Admin" || $userstatus=="Manager"){
			?>
			<div class="container1" id="c2">
				<?php
				if($userstatus=="Admin"){
					?>
					<script>
						var c2=document.getElementById('c2');
						var ls1=document.getElementById('ls1');
						var rs1=document.getElementById('rs1');
						c2.style.display="none";
						ls1.style.display='none';
						rs1.style.display='none';
					</script>
					<?php
				}else{
					?>
					<script>
						var c2=document.getElementById('c2');
						var ls1=document.getElementById('ls1');
						var rs1=document.getElementById('rs1');
						c2.style.display='flex';
						ls1.style.display='flex';
						rs1.style.display='flex';
					</script>
					<?php
				}
				?>
				<fieldset>
					<div id="overflow">
						<?php
						$sql="SELECT * from user WHERE ustatus='user' ORDER BY uname ASC";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								?>
								<fieldset id="c11">
									<label><?php echo $row['uname']; ?></label>
									<label><?php echo $row['uemail']; ?></label>
									<label><?php echo $row['umobile']; ?></label>
									<label><?php echo $row['ugender']; ?></label>
									<div style="display: flex; justify-content: space-between;">
										<label style="color: green; cursor: pointer;" title="Payment">Rs <?php echo $row['payment']; ?></label>
										<label style="color: red; cursor: pointer;" title="Due">Rs <?php echo $row['due']; ?></label>
										<label style="color: blue; cursor: pointer;" title="Points"><?php echo $row['points']; ?> points</label>
									</div>
									<legend><?php echo $row['ustatus']; ?></legend>
								</fieldset>
								<?php
							}
						}else{
							?>
							<label>no user found</label>
							<?php
						}
						?>
					</div>
					<legend>user list</legend>
				</fieldset>
			</div>
			<?php
		}else{
			?>
			<div class="container2" id="c2">
				<script>
					var c2=document.getElementById('c2');
					var ls1=document.getElementById('ls1');
					var rs1=document.getElementById('rs1');
					c2.style.display="none";
					ls1.style.display='none';
					rs1.style.display='none';
				</script>
				<div class="side1" id="side1">
					<div class="features">
						<fieldset>
							<label>A/c</label>
							<label>deluxe</label>
							<label>suspension</label>
							<label>foldable</label>
							<label>semi-foldable</label>
							<label>unfoldable</label>
							<label>37 seats</label>
							<label>39 seats</label>
							<label>points system</label>
							<legend>features</legend>
						</fieldset>
					</div>
					<div class="image">
						<div class="img" id="img4"></div>
					</div>
				</div>
			</div>
			<?php
		}
		?>

		<div class="container1" id="c3">
			<?php
			if(isset($_SESSION['uid'])){
				if($userstatus=="Admin"||$userstatus=="Manager"){
					?>
					<script>
						var c3=document.getElementById('c3');
						var ls2=document.getElementById('ls2');
						var rs2=document.getElementById('rs2');
						c3.style.display="none";
						ls2.style.display='none';
						rs2.style.display='none';
					</script>
					<?php
				}else{
					?>
					<script>
						var c3=document.getElementById('c3');
						var ls2=document.getElementById('ls2');
						var rs2=document.getElementById('rs2');
						c3.style.display='flex';
						ls2.style.display='flex';
						rs2.style.display='flex';
					</script>
					<?php
				}
				?>
				<fieldset>
					<div id="overflow">
						<?php
						$sql="SELECT * from user where uid='$userid'";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$uid=$row['uid'];
								$uname=$row['uname'];
								$uemail=$row['uemail'];
								$umobile=$row['umobile'];
								$ugender=$row['ugender'];
								$ustatus=$row['ustatus'];
								$ttc=$row['totaltc'];
								$rtc=$row['reservedtc'];
								$ptc=$row['pendingtc'];
								$payment=$row['payment'];
								$due=$row['due'];
								$points=$row['points'];
								?>
								<fieldset id="c12">
									<label>name : <?php echo $uname; ?></label>
									<label>email : <?php echo $uemail; ?></label>
									<label>mobile : <?php echo $umobile; ?></label>
									<label>gender : <?php echo $ugender; ?></label>
									<label>total ticket : <?php echo $ttc; ?></label>
									<label>reserved ticket : <?php echo $rtc; ?></label>
									<label>pending ticket : <?php echo $ptc; ?></label>
									<label>payment till day : rs <?php echo $payment; ?></label>
									<label>due payment : rs <?php echo $due; ?></label>
									<label>points : <?php echo $points; ?></label>
									<legend><?php echo $ustatus; ?></legend>
								</fieldset>
								<?php
							}
						}
						?>
					</div>
					<legend>user profile</legend>
				</fieldset>
				<?php
			}else{
				?>
				<div style="display: flex; height: 40vh; align-items: center;">
					<label style="font-weight: 900; color: black; text-align: center; font-size: 1.5em; margin: 0 auto;">session out !!! please login in to continue...</label>
				</div>
				<?php
			}
			?>
		</div>
		<div class="container2" id="c4">
			<div class="side" id="side">
				<div class="dots">
					<i class='fas fa-circle' id="dot1" style='font-size:10px;'></i>
					<i class='fas fa-circle' id="dot2" style='font-size:10px;'></i>
					<i class='fas fa-circle' id="dot3" style='font-size:10px;'></i>
					<i class='fas fa-circle' id="dot4" style='font-size:10px;'></i>
				</div>
				<div class="image">
					<div class="img" id="img1"></div>
					<div class="img" id="img2"></div>
					<div class="img" id="img3"></div>
					<div class="img" id="img4"></div>
				</div>
				<div class="list">
					<label>top destinations</label>
					<div class="dstn">
						<?php
						foreach($location as $i){ 
							?>
							<p><?php echo $i ?></p>
							<?php 
						} 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="hf">
		<div class="dropdown">
			<i class='fas fa-angle-down' id="dd" style='font-size:25px;'></i>
			<?php
			if(isset($_SESSION['uid'])){
				$sql="SELECT tstatus from ticket where treby='$username' && tstatus='P' ";
				$result=mysqli_query($conn,$sql);
				$p=mysqli_num_rows($result);
				$q=$r=$s=0;
				if(isset($_SESSION['uid'])&& ($userstatus=="Admin" || $userstatus=="Manager")){
					$sql="SELECT * from bus where bstatus!='active' ";
					$result=mysqli_query($conn,$sql);
					$q=mysqli_num_rows($result);
					$sql="SELECT * from busschedule where bsstatus!='going' && bsstatus!='Expired' ";
					$result=mysqli_query($conn,$sql);
					$r=mysqli_num_rows($result);
					$sql="SELECT * from addroute where arstatus!='ok' && arstatus!='Expired' ";
					$result=mysqli_query($conn,$sql);
					$s=mysqli_num_rows($result);
				}
				$s=$p+$q+$r+$s;
				if($s>0){
					?>
					<label id="notif"><?php echo $s;?> </i></label>
					<?php 
				}
				?>
				<?php 
			}
			?>
		</div>
		<div class="dashboard" id="dashboard">
			<nav>
				<a href="../home/home.php"><i class='fas fa-home' style='font-size:25px;'></i><label> Home</label></a>
				<a href="../bus/bus.php"><i class='fas fa-bus-alt' style='font-size:25px;'></i><label> Bus</label>
					<?php
					if(isset($_SESSION['uid'])&& ($userstatus=="Admin" || $userstatus=="Manager")){
						$sql="SELECT * from bus where bstatus!='active' ";
						$result=mysqli_query($conn,$sql);
						$c=mysqli_num_rows($result);
						if($c>0){
							?>
							<label id="noti"><?php echo $c; ?></label>
							<?php 
						}
					}
					?>
				</a>
				<a href="../schedule/schedule.php"><i class='fas fa-calendar-alt' style='font-size:25px;'></i><label>schedule</label>
					<?php
					if(isset($_SESSION['uid'])&& ($userstatus=="Admin" || $userstatus=="Manager")){
						$sql="SELECT * from busschedule where bsstatus!='going' && bsstatus!='Expired' ";
						$result=mysqli_query($conn,$sql);
						$c=mysqli_num_rows($result);
						if($c>0){
							?>
							<label id="noti"><?php echo $c; ?></label>
							<?php 
						}
					}
					?>
				</a>
				<a href="../route/route.php"><i class='fas fa-route' style='font-size:25px;'></i><label>routes</label></a>
				<a href="../addroute/addroute.php"><i class='fas fa-rupee-sign' style='font-size:25px;'></i><label>prices</label>
					<?php
					if(isset($_SESSION['uid'])&& ($userstatus=="Admin" || $userstatus=="Manager")){
						$sql="SELECT * from addroute where arstatus!='ok' && arstatus!='Expired' ";
						$result=mysqli_query($conn,$sql);
						$c=mysqli_num_rows($result);
						if($c>0){
							?>
							<label id="noti"><?php echo $c; ?></label>
							<?php 
						}
					}
					?>
				</a>
				<a href="../ticket/ticket.php"><i class='fas fa-ticket-alt' style='font-size:25px;'></i><label>ticket</label>
					<?php
					if(isset($_SESSION['uid'])){
						$sql="SELECT tstatus from ticket where treby='$username' && tstatus='P' ";
						$result=mysqli_query($conn,$sql);
						$c=mysqli_num_rows($result);
						if($c>0){
							?>
							<label id="noti"><?php echo $c; ?></label>
							<?php 
						}
					}
					?>
				</a>
				<a href="../user/user.php" id="active"><i class='fas fa-user-alt' style='font-size:25px;'></i><label>user</label></a>
				<?php
				if(isset($_SESSION['uid'])){
					?>
					<a href="../access/access.php" id="log"><i class='fas fa-sign-out-alt' style='font-size:25px;'></i><label>logout</label></a>
					<?php
				}else{
					?>
					<a href="../access/access.php" id="log"><i class='fas fa-sign-in-alt' style='font-size:25px;'></i><label>login</label></a>
					<?php
				}
				?>
			</nav>
			<i class='fas fa-angle-up' id="du" style='font-size:25px;'></i>
		</div>

		<div class="slideup">
			<i class='fas fa-angle-up' id="su" style='font-size:25px;'></i>
		</div>
		<div class="footer" id="footer">
			<i class='fas fa-angle-down' id="sd" style='font-size:25px;'></i>
			<footer>
				<h3>obts</h3>
				<h4>contact: 9812449811</h4>
				<?php
				if($userstatus=="Admin"){
					?>
					<a href="../admin/admin.php">Admin</a>
					<?php
				}
				if($userstatus=="Manager"){
					?>
					<a href="../admin/admin.php">Manager</a>
					<?php
				}
				?>
			</footer>
		</div>
	</div>

	<script src="../user/user.js"></script>

</body>
</html>