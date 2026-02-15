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
