<?php


$multiImeis = array();
$phoneData = array();
$cleanArray = array();

$imeiInputString = "4'8615,4521'23,111312f55";


$multiImeis = explode(',',$imeiInputString);

//clean array

foreach ($multiImeis as $imei =>$value){
    $multiImeis[$imei] = preg_replace('/[^0-9]/','',$value);
}


foreach ($multiImeis as $imei =>$value){
    if(strlen($value)!==6){
        unset($multiImeis[$imei]);
    }
}
foreach ($multiImeis as $imei => $value){
    if(is_numeric($value)){
        array_push($cleanArray,$value);
    }else{
        $errors['imei'] = "Not a valid imei or imei batch";
    }
}
print_r($cleanArray);

?>