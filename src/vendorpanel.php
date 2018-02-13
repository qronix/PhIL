<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin"){
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
    <div class="row vendorRow">
        <div class="container-fluid col-md-12">
            <div class="row">
                <div class="col-md-1 vendorData">
                    <p>Vendor</p>
                </div>
                <div class="col-md-1 vendorData">
                    <p>Carrier 1</p>
                </div>
                <div class="col-md-1 vendorData">
                    <p>Carrier 2</p>
                </div>
                <div class="col-md-1 vendorData">
                    <p>Carrier 3</p>
                </div>
                <div class="col-md-1 vendorData">
                    <p>Carrier 4</p>
                </div>
            </div>
        </div>
    </div>
</div>
