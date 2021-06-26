<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" media="all" type="text/css">
</head>
<body>
    <div class="con">
<nav>
    <a href="#" target="_blank">Registration</a>
    <a href="#" target="_blank">Login</a>
</nav>
    </div>
    <div class="pravila">
<section>
    <h2>Your feedback</h2>
    <form action="feedback.php" method="post">
        <label for="fname">Your first name:</label><br>
        <input type="text" name="fname" id="fname"><br>
        <label for="lname">Your last name:</label><br>
        <input type="text" name="lname" id="lname"><br>
        <label for="suggestions">Suggestions of improvement</label><br>
        <textarea name="suggestions" id="suggestions" cols="30" rows="10"></textarea> <br>
        <input type="submit" value="Send suggestion">
    </form>
</section>
    </div>
</body>
</html>