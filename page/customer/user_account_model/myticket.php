<?php
    $dataCus = getCusByPhone($_SESSION['login_phone']);
?>
<body>
    <form action="" id="myticket__form" method="post">

    <?php

    if($_GET['user'] == 'myticket'){
        // save $_SESSION
        if(isset($_GET['booking'])){
            
            $seatIDArray = array();      // ok

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

            $ticket_price = $_SESSION['ticket_price'];
            $voucher_ID = $_SESSION['voucher'];

            // $acc_ID = $_POST['acc-id'];
            // $cluster_ID = $_POST['cluster-id'];
            // $film_ID = $_POST['film-id'];
            // $film_type = $_POST['film-type'];
            // $sht_ID = $_POST['sht-id'];   //ok
            // $room_ID = $_POST['room-id'] ;
            // $voucher_ID = $_POST['payment-voucher'];
            // echo $voucher_ID;
            // $ticket_price = $_POST['ticket-price'];
            // echo $ticket_price;
            
            // booking-seat-pay__seat01010107
            // check $_SESSION, if have $_SESSION push it to array then unset $_SESSION
            foreach(getSeatByShtID($sht_ID) as $row){
                $seat_ID = $row['seat_ID'];
                $seat_Post_Name = 'booking-seat-pay__'.$seat_ID;

                if(!empty($_SESSION[$seat_Post_Name])){
                    // echo 'hello';
                    $seatIDIsChoosing = $_SESSION[$seat_Post_Name];
                    array_push($seatIDArray, $seatIDIsChoosing);
                    unset($_SESSION[$seat_Post_Name]);
                }
                
            }
            $combo_array = array();

            // get seat info and combo then push it to array and unset $_SESSION
            $seat_Number_array = array();
            $seat_Type_array = array();
            $seat_Price_array = array();
            $film_type_price = getFilmTypePrice($film_type);

            foreach($seatIDArray as $seatIDItems){
                // echo $seatIDItems;
                $package_select_name = 'package__select--'.$seatIDItems;
                // if(!empty($_SESSION[$package_select_name])){
                    $package_Items = $_SESSION[$package_select_name];
                    array_push($combo_array, $package_Items);
                    unset($_SESSION[$package_select_name]);
                // }

                foreach(getSeatBySeatIDJoinSeatType($seatIDItems) as $row){
                    $seatNumber = $row['seat_Number'];
                    $seatType = $row['seat_type'];
                    $seatPrice = $row['Price'];

                    array_push($seat_Number_array, $seatNumber);
                    array_push($seat_Type_array, $seatType);
                    array_push($seat_Price_array, $seatPrice + $film_type_price);

                }
            }
            
            // calculate combo price
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

            // print_r($combo_array);

            // $ticketPrice = $sumTicketPrice;
            // get voucher price
            $voucherPrice = 0;
            if(isset($_SESSION['voucher'])){

                if(checkVoucher($voucher_ID)){
                    $dataVoucher = getVoucherByVoucherID($voucher_ID);
                    $voucherPrice = $dataVoucher['voucher_Discount'];
                }else{
                    $voucher_ID = null;
                }
                
            }else{
                $voucher_ID = null;
            }



            // print_r($seatIDArray);

            // print_r($combo_array);
    
            // insert ticket
            $i = 0;
            foreach($seatIDArray as $seat_ID){
                $totalPrice = floatval($seat_Price_array[$i] - ($voucherPrice * $seat_Price_array[$i] / 100) + $combo_Price_array[$i]);
                insertTicket($acc_ID, $cluster_ID, $film_ID, $film_type, $sht_ID, $seat_ID, $room_ID, $voucher_ID, $totalPrice, $combo_array[$i]);
                updateShowTimeSeat($seat_ID, $sht_ID); 

                $i++;
            }
            // delete $_GET['booking'] to avoid when load page, it this page will be inserted again
            header('location: '.deleteBookingDone());
    
        }else{
            // unset($_SESSION['']);
            // unset($_SESSION['']);
            // unset($_SESSION['']);
            // unset($_SESSION['']);
            // unset($_SESSION['']);
            // unset($_SESSION['']);
            // unset($_SESSION['']);
        }
        ?>
            <h1 class="myticket__title">YOUR TICKET</h1>
            <input style="text-align: center;display: flex; justify-content: center; margin:auto;" placeholder="Search Ticket On All" type="text" name="" id="search-input" class="manage-film__input">

            <table id="table" cellspacing="0" class="myticket__table">
                <tbody class="myticket__tbody">
                    <tr class=" myticket-tr--th">
                        <th class="myticket-th"><p class="myticket-th__para">FILM</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">BOOKING DATE</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">SHOW DATE</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">FILM TYPE</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">TIME</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">AREA</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">CLUSTER</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">ROOM</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">SEAT</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">SEAT TYPE</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">VOUCHER</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">COMBO</p></th>
                        <th class="myticket-th"><p class="myticket-th__para">PRICE</p></th>
                    </tr>

                    <?php
                    $acc_ID = $dataCus['cus_ID'];
                        $i = 0;
                        foreach(getMyTicketTable($acc_ID) as $ticketInfo){
                            $ticket_ID = $ticketInfo['ticket_ID'];
                            $film_Name = $ticketInfo['film_Name'];
                            $date = $ticketInfo['sht_Date'];
                            $date = dayReverse($date);
                            $film_type = $ticketInfo['type_Name'];
                            $sht_Time = $ticketInfo['sht_Time'];
                            $area_Name = $ticketInfo['area_Name'];
                            $cluster_Name = $ticketInfo['cluster_Name'];
                            $room_Name = $ticketInfo['room_Name'];
                            $seat_Number = $ticketInfo['seat_Number'];
                            $seat_Type = $ticketInfo['seat_type'];
                            $voucher_ID = $ticketInfo['voucher_ID'];
                            $booking_date = $ticketInfo['ticket_Date'];
                            $booking_date = dayReverse($booking_date);
                            if($voucher_ID == ''){
                                $voucher_ID = 'x';
                            }
                            $seat_Price = $ticketInfo['ticket_Price'];
                    ?>
                        <tr class="myticket-tr">
                            <td class="myticket-td"><p class="myticket-td__para"><?= $film_Name ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $booking_date ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $date ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $film_type ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $sht_Time ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $area_Name ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $cluster_Name ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $room_Name ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $seat_Number ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $seat_Type ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= $voucher_ID ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= getComboNameByTicketID($ticket_ID) ?></p></td>
                            <td class="myticket-td"><p class="myticket-td__para"><?= number_format($seat_Price) ?></p></td>
                            
                        </tr>
                    <?php
                        $i++;
                        }
                    ?>
                </tbody>
            </table>  
        <?php
    }else{
        header('location: index.php?page=error_1');
    }

    ?>
    </form>
</body>

<script>
    searchFilm()
</script>
