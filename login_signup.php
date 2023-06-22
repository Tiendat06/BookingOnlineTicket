<?php
    ob_start();
    session_start();
    if(!empty($_SESSION['login_phone']) && !empty($_SESSION['login_pass'])){
        header('location: index.php?page=index');
    }
    //include('connect.php');
    require_once('./database/connect.php');
    //global $conn;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    <title>Galaxy Cinema</title>
    <link rel="shortcut icon" href="./assets/img/webicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/font/fontawesome-free-6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/head.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="./assets/js/login_signup.js"></script>
    <script src="./assets/js/head/header.js"></script>

</head>

<body>
    <!-- header -->
    <?php 
        include('./includes/head/head_login.php');
    ?>

    <!-- content -->
    
    <?php
        if(isset($_GET['page'])){
            switch($_GET['page']){
                case 'signup': include('./page/login_signup/signup.php'); 
                    break;
                case 'login': include('./page/login_signup/login.php');
                    break;
                case 'main_page': include('./page/customer/main_page.php');
                    break;
                case 'describe': include('./page/customer/describe.php');
                    break;
                case 'movie': include('./page/customer/movie.php');
                    break;
                case 'clusters': include('./page/customer/clusters.php');
                    break;
                case 'voucher': include('./page/customer/voucher.php');
                    break;
                case 'forgot_password': include('./page/login_signup/forgot_pass.php');
                    break;
                case 'send_mail': include('./page/login_signup/forgot_pass_model/forgot_pass_send_mail.php');
                    break;
                case 'change_pass': include('./page/login_signup/forgot_pass_model/forgot_pass_change_pass.php');
                    break;
                case 'user_account': include('./page/login_signup/login.php');
                    // header('location: '.deleteOneURL('user'));
                    break;
                default:
                // include('login.php');
                    include('./page/login_signup/login.php');
                    header('location: '. getNewURL());

                    // echo $new_url;
                    
                    
                    break;
            }
        }else{
            include('./page/login_signup/login.php');
        }
    ?>
    
    <!-- footer -->
    <?php
        include('./includes/foot/footer.php');
    ?>
</body>
