<?php

    session_start();
    session_destroy();
    header('location:/serviceHub/Signup_login/login.php');
?>
