// JavaScript Document
var eur=[7.156,7.258,7.356];
var chf=[5.642,5.861,6.061];
var usd=[4.326,4.586,4.698];
	
var izabrana="";

function selected(izabrana){
	
	if(izabrana=="EUR"){
		document.getElementById("txt").innerHTML="<select id='sel' onChange='euro(this.value)'><option id=''></option><option id='Kupovni'>Kupovni</option><option id='Srednji'>Srednji</option><option id='Prodajni'>Prodajni</option></select>";
		
	
	}else if(izabrana=="CHF"){
		
		
	}else if(izabrana=="USD"){
		
		
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
