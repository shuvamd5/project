<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../route/route.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title>OBTS/ROUTES</title>
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

	$bid=$sp=$fp=$route=$cost="";
	$location = array("Kathmandu","Lalitpur","Bhaktapur","Pokhara","Biratnagar","Dharan","Birgunj","Butwal","Hetauda","Janakpur","Dhangadhi","Bhairahawa","Mahendranagar","Nepalgunj","Ilam","Kirtipur","Tansen","Damauli","Gulariya","Tikapur","Damak","Birtamod","Mechinagar","Dipayal","Dadeldhura","Gaur","Darchula","Baglung","Rupandehi","Gorkha","Arghakhanchi","Dhankuta","Dolakha","Bhojpur","Gulmi","Tulsipur","Khandbari","Kohalpur","Bara","Sindhuli","Ramechhap","Syangja","Lamjung","Tanahun","Dolpa","Parbat","Pyuthan","Rolpa","Salyan","Sankhuwasabha","Udayapur","Okhaldhunga","Saptari","Sarlahi","Siraha","Khotang","Kalikot","lamhai");
	$location1 = array("Kathmandu","Lalitpur","Bhaktapur","Pokhara","Biratnagar","Dharan","Birgunj","Butwal","Hetauda","Janakpur","Dhangadhi","Bhairahawa","Mahendranagar","Nepalgunj","Ilam","Kirtipur","Tansen","Damauli","Gulariya","Tikapur","Damak","Birtamod","Mechinagar","Dipayal","Dadeldhura","Gaur","Darchula","Baglung","Rupandehi","Gorkha","Arghakhanchi","Dhankuta","Dolakha","Bhojpur","Gulmi","Tulsipur","Khandbari","Kohalpur","Bara","Sindhuli","Ramechhap","Syangja","Lamjung","Tanahun","Dolpa","Parbat","Pyuthan","Rolpa","Salyan","Sankhuwasabha","Udayapur","Okhaldhunga","Saptari","Sarlahi","Siraha","Khotang","Kalikot","lamhai");
	sort($location);
	sort($location1);
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
				if(isset($_POST['spedit'])){
					$rid=check_data($_POST['rid']);
					$sp=check_data($_POST['sp']);
					$sql="SELECT sp from route where rid='$rid' ";
					$result=mysqli_query($conn,$sql);
					if(mysqli_num_rows($result)>0){
						while($row=mysqli_fetch_assoc($result)){
							$s=$row['sp'];
							if($s==$sp){
										//echo "already edited ";
							}else{
								$sql1="UPDATE route set sp='$sp' where rid='$rid' ";
								if(mysqli_query($conn,$sql1)){
									echo "updated data";
								}else{
									echo "error updating.. ".mysqli_error($conn);
								}
							}
						}
					}
				}
				if(isset($_POST['fpedit'])){
					$rid=check_data($_POST['rid']);
					$fp=check_data($_POST['fp']);
					$sql="SELECT fp from route where rid='$rid' ";
					$result=mysqli_query($conn,$sql);
					if(mysqli_num_rows($result)>0){
						while($row=mysqli_fetch_assoc($result)){
							$f=$row['fp'];
							if($f==$fp){
										//echo "already edited ";
							}else{
								$sql1="UPDATE route set fp='$fp' where rid='$rid' ";
								if(mysqli_query($conn,$sql1)){
									echo "updated data";
								}else{
									echo "error updating.. ".mysqli_error($conn);
								}
							}
						}
					}
				}
				if(isset($_POST['routeentry'])){
					$sp=check_data($_POST['sp']);
					$fp=check_data($_POST['fp']);
					$count=$count1=0;
					for($i=0;$i<count($location);$i++){
						if($sp!=$location[$i]){
							$count++;
						}
					}
					for($i=0;$i<count($location);$i++){
						if($fp!=$location[$i]){
							$count1++;
						}
					}
					if($count==count($location)){
						echo "<br/>Error in sp...select from the given option!!!";
					}else if($count1==count($location)){
						echo "<br/>Error in fp...select from the given option!!!";
					}else{
						storeroute($sp,$fp,$conn);
					}
				}
			}
			function storeroute($a,$b,$conn){
				$check=repeat($conn,$a,$b);
				if($check=="false"){
					$sql="INSERT INTO route(sp,fp) VALUES('$a','$b')";
					if($conn->query($sql)===TRUE){
						echo "<br/>Route is registered";
					}
					else{
						echo "Error".$sql.$conn->error;
					}
				}
			}
			function repeat($conn,$a,$b){
				$sql="SELECT sp,fp from route";
				$result=mysqli_query($conn,$sql);
				if(mysqli_num_rows($result)>0){
					while($row=mysqli_fetch_assoc($result)){
						if($a==$row["sp"]){
							if($b==$row["fp"]){
										//echo "<br/>Route is already registered <br/>";
								return "true";
							}
						}
					}
					return "false";
				}else{
					return "false";
				}
			}
			?>
		</fieldset>
	</div>

	<div class="container">
		<?php
		if($userstatus=="Admin"||$userstatus=="Manager"){
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
				<fieldset id="routeentry">
					<form name="routeentry" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<fieldset>
							<select name="sp" required>
								<option>--Starting location--</option>
								<?php 
								foreach($location as $i){ 
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php
								} 
								?>
							</select>
							<legend>starting location</legend>
						</fieldset>
						<fieldset>
							<select name="fp" required>
								<option>--Final location--</option>
								<?php 
								foreach($location as $i){ 
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php
								} 
								?>
							</select>
							<legend>final location</legend>
						</fieldset>
						<button name="routeentry">enter</button>
					</form>
					<legend>Route entry</legend>
				</fieldset>
				<fieldset id="editroute">
					<?php
					$sql="SELECT * from route";
					$result=mysqli_query($conn,$sql);
					$cnt1=mysqli_num_rows($result);
					?>
					<div style="max-width: 220px; margin: 2% auto;">
						<section id="section">
							<input type="search" id="search" name="search" placeholder="Search route name" autocomplete="off">
							<button id="btn">back</button>
						</section>
						<fieldset id="c11" style=" background-color: transparent; box-shadow: none;">
							<fieldset id="c11x">
								<button class="bb">1</button>
								<?php
								for($i=1;$i<=($cnt1/8.1);$i++){
									?>
									<button class="bb"><?php echo $i+1;?></button>
									<?php
								}
								?>
							</fieldset>
						</fieldset>
					</div>
					<div id="oflow">

					</div>
					<?php
					for($j=1;$j<=(($cnt1/8.1)+1);$j++){
						$x1=($j-1)*8;
						?>
						<div id="overflow" class="off">
							<?php
							$sql="SELECT * from route LIMIT $x1,8";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									?>
									<fieldset id="c11">
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden>
											<select name="sp">
												<?php 
												foreach($location as $i){ 
													?>
													<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
												} 
												?>
											</select>
											<button name="spedit">EDIT</button>
										</form>
										<label>&#62</label>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden>
											<select name="fp">
												<?php 
												foreach($location as $i){ 
													?>
													<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
												}
												?>
											</select>
											<button name="fpedit">EDIT</button>
										</form>
										<legend><?php echo $row['sp']." > ".$row['fp']; ?></legend>
									</fieldset>
									<?php
								}
							}else{
								?>
								<label>no records of routes found</label>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
					<legend>edit Routes</legend>
				</fieldset>
				<script>
					var cx1='<?php echo $cnt1/8.1; ?>';
					var kof1=document.getElementsByClassName('off');
					var kb1=document.getElementsByClassName('bb');
					var oflow=document.getElementById('oflow');
					var srch=document.getElementById('search');
					for(let l=0;l<=cx1;l++){
						if(kof1[0]!=kof1[l]){
							if(kof1[l]){
								kof1[l].style.display='none';
							}
						}
					}
					for(let k=0;k<=cx1;k++){
						kb1[k].onclick=function(){
							for(let l=0;l<=cx1;l++){
								if(kof1[k]==kof1[l]){
									if(kof1[l]){
										kof1[l].style.display='flex';
									}
								}else{
									if(kof1[l]){
										kof1[l].style.display='none';
									}
								}
							}
							oflow.style.display='none';
							srch.value="";
						}
					}
				</script>
				<script>
					var s=document.getElementById('search');
					s.oninput=function(){
						let y=s.value;
						let x=y.toUpperCase();
						document.getElementById('oflow').style.display='flex';
						document.getElementById('overflow').style.display='none';
						var cx1='<?php echo $cnt1/8.1; ?>';
						var kof1=document.getElementsByClassName('off');
						for(let l=0;l<=cx1;l++){
							if(kof1[0]!=kof1[l]){
								if(kof1[l]){
									kof1[l].style.display='none';
								}
							}
						}
						<?php
						$sql1="SELECT * from route";
						$result1=mysqli_query($conn,$sql1);
						if(mysqli_num_rows($result1)>0){
							while($row1=mysqli_fetch_assoc($result1)){
								$bcd=strtoupper($row1['sp']);
								$bno=strtoupper($row1['fp']);
								$bnd=$bcd." ".$bno;
								?>
								var bcd='<?php echo $bcd;?>';
								var bno='<?php echo $bno;?>';
								var bnd='<?php echo $bnd;?>';
								if(x==bnd||x==bcd||x==bno){
									if(x==bnd){
										document.getElementById('oflow').innerHTML=('<?php
											$sql="SELECT * from route WHERE sp='$bcd' && fp='$bno' ";
											$result=mysqli_query($conn,$sql);
											if(mysqli_num_rows($result)>0){
												while($row=mysqli_fetch_assoc($result)){
													?><fieldset id="c11"><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden><select name="sp"><?php 
													foreach($location as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													} 
													?>
													</select><button name="spedit">EDIT</button></form><label>&#62</label><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden><select name="fp"><?php 
													foreach($location as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													}
													?>
													</select><button name="fpedit">EDIT</button></form><legend><?php echo $row['sp']." > ".$row['fp']; ?></legend></fieldset><?php
												}
											}?>');
									}
									if(x==bcd){
										document.getElementById('oflow').innerHTML=('<?php
											$sql="SELECT * from route WHERE sp='$bcd' || fp='$bcd' ";
											$result=mysqli_query($conn,$sql);
											if(mysqli_num_rows($result)>0){
												while($row=mysqli_fetch_assoc($result)){
													?><fieldset id="c11"><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden><select name="sp"><?php 
													foreach($location as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													} 
													?>
													</select><button name="spedit">EDIT</button></form><label>&#62</label><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden><select name="fp"><?php 
													foreach($location as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													}
													?>
													</select><button name="fpedit">EDIT</button></form><legend><?php echo $row['sp']." > ".$row['fp']; ?></legend></fieldset><?php
												}
											}?>');
									}
									if(x==bno){
										document.getElementById('oflow').innerHTML=('<?php
											$sql="SELECT * from route WHERE sp='$bno' || fp='$bno' ";
											$result=mysqli_query($conn,$sql);
											if(mysqli_num_rows($result)>0){
												while($row=mysqli_fetch_assoc($result)){
													?><fieldset id="c11"><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden><select name="sp"><?php 
													foreach($location as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													} 
													?>
													</select><button name="spedit">EDIT</button></form><label>&#62</label><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $row['rid']; ?>" hidden><select name="fp"><?php 
													foreach($location as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													}
													?>
													</select><button name="fpedit">EDIT</button></form><legend><?php echo $row['sp']." > ".$row['fp']; ?></legend></fieldset><?php
												}
											}?>');
									}
								}
								<?php
							}
						}
						?>
					}
				</script>
				<script>
					var btn=document.getElementById('btn');
					var of=document.getElementById('overflow');
					var of1=document.getElementById('oflow');
					var s=document.getElementById('search');
					var cx1='<?php echo $cnt1/8.1; ?>';
					var kof1=document.getElementsByClassName('off');
					btn.onclick=function(){
						of1.style.display='none';
						of.style.display='flex';
						s.value="";
						for(let l=0;l<=cx1;l++){
							if(kof1[0]!=kof1[l]){
								if(kof1[l]){
									kof1[l].style.display='none';
								}
							}
						}
					}
				</script>
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
				<script>
					var c2=document.getElementById('c2');
					var ls1=document.getElementById('ls1');
					var rs1=document.getElementById('rs1');
					c2.style.display="none";
					ls1.style.display='none';
					rs1.style.display='none';
				</script>
				<div class="container1" id="c5">
					<fieldset id="phpmethod">
						<?php
						function storecheckpoint($a,$b,$c,$conn){
							$check=repeatcheck($conn,$a,$b);
							if($check=="false"){
								$sql="INSERT INTO checkpoint(rid,route,price) VALUES('$a','$b','$c')";
								if($conn->query($sql)===TRUE){
									echo "<br/>checkpoint is registered";
								}
								else{
									echo "Error".$sql.$conn->error;
								}
							}
						}
						function repeatcheck($conn,$a,$b){
							$sql="SELECT rid,route from checkpoint";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									if($a==$row["rid"]){
										if($b==$row["route"]){
										//echo "<br/>checkpoint is already registered <br/>";
											return "true";
										}
									}
								}
								return "false";
							}else{
								return "false";
							}
						}
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['checkpoint'])){
								?>
								<script>
									var c1=document.getElementById('c1');
									var c2=document.getElementById('c2');
									var ls=document.getElementById('ls');
									var rs=document.getElementById('rs');
									var ls1=document.getElementById('ls1');
									var rs1=document.getElementById('rs1');
									c1.style.display='none';
									c2.style.display='flex';
									ls.style.display='none';
									rs.style.display='none';
									ls1.style.display='flex';
									rs1.style.display='flex';
								</script>
								<?php
								$rid=check_data($_POST['rid']);
								$route=check_data($_POST['route']);
								$price=check_data($_POST['price']);
								$count2=0;
								for($i=0;$i<count($location);$i++){
									if($route!=$location[$i]){
										$count2++;
									}
								}
								if($count2==count($location)){
									echo "<br/>Error in route...select from the given option!!!";
								}else{
									storecheckpoint($rid,$route,$price,$conn);
								}
							}

							if(isset($_POST['cpedit'])){
								?>
								<script>
									var c1=document.getElementById('c1');
									var c2=document.getElementById('c2');
									var ls=document.getElementById('ls');
									var rs=document.getElementById('rs');
									var ls1=document.getElementById('ls1');
									var rs1=document.getElementById('rs1');
									c1.style.display='none';
									c2.style.display='flex';
									ls.style.display='none';
									rs.style.display='none';
									ls1.style.display='flex';
									rs1.style.display='flex';
								</script>
								<?php
								$rid=check_data($_POST['rid']);
								$cpid=check_data($_POST['croute']);
								$route=check_data($_POST['route']);
								$sql="SELECT route from checkpoint where cpid='$cpid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$r=$row['route'];
										if($r==$route){
										//echo "already edited ";
										}else{
											$sql1="UPDATE checkpoint set route='$route' where cpid='$cpid' ";
											if(mysqli_query($conn,$sql1)){
												echo "updated data";
											}else{
												echo "error updating.. ".mysqli_error($conn);
											}
										}
									}
								}
							}
							if(isset($_POST['cpprice'])){
								?>
								<script>
									var c1=document.getElementById('c1');
									var c2=document.getElementById('c2');
									var ls=document.getElementById('ls');
									var rs=document.getElementById('rs');
									var ls1=document.getElementById('ls1');
									var rs1=document.getElementById('rs1');
									c1.style.display='none';
									c2.style.display='flex';
									ls.style.display='none';
									rs.style.display='none';
									ls1.style.display='flex';
									rs1.style.display='flex';
								</script>
								<?php
								$cpid=check_data($_POST['croute']);
								$price=check_data($_POST['price']);
								$sql="SELECT price from checkpoint where cpid='$cpid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$p=$row['price'];
										if($p==$price){
										//echo "already edited ";
										}else{
											$sql1="UPDATE checkpoint set price='$price' where cpid='$cpid' ";
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
				<fieldset id="checkpointentry">
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<fieldset>
							<select name="rid" required>
								<option>--select route--</option>
								<?php
								$sql="SELECT * from route";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$rid=$row['rid'];
										$sp=$row['sp'];
										$fp=$row['fp'];
										?>
										<option value="<?php echo $rid;?>"><?php echo $sp." > ".$fp; ?></option>
										<?php
									}
								}else{
									?>
									<label>add routes first</label>
									<?php
								}
								?>
							</select>
							<legend>route</legend>
						</fieldset>
						<fieldset>
							<select name="route" required>
								<option>--Checkpoint--</option>
								<?php 
								foreach($location as $i){ 
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php
								} 
								?>
							</select>
							<legend>checkpoint</legend>
						</fieldset>
						<fieldset>
							<input type="number" name="price" placeholder="ENTER PRICE" autocomplete="off" required>
							<legend>price</legend>
						</fieldset>
						<button name="checkpoint">ENTER</button>
					</form>
					<legend>checkpoint entry</legend>
				</fieldset>
				<fieldset id="editcheckpoint">
					<?php
					$sql="SELECT * from route";
					$result=mysqli_query($conn,$sql);
					$cnt1m=mysqli_num_rows($result);
					?>
					<div style="max-width: 220px; margin: 2% auto;">
						<section id="section">
							<input type="search" id="searchm" name="search" placeholder="Search route name" autocomplete="off">
							<button id="btnm">back</button>
						</section>
						<fieldset id="c11" style=" background-color: transparent; box-shadow: none;">
							<fieldset id="c11x">
								<button class="bbm">1</button>
								<?php
								for($i=1;$i<=($cnt1m/8.1);$i++){
									?>
									<button class="bbm"><?php echo $i+1;?></button>
									<?php
								}
								?>
							</fieldset>
						</fieldset>
					</div>
					<div id="oflowm">

					</div>
					<?php
					for($j=1;$j<=(($cnt1m/8.1)+1);$j++){
						$x1=($j-1)*8;
						?>
						<div id="overflowm" class="offm">
							<?php
							$sql="SELECT * from route LIMIT $x1,8";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$rid=$row['rid'];
									$sp=$row['sp'];
									$fp=$row['fp'];
									?>
									<fieldset id="c11">
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="rid" value="<?php echo $rid; ?>" hidden>
											<fieldset>
												<select name="croute">
													<option value="" readonly><?php echo "Enter checkpoint"; ?></option>
													<?php
													$sql1="SELECT * from checkpoint where rid='$rid'";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option>
															<?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option>
														<?php 
													}
													?>
												</select>
												<label>&#62</label>
												<select name="route">
													<?php 
													$location1=\array_diff($location1, ["$sp","$fp"]);
													foreach($location1 as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													} 
													?>
												</select>
												<legend>edit route</legend>
											</fieldset>
											<button name="cpedit">EDIT</button>
										</form>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<fieldset>
												<select name="croute">
													<option value="" readonly><?php echo "Enter checkpoint"; ?></option>
													<?php
													$sql1="SELECT * from checkpoint where rid='$rid' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option>
															<?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option>
														<?php 
													}
													?>
												</select>
												<input type="number" name="price" placeholder="edit price">
												<legend>edit price</legend>
											</fieldset>

											<button name="cpprice">EDIT</button>
										</form>
										<legend>
											<?php
											echo $sp;
											$sql1="SELECT * from checkpoint where rid='$rid' ";
											$result1=mysqli_query($conn,$sql1);
											if(mysqli_num_rows($result1)>0){
												while($row1=mysqli_fetch_assoc($result1)){
													echo " > ".$row1['route'].":".$row1['price'];
												}
											}
											echo " > ".$fp;
											?>
										</legend>
									</fieldset>
									<?php
								}
							}
							?>
						</div>
						<?php
					}
					?>
					<legend>Edit checkpoint</legend>
				</fieldset>
				<script>
					var cx1m='<?php echo $cnt1m/8.1; ?>';
					var kof1m=document.getElementsByClassName('offm');
					var kb1m=document.getElementsByClassName('bbm');
					var oflowx=document.getElementById('oflowm');
					var srchx=document.getElementById('searchm');
					for(let l=0;l<=cx1m;l++){
						if(kof1m[0]!=kof1m[l]){
							if(kof1m[l]){
								kof1m[l].style.display='none';
							}
						}
					}
					for(let k=0;k<=cx1m;k++){
						kb1m[k].onclick=function(){
							for(let l=0;l<=cx1m;l++){
								if(kof1m[k]==kof1m[l]){
									if(kof1m[l]){
										kof1m[l].style.display='flex';
									}
								}else{
									if(kof1m[l]){
										kof1m[l].style.display='none';
									}
								}
							}
							oflowx.style.display='none';
							srchx.value="";
						}
					}
				</script>
				<script>
					var sm=document.getElementById('searchm');
					sm.oninput=function(){
						let ym=sm.value;
						let xm=ym.toUpperCase();
						document.getElementById('oflowm').style.display='flex';
						document.getElementById('overflowm').style.display='none';
						var cx1m='<?php echo $cnt1m/8.1; ?>';
						var kof1m=document.getElementsByClassName('offm');
						for(let l=0;l<=cx1m;l++){
							if(kof1m[0]!=kof1m[l]){
								if(kof1m[l]){
									kof1m[l].style.display='none';
								}
							}
						}
						<?php
						$sql1x="SELECT * from route";
						$result1x=mysqli_query($conn,$sql1x);
						if(mysqli_num_rows($result1x)>0){
							while($row1x=mysqli_fetch_assoc($result1x)){
								$bcd=strtoupper($row1x['sp']);
								$bno=strtoupper($row1x['fp']);
								$bnd=$bcd." ".$bno;
								?>
								var bcd='<?php echo $bcd;?>';
								var bno='<?php echo $bno;?>';
								var bnd='<?php echo $bnd;?>';
								if(xm==bnd||xm==bcd||xm==bno){
									if(xm==bnd){
										document.getElementById('oflowm').innerHTML=('<?php
											$sql="SELECT * from route WHERE sp='$bcd' && fp='$bno' ";
											$result=mysqli_query($conn,$sql);
											if(mysqli_num_rows($result)>0){
												while($row=mysqli_fetch_assoc($result)){
													$rid=$row['rid'];
													$sp=$row['sp'];
													$fp=$row['fp'];
													?><fieldset id="c11"><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $rid; ?>" hidden><fieldset><select name="croute"><option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													$sql1="SELECT * from checkpoint where rid='$rid'";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option><?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php 
													}
													?></select><label>&#62</label><select name="route"><?php 
													$location1=\array_diff($location1, ["$sp","$fp"]);
													foreach($location1 as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													} 
													?></select><legend>edit route</legend></fieldset><button name="cpedit">EDIT</button></form><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><fieldset><select name="croute"><option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													$sql1="SELECT * from checkpoint where rid='$rid' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option><?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													}
													?></select><input type="number" name="price" placeholder="edit price"><legend>edit price</legend></fieldset><button name="cpprice">EDIT</button></form><legend><?php
													echo $sp;
													$sql1="SELECT * from checkpoint where rid='$rid' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															echo " > ".$row1['route'].":".$row1['price'];
														}
													}
													echo " > ".$fp;
													?>
													</legend></fieldset><?php
												}
											}?>');
									}
									if(xm==bcd){
										document.getElementById('oflowm').innerHTML=('<?php
											$sql="SELECT * from route WHERE sp='$bcd' || fp='$bcd' ";
											$result=mysqli_query($conn,$sql);
											if(mysqli_num_rows($result)>0){
												while($row=mysqli_fetch_assoc($result)){
													$rid=$row['rid'];
													$sp=$row['sp'];
													$fp=$row['fp'];
													?><fieldset id="c11"><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $rid; ?>" hidden><fieldset><select name="croute"><option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													$sql1="SELECT * from checkpoint where rid='$rid'";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option><?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php 
													}
													?></select><label>&#62</label><select name="route"><?php 
													$location1=\array_diff($location1, ["$sp","$fp"]);
													foreach($location1 as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													} 
													?></select><legend>edit route</legend></fieldset><button name="cpedit">EDIT</button></form><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><fieldset><select name="croute"><option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													$sql1="SELECT * from checkpoint where rid='$rid' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option><?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													}
													?></select><input type="number" name="price" placeholder="edit price"><legend>edit price</legend></fieldset><button name="cpprice">EDIT</button></form><legend><?php
													echo $sp;
													$sql1="SELECT * from checkpoint where rid='$rid' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															echo " > ".$row1['route'].":".$row1['price'];
														}
													}
													echo " > ".$fp;
													?>
													</legend></fieldset><?php
												}
											}?>');
									}
									if(xm==bno){
										document.getElementById('oflowm').innerHTML=('<?php
											$sql="SELECT * from route WHERE sp='$bno' || fp='$bno' ";
											$result=mysqli_query($conn,$sql);
											if(mysqli_num_rows($result)>0){
												while($row=mysqli_fetch_assoc($result)){
													$rid=$row['rid'];
													$sp=$row['sp'];
													$fp=$row['fp'];
													?><fieldset id="c11"><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="rid" value="<?php echo $rid; ?>" hidden><fieldset><select name="croute"><option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													$sql1="SELECT * from checkpoint where rid='$rid'";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option><?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php 
													}
													?></select><label>&#62</label><select name="route"><?php 
													$location1=\array_diff($location1, ["$sp","$fp"]);
													foreach($location1 as $i){ 
														?>
														<option value="<?php echo $i ?>"><?php echo $i ?></option><?php
													} 
													?></select><legend>edit route</legend></fieldset><button name="cpedit">EDIT</button></form><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><fieldset><select name="croute"><option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													$sql1="SELECT * from checkpoint where rid='$rid' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															?>
															<option value="<?php echo $row1['cpid']; ?>"><?php echo $row1['route']; ?></option><?php 
														}
													}else{
														?>
														<option value="" readonly><?php echo "Enter checkpoint"; ?></option><?php
													}
													?></select><input type="number" name="price" placeholder="edit price"><legend>edit price</legend></fieldset><button name="cpprice">EDIT</button></form><legend><?php
													echo $sp;
													$sql1="SELECT * from checkpoint where rid='$rid' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															echo " > ".$row1['route'].":".$row1['price'];
														}
													}
													echo " > ".$fp;
													?>
													</legend></fieldset><?php
												}
											}?>');
									}
								}
								<?php
							}
						}
						?>
					}
				</script>
				<script>
					var btnxx=document.getElementById('btnm');
					var ofxx=document.getElementById('overflowm');
					var of1xx=document.getElementById('oflowm');
					var sxx=document.getElementById('searchm');
					var cx1m='<?php echo $cnt1m/8.1; ?>';
					var kof1m=document.getElementsByClassName('offm');
					btnxx.onclick=function(){
						of1xx.style.display='none';
						ofxx.style.display='flex';
						sxx.value="";
						for(let l=0;l<=cx1m;l++){
							if(kof1m[0]!=kof1m[l]){
								if(kof1m[l]){
									kof1m[l].style.display='none';
								}
							}
						}
					}
				</script>
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
			<fieldset id="f1x">
				<?php
				$sql="SELECT * from route";
				$result=mysqli_query($conn,$sql);
				$cnt1mx=mysqli_num_rows($result);
				?>
				<div style="max-width: 220px; margin: 2% auto;" id="d1">
					<fieldset id="c11" style="background-color: transparent; box-shadow: none;">
						<fieldset id="c11x">
							<button class="bbmx">1</button>
							<?php
							for($i=1;$i<=($cnt1mx/8.1);$i++){
								?>
								<button class="bbmx"><?php echo $i+1;?></button>
								<?php
							}
							?>
						</fieldset>
					</fieldset>
				</div>
				<?php
				for($j=1;$j<=(($cnt1mx/8.1)+1);$j++){
					$x1=($j-1)*8;
					?>
					<div id="overflowm" class="offmx">
						<?php
						$sql="SELECT * from route LIMIT $x1,8";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$rid=$row['rid'];
								$sqlx="SELECT * from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid WHERE rid='$rid' ";
								$total=mysqli_num_rows(mysqli_query($conn,$sqlx));
								?>
								<fieldset id="c11">
									<label>
										<?php echo $row['sp'];
										echo " > ";
										$sql1="SELECT * from checkpoint where rid='$rid'";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												echo $row1['route']." > ";
											}
										}
										echo $row['fp']; ?>
									</label>
									<legend><?php echo $total; ?> schedule</legend>
								</fieldset>
								<?php
							}
						}else{
							?>
							<label>no records found</label>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
				<legend>Routes</legend>
			</fieldset>
			<script>
				var cx1mx='<?php echo $cnt1mx/8.1; ?>';
				var kof1mx=document.getElementsByClassName('offmx');
				var kb1mx=document.getElementsByClassName('bbmx');
				for(let l=0;l<=cx1mx;l++){
					if(kof1mx[0]!=kof1mx[l]){
						if(kof1mx[l]){
							kof1mx[l].style.display='none';
						}
					}
				}
				for(let k=0;k<=cx1mx;k++){
					kb1mx[k].onclick=function(){
						for(let l=0;l<=cx1mx;l++){
							if(kof1mx[k]==kof1mx[l]){
								if(kof1mx[l]){
									kof1mx[l].style.display='flex';
								}
							}else{
								if(kof1mx[l]){
									kof1mx[l].style.display='none';
								}
							}
						}
					}
				}
			</script>
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
					$q=mysqli_num_rows($result);$sql="SELECT * from busschedule where bsstatus!='going' && bsstatus!='Expired' ";
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
				<a href="../route/route.php" id="active"><i class='fas fa-route' style='font-size:25px;'></i><label>routes</label></a>
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
				<a href="../user/user.php"><i class='fas fa-user-alt' style='font-size:25px;'></i><label>user</label></a>
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

	<script src="../route/route.js"></script>

</body>
</html>