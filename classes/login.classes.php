<?php

class Login extends Connection{

    //getting the user from db based on log in details
    protected function getUser($email, $password){
        $stmt = $this->connect()->prepare('SELECT user_password FROM users_table WHERE user_email = ?;');

        if(!$stmt->execute(array($email))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed1");
            exit();
        }

        if ($stmt->rowCount() ==  0) {
            $stmt = null;
            header("location: ../index.php?error=usernotfound1");
            exit();
        }
        //checking for password
        $passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $passwordHashed[0]["user_password"]);

        if ($checkPassword == false) {
            $stmt = null;
            header("location: ../index.php?error=wrongpassword"); 
            exit();
        }
        elseif ($checkPassword == true) {
            //getting the details if user password is correct
            $stmt = $this->connect()->prepare('SELECT * FROM users_table WHERE user_email = ? AND user_password = ?;');
            
            if(!$stmt->execute(array($email, $passwordHashed[0]["user_password"]))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed2/");
            exit();
            }
            if ($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../index.php?error=usernotfound2/");
                exit();
            }
            //starts session then assigning user info to session vars
            session_start();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["userStudNum"] = $user[0]["user_studnum"];
            $_SESSION["userid"] = $user[0]["user_email"];
            $_SESSION["userFirstName"] = $user[0]["user_firstname"];
            $_SESSION["userLastName"] = $user[0]["user_lastname"];
            $_SESSION["userMiddleName"] = $user[0]["user_middlename"];
            $_SESSION["userGender"] = $user[0]["user_gender"];
            $_SESSION["userDepartment"] = $user[0]["user_department"];
            $_SESSION["userYearLevel"] = $user[0]["user_yearlevel"];
            $_SESSION["userBlock"] = $user[0]["user_block"];
            $_SESSION["userPassword"] = $user[0]["user_password"];
            $_SESSION["userPriviledge"] = $user[0]["user_priviledge"];
            $stmt = null;
        
        }

        $stmt = null;
    }
}
