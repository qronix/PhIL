
<?php

//include ("phone.php");
//include ("includes/header.php");


$phone = new Phone();

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
                        <select class='form-control' name='vendor' id="vendor" required>
                            <?php
                                echo $phone->getVendors();
                            ?>
                        </select>
                </div>
                <div class="form-group phoneedit" id="carrier-group">
                    <label for="carrier">Carrier</label>

                    <select id='carrier' class='form-control' name='carrier' required>

                    </select>
                </div>
                <div class="form-group phoneedit" id="phone-group">
                    <label for="phone">Phone</label>

                    <select id='phone' class='form-control' name='phone' required>

                    </select>
                </div>
                <div class="form-group phoneedit" id="imei-group">
                    <label for="imei">IMEI</label>
                    <input type="text" class="form-control" name="imei" id="imei" required>
                </div>

                <div class="form-group phoneedit" id="manager-group">
                    <label for="manager">Manager</label>
                    <input type="text" id="manager" class="form-control" name="manager" required>
                </div>
                <div class="form-group phoneedit" id="manager-password-group">
                    <label for="manager">Manager Password</label>
                    <input type="password" id="managerPassword" class="form-control" name="managerPassword" required>
                </div>

                <div class="form-group phoneedit" id="designation-group">
                    <input class="phoneradio" type="radio" name="designation" value="pickup"><span>Pickup</span>
                    <input class="phoneradio" type="radio" name="designation" value="brightstar"><span>Brightstar</span>
                    <input class="phoneradio" type="radio" name="designation" value="walkin"><span>Walk-in</span>
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
        url:'loadphoneform.php',
        data: formData,
        // dataType: 'json',
        encode: true
    }).done(function(data){
       $("#carrier").html(data);
    });
});
$('#carrier').change(function(){
    var formData={
        'vendor' : document.querySelector("#vendor").value,
        'carrier' : document.querySelector("#carrier").value
    };
    $.ajax({
        type:'POST',
        url:'loadphoneform.php',
        data: formData,
        // dataType: 'json',
        encode: true
    }).done(function(data){
        $("#phone").html(data);
    });
});

</script>