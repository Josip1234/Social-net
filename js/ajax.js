// JavaScript Document
function pokaziteme(){
	var conn=new XMLHttpRequest();
	conn.onreadystatechange=function(){
		if(this.readyState === 4 && this.status === 200){
		
			document.getElementById("demo").innerHTML="Otvorena veza";
		}else{
			document.getElementById("demo").innerHTML="Zatvorena veza";
		}
	};
	conn.open("GET","dbconn.php",true);
	conn.send();
}