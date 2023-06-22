<body>

<div class="manage-user">
        <!-- <form onsubmit="" action="" method="post"> -->

            <h1 class="manage-film__title manage-user__title">MANAGE SHOWTIME</h1>

            <input placeholder="Search Showtime On All" type="text" name="" id="search-input" class="manage-film__input">

            <table id="table" class="manage-user__table">
                <tbody id="tbody" class="manage-film__tbody manage-user__tbody">
                    <tr class="manage-film__tr-main manage-user__tr">
                        <th class="manage-film__th manage-user__th">Showtime ID</th>
                        <th class="manage-film__th manage-user__th">Film ID</th>
                        <th class="manage-film__th manage-user__th">Room ID</th>
                        <th class="manage-film__th manage-user__th">Showtime Type</th>
                        <th class="manage-film__th manage-user__th">Showtime Date</th>
                        <th class="manage-film__th manage-user__th">Showtime Start</th>
                        <th class="manage-film__th manage-user__th">Showtime End</th>
                        <th class="manage-film__th manage-user__th">Edit</th>
                        <th class="manage-film__th manage-user__th">Delete</th>
                    </tr>
    
                    <?php
                        foreach (getAllShowTime() as $row){
                            $sht_ID = $row['sht_ID'];
                            $film_ID = $row['film_ID'];
                            $room_ID = $row['room_ID'];
                            $sht_Type = $row['sht_Type'];
                            $sht_Date = $row['sht_Date'];
                            $sht_Time = $row['sht_Time'];
                            $sht_End = $row['sht_Time_end'];
                            

                    ?>
                        <tr id="manage-film__tr" class="manage-film__tr">

                            <td title="<?= $sht_ID ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $sht_ID ?></p>
                            </td>
                            
                            <td title="<?= $film_ID ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $film_ID ?></p>
                            </td>

                            <td title="<?= $room_ID ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $room_ID ?></p>
                            </td>

                            <td title="<?= $sht_Type ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $sht_Type ?></p>
                            </td>

                            <td title="<?= dayReverse($sht_Date) ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= dayReverse($sht_Date) ?></p>
                            </td>

                            <td title="<?= $sht_Time ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $sht_Time ?></p>
                            </td>

                            <td title="<?= $sht_End ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $sht_End ?></p>
                            </td>

                            <td class="manage-user__td">
                                <a href="?page=manage_sht_edit&shtID=<?= $sht_ID ?>" id="" class="manage-user__btn">
                                    <i class="manage-user__icon fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>

                            <td id="" class="manage-user__td">
                                <!-- onClickDelete(this.id) -->
                                <div onclick="onClickDeleteShowtime(this.id)" id="<?= $sht_ID ?>" class="manage-user__btn">
                                    <i class="manage-user__icon fa-solid fa-trash"></i>
                                </div>
                            </td>
                        </tr>                   
                    <?php
                        }
                        
                    ?>
                    <input type="hidden" id="manage-lock-btn" name="manage-lock-btn" value="">
                </tbody>

                <div onclick="onClickModal(this.id)" id="modal" class="modal d-none"></div>
                <!-- delete response -->
                <div id="delete-res" class="delete-res d-none">
                    <h1 id="delete-res__title" class="delete-res__title"></h1>
                    <div class="delete-res__site">
                        <a id="delete-res__link" class="delete-res__items" href="">Yes</a>
                        <a class="delete-res__items" href="?page=manage_showtime">No</a>
                    </div>
                </div>
            </table>

    </div>
  
</body>

<script>
    searchFilm()
</script>








