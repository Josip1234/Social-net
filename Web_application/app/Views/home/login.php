<main>
<div class="form-box">
    <h2>Login</h2>
    <?php
        if(!empty($error)):
        ?>
        <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <!-- htmlspecialchars is to prevent sql injection 
            Convert special characters to HTML entities
        
        -->
    <form method="post">
        <label for="username">Enter your email</label>
        <input type="email" name="username" id="username" required autocomplete="off">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required autocomplete="off">
        <button type="submit">Login</button>
    </form>

</div>
</main>