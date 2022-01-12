<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!defined('MyConst')) {
    die('Direct access not permitted');
}

$amazon = new mysqli("192.168.101.64", "kajkosho_rcp", "Damwoz!4905", "kajkosho_amazon_sku");
require_once("vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

function ArrayToCSV($data, $cfilename)
{
    $fp = fopen($cfilename, 'wb+');
    $header = false;
    foreach ($data as $row) {
        fputcsv($fp, array_merge($row));
    }
    fclose($fp);
    return 1;
}
?>
<section class='m-auto rounded shadow-5-strong p-4 m-auto'>
    <div class='d-grid justify-content-center gap-3'>
        <div class='row'>
            <h1 class='text-center'>Generowanie pliku z Amazona</h1>
        </div>
        <form class="m-auto " method='get'>
            <div class='row'>
                <div class='col-6'>
                    <div>
                        <div class="form-outline mb-4">
                            <input type="text" id="form1Example1" name='sku' class="form-control" />
                            <label class="form-label" for="sku">SKU</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="form1Example1" name='nazwa' class="form-control" />
                            <label class="form-label" for="sku">Nazwa pliku</label>
                        </div>
                    </div>
                </div>
                <div class='col-6'>
                    <div>
                        <div class="form-outline mb-4">
                            <input type="decimal" id="form1Example1" value='5.1' name='narzut' class="form-control" />
                            <label class="form-label" for="narzut">Dzielnik</label>
                        </div>
                    </div>
                </div>
            </div>
            <input type='hidden' name='site' value='generator'>
            <button type="submit" class="btn btn-primary btn-block">WCZYTAJ PLIK</button>
        </form>
        <div class='row w-100 m-auto'>
            <a href='https://bstock.com/amazoneu/' target="_blank" class='btn btn-secondary'>AUKCJE</a>
        </div>






        <?php

        if (isset($_GET['sku'])) {




            $url = 'https://m.bstock.com/m/downloads/get?site=a2z&sku=' . $_GET['sku'] . '&file_type=csv';

            // Use basename() function to return the base name of file  
            $file_name = basename($_GET['nazwa']);

            // Use file_get_contents() function to get the file 
            // from url and use file_put_contents() function to 
            // save the file by using base name 
            if (file_put_contents("nav/generator/files/" . $file_name, file_get_contents($url))) {
                echo "File downloaded successfully";
                if (($fh = fopen("nav/generator/files/" . $_GET['nazwa'], "r")) !== FALSE) {

                    //Setup a PHP array to hold our CSV rows.
                    $csvData = array();

                    //Loop through the rows in our CSV file and add them to
                    //the PHP array that we created above.
                    while (($row = fgetcsv($fh, 0, ",")) !== FALSE) {
                        $csvData[] = $row;
                    }

                    //Finally, encode our array into a JSON string format so that we can print it out.



                    fclose($fh);
                    $checks = ['CONDITION', 'SUBCATEGORY', 'ASIN', 'EAN', 'Item Desc', 'QTY', 'CURRENCY CODE', 'COST', 'TOTAL RETAIL', 'LPN'];
                    echo "<form method='GET' class='generator'>";
                    $i = 0;
                    foreach ($csvData[0] as $x) {
                        if (in_array($x, $checks)) {
                            echo "<input type='checkbox' id='" . $x . "' value='" . $i . "' name='cut_this[]' checked>";
                        } else {
                            echo "<input type='checkbox' id='" . $x . "' value='" . $i . "' name='cut_this[]'>";
                        }

                        echo "<label for='" . $x . "'> # " . $i . " | " . $x . "</label></br>";
                        $i++;
                    }
                    echo "<input type='checkbox' id='cut_this' value='H' name='cut_this[]' checked='checked'> ";
                    echo "<label for='cut_this'>Czy dodać hiperłącze na końcu? ( Musi być zaznaczony ASIN )</label>";
                    echo "<input type='hidden' value='" . $_GET['sku'] . "' name='sku_second'>";
                    echo "<input type='hidden' value='" . $_GET['nazwa'] . "' name='nazwa'>";
                    echo "<input type='hidden' value='" . $i . "' name='count'> ";
                    echo "<input type='hidden' value='" . $_GET['narzut'] . "' name='narzut'> ";
                    echo "<input type='submit' value='Wyciągnij'>";
                    echo "<input type='hidden' name='site' value='generator'>";
                    echo "</form>";
                }
            } else {
                echo "File downloading failed.";
            }
        }









        // // print_r($csv[0]);


        // echo "A";
        if (isset($_GET['cut_this'])) {
            if (($fh = fopen("nav/generator/files/" . $_GET['nazwa'], "r")) !== FALSE) {
                $csvData = array();

                //Loop through the rows in our CSV file and add them to
                //the PHP array that we created above.
                while (($row = fgetcsv($fh, 0, ",")) !== FALSE) {
                    $csvData[] = $row;
                }
            }
            // print_r($csvData);
            $i = 0;
            $j = 0;
            $html = "<table>";
            $total_retail = 0;
            $thead = [];
            foreach ($csvData as $x) {

                if ($i == 0) {
                    // print_r($x);
                    $asin = array_search("ASIN", $x);
                }
                $html .= "<tr>";
                $z = 0;
                foreach ($_GET['cut_this'] as $y) {
                    if ($y == $asin) {
                        $link = $x[$y];
                    }
                    if ($j == 0) {
                        if ($i == 0) {
                            if ($y == "H") {
                                $thead[$z] = "Link";
                            } else {
                                $thead[$z] = $x[$y];
                            }
                        }
                    }
                    if ($y == "H") {
                        if ($i == 0) {
                            $thi[] = "Link";
                            $html .= "<td>Link</td>";
                            $i++;
                        } else {

                            $html .= "<td><a href='https://www.amazon.de/gp/product/" . $link . "'>LINK</a></td>";
                        }
                    } else {
                        $thi[] = $x[$y];
                        switch ($thead[$z]) {
                            case 'TOTAL RETAIL': //total retail
                                $total_retail += floatval($x[$y]);
                                if ($i == 0) {
                                    $html .= "<td>TOTAL RETAIL</td>";
                                } else {
                                    $html .= "<td>" . floatval($x[$y]) . "</td>";
                                }
                                break;
                            case 'COST':
                                if ($i == 0) {
                                    $html .= "<td>COST</td>";
                                } else {
                                    $html .= "<td> " . floatval($x[$y]) . "</td>";
                                }
                                break;
                            default:
                                if ($i == 0) {
                                    $html .= "<td>" . $thead[$z] . "</td>";
                                } else {
                                    $html .= "<td> " . $x[$y] . "</td>";
                                }
                                break;
                        }
                    }

                    $z++;
                }
                $j = 1;
                echo "</tr>";
                $ans[] = $thi;
                $thi = [];
            }
            // print_r($thead);
            $total_retail = number_format($total_retail, 2, ".", "");
            $wart_pln = number_format(($total_retail * 4.6), 2, ".", "");
            $kwot_pln = number_format($wart_pln / $_GET['narzut'], 2, ".", "");
            $transp = number_format(1850.00, 2, ".", "");
            $lacz_koszt_n = number_format($kwot_pln + $transp, 2, ".", "");
            $lacz_koszt_b = number_format($lacz_koszt_n * 1.23, 2, ".", "");

            // $wart_pln = "1";
            // $kwot_pln = "2";
            // $transp = "3";
            // $lacz_koszt_n = "4";
            // $lacz_koszt_b = "5";
            $html .= "
    <tr></tr>
    <tr></tr>
    <tr style='border:1px solid black'>
    <td>Wartość stoku w EURO</td><td>" . $total_retail . "</td>
    </tr>
    <tr style='border:1px solid black'>
    <td>Wartość stoku w PLN 4,6</td><td class='background-color:red'>" . $wart_pln . "</td>
    </tr>
    <tr style='border:1px solid black'>
    <td>Kwota kupna w PLN netto</td><td>" . $kwot_pln . "</td>
    </tr>
    <tr style='border:1px solid black'>
    <td>Koszt transportu netto</td><td>" . $transp . "</td>
    </tr>
    <tr style='border:1px solid black'>
    <td>Łączny koszt stoku netto</td><td>" . $lacz_koszt_n . "</td>
    </tr>
    <tr style='border:1px solid black;background-color:green'>
    <td>Łączny koszt stoku brutto</td><td>" . $lacz_koszt_b . "</td>
    </tr>

    ";
        ?>
    </div>
    <?php
            $a = ArrayToCSV($ans, "nav/generator/files/" . $_GET['nazwa'] . ".csv");
            if ($a == 1) { //1
                $spreadsheet = new Spreadsheet();
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
                $spreadsheet = $reader->loadFromString($html);

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
                $writer->save("nav/generator/files/" . $_GET['nazwa'] . '.xls');
                echo "<div class='row w-50 m-auto py-3'><a class='btn btn-success' href='nav/generator/files/" . $_GET['nazwa'] . ".xls'>POBIERZ GOTOWY PLIK!</a></div>";
                unset($spreadsheet);
                // $reader->setDelimiter(',');
                // $reader->setEnclosure('"');
                // $reader->setSheetIndex(0);
                // /* Load a CSV file and save as a XLS */
                // $spreadsheet = $reader->load("nav/generator/files/".$_GET['sku_second'].".csv");

                // 
                // $writer->setEnclosureRequired(false);
                // $writer->save("nav/generator/files/".$_GET['sku_second'].'.xls');
                // $spreadsheet->disconnectWorksheets();
                // echo "PLIK gotowy do pobrania ";
                $sql = "INSERT INTO `sku_input`(`input_user`, `input_value`) VALUES ('" . $user['user_email'] . "','" . $_GET['sku_second'] . "')";
                mysqli_query($amazon, $sql);
            } else {
                echo "błąd!!!!!";
            }
        }

        if ($_SESSION['prv'] >= 2) {
    ?>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Aktywność
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-mdb-parent="#accordionExample">
                <div class="accordion-body">



                    <?php




                    $sql = "SELECT * FROM `sku_input`";
                    $result = mysqli_query($amazon, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo " -> " . $row['input_user'] . " | " . $row['input_value'] . " | " . $row['input_time'] . "<br>";
                    }

                    ?>

                </div>
            </div>

        <?php
        }
        ?>
        </div>
        <?php


        $html = file_get_contents('https://bstock.com/amazoneu/');
        $only_body = preg_replace(["/.*<body[^>]*>|<\/body>.*/si", "#<script(.*?)>(.*?)</script>#is"], "", $html);
        ?>
        <div id='pageInner'>
            <h3 class='text-center m-2'>Aktualne aukcje ;) </h3>
            <ul></ul>
        </div>
        <div style='display:none' id='pageContent'>
            <?php
            print_r($only_body);
            ?>
        </div>
        <script>
            $(document).ready(function() {
                $("#pageContent .product-info").each(function() {
                    var div = document.createElement('li');
                    let ht = $(this).find(".product-name").html();
                    let time = $(this).find(".time_remaining strong span").attr('data-end-time');
                    div.innerHTML = ht.trim();
                    var btn = document.createElement('button');
                    var date = new Date(Date.parse(time));

                    let str = $(div).find('a').text();
                    var mySubString = str.substring(
                        str.indexOf("(") + 1,
                        str.lastIndexOf(")")
                    );

                    btn.classList.add("btn", 'btn-primary', 'btn-sm', 'p-1', 'm-1')
                    btn.setAttribute('sku',mySubString.slice(4))
                    btn.innerHTML = "UZUPEŁNIJ"
                   div.prepend(btn)
                    div.prepend("Date: " + date.getDate() +
                        "/" + (date.getMonth() + 1) +
                        "/" + date.getFullYear() +
                        " " + date.getHours() +
                        ":" + date.getMinutes() +
                        ":" + date.getSeconds() + " ");
                    $(div).find('a').attr("target", "_blank")
                    console.log(btn)
                    $("#pageInner ul").append(div);

                })
            })

            $(document).on('click','button[sku]',function(){
                let sku = $(this).attr('sku')
                console.log(sku)
                $("input[name=sku]").val(sku)
                $("input[name=sku]").focus();
            })
        </script>
        <?php
        // $doc = new DOMDocument;
        // libxml_use_internal_errors(true);
        // $doc->loadHTML($html);
        // print_R($doc);
        // echo "0-0000000000000000000000</br></br></br>";
        // foreach($doc->getElementsByTagName('div') as $ptag)
        // {
        //     if($ptag->getAttribute('class')=="product-name")
        //     {
        //         // print_r($ptag);
        //         echo $ptag->textContent."</br></br>"; //"prints" Some text
        //     }
        // }
        ?>
</section>