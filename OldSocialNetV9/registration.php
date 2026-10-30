<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css">
</head>
<body>
    <div class="con">
        <nav>
            <a href="#" target="_blank" rel="noopener noreferrer">Registration</a>
            <a href="#" target="_blank" rel="noopener noreferrer">Login</a>
        </nav>
        <div class="rules">
            <section>
                <h2>Register here</h2>
                <form action="registration.php" method="post">
                    <label for="fname">First name:</label> <br>
                     <input type="text" name="fname" id="fname" autocomplete="off" maxlength="50" size="17" required> <br>
                     <label for="lname">Last name:</label> <br>
                     <input type="text" name="lname" id="lname" autocomplete="off" maxlength="50" size="17" required> <br>
                     <label for="sex">Sex</label> <br>
                     <input type="radio" name="sex" id="sex" value="m" required>Male 
                     <input type="radio" name="sex" id="sex" value="f" required>Female <br>
                     <label for="dateofbirth">Date of birth:</label> <br>
                     <input type="date" name="dateofbirth" id="dateofbirth" required> <br>
                     <label for="cityofbirth">City of birth:</label> <br>
                     <input type="text" name="cityofbirth" id="cityofbirth" maxlength="50" size="17" autocomplete="off" required> <br>
                     <label for="countryofbirth">Country of birth:</label> <br>
                     <input type="text" name="countryofbirth" id="countryofbirth" maxlength="50" size="17" autocomplete="off" required> <br>
                     <label for="pass">Password:</label> <br>
                     <input type="text" name="pass" id="pass" maxlength="50" size="17" required autocomplete="off"> <br>
                     <label for="profilepicture">Profile picture:</label> <br>
                     <input type="file" name="profilepicture" id="profilepicture"> <br>
                     <br>
                     <input type="submit" value="Register">
                </form>
            </section>

        </div>
    </div>
</body>
</html>