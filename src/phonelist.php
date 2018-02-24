<?php
session_start();
if(!isset($_SESSION['role'])||empty($_SESSION['role'])){
    header("Location: dashboard.php");
}
include("includes/header.php");
include("includes/sidebar.php");
include("phone.php");


$phone = new Phone();


?>


<?php
if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&
    ($_SESSION['role']==="admin"||$_SESSION['role']==="manager"
    ||$_SESSION['role']==="superuser")){
    include ("phoneform.php");
}
?>

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
    <div class="container" id="phoneList-message">

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
           setupRemoveBtns();
       });
   }
   function setupRemoveBtns(){
       var removePhoneBtns = document.querySelectorAll(".phoneremove");

       removePhoneBtns.forEach(function(btn){
           btn.addEventListener("click",function(event){
               var phoneIdMatches = btn.href.match(/(?<=\?phoneid=)(.*)/);
               var phoneId = phoneIdMatches[0];

               $.ajax({
                   type:"POST",
                   url:"deletephone.php",
                   data:{'phoneid':phoneId},
                   dataType:'json',
                   encode:true
               }).done(function (data) {
                   var phoneListMessage =$('#phoneList-message');
                   phoneListMessage.html("<div class='alert alert-warning'>"+data+"</div>");
               });


               event.preventDefault();
               $("#phoneList-message").fadeTo(2000, 500).slideUp(500, function(){
                   $("#phoneList-message").slideUp(500);
               });
               loadPhones();
           });
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

            event.preventDefault();
            $("#form-message").fadeTo(2000, 500).slideUp(500, function(){
                $("#form-message").slideUp(500);
            });
        });
    });
</script>
</body>
</html>
