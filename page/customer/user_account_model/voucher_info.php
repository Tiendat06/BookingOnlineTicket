<?php
    if(isset($_GET['voucher'])){
        $voucherID = 'HAPPY'.$_GET['voucher'];
        $_SESSION['voucher_id'] = $voucherID;
        header('location: '.deleteURLVoucherIDInVoucher());
    }else{
        $voucherID = $_SESSION['voucher_id'];
    }
    $dataVoucher = getVoucherByVoucherID($voucherID);
    $voucher_EXP = $dataVoucher['voucher_EXP'];
    $voucher_Discount = $dataVoucher['voucher_Discount'];
    $voucher_Describe = $dataVoucher['voucher_Description'];
    $voucher_photo = $dataVoucher['voucher_Photo'];
?>
<body>
    <h1 class="voucher__title">ABOUT VOUCHER</h1>

    <div class="voucher__content">
        <img class="voucher__content--img col-l-5 col-md-5 col-sm-5" src="/assets/img/<?= $voucher_photo ?>" alt="" srcset="">

        <p class="voucher__content--describe col-l-12 col-md-12 col-sm-12">Description: <?= $voucher_Describe ?></p>
    </div>
</body>
<?php
    // }else{
    //     header('location: index.php?page=error_1');
    // }
?>