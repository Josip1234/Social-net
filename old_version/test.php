<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetna skripta</title>
    <link rel="stylesheet" href="css/float_layout_css.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <script src="js/social.js"></script>
    <script src="js/calendar.js"></script>
    <script src="js/dropdownmenu.js"></script>
    <script src="js/random.js"></script>
</head>
<body onmouseover="prikazi_datum(), dohvati_kalendar_nova_verzija()" onload="slike()">
    <?php 
    session_start();
      include "functions.php";
      echo dohvati_listu_slika_iz_direktorija();
      print_image_profile_history($_SESSION['username']);
  
    ?>
    <h2>CSS Layout Float</h2>
<p>In this example, we have created a header, two columns/boxes and a footer. On smaller screens, the columns will stack on top of each other.</p>
<p>Resize the browser window to see the responsive effect (you will learn more about this in our next chapter - HTML Responsive.)</p>

<nav>  
<div class="dropdown">
    <button class="dropbtn">Profil</button>
    <div class="dropdown-content">
        <a href="registration.php">Registation</a>
        <a href="profile.php">Profile of user</a>
        <a href="terminirajprofil.php">Delete profile</a>
<a href="profilna.php" style="font-size: 10px;">Add profile picture</a>
<a href="update_profilne.php" style="font-size: 10px;">Update profile picture</a>
<a href="login.php" target="_blank">Login</a>
<a href="logout.php" target="_blank">Logout</a>

    </div>
  </div>

  <div class="dropdown">
    <button class="dropbtn">Privacy, feedbacks</button>
    <div class="dropdown-content">
        <a href="privacy.php" target="_blank" style="font-size: 12px;">Terms of privacy</a>
         
        <a href="feedback.php" target="_blank">Add feedback</a>

    </div>
  </div>


  <div class="dropdown">
    <button class="dropbtn">Forumi,chatovi, početna</button>
    <div class="dropdown-content">
    <a href="forum.php" target="_blank" rel="noopener noreferrer">Forum</a>
    <a href="index.html" target="_blank" rel="noopener noreferrer">Back to home page</a>
  
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Photos</button>
    <div class="dropdown-content">
    <a href="print_profile_history.php" target="_blank" rel="noopener noreferrer">Print profile history images</a>
    </div>
  </div>
</nav>


<header>
  <h2>Cities</h2>
</header>

<section>


  <article>
    <h1>Privacy rules</h1>
    <p>Your data will be protected. Any unauthorised use of your data from our employees will be prosecuted by the law of our country. Do not use passwords if you are already use in your other emails, or site logins. Always use password not less than 8 bites and use at least 1 number and 1 small and 1 big letter. To accept our rules of privacy, visit <a id="privatnost" href="privacy.php" target="_blank">privacy </a> and check if you are agree. Other information will be here also.</p>
    <p>    <section id="randslike">
<h2>Random slike</h2>
<p id="s"></p>
    </section></p>
    <p>
    <section id="cal" class="cl">
        <h2>Calendar for March 2025</h2>
        <p id="calendar"></p>
    </section>
    </p>
  </article>
</section>

<footer>

    
    <p id="datum"></p>
</footer>
</body>
</html>