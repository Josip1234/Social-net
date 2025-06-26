function prikazi_datum(){
    var dat=new Date();
    document.getElementById('datum').innerHTML=dat;
}
function selected(selected){
	var selected=document.getElementById("sel");
	var val=selected;
	document.getElementById("sec").innerHTML=val;
}