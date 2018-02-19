<?php

include("includes/header.php");
include("includes/sidebar.php");

?>


<div class="container searchLine">
    Super extravagent apple phone name 2
</div>


<script type="text/javascript">
    var target = document.getElementsByClassName("searchLine")[0].innerText;


    // function highlightTerms(){
    //     console.log(target);
    //     var searchTerm = "super";
    //     var nameArray = target.split(searchTerm);
    //     console.log(nameArray);
    //     var indexCount = 0;
    //     var newName = [];
    //
    //     nameArray.forEach(function(namePiece){
    //         var searchHighlightInjection = "<span class='searchHighlight'>"+searchTerm+"</span>";
    //         if(namePiece==""){
    //             newName.push(searchHighlightInjection);
    //             // return;
    //         }else if(indexCount!=0){
    //             // newName.push(namePiece + searchHighlightInjection) ;
    //             newName.push(searchHighlightInjection + namePiece);
    //         }else if(indexCount==0 && namePiece != searchTerm){
    //             newName.push(namePiece);
    //         }else if(indexCount==0 && namePiece == searchTerm){
    //             newName.push(searchHighlightInjection);
    //         }
    //         indexCount++;
    //     });
    //     var highlightResults = newName.join("");
    //     console.log("New name is :" +highlightResults);
    //
    //     document.getElementsByClassName("searchLine")[0].innerHTML = highlightResults;
    // }

    //attempt with REGEX

    function regexHighlight(searchTerm){
        var regexTerm = searchTerm;
        var regexp = new RegExp(regexTerm,"ig");
        var targetElementHTML = document.getElementsByClassName("searchLine")[0];

        targetElementHTML.innerHTML = target.replace(regexp,"<span class='searchHighlight'>"+searchTerm+"</span>");
    }
</script>


