// JavaScript Document
function prikazi_datum(){

	var dat = new Date();
	document.getElementById('datum').innerHTML=dat;
  
	
};

function selected("<?php $sel ?>"){
	var selected=document.getElementById("sel");
	var val=selected;
	document.getElementById("sec").innerHTML=val;
}