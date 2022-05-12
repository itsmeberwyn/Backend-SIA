<?php
//destroys sessions for log out
session_start();
session_unset();
session_destroy();

header("location: ../index.php?logout=success");