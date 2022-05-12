<?php

class ChangePasswordContr extends ChangePassword {
    private $studnum;
    private $old_password_confirm;
    private $new_password;
    private $new_password_confirm;


    public function __construct($studnum, $old_password_confirm, $new_password, $new_password_confirm){
            $this->studnum = $studnum;
            $this->old_password_confirm = $old_password_confirm;
            $this->new_password = $new_password;
            $this->new_password_confirm = $new_password_confirm;

    }

    //checking for validity of inputs
    public function changePasswordUser(){
        if ($this->emptyInput() == false) {
            header("Location: ../index.php?error=emptyinput");
            exit();
        }
        $this->changePassword($this->studnum, $this->old_password_confirm, $this->new_password, $this->new_password_confirm);
    }

    //checking for empty inputs
    private function emptyInput(){
        $result = false;
        if (empty($this->old_password_confirm) || empty($this->new_password) || empty($this->new_password_confirm)) {
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }


}