<?php

class Update extends Connection{

    //executes update command to db
    protected function setUpdateUser($firstname, $lastname, $middlename, $gender, $department, $yearlevel, $block, $email, $priveledge, $studnum){
        $stmt = $this->connect()->prepare('UPDATE users_table SET user_firstname =?, user_lastname =?, user_middlename =?, user_gender =?, user_department =?, user_yearlevel =?, user_block =?, user_email =?,  user_priviledge =?
        WHERE user_studnum = ?;');
        
        if(!$stmt->execute(array($firstname, $lastname, $middlename, $gender, $department, $yearlevel, $block, $email, $priveledge, $studnum))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
     
    //updates form values upon changing
    protected function updateForm($studnum){
        $stmt = $this->connect()->prepare('SELECT * FROM users_table WHERE user_studnum = ?;');

        if(!$stmt->execute(array($studnum))){
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        else{
            session_start();
            $user1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["userid"] = $user1[0]["user_email"];
            $_SESSION["userStudNum"] = $user1[0]["user_studnum"];
            $_SESSION["userFirstName"] = $user1[0]["user_firstname"];
            $_SESSION["userLastName"] = $user1[0]["user_lastname"];
            $_SESSION["userMiddleName"] = $user1[0]["user_middlename"];
            $_SESSION["userGender"] = $user1[0]["user_gender"];
            $_SESSION["userDepartment"] = $user1[0]["user_department"];
            $_SESSION["userYearLevel"] = $user1[0]["user_yearlevel"];
            $_SESSION["userBlock"] = $user1[0]["user_block"];
            $_SESSION["userPassword"] = $user1[0]["user_password"];
            $_SESSION["userPriviledge"] = $user1[0]["user_priviledge"];
            $stmt = null;
        }

    }

   
}