<body>
    <div class="bg--outside">
        <form action="" method="post">
            <div class="container forgot-pass__container">
                <div class="row forgot-pass__row">
                    <h1 class="forgot-pass__title">Forgot Password</h1>
        
                    <div class="forgot-pass__content">
                        <p class="forgot-pass__content--para">Please enter your registered email in the form below, we will send the password to your email.</p>
                        <input type="email" class="forgot-pass__mail" name="forgot-pass__email" id="">
                        <?php
                        if(isset($_POST['forgot-pass__btn'])){
                            if(!empty($_POST['forgot-pass__email'])){
                                $email = $_POST['forgot-pass__email'];
                                if(checkDuplicateEmail($email)){
                                    $_SESSION['email'] = $email;
                                    header('location: login_signup.php?page=send_mail&email='.$email);
                                }else{
                                    echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Invalid Email !</p>";
                                }
                            }else{
                                echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Please enter your email !</p>";
                            }
                        }
                        ?>
                        <button name="forgot-pass__btn" class="forgot-pass__btn">SEND</button>
                    </div>

                    <div class="row forgot-pass__voucher">
                        <h1 class="voucher-main__header col-l-12 col-md-12 col-sm-12">VOUCHER</h1>

                        <?php
                            foreach(getAllVoucher() as $row){
                                $voucher_ID = $row['voucher_ID'];
                                $voucher_EXP = $row['voucher_EXP'];
                                $voucher_Discount = $row['voucher_Discount'];
                                $voucher_Describe = $row['voucher_Description'];
                                $voucher_photo = $row['voucher_Photo'];
                        ?>

                            <a href="/index.php?page=user_account&user=news_notice" class="voucher-main__items col-l-6 col-md-6 col-sm-12">
                                <img class="voucher-main__img" src="/assets/img/<?= $voucher_photo ?>" alt="" srcset="">
                            </a>
                        <?php
                            }
                        ?>

                        <!-- <a class="voucher-main__items col-l-6 col-md-6 col-sm-12">
                            <img class="voucher-main__img" src="/assets/img/voucher-2.jpg" alt="" srcset="">
                        </a> -->
                    </div>

                </div>
            </div>
            
        </form>
    </div>
</body>