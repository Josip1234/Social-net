//this function will load selected values into select choice after cookies 
//has been set
window.onload=function(){
    document.getElementById("state").selectedIndex=localStorage.getItem("selected");
    document.getElementById("city").selectedIndex=localStorage.getItem("selectedCity");
}

//show form hide checbox and label checkbox
function showForm(){
     document.getElementById("form").className="enabled";

     document.getElementById("ia").className="disabled";
     document.getElementById("pi").className="disabled";
     addInputFieldValidation();
   
}
//add input field if checkbox has been checked to show address input
//enable hidden span field also
//replace hidden span with hidden field
function addInputFieldValidation(){
      document.getElementById("hidden").className="enabled";
      $hidden='<input type="hidden" name="includeAddress" value="yes"></input>';
        document.getElementById("hidden").outerHTML=$hidden;
     
     
}
//function for getting selected value from select choice of state
function showSelected(){
     var s = document.getElementById("state");
var selNum = s.options[s.selectedIndex].value;
//create cookie to tell php that what value has been selected
createCookie("selected", selNum);
 //reloads current url
 var selected=document.getElementById("state").value;
 localStorage.setItem("selected",selected);
 location.reload();

 //showForm();
 //new solution we will append selected value to url
 //var oldUrl=window.location;
 //var newUrl=oldUrl+"?selected="+selNum;

//window.location=newUrl;           
}
//this function will refresh page and create city cookie
function showSelectedCity(){
         var s = document.getElementById("city");
var selNumCit = s.options[s.selectedIndex].value;
//create cookie to tell php that what value has been selected
createCookie("selectedCity", selNumCit);
 //reloads current url
 var selected=document.getElementById("city").value;
 localStorage.setItem("selectedCity",selected);
 location.reload();
}

// Function to create the cookie 
function createCookie(name, value, days) {
    let expires;

    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }

    document.cookie = name + "=" +
        value + expires + "; path=Social-net/Web_application/public/index.php?page=register";
}


    
