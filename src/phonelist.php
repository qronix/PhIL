<?php
session_start();
if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    header("Location: dashboard.php");
}
include("includes/header.php");
include("includes/sidebar.php");
include("phone.php");


//if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']!="admin"){
//    header("Location: dashboard.php");
//}

$phone = new Phone();


?>


<?php include ("phoneform.php");?>

<div class="container editusercontainer col-sm-11">
    <div class="row">
        <div class="container" id="form-message">

        </div>
    </div>
    <div class="row">
        <h2>Phone list</h2>
    </div>
    <div class="row">
        <div class="container col-md-6" id="searchPhoneArea">
            <form id="phone-search" class="col-md-12" action="phonesearch.php" method="POST">
                <div class="form-group phonesearch" id="phonesearch">
                    <input class="text form-control" name="phonesearch" id="phonesearchEntry" placeholder="imei, employee, phone...">
                </div>
                <div class="form-group">
                    <button type="submit" id="phonesearchBtn" class="btn"><i class="fa fa-search"></i>Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container col-md-10" id="phonelist">
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".main").fadeIn(1000);
        loadPhones();
    });
    $("#phone-search").submit(function(event) {
        var searchTerm = document.querySelector("#phonesearchEntry").value;
        console.log(searchTerm);
        $.ajax({
           type:'POST',
           url:"phonesearch.php",
           data:{'searchterm': searchTerm},
           encode:true
        }).done(function(data){
            $("#phonelist").html(data);
        });
        event.preventDefault();
    });
   function loadPhones(){
       $.ajax({
          type:'POST',
          url:"loadphones.php",
          data:{'action':"load"},
          encode:true
       }).done(function(data){
           $("#phonelist").html(data);
       });
   }
    $(function(){
        var form=$('#edit-form-phone');
        var formMessage =$('#form-message');

        $(form).submit(function(event){

            $('.alert').remove();
            var formData = {
                'vendor' : document.querySelector("#vendor").value,
                'carrier' : document.querySelector("#carrier").value,
                'phone' : document.querySelector("#phone").value,
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
                    console.log("here");
                    $(formMessage).append("<div class='alert alert-warning'>"+data.message+"</div>");
                }
                loadPhones();
            });
            $('#vendor').val('');
            $('#carrier').val('');
            $('#phone').val('');
            $('#imei').val('');
            $('#employee').val('');
            $('#manager').val('');
            $('#managerPassword').val('');

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
