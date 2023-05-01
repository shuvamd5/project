<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bus/bus.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title>OBTS/BUS</title>
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

	$bcd0=$bcd1=$bcd2=$bcd=$bno=$bname=$btype=$nseat=$stype=$bstatus=$bsapby="";
	$zonecode=array("ME"=>"मे","KO"=>"को","SA"=>"स","JA"=>"ज","BA"=>"बा","NA"=>"ना","GA"=>"ग","LU"=>"लु","DH"=>"ध","RA"=>"र","BHE"=>"भे","KA"=>"क","SE"=>"से","MA"=>"म");
	$vehicletype=array("KA"=>"क","KHA"=>"ख");
	$zonecode1=array("ME","KO","SA","JA","BA","NA","GA","LU","DH","RA","BHE","KA","SE","MA");
	$vehicletype1=array("KA","KHA");
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
				if(isset($_POST['bedit'])){
					$bid=check_data($_POST['bid']);
					$bsapby=check_data($_POST['bsapby']);
					$bstatus=check_data($_POST['bstatus']);
					$sql="SELECT bstatus from bus where bid='$bid' ";
					$result=mysqli_query($conn,$sql);
					if(mysqli_num_rows($result)>0){
						while($row=mysqli_fetch_assoc($result)){
							$bs=$row['bstatus'];
							if($bs==$bstatus){
										//echo "already edited ";
							}else{
								$sql1="UPDATE bus set bstatus='$bstatus',bsapby='$bsapby' where bid='$bid' ";
								if(mysqli_query($conn,$sql1)){
									//echo "data updated";
								}else{
									echo "error updating.. ".mysqli_error($conn);
								}
								if($bstatus!="active"){
									$sql1="UPDATE busschedule set bsstatus='unchecked' ,bssapby='$bsapby' where bid='$bid' && bsstatus!='Expired' ";
								if(mysqli_query($conn,$sql1)){
									//echo "data updated";
								}else{
									echo "error updating.. ".mysqli_error($conn);
								}
								$sql1="UPDATE addroute INNER JOIN busschedule on addroute.bsid=busschedule.bsid set arstatus='unchecked' where bid='$bid' && arstatus!='Expired' ";
								if(mysqli_query($conn,$sql1)){
									echo "data updated";
								}else{
									echo "error updating.. ".mysqli_error($conn);
								}
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
					c1.style.display='flex';
					ls.style.display='flex';
					rs.style.display='flex';
				</script>

				<fieldset style="max-width: 100%; min-width: 100%; padding: 2% 0; display: flex; flex-wrap: wrap;">
					
					<?php
					$sql="SELECT * from bus";
					$result=mysqli_query($conn,$sql);
					$cnt=mysqli_num_rows($result);
					?>
					<div style="margin: 2% auto; max-width: 220px;">
						<section id="section">
							<input type="search" id="search" name="search" placeholder="Search bus number plate" autocomplete="off">
							<button id="btn">back</button>
						</section>
						<fieldset id="c11" style=" background-color: transparent; box-shadow: none;">
							<fieldset id="c11x">
								<button class="b">1</button>
								<?php
								for($i=1;$i<=($cnt/8.1);$i++){
									?>
									<button class="b"><?php echo $i+1;?></button>
									<?php
								}
								?>
							</fieldset>
						</fieldset>
					</div>
					<div id="oflow">

					</div>
					<?php
					for($j=1;$j<=(($cnt/8.1)+1);$j++){
						$x=($j-1)*8;
						?>

						<div id="overflow" class="of">
							<?php
							$sql="SELECT * from bus LIMIT $x,8";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$bid=$row['bid'];
									$sql1="SELECT * from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid WHERE bid='$bid' && bsstatus='going' && arstatus='ok' ";
									$result1=mysqli_num_rows(mysqli_query($conn,$sql1));
									?>
									<fieldset id="c11">
										<label><?php echo $row['bcd']." ".$row['bno']; ?></label>
										<label><?php echo "name: ".$row['bname']; ?></label>
										<label><?php echo "type: ".$row['btype']; ?></label>
										<label><?php echo "seats: ".$row['nseat']." (".$row['stype'].")"; ?></label>
										<label><?php echo "schedule: ".$result1; ?> on-route</label>
										<label>
											<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
												<input type="number" name="bid" value="<?php echo $row['bid']; ?>" hidden>
												<input type="text" name="bsapby" value="<?php echo $_SESSION['uname']; ?>" hidden>
												<select name="bstatus">
													<option value="unchecked">unchecked</option>
													<option value="active">active</option>
													<option value="inactive">inactive</option>
												</select>
												<button name="bedit">edit</button>
											</form>
										</label>
										<legend><?php echo $row['bstatus']; ?></legend>
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
					<legend style="position: absolute; left: 5.8%; top: 15%;">Edit status</legend>
				</fieldset>

				<script>
					var cx='<?php echo $cnt/8.1; ?>';
					var kof=document.getElementsByClassName('of');
					var kb=document.getElementsByClassName('b');
					var oflow=document.getElementById('oflow');
					var srch=document.getElementById('search');
					for(let l=0;l<=cx;l++){
						if(kof[0]!=kof[l]){
							if(kof[l]){
								kof[l].style.display='none';
							}
						}
					}
					for(let k=0;k<=cx;k++){
						kb[k].onclick=function(){
							for(let l=0;l<=cx;l++){
								if(kof[k]==kof[l]){
									if(kof[l]){
										kof[l].style.display='flex';
									}
								}else{
									if(kof[l]){
										kof[l].style.display='none';
									}
								}
							}
							oflow.style.display='none';
							srch.value="";
							srch.reset();
						}
					}
				</script>
				<script>
					var s=document.getElementById('search');
					s.oninput=function(){
						var y=s.value;
						var x=y.toUpperCase();
						document.getElementById('oflow').style.display='flex';
						document.getElementById('overflow').style.display='none';
						var cx='<?php echo $cnt/8.1; ?>';
						var kof=document.getElementsByClassName('of');
						for(let l=0;l<=cx;l++){
							if(kof[0]!=kof[l]){
								if(kof[l]){
									kof[l].style.display='none';
								}
							}
						}
						<?php
						$sql2="SELECT * from bus";
						$result2=mysqli_query($conn,$sql2);
						if(mysqli_num_rows($result2)>0){
							while($row2=mysqli_fetch_assoc($result2)){
								$bcd=$row2['bcd'];
								$bno=$row2['bno'];
								$bnd=$bcd." ".$bno;
								?>
								var bnd='<?php echo $bnd;?>';
								var bno='<?php echo $bno;?>';
								if(x==bnd || x==bno){
									document.getElementById('oflow').innerHTML=('<?php 
										$sql="SELECT * from bus WHERE (bno='$bno') || (bcd='$bcd' && bno='$bno') ";
										$result=mysqli_query($conn,$sql);
										if(mysqli_num_rows($result)>0){
											while($row=mysqli_fetch_assoc($result)){
												$bid=$row['bid'];
												$sql1="SELECT * from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid WHERE bid='$bid' && bsstatus='going' && arstatus='ok' ";
												$result1=mysqli_num_rows(mysqli_query($conn,$sql1));
												?>
												<fieldset id="c11"><label><?php echo $row['bcd']." ".$row['bno']; ?></label><label><?php echo "name: ".$row['bname']; ?></label><label><?php echo "type: ".$row['btype']; ?></label><label><?php echo "seats: ".$row['nseat']." (".$row['stype'].")"; ?></label><label><?php echo "schedule: ".$result1; ?> on-route</label><label><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="bid" value="<?php echo $row['bid']; ?>" hidden><input type="text" name="bsapby" value="<?php echo $_SESSION['uname']; ?>" hidden><select name="bstatus"><option value="unchecked">unchecked</option><option value="active">active</option><option value="inactive">inactive</option></select><button name="bedit">edit</button></form></label><legend><?php echo $row['bstatus']; ?></legend></fieldset><?php
											}
										}?>');
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
					var cx='<?php echo $cnt/8.1; ?>';
					var kof=document.getElementsByClassName('of');
					btn.onclick=function(){
						of1.style.display='none';
						of.style.display='flex';
						s.value="";
						for(let l=0;l<=cx;l++){
							if(kof[0]!=kof[l]){
								if(kof[l]){
									kof[l].style.display='none';
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
					c1.style.display='none';
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
						c2.style.display='none';
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
				<div class="container1" id="c5">
					<fieldset id="phpmethod">
						<?php
						function repeat($conn,$a,$b){
							$sql="SELECT * from bus where bcd='$a' && bno='$b' ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								return "true";
							}else{
								return "false";
							}
						}
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['busentry'])){
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
								$bcd0=strtoupper(check_data($_POST['bcd0']));
								$bcd1=check_data($_POST['bcd1']);
								$bcd2=strtoupper(check_data($_POST['bcd2']));
								$bno=check_data($_POST['bno']);
								$bname=strtoupper(check_data($_POST['bname']));
								$btype=check_data($_POST['btype']);
								$nseat=check_data($_POST['nseat']);
								$stype=strtoupper(check_data($_POST['stype']));
								$bstatus="unchecked";
								$bsapby="none";
								$bcd=$bcd0." ".$bcd1;
								$bcd=$bcd." ".$bcd2;
								$count=$count1=0;
								for($i=0;$i<count($zonecode1);$i++){
									if($bcd0!=$zonecode1[$i]){
										$count++;
									}
								}
								for($i=0;$i<count($vehicletype1);$i++){
									if($bcd2!=$vehicletype1[$i]){
										$count1++;
									}
								}
								if($count==count($zonecode1)){
									echo "<br/>Error in zonecode...select from the given option!!!";
								}else if($count1==count($vehicletype1)){
									echo "<br/>Error in type...select from the given option!!!";
								}else{
									$check=repeat($conn,$bcd,$bno);
									if($check=="false"){
										$sql="INSERT INTO bus(bcd,bno,bname,btype,nseat,stype,bstatus,bsapby) 
										VALUES('$bcd','$bno','$bname','$btype','$nseat','$stype','$bstatus','$bsapby')";
										if($conn->query($sql)===TRUE){
											echo "bus registered";
										}else{
											echo "Error".$sql.$conn->error;
										}
									}
								}
							}
						}	
						?>
					</fieldset>
				</div>
				<fieldset id="bentry">
					<form name="busentry" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<fieldset>
							<div id="bcd">
								<select name="bcd0" required>
									<option>--select zone code--</option>
									<?php 
									foreach($zonecode as $i=>$j){ 
										?>
										<option value="<?php echo $i ?>"><?php echo $i." / ".$j ?></option>
										<?php 
									} 
									?>
								</select>
								<input type="tel" name="bcd1" placeholder="Number" autocomplete="off" pattern="[0-9]{1}||[0-9]{2}" required>
								<select name="bcd2" required>
									<option>--select vehicle type--</option>
									<?php 
									foreach($vehicletype as $i=>$j){ 
										?>
										<option value="<?php echo $i ?>"><?php echo $i." / ".$j ?></option> 
										<?php 
									} 
									?>
								</select>
								<input type="tel" name="bno" placeholder="BUS NUMBER" autocomplete="off" pattern="[0-9]{4}" required>
								<input type="text" id="bname" name="bname" placeholder="NAME" autocomplete="off" required>
							</div>
							<legend>number plate</legend>
						</fieldset>
						<fieldset>
							<div>
								<input type="radio" name="btype" value="A/C" required> A/C
								<input type="radio" name="btype" value="Deluxe"> Deluxe
								<input type="radio" name="btype" value="Suspension"> Suspension
							</div>
							<legend>features</legend>
						</fieldset>
						<fieldset>
							<div>
								<input type="radio" name="nseat" value="37" required> 37
								<input type="radio" name="nseat" value="39"> 39
							</div>
							<legend>no. of seats</legend>
						</fieldset>
						<fieldset>
							<div>
								<input type="radio" name="stype" value="foldable" required> Foldable
								<input type="radio" name="stype" value="semi-foldable"> Semi-Foldable
								<input type="radio" name="stype" value="unfoldable"> Unfoldable
							</div>
							<legend>seat type</legend>
						</fieldset>
						<fieldset>
							<button name="busentry" id="busentry">add</button>
						</fieldset>
					</form>
					<legend style="text-align: right; transform: translateY(10px);">bus entry</legend>
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
					c2.style.display='none';
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
					c3.style.display='none';
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
			<div class="container1" id="c5" style="color: white;">
				<fieldset id="phpmethod">
					<?php
					if($_SERVER['REQUEST_METHOD']=='POST'){
						if(isset($_POST['bdel'])){
							?>
							<script>
								var c1=document.getElementById('c1');
								var c2=document.getElementById('c3');
								var ls=document.getElementById('ls');
								var rs=document.getElementById('rs');
								var ls1=document.getElementById('ls2');
								var rs1=document.getElementById('rs2');
								c1.style.display='none';
								c2.style.display='flex';
								ls.style.display='none';
								rs.style.display='none';
								ls1.style.display='flex';
								rs1.style.display='flex';
							</script>
							<?php
							$bid=$_POST['bid'];
							$cd=date_create(date("Y-m-d"));
							//date_add($cd,date_interval_create_from_date_string("+6 day"));
							$sql1="SELECT * from ((seats INNER JOIN addroute on seats.arid=addroute.arid)INNER JOIN busschedule on addroute.bsid=busschedule.bsid) WHERE bid='$bid' ";
							$sc=mysqli_num_rows(mysqli_query($conn,$sql1));
							$sql1="SELECT * from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid WHERE bid='$bid' && arstatus='ok' ";
							$result1=mysqli_query($conn,$sql1);
							if(mysqli_num_rows($result1)>0){
								echo $sc." seats are recorded...continue ? ";
								?>
								<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
									<input type="number" name="bid" value="<?php echo $bid; ?>" hidden>
									<div style="display: flex; justify-content: space-between;">
										<button name="bdelyes" style="margin-left: 5%;">yes</button>
										<button id="bdelno" style="margin-left: 5%;">no</button>
									</div>
								</form>
								<?php
							}else{
								echo $sc." seats are recorded...continue ? ";
								?>
								<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
									<input type="number" name="bid" value="<?php echo $bid; ?>" hidden>
									<div style="display: flex; justify-content: space-between;">
										<button name="bdelyes" style="margin-left: 5%;">yes</button>
										<button id="bdelno" style="margin-left: 5%;">no</button>
									</div>
								</form>
								<?php
							}
						}
						if(isset($_POST['bdelyes'])){
							?>
							<script>
								var c1=document.getElementById('c1');
								var c2=document.getElementById('c3');
								var ls=document.getElementById('ls');
								var rs=document.getElementById('rs');
								var ls1=document.getElementById('ls2');
								var rs1=document.getElementById('rs2');
								c1.style.display='none';
								c2.style.display='flex';
								ls.style.display='none';
								rs.style.display='none';
								ls1.style.display='flex';
								rs1.style.display='flex';
							</script>
							<?php
							$bid=$_POST['bid'];
							$sql1="SELECT * from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid WHERE bid='$bid' ";
							$result1=mysqli_query($conn,$sql1);
							if(mysqli_num_rows($result1)>0){
								while($row1=mysqli_fetch_assoc($result1)){
									$bsid=$row1['bsid'];
									$arid=$row1['arid'];
									$sql="DELETE from ticket where arid='$arid' ";
									if(mysqli_query($conn,$sql)){
										//echo "data updated";
									}else{
									//echo "error updating.. ".mysqli_error($conn);
									}
									$sql="DELETE from seats where arid='$arid' ";
									if(mysqli_query($conn,$sql)){
										//echo "data updated";
									}else{
									//echo "error updating.. ".mysqli_error($conn);
									}
								}
							}
							$sql1="SELECT * from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid WHERE bid='$bid' ";
							$result1=mysqli_query($conn,$sql1);
							if(mysqli_num_rows($result1)>0){
								while($row1=mysqli_fetch_assoc($result1)){
									$bsid=$row1['bsid'];
									$arid=$row1['arid'];
									$sql="DELETE from addroute where arid='$arid' ";
									if(mysqli_query($conn,$sql)){
										//echo "data updated";
									}else{
									//echo "error updating.. ".mysqli_error($conn);
									}
									$sql="DELETE from busschedule where bsid='$bsid' ";
									if(mysqli_query($conn,$sql)){
										//echo "data updated";
									}else{
									//echo "error updating.. ".mysqli_error($conn);
									}
								}
							}
							$sql="DELETE from sales where bid='$bid' ";
							if(mysqli_query($conn,$sql)){
								//echo "data updated";
							}else{
									//echo "error updating.. ".mysqli_error($conn);
							}
							$sql="DELETE from bus where bid='$bid' ";
							if(mysqli_query($conn,$sql)){
								//echo "data updated";
							}else{
									//echo "error updating.. ".mysqli_error($conn);
							}
							$sql="SELECT * from sales";
							$result=mysqli_query($conn,$sql);
							$j=1;
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$sid=$row['sid'];
									if($sid>$j){
										$sql1="UPDATE sales set sid='$j' where sid='$sid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
									}
									$j++;
								}
							}
							$sql="ALTER TABLE sales auto_increment=1 ";
							if(mysqli_query($conn,$sql)){
									//echo "schedule deleted";
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
											//echo "error updating.. ".mysqli_error($conn);
										}
									}
									$j++;
								}
							}
							$sql="ALTER TABLE ticket auto_increment=1 ";
							if(mysqli_query($conn,$sql)){
									//echo "schedule deleted";
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
											//echo "error updating.. ".mysqli_error($conn);
										}
									}
									$j++;
								}
							}
							$sql="ALTER TABLE seats auto_increment=1 ";
							if(mysqli_query($conn,$sql)){
									//echo "schedule deleted";
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
										$sql1="UPDATE seats set arid='$j' where arid='$arid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
										$sql1="UPDATE ticket set arid='$j' where arid='$arid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
										$sql1="UPDATE addroute set arid='$j' where arid='$arid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
									}
									$j++;
								}
							}
							$sql="ALTER TABLE addroute auto_increment=1 ";
							if(mysqli_query($conn,$sql)){
									//echo "schedule deleted";
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
										$sql1="UPDATE sales set bsid='$j' where bsid='$bsid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
										$sql1="UPDATE addroute set bsid='$j' where bsid='$bsid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
										$sql1="UPDATE busschedule set bsid='$j' where bsid='$bsid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
									}
									$j++;
								}
							}
							$sql="ALTER TABLE busschedule auto_increment=1 ";
							if(mysqli_query($conn,$sql)){
									//echo "schedule deleted";
							}else{
								//echo "error updating.. ".mysqli_error($conn);
							}
							$sql="SELECT * from bus";
							$result=mysqli_query($conn,$sql);
							$j=1;
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$bid=$row['bid'];
									if($bid>$j){
										$sql1="UPDATE sales set bid='$j' where bid='$bid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
										$sql1="UPDATE busschedule set bid='$j' where bid='$bid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
										$sql1="UPDATE bus set bid='$j' where bid='$bid' ";
										if(mysqli_query($conn,$sql1)){
												//echo "schedule";
										}else{
											//echo "error updating.. ".mysqli_error($conn);
										}
									}
									$j++;
								}
							}
							$sql="ALTER TABLE bus auto_increment=1 ";
							if(mysqli_query($conn,$sql)){
								echo "data updated";
							}else{
								echo "error updating.. ".mysqli_error($conn);
							}
						}
					}	
					?>
				</fieldset>
				<script>
					var bdelno=document.getElementById('bdelno');
					bdelno.onclick=function(){
						window.location.reload();
					}
				</script>
			</div>
			<fieldset style="max-width: 100%; min-width: 100%; padding: 2% 0; display: flex; flex-wrap: wrap;">
				<?php
				if($userstatus=="User"||$userstatus==""){
					$sql="SELECT * from bus where bstatus='active' ";
				}else if($userstatus=="Admin" || $userstatus=="Manager"){
					$sql="SELECT * from bus";
				}
				$result=mysqli_query($conn,$sql);
				$cnt1=mysqli_num_rows($result);
				?>
				<div style="margin: 2% auto; max-width: 220px;">
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
				<?php
				for($j=1;$j<=(($cnt1/8.1)+1);$j++){
					$x1=($j-1)*8;
					?>
					<div id="overflow" class="off">
						<?php
						if($userstatus=="User"||$userstatus==""){
							$sql="SELECT * from bus where bstatus='active' LIMIT $x1,8 ";
						}else if($userstatus=="Admin" || $userstatus=="Manager"){
							$sql="SELECT * from bus LIMIT $x1,8";
						}
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$bid=$row['bid'];
								$sql1="SELECT * from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid WHERE bid='$bid' && bsstatus='going' && arstatus='ok' ";
								$result1=mysqli_num_rows(mysqli_query($conn,$sql1));
								?>
								<fieldset id="c11">
									<label><?php echo $row['bcd']." ".$row['bno']; ?></label>
									<label><?php echo "name: ".$row['bname']; ?></label>
									<label><?php echo "type: ".$row['btype']; ?></label>
									<label><?php echo "seats: ".$row['nseat']." (".$row['stype'].")"; ?></label>
									<label><?php echo "schedule: ".$result1; ?> on-route</label>
									<?php
									if(isset($_SESSION['uid'])&& ($userstatus=="Admin" || $userstatus=="Manager")){
										?>
										<legend class="predel"><?php echo $row['bstatus']; ?> </legend>
										<legend class="del">
											<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
												<input type="number" name="bid" value="<?php echo $row['bid']; ?>" hidden>
												<button name="bdel">delete</button>
											</form>
										</legend>
										<?php
									}else{
										?>
										<legend><?php echo $row['bstatus']; ?> </legend>
										<?php
									}
									?>
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
				<legend style="position: absolute; left: 5.8%; top: 15%;">list of buses</legend>
			</fieldset>
			<script>
				var pd='<?php echo $cnt1; ?>';
				var predel=document.getElementsByClassName('predel');
				var del=document.getElementsByClassName('del');
				for(let l=0;l<=pd;l++){
					if(del[l]){
						del[l].style.display='none';
					}
				}
				for(let k=0;k<=pd;k++){
					predel[k].onclick=function(){
						for(let l=0;l<=pd;l++){
							if(predel[k]==predel[l]){
								if(predel[l]){
									predel[l].style.display='none';
									del[l].style.display='flex';
								}
							}else{
								if(predel[l]){
									del[l].style.display='none';
									predel[l].style.display='flex';
								}
							}
						}
					}
				}
			</script>
			<script>
				var cx1='<?php echo $cnt1/8.1; ?>';
				var kof1=document.getElementsByClassName('off');
				var kb1=document.getElementsByClassName('bb');
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
				<a href="../bus/bus.php" id="active"><i class='fas fa-bus-alt' style='font-size:25px;'></i><label> Bus</label>
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

	<script src="../bus/bus.js"></script>
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>

</body>
</html>