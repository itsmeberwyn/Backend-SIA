<?php

if(isset($_POST["submit"])){

    //taking Data from form
    $email = $_POST["user_email"];
    $password = $_POST["user_password"];

    //Instantiate LoginController class
    include "../config/Config.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php";
    $login = new LoginContr($email, $password);


    //Running Error handlers and user login
    $login->loginUser();

    //routing back to index.php
    header("location: ../index.php?login=success");


}