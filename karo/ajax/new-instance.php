<?php
include('default.php')
?>
<h2>Tworzenie nowej instancji</h2>
<form method='post' id='new-instance'>
<label for='nazwa'>subdomena</label>
<input type='text' name='sdomain'>
<label for='offer'>Oferta</label>
<select name='offer'>
<option disabled='disabled' selected='selected'>Wybierz ofertę</option>
<option disabled='disabled'>Nazwa | Max użytk. | Max IPs | p. zdalna | limit urządzeń</option>
<?php
echo $sql = "SELECT * FROM `offers` ";
$query = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
    ?>
<option value='<?=$row['offer_id']?>'><?=$row['offer_name']?> | <?=$row['offer_max-users']?> użytk. | <?=$row['offer_max-ip']?> IPs. | <?=($row['offer_remote']) ? "TAK" : "NIE" ?> | <?=$row['offer_max-devices']?> dev.</option>
    <?php
}
?>
</select>
<label for='expired'>Ważność </label>
<input type='date' name='expired'>
<h3>Konto administratora</h3>
<label for='nazwa'>Email</label>
<input type='text' name='email'>
<label for='nazwa'>Hasło</label>
<input type='text' name='pw'>
<button class='accept'>amkceptuj</button>
</form>
<?php
?>
<script>


$("form").submit(function(e) {

    e.preventDefault();
    $.ajax({
    type: "GET",
    url: "ajax/new-instance-form.php",
    data: {
      name: $(this).children('input[name=name]').val(),
      sdomain: $(this).children('input[name=sdomain]').val(),
      offer: $(this).children('select').val(),
      expired : $(this).children('input[name=expired]').val(),
      email: $(this).children('input[name=email]').val(),
      pw: $(this).children('input[name=pw]').val()
    },
    dataType: "json",
    success: function (zmienna) {
      if(zmienna['ans']=="1"){
        $("#content").html("<h2>Utworzyłem nową instancję!</h2>");
      }
    },
  });
});

// $("#new-instance").on('submit',function(e){
// e.preventDefault();
// alert("X");

// })
</script>