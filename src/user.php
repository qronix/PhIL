<?php

session_start();

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
        $statement->bindValue(':password',$password);
        $statement->execute();
        //cols
        // 0: id
        // 1: password
        // 2: role
        // 3: needpasschange
        // 4: activeaccount

        if(($id = $statement->fetchColumn(0))!==false){
            //if account is enabled
            if(($activeaccount = $statement->fetchColumn(4))!=0) {
                //if password is correct
                $password_hash = $statement->fetchColumn(1);
                if(password_verify($password,$password_hash)){
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['role'] = $statement->fetchColumn(2);
                    //if account password is not default
                    if(($needpasschange=$statement->fetchColumn(3))!=1){
                        //send to dashboard
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

function register($username, $password, $passwordVerify){

}

function resetPassword($username){

}
}
?>