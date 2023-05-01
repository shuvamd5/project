		<?php 
		session_start(); 
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" type="text/css" href="../home/home.css">
			<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
			<title>OBTS/HOME</title>
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

			$sp=$fp=$trdate="";
			$location = array("Kathmandu","Lalitpur","Bhaktapur","Pokhara","Biratnagar","Dharan","Birgunj","Butwal","Hetauda","Janakpur","Dhangadhi","Bhairahawa","Mahendranagar","Nepalgunj","Ilam","Kirtipur","Tansen","Damauli","Gulariya","Tikapur","Damak","Birtamod","Mechinagar","Dipayal","Dadeldhura","Gaur","Darchula","Baglung","Rupandehi","Gorkha","Arghakhanchi","Dhankuta","Dolakha","Bhojpur","Gulmi","Tulsipur","Khandbari","Kohalpur","Bara","Sindhuli","Ramechhap","Syangja","Lamjung","Tanahun","Dolpa","Parbat","Pyuthan","Rolpa","Salyan","Sankhuwasabha","Udayapur","Okhaldhunga","Saptari","Sarlahi","Siraha","Khotang","Kalikot","lamhai");
			
			sort($location);
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
				<div class="container1" id="c1">
					<div class="container11" id="c11">
						<div class="container111" id="c111">
							<fieldset id="c111extra">
								<div>
									<h1 class="text">welcome</h1>
									<h1 class="textname">
										<?php 
										if(isset($_SESSION['uid'])){
											echo $username;
										}
										?>
									</h1>
								</div>
								
								<!--<h2>Obts is a web based ticketing system, designed with the thought to make ticketing easier and faster. you can book and manage your ticket using this system.</h2>-->
								<button id="explore" style="margin: 5% 0 0 0;">Explore</button>
							</fieldset>
						</div>
						<div class="container112" id="c112">
							<fieldset id="book">
								<form id="bookform" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
									<fieldset>
										<select name="sp" autofocus required>
											<option readonly>--SELECT STARTING LOCATION--</option>
											<?php 
											foreach($location as $i){ 
												?>
												<option value="<?php echo $i ?>"><?php echo $i ?></option>
												<?php 
											} 
											?>
										</select>
										<legend>Leaving from</legend>
									</fieldset>
									<fieldset>
										<select name="fp" required>
											<option readonly>--SELECT FINAL LOCATION--</option>
											<?php 
											foreach($location as $i){
												?>
												<option value="<?php echo $i ?>"><?php echo $i ?></option>
												<?php
											} 
											?>
										</select>
										<legend>Going to</legend>
									</fieldset>
									<fieldset id="datetime">
										<fieldset id="date">
											<input type="date" name="trdate" min="<?php echo date("Y-m-d");?>" autocomplete="off" required>
											<legend>date</legend>
										</fieldset>
										<fieldset id="time">
											<input type="time" name="trtime" autocomplete="off">
											<legend>time</legend>
										</fieldset>
									</fieldset>
									<fieldset id="booksubmit">
										<?php
										if(isset($_SESSION['uid'])){ 
											?>
											<button id="submit" name="book">book</button>
											<?php
										}else{
											?>
											<button id="submit" name="book">view</button>
											<?php
										}
										?>
									</fieldset>
								</form>
								<legend style="font-size: 1.5em;">Book</legend>
							</fieldset>
						</div>
					</div>
					<div class="container12" id="c12" style="background-color: white;">
						<?php
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['book'])){
								$sp=check_data($_POST['sp']);
								$fp=check_data($_POST['fp']);
								$trdate=$_POST['trdate'];
								if(isset($_POST['trtime'])){
									$trtime=$_POST['trtime'];
								}
								$trtime="00:00:00";
								$count=$count1=0;
								$lcount=count($location);
								for($i=0;$i<$lcount;$i++){
									if($sp!=$location[$i]){
										$count++;
									}
									if($fp!=$location[$i]){
										$count1++;
									}
								}
								if($count==$lcount){
									?>
									<div class="msg">
										<p>Error in starting point selection</p>
										<a href="../home/home.php">back to main</a>
									</div>
									<?php
								}else if($count1==$lcount){
									?>
									<div class="msg">
										<p>Error in final point selection</p>
										<a href="../home/home.php">back to main</a>
									</div>
									<?php
								}else{
									checkroute($sp,$fp,$trdate,$trtime,$conn);
								}
							}
							if(isset($_POST['byprice'])){
								$a=$_POST['sp'];
								$b=$_POST['fp'];
								$trd=date_create($_POST['trd']);
								$trd=date_format($trd,"Y-m-d");
								$trt=$_POST['trt'];
								$arprice=array();
								$rid=0;
								$sql="SELECT * from route where sp='$a' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$xrid=$row['rid'];
										$sql1="SELECT * from route where rid='$xrid' && fp='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql1="SELECT * from checkpoint where rid='$xrid' && route='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql2="SELECT * from (busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid) where rid='$rid' && arstatus='ok' && bsstatus!='Expired' ";
										$result2=mysqli_query($conn,$sql2);
										if(mysqli_num_rows($result2)>0){
											while($row2=mysqli_fetch_assoc($result2)){
												$dte=date_create($row2['trdate']);
												$dte=date_format($dte,"Y-m-d");
												$dti=date_create($row2['trtime']);
												$dti=date_format($dti,"H");
												if($trd==$dte && $dti>=$trt){
													$arprice[$row2['arid']]=$row2['price'];
												}
											}
										}
									}
								}
								$sql="SELECT * from checkpoint where route='$a' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$xrid=$row['rid'];
										$xcpid=$row['cpid'];
										$sql1="SELECT * from route where rid='$xrid' && fp='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql1="SELECT * from checkpoint where rid='$xrid' && route='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql2="SELECT * from (busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid) where rid='$rid' && arstatus='ok' && bsstatus!='Expired' ";
										$result2=mysqli_query($conn,$sql2);
										if(mysqli_num_rows($result2)>0){
											while($row2=mysqli_fetch_assoc($result2)){
												$dte=date_create($row2['trdate']);
												$dte=date_format($dte,"Y-m-d");
												$dti=date_create($row2['trtime']);
												$dti=date_format($dti,"H");
												if($trd==$dte && $dti>=$trt){
													$arprice[$row2['arid']]=$row2['price'];
												}
											}
										}
									}
								}
								asort($arprice);
								show($a,$b,$trd,$trt,$arprice,$conn);
							}
							if(isset($_POST['bytime'])){
								$a=$_POST['sp'];
								$b=$_POST['fp'];
								$trd=date_create($_POST['trd']);
								$trd=date_format($trd,"Y-m-d");
								$trt=$_POST['trt'];
								$artime=array();
								$rid=0;
								$sql="SELECT * from route where sp='$a' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$xrid=$row['rid'];
										$sql1="SELECT * from route where rid='$xrid' && fp='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql1="SELECT * from checkpoint where rid='$xrid' && route='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql2="SELECT * from (busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid) where rid='$rid' && arstatus='ok' && bsstatus!='Expired' ";
										$result2=mysqli_query($conn,$sql2);
										if(mysqli_num_rows($result2)>0){
											while($row2=mysqli_fetch_assoc($result2)){
												$dte=date_create($row2['trdate']);
												$dte=date_format($dte,"Y-m-d");
												$dti=date_create($row2['trtime']);
												$dti=date_format($dti,"H");
												if($trd==$dte && $dti>=$trt){
													$artime[$row2['arid']]=$row2['trtime'];
												}
											}
										}
									}
								}
								$sql="SELECT * from checkpoint where route='$a' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$xrid=$row['rid'];
										$xcpid=$row['cpid'];
										$sql1="SELECT * from route where rid='$xrid' && fp='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql1="SELECT * from checkpoint where rid='$xrid' && route='$b' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$rid=$row1['rid'];
											}
										}
										$sql2="SELECT * from (busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid) where rid='$rid' && arstatus='ok' && bsstatus!='Expired' ";
										$result2=mysqli_query($conn,$sql2);
										if(mysqli_num_rows($result2)>0){
											while($row2=mysqli_fetch_assoc($result2)){
												$dte=date_create($row2['trdate']);
												$dte=date_format($dte,"Y-m-d");
												$dti=date_create($row2['trtime']);
												$dti=date_format($dti,"H");
												if($trd==$dte && $dti>=$trt){
													$artime[$row2['arid']]=$row2['trtime'];
												}
											}
										}
									}
								}
								asort($artime);
								show($a,$b,$trd,$trt,$artime,$conn);
							}
							if(isset($_POST['reserve'])){
								?>
								<script>
									var c11=document.getElementById('c11');
									var c12=document.getElementById('c12');
									c12.style.display='flex';
									c11.style.display='none';
								</script>
								<?php
								$bid=$_POST['bid'];
								$bsid=$_POST['bsid'];
								$sno=$_POST['sno'];
								$sna=$_POST['sna'];
								$blc=$_POST['blc'];
								$sp=$_POST['sp'];
								$fp=$_POST['fp'];
								$sql="SELECT arid,rid from addroute where bsid='$bsid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$arid=$row['arid'];
										$rid=$row['rid'];
									}
								}
								$sql="SELECT price from addroute INNER JOIN route on addroute.rid=route.rid where sp='$sp' && fp='$fp' && bsid='$bsid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$price=$row['price'];
										$spcpid=0;
										$fpcpid=100;
									}
								}
								$sql="SELECT * from route where rid='$rid' && sp='$sp' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									$sql1="SELECT * from checkpoint where rid='$rid' && route='$fp' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row=mysqli_fetch_assoc($result1)){
											$price=$row['price'];
											$spcpid=0;
											$fpcpid=$row['cpid'];
										}
									}
								}
								$sql="SELECT * from checkpoint where rid='$rid' && route='$sp' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$spcpid=$row['cpid'];
										$spprice=$row['price'];
										$sql1="SELECT * from checkpoint where rid='$rid' && route='$fp' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$fpcpid=$row1['cpid'];
												$fpprice=$row1['price'];
												if($spcpid<=$fpcpid){
													$price=$fpprice-$spprice;
												}
											}
										}
										$sql1="SELECT * from addroute INNER JOIN route on addroute.rid=route.rid where arid='$arid' && fp='$fp' ";
										$result1=mysqli_query($conn,$sql1);
										if(mysqli_num_rows($result1)>0){
											while($row1=mysqli_fetch_assoc($result1)){
												$fpcpid=100;
												$fpprice=$row1['price'];
												$price=$fpprice-$spprice;
											}
										}
									}
								}
								ticket($blc,$sna,$arid,$sno,$sp,$fp,$spcpid,$fpcpid,$price,$username,$conn);
							}
							if(isset($_POST['ticketpending'])){
								?>
								<script>
									var c11=document.getElementById('c11');
									var c12=document.getElementById('c12');
									c12.style.display='flex';
									c11.style.display='none';
								</script>
								<?php
								$arid=$_POST['arid'];
								$sna=$_POST['sna'];
								$blc=$_POST['blc'];
								$sno=$_POST['sno'];
								$sp=$_POST['sp'];
								$fp=$_POST['fp'];
								$spcpid=$_POST['spcpid'];
								$fpcpid=$_POST['fpcpid'];
								$price=$_POST['price'];
								$sql="SELECT * from user where uid='$userid'";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$ttc=$row['totaltc'];
										$rtc=$row['reservedtc'];
										$ptc=$row['pendingtc'];
										$due=$row['due'];
										$points=$row['points'];
									}
								}
								$sql="SELECT trdate,trtime from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid where arid='$arid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$trdate=$row['trdate'];
										$trtime=$row['trtime'];
									}
								}
								$sql="SELECT * from seats where arid='$arid' && sno='$sno' && sp='$sp' && fp='$fp' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$ssid=$row['sid'];
										$sno=$row['sno'];
										$status=$row['status'];
										if($status=='R'){
											?>
											<p>the selected seat has been reserved</p>
											<?php
											ticketdisplay($arid,$ssid,$username,$conn);
										}else if($status=='P'){
											?>
											<p>the selected seat is on-hold</p>
											<?php
											ticketdisplay($arid,$ssid,$username,$conn);
										}
									}
								}else{
									$sql="INSERT into seats(arid,sno,sp,spcpid,fp,fpcpid,price,uid,status,trdate,trtime) VALUES('$arid','$sno','$sp','$spcpid','$fp','$fpcpid','$price','$userid','P','$trdate','$trtime')";
									if($conn->query($sql)===TRUE){
										//echo "stored";
									}else{
										echo "error<br/>".$sql.$conn->error;
									}
									$ttc=$ttc+1;
									$ptc=$ptc+1;
									$due=$due+$price;
									$points=$points+1;
									$sql="SELECT * from seats where arid='$arid' && sno='$sno' ";
									$result=mysqli_query($conn,$sql);
									if(mysqli_num_rows($result)>0){
										while($row=mysqli_fetch_assoc($result)){
											$ssid=$row['sid'];
										}
									}
									$sql="UPDATE user set totaltc='$ttc',pendingtc='$ptc',due='$due',points='$points' where uid='$userid' ";
									if(mysqli_query($conn,$sql)){
									}else{
										?>
										<div class="msg">
											<p><?php echo "error updating ".mysqli_error($conn);?></p>
											<a href="../home/home.php">back to main</a>
										</div>
										<?php
									}
									$sql="INSERT INTO ticket(arid,ssid,trdate,trtime,sno,blc,sna,price,uid,treby,tstatus,payment,pyreby) VALUES('$arid','$ssid','$trdate','$trtime','$sno','$blc','$sna','$price','$userid','$username','P','due','none')";
									if($conn->query($sql)===TRUE){
										?>
										<p>registration complete</p>
										<p>Ticket :</p>
										<?php
										ticketdisplay($arid,$ssid,$username,$conn);
									}else{
										?>
										<div class="msg">
											<p><?php echo "registration error ".$sql.$conn->error;?></p>
											<a href="../home/home.php">back to main</a>
										</div>
										<?php
									}
								}
							}
							if(isset($_POST['confirmticket'])){
								?>
								<script>
									var c11=document.getElementById('c11');
									var c12=document.getElementById('c12');
									c12.style.display='flex';
									c11.style.display='none';
								</script>
								<?php
								$arid=$_POST['arid'];
								$sna=$_POST['sna'];
								$blc=$_POST['blc'];
								$sno=$_POST['sno'];
								$sp=$_POST['sp'];
								$fp=$_POST['fp'];
								$spcpid=$_POST['spcpid'];
								$fpcpid=$_POST['fpcpid'];
								$price=$_POST['price'];
								$sql="SELECT * from user where uid='$userid'";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$ttc=$row['totaltc'];
										$rtc=$row['reservedtc'];
										$ptc=$row['pendingtc'];
										$due=$row['due'];
										$points=$row['points'];
									}
								}
								$sql="SELECT trdate,trtime from busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid where arid='$arid' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$trdate=$row['trdate'];
										$trtime=$row['trtime'];
									}
								}
								$sql="SELECT * from seats where arid='$arid' && sno='$sno' && sp='$sp' && fp='$fp' ";
								$result=mysqli_query($conn,$sql);
								if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_assoc($result)){
										$ssid=$row['sid'];
										$sno=$row['sno'];
										$status=$row['status'];
										if($status=='R'){
											?>
											<p>the selected seat has been reserved</p>
											<?php
											ticketdisplay($arid,$ssid,$username,$conn);
										}else if($status=='P'){
											?>
											<p>the selected seat is kept on-hold</p>
											<?php
											ticketdisplay($arid,$ssid,$username,$conn);
										}
									}
								}else{
									$sql="INSERT into seats(arid,sno,sp,spcpid,fp,fpcpid,price,uid,status,trdate,trtime) VALUES('$arid','$sno','$sp','$spcpid','$fp','$fpcpid','$price','$userid','R','$trdate','$trtime')";
									if($conn->query($sql)===TRUE){
										//echo "stored";
									}else{
										echo "error<br/>".$sql.$conn->error;
									}
									$ttc=$ttc+1;
									$rtc=$rtc+1;
									$due=$due+$price;
									$points=$points+1;
									$sql="SELECT * from seats where arid='$arid' && sno='$sno' ";
									$result=mysqli_query($conn,$sql);
									if(mysqli_num_rows($result)>0){
										while($row=mysqli_fetch_assoc($result)){
											$ssid=$row['sid'];
										}
									}
									$sql="UPDATE user set totaltc='$ttc',reservedtc='$rtc',due='$due',points='$points' where uid='$userid' ";
									if(mysqli_query($conn,$sql)){
									}else{
										?>
										<div class="msg">
											<p><?php echo "error updating ".mysqli_error($conn);?></p>
											<a href="../home/home.php">back to main</a>
										</div>
										<?php
									}
									$sql="INSERT INTO ticket(arid,ssid,trdate,trtime,sno,blc,sna,price,uid,treby,tstatus,payment,pyreby) VALUES('$arid','$ssid','$trdate','$trtime','$sno','$blc','$sna','$price','$userid','$username','R','due','none')";
									if($conn->query($sql)===TRUE){
										?>
										<p>registration complete</p>
										<p>Ticket :</p>
										<?php
										ticketdisplay($arid,$ssid,$username,$conn);
									}else{
										?>
										<div class="msg">
											<p><?php echo "error updating<br/>".mysqli_error($conn);?></p>
											<a href="../home/home.php">back to main</a>
										</div>
										<?php
									}
								}
							}
						}
						function checkroute($a,$b,$trd,$trt,$conn){
							?>
							<script>
								var c11=document.getElementById('c11');
								var c12=document.getElementById('c12');
								c12.style.display='flex';
								c11.style.display='none';
							</script>
							<?php
							if(!isset($_SESSION['uid'])){
								?><p style="color: red;">Login first to see more details&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="../access/access.php">Login</a></p><?php
								?>
								<?php
							}
							$are=array();
							$rid=0;
							$sql="SELECT * from route where sp='$a' ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$xrid=$row['rid'];
									$sql1="SELECT * from route where rid='$xrid' && fp='$b' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$rid=$row1['rid'];
										}
									}
									$sql1="SELECT * from checkpoint where rid='$xrid' && route='$b' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$rid=$row1['rid'];
										}
									}
									$sql2="SELECT * from (busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid) where rid='$rid' && arstatus='ok' && bsstatus!='Expired' ";
									$result2=mysqli_query($conn,$sql2);
									if(mysqli_num_rows($result2)>0){
										while($row2=mysqli_fetch_assoc($result2)){
											$dte=date_create($row2['trdate']);
											$dte=date_format($dte,"Y-m-d");
											$dti=date_create($row2['trtime']);
											$dti=date_format($dti,"H");
											if($trd==$dte && $dti>=$trt){
												$are[$row2['arid']]=$row2['arid'];
											}
										}
									}else{
										$are[0]=0;
									}
								}
							}
							$sql="SELECT * from checkpoint where route='$a' ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$xrid=$row['rid'];
									$xcpid=$row['cpid'];
									$sql1="SELECT * from route where rid='$xrid' && fp='$b' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$rid=$row1['rid'];
										}
									}
									$sql1="SELECT * from checkpoint where rid='$xrid' && route='$b' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$rid=$row1['rid'];
										}
									}
									$sql2="SELECT * from (busschedule INNER JOIN addroute on busschedule.bsid=addroute.bsid) where rid='$rid' && arstatus='ok' && bsstatus!='Expired' ";
									$result2=mysqli_query($conn,$sql2);
									if(mysqli_num_rows($result2)>0){
										while($row2=mysqli_fetch_assoc($result2)){
											$dte=date_create($row2['trdate']);
											$dte=date_format($dte,"Y-m-d");
											$dti=date_create($row2['trtime']);
											$dti=date_format($dti,"H");
											if($trd==$dte && $dti>=$trt){
												$are[$row2['arid']]=$row2['arid'];
											}
										}
									}else{
										$are[0]=0;
									}
								}
							}
							asort($are);
							show($a,$b,$trd,$trt,$are,$conn);
						}
						function show($sp,$fp,$trd,$trt,$arr,$conn){
							?>
							<script>
								var c11=document.getElementById('c11');
								var c12=document.getElementById('c12');
								c12.style.display='flex';
								c11.style.display='none';
							</script>
							<div class="td">
								<div><label>From: </label><?php echo $sp ?></div>
								<div><label>To: </label><?php echo $fp ?></div>
								<div><label>Date: </label><?php echo $trd ?></div>
								<div style="margin: 0 0 0 15%;"><a href="../home/home.php">back</a></div>
							</div>
							<div class="orderby">
								<div><label>Order by: </label></div>
								<div class="byprice">
									<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
										<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
										<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
										<input type="text" name="trd" value="<?php echo $trd;?> " hidden>
										<input type="text" name="trt" value="<?php echo $trt;?> " hidden>
										<button id="byprice" name="byprice">price</button>
									</form>
								</div>
								<div class="bytime">
									<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
										<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
										<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
										<input type="text" name="trd" value="<?php echo $trd;?> " hidden>
										<input type="text" name="trt" value="<?php echo $trt;?> " hidden>
										<button name="bytime">Time</button>
									</form>
								</div>
								<div style="display: flex; align-items: center; margin: 0 0 0 10%;"	>
									<div style="width: 20px; height: 3vh; background-color: white; border-radius: 5px; color: white; cursor: pointer; border: 1px solid black;">r</div>&nbspEmpty&nbsp&nbsp
									<div style="width: 20px; height: 3vh; background-color: red; border-radius: 5px; color: red; cursor: pointer; border: 1px solid black;">r</div>&nbspreserved&nbsp&nbsp
									<div style="width: 20px; height: 3vh; background-color: yellow; border-radius: 5px; color: yellow; cursor: pointer; border: 1px solid black;">p</div>&nbsppending
								</div>
							</div>
							<div class="overflow">
								<?php
								foreach($arr as $x => $y) {
									$sql="SELECT * from ((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute ON busschedule.bsid=addroute.bsid) where arid='$x'	 ";
									$result=mysqli_query($conn,$sql);
									if(mysqli_num_rows($result)>0){
										while($row=mysqli_fetch_assoc($result)){
											$bid=$row['bid'];
											$bsid=$row['bsid'];
											$nseat=$row['nseat'];
											$sql2="SELECT arid,rid from addroute	where bsid='$bsid' ";
											$result2=mysqli_query($conn,$sql2);
											if(mysqli_num_rows($result2)>0){
												while($row2=mysqli_fetch_assoc($result2)){
													$arid=$row2['arid'];
													$rid=$row2['rid'];
												}
											}
											$sql2="SELECT * from route where rid='$rid' ";
											$result2=mysqli_query($conn,$sql2);
											if(mysqli_num_rows($result2)>0){
												while($row2=mysqli_fetch_assoc($result2)){
													$loc=$row2['sp']." > ".$row2['fp'];
												}
											}
											$sql2="SELECT price from addroute INNER JOIN route on addroute.rid=route.rid where sp='$sp' && fp='$fp' && bsid='$bsid' ";
											$result2=mysqli_query($conn,$sql2);
											if(mysqli_num_rows($result2)>0){
												while($row2=mysqli_fetch_assoc($result2)){
													$price=$row2['price'];
												}
											}
											$sql2="SELECT * from route where rid='$rid' && sp='$sp' ";
											$result2=mysqli_query($conn,$sql2);
											if(mysqli_num_rows($result2)>0){
												$sql1="SELECT * from checkpoint where rid='$rid' && route='$fp' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row2=mysqli_fetch_assoc($result1)){
														$price=$row2['price'];
													}
												}
											}
											$sql2="SELECT * from checkpoint where rid='$rid' && route='$sp' ";
											$result2=mysqli_query($conn,$sql2);
											if(mysqli_num_rows($result2)>0){
												while($row2=mysqli_fetch_assoc($result2)){
													$spcpid=$row2['cpid'];
													$spprice=$row2['price'];
													$sql1="SELECT * from checkpoint where rid='$rid' && route='$fp' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															$fpcpid=$row1['cpid'];
															$fpprice=$row1['price'];
															if($spcpid<=$fpcpid){
																$price=$fpprice-$spprice;
															}
														}
													}
													$sql1="SELECT * from addroute INNER JOIN route on addroute.rid=route.rid where arid='$arid' && fp='$fp' ";
													$result1=mysqli_query($conn,$sql1);
													if(mysqli_num_rows($result1)>0){
														while($row1=mysqli_fetch_assoc($result1)){
															$fpprice=$row1['price'];
															$price=$fpprice-$spprice;
														}
													}
												}
											}
											$a=$sp;
											$b=$fp;
											?>
											<div class="seatinfo">
												<table>
													<tr><th>Bus name</th><td>:</td><td><?php echo $row['bname']; ?></td></tr>
													<tr>
														<th>Num plate</th><td>:</td><td><?php echo $row['bcd']." ".$row['bno']; ?></td>
													</tr>
													<tr><th>type</th><td>:</td><td><?php echo $row['btype']; ?></td></tr>
													<tr><th>seat type</th><td>:</td><td><?php echo $row['stype']; ?></td></tr>
													<tr><th>total seat</th><td>:</td><td><?php echo $nseat; ?></td></tr>
													<tr><th>route</th><td>:</td><td><?php echo $loc; ?></td></tr>
													<tr><th>time</th><td>:</td><td><?php echo $row['trtime']; ?></td></tr>
													<tr><th>Price</th><td>:</td><td><?php echo "Rs ".$price; ?></td></tr>
												</table>
												<?php
												$arrstat=array();
												$arrbid=array();
												$arrbsid=array();
												$arrseatno=array();
												$arrspno=array();
												$arrfpno=array();
												for($i=0;$i<$nseat;$i++){
													array_push($arrstat,"E");
													array_push($arrbid,$bid);
													array_push($arrbsid,$bsid);
												}
												$E=$nseat;
												$R=$P=0;
												$sql1="SELECT	* from route INNER JOIN addroute on route.rid=addroute.rid where arid='$x' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$arid=$row1['arid'];
														$rid=$row1['rid'];
													}
												}
												$sql1="SELECT * from route where sp='$sp' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$scpid=0;
													}
												}
												$sql1="SELECT * from checkpoint where rid='$rid' && route='$sp' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$scpid=$row1['cpid'];
													}
												}
												$sql1="SELECT * from checkpoint where rid='$rid' && route='$fp' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$fcpid=$row1['cpid'];
													}
												}
												$sql1="SELECT * from route where fp='$fp' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$fcpid=100;
													}
												}
												$prev=0;
												$prevv="E";
												$now=0;
												$nowv="E";
												$sql1="SELECT * from seats where arid='$arid' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$spcpid=$row1['spcpid'];
														$fpcpid=$row1['fpcpid'];
														$now=$row1['sno'];
														if($now!=$prev){
															if($row1['status']=="P"){
																$P++;
																$E--;
																$nowv="P";
															}
															if($row1['status']=="R"){
																$R++;
																$E--;
																$nowv="R";
															}
															$prev=$now;
															$prevv=$nowv;
														}else{
															if($row1['status']!=$prevv){
																if($row1['status']=="R"){
																	$P--;
																	$R++;
																	$prevv="R";
																}
															}
														}
														if($scpid>=$fpcpid){
															$sno=$row1['sno'];
															$sno=$sno-1;
															$arrstat[$sno]="E";
														}
														if(($fcpid<=$spcpid)&&($scpid!=0)){
															$sno=$row1['sno'];
															$sno=$sno-1;
															$arrstat[$sno]="E";
														}
														if($scpid>=$spcpid){
															if(($fcpid>=$fpcpid)||($fcpid<$fpcpid)){
																$sno=$row1['sno'];
																$sno=$sno-1;
																$arrstat[$sno]=$row1['status'];

															}
															if($scpid>=$fpcpid){
																$sno=$row1['sno'];
																$sno=$sno-1;
																$arrstat[$sno]="E";

															}
														}
														if($scpid<=$spcpid){
															if($fcpid>=$fpcpid){
																$sno=$row1['sno'];
																$sno=$sno-1;
																$arrstat[$sno]=$row1['status'];

															}
														}
													}
												}		
												?>
												<div>
													<div class="seatno">
														<label>
															seats: <?php echo $nseat; ?>&nbsp&nbsp&nbspEmpty: <?php echo $E; ?> &nbsp&nbsp&nbspPending: <?php echo $P; ?> &nbsp&nbsp&nbspReserved: <?php echo $R; ?>&nbsp&nbsp&nbsp&nbsp&nbsp
														</label>
													</div>
													<div class="seats">
														<?php
														if(isset($_SESSION['uid'])){
															showseat($arrstat,$arrbid,$arrbsid,$a,$b,$conn);
														}
														?>
													</div>
												</div>
												<?php
												?>
											</div>
											<?php
										}
									}else{
										?>
										<div class="msg">
											<p style="margin: 5% 0;">sorry no bus found for the given route and time.</p>
											<p style="margin: 5% 0;">please check if your desired route has a bus and schedule assigned or not in prices section.</p>
											<p style="margin: 5% 0;">you can go to price section from the navbar at the top-center of your screen.</p>
										</div>
										<?php
									}
								}
								?>
							</div>
							<?php
						}
						function showseat($x,$bid,$bsid,$sp,$fp,$conn){
							$sc1=array("H","2","4","6","8","10","12","14","16","G","1","3","5","7","9","11","13","15","17","क","2","4","6","8","10","12","14","16","ख","1","3","5","7","9","11","13","15");
							$sc2=array("2","4","6","8","10","12","14","16","18","21","1","3","5","7","9","11","13","15","17","20","19","2","4","6","8","10","12","14","16","18","1","3","5","7","9","11","13","15","17");
							$j=count($x);
							?>
							<table>
								<?php
								for($i=0;$i<count($x);$i++){
									$a=$x[$i];
									$bi=$bid[$i];
									$bs=$bsid[$i];
									if($j==37){
										$s=$sc1[$i];
										if($i==0){
											?>
											<tr>
												<td>Driver</td>
												<td></td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>0 && $i<8){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i==8){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}else if($i==9){
											?>
											<tr>
												<td></td>
												<td>B</td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>9 && $i<17){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i==17){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}else if($i==18){
											?>
											<tr>
												<td colspan="11"></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>

											</tr>
											<?php
										}else if($i==19){
											?>
											<tr>
												<td></td>
												<td>A</td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>19 && $i<27){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>

												<?php
											}else if($i==27){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}else if($i==28){
											?>
											<tr>
												<td>Door</td>
												<td></td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>28 && $i<36){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i==36){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $s; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $s;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}
									}else{
										$c=$sc2[$i];
										if($i==0){
											?>
											<tr>
												<td>Driver</td>
												<td></td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>0 && $i<9){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i==9){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}else if($i==10){
											?>
											<tr>
												<td></td>
												<td>B</td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>10 && $i<19){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i==19){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="B" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}else if($i==20){
											?>
											<tr>
												<td colspan="12"></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}else if($i==21){
											?>
											<tr>
												<td></td>
												<td>A</td>
												<td></td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>21 && $i<29){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i==29){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}else if($i==30){
											?>
											<tr>
												<td>Door</td>
												<td></td>
												<td></td>
												<td></td>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i>30 && $i<38){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
												<?php
											}else if($i==38){
												?>
												<td>
													<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
														<input type="text" name="sp" value="<?php echo $sp;?> " hidden>
														<input type="text" name="fp" value="<?php echo $fp;?> " hidden>
														<input type="number" name="bid" value="<?php echo $bi; ?>" hidden>
														<input type="number" name="bsid" value="<?php echo $bs; ?>" hidden>
														<input type="number" name="sno" value="<?php echo $i+1; ?>" hidden>
														<input type="text" name="blc" value="A" hidden>
														<input type="text" name="sna" value="<?php echo $c; ?>" hidden>
														<?php 
														if($a=="R"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: red;" disabled>
															<?php
														}else if($a=="P"){
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>" style="background-color: yellow;" disabled>
															<?php
														}else{
															?>
															<input type="submit" name="reserve" value="<?php echo $c;?>">
															<?php
														}
														?>
													</form>
												</td>
											</tr>
											<?php
										}
									}
								}
								?>
							</table>
							<?php
						}
						function ticket($blc,$sna,$arid,$sno,$sp,$fp,$spcpid,$fpcpid,$price,$username,$conn){
							$sql="SELECT * from ((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute ON busschedule.bsid=addroute.bsid) where arid='$arid' ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$bname=$row['bname'];
									$bcd=$row['bcd'];
									$bno=$row['bno'];
									$btype=$row['btype'];
									$stype=$row['stype'];
									$trdate=$row['trdate'];
									$trtime=$row['trtime'];
								}
							}
							?>
							<div class="ticket">
								<table>
									<tr><th>Name</th><td>:</td><td><?php echo $username; ?></td></tr>
									<tr><th>Bus name</th><td>:</td><td><?php echo $bname; ?></td></tr>
									<tr><th>Num plate</th><td>:</td><td><?php echo $bcd." ".$bno; ?></td></tr>
									<tr><th>type</th><td>:</td><td><?php echo $btype; ?></td></tr>
									<tr><th>seat type</th><td>:</td><td><?php echo $stype; ?></td></tr>
									<tr><th>Travel</th><td>:</td><td><?php echo $sp." > ".$fp; ?></td></tr>
									<tr><th>date and time</th><td>:</td><td><?php echo $trdate." ".$trtime; ?></td></tr>
									<tr><th>Seat no</th><td>:</td><td><?php echo $blc." ".$sna; ?></td></tr>
									<tr><th>Price</th><td>:</td><td><?php echo "Rs ".$price; ?></td></tr>
									<tr><th>Confirmation</th><td>:</td>
										<td>
											<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
												<input type="text" name="arid" value="<?php echo $arid; ?>" hidden>
												<input type="text" name="sno" value="<?php echo $sno; ?>" hidden>
												<input type="text" name="blc" value="<?php echo $blc; ?>" hidden>
												<input type="text" name="sna" value="<?php echo $sna; ?>" hidden>
												<input type="text" name="sp" value="<?php echo $sp; ?>" hidden>
												<input type="text" name="fp" value="<?php echo $fp; ?>" hidden>
												<input type="number" name="spcpid" value="<?php echo $spcpid; ?>" hidden>
												<input type="number" name="fpcpid" value="<?php echo $fpcpid; ?>" hidden>
												<input type="number" name="price" value="<?php echo $price; ?>" hidden>
												<input type="submit" name="confirmticket" value="Confirm">
												<input type="submit" name="ticketpending" value="On-hold">
											</form>
										</td>
									</tr>
								</table>
								<a href="../home/home.php" style="color: black; margin-top: 5%;">back to main</a>
							</div>
							<?php
						}
						function ticketdisplay($arid,$ssid,$username,$conn){
							$sql="SELECT * from ((bus INNER JOIN busschedule on bus.bid=busschedule.bid) INNER JOIN addroute ON busschedule.bsid=addroute.bsid) where arid='$arid' ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$bname=$row['bname'];
									$bcd=$row['bcd'];
									$bno=$row['bno'];
									$btype=$row['btype'];
									$stype=$row['stype'];
									$trdate=$row['trdate'];
									$trtime=$row['trtime'];
								}
							}
							$sql="SELECT * from seats where sid='$ssid' ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$price=$row['price'];
									$sp=$row['sp'];
									$fp=$row['fp'];
								}
							}
							$sql="SELECT * from ticket where arid='$arid' && ssid='$ssid' ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$blc=$row['blc'];
									$sna=$row['sna'];
									$status=$row['tstatus'];
								}
							}
							if($status=="R"){
								$status="Reserved";
							}else if($status=="P"){
								$status="Pending";
							}else{
								$status="Empty";
							}
							?>
							<div class="ticketdisplay">
								<table>
									<tr><th>Name</th><td>:</td><td><?php echo $username; ?></td></tr>
									<tr><th>Bus name</th><td>:</td><td><?php echo $bname; ?></td></tr>
									<tr><th>Num plate</th><td>:</td><td><?php echo $bcd." ".$bno; ?></td></tr>
									<tr><th>type</th><td>:</td><td><?php echo $btype; ?></td></tr>
									<tr><th>seat type</th><td>:</td><td><?php echo $stype; ?></td></tr>
									<tr><th>Travel</th><td>:</td><td><?php echo $sp." > ".$fp; ?></td></tr>
									<tr><th>date and time</th><td>:</td><td><?php echo $trdate." ".$trtime; ?></td></tr>
									<tr><th>Seat no</th><td>:</td><td><?php echo $blc." ".$sna; ?></td></tr>
									<tr><th>Price</th><td>:</td><td><?php echo "Rs ".$price; ?></td></tr>
									<tr><th>Seat status</th><td>:</td><td><?php echo $status; ?></td></tr>
									<tr><th>Payment</th><td>:</td><td>due</td></tr>
								</table>
								<div id="xprint">
									<button id="print" onclick="window.print()" style="visibility: none;">print</button>
									<a href="../home/home.php">main</a>
								</div>
							</div>
							<p>Thank you for choosing OBTS  please arrive bus station 10-15 min before departure  payment will be taken at the time of departure...thank you!!!</p>
							<?php
						}
						?>
					</div>
				</div>
				<div class="container2" id="c2">
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
				<div class="container2" id="c3">
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
				<div class="container2" id="c4">
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
							<div class="img" id="img4">
								<section style="width: 100%;">
									<div style="text-transform: uppercase;">
										<h1>Point system</h1>
									</div>
									<div style="width: 100%; text-transform: uppercase; font-size: 1.5em;">
										<li style="background-color: red; color: yellow;">when ticket is reserved or kept on-hold, user will get +1 points as reward.</li>
										<li style="background-color: blue; color: yellow;">when user pays for the ticket, the user will get another +1 points as reward.</li>
										<li style="background-color: yellow; color: black;">when user change ticket status to empty/ cancel reservation from status of pending and reserved, the user will get -1 points as effect.</li>
										<li style="background-color: black; color: red;">there will be no change of points when user change their ticket status (pending &#8651 reserved).</li>
									</div>
								</section>
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
						<a href="../home/home.php" id="active"><i class='fas fa-home' style='font-size:25px;'></i><label> Home</label></a>
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
			<script src="../home/home.js"></script>
		</body>
		</html>