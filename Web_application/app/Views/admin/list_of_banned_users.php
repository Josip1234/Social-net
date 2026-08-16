<main>
    <div id="container">
        <div class="form-box">
         <div id="search-box">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"].'?page=admin/banned_users_search&pag=1'); ?>" method="post">
                  <label for="user">Search by username:</label>
                 <input type="text" name="user" id="user">             
                 <button type="submit">Search</button>               
            </form>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Date of birth</th>
                        <th>Account status</th>
                        <th>Account type</th>
                        <th>Db user type</th>
                        <th>Ban timestamp</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    use Carbon\Carbon;

                    foreach ($users as $user): ?>

                        <tr>
                            <td><?= $user["userId"]; ?></td>
                            <td><?= $user["user"]; ?></td>
                            <td><?= $user["email"]; ?></td>
                            <td><?= \Carbon\Carbon::parse($user["dateOfBirth"])->format("d.m.Y");  ?></td>
                            <td><?= $user["accountStatus"]; ?>
                            </td>
                            <td><?= $user["acTypeName"]; ?>
                            </td>
                            <td><?= $user["databaseUser"]; ?></td>
                            <td><?= \Carbon\Carbon::parse($user["pdUpdateDate"])->format("d.m.Y H:i:s");  ?></td>
                             <td><a href="<?= '?page=admin/account_status&id=' . $user["userId"]; ?>">Update user accounts</a></td>

                        <?php endforeach;  ?>

                </tbody>


            </table>
                <?php if ($total_pages > 0): ?>
                <div class="paginator">
                <a href="?page=admin/list_of_banned_users&pag=<?= 1 ?>">First</a>
                  <?php if ($page != 1): $previous = $page - 1; ?>
                        <a href="?page=admin/list_of_banned_users&pag=<?= $previous ?>">&laquo; Previous</a>
                    <?php else: ?>
                        <a href="" class="disabled">&laquo; Previous</a>
                    <?php endif; ?>

                         <?php
                    for ($i = $pagStart; $i <= $pagEnd; $i++):

                    ?>
                        <?php if ($i == $page): ?>
                            <a href="?page=admin/list_of_banned_users&pag=<?= $i ?>" class="activepage"><?= $i ?></a>
                        <?php else: ?>
                            <a href="?page=admin/list_of_banned_users&pag=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                                        <?php if ($page < $total_pages): $next = $page + 1; ?>

                        <a href="?page=admin/list_of_banned_users&pag=<?= $next ?>"> Next &raquo;</a>
                    <?php else: ?>
                        <a href="" class="disabled"> Next &raquo;</a>

                    <?php endif; ?>
                    <a href="<?= "?page=admin/list_of_banned_users&pag=" . $total_pages . "" ?>"> Last</a>
        </div>
           <?php endif; ?>
        </div>
</main>