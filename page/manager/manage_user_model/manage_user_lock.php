<?php

    if(isset($_GET['cusID']) && isset($_GET['isActive'])){
        $cus_ID = $_GET['cusID'];
        $isActive = $_GET['isActive'];
        activeAndLockAccount($cus_ID, $isActive);
        header('location: manager_main.php?page=manage_user');
    }   
?>