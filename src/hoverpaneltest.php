<?php

include("includes/header.php");
include("includes/sidebar.php");


?>

<div class="container" id="geofence">
    <div class="container" id="helperPanel">
        I am here to help!
    </div>
</div>


<script type="text/javascript">
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

        console.log("Distance top: " + (yPos-parseInt(myYCoor)));
        console.log("Distance left: " + (xPos-parseInt(myXCoor)));
        if((xPos-parseInt(myXCoor))>=-20||(yPos-parseInt(myYCoor))>=-20&&(yPos-parseInt(myYCoor))<0){
            isFrozen = true;
            console.log("Is frozen: "+isFrozen);
            // helperPanel.style.left = xPos+'px';
        }else{
            isFrozen = false;
        }
        if(!isFrozen){
            // helperPanel.style.left = xPos+19+'px';
            // helperPanel.style.top = yPos+19+'px';
        }
        geofence
        console.log("Is frozen: "+isFrozen);
    }




</script>
