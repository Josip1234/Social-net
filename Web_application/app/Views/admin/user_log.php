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
                    <a href="#" class="disabled">&laquo; Previous</a>
                    <a href="" class="activepage">1</a>
                    <a href="">2</a>
                    <a href="">3</a>
                    <a href="" class="disabled">&raquo; Next</a>
                </div>
        </div>
</div>
</main>