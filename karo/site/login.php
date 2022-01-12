<main id='login' class='bg-image d-flex min-vh-100 justify-content-evenly py-4 flex-wrap'>
    <section class='m-auto'>
  <div class='container'>
  <div class='row justify-content-center'>
<form class="bg-white rounded shadow-5-strong p-5" method='POST'>
                <!-- Email input -->
                <div class='row mb-12 py-3'>
                  <h1 class='text-center'>Logowanie</h1>
                </div>
                <div class="form-outline mb-4">
                  <input type="email" id="form1Example1" name='email' class="form-control" />
                  <label class="form-label" for="email">Email</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" name='pw' id="pw" class="form-control" />
                  <label class="form-label" for="pw">Hasło</label>
                </div>

                <!-- 2 column grid layout for inline styling -->
                <?php
if($alert == 'error-pw'){
?>

<div class="row mb-12">
                <div class="alert alert-dismissible fade show alert-danger" role="alert">
                    Podane dane nie pasują do siebie
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
 </div>
<?php


}

?>
                
               
                <div class="row mb-4">
                  <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
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
</div>
</main>