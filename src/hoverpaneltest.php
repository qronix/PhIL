<?php

include("includes/header.php");
include("includes/sidebar.php");


?>

<div class="container hidden" id="geofence">
    <div class="container col-md-3" id="helperPanel">

    </div>
</div>

<button class="btn userbtn" id="addBtnTest">Add phone!</button>

<script type="text/javascript">

    var phoneBtn = document.getElementById("addBtnTest");
    var phoneName = "testPhone";
    var showPanel = true;

    phoneBtn.addEventListener("click",function(event){
        var geoFence = document.getElementById("geofence");
        var infoPanel = document.getElementById("helperPanel");
        var infoPanelCheckbox = null;
        var closeInfoPanel = null;

        console.log("ding");

        if(showPanel){
            geoFence.style.position="absolute";
            geoFence.style.left = event.clientX+"px";
            geoFence.style.top =  event.clientY+"px";
            infoPanel.innerHTML = "<div class='infoPanelHeader'> <p id='closeInfoPanel'>X</p></div><div class='clearfix'></div> <div class='container infoPanelText'> <p id='infoText'><a href='#'>Click here</a> " +
                "to add a "+phoneName+" to the inventory</p><input type='checkbox' id='showPanelCheck' checked><span id='checkBoxInfo'>Show this panel</span></div>";
            infoPanelCheckbox = document.getElementById("showPanelCheck");
            closeInfoPanel = document.getElementById('closeInfoPanel');
            geoFence.classList.remove("hidden");


            closeInfoPanel.addEventListener("click",function(event){
                geoFence.classList.add("hidden");
            });
            infoPanelCheckbox.addEventListener("change",function(event){
                if(this.checked){
                    showPanel = true;
                }else{
                    showPanel = false;
                }
            });
        }
    });


    var helperPanel = document.getElementById("helperPanel");
    helperPanel.style.position = "absolute";

    document.addEventListener("mousemove",function(event){
       var xCoor = event.clientX;
       var yCoor = event.clientY;

       // console.log("Coords: X: "+xCoor+" Y:"+yCoor);

        moveHelper(xCoor,yCoor);

    });

    function moveHelper(xPos, yPos){
        var myXCoor = helperPanel.style.left;
        var myYCoor = helperPanel.style.top;
        var geoFence = document.getElementById("#geofence");

        var isFrozen = false;

        // console.log("Distance top: " + (yPos-parseInt(myYCoor)));
        // console.log("Distance left: " + (xPos-parseInt(myXCoor)));
        if((xPos-parseInt(myXCoor))>=-20||(yPos-parseInt(myYCoor))>=-20&&(yPos-parseInt(myYCoor))<0){
            isFrozen = true;
            // console.log("Is frozen: "+isFrozen);
            // helperPanel.style.left = xPos+'px';
        }else{
            isFrozen = false;
        }
        if(!isFrozen){
            // helperPanel.style.left = xPos+19+'px';
            // helperPanel.style.top = yPos+19+'px';
        }
        geofence
        // console.log("Is frozen: "+isFrozen);
    }




</script>
