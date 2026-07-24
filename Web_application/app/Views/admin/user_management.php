<main>
    <div id="container">
        <div class="form-box">
            <?php if (isset($_SESSION['msg'])): ?>
                <div class="message">
                    <p class="success"><?= $_SESSION['msg']; ?></p>
                </div>
            <?php endif;
            unset($_SESSION['msg']); ?>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Date of birth</th>
                        <th>Account status</th>
                        <th>Account type</th>
                        <th>Type of database user</th>
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
                            <td><a href="<?= '?page=admin/account_status&id=' . $user["userId"]; ?>">Update user accounts</a></td>

                        <?php endforeach;  ?>

                </tbody>


            </table>
            <?php if ($total_pages > 0): ?>
                <div class="paginator">
                <a href="?page=admin/user_management&pag=<?= 1 ?>">First</a>
                  <?php if ($page != 1): $previous = $page - 1; ?>
                        <a href="?page=admin/user_management&pag=<?= $previous ?>">&laquo; Previous</a>
                    <?php else: ?>
                        <a href="" class="disabled">&laquo; Previous</a>
                    <?php endif; ?>

                         <?php
                    for ($i = $pagStart; $i <= $pagEnd; $i++):

                    ?>
                        <?php if ($i == $page): ?>
                            <a href="?page=admin/user_management&pag=<?= $i ?>" class="activepage"><?= $i ?></a>
                        <?php else: ?>
                            <a href="?page=admin/user_management&pag=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                                        <?php if ($page < $total_pages): $next = $page + 1; ?>

                        <a href="?page=admin/user_management&pag=<?= $next ?>"> Next &raquo;</a>
                    <?php else: ?>
                        <a href="" class="disabled"> Next &raquo;</a>

                    <?php endif; ?>
                    <a href="<?= "?page=admin/user_management&pag=" . $total_pages . "" ?>"> Last</a>
        </div>
           <?php endif; ?>
    </div>
</main>