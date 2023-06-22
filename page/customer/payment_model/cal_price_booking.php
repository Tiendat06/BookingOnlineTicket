<?php
    require_once('../connectInCus.php');
    if(isset($_POST['voucherID']) && isset($_POST['priceTicket'])){
        $voucherPrice = 0;
        $voucher_ID = $_POST['voucherID'];
        if(checkVoucher($voucher_ID)){
            $dataVoucher = getVoucherByVoucherID($voucher_ID);
            $voucherPrice = $dataVoucher['voucher_Discount'];
        }
        $ticketPrice = $_POST['priceTicket'];
        $sum = $ticketPrice - (floatval($voucherPrice) * $ticketPrice) / 100;
        // $_SESSION['total_Price'] = number_format($sum);

        echo number_format($sum);
    }

?>