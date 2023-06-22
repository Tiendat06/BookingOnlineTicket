<body>
    

    <div class="bg--outside">

        <form action="/user_account?user=myticket&booking=done" method="post">
        <?php
            // if(!empty($_POST['booking-seat__film-name']) 
            // && !empty($_POST['booking-seat__date']) 
            // && !empty($_POST['booking-seat__film-type']) 
            // && !empty($_POST['booking-seat__sht-Time']) 
            // && !empty($_POST['booking-seat__area-name']) 
            // && !empty($_POST['booking-seat__cluster-name']) 
            // && !empty($_POST['booking-seat__room-id']) 
            // && !empty($_POST['booking-seat__room-name']) 
            // && !empty($_POST['booking-seat__sht-id']) 
            // && !empty($_POST['booking-seat__cluster-id'])
            // && !empty($_POST['booking-seat__acc-id'])){
            $seatIDArray = array();      // ok 
                
            $count_seat_standard = 0;
            $count_seat_vip = 0;
            $count_seat_couple = 0;

            $voucher_input_ID = '';

            $acc_ID = $_SESSION['accID']; // ok
            $film_ID = $_SESSION['filmID']; // ok
            $cluster_ID = $_SESSION['cluster_ID']; // ok

            $film_Name = $_SESSION['film_Name'];
            $date = $_SESSION['Date'];
            $film_type = $_SESSION['film_type']; // ok
            $sht_Time = $_SESSION['sht_Time'];
            $area_Name = $_SESSION['area_Name'];
            $cluster_Name = $_SESSION['cluster_Name'];
            $room_ID = $_SESSION['room_ID'];     // ok
            $room_Name = $_SESSION['room_Name'];

            $sht_ID = $_SESSION['sht_ID'];   //ok


            // $film_ID = $_SESSION['filmID']; // ok
            // $cluster_ID = $_POST['booking-seat__cluster-id']; // ok
            // $acc_ID = $_POST['booking-seat__acc-id']; // ok

            // $film_Name = $_POST['booking-seat__film-name'];
            // $date = $_POST['booking-seat__date'];
            // $film_type = $_POST['booking-seat__film-type']; // ok
            // $sht_Time = $_POST['booking-seat__sht-Time'];
            // $area_Name = $_POST['booking-seat__area-name'];
            // $cluster_Name = $_POST['booking-seat__cluster-name'];
            // $room_ID = $_POST['booking-seat__room-id'];     // ok
            // $room_Name = $_POST['booking-seat__room-name'];

            // $sht_ID = $_POST['booking-seat__sht-id'];   //ok
            // echo $sht_ID;

            // seat_Post_Name = $_POST[$seat_Post_Name];
            $film_type_price = intval(getFilmTypePrice($film_type));


            // get seat then save in $_SESSION
            foreach(getSeatByShtID($sht_ID) as $row){
                $seat_ID = $row['seat_ID'];
                $seat_Post_Name = 'booking-seat-tr__'.$seat_ID;
                
                if(!empty($_POST[$seat_Post_Name])){
                    $_SESSION['booking-seat-pay__'.$seat_ID] = $seat_ID;
            ?>
                <input type="hidden" name="booking-seat-pay__<?= $seat_ID ?>" value="<?= $seat_ID ?>">                
            <?php
                    $seatIDIsChoosing = $_POST[$seat_Post_Name];
                    array_push($seatIDArray, $seatIDIsChoosing);
                }
            }

            // package
            $combo_array = array();
            
            // get seat info, combo then save combo in $_SESSION
            $seat_Number_array = array();
            $seat_Type_array = array();
            $seat_Price_array = array();
            $film_type_price = getFilmTypePrice($film_type);
            foreach($seatIDArray as $seatIDItems){
                // echo $seatIDItems;
                $combo_select_name = 'package__select--'.$seatIDItems;
                
                $combo_Items = $_POST[$combo_select_name];
                $_SESSION['package__select--'.$seatIDItems] = $combo_Items;
            ?>
                <input type="hidden" name="package__select--<?= $seatIDItems ?>" value="<?= $combo_Items ?>">        
            <?php
                array_push($combo_array, $combo_Items);
                // unset($_SESSION['package__select--'.$seatIDItems]);

                foreach(getSeatBySeatIDJoinSeatType($seatIDItems) as $row){
                    $seatNumber = $row['seat_Number'];
                    $seatType = $row['seat_type'];
                    $seatPrice = $row['Price'];
                    if($seatNumber <= 20) $count_seat_standard++;
                    if($seatNumber > 20 && $seatNumber <= 40) $count_seat_vip++;
                    if($seatNumber > 40 && $seatNumber <= 50) $count_seat_couple++;

                    array_push($seat_Number_array, $seatNumber);
                    array_push($seat_Type_array, $seatType);
                    array_push($seat_Price_array, $seatPrice + $film_type_price);
                }
            }

            $count_seat_total = $count_seat_standard + $count_seat_couple + $count_seat_vip;
            if($count_seat_standard >= 3) $voucher_input_ID = 'HAPPY10';
            if($count_seat_couple >= 3) $voucher_input_ID = 'HAPPY20';
            if($count_seat_vip >= 3) $voucher_input_ID = 'HAPPY30';
            if($count_seat_total >= 50) $voucher_input_ID = 'HAPPY50';

            // print_r($package_array);

            $combo_Price_array = array();
            foreach($combo_array as $combo_ID_Items){
                if($combo_ID_Items == 'none'){
                    array_push($combo_Price_array, 0);
                } else{
                    foreach(getAllCombo() as $row){
                        $combo_ID = $row['combo_ID'];
                        $combo_Price = $row['Combo_Price'];
                        if($combo_ID_Items == $combo_ID){
                            array_push($combo_Price_array, $combo_Price);
                        }
                    }
                }
            }

            $totalPrice = array();
            $i = 0;
            foreach($combo_array as $combo_ID_Items){
                array_push($totalPrice, $combo_Price_array[$i] + $seat_Price_array[$i]);
                $i++;
            }

            

            $sumTicketPrice = array_sum($totalPrice);
            $sumVoucherPrice = 0;

    ?>
            <div class="container">
                <div class="row payment-content">
                    <h1 class="payment-title">PAYMENT</h1>
    
                    <!-- ticket -->
                    <table cellspacing="0" class="payment-table">
                        <tbody class="payment-tbody">
                            <tr class="payment-tr payment-tr--th">
                                <th class="payment-th"><p class="payment-th__para">FILM</p></th>
                                <th class="payment-th"><p class="payment-th__para">DATE</p></th>
                                <th class="payment-th"><p class="payment-th__para">FILM TYPE</p></th>
                                <th class="payment-th"><p class="payment-th__para">TIME</p></th>
                                <th class="payment-th"><p class="payment-th__para">AREA</p></th>
                                <th class="payment-th"><p class="payment-th__para">CLUSTER</p></th>
                                <th class="payment-th"><p class="payment-th__para">ROOM</p></th>
                                <th class="payment-th"><p class="payment-th__para">SEAT</p></th>
                                <th class="payment-th"><p class="payment-th__para">SEAT TYPE</p></th>
                                <th class="payment-th"><p class="payment-th__para">COMBO</p></th>
                                <!-- <th class="payment-th"><p class="payment-th__para">SEAT PRICE</p></th> -->
                                <!-- <th class="payment-th"><p class="payment-th__para">FILM TYPE PRICE</p></th> -->
                                <!-- <th class="payment-th"><p class="payment-th__para">COMBO PRICE</p></th> -->
                                <th class="payment-th"><p class="payment-th__para">TICKET PRICE</p></th>
                            </tr>

                            <?php
                            $i = 0;
                            foreach($seatIDArray as $seat){
                            ?>
                            <tr class="payment-tr">
                                <td class="payment-td"><p class="payment-td__para"><?= $film_Name ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $date ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $film_type ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $sht_Time ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $area_Name ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $cluster_Name ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $room_Name ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $seat_Number_array[$i] ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $seat_Type_array[$i] ?></p></td>
                                <td class="payment-td"><p class="payment-td__para"><?= $combo_array[$i] ?></p></td>
                                <!-- <td class="payment-td"><p class="payment-td__para"><= $film_type_price ?></p></td> -->
                                <!-- <td class="payment-td"><p class="payment-td__para"><= $combo_Price_array[$i] ?></p></td> -->
                                <td class="payment-td"><p class="payment-td__para"><?= number_format($totalPrice[$i]) ?></p></td>
                            </tr>
                            <?php
                            $i++;
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- voucher -->
                    <div class="payment-voucher-method">
                        <div class="payment-voucher">
                            <h2 class="payment-voucher__header">VOUCHER</h2>
                            <input readonly placeholder="3 or more same seats type will receive voucher" value="<?= $voucher_input_ID ?>" type="text" name="payment-voucher" class="payment-voucher__inp" id="payment-voucher__inp">
                            
                            <div id="payment-voucher__btn" name="payment-voucher__btn" class="payment-voucher__btn">APPLY</div>
                        </div>
        
                        <!-- payment method -->
                        <div class="payment-method">
                            <h2 class="payment-method__header">PAYMENT METHOD</h2>

                            <label onclick="onClickOrder()" for="payment-method__inp-Momo" class="payment-method__items">
                                <input type="radio" name="payment-method" class="payment-method__inp" id="payment-method__inp-Momo" required>
                                <label for="payment-method__inp-Momo" class="payment-method__label">
                                    <img class="payment-method__img" src="/assets/img/momo_icon.png" alt="" srcset="">
                                    MoMo
                                </label>
                            </label>

                            <label onclick="onClickOrder()" for="payment-method__inp-Zalopay" class="payment-method__items">
                                <input type="radio" name="payment-method" class="payment-method__inp" id="payment-method__inp-Zalopay" required>
                                <label for="payment-method__inp-Zalopay" class="payment-method__label">
                                    <img class="payment-method__img" src="/assets/img/logo-zalopayt22023.jpg" alt="" srcset="">
                                    ZaloPay
                                </label>
                            </label>

                            <label onclick="onClickVNPay()" for="payment-method__inp-VNPay" class="payment-method__items">
                                <input type="radio" name="payment-method" class="payment-method__inp" id="payment-method__inp-VNPay" required>
                                <label for="payment-method__inp-VNPay" class="payment-method__label">
                                    <img class="payment-method__img" src="/assets/img/vnpay-icon.png" alt="" srcset="">
                                    VNPay
                                </label>
                            </label>

                            <!-- <div class="payment-method__btn">
                                <a id="payment-method__vnpay" class="d-none payment-method__vnpay" href="/vnpay_php/">Go to payment</a>
                            </div> -->


                            <p style="text-align: left; font-weight: bold;" id="no-check__para" ></p>
                        </div>
                    </div>

                    <!-- total -->
                    <div class="payment-total-price">
                        <h1 class="payemnt-total-price__header">Price:</h1>
                        <input id="payment-total-price__price" value="<?= $sumTicketPrice ?>" type="hidden" name="">
                        <span class="payment-total-price__price"><?= $sumTicketPrice ?> <span class="payment-total-price__price">$</span> </span>
                    </div>

                    <div class="payment-total-voucher">
                        <h1 class="payemnt-total-voucher__header">Voucher:</h1>
                        <span class="payment-total-voucher__sale"> 
                            <span id="payment-total-voucher__sale" class="payment-total-voucher__sale">0</span> 
                            
                            <span class="payment-total-voucher__sale">%</span> 
                        </span>
                    </div>

                    <div class="payment-total">
                        <h1 class="payemnt-total__header">Total:</h1>
                        <span class="payment-total--price">

                            <span id="payment-total--price" class="payment-total--price"><?= $sumTicketPrice ?></span> 

                            <span class="payment-total--price">$</span> 
                        </span>
                    </div>

                    <p class="d-none col-l-12 col-md-12 col-sm-12" style="color: red;text-align: center; font-weight:bold;" id="function" >Function has not been updated</p>
                    <!-- name="purchase__btn" -->
                    <a id="purchase__btn" onclick="checkClickPaymentMethod()" type="submit" class="payment__btn">PURCHASE</a>

                </div>
            </div>
            
            <input id="ticket-price" type="hidden" value="<?= $sumTicketPrice ?>" name="">
        
            <?php
                // save $_SESSION to use in VNPay 
                $_SESSION['ticket_price'] = $sumTicketPrice;
                $_SESSION['voucher'] = $voucher_input_ID;
            ?>
            <!-- <input type="hidden" name="booking-done" value="done"> -->

        </form>
    </div>

</body>
<?php
    // }else{
    //     header('location: index.php?page=error_1');
    // }
?>

<script>


    onClickAjaxApplyVoucher();
    calPriceAjax();
    
</script>