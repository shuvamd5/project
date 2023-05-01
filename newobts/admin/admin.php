<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../admin/admin.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title>OBTS/ADMIN</title>
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
	if(!$conn)
	{
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
			<?php
			if($userstatus=="Admin"){
				?>
				<fieldset id="salesreport" style="max-width: 100%; min-width: 100%; padding: 2% 0; display: flex;flex-wrap: wrap;">
					<?php
					$sql="SELECT * from ((sales INNER JOIN busschedule ON sales.bsid=busschedule.bsid) INNER JOIN bus ON busschedule.bid=bus.bid) WHERE bsstatus='going' ";
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
							$sql="SELECT * from ((bus INNER JOIN busschedule ON bus.bid=busschedule.bid)INNER JOIN addroute on busschedule.bsid=addroute.bsid) WHERE (bsstatus!='Expired' && arstatus='ok') LIMIT $x,8";
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
									$arstatus=$row['arstatus'];
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
										<label><?php echo $bstatus." / ".$bsstatus." / ".$arstatus; ?></label>
										<legend>sales : <?php echo $sales ; ?></legend>
									</fieldset>
									<?php
								}
							}else{
								?>
								<label>no sales done yet</label>
								<?php
							}
							?>
						</div>
						<div id="overflowx" style="display: none;" class="ofx">
							<?php
							$sql="SELECT * from ((bus INNER JOIN busschedule ON bus.bid=busschedule.bid)INNER JOIN addroute on busschedule.bsid=addroute.bsid) WHERE bsstatus='Expired' LIMIT $x,8";
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
									$arstatus=$row['arstatus'];
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
										<label><?php echo $bstatus." / ".$bsstatus." / ".$arstatus; ?></label>
										<legend>sales : <?php echo $sales ; ?></legend>
									</fieldset>
									<?php
								}
							}else{
								?>
								<label>no sales done yet</label>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
					<legend style="position: absolute; left: 5.8%; top: 15%; display: flex; width: 30%;">Sales report <button id="he" style="display: none;">hide expired</button> <button id="se">show expired</button></legend>
				</fieldset>
				<script>
					var cx='<?php echo $cnt/8.1; ?>';
					var he=document.getElementById('he');
					var se=document.getElementById('se');
					var kof=document.getElementsByClassName('of');
					var kofxx=document.getElementsByClassName('ofx');
					var kb=document.getElementsByClassName('b');
					var oflow=document.getElementById('oflow');
					var srch=document.getElementById('search');
					for(let l=0;l<=cx;l++){
						if(kof[0]!=kof[l]){
							if(kof[l]){
								kof[l].style.display='none';
								kofxx[0].style.display='none';
								kofxx[l].style.display='none';
							}
						}
					}
					for(let k=0;k<=cx;k++){
						se.onclick=function(){
							oflow.style.display='none';
							srch.value="";
							se.style.display='none';
							he.style.display='flex';
							for(let l=0;l<=cx;l++){
								if(kof[0]==kof[0]){
									if(kof[0]){
										kof[0].style.display='none';
										kofxx[0].style.display='flex';
									}
								}else{
									if(kof[l]){
										kof[l].style.display='none';
										kofxx[l].style.display='none';
									}
								}
							}
						}
						he.onclick=function(){
							he.style.display='none';
							se.style.display='flex';
							oflow.style.display='none';
							srch.value="";
							for(let l=0;l<=cx;l++){
								if(kofxx[0]==kofxx[0]){
									if(kofxx[0]){
										kofxx[0].style.display='none';
										kof[0].style.display='flex';
									}
								}else{
									if(kofxx[l]){
										kof[l].style.display='none';
										kofxx[l].style.display='none';
									}
								}
							}
						}
						kb[k].onclick=function(){
							for(let l=0;l<=cx;l++){
								if(kof[k]==kof[l]){
									if(kof[l]){
										kof[l].style.display='flex';
										se.onclick=function(){
											se.style.display='none';
											he.style.display='flex';
											kof[l].style.display='none';
											kofxx[l].style.display='flex';
											oflow.style.display='none';
											srch.value="";
										}
										he.onclick=function(){
											he.style.display='none';
											se.style.display='flex';
											kofxx[l].style.display='none';
											kof[l].style.display='flex';
											oflow.style.display='none';
											srch.value="";
										}
									}
								}else{
									if(kof[l]){
										kof[l].style.display='none';
										kofxx[l].style.display='none';
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
						document.getElementById('overflowx').style.display='none';
						<?php
						$sql1x="SELECT * from bus ";
						$result1x=mysqli_query($conn,$sql1x);
						if(mysqli_num_rows($result1x)>0){
							while($row1x=mysqli_fetch_assoc($result1x)){
								$bcdxx=$row1x['bcd'];
								$bnoxx=$row1x['bno'];
								$bndxx=$bcdxx." ".$bnoxx;
								?>
								var bndxx='<?php echo $bndxx;?>';
								var bnoxx='<?php echo $bnoxx;?>';
								if(x==bndxx || x==bnoxx){
									document.getElementById('oflow').innerHTML=('<?php
										$sql="SELECT * from ((addroute INNER JOIN busschedule ON addroute.bsid=busschedule.bsid) INNER JOIN bus on bus.bid=busschedule.bid) WHERE (bcd='$bcdxx'&& bno='$bnoxx')||(bno='$bnoxx') ";
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
												$sql2="SELECT * from route INNER JOIN addroute on route.rid=addroute.rid where arid='$arid' ";
												$result2=mysqli_query($conn,$sql2);
												if(mysqli_num_rows($result2)>0){
													while($row2=mysqli_fetch_assoc($result2)){
														$sp=$row2['sp'];
														$fp=$row2['fp'];
														$route=$sp." > ".$fp;
													}
												}
												$sql2="SELECT * from ticket where arid='$arid' && tstatus='R' ";
												$result2=mysqli_query($conn,$sql2);
												$xx=mysqli_num_rows($result2);

												$sql2="SELECT * from ticket where arid='$arid' && tstatus='P' ";
												$result2=mysqli_query($conn,$sql2);
												$y=mysqli_num_rows($result2);

												$z=$nseat-$xx-$y;
												$sql1="SELECT * from sales where bid='$bid' && bsid='$bsid' LIMIT $x,8 ";
												$result1=mysqli_query($conn,$sql1);
												if(mysqli_num_rows($result1)>0){
													while($row1=mysqli_fetch_assoc($result1)){
														$sales=$row1['sales'];
														?>
														<fieldset id="c11"><label><?php echo $bus." ".$bname; ?></label><label><?php echo $trdate." / ".$trtime; ?></label><label><?php echo $route;?></label><label><?php echo $stype." seats : ".$nseat; ?></label><div><div style="display: flex; flex-direction: column; color: red;"><label>Reserved</label><label style="margin: 0 auto;"><?php echo $xx; ?></label></div><div style="display: flex; flex-direction: column; color: blue;"><label>Pending</label><label style="margin: 0 auto;"><?php echo $y; ?></label></div><div style="display: flex; flex-direction: column; color: green;"><label>Empty</label><label style="margin: 0 auto;"><?php echo $z; ?></label></div></div><label>price : <?php echo "Rs ".$price; ?></label><label><?php echo $bstatus." / ".$bsstatus." / ".$arstatus; ?></label><legend>sales : <?php echo $sales ; ?></legend></fieldset><?php
													}
												}
											}
										}
										?>');
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
					var sx=document.getElementById('search');
					btn.onclick=function(){
						of1.style.display='none';
						of.style.display='flex';
						sx.value="";
					}
				</script>
				<?php
			}
			if($userstatus=="Manager"){
				?>
				<fieldset id="ticketsales" style="max-width: 100%; min-width: 100%; padding: 2% 0; display: flex; flex-wrap: wrap;">
					<?php
					$sql="SELECT * from addroute WHERE arstatus='ok' ";
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
							$sql="SELECT * from ((addroute INNER JOIN busschedule ON addroute.bsid=busschedule.bsid) INNER JOIN bus on bus.bid=busschedule.bid) WHERE (bsstatus!='Expired' && arstatus='ok') ORDER BY trdate ASC LIMIT $x,8";
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
										<legend><?php echo $arid;?></legend>
									</fieldset>
									<?php
								}
							}else{
								?>
								<label>no record found...</label>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
					<legend style="position: absolute; left: 5.8%; top: 15%;">Ticket Sales</legend>
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
						<?php
						$sql2x="SELECT * from bus";
						$result2x=mysqli_query($conn,$sql2x);
						if(mysqli_num_rows($result2x)>0){
							while($row2x=mysqli_fetch_assoc($result2x)){
								$bcdxx=$row2x['bcd'];
								$bnoxx=$row2x['bno'];
								$bndxx=$bcdxx." ".$bnoxx;
								?>
								var bndxx='<?php echo $bndxx;?>';
								var bnoxx='<?php echo $bnoxx;?>';
								if(xx==bndxx || xx==bnoxx){
									document.getElementById('oflowm').innerHTML=('<?php
										$sql="SELECT * from ((addroute INNER JOIN busschedule ON addroute.bsid=busschedule.bsid) INNER JOIN bus on bus.bid=busschedule.bid) WHERE bsstatus!='Expired' && arstatus='ok' && ((bno='$bnoxx')||(bcd='$bcdxx' && bno='$bnoxx'))";
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
												$arstatus=$row['arstatus'];
												$arid=$row['arid'];
												$price=$row['price'];
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
												<fieldset id="c11"><label><?php echo $bus." ".$bname; ?></label><label><?php echo $trdate." / ".$trtime; ?></label><label><?php echo $route;?></label><label><?php echo $stype." seats : ".$nseat; ?></label><div><div style="display: flex; flex-direction: column; color: red;"><label>Reserved</label><label style="margin: 0 auto;"><?php echo $R; ?></label></div><div style="display: flex; flex-direction: column; color: blue;"><label>Pending</label><label style="margin: 0 auto;"><?php echo $P; ?></label></div><div style="display: flex; flex-direction: column; color: green;"><label>Empty</label><label style="margin: 0 auto;"><?php echo $E; ?></label></div></div><label>price : <?php echo "Rs ".$price; ?></label><legend><?php echo $arid;?></legend></fieldset><?php
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
					var btnxx=document.getElementById('btnm');
					var ofxx=document.getElementById('overflowm');
					var of1xx=document.getElementById('oflowm');
					var sxx=document.getElementById('searchm');
					btnxx.onclick=function(){
						of1xx.style.display='none';
						ofxx.style.display='flex';
						sxx.value="";
					}
				</script>
				<?php
			}
			if(($userstatus!="Admin")&&($userstatus!="Manager")){
				?>
				<div style="display: flex; height: 40vh; align-items: center;">
					<label style="font-weight: 900; color: black; text-align: center; font-size: 1.5em; margin: 0 auto;">session out !!! please login in to continue...</label>
				</div>
				<?php
			}
			?>
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
					<div class="img" id="img4"></div>
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
		<div class="footer" id="footer" style="background-color: black;">
			<i class='fas fa-angle-down' id="sd" style='font-size:25px;'></i>
			<footer>
				<h3>obts</h3>
				<h4>contact: 9812449811</h4>
				<?php
				if($userstatus=="Admin"){
					?>
					<a href="../admin/admin.php" id="active">Admin</a>
					<?php
				}
				if($userstatus=="Manager"){
					?>
					<a href="../admin/admin.php" id="active">Manager</a>
					<?php
				}
				?>
			</footer>
		</div>
	</div>

	<script src="../admin/admin.js"></script>

</body>
</html>