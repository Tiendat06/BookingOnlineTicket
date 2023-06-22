<?php
    ob_start();
    $session_time = 1800; // 30 phút

    // create session time
    session_set_cookie_params($session_time);
    session_start();

    // if $_SESSION['login_pass'] and $_SESSION['login_phone'] is not contains, then out to login
    if(!isset($_SESSION['login_pass']) && !isset($_SESSION['login_phone'])){
        header('location: login_signup.php?page=main_page');
    }

    require_once('./database/connect.php');

   //global $conn;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <base href="http://localhost/"> -->
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
    <script src="./assets/js/head/header.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<body>
    <!-- Header -->
    <?php 
        include('./includes/head/head.php');
    ?>
    <!-- Content -->
    <?php
        // echo "<p>".$_GET['page']."</p>";
        
        if(isset($_GET['page'])){
            switch($_GET['page']){
                // case 'main_page': include('./page/customer/main_page.php'); 
                //     break;
                // case 'ticket_history': include('./page/customer/ticket_history.php');
                //     break;
                // case 'news': include('./page/customer/news_notice.php');
                //     break;
                // case 'myticket': include ('./page/customer/myticket.php');
                //     break;
                case 'vnpay': include('./vnpay_php/index.php');
                    break;
                case 'user_account': include('./page/customer/user_account.php');
                    break;
                case 'movie': include('./page/customer/movie.php');
                    break;
                case 'describe': include('./page/customer/describe.php');
                    break;
                case 'booking_seat': include('./page/customer/booking_seat.php');
                    break;
                case 'payment_page': include('./page/customer/payment_page.php');
                    break;
                case 'clusters': include('./page/customer/clusters.php');
                    break;
                case 'member': include('./page/customer/member.php');
                    break;
                case 'choose_package': include('./page/customer/choose_package.php');
                    break;
                // case 'voucher': include('./page/customer/voucher.php');
                //     break;
                case 'error_1': include('./page/customer/error_1.php');
                    break;
                default:
                    // echo "<p>Hello world</p>";
                    include('./page/customer/main_page.php'); 
                    break;
            }
        }else{
            include('./page/customer/main_page.php'); 
        }
    ?>
    <!-- Footer -->
    <?php 
        include('./includes/foot/footer.php');
    ?>
</body>
</html>