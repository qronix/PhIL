<?php

session_start();

global $userid;
global $currentPass;
global $newPass;
global $newPassConfirm;
global $resultData;
global $functionMessage;

$cleanData = array();
$resultData = array();
$errors = array();

if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){

    if(isset($_SESSION['userid'])&&!empty($_SESSION['userid'])){
        $userid = filter_var($_SESSION['userid'],FILTER_SANITIZE_SPECIAL_CHARS);
        $cleanUserId = preg_replace('/[^a-zA-Z0-9-_\.]/','',$userid); //clean input
        $cleanData['userid'] = $cleanUserId;
    }else{
        session_destroy();
        header("Location: index.php");
    }
    if(isset($_POST['currentPass'])&&!empty($_POST['currentPass'])){
        $currentPass = filter_input(INPUT_POST,'currentPass');
        $cleanCurrentPass = preg_replace('/[^a-zA-Z0-9-_\.]/','',$currentPass);
        $cleanData['currentPass'] = $cleanCurrentPass;
    }else{
        $errors['currentPass'] = "Current password cannot be empty.";
    }
    if(isset($_POST['newPass'])&&!empty($_POST['newPass'])){
        $newPass = filter_input(INPUT_POST,'newPass');
        $cleanNewPass= preg_replace('/[^a-zA-Z0-9-_\.]/','',$newPass);
        $cleanData['newPass'] = $cleanNewPass;
    }else{
        $errors['newPass'] = "New password cannot be empty.";
    }
    if(isset($_POST['newPassConfirm'])&&!empty($_POST['newPassConfirm'])){
        $newPassConfirm = filter_input(INPUT_POST,'newPassConfirm');
        $cleanNewPassConfirm= preg_replace('/[^a-zA-Z0-9-_\.]/','',$newPassConfirm);
        $cleanData['newPassConfirm'] = $cleanNewPassConfirm;
    }else{
        $errors['newPassConfirm']= "Confirm password cannot be empty.";
    }
    if(sizeof($errors)===0){
        if($newPass!==""&&$currentPass!==""){
            if($newPass===$currentPass&&!empty($newPass)){
                $errors['currentPass']= "New password cannot be current password";
            }else if($newPass!==$newPassConfirm){
                $errors['match'] ="New passwords do not match.";
            }else if($newPass===$newPassConfirm){
                if(sizeof($errors)===0){
                    include_once ("user.php");
                    $user = new User();
                    $functionMessage = $user->changePassword($cleanData);
                    if(isset($resultData['message'])){
                        $resultData['message']=$functionMessage;
                    }
                }else{
                    $resultData['errors']=$errors;
                }
            }else{
                $errors['newPass']="New passwords do not match";
            }
        }else{
            $errors['newPass']="New passwords cannot be empty";
        }
    }else{
        $resultData['errors']=$errors;
    }

    if(sizeof($errors)!==0){
        $cleanErrors = array();

        foreach ($errors as $key=>$value){
            $cleanErrors[$key]=strip_tags($value);
        }
        $resultData['errors']=$cleanErrors;
    }

}else{
    session_destroy();
    header("Location: index.php");
}

echo json_encode($resultData);