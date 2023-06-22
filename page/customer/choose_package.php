<body>
    <div class="bg--outside">
        <form action="/payment_page" method="post">
        <?php
            $seatIDArray = array();      // ok 
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

                // $_SESSION['film_Name'] = $film_Name; 
                // $_SESSION['Date'] = $date; 
                // $_SESSION['film_type'] = $film_type; 
                // $_SESSION['sht_Time'] = $sht_Time; 
                // $_SESSION['sht_ID'] = $sht_ID; 
                // $_SESSION['area_Name'] = $area_Name; 
                // $_SESSION['cluster_Name'] = $cluster_Name; 
                // $_SESSION['room_ID'] = $room_ID; 
                // $_SESSION['room_Name'] = $room_Name; 
                // $_SESSION['cluster_ID'] = $cluster_ID; 
                // $_SESSION['accID'] = $accID; 

            //get $_SESSION
            $film_ID = $_SESSION['filmID']; // ok
            $cluster_ID = $_SESSION['cluster_ID']; // ok
            $acc_ID = $_SESSION['accID']; // ok

            $film_Name = $_SESSION['film_Name'];
            $date = $_SESSION['Date'];
            $film_type = $_SESSION['film_type']; // ok
            $sht_Time = $_SESSION['sht_Time'];
            $area_Name = $_SESSION['area_Name'];
            $cluster_Name = $_SESSION['cluster_Name'];
            $room_ID = $_SESSION['room_ID'];     // ok
            $room_Name = $_SESSION['room_Name'];

            $sht_ID = $_SESSION['sht_ID'];   //ok

            // seat_Post_Name = $_POST[$seat_Post_Name];

            // create input:hidden with value = seat_ID while $_POST[$seat_Post_Name] is not empty then push it to array, $seat_Post_Name is created in boking_seat.php
            foreach(getSeatByShtID($sht_ID) as $row){
                $seat_ID = $row['seat_ID'];
                $seat_Post_Name = 'booking-seat-tr__'.$seat_ID;
                if(!empty($_POST[$seat_Post_Name])){
            ?>
                <input type="hidden" name="booking-seat-tr__<?= $seat_ID ?>" value="<?= $seat_ID ?>">                
            <?php
                    $seatIDIsChoosing = $_POST[$seat_Post_Name];
                    array_push($seatIDArray, $seatIDIsChoosing);
                }

            }

            // print_r($seatIDArray);
            // get seat informartions then save it to array
            $seat_Number_array = array();
            $seat_Type_array = array();
            $seat_Price_array = array();
            $film_type_price = getFilmTypePrice($film_type);
            foreach($seatIDArray as $seatIDItems){
                // echo $seatIDItems;
                foreach(getSeatBySeatIDJoinSeatType($seatIDItems) as $row){
                    $seatNumber = $row['seat_Number'];
                    $seatType = $row['seat_type'];
                    $seatPrice = $row['Price'];

                    array_push($seat_Number_array, $seatNumber);
                    array_push($seat_Type_array, $seatType);
                    array_push($seat_Price_array, $seatPrice + $film_type_price);

                }
            }
            // calculate ticket price
            $sumTicketPrice = array_sum($seat_Price_array);
            $sumVoucherPrice = 0;

    ?>
            <div class="container package__container">
                <div class="row package__content">
                    <!-- title -->
                    <h1 class="package__title">CHOOSE PACKAGE</h1>

                    <div class="package__list">

                        <?php
                            foreach(getAllCombo() as $row){
                                $combo_ID = $row['combo_ID'];
                                $combo_Name = $row['combo_Name'];
                                $combo_Describe = $row['combo_Description'];
                                $combo_Price = $row['Combo_Price'];
                                $combo_photo = $row['combo_Photo'];
                        ?>
                            <div title="<?= $combo_Describe ?>" class="package__items col-l-2-4 col-md-2-4 col-sm-6">
                                <img class="package__items--img" src="/assets/img/<?= $combo_photo ?>" alt="" srcset="">
                                <p class="package__items--about"><?= $combo_Name ?></p>
                                <p class="package__items--describe"><?= $combo_Describe ?></p>
                                <div class="package__items--price-list">
                                    <p class="package__items--price-header"><?= $combo_ID ?></p>
                                    <p class="package__items--price"><?= number_format($combo_Price) ?>$</p>
                                </div>
                            </div>

                        <?php
                            }
                        ?>
                    </div>
                    <!-- ticket info -->
                    <table cellspacing="0" class="package__table">
                        <tbody class="package__tbody">
                            <tr class="package__tr">
                                <th class="package__th"> <p class="package__th--para">FILM</p> </th>
                                <th class="package__th"> <p class="package__th--para">FILM TYPE</p> </th>
                                <th class="package__th"> <p class="package__th--para">TIME</p> </th>
                                <th class="package__th"> <p class="package__th--para">DATE</p> </th>
                                <th class="package__th"> <p class="package__th--para">AREA</p> </th>
                                <th class="package__th"> <p class="package__th--para">CLUSTER</p> </th>
                                <th class="package__th"> <p class="package__th--para">ROOM</p> </th>
                                <th class="package__th"> <p class="package__th--para">SEAT</p> </th>
                                <th class="package__th"> <p class="package__th--para">SEAT TYPE</p> </th>
                                <!-- <th class="package__th"> <p class="package__th--para">FILM TYPE PRICE</p> </th> -->
                                <th class="package__th"> <p class="package__th--para">PRICE</p> </th>
                                <th class="package__th"> <p class="package__th--para">PACKAGE</p> </th>
                            </tr>

                            <?php
                            $i = 0;
                            foreach($seatIDArray as $seat){
                            ?>
                            <tr class="package__tr">
                                <td class="package__td"><p class="package__td--para"><?= $film_Name ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $date ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $film_type ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $sht_Time ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $area_Name ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $cluster_Name ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $room_Name ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $seat_Number_array[$i] ?></p></td>
                                <td class="package__td"><p class="package__td--para"><?= $seat_Type_array[$i] ?></p></td>
                                <!-- <td class="package__td"><p class="package__td--para"><= $film_type_price ?></p></td> -->
                                <td class="package__td"><p class="package__td--para"><?= number_format($seat_Price_array[$i]) ?></p></td>
                                <td class="package__td">
                                    <!-- <p class="package__td--para"><= $seat_Price_array[$i] ?></p> -->
                                    <select name="package__select--<?= $seat ?>" id="package__select--<?= $seat ?>" class="package__select">
                                        <option value="none" class="package__option">none</option>
                                        <?php
                                            foreach(getAllCombo() as $row){
                                                $combo_ID = $row['combo_ID'];
                                                $combo_Name = $row['combo_Name'];
                                                $combo_Describe = $row['combo_Description'];
                                                $combo_Price = $row['Combo_Price'];
                                                $combo_photo = $row['combo_Photo'];
                                        ?>

                                            <option value="<?= $combo_ID ?>" class="package__option"><?= $combo_ID ?></option>
                                        <?php
                                            }
                                        ?>
                                        <!-- <option value="Combo2" class="package__option">Combo 2</option>
                                        <option value="Combo3" class="package__option">Combo 3</option>
                                        <option value="Combo4" class="package__option">Combo 4</option> -->
                                        
                                    </select>
                                </td>
                            </tr>
                            <?php
                            $i++;
                            }
                            ?>

                        </tbody>
                    </table>

                    <button class="package__btn" type="submit">NEXT</button>
                </div>
            </div>

            

            <?php
            
            ?>
        </form>
    </div>
</body>
<?php
    // }
?>