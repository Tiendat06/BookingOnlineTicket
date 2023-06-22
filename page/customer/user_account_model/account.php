<?php
    $dataCus = getCusByPhone($_SESSION['login_phone']);
?>
<body>
    <div class="account-content__title">
        <h1 class="account-content__account--header">ACCOUNT INFO</h1>
    </div>

    <!-- account informations -->
    <div class="account-content__account">

        <div class="account-content__account--name-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--name">Full Name (*)</p>
            <input name="account__username" class="account-content__account--inp" type="text" value="<?= getName($username); ?>" id="" required>
        </div>
    
        <div class="account-content__account--phone-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--phone">Phone number (*)</p>
            <input name="account__phone" class="account-content__account--inp" type="text" value="<?= $_SESSION['login_phone'] ?>" id="" required>
        </div>
    
        <div class="account-content__account--email-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--email">Email (*)</p>
            <input name="account__email" class="account-content__account--inp" type="email" value="<?= $dataCus['cus_Email'] ?>" id="" required>
        </div>

        <div class="account-content__account--dob-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--dob">DOB (*)</p>
            <input name="account__dob" class="account-content__account--inp" type="date" value="<?= $dataCus['cus_DOB'] ?>" id="" required>
        </div>

        <div class="account-content__account--gender-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--gender">Gender ( M, F / Male, Female) (*)</p>
            <input name="account__gender" id="" maxlength="1" class="account-content__account--inp account-content__account--inp-gender" type="text" value="<?= $dataCus['cus_Sex'] ?>" required>
        </div>

        <div id="account-content__current-pass" class="account-content__account--pass-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--pass">Current Password (*)</p>
            <input name="account__cur-pass" class="account-content__account--inp" type="password" value="" id="" required>
        </div>

        <div class="account-content__account--pass-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--pass">Change Password?</p>
            <input style="caret-color: transparent; cursor:default;" name="account__pass" maxlength="0" onclick="onClickChangePassword()" class="account-content__account--inp" type="password" value="1234567890" id="account-content__account--inp-pass">
        </div>

        <div id="account-content__new-pass" class="d-none account-content__account--pass-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--pass">New Password (*)</p>
            <input id="account__new-pass" class="account-content__account--inp" type="password" value="">
        </div>

        <div id="account-content__re-new--pass" class="d-none account-content__account--pass-inp account-content__account--info">
            <p class="account-content__account--para account-content__account--pass">Re-enter New Password (*)</p>
            <input id="account__re-new-pass" class="account-content__account--inp" type="password" value="">
        </div>
    </div>

    <?php
        if(isset($_POST['account-content__account--btn'])){
            // Change password (all infor)
            if(isset($_POST['account__new-pass']) && isset($_POST['account__re-new-pass'])){

                if(!empty($_POST['account__username']) && !empty($_POST['account__phone']) &&
                !empty($_POST['account__email']) && !empty($_POST['account__dob']) &&
                !empty($_POST['account__gender']) && !empty($_POST['account__cur-pass']) &&
                !empty($_POST['account__new-pass']) && !empty($_POST['account__re-new-pass'])){

                    $curPass = md5($_POST['account__cur-pass']);
                    $reNewPass = $_POST['account__re-new-pass'];
                    $newPass = $_POST['account__new-pass'];
                    if(checkCustomerPass($curPass) && $newPass == $reNewPass){
                        $cusID = getcusIDByPhone($_SESSION['login_phone']);
                        $name = $_POST['account__username'];
                        $phone = $_POST['account__phone'];
                        $email = $_POST['account__email'];
                        $dob = $_POST['account__dob'];
                        $gender = mb_strtoupper($_POST['account__gender']);

                        // normalize name
                        // $name = strtolower($name);
                        // $name = ucwords($name);
                        updateAccountCustomer($cusID, $name, $phone, $email, $dob, $gender, md5($newPass));
                        echo "<p class='account-content__pass--wrong'>Your change has been saved !</p>";

                    }else{
                        echo "<p class='account-content__pass--wrong'>Invalid Password !</p>";
                    }
                }else{
                    echo "<p class='account-content__pass--wrong'>Please enter full informations to update your account !</p>";
                }
            }else{
                // Change informations except password
                if(!empty($_POST['account__username']) && !empty($_POST['account__phone']) &&
                !empty($_POST['account__email']) && !empty($_POST['account__dob']) &&
                !empty($_POST['account__gender']) && !empty($_POST['account__cur-pass'])){
                    
                    $cusID = getcusIDByPhone($_SESSION['login_phone']);
                    $name = $_POST['account__username'];
                    $phone = $_POST['account__phone'];
                    $email = $_POST['account__email'];
                    $dob = $_POST['account__dob'];
                    $gender = mb_strtoupper($_POST['account__gender']);
                    $curPass = md5($_POST['account__cur-pass']);
                    $newPass = $curPass;
                    // normalize name
                    // $name = strtolower($name);
                    // $name = ucwords($name);
                    if(checkCustomerPass($curPass)){
                        updateAccountCustomer($cusID, $name, $phone, $email, $dob, strtoupper($gender), $newPass);
                        echo "<p class='account-content__pass--wrong'>Your change has been saved !</p>";
                    }else{
                        echo "<p class='account-content__pass--wrong'>Invalid Password !</p>";
                    }
                }else{
                    echo "<p class='account-content__pass--wrong'>Please enter full informations to update your account !</p>";
                }
            } 
        }
    ?>

    <button name="account-content__account--btn" class="account-content__account--btn" type="submit">UPDATE</button>

</body>