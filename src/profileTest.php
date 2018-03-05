<?php

include("includes/header.php");
include("includes/sidebar.php");

?>



<div class="container profileContainer col-md-5">

    <div class="row profileHeader">
        <h2>Test Profile</h2>
    </div>
    <div class="row userDetailsContainer">
        <div class="col-md-5">
            <p>Role:</p>
        </div>
        <div class="col-md-5">
            <p>Admin</p>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="container row hidden" id="changePassArea">
        <div id="resultMessage" class="alert alert-warning hidden">

        </div>
        <div class="container profilePassContainer">
            <div class="row profilePassRow">
                <label for="currentPass">Current password:</label>
            </div>
            <div class="row profilePassRow">
                <input type="password" class="form-control" id="currentPass" name="currentPass">
            </div>
            <div class="row profilePassRow">
                <label for="newPass">New password:</label>
            </div>
            <div class="row profilePassRow">
                <input type="password" class="form-control" id="newPass" name="newPass">
            </div>
            <div class="row profilePassRow">
                <label for="confirmNewPass">Confirm password:</label>
            </div>
            <div class="row profilePassRow">
                <input type="password" class="form-control" id="confirmNewPass" name="confirmNewPass">
            </div>
        </div>
    </div>
    <div class="changePasswordBtnContainer">
        <a href="#changePassCollapse" id="changePassBtn" class="btn userbtn">Change password</a>
    </div>
</div>

<script type="text/javascript">
    var changePassBtn = document.getElementById("changePassBtn");

    changePassBtn.addEventListener("click",function(event){
        var changePassArea              = document.getElementById("changePassArea");
        var changePasswordBtnContainer  = document.querySelector(".changePasswordBtnContainer");
        var changePassContainer         = document.querySelector(".profileContainer");

        if(this.innerText==="Submit"){
            console.log("ding");
            //this.setAttribute("href","");
                var currentPassword = document.getElementById("currentPass").value;
                var newPassword     = document.getElementById("newPass").value;
                var confirmPassword = document.getElementById("confirmNewPass").value;

                var queryData = {
                    currentPass:    currentPassword,
                    newPass:        newPassword,
                    newPassConfirm: confirmPassword
                };
                $.ajax({
                    type:     'POST',
                    url:      'changepass.php',
                    data:      queryData,
                    dataType: 'json',
                    encode:    true
                }).done(function(data){
                    console.log(console.dir(data));

                    //loop through object properties and values
                    if(data.errors!==undefined){
                        messageBuilder(data.errors,false);
                    }else if(data.message!==undefined){
                        messageBuilder(data.message,true);
                    }
                });
            event.preventDefault();
        }
        if(changePassArea.classList.contains("hidden")){
            changePassArea.classList.remove("hidden");
            changePasswordBtnContainer.classList.add("noMarginTop");
            changePassBtn.innerText="Submit";
            changePassContainer.classList.add("buttonPadding");
        }else{
            // changePassArea.classList.add("hidden");
            // changePasswordBtnContainer.classList.remove("noMarginTop");
            // changePassContainer.classList.remove("buttonPadding");
            // changePassBtn.innerText = "Change password";
        }
    });

    function messageBuilder(messageObject,message){
        var messageContainer = document.getElementById("resultMessage");
        var errorMessage = "";

        if(!message){
            for(prop in messageObject){
                if(errorMessage===""){
                    errorMessage=messageObject[prop];
                }else if(errorMessage!==""){
                    errorMessage+="</br>"+messageObject[prop];
                }
            }
        }else{
            errorMessage=messageObject;
        }
        console.log(errorMessage);
        var innerHTML = "<div class='alert alert-warning'>"+errorMessage+"</div>";
        messageContainer.innerHTML = innerHTML;
        messageContainer.classList.remove("hidden");

        $(messageContainer).fadeTo(2000, 500).slideUp(500, function(){
            $(messageContainer).slideUp(500);
        });
    }
</script>
