<main>
    <div id="container">
        <div class="form-box">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Message</th>
                            <th>Addition date</th>
                            <th>Update date</th>
                            <th>Date of birth</th>
                            <th>Account type</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

use Carbon\Carbon;

 foreach($users as $user): ?>

                        <tr>
                            <td><?= $user["id"]; ?></td>
                              <td><?= $user["username"]; ?></td>
                               <td><?= $user["message"]; ?></td>
                                 <td><?= \Carbon\Carbon::parse($user["additionDate"])->format("d.m.Y H:i:s");  ?></td>
                                 <td><?=($user["updateDate"]==NULL)?"No date":\Carbon\Carbon::parse($user["updateDate"])->format("d.m.Y H:i:s");  ?></td>
                                 <td><?= \Carbon\Carbon::parse($user["dateOfBirth"])->format("d.m.Y");  ?></td>
                                 <td><?=  $user["acTypeName"]; ?></td>
                                    <td><?=  $user["Age"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
              
               <!-- <tfoot>
                    <tr>
                        <td colspan="3" class="previous"><a href="?page=profile_log?page=-1">Previous</a></td>
                        <td colspan="4" class="next previous"><a href="?page=profile_log?page=1">1</a></td>
                        <td class="next"><a href="?page=profile_log?page=1">Next</a></td>
                    </tr>
                </tfoot>-->
                </table>
                  <div class="paginator">
                    <?php if($page!=1): $previous=$page-1; ?>
                    <a href="?page=profile_log&pag=<?= $previous?>">&laquo; Previous</a>
                    <?php else: ?>
                        <a href="" class="disabled">&laquo; Previous</a>
                     <?php endif; ?>
                     <?php 
                     for ($i=1; $i <= $total_pages; $i++):
                     ?>
                     <a href="?page=profile_log&pag=<?= $i ?>"ž
                     <?php if($i==$page) echo "class='activepage'"; ?>
                     ><?= $i ?></a>
                     <?php endfor; ?>
                     <?php if($page<$total_pages): $next=$page+1; ?>
                      <a href="?page=profile_log&pag=<?= $next?>" >&raquo; Next</a>
                     <?php else: ?>
                    <a href="" class="disabled">&raquo; Next</a>
                    <?php endif; ?>
                </div>
        </div>
</div>
</main>