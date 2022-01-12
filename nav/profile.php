<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
    <section class='shadow-2-strong col-5'>
        <form method='post' class='rounded p-5'>
            <div class='row mb-4'>
                <h2>Zmiana hasła</h2>
            </div>
            <div class="form-outline mb-4">
                <input type="text" name='imie' id="imie" class="form-control" value='<?=$user['user_name']?>' />
                <label class="form-label" for="imie">Wyświetlana nazwa</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" name='npw' id="npw" class="form-control" />
                <label class="form-label" for="npw">Nowe hasło</label>
            </div>
            <div class="form-outline mb-4">
                <input type="password" name='rnpw' id="rnpw" class="form-control" />
                <label class="form-label" for="rnpw">Powtórz nowe hasło</label>
            </div>
            <div class='row mt-4'>
                <button class='btn btn-success btn-lg'>Wyślij</button>
            </div>
        </form>
</section>
    <section class='shadow-2-strong col-5'>
        <form method='post' class='rounded p-5'>
            <input type='hidden' name='mode' value='10'>
            <div class='row'>
                <h2>Wybór avatara</h2>
            </div>
            <div class="mb-4 d-flex justify-content-center flex-wrap">
                <?php
                
for($i=1;$i<=60;$i++){
    ?>
                <input type='radio' class="btn-check " id="btn-check-<?=$i?>" value='<?=$i?>' name='cat'
                    autocomplete="off" />
                <label class="btn btn-primary btn-floating justify-content-center d-flex position-relative m-2 btn-lg"
                    for="btn-check-<?=$i?>"><img src="img/avatars/avatar (<?=$i?>).png"
                        class='rounded-circle position-absolute' height=40 style='top:3px'></label>
                <?php
}
                ?>

            </div>
            <div class='row mt-4'>
                <button class='btn btn-success btn-lg'>Zmień</button>
            </div>
        </form>

</section>