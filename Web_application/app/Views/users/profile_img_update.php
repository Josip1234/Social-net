<main>
    
    <div class="form-box">
            <h2>Directory images: <?= $directory; ?></h2>
            <h3>Current profile image:</h3>
              <?php  $imgUrl= 'assets/images/'.$_SESSION["user"]["id"].'/'.$profileImage["alt"]; 
                    $imgAlt=$profileImage["alt"];
              ?>
             <img src="<?= $imgUrl ?>" alt="<?= $imgAlt ?>" width="40%" height="40%">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"].'?page=users/img_update'); ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="image" id="image">
                <input type="hidden" name="userId" value="<?= $_GET["id"] ?>">
                <input type="hidden" name="profileMarkImage" value="<?= $profileImage["profileMarkImage"]; ?>">
                <button type="submit">Update current image</button>
            </form>
    </div>
</main>