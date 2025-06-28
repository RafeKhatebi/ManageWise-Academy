<?php
session_start();
//new added
session_unset();
session_destroy();
header("location:login.php");
