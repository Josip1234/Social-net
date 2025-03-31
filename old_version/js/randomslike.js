function slike(){
    var slik=["slike/chuckolino.jpg","slike/6909249-black-hd-background.jpg","slike/mountain_tree_nature_winter_snow_sky_snowy_mountains-7836.jpg"];
    var b=Math.floor(Math.random()*slik.length);
    document.getElementById('s').innerHTML="<img src='"+slik[b]+"'>";
}