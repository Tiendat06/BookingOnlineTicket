<?php
    session_start();
    if(!isset($_SESSION['login_pass']) && !isset($_SESSION['login_phone'])){
        header('location: login_signup.php?page=login_signup');
    }
    // $dataCus = getCusByPhone($_SESSION['login_phone']);

    include('./database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    <title>Manager</title>
    <link rel="shortcut icon" href="./assets/img/webicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/font/fontawesome-free-6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/head.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
    <script src="./assets/js/head/manager_head.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>

    <?php
        include('./includes/head/head_manager.php');
    ?>
    
    <?php
        
        // if(isset($_GET['page'])){
        //     switch($_GET['page']){
        //         case 'manager': include('./page/manager/manage_index.php');
        //             break;
        //         default: 
        //         // echo '<img class="side-bar__img--manager" src="../assets/img/bg-admin.jpg" alt="" srcset="">';
        //         break;
        //     }
        // }
    ?>

    <?php
        // include('../foot/foot_manager.php');
    ?>
</body>
</html>