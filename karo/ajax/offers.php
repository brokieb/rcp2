<?php
include('default.php');
?>
<h2>Zarządzanie ofertami</h2>
<div class='space-around'>
    <div class='col-3'>
        <h3>Utwórz nowy pakiet</h3>
        <form method='post'>
            <label for='nazwa'>Nazwa pakietu</label>
            <input type='text' name='name'>
            <label for='max-users'>Max użytkowników</label>
            <input type='text' name='max-users'>
            <label for='max-ip'>Max IP</label>
            <input type='text' name='max-ip'>
            <label for='max-dev'>Max urządzenia</label>
            <input type='text' name='max-dev'>
            <label for='payment-remote'>
            <input type='checkbox' id='payment-remote' name='payment-remote' value='1'>
            praca zdalna
            </label>
            <label for='payment-invoice'>
            <input type='checkbox' id='payment-invoice' name='payment-invoice' value='1'>
            Eksport do programu fakturowego  
            </label>

            <label for='payment-24h'>
            <input type='checkbox' id='payment-24h' name='payment-24h' value='1'>
            System 24h
            </label>
            
            <label for='payment-break'>
            <input type='checkbox' id='payment-break' name='payment-break' value='1'>
            Statystyki przerw
            </label>
            
            <label for='payment-new-status'>
            <input type='checkbox' id='payment-new-status' name='payment-new-status' value='1'>
            Nowy status
            </label>
            
            <label for='payment-holidays'>
            <input type='checkbox' id='payment-holidays' name='payment-holidays' value='1'>
            Wakacje i planowane nieobecności
            </label>
            
            <label for='payment-user'>Płatność od użytkownika</label>
            <input type='text' name='payment-user' placeholder='NULL'>
            <label for='price'>Cena końcowa</label>
            <input type='text' name='price'>
            <button>Dodaj pakiet</button>

        </form>
    </div>
    <div class='col-9'>
        <h3 class='col-12'>Wszystkie pakiety</h3>
        <div class='space-around'>

            <div class='offers col-6'>
                <?php
$sql = "SELECT * FROM `offers`";
$query = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($query)){
    ?>
                <div class='this-offer'>
                    <h4><?=$row['offer_name']?></h4>
                    <ul>
                        <li>Maksymalnie użytkowników <strong><?=$row['offer_max-users']?></strong></li>
                        <li>Maksymalnie adresów IP <strong><?=$row['offer_max-ip']?></strong></li>
                        <li>Maksymalnie urządzeń per. user <strong><?=$row['offer_max-devices']?></strong></li>
                    </ul>
                    <div class='col-6'>
                        <ul>
                        <?php

?>
                            <li>Praca zdalna <strong><?=($row['offer_remote']!=NULL)? "TAK": "NIE" ?></strong></li>
                            <li>Eksporty fakturowe <strong><?=($row['offer_invoice-exports']!=NULL)? "TAK": "NIE" ?></strong></li>
                            <li>24h system pracy <strong><?=($row['offer_24h-work']!=NULL)? "TAK": "NIE" ?></strong></li>
                        </ul>
                    </div>
                    <div class='col-6'>
                        <ul>
                            <li>Obliczanie przerw <strong><?=($row['offer_break-record']!=NULL)? "TAK": "NIE" ?></strong></li>
                            <li>Dodatkowy status <strong><?=($row['offer_more-statuses']!=NULL)? "TAK": "NIE" ?></strong></li>
                            <li>Urlopy i nieobecności <strong><?=($row['offer_absense-holiday']!=NULL)? "TAK": "NIE" ?></strong></li>
                        </ul>
                    </div>
                    <i>Podsumowanie <strong><?=($row['offer_pay-per-user']!=NULL)? $row['offer_price']."zł + ".$row['offer_pay-per-user']."zł /os": $row['offer_price']." zł" ?></strong></i>
                </div>
                <?php
}
?>
            </div>
        </div>
    </div>
</div>
<script>
$("form").submit(function(e) {
    e.preventDefault();
    $.ajax({
    type: "GET",
    url: "ajax/new-offer_form.php",
    data: $(this).serialize(),
    dataType: "html",
    success: function (zmienna) {
        console.log(zmienna);
    //   if(zmienna['ans']=="1"){
    //     $("#content").html("<h2>Utworzyłem nową instancję!</h2>");
    //   }
    },
  });
});
</script>