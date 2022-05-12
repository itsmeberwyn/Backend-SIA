<?php

if(isset($_POST["submit"])){

    //taking Data from form
    $studnum = $_POST["user_studnum"];
    $firstname = $_POST["user_firstname"];
    $lastname = $_POST["user_lastname"];
    $middlename = $_POST["user_middlename"];
    $gender = $_POST["user_gender"];
    $department = $_POST["user_department"];
    $yearlevel = $_POST["user_yearlevel"];
    $block = $_POST["user_block"];
    $email = $_POST["user_email"];
    $priveledge = $_POST["user_priveledge"];

    //Instantiate UpdateController class
    include "../config/Config.php";
    include "../classes/update.classes.php";
    include "../classes/update-contr.classes.php";
    $update = new UpdateContr($firstname, $lastname, $middlename, $gender, $department, $yearlevel, $block, $email, $priveledge, $studnum);
    
    //Running Error handlers and user update
    $update->updateUser();

    //routing back to index.php
    header("location: ../index.php?update=success");


}