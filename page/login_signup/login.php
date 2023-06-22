<!-- content -->
<div class="bg--outside">

<div class="container bg--inside">
    <div class="row">
        <div class="sign-in-sign-up__form">
            <!-- <form onsubmit="return false" action="" method="POST"> -->
                <form method="POST" id="form__login">
                    <!-- sign-in -->
                    <div class="sign-in__form" id="sign-in__form-move">
                    <h1 class="sign-in__form--header">
                        LOGIN
                    </h1>

                    <div class="sign-in__form--content">
                        <p class="sign-in__form--inp-phone sign-in__form--inp-para">Phone number</p>
                        <input type="text" id="sign_in_phone" class="sign-in__form--input" name="sign_in_phone">

                        <p class="sign-in__form--inp-pass sign-in__form--inp-para">Password</p>
                        <input type="password" id="sign_in_pass" class="sign-in__form--input" name="sign_in_pass">

                        <!-- login -->
                        <?php

                        if(isset($_POST['login__btn'])){
                            
                            if (!empty($_POST['sign_in_phone']) && !empty($_POST['sign_in_pass'])){
                                $pass = md5($_POST['sign_in_pass']);
                                $phone = $_POST['sign_in_phone'];
                            
                                
                                if(!checkLogin($phone, $pass)){
                                    echo "<p class='sign-in__form-check'>Wrong phone number or password</p>";
                                }
                                else if(checkLogin($phone, $pass) && $pass == md5('123456') && $phone == 'admin'){
                                    $_SESSION['login_phone'] = $phone;
                                    $_SESSION['login_pass'] = $pass;
                                    header('location: manager_main.php?page=manage_user');
                                }
                                else{
                                    $dataAcc = getAccByPhone($phone);
                                    $isActive = $dataAcc['acc_isActive'];

                                    if($isActive == 'Lock'){
                                        echo "<p class='sign-in__form-check'>Your account has been locked</p>";
                                    }else{
                                        $_SESSION['login_phone'] = $phone;
                                        $_SESSION['login_pass'] = $pass;
                                        header('location: index');
                                    }
                                }
                            }else{
                                echo "<p class='sign-in__form-check'>Phone number and Password cannot be blanked</p>";
                            }
                        }
                        ?>

                        <div class="sign-in__form-forgot-remember">
                            <div>
                                <input type="checkbox" class="sign-in__form--checkbox" name="login__checkbox" id="sign-in__form--remember">
                                <label for="sign-in__form--remember"
                                    class="sign-up__form--label sign-in__form--label">
                                    Remember me
                                </label>
                            </div>
                            <a href="?page=forgot_password" class="sign-in__form--link">
                                <p class="sign-in__form--para sign-in__form--para-forgot">Forgot password?</p>
                            </a>
                        </div>

                        <p class="sign-in__form--para">Don't have account?
                            <a href="?page=signup" onclick="onClickSignUpNow()" id="sign-in__form--link" class="sign-in__form--link">
                                Sign up now
                            </a>
                        </p>

                        <button name="login__btn" id="sign-in__form--btn" class="sign-in__form--btn">LOGIN</button>

                    </div>
                </div>

            </form>
        </div>

    </div>
</div>
</div> 