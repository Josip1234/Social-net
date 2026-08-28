// JavaScript Document
function hideDivs(){
	document.getElementById('Kreiraj').style.display="none";
	document.getElementById('teme').style.display="none";
	document.getElementById('podteme').style.display="none";
}
function displayNew(){
	document.getElementById('Kreiraj').style.display="inline";
}
function hideNew(){
	document.getElementById('Kreiraj').style.display="none";
}
function displayExist(){
	document.getElementById('teme').style.display="inline";
}
function hideTopics(){
	
	if(displaySubtopics()){
	  document.getElementById('podteme').style.display="none";
			document.getElementById('teme').style.display="none";
	}else if(!displaySubtopics()){
		document.getElementById('teme').style.display="none";
	}
}
function displaySubtopics(){
	document.getElementById('podteme').style.display="inline";
	return true;
}
function hideSubtopics(){
	document.getElementById('podteme').style.display="none";
}
