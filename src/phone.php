<?php


if(!isset($_SESSION)){
    session_start();
}

include("includes/dbcon.php");
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

                    while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
                        //$date = date_format($result['date'],"d/m/Y");
                        $display =  "<div class='container phonerow col-md-9'>";
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
                        $display .= "<p class='phonedataTitle'>Pickup: </br><span class='phonedata'>".$result['storepickup']."</span></p>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 phonedata'>";
                        $display .= "<p class='phonedataTitle'>Brightstar: </br><span class='phonedata'>".$result['brightstar']."</span></p>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-2 btngrp'>";
                        $display .= "<a class='userbtn useredit phoneedit' href='editphone.php?userid=".$result['id']."'><i class='fa fa-pencil' aria-hidden='true'></i>edit</a></br>";
                        $display .= "<a class='userbtn userdelete phonedelete' href='deletephone.php?userid=".$result['id']."'><i class='fa fa-trash' aria-hidden='true'></i>delete</a>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "</div>";

                        echo $display;
                    }

                }catch (PDOException $exc){
                    echo "<div class='alert alert-danger'>Users could not be displayed</div>";
                }
            }else{
                echo "<div class='alert alert-warning'>You cannot view users</div>";
            }
        }else{
            echo "<div class='alert alert-warning'>You are not logged in</div>";
        }
    }

    function createPhone($phoneData){
        $isRealManager = $this->user->verifyManager($phoneData['manager'],$phoneData['managerPassword']);
        if($isRealManager){
            $phoneExists = $this->checkPhoneExists($phoneData['vendor'],$phoneData['carrier'],$phoneData['imei']);
            if(!$phoneExists){
                $sql = "INSERT INTO phones (vendor,carrier,phonetype,imei,employee,manager,date,storepickup,brightstar) VALUES ()";
            }else{
                return("Phone already exists!");
            }
        }else{
            return("Could not verify manager " .$phoneData['manager']. " phone not added.");
        }

    }

    function checkPhoneExists($vendor,$carrier,$imei){
        try{
            $sql = "SELECT * FROM phones WHERE vendor=:vendor, carrier=:carrier, imei=:imei LIMIT 1";
            $statement = $this->pdo->prepare($sql);
            $statement ->bindValue('vendor',$vendor);
            $statement -> bindValue('carrier',$carrier);
            $statement -> bindValue('imei',$imei);
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
}