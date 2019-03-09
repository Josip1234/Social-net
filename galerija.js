// JavaScript Document

function getSLike(){var linkovi=["slike/ba.JPG","slike/chuckolino.jpg","slike/mountain_tree_nature_winter_snow_sky_snowy_mountains-7836.jpg","slike/WIN_20170426_13_22_29_Pro.jpg","slike/WIN_20170426_13_24_27_Pro.jpg","slike/WIN_20170426_13_39_20_Pro.jpg"];

var vel=linkovi.length-1;
var otvori_odlomak="<p>";
var zatvori_odlomak="</p>";
var link="";
var ln="<a href='";
var ln2="' target='_blank'>";
var ln3="<img src=";
var ln4="'";
var ln5="width='200' height='200'>";
var ln6="</a>";
link+=otvori_odlomak;	
					
					do{
	
	link+=ln+linkovi[vel]+ln2+ln3+ln4+linkovi[vel]+ln4+ln5+ln6;
	
	
	
	
	
	
	vel--;

	}while(vel>=0);
link+=zatvori_odlomak;

document.getElementById("slika").innerHTML=link;

				   }

