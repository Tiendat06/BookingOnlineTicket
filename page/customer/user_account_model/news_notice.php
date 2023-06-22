<body>
    <h1 class="news__title">NEWS AND ENDOW</h1>

    <!-- combo -->
    <h2 class="news-info__package--title">COMBO WHEN BUY TICKET</h2>
    <div class="news-info__package">
        <?php
            foreach(getAllCombo() as $row){
                $combo_ID = $row['combo_ID'];
                $combo_Name = $row['combo_Name'];
                $combo_Photo = $row['combo_Photo'];
        ?>

            <div class="news-info__package--items col-l-3 col-md-3 col-sm-6">
                <a href="?page=user_account&user=package_info&package=<?= $combo_ID ?>" class="news-info__package--inner">
                    <img class="news-info__package--img" src="/assets/img/<?= $combo_Photo ?>" alt="" srcset="">
                </a>
            </div>
        <?php
            }
        ?>

    <!-- voucher -->
    <h2 class="news-info__voucher--title">VOUCHER WHEN BOOKING SEAT</h2>
    <div class="news-info__voucher">
        <?php
            foreach(getAllVoucher() as $row){
                $voucher_Discount = $row['voucher_Discount'];
                $voucher_photo = $row['voucher_Photo'];
        ?>
            <div class="news-info__voucher--items col-l-6 col-md-6 col-sm-12">
                <a href="?page=user_account&user=voucher_info&voucher=<?= $voucher_Discount ?>" class="news-info__voucher--inner">
                    <img class="news-info__voucher--img" src="/assets/img/<?= $voucher_photo ?>" alt="" srcset="">
                </a>
            </div>        
        <?php
            }
        ?>
    </div>
    
    </div>
</body>
