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

var lges=document.getElementById('logineyeslash');
var lge=document.getElementById('logineye');
var sues=document.getElementById('signupeyeslash');
var sue=document.getElementById('signupeye');
var upass=document.getElementById('upass');
var logpass=document.getElementById('logpass');
lges.onclick=function(){
	logpass.type='text';
	lges.style.display='none';
	lge.style.display='flex';
}
lge.onclick=function(){
	logpass.type='password';
	lge.style.display='none';
	lges.style.display='flex';
}
sues.onclick=function(){
	upass.type='text';
	sues.style.display='none';
	sue.style.display='flex';
}
sue.onclick=function(){
	upass.type='text';
	sue.style.display='none';
	sues.style.display='flex';
}

var container=document.getElementById('container');
var s=document.getElementById('s');
var l=document.getElementById('l');
var sb=document.getElementById('sb');
var lb=document.getElementById('lb');
var lgb=document.getElementById('loginbutton');
var sub=document.getElementById('signupbutton');
var reg=document.getElementById('signup');
lgb.onclick=function(){
	l.style.display='flex';
	lb.style.display='flex';
	s.style.display='none';
	sb.style.display='none';
}
sub.onclick=function(){
	s.style.display='flex';
	sb.style.display='flex';
	l.style.display='none';
	lb.style.display='none';
}
reg.onclick=function(){
	s.style.display='flex';
	sb.style.display='flex';
	l.style.display='none';
	lb.style.display='none';
}
function validateuname(){
	var uname=document.getElementById('uname').value;
	var info=document.getElementById('info');
	var submit=document.getElementById('submit');
	pattern1=/[a-zA-Z\s]/;
	if((uname.search(pattern1)==-1)||uname==""){
		document.getElementById('uname').style.borderColor='red';
		info.style.display='flex';
		info.style.margin='2.5% auto';
		info.innerHTML="only alphabet and space";
		validate();
	}else{
		document.getElementById('uname').style.borderColor='green';
		submit.style.display='flex';
		info.style.display='none';
	}
}
function validateuemail(){
	var uemail=document.getElementById('uemail').value;
	var info=document.getElementById('info');
	var submit=document.getElementById('submit');
	pattern3=/[a-zA-Z0-9]+[@]+[a-zA-Z]/;
	if((uemail.search(pattern3)==-1)||uemail==""){
		document.getElementById('uemail').style.borderColor='red';
		info.style.display='flex';
		info.style.margin='2.5% auto';
		info.innerHTML="@ is necessary";
		validate();
	}else{
		document.getElementById('uemail').style.borderColor='green';
		submit.style.display='flex';
		info.style.display='none';
	}
}
function validateumobile(){
	var umobile=document.getElementById('umobile').value;
	var info=document.getElementById('info');
	var submit=document.getElementById('submit');
	pattern4=/[0-9]/;
	if((umobile.search(pattern4)==-1)||umobile==""||umobile.length!=10){
		document.getElementById('umobile').style.borderColor='red';
		info.style.display='flex';
		info.style.margin='2.5% auto';
		info.innerHTML="must be 10 digit";
		validate();
	}else{
		document.getElementById('umobile').style.borderColor='green';
		submit.style.display='flex';
		info.style.display='none';
	}
}
function validateupass(){
	var	upass=document.getElementById('upass').value;
	var info=document.getElementById('info');
	var submit=document.getElementById('submit');
	pattern2=/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])/;
	if((upass.search(pattern2)==-1)||upass==""||upass.length<8||upass.length>16){
		document.getElementById('upass').style.borderColor='red';
		info.style.display='flex';
		info.style.margin='-1.25% auto';
		info.innerHTML="atleast 1 uppercase,1 symbol,1 number";
		validate();
	}else{
		document.getElementById('upass').style.borderColor='green';
		submit.style.display='flex';
		info.style.display='none';
	}
}
function validate(){
	var submit=document.getElementById('submit');
	submit.style.display='none';
}