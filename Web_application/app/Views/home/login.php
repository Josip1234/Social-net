<div class="form-box">
    <h2>Login</h2>
    <?php
        if(!empty($error)):
        ?>
        <p class="error"><?= $error ?></p>
        <?php endif; ?>
    <form method="post">
        <label>Email:</label>
        <input type="email" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>

</div>