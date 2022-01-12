<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<main id='login' class=' bg-image d-flex min-vh-100 d-flex justify-content-center py-2 flex-column'>
    <section class='d-grid gap-5 noMasonry mx-auto my-2 bg-white rounded shadow-5-strong p-5'>
        <div class='container'>
            <div class='row justify-content-center'>
                <form class="" method='POST'>
                    <!-- Email input -->
                    <div class='row mb-12'>
                        <h1 class='text-center'>Logowanie</h1>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="email" id="form1Example1" name='email' class="form-control" required='required'/>
                        <label class="form-label" for="email">Email</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name='pw' id="pw" class="form-control" required='required'/>
                        <label class="form-label" for="pw">Hasło</label>
                    </div>

                    <!-- 2 column grid layout for inline styling -->
                    <?php
                    if(isset($alert)){
?>
 <div class="row mb-12">
                        <div class="alert alert-dismissible fade show alert-danger" role="alert">

<?php
                        switch($alert){
                            case 'error-pw':
    echo "   Podane dane nie pasują do siebie    ";
                                break;
                            case 'closed-account':
    echo "   Konto zawieszone :(    ";
                                break;
                        }
?>
                            <button type="button" class="btn-close" data-mdb-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>


<?php

                    }
                    
if($alert == 'error-pw'){
?>

                   
                         
                    <?php


}

?>


                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="form1Example3" name='remember'/>
                                <label class="form-check-label" for="form1Example3">
                                    Zapamiętaj
                                </label>
                            </div>
                        </div>

                        <div class="col text-center">
                            <!-- Simple link -->
                            <a href="#!">Zapomniałem o czymś</a>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <input type='hidden' name='mode' value='1'>
                    <button type="submit" class="btn btn-primary btn-block">Zaloguj się</button>
                </form>
            </div>
        </div>
        <?php
if(!empty($cookies_user)){
?>

<div class='container d-grid gap-3'>
            <div class='row'>
                <h3 class='text-center'>Zapisane sesje</h3>
            </div>
<form method='post'>


<button type='submit' class='btn d-flex row rounded shadow-5-strong py-3 px-1 pe-auto m-0 w-100 h-100'>
                <div class='col-3 d-flex justify-content-center'>
                    <img src="img/avatars/avatar (<?=$cookies_user['user_avatar']?>).png" class="rounded-circle" height="40" />
                </div>
                <div class='col-9 h-100 d-flex align-items-center'>
                    <h5 class='m-0'><?=implode(createName($cookies_user['user_email'])," ")?></h5>
                </div>
            </button>
<input type='hidden' name='mode' value='11'>
            </form>
<?php


}

?>

        </div>

<?php

        ?>
      
    </section>
</main>