<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<main class='wall'>
<section style='width:99%'>
        <h1>Naruszenia protokołów bezpieczeństwa 3 stopnia</h1>
        <div class=''>
            <table style='width:100%'>
                <thead>
                    <tr>
                        <td>Kiedy</td>
                        <td>Kto</td>
                        <td>Typ</td>
                        <td>Opis</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
$sql = "SELECT * FROM `logs` INNER JOIN `users` ON `users`.user_id=`logs`.user_id ORDER BY log_id DESC";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
?>
                    <tr>
                        <td ><?=$row['log_occured']?></td>
                        <td><?=$row['user_email']?></td>
                        <td><?=$row['log_type']?></td>
                        <td ><?=$row['log_value']?></td>
                    </tr>

                    <?php
}
?>
                </tbody>
            </table>
        </div>
        <p>0 - informacja, 1 - Nieścisłość, 2 - Powazny błąd trzech wymiarów</p>
    </section>
    </main>