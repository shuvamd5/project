<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../ticket/ticket.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title>OBTS/TICKET</title>
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
				<fieldset style="max-width: 100%; min-width: 100%; padding: 2% 0; display: flex; flex-wrap: wrap;">
					
					<?php
					$sql="SELECT * from ((bus INNER JOIN busschedule ON bus.bid=busschedule.bid)INNER JOIN addroute on busschedule.bsid=addroute.bsid) WHERE arstatus='ok' ";
					$result=mysqli_query($conn,$sql);
					$cntm=mysqli_num_rows($result);
					?>
					<div style="margin: 2% auto; max-width: 220px;">
						<section id="section">
							<input type="search" id="searchm" name="search" placeholder="Search bus number plate" autocomplete="off">
							<button id="btnm">back</button>
						</section>
						<fieldset id="c11" style=" background-color: transparent; box-shadow: none;">
							<fieldset id="c11x">
								<button class="b1">1</button>
								<?php
								for($i=1;$i<=($cntm/8.1);$i++){
									?>
									<button class="b1"><?php echo $i+1;?></button>
									<?php
								}
								?>
							</fieldset>
						</fieldset>
					</div>
					<div id="oflowm">

					</div>
					<?php
					for($j=1;$j<=(($cntm/8.1)+1);$j++){
						$x=($j-1)*8;
						?>
						<div id="overflowm" class="of1">
							<?php
							$sql="SELECT * from ((bus INNER JOIN busschedule ON bus.bid=busschedule.bid)INNER JOIN addroute on busschedule.bsid=addroute.bsid) WHERE arstatus='ok' LIMIT $x,8";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$bid=$row['bid'];
									$bsid=$row['bsid'];
									$nseat=$row['nseat'];
									$stype=$row['stype'];
									$bus=$row['bcd']." ".$row['bno'];
									$bname=$row['bname'];
									$btype=$row['btype'];
									$trdate=$row['trdate'];
									$trtime=$row['trtime'];
									$bstatus=$row['bstatus'];
									$bsstatus=$row['bsstatus'];
									$arid=$row['arid'];
									$price=$row['price'];
									$sql1="SELECT * from sales where bid='$bid' && bsid='$bsid' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$sales=$row1['sales'];
										}
									}else{
										$sales=0;
									}
									$sql2="SELECT * from route INNER JOIN addroute on route.rid=addroute.rid where arid='$arid' ";
									$result2=mysqli_query($conn,$sql2);
									if(mysqli_num_rows($result2)>0){
										while($row2=mysqli_fetch_assoc($result2)){
											$sp=$row2['sp'];
											$fp=$row2['fp'];
											$route=$sp." > ".$fp;
										}
									}
									$P=0;
									$E=$nseat;
									$R=0;
									$prev=0;
									$prevv="E";
									$now=0;
									$nowv="E";
									$sql1="SELECT * from ticket where arid='$arid' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$now=$row1['sno'];
											if($now!=$prev){
												if($row1['tstatus']=="P"){
													$P++;
													$E--;
													$nowv="P";
												}
												if($row1['tstatus']=="R"){
													$R++;
													$E--;
													$nowv="R";
												}
												$prev=$now;
												$prevv=$nowv;
											}else{
												if($row1['tstatus']!=$prevv){
													if($row1['tstatus']=="R"){
														$P--;
														$R++;
														$prevv="R";
													}
												}
											}
										}
									}
									?>
									<fieldset id="c11">
										<label><?php echo $bus." ".$bname; ?></label>
										<label><?php echo $trdate." / ".$trtime; ?></label>
										<label><?php echo $route;?></label>
										<label><?php echo $stype." seats : ".$nseat; ?></label>
										<div>
											<div style="display: flex; flex-direction: column; color: red;"><label>Reserved</label><label style="margin: 0 auto;"><?php echo $R; ?></label></div>
											<div style="display: flex; flex-direction: column; color: blue;"><label>Pending</label><label style="margin: 0 auto;"><?php echo $P; ?></label></div>
											<div style="display: flex; flex-direction: column; color: green;"><label>Empty</label><label style="margin: 0 auto;"><?php echo $E; ?></label></div>
										</div>
										<label>price : <?php echo "Rs ".$price; ?></label>
										<legend>sales : <?php echo $sales ; ?></legend>
									</fieldset>
									<?php
								}
							}else{
								?>
								<label style="color: white;">no records found</label>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
					<legend style="position: absolute; left: 5.8%; top: 15%;">ticket sales</legend>
				</fieldset>
				<script>
					var cxx='<?php echo $cntm/8.1; ?>';
					var kofx=document.getElementsByClassName('of1');
					var kbx=document.getElementsByClassName('b1');
					var oflowx=document.getElementById('oflowm');
					var srchx=document.getElementById('searchm');
					for(let l=0;l<=cxx;l++){
						if(kofx[0]!=kofx[l]){
							if(kofx[l]){
								kofx[l].style.display='none';
							}
						}
					}
					for(let k=0;k<=cxx;k++){
						kbx[k].onclick=function(){
							for(let l=0;l<=cxx;l++){
								if(kofx[k]==kofx[l]){
									if(kofx[l]){
										kofx[l].style.display='flex';
									}
								}else{
									if(kofx[l]){
										kofx[l].style.display='none';
									}
								}
							}
							oflowx.style.display='none';
							srchx.value="";
						}
					}
				</script>
				<script>
					var sx=document.getElementById('searchm');
					sx.oninput=function(){
						var yx=sx.value;
						var xx=yx.toUpperCase();
						document.getElementById('oflowm').style.display='flex';
						document.getElementById('overflowm').style.display='none';
						var cxx='<?php echo $cntm/8.1; ?>';
						var kofx=document.getElementsByClassName('of1');
						for(let l=0;l<=cxx;l++){
							if(kofx[0]!=kofx[l]){
								if(kofx[l]){
									kofx[l].style.display='none';
								}
							}
						}
						<?php
						$sqlxx="SELECT * from bus";
						$resultxx=mysqli_query($conn,$sqlxx);
						if(mysqli_num_rows($resultxx)>0){
							while($rowxx=mysqli_fetch_assoc($resultxx)){
								$bcdxx=$rowxx['bcd'];
								$bnoxx=$rowxx['bno'];
								$bndxx=$bcdxx." ".$bnoxx;
								?>
								var bndxx='<?php echo $bndxx;?>';
								var bnoxx='<?php echo $bnoxx;?>';
								if(xx==bndxx || xx==bnoxx){
									document.getElementById('oflowm').innerHTML=('<?php
										$sql="SELECT * from ((bus INNER JOIN busschedule ON bus.bid=busschedule.bid)INNER JOIN addroute on busschedule.bsid=addroute.bsid) WHERE arstatus='ok' && ((bno='$bnoxx')||(bcd='bcdxx' && bno='$bnoxx')) LIMIT $x,8";
										$result=mysqli_query($conn,$sql);
										if(mysqli_num_rows($result)>0){
											while($row=mysqli_fetch_assoc($result)){
												$bid=$row['bid'];
												$bsid=$row['bsid'];
												$nseat=$row['nseat'];
												$stype=$row['stype'];
												$bus=$row['bcd']." ".$row['bno'];
												$bname=$row['bname'];
												$btype=$row['btype'];
												$trdate=$row['trdate'];
												$trtime=$row['trtime'];
												$bstatus=$row['bstatus'];
												$bsstatus=$row['bsstatus'];
												$arid=$row['arid'];
												$price=$row['price'];
												$sql1="SELECT * from sales where bid='$bid' && bsid='$bsid' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$sales=$row1['sales'];
													}
												}else{
													$sales=0;
												}
												$sql2="SELECT * from route INNER JOIN addroute on route.rid=addroute.rid where arid='$arid' ";
												$result2=mysqli_query($conn,$sql2);
												if(mysqli_num_rows($result2)>0){
													while($row2=mysqli_fetch_assoc($result2)){
														$sp=$row2['sp'];
														$fp=$row2['fp'];
														$route=$sp." > ".$fp;
													}
												}
												$P=0;
												$E=$nseat;
												$R=0;
												$prev=0;
												$prevv="E";
												$now=0;
												$nowv="E";
												$sql1="SELECT * from ticket where arid='$arid' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$now=$row1['sno'];
														if($now!=$prev){
															if($row1['tstatus']=="P"){
																$P++;
																$E--;
																$nowv="P";
															}
															if($row1['tstatus']=="R"){
																$R++;
																$E--;
																$nowv="R";
															}
															$prev=$now;
															$prevv=$nowv;
														}else{
															if($row1['tstatus']!=$prevv){
																if($row1['tstatus']=="R"){
																	$P--;
																	$R++;
																	$prevv="R";
																}
															}
														}
													}
												}
												?>
												<fieldset id="c11"><label><?php echo $bus." ".$bname; ?></label><label><?php echo $trdate." / ".$trtime; ?></label><label><?php echo $route;?></label><label><?php echo $stype." seats : ".$nseat; ?></label><div><div style="display: flex; flex-direction: column; color: red;"><label>Reserved</label><label style="margin: 0 auto;"><?php echo $R; ?></label></div><div style="display: flex; flex-direction: column; color: blue;"><label>Pending</label><label style="margin: 0 auto;"><?php echo $P; ?></label></div><div style="display: flex; flex-direction: column; color: green;"><label>Empty</label><label style="margin: 0 auto;"><?php echo $E; ?></label></div></div><label>price : <?php echo "Rs ".$price; ?></label><legend>sales : <?php echo $sales ; ?></legend></fieldset><?php
											}
										} ?>');
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
					var cxx='<?php echo $cntm/8.1; ?>';
					var kofx=document.getElementsByClassName('of1');
					btnxx.onclick=function(){
						of1xx.style.display='none';
						ofxx.style.display='flex';
						sxx.value="";
						for(let l=0;l<=cxx;l++){
							if(kofx[0]!=kofx[l]){
								if(kofx[l]){
									kofx[l].style.display='none';
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
				<div class="container1" id="c5">
					<fieldset id="phpmethod">
						<?php
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['payedit'])){
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
								$tid=$_POST['tid'];
								$pay=$_POST['payment'];
								$sql="SELECT * from ticket where tid='$tid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$uid=$row['uid'];
										$price=$row['price'];
										$tstatus=$row['tstatus'];
									}
								}
								$sql="SELECT * from user where uid='$uid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$rtc=$row['reservedtc'];
										$ptc=$row['pendingtc'];
										$payment=$row['payment'];
										$due=$row['due'];
										$points=$row['points'];
									}
								}
								$sql="SELECT payment from ticket where tid='$tid' && payment='Clear' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){

								}else{
									$payment=$payment+$price;
									$due=$due-$price;
									$points=$points+1;
									if($tstatus!="R"){
										$rtc=$rtc+1;
										$ptc=$ptc-1;
									}
									$sql1="UPDATE user set reservedtc='$rtc',pendingtc='$ptc',payment='$payment',due='$due',points='$points' where uid='$uid' ";
									if(mysqli_query($conn,$sql1)){
										//echo "updated data";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql1="UPDATE ticket set payment='$pay',tstatus='R',pyreby='$username' where tid='$tid' ";
									if(mysqli_query($conn,$sql1)){
										//echo "updated data";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql1="SELECT * from (((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute on busschedule.bsid=addroute.bsid) INNER JOIN ticket on addroute.arid=ticket.arid) where tid='$tid' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$bid=$row1['bid'];
											$bsid=$row1['bsid'];
											$price=$row1['price'];
											$sql2="SELECT sales from sales where bid='$bid' && bsid='$bsid' ";
											$result2=mysqli_query($conn,$sql2);
											if(mysqli_num_rows($result2)>0){
												while($row2=mysqli_fetch_assoc($result2)){
													$sale=$row2['sales'];
												}
											}
										}
									}
									$sale=$sale+$price;
									$sql="UPDATE sales set sales='$sale' where bid='$bid' && bsid='$bsid' ";
									if(mysqli_query($conn,$sql)){
										?>
										<div class="msg"><p>data updated</p></div>
										<?php
									}else{

									}
								}
							}
						}
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['paycancel'])){
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
								$tid=$_POST['tid'];
								$pay=$_POST['payment'];
								$sql="SELECT * from ticket where tid='$tid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$uid=$row['uid'];
										$price=$row['price'];
										$tstatus=$row['tstatus'];
										$sid=$row['ssid'];
									}
								}
								$sql="SELECT * from seats where sid='$sid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$stat=$row['status'];
									}
								}
								$sql="SELECT * from user where uid='$uid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$rtc=$row['reservedtc'];
										$ptc=$row['pendingtc'];
										$payment=$row['payment'];
										$due=$row['due'];
										$points=$row['points'];
									}
								}
								$sql="SELECT payment from ticket where tid='$tid' && payment='due' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){

								}else{
									$payment=$payment-$price;
									$due=$due+$price;
									$points=$points-1;
									if($stat!="R"){
										$rtc=$rtc-1;
										$ptc=$ptc+1;
									}
									$sql1="UPDATE user set reservedtc='$rtc',pendingtc='$ptc',payment='$payment',due='$due',points='$points' where uid='$uid' ";
									if(mysqli_query($conn,$sql1)){
										//echo "updated data";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql1="UPDATE ticket set payment='$pay',tstatus='$stat',pyreby='$username' where tid='$tid' ";
									if(mysqli_query($conn,$sql1)){
										//echo "updated data";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql1="SELECT * from (((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute on busschedule.bsid=addroute.bsid) INNER JOIN ticket on addroute.arid=ticket.arid) where tid='$tid' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$bid=$row1['bid'];
											$bsid=$row1['bsid'];
											$price=$row1['price'];
											$sql2="SELECT sales from sales where bid='$bid' && bsid='$bsid' ";
											$result2=mysqli_query($conn,$sql2);
											if(mysqli_num_rows($result2)>0){
												while($row2=mysqli_fetch_assoc($result2)){
													$sale=$row2['sales'];
												}
											}
										}
									}
									$sale=$sale-$price;
									$sql="UPDATE sales set sales='$sale' where bid='$bid' && bsid='$bsid' ";
									if(mysqli_query($conn,$sql)){
										?>
										<div class="msg"><p>data updated</p></div>
										<?php
									}else{

									}
								}
							}
						}
						?>
					</fieldset>
				</div>
				<fieldset id="ticketpayment">
					<fieldset id="busticketlist">
						<div id="overflow">
							<?php
							$d=date("Y-m-d");
							$sql="SELECT * from ((bus INNER JOIN busschedule ON bus.bid=busschedule.bid) INNER JOIN addroute on busschedule.bsid=addroute.bsid) where trdate>='$d' && arstatus='ok' ORDER BY trdate ASC ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									?>
									<fieldset>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="arid" value="<?php echo $row['arid']; ?>" hidden>
											<button name="tpedit"><?php echo $row['trdate']." ".$row['bcd']." ".$row['bno'] ?></button>
										</form>
									</fieldset>
									<?php
								}
							}else{
								?>
								<label style="color: white;">no ticket has been booked yet</label>
								<?php
							}
							?>
						</div>
						<legend>ticket payment</legend>
					</fieldset>
					<fieldset id="buslist">
						<?php
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['tpedit'])){
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
								$arid=$_POST['arid'];
								$sql="SELECT * from ticket where arid='$arid' ";
								$result=mysqli_query($conn,$sql);
								?>
								<div id="overflow">
									<?php
									if(mysqli_num_rows($result)>0){
										while($row=mysqli_fetch_assoc($result)){
											$tstatus=$row['tstatus'];
											if($tstatus=="R"){
												$tstatus="Reserved";
											}
											if($tstatus=="P"){
												$tstatus="Pending";
											}
											?>
											<fieldset id="c12">
												<label><?php echo $row['treby']; ?></label>
												<label><?php echo $row['blc'].$row['sna']; ?></label>
												<label><?php echo $tstatus; ?></label>
												<label><?php echo $row['price']; ?></label>
												<label><?php echo $row['payment']; ?></label>
												<?php
												if($row['payment']=="due"){
													?>
													<label>
														<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
															<input type="number" name="tid" value="<?php echo $row['tid']; ?>" hidden>
															<input type="text" name="payment" value="Clear" hidden>
															<button name="payedit">Clear</button>
														</form>
													</label>
													<?php
												}
												if($row['payment']=="Clear"){
													?>
													<label>
														<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
															<input type="number" name="tid" value="<?php echo $row['tid']; ?>" hidden>
															<input type="text" name="payment" value="due" hidden>
															<button name="paycancel">cancel</button>
														</form>
													</label>
													<?php
												}
												?>

											</fieldset>
											<?php
										}
									}else{
										?>
										<label style="width: 100%; color: white;">no ticket booked yet</label>
										<?php
									}
									?>
								</div>
								<?php
							}
						}
						?>
						<legend>userlist</legend>
					</fieldset>
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
				}else if(isset($_SESSION['uid'])){
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
				<div class="container1" id="c5">
					<fieldset id="phpmethod">
						<?php
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['tedit'])){
								?>
								<script>
									var c1=document.getElementById('c1');
									var c2=document.getElementById('c2');
									var c3=document.getElementById('c3');
									var ls=document.getElementById('ls');
									var rs=document.getElementById('rs');
									var ls1=document.getElementById('ls1');
									var rs1=document.getElementById('rs1');
									var ls2=document.getElementById('ls2');
									var rs2=document.getElementById('rs2');
									c1.style.display='none';
									c2.style.display='none';
									c3.style.display='flex';
									ls.style.display='none';
									rs.style.display='none';
									ls1.style.display='none';
									rs1.style.display='none';
									ls2.style.display='flex';
									rs2.style.display='flex';
								</script>
								<?php
								$tid=check_data($_POST['tid']);
								$ssid=check_data($_POST['ssid']);
								$tstatus=check_data($_POST['tstatus']);
								$ctstatus=$_POST['ctstatus'];
								$price=check_data($_POST['price']);
								$sql="SELECT * from user where uid='$userid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$ttc=$row['totaltc'];
										$rtc=$row['reservedtc'];
										$ptc=$row['pendingtc'];
										$payment=$row['payment'];
										$due=$row['due'];
										$points=$row['points'];
									}
								}
								if($tstatus=="E"){
									$ttc=$ttc-1;
									if($ctstatus=="R"){
										$rtc=$rtc-1;
									}
									if($ctstatus=="P"){
										$ptc=$ptc-1;
									}
									$due=$due-$price;
									$points=$points-1;
									$sql="UPDATE user set totaltc='$ttc',reservedtc='$rtc',pendingtc='$ptc',due='$due',points='$points' where uid='$userid' ";
									if(mysqli_query($conn,$sql)){
										//echo "updated data";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql="DELETE from seats where sid='$ssid' ";
									if(mysqli_query($conn,$sql)){
										echo "data updated";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql="SELECT * from seats";
									$result=mysqli_query($conn,$sql);
									$j=1;
									if(mysqli_num_rows($result)>0){
										while($row=mysqli_fetch_assoc($result)){
											$sid=$row['sid'];
											if($sid>$j){
												$sql1="UPDATE ticket set ssid='$j' where ssid='$sid' ";
												if(mysqli_query($conn,$sql1)){
													//echo "schedule";
												}else{
													echo "error updating.. ".mysqli_error($conn);
												}
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
									$sql="DELETE from ticket where tid='$tid' ";
									if(mysqli_query($conn,$sql)){
										//echo "updated";
									}else{
										echo "error updating.. ".mysqli_error($conn);
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
								}else{
									if($ctstatus==$tstatus){

									}else{
										if($tstatus=="R"){
											$rtc=$rtc+1;
											$ptc=$ptc-1;
										}else if($tstatus=="P"){
											$ptc=$ptc+1;
											$rtc=$rtc-1;
										}
										$sql="UPDATE user set reservedtc='$rtc',pendingtc='$ptc' where uid='$userid' ";
										if(mysqli_query($conn,$sql)){
											//echo "updated data";
										}else{
											echo "error updating.. ".mysqli_error($conn);
										}
										$sql="UPDATE ticket set tstatus='$tstatus' where tid='$tid' ";
										if(mysqli_query($conn,$sql)){
											//echo "updated data";
										}else{
											echo "error updating.. ".mysqli_error($conn);
										}
										$sql="UPDATE seats set status='$tstatus' where sid='$ssid' ";
										if(mysqli_query($conn,$sql)){
											echo "data updated";
										}else{
											echo "error updating.. ".mysqli_error($conn);
										}
									}
								}
							}
						}
						?>
					</fieldset>
				</div>
				<fieldset id="buttons" style="position: absolute; top: 15%; left: 30%; right: 30%;">
					<button id="p">pending</button>
					<button id="r">reserved</button>
					<button id="q">paid</button>
				</fieldset>
				<fieldset id="pending">
					<div id="overflow">
						<?php
						$sql="SELECT * from ((((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute on busschedule.bsid=addroute.bsid) INNER JOIN ticket on addroute.arid=ticket.arid) INNER JOIN route on addroute.rid=route.rid) where uid='$userid' && tstatus='P' && payment!='Clear' ";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$tid=$row['tid'];
								$ssid=$row['ssid'];
								$bcd=$row['bcd'];
								$bno=$row['bno'];
								$bname=$row['bname'];
								$trdate=$row['trdate'];
								$trtime=$row['trtime'];
								$price=$row['price'];
								$sp=$row['sp'];
								$fp=$row['fp'];
								$blc=$row['blc'];
								$sna=$row['sna'];
								$ctstatus=$row['tstatus'];
								$sql1="SELECT * from seats WHERE sid='$ssid' ";
								$result1=mysqli_query($conn,$sql1);
								if(mysqli_num_rows($result1)>0){
									while($row1=mysqli_fetch_assoc($result1)){
										$sp=$row1['sp'];
										$fp=$row1['fp'];
									}
								}
								?>
								<fieldset id="c11">
									<label><?php echo $username; ?></label>
									<label><?php echo $bcd." ".$bno." ".$bname; ?></label>
									<label><?php echo $sp." > ".$fp; ?></label>
									<div>
										<label>seat : <?php echo $blc." ".$sna;  ?></label>
										<label>price : rs <?php echo $row['price']  ; ?></label>
									</div>
									<label>date : <?php echo $row['trdate']." / ".$row['trtime']; ?></label>
									<label>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="tid" value="<?php echo $row['tid']; ?>" hidden>
											<input type="number" name="ssid" value="<?php echo $row['ssid']; ?>" hidden>
											<input type="text" name="ctstatus" value="<?php echo $ctstatus; ?>" hidden>
											<input type="number" name="price" value="<?php echo $row['price']; ?>" hidden>
											<select name="tstatus">
												<option value="E">Cancel</option>
												<option value="P">On hold</option>
												<option value="R">Reserve</option>
											</select>
											<button name="tedit">Edit</button>
										</form>
									</label>
									<legend>On-hold</legend>
								</fieldset>
								<?php
							}
						}else{
							?>
							<label style="color: white;">no tickets on hold</label>
							<?php
						}
						?>
					</div>
					<legend>pending</legend>
				</fieldset>
				<fieldset id="reserved">
					<div id="overflow">
						<?php
						$sql="SELECT * from ((((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute on busschedule.bsid=addroute.bsid) INNER JOIN ticket on addroute.arid=ticket.arid) INNER JOIN route on addroute.rid=route.rid) where uid='$userid' && tstatus='R' && payment!='Clear' ";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$tid=$row['tid'];
								$ssid=$row['ssid'];
								$bcd=$row['bcd'];
								$bno=$row['bno'];
								$bname=$row['bname'];
								$trdate=$row['trdate'];
								$trtime=$row['trtime'];
								$price=$row['price'];
								$sp=$row['sp'];
								$fp=$row['fp'];
								$blc=$row['blc'];
								$sna=$row['sna'];
								$ctstatus=$row['tstatus'];
								$sql1="SELECT * from seats WHERE sid='$ssid' ";
								$result1=mysqli_query($conn,$sql1);
								if(mysqli_num_rows($result1)>0){
									while($row1=mysqli_fetch_assoc($result1)){
										$sp=$row1['sp'];
										$fp=$row1['fp'];
									}
								}
								?>
								<fieldset id="c11">
									<label><?php echo $username; ?></label>
									<label><?php echo $bcd." ".$bno." ".$bname; ?></label>
									<label><?php echo $sp." > ".$fp; ?></label>
									<div>
										<label>seat : <?php echo $blc." ".$sna;  ?></label>
										<label>price : rs <?php echo $row['price']  ; ?></label>
									</div>
									<label>date : <?php echo $row['trdate']." / ".$row['trtime']; ?></label>
									<label>
										<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
											<input type="number" name="tid" value="<?php echo $row['tid']; ?>" hidden>
											<input type="number" name="ssid" value="<?php echo $row['ssid']; ?>" hidden>
											<input type="text" name="ctstatus" value="<?php echo $ctstatus; ?>" hidden>
											<input type="number" name="price" value="<?php echo $row['price']; ?>" hidden>
											<select name="tstatus">
												<option value="E">Cancel</option>
												<option value="P">On hold</option>
												<option value="R">Reserve</option>
											</select>
											<button name="tedit">edit</button>
										</form>
									</label>
									<legend>Reserved</legend>
								</fieldset>
								<?php
							}
						}else{
							?>
							<label style="color: white;">no ticket on reserved</label>
							<?php
						}
						?>
					</div>
					<legend>reserved</legend>
				</fieldset>
				<fieldset id="paid">
					<div id="overflow">
						<?php
						$sql="SELECT * from ((((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute on busschedule.bsid=addroute.bsid) INNER JOIN ticket on addroute.arid=ticket.arid) INNER JOIN route on addroute.rid=route.rid) where uid='$userid' && tstatus='R' && payment='Clear' ";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$tid=$row['tid'];
								$ssid=$row['ssid'];
								$bcd=$row['bcd'];
								$bno=$row['bno'];
								$bname=$row['bname'];
								$trdate=$row['trdate'];
								$trtime=$row['trtime'];
								$price=$row['price'];
								$sp=$row['sp'];
								$fp=$row['fp'];
								$blc=$row['blc'];
								$sna=$row['sna'];
								$tstatus=$row['tstatus'];
								$payment=$row['payment'];
								$sql1="SELECT * from seats WHERE sid='$ssid' ";
								$result1=mysqli_query($conn,$sql1);
								if(mysqli_num_rows($result1)>0){
									while($row1=mysqli_fetch_assoc($result1)){
										$sp=$row1['sp'];
										$fp=$row1['fp'];
									}
								}
								?>
								<fieldset id="c11">
									<label><?php echo $username; ?></label>
									<label><?php echo $bcd." ".$bno." ".$bname; ?></label>
									<label><?php echo $sp." > ".$fp; ?></label>
									<div>
										<label>seat : <?php echo $blc." ".$sna;  ?></label>
										<label>price : rs <?php echo $row['price']  ; ?></label>
									</div>
									<label>date : <?php echo $row['trdate']." / ".$row['trtime']; ?></label>
									<legend><?php echo $payment; ?></legend>
								</fieldset>
								<?php
							}
						}else{
							?>
							<label style="color: white;">no paid ticket</label>
							<?php
						}
						?>
					</div>
					<legend>paid</legend>
				</fieldset>
				<?php
			}else{
				?>
				<div style="display: flex; height: 40vh; align-items: center;">
					<label style="font-weight: 900; color: white; text-align: center; font-size: 1.5em; margin: 0 auto;">session out !!! please login in to continue...</label>
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
				<a href="../ticket/ticket.php" id="active"><i class='fas fa-ticket-alt' style='font-size:25px;'></i><label>ticket</label>
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

	<script src="../ticket/ticket.js"></script>

</body>
</html>