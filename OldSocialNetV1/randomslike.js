function slike(){
	var slik=["images/chuckolino.jpg","images/6909249-black-hd-background.jpg","images/mountain_tree_nature_winter_snow_sky_snowy_mountains-7836.jpg",
		"images/WIN_20170103_10_27_47_Pro.jpg"
	];

var b=Math.floor(Math.random()*slik.length);
document.getElementById('s').innerHTML="<img src='"+slik[b]+"' alt='"+b+"'>";

}