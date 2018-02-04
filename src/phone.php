<?php


if(!isset($_SESSION)){
    session_start();
}

include("includes/dbcon.php");

class Phone
{
    private $dbCon;
    private $pdo;

    function __construct()
    {
        $this->dbCon = new DBConn();
        $this->pdo = $this->dbCon->getInstance();
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
}