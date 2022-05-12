<?php
class UpdateContr extends Update {
    private $user_studnum;
    private $user_firstname;
    private $user_lastname;
    private $user_middlename;
    private $user_gender;
    private $user_department;
    private $user_yearlevel;
    private $user_block;
    private $user_email;
    private $user_priveledge;

    public function __construct(
        $user_firstname, 
        $user_lastname, 
        $user_middlename, 
        $user_gender, 
        $user_department, 
        $user_yearlevel, 
        $user_block, 
        $user_email,
        $user_priveledge,
        $user_studnum
        ){
            $this->user_firstname = $user_firstname;
            $this->user_lastname = $user_lastname;
            $this->user_middlename = $user_middlename;
            $this->user_gender = $user_gender;
            $this->user_department = $user_department;
            $this->user_yearlevel = $user_yearlevel;
            $this->user_block = $user_block;
            $this->user_email = $user_email;
            $this->user_priveledge = $user_priveledge;
            $this->user_studnum = $user_studnum;
    }

    //error handling of forms
    public function updateUser(){
        if ($this->emptyInput() == false) {
            header("Location: ../index.php?error=emptyinput");
            exit();
        }

        if ($this->invalidEmail() == false) {
            header("Location: ../index.php?error=invalidEmail");
            exit();
        }

        $this->setUpdateUser($this->user_firstname, $this->user_lastname, $this->user_middlename, $this->user_gender, $this->user_department, $this->user_yearlevel, $this->user_block, $this->user_email,  $this->user_priveledge, $this->user_studnum);
        $this->updateForm($this->user_studnum);
    }

    //checks for empty inputs
    private function emptyInput(){
        $result = false;

        if (empty($this->user_firstname) || empty($this->user_lastname)|| empty($this->user_middlename) || empty($this->user_gender) || empty($this->user_department) || empty($this->user_yearlevel) || empty($this->user_block) || empty($this->user_email) || empty($this->user_priveledge) || empty($this->user_studnum)) {
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    //checks for valid email
    private function invalidEmail(){
        $result = false;
        if(!filter_var($this->user_email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }
        else{
            $result = true;
        }
    return $result;
    }

}