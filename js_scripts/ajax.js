function pokaziteme(){
    var conn=new XMLHttpRequest();
    conn.onreadystatechange=function(){
        if(this.readyState == 4 && this.status === 200){
            document.getElementById("demo").innerHTML="Otvorena veza";
        }else{
            document.getElementById("demo").innerHTML="Zatvorena veza";
        }
    };
    conn.open("GET","dbconn.php",true);
    conn.send();
}

function pokazitemu(str){
    if(str==""){
        document.getElementById("txtHint").innerHTML="";
        return;
    }else{
        if(window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
        }else{
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("txtHint").innerHTML=this.responseText;
            }
        };
        xmlhttp.open("GET","ispis_tema.php",true);
        xmlhttp.send();
    }
}

function dohvati_odgovore(){
    var xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            document.getElementById("txt").innerHTML=this.responseText;
        }
    };
    xhttp.open("GET","odgovori.php",true);
    xhttp.send();
}