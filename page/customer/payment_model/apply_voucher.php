<?php
    require_once('../connectInCus.php');
    if(isset($_POST['voucherID'])){
        $voucher_ID = $_POST['voucherID'];
        if(checkVoucher($voucher_ID)){
            $dataVoucher = getVoucherByVoucherID($voucher_ID);
            $voucherPrice = $dataVoucher['voucher_Discount'];
        ?>
            <input type="hidden" id="voucher-price" value="<?= $voucherPrice ?>">
        <?php 
            echo number_format($voucherPrice);
        }else{
            echo '0';
        }
    }
?>
