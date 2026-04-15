<main>
    
    <div class="form-box">
            <h2>Directory images: <?= $directory; ?></h2>
            <h3>Current profile image:</h3>
            <img src="<?= $profileImage["url"]; ?>" alt="<?= $profileImage["alt"]; ?>" width="20%" height="20%">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"].'?page=users/img_update'); ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="image" id="image">
                <input type="hidden" name="userId" value="<?= $_GET["id"] ?>">
                <input type="hidden" name="profileMarkImage" value="<?= $profileImage["profileMarkImage"]; ?>">
                <button type="submit">Update current image</button>
            </form>
    </div>
</main>