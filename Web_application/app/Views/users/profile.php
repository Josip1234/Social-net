<main>

  
    <div class="form-box">
           
         <h2>User profile</h2>
         <form action="" method="post">
            <label for="fname">First name:</label>
            <input type="text" name="fname" id="fname" value="<?= $profil["firstName"]; ?>" readonly>
             <label for="lname">Last name:</label>
            <input type="text" name="lname" id="lname" value="<?= $profil["lastName"]; ?>" readonly>
             <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $profil["email"]; ?>" readonly>
             <label for="sex">Sex:</label>
            <input type="text" name="sex" id="sex" value="<?= ($profil["sex"]==='m')?'Male':'Female'; ?>" readonly>

                <label for="dbirth">Date of birth</label>
            <input type="date" name="dbirth" id="dbirth" value="<?= $profil["dateOfBirth"]; ?>" max="999-12-31" readonly>

            <label for="img">Profile image:</label>
            <img src="<?= $profil["url"]; ?>" alt="<?= $profil["imageName"] ?>" id="img" readonly>

             <label for="acTypeId">Account type:</label>
            <input type="text" name="acTypeId" id="acTypeId" value="<?= $profil["acTypeName"]; ?>" readonly>

            <label for="accountStatus">Account status:</label>
            <input type="text" name="accountStatus" id="accountStatus" value="<?= $profil["accountStatus"]; ?>" readonly>
            
            <label for="registrationDate">Registration date</label>
            <input type="datetime" name="registrationDate" id="registrationDate" value="<?= $profil["registrationDate"]; ?>" readonly>

               <label for="street">Street</label>
            <input type="text" name="street" id="street" value="<?= $profil["street"]; ?>" readonly>

              <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?= $profil["CitName"]; ?>" readonly>

                 <label for="state">State</label>
            <input type="text" name="state" id="state" value="<?= $profil["StName"]; ?>" readonly>

         </form>
     
    </div>

</main>