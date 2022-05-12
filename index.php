<?php
session_start();
?>
<header>
    <?php 
    if(isset($_SESSION["userStudNum"])){
    ?>
    <h2><?php echo $_SESSION["userStudNum"] ?></h2>
    <h2><?php echo $_SESSION["userFirstName"] ?></h2>
    <h5><a href="modules/logout.modules.php">LOGOUT</a></h5>
    <?php 
    }
    else
    {
    ?>
    <h5><a href="#">LOGIN</a></h5>
    <?php
    }
    ?>
</header>

<body>
    <?php 
    if(!isset($_SESSION["userStudNum"])){
    ?>
    <h1>Login</h1>
    <form action="modules/login.modules.php" method="POST">
        <input type="text" name="user_email" placeholder="E-mail">
        <input type="password" name="user_password" placeholder="Password">
        <button type="submit" name="submit"> LOGIN</button>
    </form>

  
    <h1>Signup</h1>
    <form action="modules/signup.modules.php" method="POST">
        <input type="text" name="user_firstname" placeholder="First Name">
        <input type="text" name="user_lastname" placeholder="Last Name">
        <input type="text" name="user_middlename" placeholder="Middle Name">
        <input type="text" name="user_gender" placeholder="Gender">
        <input type="text" name="user_department" placeholder="College Department">
        <input type="text" name="user_yearlevel" placeholder="Year Level">
        <input type="text" name="user_block" placeholder="Block">
        <input type="text" name="user_email" placeholder="E-mail">
        <input type="text" name="user_priveledge" placeholder="Privelege">
        <input type="password" name="user_password" placeholder="Password">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
        <button type="submit" name="submit">REGISTER</button>
    </form>
    <?php 
    }
    ?>

    <?php 
    if(isset($_SESSION["userStudNum"])){
    ?>

    <h1>Update User Details</h1>
    <form action="modules/update.modules.php" method="POST">
        <input type="hidden" name="user_studnum" value="<?php echo $_SESSION["userStudNum"] ?>">
        <input type="text" name="user_firstname" placeholder="First Name" value="<?php  echo $_SESSION["userFirstName"] ?>">       
        <input type="text" name="user_lastname" placeholder="Last Name" value="<?php echo $_SESSION["userLastName"] ?>">
        <input type="text" name="user_middlename" placeholder="Middle Name" value="<?php echo $_SESSION["userMiddleName"] ?>">
        <input type="text" name="user_gender" placeholder="Gender" value="<?php echo $_SESSION["userGender"] ?>">
        <input type="text" name="user_department" placeholder="College Department" value="<?php echo $_SESSION["userDepartment"] ?>">
        <input type="text" name="user_yearlevel" placeholder="Year Level" value="<?php echo $_SESSION["userYearLevel"] ?>">
        <input type="text" name="user_block" placeholder="Block" value="<?php echo $_SESSION["userBlock"] ?>">
        <input type="text" name="user_email" placeholder="E-mail" value="<?php echo $_SESSION["userid"] ?>">
        <input type="text" name="user_priveledge" placeholder="Privelege" value="<?php echo $_SESSION["userPriviledge"] ?>">
        <button type="submit" name="submit">Update Details</button>
    </form>

    <h1>Change Password</h1>
    <form action="modules/changePassword.modules.php" method="POST">
        <input type="hidden" name="user_studnum" value="<?php echo $_SESSION["userStudNum"] ?>">
        <input type="hidden" name="user_old_password" value="<?php echo $_SESSION["userPassword"] ?>">
        <input type="text" name="user_old_password_confirm" placeholder="Confirm Old Password">
        <input type="password" name="user_new_password" placeholder="New Password">
        <input type="password" name="user_new_password_confirm" placeholder="Confirm New Password">
        <button type="submit" name="submit">Change Password</button>
    </form>
    <?php 
    }
    ?>
</body>
