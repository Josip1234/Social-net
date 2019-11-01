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
  
	
<<<<<<< HEAD
<<<<<<< HEAD
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

=======
};
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> parent of ad58c11... napravljene galerije
=======
=======
>>>>>>> parent of 9960ec0... wgrge
=======
};
>>>>>>> parent of 91a52f5... napravljen feedback

function selected("<?php $sel ?>"){
	var selected=document.getElementById("sel");
	var val=selected;
	document.getElementById("sec").innerHTML=val;
<<<<<<< HEAD
<<<<<<< HEAD
}
>>>>>>> parent of 91a52f5... napravljen feedback
=======
}
>>>>>>> parent of 91a52f5... napravljen feedback
<<<<<<< HEAD
>>>>>>> parent of 9960ec0... wgrge
<<<<<<< HEAD
=======
>>>>>>> parent of 94fc92c... ergweeg
=======
>>>>>>> parent of e0e0777... napravljene galerije
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> parent of 9960ec0... wgrge
=======
};
>>>>>>> parent of ad58c11... napravljene galerije
=======
>>>>>>> parent of b795644... bh
=======
>>>>>>> parent of 6467b6d... blak
=======
=======
>>>>>>> parent of 9960ec0... wgrge
>>>>>>> parent of 77391b4... Revert "ttt"
=======
>>>>>>> parent of 06b3989... jzj
=======
}
>>>>>>> parent of 91a52f5... napravljen feedback
