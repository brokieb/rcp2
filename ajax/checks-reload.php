<?php
$realIP = $_SERVER['REMOTE_ADDR'];
$sql = "SELECT `user_remote_work` FROM users WHERE `user_id`=".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
$sql = "SELECT * FROM `con_accepted_ip` WHERE `con_accept_ip_ip`='".$realIP."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if(!empty($row)||$row2['user_remote_work']=='1'){

?>
<div class='col align-self-center'>
    <h1 style='text-align:center'>Dziś jest <?=date('d/m/Y')?></h2>
        <h4 style='text-align:center' class='time'>
            </h3>
</div>
<div class='d-flex flex-column gap-3'>



    <?php

$sql = "SELECT `user_status` FROM users WHERE `user_id`=".$_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

switch($row['user_status']){
case 0:
    ?>
    <button type="button" class='status-toggle-new py-3 btn btn-primary btn-lg' data-event='1' data-type='1'>ZACZYNAM
        PRACE</button>
    <?php
    break;
case 1://PRACA
    ?>
    <button type="button" class='status-toggle-new py-3 btn btn-primary btn-lg' data-event='2' data-type='2'>ZACZYNAM
        PRZERWE</button>
    <button type="button" class='status-toggle-new py-3 btn btn-primary btn-lg' data-event='3' data-type='3'>IDĘ NA
        MAGAZYN</button>
    <button type="button" class='status-toggle-new py-3 btn btn-primary btn-lg' data-event='1' data-type='0'>KOŃCZĘ
        PRACĘ NA DZIŚ </button>
    <?php
    break;
case 2://PRZERWA
    ?>
    <button type="button" class='status-toggle-new py-3 btn btn-primary btn-lg' data-event='2' data-type='1'>KONIEC
        PRZERWY</button>
    <?php
    break;
case 3://MAGAZYN
    ?>
    <button type="button" class='status-toggle-new py-3 btn btn-primary btn-lg' data-event='3' data-type='1'>WRACAM Z
        MAGAZYNU</button>
    <?php
    break;
}

?>
</div>

<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne"
                aria-expanded="false" aria-controls="collapseOne">
                Dzisiejsza aktywność
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-mdb-parent="#accordionExample">
            <div class="accordion-body">
               <?php

$sql = "SELECT * FROM records_new WHERE `record_date`=CURDATE() AND `user_id`=".$_SESSION['user_id']." ORDER BY `record_id` DESC";
$result = mysqli_query($conn, $sql);
?><div class='checks-tab'><?php
while($row = mysqli_fetch_array($result)){

switch(($row['record_event'])){
    case 1:
        $ans = "PRACA";
        break;
    case 2:
        $ans = "PRZERWA";
        break;
    case 3:
        $ans = "MAGAZYN";
        break;
}?>
    <div class='check-el' data-time='2012-01-01T<?=$row['record_in_time']?>.000Z'>
        <i class='fas fa-angle-up green'></i>
        [<?=$row['record_in_time']?>] START <?=$ans?>
    </div>
    <?php


if($row['record_out_time']!=NULL){?>
    <div class='check-el' data-time='2012-01-01T<?=$row['record_out_time']?>.000Z'>
        <i class='fas fa-angle-down red'></i>
        [<?=$row['record_out_time']?>] STOP <?=$ans?>
    </div>
    <?php
}
}
?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php
}else{
    ?>
<h1>XXWygląda na to że jesteś w innej lokalizacji,</h1>
<h1>Zaloguj się do firmowej sieci żeby móc kontynuować</h1>
<h2>Jeżeli jest to błąd, i jesteś w sieci - poinformuj o tym administratora</h2>
<?php
}

?>


<script>
$(".status-toggle-new").click(function() {
    $(".status-toggle-new").attr("disabled", "disabled")
    $.ajax({
        type: "GET",
        url: "ajax/checks-new.php",
        data: {
            "type": $(this).data('type'),
            "event": $(this).data('event')
        },
        dataType: "html",
        success: function(zmienna) {
            console.log(zmienna);
            $("#checks").html(zmienna);
        }
    });
})

setTimeout(function() {
    // Now sort them
    console.log("ASD");
    var board = $(".checks-tab");
    var boards = board.children(".check-el").detach().get();
    boards.sort(function(a, b) {
        return new Date($(a).data("time")) - new Date($(b).data("time"));
    });
    board.append(boards);
}, 500);

$(".history-toggle").click(function() {
    $(".checks-tab").stop().slideToggle();
})
</script>