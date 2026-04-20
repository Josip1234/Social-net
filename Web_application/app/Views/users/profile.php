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
            <span id="updateBasicInfo">
                 <?php echo "<a href='?page=users/update&id={$profil["userId"]}'>Update basic information</a>"; ?>
            </span>
            <label for="img">Profile image:</label>
                 <?php  $imgUrl= 'assets/images/'.$profil["userId"].'/'.$profileImage["alt"]; 
                    $imgAlt=$profileImage["alt"];
              ?>
             <img src="<?= $imgUrl ?>" alt="<?= $imgAlt ?>" width="40%" height="40%">

            <span id="updateProfileImage">
                 <?php echo "<a href='?page=users/profile_img_update&id={$profil["userId"]}&profileMarkImage=p'>Update profile image</a>"; ?>
            </span>

             <label for="acTypeId">Account type:</label>
            <input type="text" name="acTypeId" id="acTypeId" value="<?= $profil["acTypeName"]; ?>" readonly>

            <!-- this must be visible only for admins -->
             <span id="updateAccountType">
                 <?php echo "<a href='?page=users/edit_account_type&id={$profil["userId"]}'>Update account type</a>"; ?>
            </span>

            <label for="accountStatus">Account status:</label>
            <input type="text" name="accountStatus" id="accountStatus" value="<?= $profil["accountStatus"]; ?>" readonly>
            
            <label for="registrationDate">Registration date</label>
            <input type="datetime" name="registrationDate" id="registrationDate" value="<?= $profil["registrationDate"]; ?>" readonly>

                 <span id="updateProfileDetails">
                 <?php echo "<a href='?id={$profil["userId"]}'>Update profile details</a>"; ?>
            </span>


               <label for="street">Street</label>
            <input type="text" name="street" id="street" value="<?= $profil["street"]; ?>" readonly>
            

              <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?= $profil["CitName"]; ?>" readonly>

                 <label for="state">State</label>
            <input type="text" name="state" id="state" value="<?= $profil["StName"]; ?>" readonly>

                   <span id="updateAddress">
                 <?php echo "<a href='?id={$profil["userId"]}'>Update address</a>"; ?>
            </span>
         </form>
      
    </div>

</main>