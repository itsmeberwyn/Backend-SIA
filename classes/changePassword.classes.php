<?php

class ChangePassword extends Connection{

    //retrieving user password for checking
    protected function changePassword($studnum, $old_password_confirm, $new_password, $new_password_confirm){
        $stmt = $this->connect()->prepare('SELECT user_password FROM users_table WHERE user_studnum = ?;');

        if ($new_password !== $new_password_confirm) {
            $stmt = null;
            header("location: ../index.php?error=newpasswordnotmatch");
            exit();
        }

        if(!$stmt->execute(array($studnum))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        //checking if old password match
        $passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($old_password_confirm, $passwordHashed[0]["user_password"]);

        if ($checkPassword == false) {
            $stmt = null;
            header("location: ../index.php?error=oldpasswordnotmatch"); 
            exit();
        }

        //executes change password if old password matched
        if ($checkPassword == true) {
            $stmt = null;
            $stmt = $this->connect()->prepare('UPDATE users_table SET user_password = ? WHERE user_studnum = ?;');
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            if(!$stmt->execute(array($hashedPassword, $studnum))){
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            else{
                $stmt = null;
                header("location: ../index.php?changepassword=success");
                exit();
            }

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