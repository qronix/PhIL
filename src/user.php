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
        $sql= "SELECT id, role, needpasschange, activeaccount FROM users WHERE username = :username AND password = :password";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':username',$username);
        $statement->bindValue(':password',$password);
        $statement->execute();
        //cols
        // 0: id
        // 1: role
        // 2: needpasschange
        // 3: activeaccount

        if(($id = $statement->fetchColumn(0))!==false){

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
