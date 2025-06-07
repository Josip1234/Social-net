<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odgovori na teme</title>
</head>
<body>
    <?php 
include("dbconn.php");
$sql="SELECT email, datum_i_vrijeme_komentara, komentar FROM komentari";
$result=mysqli_query($dbc,$sql);
echo "<table><thead>";
echo "<tr><th>Email</th>";
echo "<th>Date and time</th>";
echo "<th>Comment</th></tr></thead>";
echo "<tbody>";
while($row=mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['datum_i_vrijeme_komentara']."</td>";
    echo "<td>".$row['komentar']."</td></tr>";
}
echo "</tbody>";
echo "</table>";
mysqli_close($dbc);




?>
</body>
</html>