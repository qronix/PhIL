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
<div class="row vendorRow">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-1 vendorDataCol">
                <div class="row vendorDataRow">
                    <p>Vendor</p>
                </div>
                <div class="row vendorData">
                    <p>Apple</p>
                </div>
            </div>
            <div class="col-md-1 vendorDataCol">
                <div class="row vendorDataRow">
                    <p>Carriers</p>
                </div>
                <div class="row vendorData">
                    <p>Verizon</p>
                    <p>Sprint</p>
                    <p>ATT</p>
                    <p>Unlocked</p>
                </div>
            </div>
            <div class="col-md-1 vendorDataCol">
                <div class="row vendorDataRow">
                    <p>Count</p>
                </div>
                <div class="row vendorData">
                    <p>459</p>
                </div>
            </div>
        </div>
        <div class="row">
            <a class='userbtn userdelete' href='deleteuser.php?userid='><i class='fa fa-trash' aria-hidden='true'></i>Delete</a>
        </div>
    </div>
</div>
<div class="row vendorRow">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-1 vendorDataCol">
                <div class="row vendorDataRow">
                    <p>Vendor</p>
                </div>
                <div class="row vendorData">
                    <p>Apple</p>
                </div>
            </div>
        </div>
    </div>
</div>
