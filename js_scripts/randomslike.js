function slike(){
    var slik=["/Social-net/old_version/slike/chuckolino.jpg","slike/6909249-black-hd-background.jpg","slike/mountain_tree_nature_winter_snow_sky_snowy_mountains-7836.jpg","slike/WIN_20170426_13_38_04_Pro.jpg"];
    var b=Math.floor(Math.random()*slik.length);
    document.getElementById('s').innerHTML="<img src='"+slik[b]+"'></img>";
}