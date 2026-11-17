<main>
    <div id="container"> 
        <div class="form-box">
                  <?php if(isset($_SESSION['msg'])): ?>
     <div class="message">
          <p class="success"><?= $_SESSION['msg']; ?></p>
     </div>
     <?php endif; unset($_SESSION['msg']);?>
            <ul class="ul">
                <?php foreach ($topics as $value):?>
                <li><a href="?topicNumber=<?= $value["topicNumber"] ?>"><?= $value["topicName"] ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="paginator"> 
                <a href="#first">First</a>
                <a href="#" class="disabled">Previous</a>
                <a href="#1" class="activepage">1</a>
                <a href="#2">Next</a>
                <a href="#last">Last</a>
            </div>
        </div>
    </div>
</main>