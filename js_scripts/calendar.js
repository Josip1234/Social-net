//kalendar u obliku odlomka
function dohvati_kalendar(){
    var zarezi="";
    var novired="<br>";
    var dani=[];
    var number=1;
    var max_number=32;
    for(;number<max_number;number+=1){
        dani[number]=number;
        if(number==10){
            zarezi+=novired;
        }else if(number==20){
            zarezi+=novired;
        }else if(number==30){
            dani[number]=number;
            zarezi+=novired;
        }
        zarezi+=dani[number]+"&emsp;";
    };
    document.getElementById('calendar').innerHTML=zarezi;
}
//kalendar u obliku tablice za treći mjesec
function dohvati_kalendar_nova_verzija(){
   var razmak=" ";
   var tablica="<h2>Calendar For March 2025</h2><table>";
   var red="<tr>";
   var dat="<td>";
   var ctablica="</tablica>";
   var cred="</tr> ";
   var cdat="</td> ";
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
document.getElementById('calendar').style.width='50%';
document.getElementById('calendar').style.height='100%';
document.getElementById('calendar').style.overflow='auto';
}