// JavaScript Document
function hd(){
	document.getElementById("valut").style.display="none";
}
function sho(){
	document.getElementById('sh').style.display="inline";

}

function showRand(){
	document.getElementById('secrand').style.display="inline";
	document.getElementById('butt').style.display="none";
}
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


/*
function displaycategories(){
	pokusaj=pokusaj+1;
	var pokusaj=0;
	if(pokusaj==0){
 limit=6;
 category='rest';
 first=4;
 last=9;
	
	}else{
		 limit=6;
 category='rest';
 first=first+6;
 last=last+6;
	}
	document.getElementById("slika").style.display="none";
	 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
		
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("categslik").innerHTML = this.responseText;
				
            }
        };
	
        xmlhttp.open("GET","printingpicturegalley.php?limit="+limit+"&category="+category+"+&first="+first+"+&second="+last,true);
	    
        xmlhttp.send();
	document.getElementById("categslik").style.display="block";
	
	
	
	
	
}
*/

function setColorGreen(){
	document.getElementById("sel").style.backgroundColor="green";
	document.getElementById("op").style.color="green";
}
function setColorWhite(){
	document.getElementById("sel").style.backgroundColor="white";
	document.getElementById("op").style.color="white";
}

