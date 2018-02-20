<?php

class Phonetype{


    private $phonetypeName;
    private $phoneCount;
    private $carrier;

    function __construct($phonetypeName,$carrier)
    {
        $this->phonetypeName= $phonetypeName;
        $this->carrier = $carrier;
        $this->phoneCount = 1;

        $phoneInfo = [
            'phoneType'=>$this->phonetypeName,
            'phoneCount'=>$this->phoneCount,
            'carrier'=>$this->carrier
        ];
        return($phoneInfo);
    }

    function getPhoneInfo(){

        $phoneInfo = [
          'phoneType'=>$this->phonetypeName,
            'phoneCount'=>$this->phoneCount,
            'carrier'=>$this->carrier
        ];

        return($phoneInfo);
    }

    function getCarrier(){
        return $this->carrier;
    }

    function getPhoneType(){
        return $this->phonetypeName;
    }

    function getCount(){
        return $this->phoneCount;
    }

    function addtoCount(){
        $this->phoneCount+=1;
    }
}