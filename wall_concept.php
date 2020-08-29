<?php
$user="jbosnjak3@gmail.com";
$friend="mmarkovic@gmail.com";
$post_options=array("Edit post","Delete Post");
$friend_posts_options=array("Hide post","Block post");
$mypost="Hello it is a beautifull day";
$my_friend_post="I cant even make it today!!";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wall concept</title>
</head>
<body>
<div class="container">
<section class="user">
<h2>User:</h2>
<?php 
echo $user;
?>
<hr>
<aside class="new_posts">
<h2>Form for adding new posts from user</h2>
<form action="wall_concept.php" method="post">
<label for="newpost">Add new post:</label>
<input type="text" name="post" id="post">
<input type="submit" value="Add new post">
</form>
</aside>
</section>
<section class="user_posts">
<h2>User posts:</h2>
<?php 

foreach ($post_options as $options) {
    echo "$options <br>";
  }
echo $mypost;
?>
<hr>
</div>
<section class="friend_posts">
<h2>Friends posts:</h2>
<?php 


foreach ($friend_posts_options as $options) {
    echo "$options <br>";
  }



echo $friend;
echo "<br>";
echo $my_friend_post;

?>
</section>

</div>
</body>
</html>