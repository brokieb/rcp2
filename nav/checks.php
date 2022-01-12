<section id='checks' class='d-flex flex-column gap-4 shadow-2-strong mx-auto'>
<?php
include("ajax/checks-reload.php");
?>
</section>
<?php
$sql_export = "SELECT * FROM `accepted_months` WHERE `accept_m_user_id`='".$user['user_id']."' AND `accept_m_status`=1 LIMIT 1";
$result_export = mysqli_query($conn, $sql_export);
while($user_export = mysqli_fetch_array($result_export)){
?>
    <section id='zest' class='d-flex flex-column gap-4 shadow-2-strong mx-auto w-25'>
    <h2>Twoje miesięczne zestawienie za miesiąc <?=substr($user_export['accept_month'],0,-3)?> zostało wygenerowane</h2>
    <h4>Aby potwierdzić otrzymanie dokumentu, podaj poniżej kod znajdujący się w górnej części dostarczonego dokumentu</h4>
    <form class='row w-50 mx-auto' id='accept-zest'>
    <div class="form-outline mb-4">
                        <input type='number' id='tess' name='zest-accept' class='form-control' required='required'>
                        <label class="form-label" for="email">Kod dokumentu</label>
                    </div>
                    <div class='row alert-section'>
                    </div>
    <button type='submit' class='zest-accept-button btn btn-success'>akceptuj</button>
    </form>
    </section> 
<?php
}
?>
