<?php 
include("templates/header_template.php");
create_header_template("test.php");
?>
<body>
<?php 
 
 $dbconn=new DatabaseConnection("localhost","root","","scn","utf8");
 $dbconn->connectToDatabase();
 $what_data_to_print=array("nav_name","nav_script_name","tag");
 create_navigation_template_from_database("test.php",$dbconn,Table_constant::TABLE_NAVIGATION,$what_data_to_print);
 $dbconn->close_database();

?>
</body>
</html>