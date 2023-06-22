<?php
    require_once('../connectInMan.php');

    if(!empty($_POST['film_ID']) && !empty($_POST['shtID'])){
        // $sht_ID = $_POST['shtID'];
        // $dataSht = getShowTimeByShowTimeID($sht_ID);
        // $roomID = $dataSht['room_ID'];
        $film_ID = $_POST['film_ID'];
        foreach(getRoomAndCluster($film_ID) as $row){
            $room_ID = $row['room_ID'];
            $cluster_Name = $row['cluster_Name'];
            $cluster_Address = $row['cluster_Address'];
            
            ?>
                <option title="<?php echo $room_ID." - ".$cluster_Name." (". $cluster_Address.")" ?>" value="<?= $room_ID ?>" class="manage-film__option--add-room"><?php echo $room_ID." - ".$cluster_Name ?></option>

            <?php
            
        }
    }
?>