// JavaScript Document
var pictures=["images/005.jpeg","images/6pgqmj7.jpg","images/007.jpeg","images/013.jpeg","images/029.jpeg","images/71psjtt.jpg","images/078.jpeg","images/85v04g8.jpg","images/478267700_7b6cd46a52_o.jpg","images/BIOTR.jpg"];
var desc=["Adrianna Lima","Sexy model in a dress","Sexy model sitting at the door","Sexy model in heels","Model in red dress and high heels","Shina Shetty","Model in black dress","Half naked model","Busty model in underwear","Model 's butt"];
var actress=["images/8e91rnq.jpg","images/Beckinsale_by_CharsiBevda.jpg","images/559361-1024x768-Electra_Carmen028.jpg"];
var desc2=["Carmen Electra","Kate Beckinsale","Carmen Electra in gold"];

var pjevacice=["images/christina_aguilera_wallpapers_011.jpg"];
var desc3=["Christina Aguilera"];

var animated=["images/cleavenger29.jpg"];
var desc4=["Animated women"];

function select(id){
	var a="";
	a+="<section><h2>Beautifull female models</h2>";
	if(id=="Female models"){
		for(var i=0;i<8;i++){
		a+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pictures[i]+"'><img src='"+pictures[i]+"' alt='"+desc[i]+"' width='300' height='200'></a><div class='desc'><b>Figure"+i+".</b>"+desc[i]+"</div></div></div>";
		
		}
		a+="<div id='clearfix'></div>";
		a+="<input type='button' id='2' value='2' onClick='nova(this.value)'>";
		document.getElementById("1").innerHTML=a+"</section>";
	}else if(id=="Female Actress"){
		var b="";
		b+="<section><h2>Female actress</h2>";
		for(var j=0;j<actress.length;j++){
		b+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+actress[j]+"'><img src='"+actress[j]+"' alt='"+desc2[j]+"' width='300' height='200'></a><div class='desc'><b>Figure"+j+".</b>"+desc2[j]+"</div></div></div>";
		
		}
		b+="<div id='clearfix'></div>";
		document.getElementById("1").innerHTML=b+"</section>";
	}else if(id=="Female Singers"){
		var c="";
		c+="<section><h2>Female Singers</h2>";
		for(var o=0;o<pjevacice.length;o++){
			c+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pjevacice[o]+"'><img src='"+pjevacice[o]+"' width='300' height='200'></a><div class='desc'><b>Figure"+o+"</b>"+desc3[o]+"</div></div></div>";
		}
		c+="<div id='clearfix'></div>";
		document.getElementById("1").innerHTML=c+"</section>";
	}else if(id=="Animated people"){
		var d="";
		d+="<section><h2>Animated people</h2>";
		for(var p=0;p<animated.length;p++){
			d+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+animated[p]+"'><img src='"+animated[p]+"' width='300' height='200'></a><div class='desc'><b>Figure"+p+"</b>"+desc4[p]+"</div></div></div>";
		}
		d+="<div id='clearfix'></div>";
		document.getElementById("1").innerHTML=d+"</section>";
		
	}
}
function nova(stranica){
	var zadnji_element=8;
	var a="";
	a+="<section><h2>Beautifull female models</h2>";
	for(var i=zadnji_element;i<pictures.length;i++){
		a+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pictures[i]+"'><img src='"+pictures[i]+"' alt='"+desc[i]+"' width='300' height='200'></a><div class='desc'><b>Figure"+i+".</b>"+desc[i]+"</div></div></div>";
		
		}
		a+="<div id='clearfix'></div>";
	document.getElementById("1").innerHTML=a+"</section>";
}