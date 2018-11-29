// JavaScript Document
<<<<<<< HEAD
<<<<<<< HEAD
var pictures=["slike/005.jpeg","slike/6pgqmj7.jpg","slike/007.jpeg","slike/013.jpeg","slike/029.jpeg","slike/71psjtt.jpg","slike/078.jpeg","slike/85v04g8.jpg","slike/478267700_7b6cd46a52_o.jpg","slike/BIOTR.jpg","slike/fhtt.jpg","slike/hkgm.jpg","slike/Linuxgirl2.jpg","slike/mya_wallpapers_24.jpg","slike/naked-ferrari-woman-2.jpg","slike/naomi campbell.jpg","slike/preuzmi.jpg","slike/sh.jpg","slike/SS-1.jpg","slike/wallpapers-33.jpg","slike/vicky_xdib2ip4.jpg"];

var desc=["Adrianna Lima","Sexy model in a dress","Sexy model sitting at the door","Sexy model in heels","Model in red dress and high heels","Shina Shetty","Model in black dress","Half naked model","Busty model in underwear","Model 's butt","Busty female model","Women in white","Linux girl","Motorbike model","Naked Ferrari women","Naomi Campbell","Half Naked Women","Half naked girl","Half naked girls in high heels","Sexy girl model in bathing suit","Vicky"];

var actress=["slike/8e91rnq.jpg","slike/Beckinsale_by_CharsiBevda.jpg","slike/559361-1024x768-Electra_Carmen028.jpg","slike/girl_kelly_hu002.jpg","slike/kate-beckinsale22.jpg","slike/kate-beckinsale24.jpg","slike/kate-beckinsale30.jpg"];
var desc2=["Carmen Electra","Kate Beckinsale","Carmen Electra in gold","Kelly Hu","Kate Beckinsale 2","Kate Beckinsale 3","Kate Beckinsale 4"];
=======
=======
>>>>>>> parent of e0e0777... napravljene galerije
var pictures=["slike/005.jpeg","slike/6pgqmj7.jpg","slike/007.jpeg","slike/013.jpeg","slike/029.jpeg","slike/71psjtt.jpg","slike/078.jpeg","slike/85v04g8.jpg","slike/478267700_7b6cd46a52_o.jpg","slike/BIOTR.jpg"];
var desc=["Adrianna Lima","Sexy model in a dress","Sexy model sitting at the door","Sexy model in heels","Model in red dress and high heels","Shina Shetty","Model in black dress","Half naked model","Busty model in underwear","Model 's butt"];
var actress=["slike/8e91rnq.jpg","slike/Beckinsale_by_CharsiBevda.jpg","slike/559361-1024x768-Electra_Carmen028.jpg"];
var desc2=["Carmen Electra","Kate Beckinsale","Carmen Electra in gold"];
<<<<<<< HEAD
>>>>>>> parent of e0e0777... napravljene galerije
=======
>>>>>>> parent of e0e0777... napravljene galerije

var pjevacice=["slike/christina_aguilera_wallpapers_011.jpg"];
var desc3=["Christina Aguilera"];

var animated=["slike/cleavenger29.jpg"];
var desc4=["Animated women"];

function select(id){
	var a="";
	/*a+="<h2>Beautifull female models</h2>";*/
	if(id=="Female models"){
		for(var i=0;i<8;i++){
		a+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pictures[i]+"'><img src='"+pictures[i]+"' alt='"+desc[i]+"' width='30%' height='20%'></a><div class='desc'><b>Figure"+i+".</b>"+desc[i]+"</div></div></div>";
		
		}
		a+="<div id='clearfix'></div>";
		a+="<input type='button' id='2' value='2' onClick='nova(this.value)'>";
		document.getElementById("1").innerHTML=a;
	}else if(id=="Female Actress"){
		var b="";
		/*b+="<h2>Female actress</h2>";*/
		for(var j=0;j<actress.length;j++){
		b+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+actress[j]+"'><img src='"+actress[j]+"' alt='"+desc2[j]+"' width='30%' height='20%'></a><div class='desc'><b>Figure"+j+".</b>"+desc2[j]+"</div></div></div>";
		
		}
		b+="<div id='clearfix'></div>";
		document.getElementById("1").innerHTML=b;
	}else if(id=="Female Singers"){
		var c="";
		c+="<h2>Female Singers</h2>";
		for(var o=0;o<pjevacice.length;o++){
			c+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pjevacice[o]+"'><img src='"+pjevacice[o]+"' width='30%' height='20%'></a><div class='desc'><b>Figure"+o+"</b>"+desc3[o]+"</div></div></div>";
		}
		c+="<div id='clearfix'></div>";
		document.getElementById("1").innerHTML=c;
	}else if(id=="Animated people"){
		var d="";
		/*d+="<h2>Animated people</h2>";*/
		for(var p=0;p<animated.length;p++){
			d+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+animated[p]+"'><img src='"+animated[p]+"' width='30%' height='20%'></a><div class='desc'><b>Figure"+p+"</b>"+desc4[p]+"</div></div></div>";
		}
		d+="<div id='clearfix'></div>";
		document.getElementById("1").innerHTML=d;
		
<<<<<<< HEAD
<<<<<<< HEAD
	}else if(id=="Female Dancers"){
		var m="";
		/*m+="<h2>Female Dancers</h2>";*/
		for(var ma=0;ma<8;ma++){
			m+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+dancers[ma]+"'><img src='"+dancers[ma]+"' width='30%' height='20%'></a><div class='desc'><b>Figure"+ma+"</b>"+desc5[ma]+"</div></div></div>";
		}
		m+="<div id='clearfix'></div>";
		m+="<input type='button' id='2' value='2' onClick='novam(this.value)'>";
		document.getElementById("1").innerHTML=m;
=======
>>>>>>> parent of e0e0777... napravljene galerije
=======
>>>>>>> parent of e0e0777... napravljene galerije
	}
}
function nova(stranica){
	var zadnji_element=8;
	var a="";
<<<<<<< HEAD
<<<<<<< HEAD
	/*a+="<h2>Beautifull female models</h2>";*/
	for(var i=zadnji_element;i<16;i++){
		a+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pictures[i]+"'><img src='"+pictures[i]+"' alt='"+desc[i]+"' width='30%' height='30%'></a><div class='desc'><b>Figure"+i+".</b>"+desc[i]+"</div></div></div>";
		
		}
		a+="<div id='clearfix'></div>";
	a+="<input type='button' id='3' value='3' onClick='nova3(this.value)'>";
	document.getElementById("1").innerHTML=a;
}
function nova3(stranica){
	var zadnji_element=16;
	var a="";
	/*a+="<h2>Beautifull female models</h2>";*/
=======
	a+="<section><h2>Beautifull female models</h2>";
>>>>>>> parent of e0e0777... napravljene galerije
=======
	a+="<section><h2>Beautifull female models</h2>";
>>>>>>> parent of e0e0777... napravljene galerije
	for(var i=zadnji_element;i<pictures.length;i++){
		a+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pictures[i]+"'><img src='"+pictures[i]+"' alt='"+desc[i]+"' width='30%' height='30%'></a><div class='desc'><b>Figure"+i+".</b>"+desc[i]+"</div></div></div>";
		
		}
		a+="<div id='clearfix'></div>";
<<<<<<< HEAD
<<<<<<< HEAD
	
	document.getElementById("1").innerHTML=a;

}

function novam(stranica){
	var zadnji_element=8;
	var m="";
	/*m+="<h2>Female Dancers</h2>";*/
	for(var i=zadnji_element;i<dancers.length;i++){
		m+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+dancers[i]+"'><img src='"+dancers[i]+"' alt='"+desc5[i]+"' width='30%' height='20%'></a><div class='desc'><b>Figure"+i+".</b>"+desc5[i]+"</div></div></div>";
		
		}
		m+="<div id='clearfix'></div>";
	document.getElementById("1").innerHTML=m;
	
}
=======
	document.getElementById("1").innerHTML=a+"</section>";
}
>>>>>>> parent of e0e0777... napravljene galerije
=======
	document.getElementById("1").innerHTML=a+"</section>";
}
>>>>>>> parent of e0e0777... napravljene galerije
