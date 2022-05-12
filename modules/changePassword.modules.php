<?php

if(isset($_POST["submit"])){

    //taking Data from form
    $studnum = $_POST["user_studnum"];
    $old_password_confirm = $_POST["user_old_password_confirm"];
    $new_password = $_POST["user_new_password"];
    $new_password_confirm = $_POST["user_new_password_confirm"];

    //Instantiate ChangePassword class
    include "../config/Config.php";
    include "../classes/changePassword.classes.php";
    include "../classes/changePassword-contr.classes.php";
    $changePassword = new ChangePasswordContr($studnum, $old_password_confirm, $new_password, $new_password_confirm);


    //Running Error handlers and user change password
    $changePassword->changePasswordUser();

    //routing back to index.php
    header("location: ../index.php?error=none");


}