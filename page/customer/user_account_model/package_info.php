<?php
    if(isset($_GET['package'])){
        $comboID = $_GET['package'];
        $_SESSION['pakage_id'] = $comboID;

        header('location: '. deleteURLPackageIDInPackage());
    }else{
        $comboID = $_SESSION['pakage_id'];
    }
    $dataCombo = getComboByComboID($comboID);
    // print_r($dataCombo);
    $combo_Name = $dataCombo['combo_Name'];
    $combo_Description = $dataCombo['combo_Description'];
    $combo_Price = $dataCombo['Combo_Price'];
    $combo_photo = $dataCombo['combo_Photo'];
?>
<body>
    <h1 class="package__title--header voucher__title">ABOUT PACKAGE</h1>

    <div class="voucher__content">
        <img class="package__content--img voucher__content--img col-l-5 col-md-5 col-sm-5" src="/assets/img/<?= $combo_photo ?>" alt="" srcset="">

        <p class="package__content--describe col-l-12 col-md-12 col-sm-12">Name: <?= $combo_Name ?></p>
        <p class="package__content--describe col-l-12 col-md-12 col-sm-12">Description: <?= $combo_Description ?></p>
        <p class="package__content--describe col-l-12 col-md-12 col-sm-12">Price: <?= number_format($combo_Price)?>$</p>

    </div>
</body>
<?php
    // }
    // else{
    //     header('location: index.php?page=error_1');
    // }
?>