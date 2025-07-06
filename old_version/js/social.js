function prikazi_datum(){
    var dat=new Date();
    document.getElementById('datum').innerHTML=dat;
}
function selected(selected){
	var selected=document.getElementById("sel");
	var val=selected;
	document.getElementById("sec").innerHTML=val;
}
function setColorGreen(){
	document.getElementById("sel").style.backgroundColor="green";
	document.getElementById("op").style.color="green";
}
function setColorWhite(){
	document.getElementById("sel").style.backgroundColor="white";
	document.getElementById("op").style.color="white";
}