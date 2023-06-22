<div class="bg--outside">

        <div class="container bg--inside">
            <div class="row">
                <div class="sign-in-sign-up__form">
                    <!-- <form onsubmit="return false" action="" method="POST"> -->
                        <form method="POST">
                            
                            <!-- sign up -->
                            <div class="sign-in__form" id="sign-up__form-move">
                        
                            <h1 class="sign-in__form--header">
                                SIGN UP
                            </h1>

                            <div class="sign-in__form--content">

                                <p class="sign-in__form--inp-phone sign-in__form--inp-para">Full name</p>
                                <input type="text" class="sign-in__form--input" name="sign_up_name">

                                <p class="sign-in__form--inp-phone sign-in__form--inp-para">Phone number</p>
                                <input type="text" class="sign-in__form--input" name="sign_up_phone">

                                <p class="sign-in__form--inp-phone sign-in__form--inp-para">Email address</p>
                                <input type="text" class="sign-in__form--input" name="sign_up_email">

                                <p class="sign-in__form--inp-pass sign-in__form--inp-para">Password</p>
                                <input type="password" class="sign-in__form--input" name="sign_up_pass">

                                <p class="sign-in__form--inp-pass sign-in__form--inp-para">Date of Birth</p>
                                <input type="date" class="sign-in__form--input" name="sign_up_dob">

                                <div class="sign-in__form--gender">
                                    <label class="sign-in__form--inp-para">Gender</label>
                                    <div class="sign-form__male-female">
                                        <input id="male" type="radio" name="sign_up_gender" value="M">
                                        <label class="sign-in__form--input sign-in__form--input-gender"
                                            for="male">Male</label>

                                        <input id="female" type="radio" name="sign_up_gender" value="F">
                                        <label class="sign-in__form--input sign-in__form--input-gender"
                                            for="female">Female</label>
                                    </div>
                                </div>

                                <!-- Sign up php -->
                                <?php
                                // if (!empty($_POST['sign_up_name']) && !empty($_POST['sign_up_phone']) && !empty($_POST['sign_up_email']) && !empty($_POST['sign_up_pass']) && !empty($_POST['sign_up_dob']) && !empty($_POST['sign_up_gender'])) {
                                //     $sign_up_name = $_POST['sign_up_name'];
                                //     $sign_up_phone = $_POST['sign_up_phone'];
                                //     $sign_up_email = $_POST['sign_up_email'];
                                //     $sign_up_pass = $_POST['sign_up_pass'];
                                //     $sign_up_dob = $_POST['sign_up_dob'];
                                //     $sign_up_gender = $_POST['sign_up_gender'];

                                //     $query = "call Sign_Up('$sign_up_name', '$sign_up_email', '$sign_up_phone', null, '$sign_up_dob', '$sign_up_gender', '$sign_up_pass')";
                                //     mysqli_query($conn, $query);

                                // }
                                if(isset($_POST['sign-up__btn'])){
                                    if (!empty($_POST['sign_up_name']) && !empty($_POST['sign_up_phone']) && !empty($_POST['sign_up_email']) && !empty($_POST['sign_up_pass']) && !empty($_POST['sign_up_dob']) && !empty($_POST['sign_up_gender'])){
                                        $sign_up_name = $_POST['sign_up_name'];
                                        $sign_up_phone = $_POST['sign_up_phone'];
                                        $sign_up_email = $_POST['sign_up_email'];
                                        $sign_up_pass = md5($_POST['sign_up_pass']);
                                        $sign_up_dob = $_POST['sign_up_dob'];
                                        $sign_up_gender = $_POST['sign_up_gender'];

                                        // check duplicate phone number
//                                        $query1 = mysqli_query($conn, "select * from customer where cus_Phone_number = '$sign_up_phone'");
//                                        $row1 = mysqli_fetch_assoc($query1);
                                        // mysqli_free_result($query1);

                                        // check duplicate email
//                                        $query2 = mysqli_query($conn, "select * from customer where cus_Email = '$sign_up_email'");
//                                        $row2 = mysqli_fetch_assoc($query2);
                                        // mysqli_free_result($query2);

                                        if(checkDuplicatePhone($sign_up_phone)){
                                            echo "<p class='sign-in__form-check'>Phone number has been used</p>";
                                            // exit();
                                        }else if(checkDuplicateEmail($sign_up_email)){
                                            echo "<p class='sign-in__form-check'>Email has been used</p>";
                                        }else{
//                                            $query3 = "call creCustomer('$sign_up_name', '$sign_up_email', '$sign_up_phone', null, '$sign_up_dob', '$sign_up_gender', '$sign_up_pass')";
//                                            $result = mysqli_query($conn, $query3);
//                                            // mysqli_free_result($result);
                                            createCustomer($sign_up_name, $sign_up_email, $sign_up_phone, null, $sign_up_dob, $sign_up_gender,$sign_up_pass);
                                            header('location: login_signup.php');
                                        }
                                    }else{
                                        echo "<p class='sign-in__form-check'>Please enter full informations</p>";
                                        // exit();
                                    }
                                }
                                ?>

                                <input type="checkbox" class="sign-in__form--input sign-up__checkbox" name="" id="sign-up__checkbox" required>
                                <label for="sign-up__checkbox" class="sign-up__form--label">I agree to the
                                    <a href="#" class="sign-in__form--link">
                                        Term of Use
                                    </a>
                                </label>

                                <p class="sign-in__form--para">Having account?
                                    <a href="?page=login" onclick="onClickSignInNow()" id="sign-up__form--link" class="sign-in__form--link">
                                        Sign in now
                                    </a>
                                </p>

                                <button name="sign-up__btn" class="sign-in__form--btn">SIGN UP</button>

                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div> 