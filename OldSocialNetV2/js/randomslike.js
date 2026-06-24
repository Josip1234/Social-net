// JavaScript Document

function slike(){var slik=["slike/1.jpg",
	"slike/3.jpg",
	"slike/6.jpg","slike/7.jpg"
];

var b=Math.floor(Math.random()*slik.length);
document.getElementById('s').innerHTML="<img src='"+slik[b]+"'>";
			
				
				}
	

