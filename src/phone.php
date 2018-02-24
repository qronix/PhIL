<?php


if(!isset($_SESSION)){
    session_start();
}

//include("includes/dbcon.php");
include_once("user.php");


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
//            if($_SESSION['role']!=="manager"||$_SESSION['role']!=="admin"||$_SESSION['role']!=="user"){ //what the hell is this nonsense Jon?
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
//                        $display .= "<div class='clearfix'></div>";
                        $display .= "<div class='col-md-8 btngrp'>";
                        $display .= "<a class='userbtn useredit phoneedit' href='editphone.php?phoneid=".$result['id']."'><i class='fa fa-pencil'></i>Edit Phone</a></br>";
                        if($_SESSION['role']=="admin"||$_SESSION['role']=="superuser"){
                            $display .= "<a class='userbtn useredit phoneremove' href='deletephone.php?phoneid=".$result['id']."'><i class='fa fa-trash'></i>Remove Phone</a></br>";
                        }
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "</div>";


                        $returnData.= $display;
                    }
                    return $returnData;
                }catch (PDOException $exc){
                    return "<div class='alert alert-danger'>Phones could not be displayed</div>";
                }
//            }else{
//                return "<div class='alert alert-warning'>You cannot view phones</div>";
//            }
        }else{
            return "<div class='alert alert-warning'>You are not logged in</div>";
        }
    }

    function createPhone($phoneData){
        $message = "";

            $phoneExists = $this->checkPhoneExists($phoneData['imei']);
            if(!$phoneExists){
                try{
                    $sql = "INSERT INTO phones (vendor,carrier,phonetype,imei,employee,manager,date,designation)
                        VALUES (:vendor,:carrier,:phonetype,:imei,:employee,:manager,:date,:designation)";
                    $statement = $this->pdo->prepare($sql);
                    $statement->bindValue('date',date("Y-m-d H:i:s"));
                    $statement->bindValue('vendor',$phoneData['vendor']);
                    $statement->bindValue('carrier',$phoneData['carrier']);
                    $statement->bindValue('phonetype',$phoneData['phone']);
                    $statement->bindValue('imei',$phoneData['imei']);
                    $statement->bindValue('employee',$phoneData['employee']);
                    $statement->bindValue('manager','SYSTEM');
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
        return $message;
    }

    function deletePhone($phoneId){
        $resultData = "";

        try{
            $sql = "DELETE FROM phones WHERE id=:phoneid LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue('phoneid',$phoneId);
            if($statement->execute()){
                $resultData = "Phone was successfully removed";
            }else{
                $resultData = "Could not delete phone from database";
            }
        }catch (PDOException $exc){
            $resultData = "Could not contact the database";
        }
        return($resultData);
    }

    function createPhoneType($vendorname,$newPhoneType,$carrier){

        //check existence of phone type
        $resultData = "";

        try{
            $sql = "SELECT id FROM phonetypes WHERE vendor=:vendorname AND 
              carrier=:carriername AND phonetype=:phonetype";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue('vendorname',$vendorname);
            $statement->bindValue('carriername',$carrier);
            $statement->bindValue('phonetype',$newPhoneType);
            $phoneTypeIsNew = false;
            $count = -1;


            if($statement->execute()){
                if(($result=$statement->fetch(PDO::FETCH_ASSOC))===false){
                    $phoneTypeIsNew = true;
                    $resultData = $result['id'];
                }
                else{
                    while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false) {
                        if ($result['phonetype'] == $newPhoneType) {
                            $resultData = "Phone type: " . $newPhoneType . " already exists.";
                            $phoneTypeIsNew = false;
                        }
                    }
                }
            }else{
                $resultData = "Could not contact database.";
            }
            if($phoneTypeIsNew){
                $sql = "INSERT INTO phonetypes (vendor,phonetype,carrier) VALUES (:vendor, :phonetype, :carrier)";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue('vendor',$vendorname);
                $statement->bindValue('carrier',$carrier);
                $statement->bindValue('phonetype',$newPhoneType);
                if($statement->execute()){
                    $resultData = "Phone type: ". $newPhoneType. " was added to vendor: ".$vendorname;
                }else{
                    $resultData = "Could not add phone type to database.";
                }
            }else{
                $resultData = "Phone already exists";
            }
        }catch (PDOException $exc){
            $resultData = "Could not contact database.";
        }
        return($resultData);
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
            $sql = "SELECT DISTINCT vendorname FROM vendors";
            $statement = $this->pdo->prepare($sql);

            $vendors = array();

            $resultData = "<option>Select..</option>";

            if($statement->execute()){


                while(($result = $statement->fetch(PDO::FETCH_ASSOC))!==false){
                    array_push($vendors,$result['vendorname']);
                }

                foreach($vendors as $vendor){
                    $resultData.="<option>".$vendor."</option>";
                }
            }else{
                $resultData.="<option>Error</option>";
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
                $display.="<input type='text' id='newCarrierNameFor".$result['vendorname']."'class='carrierName form-control' placeholder='New Carrier' name='newCarrier'></input>";
                $display.="<a href='#' class='btn carrierAddBtn' id='addCarrierBtnFor".$result['vendorname']."'><i class='fa fa-plus'></i>Add</a>";
        $display.="</div>";
    $display.="</div>";
$display.="</div>";
$returnData.=$display;
            }

        }catch (PDOException $exc){
            $returnData = "<div class='alert alert-danger'>Could not contact database</div>";
        }
        return($returnData);
    }

    function removeCarrier($vendor, $carrier){
        $returnData = "";

        try{
            $sql = "SELECT * FROM vendors WHERE vendorname=:vendor";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue('vendor',$vendor);
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
                        $returnData = "Carrier could not be removed";

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
            $sql = "SELECT * FROM vendors WHERE vendorname=:vendor";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':vendor',$vendor);
            $statement->execute();

            $carriers = array();
            $returnData = "<option>Select...</option>";

            while(($result = $statement->fetch(PDO::FETCH_ASSOC))!==false){
                foreach ($result as $key => $value){
                    if(strpos($key,'supportedcarrier')!==false){
                        if($value!==""){
                            array_push($carriers,$value);
                        }
                    }
                }
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
            $sql = "SELECT DISTINCT phonetype FROM phonetypes WHERE vendor=:vendor AND carrier=:carrier";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':vendor',$vendor);
            $statement->bindValue(':carrier',$carrier);

            if($statement->execute()){
                $phones = array();
                $returnData = "";

                while(($result = $statement->fetch(PDO::FETCH_ASSOC))!==false){
                    array_push($phones,$result['phonetype']);
                }
                foreach ($phones as $phone){
                    $returnData.="<option>".$phone."</option>";
                }
            }else{
                $returnData = "Could not get phones";
            }
            return $returnData;
        }catch(PDOException $exc){
            return $error = ['error','error','error'];
        }
    }


    function loadPhoneTypesPanel()
    {

        include_once("phonetype.php");

        $resultData = "";
        $vendorList = array();
        $display = "";

        try {
            //grab vendor list
            $sql = "SELECT DISTINCT vendorname FROM vendors";
            $statement = $this->pdo->prepare($sql);
            if ($statement->execute()) {
                while (($result = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
                    if (!in_array($result['vendorname'], $vendorList)) {
                        array_push($vendorList, $result['vendorname']);
                    }
                }
                foreach ($vendorList as $vendorname) {

                    $display .= "<div class='card'>";
                    $display .= "<div class='card-header' id='headingOne'>";
                    $display .= "<h5 class='mb-0'>";
                    $display .= "<button class='btn btn-link' data-toggle='collapse' data-target='#collapse" . $vendorname . "' aria-expanded='true' aria-controls='collapseOne'>";
                    if(strtolower($vendorname)=="apple"){
                        $display .= "<i class='fa fa-apple vendorlistIcon'></i>".$vendorname;
                    }else if(strtolower($vendorname)=="android"){
                        $display .= "<i class='fa fa-android vendorlistIcon'></i>".$vendorname;
                    }else{
                        $display .= "<i class='fa fa-globe vendorlistIcon vendorlistGlobeIcon'></i><p class='unlockedVendorList'>".$vendorname."</p>";
                    }
                    $display .= "</button>";
                    $display .= "</h5>";
                    $display .= "</div>";
                    $display .= "<div id='collapse" . $vendorname . "' class='collapse show' aria-labelledby='headingOne' data-parent='#accordion'>";
                    $display .= "<div class='card-body'>";
                    $display .= "<div class='container phoneSearchContainer'>";
                    $display .= "<label for='searchInput' class='phoneSearchLabel'>Search:</label>";
                    $display .= "<input type='text' name='searchInput' id='" . $vendorname . "PhoneSearch' class='form-control phoneSearchField' placeholder='Enter phone name...'>";
                    $display .= "</div>"; //end search container
                    $display .= "<div class='clearfix'></div>";
                    $display .= "<div class='container col-md-12 phonePanelContainer'>";
                    $display .= "<ul class='list-group vendorPhonePanel' id='" . $vendorname . "PhoneList'>";

                    $sql = "SELECT phonetype, carrier FROM phonetypes WHERE vendor=:vendorname";
                    $statement = $this->pdo->prepare($sql);
                    $statement->bindValue('vendorname', $vendorname);

                    if ($statement->execute()) {
                        $phonetypes = array();
//
                        while (($result = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
                            if (!isset($phonetypes[$result['phonetype']])) {
                                $newPhoneType = new Phonetype($result['phonetype'], $result['carrier']);
                                $phonetypes[$result['phonetype']] = $newPhoneType;

                            } else if (isset($phonetypes[$result['phonetype']]) &&
                                $phonetypes[$result['phonetype']]->getCarrier() != $result['carrier']) {
                                $newPhoneType = new Phonetype($result['phonetype'], $result['carrier']);
                                $phonetypes['('.$result['carrier'].')'.$result['phonetype']] = $newPhoneType;
                            } else {
                                $phonetypes[$result['phonetype']]->addtoCount();
                            }
                        }
//                        //get counts
                        foreach ($phonetypes as $phonetype) {
                            try {
                                $sql = "SELECT * FROM phones WHERE phonetype=:phonetype AND vendor=:vendor AND carrier=:carrier AND designation=:designation";
                                $statement = $this->pdo->prepare($sql);
                                $statement->bindValue('phonetype', $phonetype->getPhoneType());
                                $statement->bindValue('vendor', $vendorname);
                                $statement->bindValue('designation', "inventory");
                                $statement->bindValue('carrier', $phonetype->getCarrier());

                                if ($statement->execute()) {
                                    while (($result = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
                                        $phonetype->addtoCount();
                                    }
                                } else {
                                    $resultData = "Could not get counts";
                                }
                            } catch (PDOException $exc) {
                                $resultData = "Could not connect to database";
                            }

                            $display .= "<div class='row phoneTypeRow container-fluid'>";
                            $display .= "<li class=' phonePanelLi list-group-item d-flex justify-content-between align-items-center'>";

                            $display .= "<div class='col-md-3'>";
                            $display .= "<p class='phonePanelPhoneName'>" . $phonetype->getPhoneType() . "</p>";
                            $display .= "</div>"; //end type col
                            $thisPhoneCarrier = $phonetype->getCarrier();
                            $carrierImg = "";
                            if (strtolower($thisPhoneCarrier) == "sprint") {
                                $carrierImg = "<img src='vendor/icons/Sprint.svg' class='sprintLogoPhonePanel'>";
                            } else if (strtolower($thisPhoneCarrier) == "verizon") {
                                $carrierImg = "<img src='vendor/icons/verizon.svg' class='verizonLogoPhonePanel'>";
                            } else if (strtolower($thisPhoneCarrier) == 'att') {
                                $carrierImg = "<img src='vendor/icons/AT&T.svg' class='attLogoPhonePanel'>";
                            } else {
                                $carrierImg = "<i class=\"fa fa-globe panelListGlobe\"></i>";
                            }
                            $display .= "<div class='col-md-3'>";
                            $display .= $carrierImg;
                            $display .= "</div>"; //end carrier img col
                            $display .= "<div class='col-md-1'>";
                            $display .= "<span class='badge badge-primary badge-pill'>" . $phonetype->getCount() . "</span>";
                            $display .= "</div>"; //end count col
                            $display .= "<div class='col-md-3'>";

                            $display .= "<button class='btn userbtn phonePanelDeleteBtn' id='" . $vendorname . ":" . $phonetype->getPhoneType() . "#" . $phonetype->getCarrier() . "'><i class='fa fa-trash phonePanelTrashIcon'></i>Delete</button>";
                            $display .= "</div>"; //end button col
                            $display .= "</li>"; //end list
                            $display .= "</div>"; //end row

                        }//end for each
                        $display .= "<div class='container phoneAddContainer'>";
                        $display .= "<label for='phoneName' class='phoneNameLabel'>Add new phone type:</label>";
                        $display .= "<input type='text' name='phoneName' class='form-control phonePanelNameInput' id='" . $vendorname . "NewPhoneName'>";
                        $display .= "<label for=$vendorname.'carrierName' class='phoneNameLabel'>Carrier:</label>";
                        $display .= "<select id='" . $vendorname . "carrierNames' class='form-control selectbox carrierSelectBox' name='carrier' required>";
                        $display .= $this->getCarriers($vendorname);
                        $display .= "</select>";
                        $display .= "<button class='btn userbtn addPhoneBtn'><i class='fa fa-plus'></i>Add</button>";
                        $display .= "</div>";
                        $display .= "</ul>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "</div>";
                    } else {
                        $resultData = "Could not retreive phones for vendor: " . $vendorname;
                        return ($resultData);
                    }
                    }
                }else{
                    $resultData = "Could not load vendors.";
                }
                }catch(PDOException $exc){
                    $resultData = "Could not contact database";
                }

        if ($resultData == "") {
            $resultData = $display;
        }
        return ($resultData);
    }
    function removePhoneType($vendor,$phonetype,$carrier){
        $resultData = "";

        try{

            $sql = "DELETE FROM phonetypes WHERE vendor=:vendor AND phonetype=:phonetype AND carrier=:carrier LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue('vendor',$vendor);
            $statement->bindValue('phonetype',$phonetype);
            $statement->bindValue('carrier',$carrier);

            if($statement->execute()){
                $resultData = $phonetype." was successfully removed from " .$vendor;
            }else{
                $resultData = "Could not remove phone type.";
            }
        }catch (PDOException $exception){
            $resultData = "Could not contact database.";
        }
        return($resultData);
    }
    function addCarrier($vendor, $newCarrier){

        try{
            //check carrier does not exist for vendor
            $sql = "SELECT * from vendors WHERE vendorname=:vendorname";
            $statement = $this->pdo->prepare($sql);
            $statement ->bindValue('vendorname',$vendor);
            $canAddCarrier = false;
            $availableCarrierSlot = "";

            if($statement->execute()){
                while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false) {
                    foreach($result as $key=>$value){
                        if($value==$newCarrier){
                            return "Carrier already exists";
                        }
                        if(strpos($key,'supportedcarrier')!==false){
                            //a carrier slot is available
                            if($value==""){
                                $availableCarrierSlot = $key;
                                $canAddCarrier = true;
                            }
                        }
                    }
                }
                if($canAddCarrier){
                    $sql = "UPDATE vendors SET ".$availableCarrierSlot."=:carriername WHERE vendorname=:vendorname LIMIT 1";
                    $statement = $this->pdo->prepare($sql);
                    $statement->bindValue('carriername',$newCarrier);
                    $statement->bindValue('vendorname',$vendor);
                    if($statement->execute()){
                        return("Carrier was successfully added to ".$vendor);
                    }else{
                        return("Could not add carrier to database for vendor ".$vendor);
                    }
                }else{
                    return "Carrier limit reached";
                }
            }else{
                return "Could not check for existence of carrier";
            }
        }catch (PDOException $exc){
            return ("Could not contact database");
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


        //regexs
        $vendorRegex = '/(?<=vendor:)(\s?.\S*)/';
        $carrierRegex = '/(?<=carrier:)(\s?.\S*)/';
        $imeiRegex='/(?<=imei:)(\s?.\S*)/';
        $phonetypeRegex='/(?<=phonetype:)(\s?.\S*)/';
        $employeeRegex='/(?<=employee:)(\s?.\S*)/';
        $managerRegex='/(?<=manager:)(\s?.\S*)/';
        $dateRegex='/(?<=date:)(\s?.\S*)/';
        $designationRegex='/(?<=designation:)(\s?.\S*)/';

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

        try{
            $sql = "SELECT * FROM phones WHERE vendor LIKE :vendor AND carrier LIKE :carrier AND phonetype LIKE :phonetype AND imei LIKE :imei AND
                    employee LIKE :employee AND manager LIKE :manager AND date LIKE :date AND designation LIKE :designation";

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
            }

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
                $display .= "<div class='col-md-2 btngrp'>";
                $display .= "<a class='userbtn useredit phoneedit' href='editphone.php?phoneid=".$result['id']."'><i class='fa fa-pencil'></i>Edit Phone</a></br>";
                $display .= "</div>";
                $display .= "</div>";
                $display .= "</div>";
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