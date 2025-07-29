<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php file for function testing</title>
</head>
<body>
    <?php 
 echo "This is a php file for function testing.<br>";
 include("classes/files_and_directories.php");
 include("classes/files.php");
 include("classes/constant_arrays.php");
 //with this we will create new file if does not exists
 //we will use function create file if not exists from file class
 $file = new File("test/","test.php");
 $arrays=new Cnst_array();
 $file->setDirectoryName("test");
 $file->create_new_files_if_exists($arrays->getPhpScripts());
?>
</body>
</html>