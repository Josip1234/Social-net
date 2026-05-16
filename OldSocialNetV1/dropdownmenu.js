var ftime=100;
var ctime=0;
var val=0;
function openmenu(id){
	menucanceltime();
	if(val) val.style.visibility='hidden';
	val=document.getElementById(id);
	val.style.visibility='visible';
}
function menuclose(){
	if(val) val.style.visibility='hidden';
}
function menuclosetime(){
	 ctime=window.setTimeout(menuclose,ftime);
}
function menucanceltime(){
	if(ctime){
		window.clearTimeout(ctime);
		ctime=null;
	}
}
document.onclick=menuclose;