<?php

session_start();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&($_SESSION['role']=="admin")||$_SESSION['role']=="superuser"){

    include_once("phone.php");
    $phone = new Phone();


}else{
    session_destroy();
    header("Location: index.php");
}


include_once("includes/header.php");
include_once("includes/sidebar.php");

?>
<div class="container col-md-10" id="phonePanel">
    <div id="phonePanelHeader" class="row">
        <h2>Phones</h2>

        <div class="container">
            <div id="accordion">
                <?php
                    $result = $phone->loadPhoneTypesPanel();
                    echo $result;
                ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var searchFields = document.querySelectorAll(".phoneSearchField");

    searchFields.forEach(function(searchField){

        var vendorNameMatches = searchField.id.match(/^.*(?=PhoneSearch)/);
        var vendorName = vendorNameMatches[0];
        var phoneListTargets = document.querySelectorAll(".phonePanelPhoneName");


        searchField.onkeyup = function(){
            var searchTerm = searchField.value;

            phoneListTargets.forEach(function(listElement){
                var phoneName = listElement.innerText;
                var phoneListVendorRegex = listElement.parentElement.parentElement.parentElement.parentElement.id.match(/^(.*)(?=PhoneList)/);
                var phoneListVendor = phoneListVendorRegex[0];

                console.log("vendorName: " + vendorName + " AND phoneListVendor: " + phoneListVendor);

                if(phoneName.toLowerCase().indexOf(searchTerm)==-1 && phoneListVendor==vendorName) {
                    listElement.parentElement.parentElement.classList.add("hidden");
                }else if(phoneName.toLowerCase().indexOf(searchTerm)!=-1 && phoneListVendor == vendorName){
                    if(listElement.parentElement.parentElement.classList.contains("hidden")){
                        listElement.parentElement.parentElement.classList.remove("hidden");
                    }
                    var regexTerm = searchTerm;
                    var regexp = new RegExp(regexTerm,"ig");
                    listElement.innerHTML = listElement.innerText.replace(regexp,"<span class='searchHighlight'>"+searchTerm+"</span>");
                }
            });
       };
        searchField.onchange = function(){
            var searchTerm = searchField.value;
            phoneListTargets.forEach(function(listElement){
                var phoneName = listElement.innerText;
                var phoneListVendorRegex = listElement.parentElement.parentElement.parentElement.parentElement.id.match(/^(.*)(?=PhoneList)/);
                var phoneListVendor = phoneListVendorRegex[0];
                console.log("vendorName: " + vendorName + " AND phoneListVendor: " + phoneListVendor);

                if(phoneName.toLowerCase().indexOf(searchTerm)==-1 && phoneListVendor==vendorName) {
                    listElement.parentElement.parentElement.classList.add("hidden");
                }else if(phoneName.toLowerCase().indexOf(searchTerm)!=-1 && phoneListVendor == vendorName){
                    if(listElement.parentElement.parentElement.classList.contains("hidden")){
                        listElement.parentElement.parentElement.classList.remove("hidden");
                    }
                    var regexTerm = searchTerm;
                    var regexp = new RegExp(regexTerm,"ig");
                    listElement.innerHTML = listElement.innerText.replace(regexp,"<span class='searchHighlight'>"+searchTerm+"</span>");
                }
            });
        };
    });

    var addBtns = document.querySelectorAll(".addPhoneBtn");


    addBtns.forEach(function(addBtn){
       addBtn.addEventListener("click",function(event){

           var vendorNameResults = addBtn.parentElement.parentElement.id.match(/^(.*)(?=PhoneList)/);
           var vendorName = vendorNameResults[0];
           var phoneType = document.getElementById(vendorName+"NewPhoneName").value;
           var carrierName = document.querySelector("#"+vendorName+"carrierNames").value;

           var data = {
             vendorname: vendorName,
               carrier: carrierName,
               newphonetype: phoneType
           };


           $.ajax({
              type:'POST',
               url:"createphonetype.php",
              data:data,
              encode:true,
              dataType:'json'
           }).done(function (data) {
               location.reload();
           });

           event.preventDefault();
       });
    });


    var deleteBtns = document.querySelectorAll(".phonePanelDeleteBtn");

    deleteBtns.forEach(function(deleteBtn){
       deleteBtn.addEventListener("click",function(event){

           var vendorNameMatches = deleteBtn.id.match(/(.*)(?=:)/);
           var phonetypeMatches = deleteBtn.id.match(/(?<=:)(.*)(?=#)/);
           var carrierMatches = deleteBtn.id.match(/(?<=#)(.*)/);

           var vendorName = vendorNameMatches[0];
           var phonetype  = phonetypeMatches[0];
           var carrier = carrierMatches[0];


           var data = {
                vendorname:vendorName,
                phonetype:phonetype,
                carrier:carrier
           };

            $.ajax({
                type:'POST',
                url:'removephonetype.php',
                data:data,
                dataType:'json',
                encode:true

            }).done(function(data){
                location.reload();
            });
           event.preventDefault();
       });
    });
</script>
