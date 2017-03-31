// JavaScript Document

function dohvati_kalendar(){
	var razmak = "";
    var tablica="<table>";
	var red="<tr>";
	var dat="<td>";
	 var ctablica="</table>";
	 var cred="</tr>";
	 var cdat="</td>";
	 
	 
	 razmak+=tablica;
	 razmak+=red;
	 for(var j=1;j<32;j++){
		
		 razmak+=dat;
		  razmak+=j;
		  razmak+=cdat;
		 if(j==10){
			 razmak+=cred;
			 razmak+=red;
		 }else if(j==20){
			 razmak+=cred;
			 razmak+=red;
		 }else if(j==30){
			 razmak+=cred;
			 razmak+=red;
		 }
	 }
	
	 
	
	 
	 razmak+=cred;
	 razmak+=ctablica;
		
    document.getElementById('calendar').innerHTML=razmak;
	
	
	
};



