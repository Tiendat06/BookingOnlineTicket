<body>
<div class="manage-user">
        <!-- <form onsubmit="" action="" method="post"> -->

        <h1 class="manage-user__title">MANAGE INCOME</h1>

        <input placeholder="Search Ticket On All" type="text" name="" id="search-input" class="manage-income__search manage-film__input">

        <div class="manage-income__navbar">
    
            <div class="manage-income__date">
                <div class="manage-income__select--choice">

                    <select class="manage-income__select" name="select-room" id="select-room">
                        <option value="none">Room</option>
                        <?php
                            foreach(getAllRoom() as $row){
                                $room_ID = $row['room_ID'];
                                ?>
                                    <option value="<?= $room_ID ?>"><?= $room_ID ?></option>
                                
                                <?php
                            }
                        ?>
                    </select>
    
                    <select class="manage-income__select" name="select-choice" id="select-choice">
                        <option value="none">Feature Choice</option>
                        <option value="monthly_ticket">
                            Monthly ticket
                        </option>
                        <option value="monthly_money">
                            Calculate money in month
                        </option>
                        <option value="seat_book_in_month">
                            Room's seat booked in month
                        </option>
                        <option value="film_hot">
                            Film hot in month
                        </option>
                    </select>
                    
                    <select class="manage-income__select" name="select-date" id="select-date">
                        <option value="none">Month</option>
                        <?php
                            for($i = 1; $i <= 12; $i++){
                                ?>
                                <option value="<?= $i ?>">
                                    <?= getMonth($i) ?>
                                </option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <button id="manage-income__btn" class="manage-income__btn">Calculate</button>
                <div id="manage-income__result" class="manage-income__result">
                    
                </div>
            </div>
        </div>

        <table id="table" class="manage-user__table">
            <tbody class="manage-user__tbody">
                <tr class="manage-user__tr">
                    <th class="manage-user__th">Ticket ID</th>
                    <th class="manage-user__th">Account ID</th>
                    <th class="manage-user__th">Cluster ID</th>
                    <!-- <th class="manage-user__th">Cus_Password</th> -->
                    <th class="manage-user__th">Film ID</th>
                    <th class="manage-user__th">File Type</th>
                    <th class="manage-user__th">Showtime ID</th>
                    <th class="manage-user__th">Seat ID</th>
                    <th class="manage-user__th">Room ID</th>
                    <!-- <th class="manage-user__th">Reset Password</th> -->
                    <!-- <th class="manage-user__th">Edit</th> -->
                    <th class="manage-user__th">Voucher</th>
                    <th class="manage-user__th">Package</th>
                    <th class="manage-user__th">Ticket Price</th>
                    <th class="manage-user__th">Purchase Date</th>
                    <!-- <th class="manage-user__th">Reset Password</th> -->
                </tr>

                <?php
                    foreach (getAllTicket() as $row){
                        $ticket_ID = $row['ticket_ID'];
                        $acc_ID = $row['acc_ID'];
                        $cluster_ID = $row['cluster_ID'];
                        $film_ID = $row['film_ID'];
                        $type_Name = $row['type_Name'];
                        $sht_ID = $row['sht_ID'];
                        $seat_ID = $row['seat_ID'];
                        $room_ID = $row['room_ID'];
                        $voucher_ID = $row['voucher_ID'];
                        $ticket_Price = $row['ticket_Price'];
                        $ticket_Date = $row['ticket_Date'];
                ?>
                    <tr class="manage-film__tr">
                        <td class="manage-user__td"><?= $ticket_ID ?></td>
                        <td class="manage-user__td"><?= $acc_ID ?></td>
                        <td class="manage-user__td"><?= $cluster_ID ?></td>
                        <td class="manage-user__td"><?= $film_ID ?></td>
                        <td class="manage-user__td"><?= $type_Name ?></td>
                        <td class="manage-user__td"><?= $sht_ID ?></td>
                        <td class="manage-user__td"><?= $seat_ID ?></td>
                        <td class="manage-user__td"><?= $room_ID ?></td>
                        <td class="manage-user__td"><?= $voucher_ID ?></td>
                        <td class="manage-user__td"><?= getComboNameByTicketID($ticket_ID) ?></td>
                        <td class="manage-user__td"><?= $ticket_Price ?></td>
                        <td class="manage-user__td"><?= dayReverse($ticket_Date) ?></td>

                    </tr>                   
                <?php
                    }
                    
                ?>
                <input type="hidden" id="manage-lock-btn" name="manage-lock-btn" value="">
            </tbody>
        </table>
</body>
<script>
    function onClickIncomeMonthly(){
        $().ready(()=>{
        $('#manage-income__btn').click(()=>{
            $.ajax({
                url: '/page/manager/manage_income_model/manage_income_monthly.php',
                type: 'post',
                data: {
                    choice: $('#select-choice').val(),
                    month: $('#select-date').val(),
                    room: $('#select-room').val(),
                },
                
            }).done( function(result){
                $('#manage-income__result').html(result);
            })
        })
    })
    }
    
    onClickIncomeMonthly();

    searchFilm()
</script>