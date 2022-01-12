<?php
echo "AAA!!0";
$html = file_get_contents('https://rcp.o4s.pl:4444/');
$curl = curl_init('https://rcp.o4s.pl'); 
curl_setopt($curl, CURLOPT_PORT, 4444); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 4444); 
echo $result = curl_exec($curl);
        ?>
        <div id='pageInner'>
            <h3 class='text-center m-2'>Aktualne aukcje ;) AS 2</h3>
            <ul></ul>
        </div>
        <div
             id='pageContent'>
            <?php
            print_r($html);
            ?>
        </div>
