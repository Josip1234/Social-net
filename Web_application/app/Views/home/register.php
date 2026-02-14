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
        
             <p id="pi"> <b>Input address?</b></p>
            <input type="checkbox" id="ia" onclick="showForm()">
          
       
            <div class="disabled" id="form">
                <label for="city">Insert city</label>
                <input type="text" name="city">
                <label for="state">Add new state</label>
                <input type="text" name="state">
                <label for="address">Add new address</label>
                <input type="text" name="address">
            </div>
            <label for="hp">Input password</label>
            <input type="hp" name="hp" id="hp">
            <input type="hidden" name="registrationDate" value="<?= \Carbon\Carbon::now()->format("Y-m-d"); ?>">
            <input type="submit" value="Register">
        </form>
    </div>
</main>