<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../schedule/schedule.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title>OBTS/SCHEDULE</title>
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

	$bid=$trdate=$trtime=$bsstatus=$bssapby="";
	$seats=$status=$sreby="";
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
				if(isset($_POST['bsedit'])){
					$bsid=check_data($_POST['bsid']);
					$bssapby=check_data($_POST['bssapby']);
					$bsstatus=check_data($_POST['bsstatus']);
					$sql="SELECT bsstatus from busschedule where bsid='$bsid' ";
					$result=mysqli_query($conn,$sql);
					if(mysqli_num_rows($result)>0){
						while($row=mysqli_fetch_assoc($result)){
							$bss=$row['bsstatus'];
							if($bss==$bsstatus){
										//echo "already edited ";
							}else{
								$sql1="UPDATE busschedule set bsstatus='$bsstatus',bssapby='$bssapby' where bsid='$bsid' ";
								if(mysqli_query($conn,$sql1)){
									echo "data updated";
								}else{
									echo "error updating.. ".mysqli_error($conn);
								}
								if($bsstatus!="going"){
									$sql="UPDATE addroute set arstatus='unchecked' where bsid='$bsid' && arstatus!='Expired' ";
									if(mysqli_query($conn,$sql1)){
						//echo "schedule";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
								}
								if($bsstatus=="going"){
									$sql="SELECT * from busschedule where bsid='$bsid'";
									$x=mysqli_query($conn,$sql);
									if(mysqli_num_rows($x)>0){
										while ($row=mysqli_fetch_assoc($x)) {
											$bsid=$row['bsid'];
											$a=$row['bid'];
											$b=$row['trdate'];
											$c=$row['trtime'];
										}
									}
									$sql="INSERT INTO sales(bid,bsid,trdate,trtime,sales)
									VALUES('$a','$bsid','$b','$c',0)";
									if($conn->query($sql)===TRUE){
										//echo "schedule has been added";
									}else{
										echo "<br/>Error".$sql.$conn->error;
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

				<fieldset style="max-width: 100%; min-width: 100%; padding: 2% 0; display: flex;flex-wrap: wrap;">
					
					<?php
					$sql="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bstatus='active' && bsstatus!='Expired' ";
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
							$sql="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bstatus='active' && bsstatus!='Expired' ORDER BY trdate ASC LIMIT $x,8 ";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$bsid=$row['bsid'];
									$sql1="SELECT * from addroute INNER JOIN route on addroute.rid=route.rid WHERE bsid='$bsid' ";
									$result1=mysqli_query($conn,$sql1);
									if(mysqli_num_rows($result1)>0){
										while($row1=mysqli_fetch_assoc($result1)){
											$sp=$row1['sp'];
											$fp=$row1['fp'];
											$price=$row1['price'];
											$mix=$sp." > ".$fp;
										}
									}
									?>
									<fieldset id="c11">
										<label><?php echo $row['bcd']." ".$row['bno']; ?></label>
										<label>name : <?php echo $row['bname']; ?></label>
										<label>type : <?php echo $row['btype']; ?></label>
										<label>date : <?php echo $row['trdate']; ?></label>
										<label>time : <?php echo $row['trtime']; ?></label>
										<label><?php echo $mix; ?></label>
										<label>
											<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
												<input type="number" name="bsid" value="<?php echo $row['bsid']; ?>" hidden>
												<input type="text" name="bssapby" value="<?php echo $_SESSION['uname']; ?>" hidden>
												<select name="bsstatus">
													<option value="not approved">not approved</option>
													<option value="going">going</option>
													<option value="not going">not going</option>
													<option value="pending">pending</option>
												</select>
												<button name="bsedit">edit</button>
											</form>
										</label>
										<legend><?php echo $row['bsstatus']; ?></legend>
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
						$sql2="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bstatus='active' && bsstatus!='Expired' ";
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
										$sql="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bstatus='active' && bsstatus!='Expired' && ((bno='$bno')||(bcd='$bcd' && bno='$bno')) ";
										$result=mysqli_query($conn,$sql);
										if(mysqli_num_rows($result)>0){
											while($row=mysqli_fetch_assoc($result)){
												$bsid=$row['bsid'];
												$sql1="SELECT * from addroute INNER JOIN route on addroute.rid=route.rid WHERE bsid='$bsid' ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$sp=$row1['sp'];
														$fp=$row1['fp'];
														$price=$row1['price'];
														$mix=$sp." > ".$fp;
													}
												}
												?>
												<fieldset id="c11"><label><?php echo $row['bcd']." ".$row['bno']; ?></label><label>name : <?php echo $row['bname']; ?></label><label>type : <?php echo $row['btype']; ?></label><label>date : <?php echo $row['trdate']; ?></label><label>time : <?php echo $row['trtime']; ?></label><label><?php echo $mix; ?></label><label><form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="bsid" value="<?php echo $row['bsid']; ?>" hidden><input type="text" name="bssapby" value="<?php echo $_SESSION['uname']; ?>" hidden><select name="bsstatus"><option value="not approved">not approved</option><option value="going">going</option><option value="not going">not going</option><option value="pending">pending</option></select><button name="bsedit">edit</button></form></label><legend><?php echo $row['bsstatus']; ?></legend></fieldset><?php
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
							$sql="SELECT bid,trdate from busschedule";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									$x=date_create($b);
									$c=date_create($row['trdate']);
									$y=date_diff($x,$c);
									$z=$y->format("%a");
									if($a==$row["bid"]){
										if($b==$row['trdate']){
										//echo "<br/>Travelling date for the bus is already registered <br/>";
											return "true";
										}else if($z<=2){
											echo "<br/>difference between dates is less than 2 days";
											return "true";
										}
									}
								}
								return "false";
							}else{
								return "false";
							}
						}
						function store($a,$b,$c,$d,$e,$conn){
							$check=repeat($conn,$a,$b);
							if($check=="false"){
								$sql="INSERT INTO busschedule(bid,trdate,trtime,bsstatus,bssapby) 
								VALUES('$a','$b','$c','$d','$e')";
								if($conn->query($sql)===TRUE){
									echo "data updated";
								}else{
									echo "Error".$sql.$conn->error;
								}
							}
						}
						if($_SERVER['REQUEST_METHOD']=='POST'){
							if(isset($_POST['scheduleentry'])){
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
								$bid=$_POST['bid'];
								$trtime=$_POST['trtime'];
								$tr=date_create($_POST['trdate']);
								$trdate=date_format($tr,"Y-m-d");
								$x=date_create(date("Y-m-d"));
								$g=date_format($x,"Y-m-d");
								$h=date_diff($tr,$x);
								$i=$h->format("%a");
								$bsstatus="not approved";
								$bssapby="none";
								if($i>=4){
									store($bid,$trdate,$trtime,$bsstatus,$bssapby,$conn);
								}else{
									echo "There is less than 4 days difference in days.";	
								}
							}					
						}
						?>
					</fieldset>
				</div>
				<fieldset style="max-width: 100%; min-width: 100%; padding: 2% 0; display: flex; flex-wrap: wrap;">
					
					<?php
					$sql="SELECT * from bus";
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
							$sql="SELECT * from bus LIMIT $x,8";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0){
								while($row=mysqli_fetch_assoc($result)){
									?>
									<fieldset id="c11">
										<label><?php echo $row['bcd']." ".$row['bno']; ?></label>
										<label>name : <?php echo $row['bname']; ?></label>
										<label>type : <?php echo $row['btype']; ?></label>
										<label>seats : <?php echo $row['nseat']; ?></label>
										<label style="font-weight: 700; font-size: 0.9em;">Add travelling date : </label>
										<label>
											<form id="bussch" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
												<input type="number" name="bid" value="<?php echo $row['bid']?>" hidden>
												<input type="date" name="trdate" min="<?php echo date("Y-m-d");?>" autocomplete="off" required>
												<input type="time" name="trtime" autocomplete="off" required>
												<button name="scheduleentry">ENTER</button>
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
					<legend style="position: absolute; left: 5.8%; top: 15%;">add schedule</legend>
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
						$sql="SELECT * from bus";
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$bcd=$row['bcd'];
								$bno=$row['bno'];
								$bcd=$bcd." ".$bno;
								?>
								var bcd='<?php echo $bcd;?>';
								var bno='<?php echo $bno;?>';
								if(xx==bcd || xx==bno){
									document.getElementById('oflowm').innerHTML=('<fieldset id="c11"><label><?php echo $row['bcd']." ".$row['bno']; ?></label><label>name : <?php echo $row['bname']; ?></label><label>type : <?php echo $row['btype']; ?></label><label>seats : <?php echo $row['nseat']; ?></label><label style="font-weight: 700; font-size: 0.9em;">Add travelling date : </label><label><form id="bussch" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"><input type="number" name="bid" value="<?php echo $row['bid']?>" hidden><input type="date" name="trdate" min="<?php echo date("Y-m-d");?>" autocomplete="off" required><input type="time" name="trtime" autocomplete="off" required><button name="scheduleentry">ENTER</button></form></label><legend><?php echo $row['bstatus']; ?></legend></fieldset>');
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
							$bsid=$_POST['bsid'];
							$cd=date_create(date("Y-m-d"));
							//date_add($cd,date_interval_create_from_date_string("+6 day"));
							$sql1="SELECT * from seats INNER JOIN addroute on seats.arid=addroute.arid WHERE bsid='$bsid' ";
							$sc=mysqli_num_rows(mysqli_query($conn,$sql1));
							$sql1="SELECT * from addroute WHERE bsid='$bsid' && arstatus='ok' ";
							$result1=mysqli_query($conn,$sql1);
							if(mysqli_num_rows($result1)>0){
								echo $sc." seats are recorded...continue ? ";
								?>
								<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
									<input type="number" name="bsid" value="<?php echo $bsid; ?>" hidden>
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
									<input type="number" name="bsid" value="<?php echo $bsid; ?>" hidden>
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
							$bsid=$_POST['bsid'];
							$sql1="SELECT * from addroute WHERE bsid='$bsid' ";
							$result1=mysqli_query($conn,$sql1);
							if(mysqli_num_rows($result1)>0){
								while($row1=mysqli_fetch_assoc($result1)){
									$arid=$row1['arid'];
									$sql="DELETE from ticket where arid='$arid' ";
									if(mysqli_query($conn,$sql)){
										//echo "data updated";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql="DELETE from seats where arid='$arid' ";
									if(mysqli_query($conn,$sql)){
										//echo "data updated";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
								}
							}
							$sql1="SELECT * from addroute WHERE bsid='$bsid' ";
							$result1=mysqli_query($conn,$sql1);
							if(mysqli_num_rows($result1)>0){
								while($row1=mysqli_fetch_assoc($result1)){
									$arid=$row1['arid'];
									$sql="DELETE from addroute where arid='$arid' ";
									if(mysqli_query($conn,$sql)){
										//echo "data updated";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
									$sql="DELETE from sales where bsid='$bsid' ";
									if(mysqli_query($conn,$sql)){
								//echo "data updated";
									}else{
										echo "error updating.. ".mysqli_error($conn);
									}
								}
							}
							$sql="DELETE from busschedule where bsid='$bsid' ";
							if(mysqli_query($conn,$sql)){
								echo "data updated";
							}else{
								echo "error updating.. ".mysqli_error($conn);
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
					$sql="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bsstatus='going' ";
				}else if($userstatus=="Admin" || $userstatus=="Manager"){
					$sql="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bsstatus!='Expired' ";
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
							$sql="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bsstatus='going' ORDER BY trdate ASC LIMIT $x1,8 ";
						}else if($userstatus=="Admin" || $userstatus=="Manager"){
							$sql="SELECT * from busschedule INNER JOIN bus ON busschedule.bid=bus.bid where bsstatus!='Expired' ORDER BY trdate ASC LIMIT $x1,8 ";
						}
						$result=mysqli_query($conn,$sql);
						if(mysqli_num_rows($result)>0){
							while($row=mysqli_fetch_assoc($result)){
								$bsid=$row['bsid'];
								$sql1="SELECT * from addroute INNER JOIN route on addroute.rid=route.rid WHERE bsid='$bsid' ";
								$result1=mysqli_query($conn,$sql1);
								if(mysqli_num_rows($result1)>0){
									while($row1=mysqli_fetch_assoc($result1)){
										$sp=$row1['sp'];
										$fp=$row1['fp'];
										$price=$row1['price'];
										$mix=$sp." > ".$fp;
									}
								}
								?>
								<fieldset id="c11">
									<label><?php echo $row['bcd']." ".$row['bno']; ?></label>
									<label>name : <?php echo $row['bname']; ?></label>
									<label>type : <?php echo $row['btype']; ?></label>
									<label>time : <?php echo $row['trtime']; ?></label>
									<label><?php echo $mix; ?></label>
									<label>status : <?php echo $row['bsstatus']; ?></label>
									<?php
									if(isset($_SESSION['uid'])&& ($userstatus=="Admin" || $userstatus=="Manager")){
										?>
										<legend class="predel"><?php echo $row['trdate']; ?> </legend>
										<legend class="del">
											<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
												<input type="number" name="bsid" value="<?php echo $row['bsid']; ?>" hidden>
												<button name="bdel">delete</button>
											</form>
										</legend>
										<?php
									}else{
										?>
										<legend><?php echo $row['trdate']; ?> </legend>
										<?php
									}
									?>
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
				<legend style="position: absolute; left: 5.8%; top: 15%;">schedules</legend>
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
				<a href="../schedule/schedule.php" id="active"><i class='fas fa-calendar-alt' style='font-size:25px;'></i><label>schedule</label>
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

	<script src="../schedule/schedule.js"></script>
	<script>
		if ( window.history.replaceState ) {
			window.history.replaceState( null, null, window.location.href );
		}
	</script>

</body>
</html>