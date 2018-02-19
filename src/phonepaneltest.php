<?php

session_start();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])&&$_SESSION['role']=="admin"){

    include_once("phone.php");
    $phone = new Phone();
    $returnData = $phone->loadPhonePanel();

}else{
    session_destroy();
    header("Location: index.php");
}

echo $returnData;

include_once("includes/header.php");
include_once("includes/sidebar.php");

?>
<div class="container col-md-10" id="phonePanel">
    <div id="phonePanelHeader" class="row">
        <h2>Phones</h2>
        <div class="container">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Apple
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="container phoneSearchContainer">
                                <input type="text" id="applePhoneSearch" class="form-control phoneSearchField" placeholder="Enter phone name...">
                                <button class="btn userbtn phonePanelSearchBtn"><i class="fa fa-search"></i>Search</button>
                            </div>
                            <div class="clearfix"></div>
                            <ul class="list-group" id="applePhoneList">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                    <button class="btn userbtn phonePanelDeleteBtn"><i class="fa fa-trash phonePanelTrashIcon"></i>Delete</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                    <button class="btn userbtn phonePanelDeleteBtn"><i class="fa fa-trash phonePanelTrashIcon"></i>Delete</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                    <button class="btn userbtn phonePanelDeleteBtn"><i class="fa fa-trash phonePanelTrashIcon"></i>Delete</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                    <button class="btn userbtn phonePanelDeleteBtn"><i class="fa fa-trash phonePanelTrashIcon"></i>Delete</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                    <button class="btn userbtn phonePanelDeleteBtn"><i class="fa fa-trash phonePanelTrashIcon"></i>Delete</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                    <button class="btn userbtn phonePanelDeleteBtn"><i class="fa fa-trash phonePanelTrashIcon"></i>Delete</button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone 1</p>
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Super extravagent apple phone name 2</p>
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <p class="phonePanelPhoneName">Apple phone superbig 256gb 3</p>
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Android
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Prepaid
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Collapsible Group Item #3
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // var searchBtns = document.querySelectorAll(".phonePanelSearchBtn");
    //
    // searchBtns.forEach(function(searchButton){
    //    searchButton.addEventListener("click",function(event){
    //        //add regex to get vendor name
    //         var searchButtonVendor = searchButton.id.match()
    //        //construct vendor name based id for search input id
    //
    //        //filter out all list items without a corresponding search value
    //        event.preventDefault();
    //    });
    // });
    var searchFields = document.querySelectorAll(".phoneSearchField");

    searchFields.forEach(function(searchField){

        var vendorNameMatches = searchField.id.match(/^.*(?=PhoneSearch)/);
        var vendorName = vendorNameMatches[0];
        var phoneListTargets = document.querySelectorAll(".phonePanelPhoneName");


        searchField.onkeyup = function(){
            var searchTerm = searchField.value;
            phoneListTargets.forEach(function(listElement){
                var phoneName = listElement.innerText;
                // console.log("Phone name is: " + phoneName);
                // console.log("search term is: " + searchTerm);

                if(phoneName.toLowerCase().indexOf(searchTerm)==-1) {
                    // listElement.parentElement.classList.add("hidden");
                    listElement.parentElement.classList.add("hidden");
                }else if(phoneName.toLowerCase().indexOf(searchTerm)!=-1){
                    if(listElement.parentElement.classList.contains("hidden")){
                        listElement.parentElement.classList.remove("hidden");
                    }
                    var regexTerm = searchTerm;
                    var regexp = new RegExp(regexTerm,"ig");
                    // var targetElementHTML = document.getElementsByClassName("searchLine")[0];

                    listElement.innerHTML = listElement.innerText.replace(regexp,"<span class='searchHighlight'>"+searchTerm+"</span>");
                }
            });
       };
        searchField.onchange = function(){
            var searchTerm = searchField.value;
            phoneListTargets.forEach(function(listElement){
                var phoneName = listElement.innerText;
                console.log("Phone name is: " + phoneName);
                console.log("search term is: " + searchTerm);

                if(phoneName.toLowerCase().indexOf(searchTerm)==-1) {
                    // listElement.parentElement.classList.add("hidden");
                    listElement.parentElement.classList.add("hidden");
                }else if(phoneName.toLowerCase().indexOf(searchTerm)!=-1){
                    if(listElement.parentElement.classList.contains("hidden")){
                        listElement.parentElement.classList.remove("hidden");
                    }
                }
                // }else if(phoneName.toLowerCase().indexOf(searchTerm)!=-1){
                //     if(listElement.parentElement.classList.contains("hidden")){
                //         listElement.parentElement.classList.remove("hidden");
                //     }
                // }
            });
        };
        // if(searchField.length==0){
        //     phoneListTargets.forEach(function(listElement){
        //         listElement.parentElement.classList.remove("hidden");
        //     });
        //     console.log("DING0");
        // }
    });
</script>
