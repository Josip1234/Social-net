<main>
    <div id="container">
        <div class="form-box">

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
                            <td></td>

                        <?php endforeach;  ?>

                </tbody>


            </table>
        </div>
</main>