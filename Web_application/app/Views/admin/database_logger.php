<main>
    <div id="container">
        <div class="form-box">
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
                        }elseif ($logs["dateAdded"]===null) {
                             $dateAdded = "No data.";
                        }
                        else {
                            $dateAdded = \Carbon\Carbon::parse($logs["dateAdded"])->format("d.m.Y H:i:s");
                        }


                        if ($logs["dateDeleted"] === "0000-00-00 00:00:00") {
                            $dateDeleted = "Invalid date";
                        } 
                        elseif ($logs["dateDeleted"]===null) {
                            $dateDeleted = "No data.";
                        }
                        else {
                            $dateDeleted = \Carbon\Carbon::parse($logs["dateDeleted"])->format("d.m.Y H:i:s");
                        }


                        if ($logs["dateUpdated"] === "0000-00-00 00:00:00") {
                            $dateUpdated = "Invalid date";
                        }
                        elseif ($logs["dateUpdated"]===null) {
                            $dateUpdated = "No data.";
                        }
                        else {
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
        </div>
    </div>
</main>