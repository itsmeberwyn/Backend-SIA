<?php

class LoginContr extends Login{

    private $user_email;
    private $user_password;


    public function __construct($user_email, $user_password){
            $this->user_email = $user_email;
            $this->user_password = $user_password;

    }

    //checking validity of inputs
    public function loginUser(){
        if ($this->emptyInput() == false) {
            header("Location: ../index.php?error=emptyinput");
            exit();
        }
        $this->getUser($this->user_email, $this->user_password);
    }
    //checks for empty inputs
    private function emptyInput(){
        $result = false;
        if (empty($this->user_email) || empty($this->user_password)) {
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }


}