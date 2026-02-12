<main>
    <div class="form-box">
        <h2>User registration</h2>
        <form method="post">
            <label for="fname">First name:</label>
            <input type="text" name="fname" id="fname" required>
            <label for="lname">Last name:</label>
            <input type="text" name="lname" id="lname">
            <label for="email">Email address:</label>
            <input type="email" name="email" id="email">
            <label for="sex1">Sex:</label>
            <span class="radio">
            <input type="radio" name="sex" id="sex1" value="m" checked>Male
            <input type="radio" name="sex" id="sex2" value="f">Female
            </span>
     
            <label for="dbirth">Date of birth</label>
            <input type="date" name="dbirth" id="dbirth">
            <label for="ia">Input address?</label>
            <input type="checkbox" name="ia" id="ia">
            <div class="disabled">
                <label for="adid">Address select</label>
                <select name="adid" id="adid">
                    <option value="">Choose address</option>
                </select>
            </div>
            <label for="hp">Input password</label>
            <input type="hp" name="hp" id="hp">
            <input type="hidden" name="registrationDate" value="<?= \Carbon\Carbon::now()->format("Y-m-d"); ?>">
            <input type="submit" value="Register">
        </form>
    </div>
</main>