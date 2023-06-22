<?php
    if(isset($_GET['filmID'])){
        $filmID = $_GET['filmID'];
        $_SESSION['filmID'] = $filmID;
        header('location: '.deleteFilmID());
    }
    else{
        $filmID = $_SESSION['filmID'];

        $dataFilm = getFilmByFilmID($filmID);

        $film_Name = $dataFilm['film_Name'];
    }
?>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="manage-film__edit--content">

            <h1 class="manage-film__edit-title">ADD SHOWTIME</h1>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Film</p>
                <input style="text-align:center;" readonly class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" value="<?= $film_Name ?>" name="film_name">
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Room</p>
                <select class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="room_id">
                    <?php
                        foreach(getRoomAndCluster($filmID) as $row){
                            $room_ID = $row['room_ID'];
                            $cluster_Name = $row['cluster_Name'];
                            $cluster_Address = $row['cluster_Address'];
                            ?>
                                <option title="<?php echo $room_ID." - ".$cluster_Name." (". $cluster_Address.")" ?>" value="<?= $room_ID ?>" class="manage-film__option--add-room"><?php echo $room_ID." - ".$cluster_Name ?></option>
                
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Type</p>
                <select class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" name="sht_type" id="">
                    <?php
                        foreach(getFilmeTypeByFilmId($filmID) as $row){
                            $film_type = $row['type_Name'];
                            ?>
                                <option value="<?= $film_type ?>" class="manage-film__option--add-type"><?= $film_type ?></option>
                                
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Date</p>
                <input style="text-align: center;" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="date" id="" name="sht_date">
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Time Start</p>
                <input style="text-align: center;" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="time" id="" name="sht_start">
            </div>

            <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Showtime Time End</p>
                <input style="text-align: center;" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="time" id="" name="sht_end">
            </div>

            <?php
                if(isset($_POST['add-sht_btn'])){
                    if(!empty($_POST['film_name']) && !empty($_POST['room_id']) 
                    && !empty($_POST['sht_type']) && !empty($_POST['sht_date']) 
                    && !empty($_POST['sht_start']) && !empty($_POST['sht_end'])){
                        $room_id = $_POST['room_id'];
                        $sht_type = $_POST['sht_type'];
                        $sht_date = $_POST['sht_date'];
                        $sht_start = $_POST['sht_start'];
                        $sht_end = $_POST['sht_end'];
                        addShowtime($filmID, $room_id, $sht_type, $sht_date, $sht_start, $sht_end);
                        echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Add Successfully</p>";

                    }else{
                        echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Please enter full informations</p>";

                    }
                }
            ?>
            <button name="add-sht_btn" class="manage-film__edit--btn">ADD</button>
        </div>
        
    </form>
</body>