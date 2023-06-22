<!-- news -->
<body>
    <div class="bg--outside">
        <form action="" method="post">

            <div class="container">
                <div class="row user-account">
                    <div class="account-setting col-l-3 col-md-3 col-sm-3">
                        <!-- <i style="cursor: default;" class="fa-solid fa-user account-setting__icon"></i> -->
                        <i style="cursor: default;" class="fas fa-user-circle account-setting__icon"></i>
                        <p class="account-setting__para">
                            <?php $username = $_SESSION['login_phone'];
                            echo getName($username); ?>
                        </p>
                        <?php 
                            $isClickAccount = '';
                            $isClickNews = '';
                            $isClickMyticket = '';
                            $isClickMyVoucher = '';
                            if(isset($_GET['user'])){
                                switch($_GET['user']){
                                    case 'account': $isClickAccount = 'isClick';
                                        break;
                                    case 'news_notice': $isClickNews = 'isClick';
                                        break;
                                    case 'myticket': $isClickMyticket = 'isClick';
                                        break;
                                    case 'voucher_info': $isClickNews = 'isClick';
                                        break;
                                    case 'package_info': $isClickNews = 'isClick';
                                        break;
                                    default:
                                        break;
                                }
                            }
                        ?>
            
                        <a href="/user_account?user=account" class=" account-setting__account account-setting__items">
                            <p class="<?= $isClickAccount ?> account-setting__header">ACCOUNT</p>
                        </a>
                        
                        <a href="/user_account?user=news_notice" class=" account-setting__news account-setting__items">
                            <p class="<?= $isClickNews ?> account-setting__header">NEWS</p>
                        </a>
        
                        <a href="/user_account?user=myticket" class=" account-setting__my-ticket account-setting__items">
                            <p class="<?= $isClickMyticket ?> account-setting__header">MY TICKET</p>
                        </a>
        
                        <!-- <a href="?page=user_account&user=voucher" class=" account-setting__my-voucher account-setting__items">
                            <p class="<= $isClickMyVoucher ?> account-setting__header">MY VOUCHER</p>
                        </a> -->
        
                    </div>
                    
                    <div class="account-content col-l-9 col-md-9 col-sm-9">
                        <?php
                        if(isset($_GET['user'])){
                            switch($_GET['user']){
                                case 'news_notice': include('user_account_model/news_notice.php');
                                    break;
                                case 'account': include('user_account_model/account.php');
                                    break;
                                case 'myticket': include('user_account_model/myticket.php');
                                    break;
                                case 'voucher_info': include('user_account_model/voucher_info.php');
                                    break;
                                case 'package_info': include('user_account_model/package_info.php');
                                    break;
                                default:
                                    header('location: index.php?page=error_1');
                                    break;
                            }
        
                        }
                        
                        ?>
                    </div>
        
                </div>
            </div>
        </form>
    </div>

</body>