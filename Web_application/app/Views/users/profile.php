<main>

  
    <div class="form-box">
                  <?php if(isset($_SESSION['msg'])): ?>
     <div class="message">
          <p class="success"><?= $_SESSION['msg']; ?></p>
     </div>
     <?php endif; unset($_SESSION['msg']);?>
<!-- There is a problem with registered user no address  -->
        <?php if(!isset($profil) || $profil!=""): ?>
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
                 <?php
                      endif;
                          use Carbon\Carbon;
                         use Core\Auth;

               if(!isset($profil) || $profil!=""){
 echo "<a class='updateInformations' href='?page=users/update&id={$profil["userId"]}'>Update basic information</a>"; 
               }; 
               if(!isset($profil) || $profil!=""):
 ?>
 
            </span>
         </form>
         <?php if(!empty($profileImage)): ?> 
            <label>Profile image:</label>
                 <?php  $imgUrl= 'assets/images/'.$profil["userId"].'/'.$profileImage["alt"]; 
                    $imgAlt=$profileImage["alt"];
              ?>
             <img src="<?= $imgUrl ?>" alt="<?= $imgAlt ?>" width="40%" height="40%">

            <span id="updateProfileImage">
                 <?php echo "<a class='updateInformations' href='?page=users/profile_img_update&id={$profil["userId"]}&profileMarkImage=p'>Update profile image</a>"; ?>
            </span>
            <?php endif; ?>
             <label for="acTypeId">Account type:</label>
            <input type="text" name="acTypeId" id="acTypeId" value="<?= $profil["acTypeName"]; ?>" readonly>

            <label for="accountStatus">Account status:</label>
            <input type="text" name="accountStatus" id="accountStatus" value="<?= $profil["accountStatus"]; ?>" readonly>
            
            <label for="registrationDate">Registration date</label>
            <input type="datetime" name="registrationDate" id="registrationDate" value="<?= Carbon::parse($profil["registrationDate"])->format("d.m.Y H:i:s"); ?>" readonly>

               <!-- Account type and account profile details will be updated by admin on user managment part -->


               <label for="street">Street</label>
            <input type="text" name="street" id="street" value="<?= $profil["street"]; ?>" readonly>
            

              <label for="city">City</label>
            <input type="text" name="city" id="city" value="<?= $profil["CitName"]; ?>" readonly>

                 <label for="state">State</label>
            <input type="text" name="state" id="state" value="<?= $profil["StName"]; ?>" readonly>

                   <span id="updateAddress">
                 
                 <?php echo "<a class='updateInformations' href='?page=address/update&id={$profil["userId"]}'>Update address</a>"; ?>
            </span>
           
         </form>
          <?php else: ?>
               <p>Please, insert your profile image or your address to gain access to profile details.</p>
               <?php if((int)$userImage===0): ?>
               <p>You can insert your profile image <a href="?page=users/profile_img_update&option=insert">at this url</a></p>
               <?php endif; ?>
               <?php if($usrAddr>0): ?>
                <p>You can insert your new address <a href="?page=address/insert">at this url</a></p>
               <?php endif; ?>
               <?php endif; ?>
    </div>

</main>