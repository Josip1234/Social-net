<?php 

if(!active('profile_log_search',$activePage)){
 
if(isset($_SESSION["searched"])){
    unset($_SESSION["searched"]);
}
 

}


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
     <?php if($_SESSION["user"]["accounttype"] === 1): ?>
    <link rel="stylesheet" href="assets/css/dropdown.css">
      <script src="assets/js/dropdown.js"></script>
       <?php endif; ?>
    <?php if (active('address/update',$activePage)): ?>
        <script src="assets/js/update_address.js"></script>
    <?php elseif (active('profile_log',$activePage) || active('profile_log_search',$activePage) || active('admin/database_logger',$activePage)): ?>
         <link rel="stylesheet" href="assets/css/table.css">
         <link rel="stylesheet" href="assets/css/pagination.css">
    <?php else: ?>
         <script src="assets/js/js.js"></script>
    <?php endif; ?>
</head>
<body>
    <header>
        <h1>Social network</h1>
        <nav>
<!--urls for all unregistered and not logged in users -->
<a href="index.php" class="<?= active('index',$activePage) ?>">Home page</a>
<!--urls for non logged in users -->
<?php if(!isset($_SESSION['user'])): ?>
<a href="index.php?page=register" class="<?= active('register',$activePage) ?>">Registration</a>
<a href="index.php?page=login" class="<?= active('login',$activePage) ?>">Login</a>
<?php else: ?>
<!-- Logout - all logged in users -->
 <a href="index.php?page=logout">Logout</a>
 
 <a href="index.php?page=users/profile" class="<?= active('users/profile',$activePage);    setcookie("selected","",1);
        setcookie("selectedCity","",1); ?>">User profile</a>
<!-- for admins -->
 <?php if($_SESSION["user"]["accounttype"] === 1): ?>
 <div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">User management</button>
  <div id="myDropdown" class="dropdown-content">
    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
    <a href="?page=profile_log&pag=1">Profile logs</a>
    <a href="?page=admin/database_logger">Database logger</a>
    <a href="#blog">Blog</a>
    <a href="#contact">Contact</a>
    <a href="#custom">Custom</a>
    <a href="#support">Support</a>
    <a href="#tools">Tools</a>
  </div>
</div>
   
 <?php endif; endif; ?>
        </nav>
        

    </header>