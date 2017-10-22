// JavaScript Document
function prikazi_datum(){

	var dat = new Date();
	document.getElementById('datum').innerHTML=dat;
  
	
}
function selected(val){
	
	   if (val == 0) {
        
		setColorWhite();
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
				setColorGreen();
            }
        };
        xmlhttp.open("GET","socijalnamreza.php?q="+val,true);
        xmlhttp.send();
		
    }
	
}
function setColorGreen(){
	document.getElementById("sel").style.backgroundColor="green";
	document.getElementById("op").style.color="green";
}
function setColorWhite(){
	document.getElementById("sel").style.backgroundColor="white";
	document.getElementById("op").style.color="white";
}
