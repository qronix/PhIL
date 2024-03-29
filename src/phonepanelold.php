<?php

if(!isset($_SESSION)){
    session_start();
}

$returnData = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin"){
    include("includes/header.php");
    include("includes/sidebar.php");
    include_once("phone.php");
    $phone = new Phone();
    $returnData = $phone->loadVendorTable();
}else{
    session_destroy();
    header("Location: index.php");
}



?>

<div id="phonePanel" class="container col-md-10">
    <div id="phonePanelHeader" class="row">
        <h2>Phones</h2>
    </div>
</div>

<div class="container col-md-10 vendorContainer">
    <?php
    if($returnData!=""){
        echo $returnData;
    }else{
        echo "<div class='alert alert-danger'>Could not load vendors</div>";
    }
    ?>
</div>

<script type="text/javascript">
    $(".carrierDeleteBtn").click(function(event){

        var vendor = this.href.match(/(?<=vendorid=).*(?=&)/);
        var carrier = this.href.match(/(?<=&carrierid=).*(?=)/);
        carrier[0]=carrier[0].replace(/%20/g," ");

        var formData = {
            vendor: vendor[0],
            carrier: carrier[0]
        };
        $.ajax({
            type:'POST',
            url:'removeCarrier.php',
            data:formData,
            dataType:'json',
            encode: true
        }).done(function(data){
            // location.reload();
            console.log(data);
        });
        event.preventDefault();
    });

    var addCarrierBtns = document.querySelectorAll("a[id*='addCarrierBtnFor']");

    addCarrierBtns.forEach(function(btn){
        btn.addEventListener("click",function(event){
            var vendorName = btn.id.match(/(?<=addCarrierBtnFor).*(?=)/);
            var carrierInputId = "newCarrierNameFor"+vendorName[0];
            var newCarrierName = document.getElementById(carrierInputId).value;
            // console.log("DING");
            $.ajax({
                type:"POST",
                url:'addCarrier.php',
                data:{
                    vendor:vendorName[0],
                    newCarrier:newCarrierName
                },
                dataType: 'json',
                encode:true
            }).done(function(data){
                console.log(data);
            });
            event.preventDefault();
        });
    });
</script>
