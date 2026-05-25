function slike(){
	var slik=["images/ba.jpg",
	"images/chuckolino.jpg",
	"images/mountain_tree_nature_winter_snow_sky_snowy_mountains-7836.jpg","images/WIN_20170103_10_27_47_Pro.jpg","images/WIN_20170426_13_38_04_Pro.jpg","images/6909249-black-hd-background.jpg",
	"images/18301979_1384627031575290_7206383306287674490_n.jpg","images/WIN_20170426_13_22_29_Pro.jpg","images/WIN_20170426_13_24_27_Pro.jpg",
	"images/WIN_20170426_13_39_20_Pro.jpg",
	"images/memes/chuck norris memes/chuckolino.jpg",
	"images/memes/Football memes/18057949_10212111405278934_6080971669455947764_n.jpg",
	"images/memes/ostalo/18664663_1505359669503586_224985544163196112_n.jpg",
	"images/memes/ostalo/18670880_524099894380583_1443801739610565269_n.jpg",
	"images/memes/san andreas memes/18119221_681126588746545_1681876964906422058_n.jpg",
	"images/memes/san andreas memes/18221644_106221769952415_8011258884316001155_n.jpg",
	"images/memes/san andreas memes/18301979_1384627031575290_7206383306287674490_n.jpg",
	"images/roštiljada/18622764_10210968533302832_2111868119_n.jpg",
	"images/roštiljada/18622823_10210968532542813_743119040_n.jpg",
	"images/roštiljada/18623156_10210968534742868_1904510961_n.jpg",
	"images/roštiljada/18624892_10210968533742843_1924789894_n.jpg",
	"images/roštiljada/18643757_10210968531542788_1977272717_n.jpg",
	"images/roštiljada/18644337_10210968533142828_1969009775_n.jpg",
	"images/dbpct/86a.jpg",
	"images/dbpct/2016-09-18 16.16.23.jpeg",
    "images/dbpct/11079677_10200253636939652_387281542_n.jpg",
	"images/dbpct/13112942_1764463570490980_818236879060971937_o.jpg",
	"images/dbpct/14659446_1016601081782863_7269140249064767488_n.jpg",
	"images/dbpct/16938603_1357861467608594_4503428314469121511_n.jpg",
	"images/dbpct/16939233_1357999100928164_5426498406180099947_n.jpg",
	"images/dbpct/16939333_123926584800391_2819842639021048634_n.jpg",
	"images/dbpct/17155176_1806036566387346_8870211222756424419_n.png",
	"images/dbpct/aktualnolight_elementi922slika3.jpg",
	"images/dbpct/FB_IMG_14948811687788262.jpg",
	"images/dbpct/FB_IMG_14981461726460784.jpg",
	"images/dbpct/FB_IMG_14981463342233258.jpg",
	"images/dbpct/FB_IMG_14981463418114436.jpg",
	"images/dbpct/FB_IMG_14981464357377926.jpg",
	"images/dbpct/FB_IMG_14981464607475376.jpg",
	"images/dbpct/FB_IMG_14981464716936861.jpg"
	];

var b=Math.floor(Math.random()*slik.length);
document.getElementById('s').innerHTML="<img src='"+slik[b]+"' alt='"+b+"'>";

}