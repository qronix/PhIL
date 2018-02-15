<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin"){
    include("includes/header.php");
    include("includes/sidebar.php");
    include("phone.php");
    $phone = new Phone();
//    $returnData = $phone->loadVendorTable();
}else{
    session_destroy();
    header("Location: index.php");
}

//echo $returnData;


?>

<div id="vendorPanel" class="container col-md-10">
    <div id="vendorPanelHeader" class="row">
        <h2>Vendors</h2>
    </div>
</div>

<div class="container col-md-10 vendorContainer">
<div class="card">
    <img class="card-img-top" src="vendor/icons/Apple_logo_black.svg">
    <div class="card-body">
        <h5 class="card-title">Apple</h5>
        <p class="card-text">Carriers</p>
        <div class="vendorCarriers">
            <p class="carrierName">Sprint</p>
            <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
            <div class="clearfix"></div>
            <p class="carrierName">Verizon</p>
            <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
            <div class="clearfix"></div>
            <p class="carrierName">ATT</p>
            <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
            <div class="clearfix"></div>
            <p class="carrierName">New Carrier</p>
            <a href="#" class="btn carrierAddBtn"><i class="fa fa-plus"></i>Add</a>
        </div>
    </div>
</div>
    <div class="card">
        <img class="card-img-top" src="vendor/icons/Android_robot.svg">
        <div class="card-body">
            <h5 class="card-title">Android</h5>
            <p class="card-text">Carriers</p>
            <div class="vendorCarriers">
                <p class="carrierName">Sprint</p>
                <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
                <div class="clearfix"></div>
                <p class="carrierName">Verizon</p>
                <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
                <div class="clearfix"></div>
                <p class="carrierName">ATT</p>
                <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
                <div class="clearfix"></div>
                <p class="carrierName">New Carrier</p>
                <a href="#" class="btn carrierAddBtn"><i class="fa fa-plus"></i>Add</a>
            </div>
        </div>
    </div>
    <div class="card">
        <img class="card-img-top" src="vendor/icons/prepaid_logo.svg">
        <div class="card-body">
            <h5 class="card-title">Prepaid</h5>
            <p class="card-text">Carriers</p>
            <div class="vendorCarriers">
                <p class="carrierName">Sprint</p>
                <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
                <div class="clearfix"></div>
                <p class="carrierName">Verizon</p>
                <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
                <div class="clearfix"></div>
                <p class="carrierName">ATT</p>
                <a href="#" class="btn carrierDeleteBtn"><i class="fa fa-trash"></i>Delete</a>
                <div class="clearfix"></div>
                <p class="carrierName">New Carrier</p>
                <a href="#" class="btn carrierAddBtn"><i class="fa fa-plus"></i>Add</a>
            </div>
        </div>
    </div>
</div>
