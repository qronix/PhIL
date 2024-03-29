<?php

session_start();
include ("includes/header.php");
include ("includes/sidebar.php");
include ("phone.php");

$phone = new Phone();

$resultData = array();
$phoneData = array();
$errorMsg = "";
$phoneid = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
    if(isset($_GET['phoneid'])&&!empty($_GET['phoneid'])){
        $phoneid = filter_input(INPUT_GET,'phoneid');
        $_SESSION['phoneeditid'] = $phoneid;
        $resultData = $phone->loadPhone($phoneid);
    }else{
        $errorMsg = "<div class='alert alert-danger'>No phone id provided</div>";
    }


    if(isset($resultData['error'])&&$resultData['error']!==''){
        $errorMsg = $resultData['error'];
    }
    if(isset($resultData['phonedata'])&&$resultData['phonedata']){
        $phoneData = $resultData['phonedata'];
    }
}else{
    header("Location: index.php");
}

?>

<div class="container editusercontainer col-sm-11" id="editphoneForm">
    <div class="row">
        <div class="container" id="form-message">
            <?php if($errorMsg!==""){
                echo $errorMsg;
            }?>
        </div>
    </div>
    <div class="row">
        <h2>Edit phone</h2>
    </div>
    <div class="row">
        <div class="container col-md-12" id="editPhoneArea">
            <form id="edit-form-phone" class="col-md-12 form-horizontal" action="updatephone.php" method="POST">
                <div class="form-row editPhoneRow">
                    <div class="form-group phoneedit col-md-4" id="vendor-group">
                        <div class="row phoneeditRow">
                            <label for="vendor">Vendor:</label>
                        </div>
                        <div class="row phoneeditRow">
                            <span id="vendor"><?php echo $phoneData['vendor'];?></span>
                        </div>
                    </div>
                    <div class="form-group col-md-4 phoneedit" id="carrier-group">
                        <div class="row phoneeditRow">
                            <label for="carrier">Carrier:</label>
                        </div>
                        <div class="row phoneeditRow">
                            <span id="carrier"><?php echo $phoneData['carrier'];?></span>
                        </div>
                    </div>
                </div>
                <div class="form-row editPhoneRow">
                    <div class="form-group col-md-4 phoneedit" id="phone-group">
                        <div class="row phoneeditRow">
                            <label for="phone">Phone:</label>
                        </div>
                        <div class="row phoneeditRow">
                            <span id="phonetype"><?php echo $phoneData['phonetype'];?></span>
                        </div>
                    </div>
                    <div class="form-group col-md-4 phoneedit" id="imei-group">
                        <div class="row phoneeditRow">
                            <label for="imei">IMEI:</label>
                        </div>
                        <div class="row phoneeditRow">
                            <span id="imei"><?php echo $phoneData['imei'];?></span>
                        </div>
                    </div>
                </div>
                <div class="form-row editPhoneRow">
                    <div class="form-group col-md-4 phoneedit" id="manager-group">
                        <div class="row phoneeditRow">
                            <label for="manager">Manager</label>
                        </div>
                        <div class="row phoneeditRow">
                            <input type="text" id="manager" class="form-control" name="manager" required>
                        </div>
                    </div>
                    <div class="form-group col-md-4 phoneedit" id="manager-password-group">
                        <div class="row phoneeditRow">
                            <label for="manager">Manager Password</label>
                        </div>
                        <div class="row phoneeditRow">
                            <input type="password" id="managerPassword" class="form-control" name="managerPassword" required>
                        </div>
                    </div>
                </div>
                <div class="form-row editPhoneRow">
                    <div class="form-group col-md-4 phoneedit" id="designation-group">
                        <div class="row phoneeditRow">
                            <label for="designation">Designation:</label>
                        </div>
                        <div class="row phoneeditRow">
                            <select class="form-control" id="phonedesignation">
                                <option>Inventory</option>
                                <option>Lost</option>
                                <option>Brightstar</option>
                                <option>Pickup</option>
                                <option>Walkin</option>
                                <option>Transfer</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row ">
                            <button type="submit" id="editPhoneBtn" class="btn">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var form = document.getElementById("#edit-form-phone");

    $("#edit-form-phone").submit(function(event){
        var formData = {
            vendor: document.getElementById("vendor").innerText,
            carrier: document.getElementById("carrier").innerText,
            phonetype: document.getElementById("phonetype").innerText,
            imei:document.getElementById("imei").innerText,
            manager:document.getElementById("manager").value,
            managerpassword:document.getElementById("managerPassword").value,
            designation:document.getElementById("phonedesignation").value
        };
       $.ajax({
         type:'POST',
         url:'updatephone.php',
         data: formData,
         encode:true
       }).done(function(data){
           var result = JSON.parse(data);
        if(result.message){
              $("#form-message").append(result.message);
          }
        if(result.errors){
           if(result.errors.manager){
               $("#form-message").append(result.errors.manager);
           }
            if(result.errors.phoneid){
                $("#form-message").append(result.errors.phoneid);
            }
            if(result.errors.managerpassword){
                $("#form-message").append(result.errors.managerpassword);
            }
            if(result.errors.designation){
                $("#form-message").append(result.errors.designation);
            }
        }
       });
        event.preventDefault();
        $("#form-message").fadeTo(2000, 500).slideUp(500, function(){
            $("#form-message").slideUp(500);
        });
        $("#form-message").html("");
        $("#manager").val("");
        $("#managerPassword").val("");
        $("#phonedesignation").val("Inventory");

    });

</script>
