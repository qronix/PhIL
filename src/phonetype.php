<?php

class Phonetype{


    private $phonetypeName;
    private $phoneCount;

    function __construct($phonetypeName)
    {
        $this->phonetypeName= $phonetypeName;
        $this->phoneCount = 1;

        $phoneInfo = [
            'phoneType'=>$this->phonetypeName,
            'phoneCount'=>$this->phoneCount
        ];
        return($phoneInfo);
    }

    function getPhoneInfo(){

        $phoneInfo = [
          'phoneType'=>$this->phonetypeName,
            'phoneCount'=>$this->phoneCount
        ];

        return($phoneInfo);
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