<?php
    require_once('../connectInMan.php');
    if(!empty($_POST['month']) && !empty($_POST['choice']) && !empty($_POST['room'])){
        
        $month = $_POST['month'];
        $choice = $_POST['choice'];
        $room = $_POST['room'];
        // monthly money
        if($choice == 'monthly_money'){
            $money = sumTicketPriceInMonth($month);
            $price = $money['sumTicket'];
            if($price != ""){
            ?>
                <span class="manage-income__title">Total:</span>
                <span class="manage-income__title"><?php echo strval(number_format(doubleval($price))) ?></span>
                <span class="manage-income__title">$</span>
    
            <?php
            }else{
                ?>
                <span class="manage-income__title">Total:</span>
                <span class="manage-income__title">0</span>
                <span class="manage-income__title">$</span>
    
            <?php
            }
            // monthly ticket
        }else if($choice == 'monthly_ticket'){
            if(!empty(countTicketInMonth($month))){
                $count = countTicketInMonth($month);
                $ticket_Count = $count['ticket_Count'];
                ?>
                    <span class="manage-income__title">Total:</span>
                    <span class="manage-income__title"><?php echo $ticket_Count ?></span>
                    <span class="manage-income__title">tickets in <?= getMonth($month) ?></span>
        
                <?php
            }else{
                ?>
                <span style="color: red;" class="manage-income__title">Please choose "month" !</span>
    
            <?php
            }
            // hot film in month
        }else if($choice == 'film_hot'){
            if($month == 'none'){
                ?>
                <span style="color: red;" class="manage-income__title">Please choose "month" !</span>
    
            <?php
            }
            
            else if(!empty(hotFilmInMonth($month))){
                $dataFilmHot = hotFilmInMonth($month);
                $film = $dataFilmHot['film'];
                $count = $dataFilmHot['film_quan'];
            ?>
                <span class="manage-income__title"><?php echo ucfirst($film) ?></span>
                <span class="manage-income__title">with</span>
                <span class="manage-income__title"><?= $count ?></span>
                <span class="manage-income__title">tickets in month</span>
    
            <?php
            }else{
                ?>
                <span style="color: red;" class="manage-income__title">No data !</span>
    
            <?php
            }
            // booked seat in room in month
        }else if($choice == "seat_book_in_month"){
            if($month == 'none'){
                ?>
                <span style="color: red;" class="manage-income__title">Please choose "month" !</span>
            <?php
            }else if($room == 'none'){
                ?>
                <span style="color: red;" class="manage-income__title">Please choose "room" !</span>
            <?php
            }else if(!empty(seatOfRoomBookedInMonth($room, $month))){
                $dataSeatOfRoom = seatOfRoomBookedInMonth($room, $month);
                $total_seat = $dataSeatOfRoom['total_seats'];
                ?>
                <span class="manage-income__title"><?php echo $total_seat ?></span>
                <span class="manage-income__title">seat(s) in <?= $room ?> is booked in <?= getMonth($month) ?></span>
            <?php
            }else{
                ?>
                <span style="color: red;" class="manage-income__title">No data !</span>
    
            <?php
            }
        }
    }else{
        echo 'helo';
    }
?>