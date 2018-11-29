// JavaScript Document
var eur=[7.156,7.258,7.356];
var ch=[5.642,5.861,6.061];
var us=[4.326,4.586,4.698];
	
var izabrana="";

function selected(izabrana){
	
	if(izabrana=="EUR"){
		
		document.getElementById("txt").innerHTML="<select id='sel' onChange='euro(this.value)'><option id=''></option><option id='Kupovni'>Kupovni</option><option id='Srednji'>Srednji</option><option id='Prodajni'>Prodajni</option></select>";
		
	
	}else if(izabrana=="CHF"){
		document.getElementById("txt").innerHTML="<select id='sel' onChange='franak(this.value)'><option id=''></option><option id='Kupovni'>Kupovni</option><option id='Srednji'>Srednji</option><option id='Prodajni'>Prodajni</option></select>";
		
	}else if(izabrana=="USD"){
		document.getElementById("txt").innerHTML="<select id='sel' onChange='dolar(this.value)'><option id=''></option><option id='Kupovni'>Kupovni</option><option id='Srednji'>Srednji</option><option id='Prodajni'>Prodajni</option></select>";
		
	}else{
		document.getElementById("txt").innerHTML="Currency does not exist";
		
	}
	
}
var eu="";
function euro(eu){
			if(eu==="Kupovni"){
				
				
				document.getElementById("txt").innerHTML="<label>Unesi broj eura:</label><input type='number' id='num' onChange='kupovnieur(this.value)'>";
				
			}else if(eu==="Srednji"){
				
				document.getElementById("txt").innerHTML="<label>Unesi broj eura:</label><input type='number' id='num' onChange='srednjieur(this.value)'>";				
				
			}else if(eu==="Prodajni"){
				
				document.getElementById("txt").innerHTML="<label>Unesi broj eura:</label><input type='number' id='num' onChange='prodajnieur(this.value)'>";
			    
			}else{
				document.getElementById("txt").innerHTML="Invalid";
			}
		}

function kupovnieur(br){
	document.getElementById("txt").innerHTML=br*eur[0];
	
}

function srednjieur(br){
	document.getElementById("txt").innerHTML=br*eur[1];
}
function prodajnieur(br){
	document.getElementById("txt").innerHTML=br*eur[2];
}

var chf="";
function franak(chf){
	if(chf==="Kupovni"){
		document.getElementById("txt").innerHTML="<label>Unesi broj švicarskog franka:</label><input type='number' id='num' onChange='kupovnichf(this.value)'>"; 
		
	}else if(chf==="Srednji"){
		     document.getElementById("txt").innerHTML="<label>Unesi broj švicarskog franka:</label><input type='number' id='num' onChange='srednjichf(this.value)'>";
			    
		
	}else if(chf==="Prodajni"){
		     document.getElementById("txt").innerHTML="<label>Unesi broj švicarskog franka:</label><input type='number' id='num' onChange='prodajnichf(this.value)'>";
			    
	}
}
function kupovnichf(br){
   document.getElementById("txt").innerHTML=br * ch[0];
}
function srednjichf(br){
	document.getElementById("txt").innerHTML=br * ch[1];
	
}
function prodajnichf(br){
	document.getElementById("txt").innerHTML=br * ch[2];
	
}


var d="";
function dolar(d){
	if(d==="Kupovni"){
		document.getElementById("txt").innerHTML="<label>Unesi broj američkog dolara:</label><input type='number' id='num' onChange='kupovnidol(this.value)'>"; 
		
	}else if(d==="Srednji"){
		     document.getElementById("txt").innerHTML="<label>Unesi broj američkog dolara:</label><input type='number' id='num' onChange='srednjidol(this.value)'>";
			    
		
	}else if(d==="Prodajni"){
		     document.getElementById("txt").innerHTML="<label>Unesi broj američkog dolara:</label><input type='number' id='num' onChange='prodajnidol(this.value)'>";
			    
	}
};

function kupovnidol(br){
   document.getElementById("txt").innerHTML=br * us[0];
};
function srednjidol(br){
	document.getElementById("txt").innerHTML=br * us[1];
	
};
function prodajnidol(br){
	document.getElementById("txt").innerHTML=br * us[2];
	
};

