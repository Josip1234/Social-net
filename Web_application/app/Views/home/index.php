<main>
    <div id="container">
          <div class="form-box">
              <?php if(isset($_SESSION['msg'])): ?>
               <div class="form-box">
     <div class="message">
          <p class="error"><?= $_SESSION['msg']; ?></p>
     </div>

          </div>
     <?php endif; unset($_SESSION['msg']);?>
     <h1>Dobrodošao na moju stranicu</h1>
    <p>Random generirani sadržaj 🚀</p>

     <h1>Istraži nešto novo</h1>
    <p>Ovo je demo početna stranica s random sadržajem.</p>
    <button onclick="alert('Kliknuo si gumb!')">Klikni me</button>

       <?php if(isset($_SESSION['update'])): ?>
     <div class="message">
          <p class="success"><?= $_SESSION['update']; ?></p>
     </div>
     <?php endif; unset($_SESSION['update']);?>
          </div>
</div>
</main>