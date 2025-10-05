    <div id="podnozje">
          <table>
            <thead>
                <tr>
                    <th>Današnji datum</th>
                    <th>Trenutno vrijeme</th>
                    <th>Status korisnika</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo dohvatiDanašnjiDatum("d.m.Y");  ?>
                    </td>
                    <td>
                        <?php echo dohvatiTrenutnoVrijeme("H:i:s") ?>
                    </td>
                    <td>
                        <?php $status="";
                         (isset($_SESSION["user"]))?$status="Prijavljen":$status="Neprijavljen";
                         echo $status;
                        ?>
                    </td>
                </tr>
            </tbody>
          </table>
    </div>
</body>
</html>