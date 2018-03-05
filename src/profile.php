<?php

session_start();

$resultData = "";

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&isset($_SESSION['userid'])&&!empty($_SESSION['userid'])){

    include_once ("user.php");
    include_once ("includes/header.php");
    include_once ("includes/sidebar.php");
    $user = new User();
    $userId = $_SESSION['userid'];
    $userIdClean = filter_var($userId,FILTER_SANITIZE_SPECIAL_CHARS);
    $resultData = $user->loadProfile($userIdClean);

}else{
    session_destroy();
    header("Location: index.php");
}

echo $resultData;

?>


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