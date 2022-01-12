
<?php
if(!defined('MyConst')) {
   die('Direct access not permitted');
}
?>
<main class='wall'>

<section>
    <h1>Aktualizacja danych</h1>
    <?php
    $sql = "SELECT * FROM `users` WHERE user_id = '".$_SESSION['user_id']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
?>
    <form method='POST'>
        <label for='imie'>Twoje wyświetlane imie</label>
        <input type='text' name='imie' value='<?=$row['user_name']?>'>
        <label for='npw'>Nowe hasło</label>
        <input type='password' name='npw' >
        <label for='rnpw'>powtórz nowe hasło</label>
        <input type='password' name='rnpw'>
        <input type='hidden' name='mode' value='3'>
        <button>Aktualizuj swoje dane</button>
    </form>
    </section>

    </main>