<?php

class Signup extends Connection{

    //executes insertion command to db
    protected function setUser($firstname, $lastname, $middlename, $gender, $department, $yearlevel, $block, $email, $password, $confirm_password, $priveledge){
        $stmt = $this->connect()->prepare('INSERT INTO users_table(user_firstname, user_lastname, user_middlename, user_gender, user_department, user_yearlevel, user_block, user_email, user_password, user_priviledge) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');

        if ($password !== $confirm_password) {
            $stmt = null;
            header("location: ../index.php?error=passwordnotmatch");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($firstname, $lastname, $middlename, $gender, $department, $yearlevel, $block, $email, $hashedPassword, $priveledge))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
     
    //check if email is already taken
    protected function checkUser($email){
        $stmt = $this->connect()->prepare('SELECT user_email FROM users_table WHERE user_email = ?;');

        if(!$stmt->execute(array($email))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $resultCheck = false;
        if($stmt->rowCount() > 0){
            $resultCheck = false;
        }

        else{
            $resultCheck = true;
        }

        return $resultCheck;
    }
}