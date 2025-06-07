<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet forum - popis tema</title>
    <script src="js/ajax.js"></script>
</head>
<body onload="dohvati_odgovore()">
    <?php 
include("dbconn.php");
echo "<table><thead><tr><th><b>Broj teme</b></th><th>Naziv teme</th></tr></thead>";
$sql="SELECT id, email, naziv_teme FROM teme";
$query=mysqli_query($dbc,$sql);
echo "<tbody>";
while($result=mysqli_fetch_array($query)){
    echo "<tr>";
    echo "<td>".$result['id']."</td><td>".$result['naziv_teme']."</td>";
    echo "<tr>";
}
echo "</tbody></table>";

?>
<div id="txt"></div>
</body>
</html>