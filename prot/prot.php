<?php
require("PHPMailer/Exception.php");
require("PHPMailer/PHPMailer.php");
require("PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $mail = new PHPMailer(true);
//Odbiorca id prim
//id wiadomosci


function SendMail($adres,$nazwa){
    try {
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->Host       = 'wn14.webd.pl'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'help@o4s.pl';
    $mail->Password   = '!o4s_Kajko?'; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->isHTML(true);
    $mail->setFrom('help@o4s.pl', 'O4S');
    $mail->addAddress($adres, $nazwa); //do kogo
    $mail->Body  = "Dzień dobry</br>
<br>
Serdecznie przepraszamy za utrudnienia, ale niestety hurtownia nie dostarczyła nam towaru na czas.Z tego powodu dostawa zamówionych przez Państwa kosmetyków marki Solverx opóźni się. Planowany czas wysyłki towaru to wtorek / środa po świętach. Prosimy o wyrozumiałość. </br>
</br>
Życzymy Państwu radosnych i spokojnych Świąt Wielkanocnych. </br>
</br>
Pozdrawiamy</br>
Zespół O4Season";
    $mail->Subject = "Opóźnienie twojego zamówienia w naszym sklepie"; 

    $mail->send();
    return "OK";

} catch (Exception $e) {
   echo "<br>Błąd przy wysyłaniu maila: {$mail->ErrorInfo}\n";
}
}


$arr = ["qwecyhq8as+4f09df005@allegromail.pl",
"nw78dvgzl2+7bdbdf718@allegromail.pl",
"n11kprc3cr+263acd944@allegromail.pl",
"r3qhrkk7t0+3462c13e6@allegromail.pl",
"hrlwafsgqc+3158efd48@allegromail.pl"];
print_r($arr);
foreach($arr as $z){
    echo "X ";
    echo SendMail($z,$z);
}
?>
