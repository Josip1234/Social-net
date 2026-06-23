<main>
    <div id="container">
        <div class="form-box">
                  <div id="search-box">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"].'?page=admin/database_logger_search&pag=1'); ?>" method="post">
                <label for="actype">Search by account type:</label>
                <select name="actype" id="actype">
                    <?php foreach($aType  as $type): ?>
                     <option value="<?= $type["dataTypeRec"]; ?>"><?= $type["dataTypeRec"]; ?></option>
                    <?php endforeach; ?>
                </select>
                
                 <button type="submit">Search</button>
            </form>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Description</th>
                        <th>User added</th>
                        <th>User updated</th>
                        <th>User deleted</th>
                        <th>Date deleted</th>
                        <th>Date updated</th>
                        <th>Date added</th>
                        <th>Account type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    use Carbon\Carbon;


                    foreach ($log as $logs):

                        if ($logs["dateAdded"] === "0000-00-00 00:00:00") {
                            $dateAdded = "Invalid date";
                        } elseif ($logs["dateAdded"] === null) {
                            $dateAdded = "No data.";
                        } else {
                            $dateAdded = \Carbon\Carbon::parse($logs["dateAdded"])->format("d.m.Y H:i:s");
                        }


                        if ($logs["dateDeleted"] === "0000-00-00 00:00:00") {
                            $dateDeleted = "Invalid date";
                        } elseif ($logs["dateDeleted"] === null) {
                            $dateDeleted = "No data.";
                        } else {
                            $dateDeleted = \Carbon\Carbon::parse($logs["dateDeleted"])->format("d.m.Y H:i:s");
                        }


                        if ($logs["dateUpdated"] === "0000-00-00 00:00:00") {
                            $dateUpdated = "Invalid date";
                        } elseif ($logs["dateUpdated"] === null) {
                            $dateUpdated = "No data.";
                        } else {
                            $dateUpdated = \Carbon\Carbon::parse($logs["dateUpdated"])->format("d.m.Y H:i:s");
                        }






                    ?>
                        <tr>
                            <td><?= $logs["idLogCon"]; ?></td>
                            <td><?= $logs["loggerDescription"]; ?></td>
                            <td><?= ($logs["userAdded"] != null) ? $logs["userAdded"] : "No data"; ?></td>
                            <td><?= ($logs["userUpdated"] != null) ? $logs["userUpdated"] : "No data"; ?></td>
                            <td><?= ($logs["userDeleted"] != null) ? $logs["userDeleted"] : "No data" ?></td>
                            <td><?= $dateDeleted;  ?></td>
                            <td><?= $dateUpdated;  ?></td>
                            <td><?= $dateAdded;  ?></td>
                            <td><?= $logs["acTypeName"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($total_pages > 0): ?>
                <div class="paginator">
                    <a href="?page=admin/database_logger&pag=<?= 1 ?>">First</a>
                    <?php if ($page != 1): $previous = $page - 1; ?>
                        <a href="?page=admin/database_logger&pag=<?= $previous ?>">&laquo; Previous</a>
                    <?php else: ?>
                        <a href="" class="disabled">&laquo; Previous</a>
                    <?php endif; ?>

                    <?php
                    for ($i = $pagStart; $i <= $pagEnd; $i++):

                    ?>
                        <?php if ($i == $page): ?>
                            <a href="?page=admin/database_logger&pag=<?= $i ?>" class="activepage"><?= $i ?></a>
                        <?php else: ?>
                            <a href="?page=admin/database_logger&pag=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>


                    <?php if ($page < $total_pages): $next = $page + 1; ?>

                        <a href="?page=admin/database_logger&pag=<?= $next ?>"> Next &raquo;</a>
                    <?php else: ?>
                        <a href="" class="disabled"> Next &raquo;</a>

                    <?php endif; ?>
                    <a href="<?= "?page=admin/database_logger&pag=" . $total_pages . "" ?>"> Last</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>