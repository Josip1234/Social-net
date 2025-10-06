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
                         <span id='trenutno_vrijeme'></span>
                        <?php $trenutnoVrijeme=dohvatiTrenutnoVrijeme(dohvatiTrenutnoVrijeme("H:i:s"));
                        //za izračun trenutnog vremena u session sam stavio time tako treba i ovdje da se dobije ispravna razlika
                        //echo $trenutnoVrijeme;
                         izracnajVrijeme(time());?>
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