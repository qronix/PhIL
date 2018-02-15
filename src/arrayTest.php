<?php

$result = array();

$result['id'] = 2;
$result['supportedcarrier1'] = "Carrier 1";
$result['supportedcarrier2'] = "Carrier 2";
$result['supportedcarrier3'] = "Carrier 3";
$result['supportedcarrier4'] = "Carrier 4";
$result['supportedcarrier5'] = "Carrier 5";
$result['magic'] = "Carrier 6";
$result['iscool'] = "Carrier 7";


function displayArray($array){

    $resultData = "";

    foreach ($array as $key => $value){
        if(strpos($key,'supportedcarrier')!==false){
            $resultData .= "<div class='container'>".$value."</div>";
        }
    }

    echo($resultData);
}


?>

<div class="container">
    <?php

    displayArray($result);

    ?>
</div>
