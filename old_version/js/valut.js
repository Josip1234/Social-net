var izabrana="";
function selected(izabrana){
    if(izabrana=="EUR"){
        document.getElementById("txt").innerHTML="<label>Unesi broj eura:</label><input type='number' id='eur'>";
        document.getElementById("tecaj").innerHTML="<label>Odaberite kupovnu, prodajnu ili srednju vrijednost:</label><select id='vrijednost' onChange='odabrane(this.value)'><option value=''></option><option value='kupovna'>Kupovni</option><option value='srednji'>Srednji</option><option value='prodajni'>Prodajni</option></select>";
    }else if(izabrana=="CHF"){
                document.getElementById("txt").innerHTML="<label>Unesi broj švicarskog franka:</label><input type='number' id='chf'>";
        document.getElementById("tecaj").innerHTML="<label>Odaberite kupovnu, prodajnu ili srednju vrijednost:</label><select id='vrijednost' onChange='odabrane(this.value)'><option value=''></option><option value='kupovna'>Kupovni</option><option value='srednji'>Srednji</option><option value='prodajni'>Prodajni</option></select>";

    }else if(izabrana=="USD"){
                document.getElementById("txt").innerHTML="<label>Unesi broj američkog dolara:</label><input type='number' id='usd'>";
        document.getElementById("tecaj").innerHTML="<label>Odaberite kupovnu, prodajnu ili srednju vrijednost:</label><select id='vrijednost' onChange='odabrane(this.value)'><option value=''></option><option value='kupovna'>Kupovni</option><option value='srednji'>Srednji</option><option value='prodajni'>Prodajni</option></select>";

    }else{
        document.getElementById("txt").innerHTML="Currency does not exists.";
    }
}
var odabir="";
function odabrane(odabir){
    if(odabir=="kupovna"){
        document.getElementById("res").innerHTML="Odabran je kupovni tečaj.";
    }else if(odabir=="srednji"){
        document.getElementById("res").innerHTML="Odabran je srednji tečaj.";
    }else if(odabir=="prodajni"){
        document.getElementById("res").innerHTML="Odabran je prodajni tečaj.";
    }else{
        document.getElementById("res").innerHTML="Nije odabrano";

    }
}