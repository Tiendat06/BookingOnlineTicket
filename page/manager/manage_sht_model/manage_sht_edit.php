<body>
    <?php
        if(isset($_GET['shtID'])){
            $shtID = $_GET['shtID'];
            $_SESSION['shtID'] = $shtID;
            header('location: '.deleteOneURL('shtID'));
        }
        else{
            $shtID = $_SESSION['shtID'];
            // echo $shtID;
        }
        $dataSht = getShowTimeByShowTimeID($shtID);

        $filmID = $dataSht['film_ID'];
        $dataFilm = getFilmByFilmID($filmID);
        $filmName = $dataFilm['film_Name'];

        $room_ID = $dataSht['room_ID'];
        $dataCluster = getClusterByRoomID($shtID, $room_ID, $filmID);
        $cluster_Name = $dataCluster[0]['cluster_Name'];

        $sht_Type = $dataSht['sht_Type'];

        $sht_Date = $dataSht['sht_Date'];
        $sht_Time = $dataSht['sht_Time'];
        $sht_End = $dataSht['sht_Time_end'];

    ?>
        <form action="" method="post" enctype="multipart/form-data">
        <div class="manage-film__edit--content">
        <input type="hidden" name="sht_id" id="sht_id" value="<?= $shtID ?>">
            <h1 class="manage-film__edit-title">EDIT SHOWTIME</h1>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Film</p>

                <select class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="film_id" name="film_id">
                    
                    <option title="" value="<?= $filmID ?>" class="manage-film__option--add-room"><?php echo $filmID." - ".$filmName ?></option>
                    <?php
                        foreach(getAllFilm() as $row){
                            $film_ID = $row['film_ID'];
                            $film_Name = $row['film_Name'];
                            if($film_ID == $filmID){
                                continue;
                            }else{
                                ?>
                                    <option title="<?php ?>" value="<?= $film_ID ?>" class="manage-film__option--add-room"><?php echo $film_ID." - ".$film_Name ?></option>
                    
                                <?php
                            }
                        }
                    ?>
                </select>
                
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Room</p>
                <select class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="room_id" name="room_id">
                    <option title="<?php echo $room_ID." - ".$cluster_Name." (". $cluster_Address.")" ?>" value="<?= $room_ID ?>" class="manage-film__option--add-room"><?php echo $room_ID." - ".$cluster_Name ?></option>
                    
                </select>
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Type</p>
                <select class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" name="sht_type" id="sht_type">
                    <option value="<?= $sht_Type ?>" class="manage-film__option--add-type"><?= $sht_Type ?></option>
                    
                </select>
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Date</p>
                <input value="<?= $sht_Date ?>" style="text-align: center;" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="date" id="" name="sht_date">
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Time Start</p>
                <input value="<?= $sht_Time ?>" style="text-align: center;" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="time" id="" name="sht_start">
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Time End</p>
                <input value="<?= $sht_End ?>" style="text-align: center;" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="time" id="" name="sht_end">
            </div>

            <?php
                if(isset($_POST['edit-sht_btn'])){
                    if(!empty($_POST['film_id']) && !empty($_POST['room_id'])
                    && !empty($_POST['sht_type']) && !empty($_POST['sht_date'])
                    && !empty($_POST['sht_start']) && !empty($_POST['sht_end'])){

                        $film_ID = $_POST['film_id'];
                        $room_ID = $_POST['room_id'];
                        $sht_type = $_POST['sht_type'];
                        $sht_date = $_POST['sht_date'];
                        $sht_start = $_POST['sht_start'];
                        $sht_end = $_POST['sht_end'];
                        updateShowTime($shtID, $film_ID, $room_ID, $sht_type, $sht_date, $sht_start, $sht_end);
                        echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Edit Successfully</p>";

                    }else{
                        echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Please enter full informations</p>";

                    }
                }
            ?>

            
            <button name="edit-sht_btn" class="manage-film__edit--btn">EDIT</button>
        </div>
        
    </form>

</body>

<script>
    
    onClickChangeRoomAjaxFirst();
    onClickChangeRoomAjaxChange();
    onClickChangeTypeAjaxFirst();
    onClickChangeTypeAjaxChange();
</script>