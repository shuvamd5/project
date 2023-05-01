var connection=document.getElementById('connection');
var welcome=document.getElementById('welcome');
setTimeout(play,3000);
connection.style.display='block';
welcome.style.display='none';
function play(){
	connection.style.display='none';
	welcome.style.display='block';
	setTimeout(play1,3000);
}
function play1(){
	connection.style.display='none';
	welcome.style.display='none';
}

var dd=document.getElementById('dd');
var d=document.getElementById('dashboard');
var du=document.getElementById('du');
var su=document.getElementById('su');
var footer=document.getElementById('footer');
var sd=document.getElementById('sd');
dd.onclick=function(){
	dd.style.display='none';
	d.style.display='block';
}
du.onclick=function(){
	d.style.display='none';
	dd.style.display='block';
}
su.onclick=function(){
	su.style.display='none';
	footer.style.display='block';
}
sd.onclick=function(){
	footer.style.display='none';
	su.style.display='block';
}

var face=document.getElementById('face');
face.onclick=function(){
	window.location.reload();
}

var c1=document.getElementById('c1');
var c2=document.getElementById('c2');
var c3=document.getElementById('c3');
var c4=document.getElementById('c4');
var ls=document.getElementById('ls');
var ls1=document.getElementById('ls1');
var ls2=document.getElementById('ls2');
var ls3=document.getElementById('ls3');
var rs=document.getElementById('rs');
var rs1=document.getElementById('rs1');
var rs2=document.getElementById('rs2');
var rs3=document.getElementById('rs3');

rs.onclick=function(){
	rs.style.display='none';
	rs2.style.display='none';
	rs3.style.display='none';
	ls.style.display='none';
	ls2.style.display='none';
	ls3.style.display='none';
	c1.style.display='none';
	c3.style.display='none';
	c4.style.display='none';
	ls1.style.display='flex';
	rs1.style.display='flex';
	c2.style.display='flex';
}
rs1.onclick=function(){
	rs1.style.display='none';
	rs.style.display='none';
	rs3.style.display='none';
	ls.style.display='none';
	ls1.style.display='none';
	ls3.style.display='none';
	c1.style.display='none';
	c2.style.display='none';
	c4.style.display='none';
	ls2.style.display='flex';
	rs2.style.display='flex';
	c3.style.display='flex';
}
rs2.onclick=function(){
	rs2.style.display='none';
	rs.style.display='none';
	rs1.style.display='none';
	ls.style.display='none';
	ls1.style.display='none';
	ls2.style.display='none';
	c1.style.display='none';
	c2.style.display='none';
	c3.style.display='none';
	ls3.style.display='flex';
	rs3.style.display='flex';
	c4.style.display='flex';
}
rs3.onclick=function(){
	rs3.style.display='none';
	rs1.style.display='none';
	rs2.style.display='none';
	rs1.style.display='none';
	ls1.style.display='none';
	ls2.style.display='none';
	ls3.style.display='none';
	c2.style.display='none';
	c3.style.display='none';
	c4.style.display='none';
	ls.style.display='flex';
	rs.style.display='flex';
	c1.style.display='flex';
}
ls.onclick=function(){
	ls.style.display='none';
	ls1.style.display='none';
	ls2.style.display='none';
	rs.style.display='none';
	rs1.style.display='none';
	rs2.style.display='none';
	c1.style.display='none';
	c2.style.display='none';
	c3.style.display='none';
	ls3.style.display='flex';
	rs3.style.display='flex';
	c4.style.display='flex';
}
ls1.onclick=function(){
	ls1.style.display='none';
	ls2.style.display='none';
	ls3.style.display='none';
	rs1.style.display='none';
	rs2.style.display='none';
	rs3.style.display='none';
	c2.style.display='none';
	c3.style.display='none';
	c4.style.display='none';
	ls.style.display='flex';
	rs.style.display='flex';
	c1.style.display='flex';
}
ls2.onclick=function(){
	ls2.style.display='none';
	ls.style.display='none';
	ls3.style.display='none'
	rs.style.display='none';
	rs2.style.display='none';
	rs3.style.display='none';
	c1.style.display='none';
	c3.style.display='none';
	c4.style.display='none';
	ls1.style.display='flex';
	rs1.style.display='flex';
	c2.style.display='flex';
}
ls3.onclick=function(){
	ls3.style.display='none';
	ls.style.display='none';
	ls1.style.display='none';
	rs.style.display='none';
	rs1.style.display='none';
	rs3.style.display='none';
	c1.style.display='none';
	c2.style.display='none';
	c4.style.display='none';
	ls2.style.display='flex';
	rs2.style.display='flex';
	c3.style.display='flex';
}

var dot1=document.getElementById('dot1');
var dot2=document.getElementById('dot2');
var dot3=document.getElementById('dot3');
var dot4=document.getElementById('dot4');
var img1=document.getElementById('img1');
var img2=document.getElementById('img2');
var img3=document.getElementById('img3');
var img4=document.getElementById('img4');

dot1.onclick=function(){
	img1.style.display='flex';
	img2.style.display='none';
	img3.style.display='none';
	img4.style.display='none';
}
dot2.onclick=function(){
	img1.style.display='none';
	img2.style.display='flex';
	img3.style.display='none';
	img4.style.display='none';
}
dot3.onclick=function(){
	img1.style.display='none';
	img2.style.display='none';
	img3.style.display='flex';
	img4.style.display='none';

}
dot4.onclick=function(){
	img1.style.display='none';
	img2.style.display='none';
	img3.style.display='none';
	img4.style.display='flex';
}
