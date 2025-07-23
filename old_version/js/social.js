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
function selected2(val){
	   if (val == "") {
        document.getElementById("sv").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("sv").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","socijalnamreza.php?q="+val,true);
        xmlhttp.send();
    }
	
}