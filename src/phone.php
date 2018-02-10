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
                        //$date = date_format($result['date'],"d/m/Y");
                        $display =  "<div class='container phonerow col-md-12'>";
                        $display .= "<div class='row'>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Vendor:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata clearfix'>".$result['vendor']."</span>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<div class='row container'>";
                        $display .= "<p class='phonedataTitle'>Carrier:</p>";
                        $display .= "</div>";
                        $display .= "<div class='row container'>";
                        $display .= "<span class='phonedata'>".$result['carrier']."</span>";
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
//                        $display .= "<a class='userbtn useredit phoneedit' href='pullphone.php?phoneid=".$result['id']."'><i class='fa fa-check'></i>Pull</a></br>";
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
            $sql = "SELECT DISTINCT vendor FROM phones";
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
                //$date = date_format($result['date'],"d/m/Y");
                $display =  "<div class='container phonerow col-md-12'>";
                $display .= "<div class='row'>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>Vendor: </br><span class='phonedata'>".$result['vendor']."</span></p>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>Carrier: </br><span class='phonedata'>".$result['carrier']."</span></p>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>Phone: </br><span class='phonedata'>".$result['phonetype']."</span></p>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>IMEI: </br><span class='phonedata'>".$result['imei']."</span></p>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>Employee: </br><span class='phonedata'>".$result['employee']."</span></p>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>Manager: </br><span class='phonedata'>".$result['manager']."</span></p>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>Date: </br><span class='phonedata'>".$result['date']."</span></p>";
                $display .= "</div>";
                $display .= "<div class='col-md-1 phonedata'>";
                $display .= "<p class='phonedataTitle'>Designation: </br><span class='phonedata'>".$result['designation']."</span></p>";
                $display .= "</div>";
//                $display .= "<div class='col-md-1 phonedata'>";
//                $display .= "<p class='phonedataTitle'>Brightstar: </br><span class='phonedata'>".$result['brightstar']."</span></p>";
//                $display .= "</div>";
//                $display .= "<div class='col-md-1 phonedata'>";
//                $display .= "<p class='phonedataTitle'>Walkin: </br><span class='phonedata'>".$result['walkin']."</span></p>";
//                $display .= "</div>";
                $display .= "<div class='col-md-2 btngrp'>";
//                $display .= "<a class='userbtn useredit phoneedit' href='pullphone.php?phoneid=".$result['id']."'><i class='fa fa-check'></i>Pull</a></br>";
//                $display .= "<a class='userbtn userdelete phonedelete' href='nopullphone.php?phoneid=".$result['id']."'><i class=\"fa fa-trash\"></i>No Pull</a>";
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
    function pullPhone($phoneid){

        $returnData = "";

        try{
            $sql = "UPDATE phones SET pulled = :pulled WHERE id=:id LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(':pulled','1');
            $statement->bindValue('id',$phoneid);
            $statement->execute();

        }catch (PDOException $exc){
            $returnData = "<div class='alert alert-danger'>Could not update phone</div>";
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