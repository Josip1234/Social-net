// JavaScript Document
function slike(){
	var slik=["slike/chuckolino.jpg"];

var b=Math.floor(Math.random()*slik.length);
document.getElementById('s').innerHTML="<img src='"+slik[b]+"'>";

}