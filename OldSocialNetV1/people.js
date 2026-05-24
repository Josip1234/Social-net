// JavaScript Document
var pictures=["images/005.jpeg","images/6pgqmj7.jpg","images/007.jpeg","images/013.jpeg","images/029.jpeg","images/71psjtt.jpg","images/078.jpeg","images/85v04g8.jpg","images/478267700_7b6cd46a52_o.jpg","images/BIOTR.jpg",
"images/fhtt.jpg","images/hkgm.jpg","images/Linuxgirl2.jpg","images/mya_wallpapers_24.jpg","images/naked-ferrari-woman-2.jpg","images/naomi campbell.jpg","images/preuzmi.jpg","images/sh.jpg","images/SS-1.jpg","images/vicky_xdib2ip4.jpg","images/wallpapers-33.jpg"
];
var desc=[
	"Adrianna Lima","Sexy model in a dress","Sexy model sitting at the door","Sexy model in heels","Model in red dress and high heels","Shina Shetty","Model in black dress","Half naked model","Busty model in underwear","Model 's butt","Busty female model","Women in white","Linux girl","Motorbike model","Naked Ferrari women","Naomi Campbell","Half Naked Women","Half naked girl","Half naked girls in high heels","Vicky","Sexy girl model in bathing suit"
];
var actress=["images/8e91rnq.jpg","images/Beckinsale_by_CharsiBevda.jpg","images/559361-1024x768-Electra_Carmen028.jpg",
	"images/girl_kelly_hu002.jpg","images/kate-beckinsale22.jpg","images/kate-beckinsale24.jpg","images/kate-beckinsale30.jpg"
];
var desc2=[
	"Carmen Electra","Kate Beckinsale","Carmen Electra in gold","Kelly Hu","Kate Beckinsale 2","Kate Beckinsale 3","Kate Beckinsale 4"
];

var pjevacice=["images/christina_aguilera_wallpapers_011.jpg"];
var desc3=["Christina Aguilera"];

var animated=["images/cleavenger29.jpg"];
var desc4=["Animated women"];


var dancers=["images/img_3952ss.jpg","images/img_3954ss.jpg","images/img_3965ss.jpg","images/img_3966.jpg","images/img_3969.jpg","images/img_3996ss.jpg","images/img_4000ss.jpg","images/mazoretkinje1104yk.jpg","images/mazoretkinje1116et.jpg"];
var desc5=["Zagreb 's Majorettes","Zagreb 's Majorettes","Face","Face2","Showing off","Posing","Eating","Osijek 's majorettes prepare","Trophy give away"];


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
		
	}else if(id=="Female Dancers"){
		var m="";
		m+="<section><h2>Female Dancers</h2>";
		for(var ma=0;ma<8;ma++){
			m+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+dancers[ma]+"'><img src='"+dancers[ma]+"' width='300' height='200'></a><div class='desc'><b>Figure"+ma+"</b>"+desc5[ma]+"</div></div></div>";
		}
		m+="<div id='clearfix'></div>";
		m+="<input type='button' id='2' value='2' onClick='novam(this.value)'>";
		document.getElementById("1").innerHTML=m+"</section>";
	}
}
function nova(stranica){
	var zadnji_element=8;
	var a="";
	a+="<section><h2>Beautifull female models</h2>";
	for(var i=zadnji_element;i<16;i++){
		a+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pictures[i]+"'><img src='"+pictures[i]+"' alt='"+desc[i]+"' width='300' height='200'></a><div class='desc'><b>Figure"+i+".</b>"+desc[i]+"</div></div></div>";
		
		}
		a+="<div id='clearfix'></div>";
	a+="<input type='button' id='3' value='3' onClick='nova3(this.value)'>";
	document.getElementById("1").innerHTML=a+"</section>";
}
function nova3(stranica){
	var zadnji_element=16;
	var a="";
	a+="<section><h2>Beautifull female models</h2>";
	for(var i=zadnji_element;i<pictures.length;i++){
		a+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+pictures[i]+"'><img src='"+pictures[i]+"' alt='"+desc[i]+"' width='300' height='200'></a><div class='desc'><b>Figure"+i+".</b>"+desc[i]+"</div></div></div>";
		
		}
		a+="<div id='clearfix'></div>";
	
	document.getElementById("1").innerHTML=a+"</section>";
}

function novam(stranica){
	var zadnji_element=8;
	var m="";
	m+="<section><h2>Female Dancers</h2>";
	for(var i=zadnji_element;i<dancers.length;i++){
		m+="<div class='responsive'><div class='gallery'><a target='_blank' href='"+dancers[i]+"'><img src='"+dancers[i]+"' alt='"+desc5[i]+"' width='300' height='200'></a><div class='desc'><b>Figure"+i+".</b>"+desc5[i]+"</div></div></div>";
		
		}
		m+="<div id='clearfix'></div>";
	document.getElementById("1").innerHTML=m+"</section>";
}