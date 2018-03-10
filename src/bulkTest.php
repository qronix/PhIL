<?php
/**
 * Created by PhpStorm.
 * User: jonathanhead
 * Date: 3/8/18
 * Time: 5:49 PM
 */

include_once ("includes/header.php");
include_once ("includes/sidebar.php");
$display="<div class='modal phoneBulkMessages' role='dialog' style='display: block'>";
$display.="<div class='modal-dialog' role='document'>";
$display.="<div class='modal-content'>";
$display.="<div class='modal-header'>";
$display.="<h5 class='modal-title'>Create phone results</h5>";
$display.="<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
$display.="<span aria-hidden='true'>&times;</span>";
$display.="</button>";
$display.="</div>";
$display.="<div class='modal-body'>";

    $display.="<div class='container row'>";
    $display.= "<p>Things here</p>";
    $display.="</div>";

$display.="</div>";
$display.="</div>";
$display.="</div>";
$display.="</div>";

echo $display;

?>


<div class="modal" tabindex="-1" role="dialog" style="display: block">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
