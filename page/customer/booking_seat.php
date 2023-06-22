<?php

    // get CusID by phone
    $accID = getcusIDByPhone($_SESSION['login_phone']);

    // save $_GET[''] items
    if(isset($_GET['filmID']) && isset($_GET['area'])){
        $film_ID = $_GET['filmID'];
        $_SESSION['filmID'] = $film_ID;
        $film_ID = $_SESSION['filmID'];

        $area_ID = $_GET['area'];
        $_SESSION['area_ID'] = $area_ID;
        $area_ID = $_SESSION['area_ID'];    

        // delete url['query']
        header('location: '.deleteURLFilmID_AreaID());
        
    }
    // else{
        $film_ID = $_SESSION['filmID'];     // phải có
        $area_ID = $_SESSION['area_ID'];    // phải có
        // $sht_ID = $_SESSION['sht_ID'];
        // $cluster_ID = $_SESSION['cluster_ID'];         // phải có/ get
    // }

    if(isset($_GET['stID']) && isset($_GET['cluster'])){
        $sht_ID = $_GET['stID'];                
        $_SESSION['sht_ID'] = $sht_ID;
        
        $cluster_ID = $_GET['cluster'];         
        $_SESSION['cluster_ID'] = $cluster_ID;
        
        header('location: '.deleteURLCluster_ShtID());
    }
    // else{
    $sht_ID = $_SESSION['sht_ID'];                
    $cluster_ID = $_SESSION['cluster_ID'];  
    // }
    foreach(getSeatByShtID($sht_ID) as $row){
        $seat_ID = $row['seat_ID'];
        $seat_Post_Name = 'booking-seat-pay__'.$seat_ID;
        $package_select_name = 'package__select--'.$seat_ID;
        if(isset($_SESSION[$seat_Post_Name]) && $_SESSION[$package_select_name]){
            unset($_SESSION[$package_select_name]);
            unset($_SESSION[$seat_Post_Name]);
        }
    }

    // save $_SESSION and get all neccessary informations
    $dateSession = $_SESSION['date'];       
    $film_type = $_SESSION['film_Type'];    
    $date = dayReverse($dateSession);

    $film_type_price = intval(getFilmTypePrice($film_type));

    $dataArea = getAreaByAreaID($area_ID);
    $area_Name = $dataArea['area_Name'];

    $dataFilm = array();
    $dataFilm = getFilmByFilmID($film_ID);
    $film_Name = $dataFilm['film_Name'];
    $film_photo = $dataFilm['film_photo'];

    $dataClus = array();
    $dataClus = getClusterByClusterID($cluster_ID);
    $cluster_Name = $dataClus['cluster_Name'];
    
    $dataST = array();
    $dataST = getShowTimeByShowTimeID($sht_ID);
    $room_ID = $dataST['room_ID'];
    $sht_Time = $dataST['sht_Time'];
    $sht_Time_end = $dataST['sht_Time_end'];

    $dataRoom = array();
    $dataRoom = getRoomByRoomID($room_ID);
    // print_r($dataRoom);
    $room_Name = $dataRoom['room_Name'];
    $room_Total_Seats = $dataRoom['room_Total_seats'];
?>

<body>
    <div class="bg--outside">
        <?php
            // /page/customer/payment_page.php?sht_ID=<?= $sht_ID
        ?>
        <form action="/choose_package" method="post">

            <div class="container">
                <div class="row booking-seat__content">
                        <!-- booking header -->
                        <div class="booking-seat__content--info col-l-12 col-md-12">
                            <h1 class="booking-seat__content--info-header">
                                BOOKING ONLINE
                            </h1>
                            <h1 class="booking-seat__content--info-header">
                                <?= $film_Name ?>
                            </h1>
                            <p class="booking-seat__content--info-para">
                                <?php echo $cluster_Name." | ". $room_Name." | Seat Total: ". $room_Total_Seats   ?>
                            </p>
                            <p class="booking-seat__content--info-last-para booking-seat__content--info-para">
                                <?php echo $date ." ". $sht_Time ?> ~ <?php echo $date ." ". $sht_Time_end ?>
                            </p>
                        </div>
    
                        <!-- booking content -->
                        <div class="booking-seat__content--seat">
                            <!-- <h1 class="booking-seat__content--screen col-l-12 col-md-12 col-sm-12">SCREEN</h1> -->
                            <img class="booking-seat__content--screen col-l-12 col-md-12 col-sm-12" src="/assets/img/bg-screen.png" alt="">
                            <?php
                            $i = 1;
                            $color = '';
                                foreach(getSeatByShtID($sht_ID) as $row){
                                    $seat_Number = $row['seat_Number'];
                                    $seat_ID = $row['seat_ID'];
                                    $is_Book = $row['isBook'];
                                    // echo $is_Book;
                                    if($i <= 20) $color = 'var(--standard-border)';
                                    elseif($i > 20 && $i <= 40) $color = 'var(--vip-border)';
                                    elseif($i > 40) $color = 'var(--couple-border)';
                                    // create input:hidden with id include $seat_ID to create a pre-existing format
                            ?>
                                <input type="hidden" id="SID_<?= $seat_ID ?>" value="<?= $seat_ID ?>" name="booking-seat__content-<?= $seat_ID ?>">
                                <div id="<?= $seat_ID ?>" class="<?= $is_Book ?> booking-seat__content--seat-items col-sm-1-2" onclick="onClickSeat(this.id)" style="border: 2px solid <?= $color ?>; color: <?= $color ?>;"><?= $seat_Number ?></div>                
                            <?php
                            $i++;
                                }
                            ?>
                        </div>
    
                        <!-- comment -->
                        <div class="booking-seat__content--notice col-l-12 col-md-12 col-sm-12">
                            <div class="booking-seat__content-seat-box ">
                                <div class="booking-seat__content-seat-box-type booking-seat__content--empty">
                                    <div class="booking-seat__content--box booking-seat__content--empty-box"></div>
                                    <p class="booking-seat__content--para">Empty Seat</p>
                                </div>
                                <div class="booking-seat__content-seat-box-type booking-seat__content--booked">
                                    <div class="booking-seat__content--box booking-seat__content--booked-box"></div>
                                    <p class="booking-seat__content--para">Booked Seat</p>
                                </div>
                                <div class="booking-seat__content-seat-box-type booking-seat__content--choosing">
                                    <div class="booking-seat__content--box booking-seat__content--choosing-box"></div>
                                    <p class="booking-seat__content--para">Choosing Seat</p>
                                </div>
                            </div>
    
                            <div class="booking-seat__content-seat-type">
                                <div class="booking-seat__content-seat-type-inner">
                                    <div class="booking-seat__content-seat-type-box booking-seat__content-seat-type-box-standard"></div>
                                    <p class="booking-seat__content--para">Standard</p>
                                </div>
                                <div class="booking-seat__content-seat-type-inner">
                                    <div class="booking-seat__content-seat-type-box booking-seat__content-seat-type-box-vip"></div>
                                    <p class="booking-seat__content--para">VIP</p>
                                </div>
                                <div class="booking-seat__content-seat-type-inner">
                                    <div class="booking-seat__content-seat-type-box booking-seat__content-seat-type-box-couple"></div>
                                    <p class="booking-seat__content--para">Couple</p>
                                </div>
                            </div>
                        </div>
    
                        <!-- booking btn next -->
                        <!-- <button onclick="onClickNextBtn()" id="booking-seat__btn-next" class="booking-seat__btn-next">NEXT</button>
                        <button onclick="onClickResetBtn()" id="booking-seat__btn-reset" class="booking-seat__btn-next booking-seat__btn-reset d-none">RESET</button> -->
                        
                        <!-- ticket-info -->
                        <div class="booking-seat__content--ticket">
                        <p class="booking-seat__content--ticket-para">TICKET INFORMATION</p>
                            <table class="booking-seat__content--table" cellspacing="0" style="text-align: center; border-color: var(--booked-seat);">
                                <tbody>
                                    
                                    <tr class="booking-seat__content--tr">
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">FILM</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">DATE</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">FILM TYPE</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">TIME</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">AREA</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">CLUSTER</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">ROOM</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">SEAT</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">SEAT TYPE</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">FILM TYPE PRICE</p> </th>
                                        <th class="booking-seat__content-th"> <p class="booking-seat__content--th-para">PRICE</p> </th>
                                    </tr>

                                    <?php
                                        foreach(getSeatByRoomIDNoPrepare($room_ID) as $row){
                                            // $seat_Number = $i;
                                            $seat_ID = $row['seat_ID'];
                                            $seat_Number = $row['seat_Number'];
                                            $seat_Type = $row['seat_type'];
                                            $seat_Price = '';
    
                                            if($seat_Number <= 20) {
                                                // $seat_Type = 'Standard';
                                                $seat_Price = '3';
                                                $seat_Price = intval($seat_Price) + $film_type_price;
                                            }
                                            else if($seat_Number > 20 && $seat_Number <= 40){
                                                // $seat_Type = 'Vip';
                                                $seat_Price = '6';
                                                $seat_Price = intval($seat_Price) + $film_type_price;
                                            }
                                            else if($seat_Number > 40) {
                                                // $seat_Type = 'Couple';
                                                $seat_Price = '5';
                                                $seat_Price = intval($seat_Price) + $film_type_price;
                                            }
                                            // create input:hidden to get seat is choosing by JS with a pre-existing format
                                    ?>
                                        <tr id="booking-seat-tr__<?= $seat_ID ?>" class="booking-seat__content--tr d-none">
                                            <input id="input-seat__<?= $seat_ID ?>" class="" type="hidden" value="<?= $seat_ID ?>">
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $film_Name ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $date ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $film_type ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $sht_Time ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $area_Name ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $cluster_Name ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $room_Name ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $seat_Number ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= $seat_Type ?></p> </td>
                                            <td class="booking-seat__content-td"> <p class="booking-seat__content--td-para"><?= number_format($film_type_price) ?></p> </td>
                                            <td class="booking-seat__content-td"> <span id="booking-seat__content--td-seat-price_<?= $seat_ID ?>" class="booking-seat__content--td-seat-price booking-seat__content--td-para"><?= number_format($seat_Price) ?></span> <span>$</span> </td>
                                        </tr>
                                        
                                    <?php
                                        }
                                    ?>

                                    <!-- <tbody id="tbody">

                                    </tbody> -->
                                </tbody>
                            </table>
                            <!-- Total price -->
                            <div class="booking-seat__content--ticket-total">
                                <h1 class="booking-seat__content--ticket-title">Total: </h1>
                                <div class="booking-seat__content--price">
                                    <span id="booking-seat__content--ticket-price" class="booking-seat__content--ticket-price">0</span>
                                    <span class="booking-seat__content--ticket-price-icon">$</span>
                                </div>
                            </div>
                            <button name="btn__pay" onclick="" id="booking-seat__btn-pay" class="disabled-tag booking-seat__btn-pay">NEXT</button>
                        </div>
                    </div>
            </div>
            

             <?php // save neccessary $_SESSION
                $_SESSION['film_Name'] = $film_Name; 
                $_SESSION['Date'] = $date; 
                $_SESSION['film_type'] = $film_type; 
                $_SESSION['sht_Time'] = $sht_Time; 
                $_SESSION['sht_ID'] = $sht_ID; 
                $_SESSION['area_Name'] = $area_Name; 
                $_SESSION['cluster_Name'] = $cluster_Name; 
                $_SESSION['room_ID'] = $room_ID; 
                $_SESSION['room_Name'] = $room_Name; 
                $_SESSION['cluster_ID'] = $cluster_ID; 
                $_SESSION['accID'] = $accID; 
            ?>
            
        </form>
    </div>
</body>



<script>

</script>