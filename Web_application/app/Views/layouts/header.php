<?php 
function active(string $page,string $current):string{
    return $page === $current ? 'activelink':'';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social-net</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Social network</h1>
        <nav>
<!--urls for all unregistered and not logged in users -->
<a href="index.php" class="<?= active('index',$activePage) ?>">Home page</a>
<!--urls for non logged in users -->
<a href="index.php?page=register" class="<?= active('register',$activePage) ?>">Registration</a>
<a href="index.php?page=login" class="<?= active('login',$activePage) ?>">Login</a>
        </nav>
        

    </header>