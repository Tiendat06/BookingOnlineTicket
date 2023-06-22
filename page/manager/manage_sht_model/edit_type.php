<?php
    require_once('../connectInMan.php');

    if(!empty($_POST['film_ID']) && !empty($_POST['shtID'])){
        // $sht_ID = $_POST['shtID'];
        // $dataSht = getShowTimeByShowTimeID($sht_ID);
        // $sht_type = $dataSht['sht_Type'];
        $film_ID = $_POST['film_ID'];
        foreach(getFilmeTypeByFilmId($film_ID) as $row){
            $film_type = $row['type_Name'];
            // if($film_type == $sht_type){
            //     continue;
            // }else{
            ?>
                <option value="<?= $film_type ?>" class="manage-film__option--add-type"><?= $film_type ?></option>
                
            <?php

            // }
        }
    }
?>