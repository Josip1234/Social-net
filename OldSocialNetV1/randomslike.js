function slike(){
	var slik=["images/chuckolino.jpg"];

var b=Math.floor(Math.random()*slik.length);
document.getElementById('s').innerHTML="<img src='"+slik[b]+"' alt='"+b+"'>";

}