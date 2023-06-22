
<body>
    <!-- slider -->
    <div class="slide-show__container">

        <div class=" slide-show__main">
            
            <div class="slide-show--click">
                <?php
                $i = 0;
                $d_none = '';
                    foreach(getNowShowing(null, null, null) as $row){
                        $film_slider = $row['film_Slider'];
                        $film_photo = $row['film_photo'];
                    ?>
                        
                        <img class="slide-show__img <?= $d_none ?> fade" src="/assets/img/<?= $film_slider ?>">
                        
                    <?php
                        $d_none = 'd-none';
                    }
                    ?>
                <!-- <img class="slide-show__img d-none fade" src="/assets/img/demon-slider.jpg">
                <img class="slide-show__img d-none fade" src="/assets/img/creed-slider.jpg">
                <img class="slide-show__img d-none fade" src="/assets/img/songsot-slider.jpg"> -->
                <a class="slider-prev" onclick="backImg()">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <a class="slider-next" onclick="nextImg()">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        
        </div>
    </div>

    <!-- film -->
    <div class="film-main__bg-outside">
        <h1 class="film-main__header">MOVIE SELECTION</h1>
        <div class="film-main container">
            <div class="film-main__row">
                

                <div id="film-main__list" class="film-main__list">
                    
                    <div id="film-main__inner-list" class="film-main__inner-list">
                        <?php
                            foreach(getAllFilmLimitSixFilm() as $row){
                                $url = '';
                                $file_name = basename($_SERVER['PHP_SELF']);
                                if($file_name != 'index.php'){
                                    
                                }
                        ?>
                            <a href="?page=describe&filmID=<?= $row['film_ID'] ?>" title="<?= $row['film_Name'] ?>" class="film-main__items col-l-2 col-md-3 col-sm-6">
                                <img src="<?php echo '/assets/img/'. $row['film_photo'] ?>" alt="" class="film-main__items--img">
                                <div class="film-main__items-booking">
                                    <h1 class="film-main__items-title"><?= $row['film_Name'] ?></h1>
                                    <button class="film-main__btn" type="submit">BOOKING</button>
                                </div>
                            </a>
                        <?php
                            }
                        ?>

                    </div>
                    <a onclick="onClickFilmMainLeft()" id="film-main__click--left" class="film-main__click--left">
                        <i class="fa-solid fa-circle-chevron-left"></i>
                    </a>
    
                    <a onclick="onClickFilmMainRight()" id="film-main__click--right" class="film-main__click--right">
                        <i class="fa-solid fa-circle-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- voucher -->
    <div class="voucher-main__bg-outside">
        <div class="container">
            <div class="row">
                <h1 class="voucher-main__header col-l-12 col-md-12 col-sm-12">VOUCHER</h1>

                <?php
                    foreach(getAllVoucher() as $row){
                        $voucher_ID = $row['voucher_ID'];
                        $voucher_EXP = $row['voucher_EXP'];
                        $voucher_Discount = $row['voucher_Discount'];
                        $voucher_Describe = $row['voucher_Description'];
                        $voucher_photo = $row['voucher_Photo'];
                ?>

                    <a href="?page=user_account&user=news_notice" class="voucher-main__items col-l-6 col-md-6 col-sm-12">
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
</body>

<script>
    setIntervalSlider()
</script>

