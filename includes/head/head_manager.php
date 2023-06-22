
<body>
    <div class="block__around--manager">

        <nav class="header__nav--manager">
            <?php
            $home = '';
            $user = '';
            $income = '';
            $film = '';

                if(isset($_GET['page'])){
                    switch($_GET['page']){
                        // home
                        case 'manage_showtime': $home = 'isClick';
                            break;

                        // user
                        case 'manage_user': $user = 'isClick';
                            break;
                        case 'manage_user_lock': $user = 'isClick';
                            break;
                        case 'manage_user_refresh': $user = 'isClick';
                            break;
                        case 'manage_user_delete': $user = 'isClick';
                            break;
        
                        // booking
                        case 'manage_film': $film = 'isClick';
                            break;
                        case 'manage_film_addsht': $film = 'isClick';
                            break;
                        case 'manage_film_edit': $film = 'isClick';
                            break;
                        case 'manage_film_info': $film = 'isClick';
                            break;
                        case 'manage_film_delete': $film = 'isClick';
                            break;
                        case 'manage_film_add_film': $film = 'isClick';
                            break;
                        case 'mange_income': $income = 'isClick';
                            break;
                        default:
                            break;
                    }
                }
            ?>

            <div class="header__nav--manager-top">
                <img class="header__nav--manager-img" src="../assets/img/bg_manager.png" alt="" srcset="">

                <a href="?page=manage_showtime" class="<?= $home ?> header__link--manager header__nav--manager-booking-history-link">
                    <!-- <i class="header__link--manager-icon fa fa-home"></i> -->
                    <i class="header__link--manager-icon fa-solid fa-video"></i>
                    <p>MANAGE SHOWTIME</p>
                </a>

                <a href="?page=manage_user" class="<?= $user ?> header__link--manager">
                    <i class="header__link--manager-icon fa fa-user"></i>
                    <p>MANAGE USERS</p>
                </a>

                <a href="?page=manage_film" class="<?= $film ?> header__link--manager">
                <i class="header__link--manager-icon fa-solid fa-film"></i>
                    <p>MANAGE FILM</p>
                </a>

                <a href="?page=mange_income" class="<?= $income ?> header__link--manager">
                <!-- <i class="header__link--manager-icon fa-solid fa-book-open"></i> -->
                <i class="header__link--manager-icon fa-solid fa-money-bill-1-wave"></i>
                    <p>MANAGE INCOME</p>
                </a>
            </div>

            <form method="post">
                <div class="header__setting--manager">
                    <i id="header__setting--manager" onclick="onClickBtnSetting()" class="click_setting-off header__setting--manager-icon fa-solid fa-gear"></i>
                    <button name="manager__log-out" onclick="onClickBtnSetting()" class="header__setting--para">LOG OUT</button>
                </div>

                <?php
                    if(isset($_POST['manager__log-out'])){
                        unset($_SESSION['login_phone']);
                        unset($_SESSION['login_pass']);
                        header('location: login_signup.php?page=login_signup');
                    }
                ?>
            </form>
        </nav>
        
        <div class="manager__content">
        <?php
        if(isset($_GET['page'])){
            switch($_GET['page']){
                // sht
                case 'manage_showtime': include('./page/manager/manage_showtime.php');
                    break;
                case 'manage_sht_delete': include('./page/manager/manage_sht_model/manage_sht_delete.php');
                    break;
                case 'manage_sht_edit': include('./page/manager/manage_sht_model/manage_sht_edit.php');
                    break;

                // user
                case 'manage_user': include('./page/manager/manage_user.php');
                    break;
                case 'manage_user_lock': include('./page/manager/manage_user_model/manage_user_lock.php');
                    break;
                // case 'manage_user_refresh': include('./page/manager/manage_user_model/manage_user_refresh.php');
                //     break;
                case 'manage_user_delete': include('./page/manager/manage_user_model/manage_user_delete.php');
                    break;

                // film
                case 'manage_film': include('./page/manager/manage_film.php');
                    break;
                case 'manage_film_addsht': include('./page/manager/manage_film_model/manage_film_addsht.php');
                    break;
                case 'manage_film_edit': include('./page/manager/manage_film_model/manage_film_edit.php');
                    break;
                case 'manage_film_info': include('./page/manager/manage_film_model/manage_film_info.php');
                    break;
                case 'manage_film_delete': include('./page/manager/manage_film_model/manage_film_delete.php');
                    break;
                case 'manage_film_add_film': include('./page/manager/manage_film_model/manage_film_add_film.php');
                    break;
                case 'manage_film_add_type': include('./page/manager/manage_film_model/manage_film_add_type.php');
                    break;

                // income
                case 'mange_income': include('./page/manager/mange_income.php');
                    break;

                default:
                    break;
            }

        }
        ?>
    </div>

    </div>
    
</body>

