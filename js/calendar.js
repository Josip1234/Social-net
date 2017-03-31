// JavaScript Document

function dohvati_kalendar(){
	var zarezi="";
	var novired="<br/>";
	var dani=[];
	var number=1;
	var max_number=32;
	for(;number<max_number;number+=1){
		dani[number]=number;
	    if(number==10){
			
			zarezi+=novired;
			
			
		}
		if(number==20){
			
			zarezi+=novired;
			
		}
		if(number==30){
			dani[number]=number;
			zarezi+=novired;
			
		}
		
		zarezi+=dani[number]+"&emsp;";
		
		
		
		
		
		
	};
    document.getElementById('calendar').innerHTML=zarezi;
	
};

