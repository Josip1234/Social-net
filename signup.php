<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social net - sign up</title>
</head>
<body>
    <form action="signup.php" method="post">
        <input type="text" name="name" id="name" placeholder="Enter first name:">
        <input type="text" name="lname" id="lname" placeholder="Enter last name:">
        <label for="birth">Enter your date of birth</label>
        <input type="date" name="birth" id="birth">
        <input type="email" name="email" id="email" placeholder="Enter your email:">
        <input type="radio" name="sex" id="male" value="Male"> <label for="Male">Male</label>
        <input type="radio" name="sex" id="female" value="Female"> <label for="Female">Female</label>
        <input type="password" name="password" id="password" placeholder="Enter your password:">
        <input type="password" name="cpassword" id="cpassword" placeholder="Confirm password:">
        <input type="submit" value="Sign up">
    </form>
</body>
</html>