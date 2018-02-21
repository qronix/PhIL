
<?php

//include ("phone.php");
//include ("includes/header.php");


$phone = new Phone();

?>

<div class="container editusercontainer col-sm-11">
    <div class="row">
        <div class="container" id="form-message">

        </div>
    </div>
    <div class="row">
        <h2>Add new phone</h2>
    </div>
    <div class="row">
        <div class="container col-md-12" id="editPhoneArea">
            <form id="edit-form-phone" class="col-md-12 form-horizontal" action="createphone.php" method="POST">
                <div class="form-row">
                    <div class="form-group phoneedit col-md-4" id="vendor-group">
                        <label for="vendor">Vendor</label>
                        <select class='form-control selectbox' name='vendor' id="vendor" required>
                            <?php
                            echo $phone->getVendors();
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4 phoneedit" id="carrier-group">
                        <label for="carrier">Carrier</label>

                        <select id='carrier' class='form-control selectbox' name='carrier' required>

                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4 phoneedit" id="phone-group">
                        <label for="phone">Phone</label>

                        <select id='phone' class='form-control selectbox' name='phone' required>

                        </select>
                    </div>
                    <div class="form-group col-md-4 phoneedit" id="imei-group">
                        <label for="imei">IMEI</label>
                        <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" name="imei" id="imei" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <button type="submit" id="addPhoneBtn" class="btn">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#vendor').change(function(){
    $("#phone").html("");
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
    $("#phone").html("");
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