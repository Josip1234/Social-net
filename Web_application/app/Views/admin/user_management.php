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
        </div>
    </div>
</main>