<?php


if(!isset($_SESSION)){
    session_start();
}

//include("includes/dbcon.php");
include("user.php");


class Phone
{
    private $dbCon;
    private $pdo;
    private $user;

    function __construct()
    {
        $this->dbCon = new DBConn();
        $this->pdo = $this->dbCon->getInstance();
        $this->user = new User();
    }

    function displayPhones(){
        if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
            if($_SESSION['role']!=="manager"||$_SESSION['role']!=="admin"||$_SESSION['role']!=="user"){
                try{
                    $sql = "SELECT * FROM phones ORDER BY date desc LIMIT 20";
                    $statement = $this->pdo->prepare($sql);
                    $statement->execute();
                    $returnData = "";

                    while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
                        $vendorImg = "";
                        $carrierImg = "";

                        if(strtolower($result['vendor'])=="android"){
                            $vendorImg = "<i class=\"fa fa-android\"></i>";
                        }
                        else if(strtolower($result['vendor'])=="apple"){
                            $vendorImg = "<i class=\"fa fa-apple\"></i>";
                        }else{
                            $vendorImg = "<i class=\"fa fa-credit-card\"></i>";
                        }
                        if(strtolower($result['carrier'])=="sprint"){
                            $carrierImg = "<img src='vendor/icons/Sprint.svg' class='sprintLogo'>";
                        }else if(strtolower($result['carrier'])=="verizon"){
                            $carrierImg = "<img src='vendor/icons/verizon.svg' class='verizonLogo'>";
                        }else if(strtolower($result['carrier'])=='att'){
                            $carrierImg = "<img src='vendor/icons/AT&T.svg' class='attLogo'>";
                        }else{
                            $carrierImg = "<i class=\"fa fa-globe\"></i>";
                        }
                        //$date = date_format($result['date'],"d/m/Y");
                        $display =  "<div class='container phonerow col-md-12'>";
                        $display .= "<div class='row'>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Vendor:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata clearfix'>".$vendorImg."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Carrier:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata'>".$carrierImg."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-2 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Phone:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata'>".$result['phonetype']."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>IMEI:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata'>".$result['imei']."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Employee:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata clearfix'>".$result['employee']."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Manager:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata'>".$result['manager']."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-2 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Date:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata'>".$result['date']."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Designation:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata'>".$result['designation']."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "</div>";
//                        $display .= "<div class='col-md-1 phonedata'>";
//                        $display .= "<p class='phonedataTitle'>Brightstar: </br><span class='phonedata'>".$result['brightstar']."</span></p>";
//                        $display .= "</div>";
//                        $display .= "<div class='col-md-1 phonedata'>";
//                        $display .= "<p class='phonedataTitle'>Walkin: </br><span class='phonedata'>".$result['walkin']."</span></p>";
//                        $display .= "</div>";
                        $display .= "<div class='col-md-2 btngrp'>";
                        $display .= "<a class='userbtn useredit phoneedit' href='editphone.php?phoneid=".$result['id']."'><i class='fa fa-pencil'></i>Edit Phone</a></br>";
//                        $display .= "<a class='userbtn userdelete phonedelete' href='nopullphone.php?phoneid=".$result['id']."'><i class=\"fa fa-trash\"></i>No Pull</a>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "</div>";

//                        echo $display;
                        $returnData.= $display;
                    }
                    return $returnData;
                }catch (PDOException $exc){
//                    echo "<div class='alert alert-danger'>Users could not be displayed</div>";
                    return "<div class='alert alert-danger'>Phones could not be displayed</div>";
                }
            }else{
//                echo "<div class='alert alert-warning'>You cannot view users</div>";
                return "<div class='alert alert-warning'>You cannot view phones</div>";
            }
        }else{
//            echo "<div class='alert alert-warning'>You are not logged in</div>";
            return "<div class='alert alert-warning'>You are not logged in</div>";
        }
    }

    function createPhone($phoneData){
        $message = "";

        $isRealManager = $this->user->verifyManager($phoneData['manager'],$phoneData['managerPassword']);
        if($isRealManager){
            $phoneExists = $this->checkPhoneExists($phoneData['imei']);
            if(!$phoneExists){
                try{
                    $sql = "INSERT INTO phones (vendor,carrier,phonetype,imei,employee,manager,date,designation)
                        VALUES (:vendor,:carrier,:phonetype,:imei,:employee,:manager,:date,:designation)";
                    $statement = $this->pdo->prepare($sql);
//
//                    if($phoneData['designation']==="pickup"){
//                        $statement->bindValue(':designation',"pickup");
//                    }elseif($phoneData['designation']==="brightstar"){
//                        $statement->bindValue(':designation',"brightstar");
//                    }elseif($phoneData['designation']==="walkin"){
//                        $statement->bindValue(':designation',"walkin");
//                    }elseif($phoneData)
                    $statement->bindValue('date',date("Y-m-d H:i:s"));
                    $statement->bindValue('vendor',$phoneData['vendor']);
                    $statement->bindValue('carrier',$phoneData['carrier']);
                    $statement->bindValue('phonetype',$phoneData['phone']);
                    $statement->bindValue('imei',$phoneData['imei']);
                    $statement->bindValue('employee',$phoneData['employee']);
                    $statement->bindValue('manager',$phoneData['manager']);
                    $statement->bindValue('designation','inventory');
                    $success = $statement->execute();

                    if($success){
                        $message = "Phone was successfully added";
                    }else{
                        $message = "Could not add phone.";
                    }
                }catch(PDOException $exc){
                    $message = "An error occurred. Phone was not entered.";
                }
            }else{
                $message = "Phone already exists!";
            }
        }else{
            $message = "Could not verify manager " .$phoneData['manager']. " phone not added.";
//            $message = $isRealManager;

        }

        return $message;
    }

    function checkPhoneExists($imei){
        try{
            $sql = "SELECT * FROM phones WHERE imei=:imei LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement -> bindValue(':imei',$imei);
            $statement -> execute();


            if(($result=$statement->fetch(PDO::FETCH_ASSOC))===false){
                return (false);
            }else{
                return (true); //phone exists
            }

        }catch (PDOException $exc){
            return ("error");
        }
    }

    function getVendors(){
        try{
//            $sql = "SELECT DISTINCT vendor FROM phones";
            $sql = "SELECT vendorname FROM vendors";
            $statement = $this->pdo->prepare($sql);
            $statement->execute();

            $vendors = array();

            $resultData = "<option>Select..</option>";

            while(($result = $statement->fetch(PDO::FETCH_ASSOC))!==false){
                array_push($vendors,$result['vendor']);
            }

            foreach($vendors as $vendor){
                $resultData.="<option>".$vendor."</option>";
            }
            return $resultData;
        }catch(PDOException $exc){
            return $error['vendors'] = ['error','error','error'];
        }
    }

    function loadVendorTable(){
        $returnData = "";

        try{
            $sql = "SELECT * FROM vendors";
            $statement = $this->pdo->prepare($sql);
            $statement->execute();



            while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
                $display ="<div class='card'>";
                if(strtolower($result['vendorname'])=="apple"){
                    $display.="<img class='card-img-top' src='vendor/icons/Apple_logo_black.svg'>";
                }else if(strtolower($result['vendorname'])=="android"){
                    $display.="<img class='card-img-top' src='vendor/icons/Android_robot.svg'>";
                }else{
                    $display.="<img class='card-img-top' src='vendor/icons/prepaid_logo.svg'>";
                }
                $display.="<div class='card-body'>";
                $display.="<h5 class='card-title'>".$result['vendorname']."</h5>";
                $display.="<p class='card-text'>Carriers</p>";
                $display.="<div class='vendorCarriers'>";

                foreach($result as $key => $value){
                    if(strpos($key,'supportedcarrier')!==false){
                        if($value!=""){
                            $display.="<p class='carrierName'>".$value."</p>";
                            $display.="<a href='removeCarrier.php?vendorid=".$result['vendorname']."&carrierid=".$value."' class='btn carrierDeleteBtn'><i class='fa fa-trash'></i>Delete</a>";
                            $display.="<div class='clearfix'></div>";
                        }
                    }
                }
//                if($result['supportedcarrier1']!=""){
//                    $display.="<p class='carrierName'>".$result['supportedcarrier1']."</p>";
//                    $display.="<a href='removeCarrier.php?vendorid=".$result['vendorname']."&carrierid=".$result['supportedcarrier1']."' class='btn carrierDeleteBtn'><i class='fa fa-trash'></i>Delete</a>";
//                    $display.="<div class='clearfix'></div>";
//                }

//                $display.="<p class='carrierName'>Verizon</p>";
//                $display.="<a href='removeCarrier.php?vendorid=&carrierid=' class='btn carrierDeleteBtn'><i class='fa fa-trash'></i>Delete</a>";
//                $display.="<div class='clearfix'></div>";
//                $display.="<p class='carrierName'>ATT</p>";
//                $display.="<a href='removeCarrier.php?vendorid=&carrierid=' class='btn carrierDeleteBtn'><i class='fa fa-trash'></i>Delete</a>";
//                $display.="<div class='clearfix'></div>";
//                $display.="<p class='carrierName'>New Carrier</p>";
                $display.="<input type='text' class='carrierName form-control' placeholder='New Carrier' name='newCarrier'></input>";
                $display.="<a href='#' class='btn carrierAddBtn'><i class='fa fa-plus'></i>Add</a>";
        $display.="</div>";
    $display.="</div>";
$display.="</div>";
$returnData.=$display;
            }
            //To be implemented - add vendors
//            if(($result=$statement->fetch(PDO::FETCH_ASSOC))===false){
//                $display ="<div class='card'>";
//                $display.="<img class='card-img-top' src='vendor/icons/Apple_logo_black.svg'>";
//                $display.="<div class='card-body'>";
//                $display.="<h5 class='card-title'>Apple</h5>";
//                $display.="<p class='card-text'>Carriers</p>";
//                $display.="<div class='vendorCarriers'>";
//                $display.="<p class='carrierName'>Sprint</p>";
//                $display.="<a href='removeCarrier.php?vendorid=&carrierid=' class='btn carrierDeleteBtn'><i class='fa fa-trash'></i>Delete</a>";
//                $display.="<div class='clearfix'></div>";
//                $display.="<p class='carrierName'>Verizon</p>";
//            $display.="<a href='removeCarrier.php?vendorid=&carrierid=' class='btn carrierDeleteBtn'><i class='fa fa-trash'></i>Delete</a>";
//            $display.="<div class='clearfix'></div>";
//            $display.="<p class='carrierName'>ATT</p>";
//            $display.="<a href='removeCarrier.php?vendorid=&carrierid=' class='btn carrierDeleteBtn'><i class='fa fa-trash'></i>Delete</a>";
//            $display.="<div class='clearfix'></div>";
//            $display.="<p class='carrierName'>New Carrier</p>";
//            $display.="<a href='removeCarrier.php?vendorid=&carrierid=' class='btn carrierAddBtn'><i class='fa fa-plus'></i>Add</a>";
//        $display.="</div>";
//    $display.="</div>";
//$display.="</div>";
//            }
        }catch (PDOException $exc){
            $returnData = "<div class='alert alert-danger'>Could not contact database</div>";
        }
        return($returnData);
    }

    function removeCarrier($vendor, $carrier){
        $returnData = "";

        try{
            $sql = "SELECT * FROM vendors";
            $statement = $this->pdo->prepare($sql);
            $statement->execute();

            $carrierColumnName = "";


            while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
                foreach ($result as $key=>$value){
                    if($value==$carrier){
                        $carrierColumnName=$key;
                        break;
                    }
                }
            }
            if($carrierColumnName==""){
                $returnData = "Could not find carrier ".$carrier." for vendor ".$vendor;
            }else{
                try{
                    $sql ="UPDATE vendors SET ".$carrierColumnName."=:carrierValue WHERE vendorname=:vendor LIMIT 1";
                    $statement = $this->pdo->prepare($sql);
                    $statement->bindValue('vendor',$vendor);
                    $statement->bindValue('carrierValue','');
                    if($statement->execute()){
                        $returnData = "Carrier removed";
                    }else{
//                        $returnData = "Carrier could not be removed";
                        $returnData =  $sql;
                    }
                }catch (PDOException $exc){
                   $returnData = "Could not contact database.";
                }
            }
        }catch (PDOException $exc){
            $returnData = "Could not contact database.";
        }
        return($returnData);
    }
    function getCarriers($vendor){
        try{
            $sql = "SELECT DISTINCT carrier FROM phones WHERE vendor=:vendor";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':vendor',$vendor);
            $statement->execute();

            $carriers = array();
            $returnData = "<option>Select...</option>";

            while(($result = $statement->fetch(PDO::FETCH_ASSOC))!==false){
                array_push($carriers,$result['carrier']);
            }
            foreach ($carriers as $carrier){
                $returnData.= "<option>".$carrier."</option>";
            }
            return $returnData;
        }catch(PDOException $exc){
            return $error = ['error','error','error'];
        }
    }
    function getPhones($vendor,$carrier){
        try{
            $sql = "SELECT DISTINCT phonetype FROM phones WHERE vendor=:vendor AND carrier=:carrier";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':vendor',$vendor);
            $statement->bindValue(':carrier',$carrier);
            $statement->execute();

            $phones = array();
            $returnData = "";

            while(($result = $statement->fetch(PDO::FETCH_ASSOC))!==false){
                array_push($phones,$result['phonetype']);
            }
            foreach ($phones as $phone){
                $returnData.="<option>".$phone."</option>";
            }
            return $returnData;
        }catch(PDOException $exc){
            return $error = ['error','error','error'];
        }
    }
    function searchPhone($searchTerm){

        $returnData = "";

        $vendorTerm = "";
        $carrierTerm = "";
        $phonetypeTerm = "";
        $imeiTerm = "";
        $employeeTerm = "";
        $managerTerm = "";
        $dateTerm = "";
        $designationTerm = "";
//        $brightstarTerm = "";
//        $walkinTerm = "";

        //regexs
        $vendorRegex = '/(?<=vendor:)(\s?.\S*)/';
        $carrierRegex = '/(?<=carrier:)(\s?.\S*)/';
        $imeiRegex='/(?<=imei:)(\s?.\S*)/';
        $phonetypeRegex='/(?<=phonetype:)(\s?.\S*)/';
        $employeeRegex='/(?<=employee:)(\s?.\S*)/';
        $managerRegex='/(?<=manager:)(\s?.\S*)/';
        $dateRegex='/(?<=date:)(\s?.\S*)/';
        $designationRegex='/(?<=designation:)(\s?.\S*)/';
//        $brightstarRegex='/(?<=brightstar:)(\s?.\S*)/';
//        $walkinRegex='/(?<=walkin:)(\s?.\S*)/';


        if(strpos($searchTerm, 'vendor:')!==false){
            preg_match($vendorRegex,$searchTerm,$vendorTerm);
        }
        if(strpos($searchTerm, 'carrier:')!==false){
            preg_match($carrierRegex,$searchTerm,$carrierTerm);
        }
        if(strpos($searchTerm, 'phone:')!==false){
            preg_match($phonetypeRegex,$searchTerm,$phonetypeTerm);
        }
        if(strpos($searchTerm, 'imei:')!==false){
            preg_match($imeiRegex,$searchTerm,$imeiTerm);
        }
        if(strpos($searchTerm, 'employee:')!==false){
            preg_match($employeeRegex,$searchTerm,$employeeTerm);
        }
        if(strpos($searchTerm, 'manager:')!==false){
            preg_match($managerRegex,$searchTerm,$managerTerm);
        }
        if(strpos($searchTerm, 'date:')!==false){
            preg_match($dateRegex,$searchTerm,$dateTerm);
        }
        if(strpos($searchTerm, 'designation:')!==false){
            preg_match($designationRegex,$searchTerm,$designationTerm);
        }
//        if(strpos($searchTerm, 'brightstar:')!==false){
//            preg_match($brightstarRegex,$searchTerm,$brightstarTerm);
//        }
//        if(strpos($searchTerm, 'walkin:')!==false){
//            preg_match($walkinRegex,$searchTerm,$walkinTerm);
//        }
        try{
            $sql = "SELECT * FROM phones WHERE vendor LIKE :vendor AND carrier LIKE :carrier AND phonetype LIKE :phonetype AND imei LIKE :imei AND
                    employee LIKE :employee AND manager LIKE :manager AND date LIKE :date AND designation LIKE :designation";
//            $sql = "SELECT * FROM phones WHERE vendor LIKE :vendor AND carrier LIKE :carrier";
            $statement = $this->pdo->prepare($sql);

            if(!empty($vendorTerm)){
                $statement->bindValue(':vendor',$vendorTerm[0]);
            }else{
                $statement->bindValue(':vendor',"%");
            }
            if(!empty($carrierTerm)){
                $statement->bindValue(':carrier',$carrierTerm[0]);
            }else{
                $statement->bindValue(':carrier',"%");
            }
            if(!empty($phonetypeTerm)){
                $statement->bindValue(':phonetype', $phonetypeTerm[0]);
            }else{
                $statement->bindValue(':phonetype',"%");
            }
            if(!empty($imeiTerm)){
                $statement->bindValue(':imei',$imeiTerm[0]);
            }else{
                $statement->bindValue(':imei',"%");
            }
            if(!empty($employeeTerm)){
                $statement->bindValue(':employee',$employeeTerm[0]);
            }else{
                $statement->bindValue(':employee',"%");
            }
            if(!empty($managerTerm)){
                $statement->bindValue(':manager',$managerTerm[0]);
            }else{
                $statement->bindValue(':manager',"%");
            }
            if(!empty($dateTerm)){
                $statement->bindValue(':date',$dateTerm[0]);
            }else{
                $statement->bindValue(':date',"%");
            }if(!empty($designationTerm)){
                $statement->bindValue(':designation',$designationTerm[0]);
            }else{
                $statement->bindValue(':designation',"%");
            }//if(!empty($brightstarTerm)){
//                $statement->bindValue(':brightstar',$brightstarTerm[0]);
//            }else{
//                $statement->bindValue(':brightstar',"%");
//            }if(!empty($walkinTerm)){
//                $statement->bindValue(':walkin',$walkinTerm[0]);
//            }else{
//                $statement->bindValue(':walkin',"%");
//            }

            $statement ->execute();


            while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
                $vendorImg = "";
                $carrierImg = "";

                if(strtolower($result['vendor'])=="android"){
                    $vendorImg = "<i class=\"fa fa-android\"></i>";
                }
                else if(strtolower($result['vendor'])=="apple"){
                    $vendorImg = "<i class=\"fa fa-apple\"></i>";
                }else{
                    $vendorImg = "<i class=\"fa fa-credit-card\"></i>";
                }
                if(strtolower($result['carrier'])=="sprint"){
                    $carrierImg = "<img src='vendor/icons/Sprint.svg' class='sprintLogo'>";
                }else if(strtolower($result['carrier'])=="verizon"){
                    $carrierImg = "<img src='vendor/icons/verizon.svg' class='verizonLogo'>";
                }else if(strtolower($result['carrier'])=='att'){
                    $carrierImg = "<img src='vendor/icons/AT&T.svg' class='attLogo'>";
                }else{
                    $carrierImg = "<i class=\"fa fa-globe\"></i>";
                }
                //$date = date_format($result['date'],"d/m/Y");
                $display =  "<div class='container phonerow col-md-12'>";
                $display .= "<div class='row'>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>Vendor:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata clearfix'>".$vendorImg."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>Carrier:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata'>".$carrierImg."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "<div class='col-md-2 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>Phone:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata'>".$result['phonetype']."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>IMEI:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata'>".$result['imei']."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>Employee:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata clearfix'>".$result['employee']."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>Manager:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata'>".$result['manager']."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "<div class='col-md-2 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>Date:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata'>".$result['date']."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<div class='row container'>";
                $display .= "<p class='phonedataTitle'>Designation:</p>";
                $display .= "</div>";
                $display .= "<div class='row container'>";
                $display .= "<span class='phonedata'>".$result['designation']."</span>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "</div>";
//                        $display .= "<div class='col-md-1 phonedata'>";
//                        $display .= "<p class='phonedataTitle'>Brightstar: </br><span class='phonedata'>".$result['brightstar']."</span></p>";
//                        $display .= "</div>";
//                        $display .= "<div class='col-md-1 phonedata'>";
//                        $display .= "<p class='phonedataTitle'>Walkin: </br><span class='phonedata'>".$result['walkin']."</span></p>";
//                        $display .= "</div>";
                $display .= "<div class='col-md-2 btngrp'>";
                $display .= "<a class='userbtn useredit phoneedit' href='editphone.php?phoneid=".$result['id']."'><i class='fa fa-pencil'></i>Edit Phone</a></br>";
//                        $display .= "<a class='userbtn userdelete phonedelete' href='nopullphone.php?phoneid=".$result['id']."'><i class=\"fa fa-trash\"></i>No Pull</a>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "</div>";

//                        echo $display;
                $returnData.= $display;
            }
            return $returnData;



        }catch (PDOException $exc){
            $returnData = "<div class='alert alert-danger'>Search could not be completed.</div>";
        }

        return($returnData);
    }
    function loadPhone($phoneid){
        $returnData = array();
        $phoneData = array();

        try{
            $sql = "SELECT * FROM phones WHERE id=:id LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':id',$phoneid);
            $statement->execute();

            if(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
                $phoneData['vendor'] = $result['vendor'];
                $phoneData['carrier'] = $result['carrier'];
                $phoneData['phonetype'] = $result['phonetype'];
                $phoneData['imei'] = $result['imei'];
                $phoneData['employee'] = $result['employee'];
                $phoneData['manager'] = $result['manager'];
                if($result['manager']==''){
                    $phoneData['manager'] = "System";
                }
                $phoneData['date'] = $result['date'];
                $phoneData['designation'] = $result['designation'];
            }else{
                $returnData['error'] = "<div class='alert alert-danger'>Could not edit phone</div>";
            }
            $returnData['phonedata']=$phoneData;
        }catch (PDOException $exc){
            $returnData['error']="<div class='alert alert-danger'>Could not edit phone</div>";
        }
        return($returnData);
    }
    function updatePhone($phoneData){

        $returnData = "";
        $isRealManager = $this->user->verifyManager($phoneData['manager'],$phoneData['managerpassword']);
        if($isRealManager){
            try{
                $sql = "UPDATE phones SET designation=:designation, employee=:employee, manager=:manager, date=:date WHERE id=:id LIMIT 1";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':designation',$phoneData['designation']);
                $statement->bindValue(':employee',$_SESSION['username']);
                $statement->bindValue(':manager',$phoneData['manager']);
                $statement->bindValue(':date',date("Y-m-d H:i:s"));
                $statement->bindValue(':id',$phoneData['phoneid']);
//                $statement->execute();

                if($statement->execute()){
                    $returnData = "Phone updated successfully";
                }else{
                    $returnData = "Could not update phone";
                }

            }catch (PDOException $exc){
                $returnData = "Could not update phone";
            }
        }else{
            $returnData="Could not verify manager ".$phoneData['manager'];
        }
        return ($returnData);
    }
    function noPullPhone($phoneid){

        $returnData = "";

        try{
            $sql = "UPDATE phones SET pulled = :pulled WHERE id=:id LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':pulled','0');
            $statement->bindValue('id',$phoneid);
            $statement->execute();

        }catch (PDOException $exc){
            $returnData = "<div class='alert alert-danger'>Could not update phone</div>";
        }
        return ($returnData);
    }
}