<?php

if(isset($_POST["submit"])){

    //taking Data from form
    $firstname = $_POST["user_firstname"];
    $lastname = $_POST["user_lastname"];
    $middlename = $_POST["user_middlename"];
    $gender = $_POST["user_gender"];
    $department = $_POST["user_department"];
    $yearlevel = $_POST["user_yearlevel"];
    $block = $_POST["user_block"];
    $email = $_POST["user_email"];
    $priveledge = $_POST["user_priveledge"];
    $password = $_POST["user_password"];
    $confirm_password = $_POST["confirm_password"];

    //Instantiate SignupController class
    include "../config/Config.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    $signup = new SignupContr($firstname, $lastname, $middlename, $gender, $department, $yearlevel, $block, $email, $password,  $priveledge,  $confirm_password);


    //Running Error handlers and user signup
    $signup->signupUser();

    //routing back to index.php
    header("location: ../index.php?signup=success");


}