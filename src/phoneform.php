
<?php

include ("phone.php");
include ("includes/header.php");

$phone = new Phone();
$vendors = array();
$selectedCarrier = "";
$selectedVendor = "apple";
$vendors = $phone->getVendors();
$carriers = $phone->getCarriers($selectedVendor);

$phones = array();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['vendor'])&&!empty($_POST['vendor'])){
        $selectedVendor= filter_input(INPUT_POST,'vendor');
        $carriers = $phone->getCarriers($selectedVendor);
    }
    if(isset($_POST['carrier'])&&!empty($_POST['carrier'])){
        $selectedCarrier= filter_input(INPUT_POST,'carrier');
    }
//    if($selectedCarrier!=""&&$selectedVendor!=""){
//        $phones = $phone->getPhones();
//    }
//    $message['carrier'] = strip_tags($selectedVendor);
//    echo json_encode($message);
}


?>

<div class="container editusercontainer col-sm-10">
    <div class="row">
        <div class="container" id="form-message">

        </div>
    </div>
    <div class="row">
        <h2>Add new phone</h2>
    </div>
    <div class="row">
        <div class="container col-md-12" id="editPhoneArea">
            <form id="edit-form-phone" class="col-md-12" action="createphone.php" method="POST">
                <div class="form-group phoneedit" id="vendor-group">
                    <label for="vendor">Vendor</label>
<!--                    <input type="text" class="form-control" name="vendor" id="vendor" required>-->
                        <select class='form-control' name='vendor' id="vendor" required>

                            <?php foreach ($vendors as $vendor){
                                echo "<option>".$vendor."</option>";
                            }?>
<!--                            <option>manager</option>-->
<!--                            <option>admin</option>-->
<!--                            <option>user</option>-->
                        </select>
                </div>
                <div class="form-group phoneedit" id="carrier-group">
                    <label for="carrier">Carrier</label>
<!--                    <input type="text" class="form-control" name="carrier" id="carrier" required>-->
                    <select id='carrier' class='form-control' name='carrier' required>

                        <?php
                        $carriers = $phone->getCarriers($selectedVendor);
                        foreach ($carriers as $carrier){
                            echo "<option>".$carrier."</option>";
                        }?>
                        <!--                            <option>manager</option>-->
                        <!--                            <option>admin</option>-->
                        <!--                            <option>user</option>-->
                    </select>
                </div>
                <div class="form-group phoneedit" id="phone-group">
                    <label for="phone">Phone</label>
<!--                    <input type="text" class="form-control" name="phone" id="phone" required>-->
                    <select id='phone' class='form-control' name='phone' required>

                        <?php
                        if($selectedCarrier!=""&&$selectedVendor!=""){
                            $phones = $phone->getPhones();
                        }
                        foreach ($phones as $phoneObj){
                            echo "<option>".$phoneObj."</option>";
                        }?>
                        <!--                            <option>manager</option>-->
                        <!--                            <option>admin</option>-->
                        <!--                            <option>user</option>-->
                    </select>
                </div>
                <div class="form-group phoneedit" id="imei-group">
                    <label for="imei">IMEI</label>
                    <input type="text" class="form-control" name="imei" id="imei" required>
                </div>
                <!--                <div class="form-group phoneedit" id="employee-group">-->
                <!--                    <label for="employee">Employee</label>-->
                <!--                    <input type="text" id="employee" class="form-control" name="employee">-->
                <!--                </div>-->
                <div class="form-group phoneedit" id="manager-group">
                    <label for="manager">Manager</label>
                    <input type="text" id="manager" class="form-control" name="manager" required>
                </div>
                <div class="form-group phoneedit" id="manager-password-group">
                    <label for="manager">Manager Password</label>
                    <input type="password" id="managerPassword" class="form-control" name="managerPassword" required>
                </div>
                <!--                <div class="form-group editinput" id="date-group">-->
                <!--                    <label for="date">Date</label>-->
                <!--                    <input type="text" id="date" class="form-control" name="date">-->
                <!--                </div>-->
                <div class="form-group phoneedit" id="designation-group">
                    <input class="phoneradio" type="radio" name="designation" value="pickup"><span>Pickup</span>
                    <input class="phoneradio" type="radio" name="designation" value="brightstar"><span>Brightstar</span>
                    <input class="phoneradio" type="radio" name="designation" value="brightstar"><span>Walk-in</span>
                </div>
                <div class="form-group">
                    <button type="submit" id="addPhoneBtn" class="btn">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#vendor').change(function(){
    var formData={
        'vendor' : document.querySelector("#vendor").value
    };
    $.ajax({
        type:'POST',
        url:'phoneform.php',
        data: formData,
        dataType: 'json',
        encode: true
    }).done(function(data){
       console.log(data);
       // if(data.success){
       //     $("#carrier-group-group").load(" #carrier-group");
       // }
    });
     $("#carrier-group").load(" #carrier-group");
});
$('#carrier').change(function(){
    var formData={
        'carrier' : document.querySelector("#carrier").value
    };
    $.ajax({
        type:'POST',
        url:'phoneform.php',
        data: formData,
        dataType: 'json',
        encode: true
    }).done(function(data){
        console.log(data);
    });
});
</script>