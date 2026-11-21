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
                <li><a href="?topicNumber=<?= $value["topicNumber"] ?>" class="topicContent"><?= $value["topicName"] ?></a>
                <span id="like" class="likes">Likes: <?= $value["likeNumbers"] ?></span>
                <span id="dislike" class="dislikes">Dislikes: <?= $value["dislikeNumbers"] ?></span>
                <button type="submit" id="submitLike">Like</button>
                <button type="submit" id="submitDislike">Dislike</button>
                <button type="reset" id="resetLike">Revert</button>
            </li>
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