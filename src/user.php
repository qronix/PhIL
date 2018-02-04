<?php

if(!isset($_SESSION)){
    session_start();
}

include("includes/dbcon.php");

class User{
    private $dbCon;
    private $pdo;

    function __construct(){
        $this->dbCon = new DBConn();
        $this->pdo = $this->dbCon->getInstance();
    }
function login($username,$password){
    try{
        $sql= "SELECT id, password, role, needpasschange, activeaccount FROM users WHERE username = :username";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':username',$username);
        $statement->execute();
        //cols
        // 0: id
        // 1: password
        // 2: role
        // 3: needpasschange
        // 4: activeaccount

        if(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
            //if account is enabled
            if($result['activeaccount']==1) {
                $password_hash = $result['password'];
                //if password is correct
                if(password_verify($password,$password_hash)){
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $result['role'];
                    $_SESSION['userid'] = $result['id'];
                    //if account password is not default
                    if($result['needpasschange']!=1){
                        $URL="dashboard.php";
                        //return "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                        //echo "<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">";
                        //header("Location: dashboard.php");
                        return("login");

                    }else{
                        header("Location: changepass.php");
                    }
                }else{
                    return("Incorrect password");
                }
            }else{
                return("Account locked");
            }
        }else{
            return("Login failed");
        }
    }catch (PDOException $exc){
        echo "An error occurred.";
        header("HTTP/1.0 500 DB ERROR");
        header("Location: index.php");
    }
}

function deleteUser($userid){
        try{
            if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
                if($_SESSION['role']=="admin"&&$_SESSION['userid']!=$userid){
                    $sql = "DELETE FROM users WHERE id=:id LIMIT 1";
                    $statement = $this->pdo->prepare($sql);
                    $statement->bindValue('id',$userid);
                    $statement->execute();
                }else{
                    return("Access denied");
                }
            }else{
                return("Invalid session");
            }
            return("User deleted");
        }catch (PDOException $exc){
            echo "An error occurred while deleting user. Assume not deleted.";
            header("HTTP/1/0 500 DB ERROR");
            header("Location: index.php");
        }
}

function displayUsers(){
        if(isset($_SESSION['role'])&&!empty($_SESSION['role'])){
            if($_SESSION['role']!=="manager"||$_SESSION['role']!=="admin"){
                try{
                    $sql = "SELECT * FROM users";
                    $statement = $this->pdo->prepare($sql);
                    $statement->execute();

                    while(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){
                        $display =  "<div class='container userrow col-md-9'>";
                        $display .= "<div class='row'>";
                        $display .= "<div class='col-md-1 userdata'>";
                        $display .= "<p>ID: </br><span class='userdata'>".$result['id']."</span></p>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-3 userdata'>";
                        $display .= "<p>Username: </br><span class='userdata'>".$result['username']."</span></p>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-3 userdata'>";
                        $display .= "<p>Email: </br><span class='userdata'>".$result['email']."</span></p>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-2 userdata'>";
                        $display .= "<p>Role: </br><span class='userdata'>".$result['role']."</span></p>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-1 userdata'>";
                        $display .= "<p>Active: </br><span class='active'>".$result['activeaccount']."</span></p>";
                        $display .= "</div>";
                        $display .= "<div class='col-md-2 btngrp'>";
                        $display .= "<a class='userbtn useredit' href='edituser.php?userid=".$result['id']."'><i class='fa fa-pencil' aria-hidden='true'></i>edit</a></br>";
                        $display .= "<a class='userbtn userdelete' href='deleteuser.php?userid=".$result['id']."'><i class='fa fa-trash' aria-hidden='true'></i>delete</a>";
                        $display .= "</div>";
                        $display .= "</div>";
                        $display .= "</div>";

                        echo $display;
                    }

                }catch (PDOException $exc){
                    echo "<div class='alert alert-danger'>Users could not be displayed</div>";
                }
            }else{
                echo "<div class='alert alert-warning'>You cannot view users</div>";
            }
        }else{
            echo "<div class='alert alert-warning'>You are not logged in</div>";
        }
}

function createUser($username, $password, $passwordVerify, $email, $role){

        //ENSURE THESE VARIABLES ARE SANITIZED!

        if(isset($_SESSION['role'])&&$_SESSION['role']==='admin'){

            try{
                //check user existence
                $sql="SELECT id FROM users WHERE username = :username";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':username',$username);
                $statement->execute();
            }catch (PDOException $exc){
                return("An error occurred while contacting database");
            }

            //cols
            // 0 : id

            //user does not exist
            if(!($id=$statement->fetchColumn(0))>0){
                //if all values have content
                if(!empty($username)&&!empty($password)&&!empty($passwordVerify)&&
                !empty($email)&&!empty($role)){
                    if($passwordVerify===$password){
                        try{
                            $sql = "INSERT INTO users (username,password,email,role,needpasschange,
                        activeaccount) VALUES (:username,:password,:email,:role,:needpasschange,
                        :activeaccount)";
                            $statement = $this->pdo->prepare($sql);
                            $password_hash=password_hash(
                                $password,
                                PASSWORD_DEFAULT,
                                ['cost'=>12]
                            );
                            $statement->bindValue(':username',$username);
                            $statement->bindValue(':password',$password_hash);
                            $statement->bindValue(':email',$email);
                            $statement->bindValue(':role',$role);
                            $statement->bindValue(':needpasschange',1);
                            $statement->bindValue(':activeaccount',1);
                            $statement->execute();
                        }catch (PDOException $exc){
                            return("Could not create user");
                        }
                    }
                }
                return("User successfully created");
            }else{
                return("User already exists");
            }
        }else{
            return("You do not have permission to create a user");
        }
}

function loadUser($id){

        $userdata = array();

        if(isset($_SESSION['role'])&&$_SESSION['role']==='admin'){
            try{
                if($id!==false&&$id!==null&&!empty($id)){
                    $sql = "SELECT username, role, email, activeaccount FROM users WHERE id=:id";
                    $statement = $this->pdo->prepare($sql);
                    $statement->bindValue(':id',$id);
                    $statement->execute();

                    $result = $statement->fetch(PDO::FETCH_ASSOC);

                    $userdata['username'] = $result['username'];
                    $userdata['role'] = $result['role'];
                    $userdata['email'] = $result['email'];
                    $userdata['activeaccount'] = $result['activeaccount'];
                    $userdata['message'] = "User successfully loaded";
                }
            }catch (PDOException $exc){
                $userdata['message'] = 'Failed to load user';
            }
        }else{
            $userdata['username'] = 'NULL';
            $userdata['email'] = 'NULL';
            $userdata['role'] = 'NULL';
            $userdata['message'] = 'You do not have permission';
        }
        return $userdata;
}

function updateUser($id,$username,$role,$email,$activeaccount){

        $message = "";

        if(isset($_SESSION['role'])&&$_SESSION['role']==='admin'){
            try{
                $sql = "UPDATE users SET username=:username, role=:role,email=:email,activeaccount=:activeaccount WHERE id=:id";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(':id',$id);
                $statement->bindValue(':username',$username);
                $statement->bindValue(':role',$role);
                $statement->bindValue(':email',$email);
                $statement->bindValue(':activeaccount',$activeaccount);
                $statement->execute();
            }catch (PDOException $exc){
                $message = 'An error occurred during update';
            }
            $message =  'User successfully updated';

        }else{
            $message = 'You do not have permission';
        }
        return $message;
}

function verifyManager($managerName, $managerPassword){

        try{
            $sql = "SELECT * FROM users WHERE username=:username";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue('username',$managerName);
            $statement ->execute();

            if(($result=$statement->fetch(PDO::FETCH_ASSOC))!==false){

                //print_r($result);
                if(!password_verify($managerPassword,$result['password'])){
                    //echo "Bad password";
                    return (false);
                }
                else if($result['role']!="admin"&&$result['role']!="manager"){
                    //echo "Bad permissions";
                    return (false);
                }
                else if($result['activeaccount']!="1"){
                    //echo "Bad account";
                    return(false);
                }
                else if($result['needpasschange']=="1"){
                    //echo "Bad password status";
                    return (false);
                }
                else{
                    return ("good");
                }
            }
        }catch (PDOException $exc){
            return (false);
        }
}


function resetPassword($username){

}
}
?>