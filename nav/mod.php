<?php
if (!defined('MyConst')) {
    die('Direct access not permitted');
}
?>
<section class='shadow-2-strong m-5'>
    <h2 class='text-center'>Lista aktywnych pracowników</h2>
    <?php
    $sql = "SELECT * FROM `users` WHERE user_status>'0'";
    $result = mysqli_query($conn, $sql);
    ?>
    <div>
        <table class='table table-bordered table-sm'>
            <thead>
                <tr>
                    <td scope='col'>E-mail</td>
                    <td scope='col'>Ostatnia aktualizacja</td>
                    <td scope='col'>Czas pracy</td>
                    <td scope='col'>Aktual.</td>
                    <td scope='col'>Moderacja</td>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $sql2 = "SELECT record_in_time FROM records_new WHERE user_id='" . $row['user_id'] . "' AND record_date='" . Date('Y-m-d') . "' AND `record_out_time` IS NULL AND `record_event`='1'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
                    $diff = timeDiff($row2['record_in_time'], Date('H:i:s'));
                ?>
                    <tr>
                        <td><?= implode(" ", createName($row['user_email'])) ?></td>
                        <td>?</td>
                        <td><?= $diff ?></td>
                        <td>
                            <?php

                            switch ($row['user_status']) {
                                case 1:
                                    echo "Praca";
                                    break;
                                case 2:
                                    echo "Przerwa";
                                    break;
                                case 3:
                                    echo "Magazyn";
                                    break;
                            }


                            ?>
                        </td>
                        <td>
                            <form method='POST'>
                                <input type='hidden' name='mode' value='4'>
                                <input type='hidden' name='id' value='<?= $row['user_id'] ?>'>
                                <button class='man-finish-day btn btn-warning btn-sm'>Zakończ dzień</button>
                            </form>


                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<section class='shadow-2-strong m-5'>
    <h2 class='text-center'>Potwierdź obeność pracowników</h2>
    <div>
        <table class='table table-bordered table-sm'>
            <thead>
                <tr>
                    <td>Data</td>
                    <td>użytkownik</td>
                    <td>Komentarz</td>
                    <td>przerwa</td>
                    <td>praca</td>
                    <td>Potwierdź</td>
                </tr>
            </thead>
            <tbody>


                <?php
                if ($_SESSION['prv'] < 2) {
                    $sql = "SELECT *,`users`.`user_id` AS `id_uzytkownika` FROM `records_new` INNER JOIN users ON `records_new`.user_id=`users`.user_id LEFT JOIN `accepted_days` ON `records_new`.`record_date`=`accepted_days`.`accept_date` AND `records_new`.`user_id`=`accepted_days`.`user_id` WHERE  user_privilage<'" . $_SESSION['prv'] . "' AND `accept_id` IS NULL GROUP BY `record_date`,records_new.`user_id` ORDER BY record_date DESC";
                } else {
                    $sql = "SELECT *,`users`.`user_id` AS `id_uzytkownika` FROM `records_new` INNER JOIN users ON `records_new`.user_id=`users`.user_id LEFT JOIN `accepted_days` ON `records_new`.`record_date`=`accepted_days`.`accept_date` AND `records_new`.`user_id`=`accepted_days`.`user_id` WHERE  `accept_id` IS NULL GROUP BY `record_date`,records_new.`user_id` ORDER BY record_date DESC";
                }
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    $ids = [];
                    $rids['rids'] = [];
                    $rids['uid'] = [];


                    $sql2 = "SELECT * FROM `records_new` LEFT JOIN 
`accepted_days` ON `records_new`.user_id=`accepted_days`.user_id  AND `records_new`.`record_date`=`accepted_days`.`accept_date` 
WHERE `records_new`.`user_id`=" . $row['id_uzytkownika'] . " AND
`record_date`='" . $row['record_date'] . "' AND
`record_event`=1 ";

                    $result2 = mysqli_query($conn, $sql2);
                    $praca = [];
                    $err = NULL;
                    while ($row2 = mysqli_fetch_array($result2)) {
                        // $accept_id = $row2['accept_id'];
                        // $accept_day = $row2['accept_date'];
                        // $accept_time = $row2['accept_hours'];
                        // $accept_type = $row2['accept_type'];
                        if ($row2['record_out_time'] == NULL) {

                            $praca[] = timeDiff($row2['record_in_time'], Date("H:i"));
                            $err = " ! ";
                        } else {
                            $praca[] = timeDiff($row2['record_in_time'], $row2['record_out_time']);
                        }
                        $rids['rids'][] = $row2['record_id'];
                    }

                    $sql2 = "SELECT * FROM `records_new` LEFT JOIN
`accepted_days` ON `records_new`.user_id=`accepted_days`.user_id  AND `records_new`.`record_date`=`accepted_days`.`accept_date` 
WHERE `records_new`.`user_id`=" . $row['id_uzytkownika'] . " AND
`record_date`='" . $row['record_date'] . "' AND
`record_event`=2 ";
                    $result2 = mysqli_query($conn, $sql2);
                    $przerwa = [];
                    while ($row2 = mysqli_fetch_array($result2)) {
                        if ($row2['record_out_time'] == NULL) {

                            $przerwa[] = timeDiff($row2['record_in_time'], Date("H:i"));
                            $err = " ! ";
                        } else {
                            $przerwa[] = timeDiff($row2['record_in_time'], $row2['record_out_time']);
                        }
                    }

                    $rids['uid'] = $row['id_uzytkownika'];


                ?>

                    <tr>
                        <td class='date'><?= substr($row['record_date'], -5) ?></td>
                        <td><?= $row['id_uzytkownika'] ?>|<?= implode(" ", createName($row['user_email'])) ?></td>
                        <td><span><?= $row['record_comment'] ?></span>
                            <form>
                                <button type='button' data-id='<?= implode(",", $rids['rids']) ?>' class='show-comment-form btn btn-info btn-sm fas fa-comment-dots'></button>
                            </form>
                        </td>
                        <td> <?= addTime($przerwa) ?></td>
                        <td><?= addTime($praca) . $err ?></td>
                        <?php
                        if ($row['record_date'] == Date('Y-m-d')) {
                        ?>
                            <td>JUTRO :)</td>
                        <?php
                        } else {
                        ?>
                            <td class='date'>
                                <form method='get'>
                                    <button title='akceptuj dzień XD' class='accept-record btn btn-success btn-sm far fa-check-circle' type='button' data-json='<?= json_encode($rids) ?>' data-comment=''><i class=""></i></button>
                                    <button title='odrzuć dzień' class='reject-record btn btn-danger btn-sm far fa-times-circle fa-2x' type='button' data-json='<?= json_encode($rids) ?>' data-comment=''>
                                    </button>
                                </form>
                            </td>
                        <?php
                        }
                        ?>

                    </tr>

                <?php



                }
                ?>
            </tbody>
        </table>
    </div>
</section>