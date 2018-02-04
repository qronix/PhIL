<?php
session_start();
if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    header("Location: index.php");
}
include("includes/header.php");
include("includes/sidebar.php");
include("phone.php");


if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']!="admin"){
    header("Location: dashboard.php");
}

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
                    <input type="text" class="form-control" name="vendor" id="vendor" required>
                </div>
                <div class="form-group phoneedit" id="carrier-group">
                    <label for="carrier">Carrier</label>
                    <input type="text" class="form-control" name="carrier" id="carrier" required>
                </div>
                <div class="form-group phoneedit" id="phone-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" required>
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
                    <input type="text" id="manager" class="form-control" name="manager">
                </div>
                <div class="form-group phoneedit" id="manager-password-group">
                    <label for="manager">Manager Password</label>
                    <input type="password" id="managerPassword" class="form-control" name="managerPassword">
                </div>
<!--                <div class="form-group editinput" id="date-group">-->
<!--                    <label for="date">Date</label>-->
<!--                    <input type="text" id="date" class="form-control" name="date">-->
<!--                </div>-->
                <div class="form-group phoneedit" id="designation-group">
                    <input class="phoneradio" type="radio" name="designation" value="pickup"><span>Pickup</span>
                    <input class="phoneradio" type="radio" name="designation" value="brightstar"><span>Brightstar</span>
                </div>
                <div class="form-group">
                    <button type="submit" id="addPhoneBtn" class="btn">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container editusercontainer col-sm-10">
    <div class="row">
        <div class="container" id="form-message">

        </div>
    </div>
    <div class="row">
        <h2>Phone list</h2>
    </div>
    <div class="row">
        <div class="container col-md-6" id="searchPhoneArea">
            <form id="phone-search" class="col-md-12" action="createphone.php" method="POST">
                <div class="form-group phonesearch" id="phonesearch">
                    <input class="text form-control" name="phonesearch" id="phonesearch" placeholder="imei, employee, phone...">
                </div>
                <div class="form-group">
                    <button type="submit" id="phonesearchBtn" class="btn"><i class="fa fa-search"></i>Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="userlist">
    <?php
    if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin") {
        ?>
        <script type="text/javascript">
            function clearUsers(){
                var userrows = document.querySelectorAll(".phonerow");
                userrows.forEach(function(user){
                    user.parentNode.removeChild(user);
                });
            }
            //clearUsers();
        </script>
        <?php
        $phone->displayPhones();
    }?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".main").fadeIn(2000);
    });

    $(function(){
        var form=$('#edit-form-phone');
        var formMessage =$('#form-message');

        $(form).submit(function(event){

            $('.alert').remove();
            var formData = {
                'vendor' : $('input[name=vendor]').val(),
                'carrier' : $('input[name=carrier').val(),
                'phone' : $('input[name=phone]').val(),
                'imei' : $('input[name=imei]').val(),
                // 'employee' : $('input[name=employee]').val(),
                'manager' : $('input[name=manager]').val(),
                'managerPassword' : $('input[name=managerPassword]').val(),
                'designation' : $('input[name=designation]:checked').val()
            };
            $.ajax({
                type:'POST',
                url:$(form).attr('action'),
                data: formData,
                dataType: 'json',
                encode: true
            }).done(function(data){
                console.log(data);
                if(data.errors!==undefined){
                    if(data.errors.vendor!==undefined){
                        $('#vendor-group').append("<div class='alert alert-danger'>"+data.errors.vendor+"</div>");
                    }
                    if(data.errors.carrier!==undefined){
                        $('#carrier-group').append("<div class='alert alert-danger'>"+data.errors.carrier+"</div>");
                    }
                    if(data.errors.phone!==undefined){
                        $('#phone-group').append("<div class='alert alert-danger'>"+data.errors.phone+"</div>");
                    }
                    if(data.errors.imei!==undefined){
                        $('#imei-group').append("<div class='alert alert-danger'>"+data.errors.imei+"</div>");
                    }
                    if(data.errors.manager!==undefined){
                        $('#manager-group').append("<div class='alert alert-danger'>"+data.errors.manager+"</div>");
                    }
                    if(data.errors.managerPassword!==undefined){
                        $('#manager-password-group').append("<div class='alert alert-danger'>"+data.errors.managerPassword+"</div>");
                    }
                    if(data.errors.designation!==undefined){
                        $('#designation-group').append("<div class='alert alert-danger'>"+data.errors.designation+"</div>");
                    }
                }
                if(data.message!==undefined){
                    $(formMessage).append("<div class='alert alert-warning'>"+data.message+"</div>");
                }
            });
            $('#vendor').val('');
            $('#carrier').val('');
            $('#phone').val('');
            $('#imei').val('');
            $('#employee').val('');
            $('#manager').val('');

            event.preventDefault();
            // $(".userrow").remove();
            // $.ajax({url:"getphones.php"}).done(function(html){
            //     $("#userlist").append(html);
            // });
            $("#form-message").fadeTo(2000, 500).slideUp(500, function(){
                $("#form-message").slideUp(500);
            });
        });
    });
</script>
</body>
</html>
