var auti=["slike/darkness2.JPG","slike/Dodge_gold  Wiper.JPG","slike/mclaren f1 niot.net (3).jpg","slike/wallpaper-mclaren-f1.jpg"];
var opis=["Lamborgini Murcielago","Dodge Viper GTS '98","Mclaren f1 '98","Pagani Zonda"];
var sportcars=["slike/Mitsubishi_Lancer_EVO_1024.jpg"];
var opis2=["Mitsubishi lancer EVO VII '00"];
function galer(val){
	var a="";
	if(val=="Supercars"){
		a+="<div class='row'>";
		for(var i=0;i<auti.length;i++){
			a+="<div class='column'>";
			a+="<img src='"+auti[i]+"' style='width:100%' onclick='openModal();currentSlide("+i+")' class='hover-shadow cursor'>";
			a+="</div>";
		}
		a+="</div>";
		a+="<div id='myModal' class='modal'>";
		a+="<span class='close cursor' onclick='closeModal()'>&times</span>";
		a+="<div class='modal-content'>";
		
		for(i=0;i<auti.length;i++){
			a+="<div class='mySlides'>";
			a+="<div class='numbertext'>";
			a+=i;
			a+="/";
			a+=auti.length;
			a+="</div>";
			a+="<img src='"+auti[i]+"' style='width:100%'>";
			a+="</div>";
		}
		a+="<a class='prev' onclick='plusSlides(-1)'>&#10094</a>";
		a+="<a class='next' onclick='plusSlides(1)'>&#10095</a>";
		
		a+="<div class='caption-container'>";
		a+="<p id='caption'></p>";
		a+="</div>";
		
		for(i=0;i<auti.length;i++){
		a+="<div class='column'>";
		a+="<img class='demo-cursor' src='"+auti[i]+"' style='width:100%' onclick='currentSlide("+i+")' alt='"+opis[i]+"'> ";
		a+="</div>";
		}
		a+="</div>";
		a+="</div>";
		
		document.getElementById("slike").innerHTML=a;
	}else if(val=="Sportscars"){
		a+="<div class='row'>";
		for(var i=0;i<sportcars.length;i++){
			a+="<div class='column'>";
			a+="<img src='"+sportcars[i]+"' style='width:100%' onclick='openModal();currentSlide("+i+")' class='hover-shadow cursor'>";
			a+="</div>";
		}
		a+="</div>";
		a+="<div id='myModal' class='modal'>";
		a+="<span class='close cursor' onclick='closeModal()'>&times</span>";
		a+="<div class='modal-content'>";
		
		for(i=0;i<sportcars.length;i++){
			a+="<div class='mySlides'>";
			a+="<div class='numbertext'>";
			a+=i;
			a+="/";
			a+=sportcars.length;
			a+="</div>";
			a+="<img src='"+sportcars[i]+"' style='width:100%'>";
			a+="</div>";
		}
		a+="<a class='prev' onclick='plusSlides(-1)'>&#10094</a>";
		a+="<a class='next' onclick='plusSlides(1)'>&#10095</a>";
		
		a+="<div class='caption-container'>";
		a+="<p id='caption'></p>";
		a+="</div>";
		
		for(i=0;i<sportcars.length;i++){
		a+="<div class='column'>";
		a+="<img class='demo-cursor' src='"+sportcars[i]+"' style='width:100%' onclick='currentSlide("+i+")' alt='"+opis2[i]+"'> ";
		a+="</div>";
		}
		a+="</div>";
		a+="</div>";
		
		document.getElementById("slike").innerHTML=a;
		
	}
}
function openModal(){
	document.getElementById("myModal").style.display="block";
	
}
function closeModal(){
	document.getElementById("myModal").style.display="none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}