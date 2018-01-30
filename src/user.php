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
        $statement->execute();
        //cols
        // 0: id
        // 1: password
        // 2: role
        // 3: needpasschange
        // 4: activeaccount

        if(($id = $statement->fetchColumn(0))!==false){
            //if account is enabled
            if(($activeaccount = $statement->fetchColumn(4))!=1) {
                $password_hash = $statement->fetchColumn(1);
                //if password is correct
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
            if(($id=$statement->fetchColumn(0))!==true){
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
            }
            return("User successfully created");
        }else{
            return("You do not have permission to create a user");
        }

}

function resetPassword($username){

}
}
?>