<?php

include_once ("phonetype.php");

$phonetypes = array();

$newPhoneType = new Phonetype("supercoolphone");

$phonetypes["supercoolphone"] = $newPhoneType;


$newPhoneType = new Phonetype("megacoolphone");

array_push($phonetypes,$newPhoneType);


//$phonetypes['supercoolphone']->addtoCount();

if(isset($phonetypes["supercoolphone"])){
    $phonetypes["supercoolphone"]->addtoCount();
    $phonetypes["supercoolphone"]->addtoCount();
    $phonetypes["supercoolphone"]->addtoCount();
    print_r($phonetypes["supercoolphone"]->getPhoneInfo());
    $count = $phonetypes["supercoolphone"]->getCount();
    echo $count;
}