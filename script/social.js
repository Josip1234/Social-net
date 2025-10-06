//funkcija koja će prikazati trenutno vrijeme i brojati će se dinamički
setInterval(ispisiVrijeme,0);
function ispisiVrijeme(){
  
   const d = new Date();
let text = d.toLocaleTimeString();
document.getElementById("trenutno_vrijeme").innerHTML = text;

}
