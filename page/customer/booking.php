<?php
    // if(isset($_GET['filmID'])){
    //     $film_ID = $_GET['filmID'];
    // }
?>
<script>
    <?php
        if($_GET['page'] == 'describe'){
    ?>
        ajaxInBookingTicket();    
    <?php
        }else if($_GET['page'] == 'clusters'){
    ?>
        ajaxInBookingTicketInCluster();
    <?php
        }
    ?>
</script>
<body>
    <div id="booking-ticket" class="booking-ticket d-none">
        <div class="row booking-site">
            <?php
            // page = describe, show input:hidden
                if($_GET['page'] == 'describe'){
            ?>

                <input type="hidden" id="filmID" name="" value="<?= $film_ID ?>">
            <?php
                }
            ?>
            <!-- Choose area, FILM TYPE -->
            <div class="booking-site__choice <?php if($_GET['page'] == 'clusters') echo "booking-site__choice--clusters" ?> col-l-11 col-md-11 col-sm-11">
                
            <?php
                if($_GET['page'] == 'describe'){
            ?>
                <div class="booking-site__choice--header">
                    <p class="booking-site__choice--para">AREA</p>
                </div>
                <select class="booking-site__choice--area" name="booking-site__choice--area" id="booking-site__choice--area">
                    <?php
                        foreach (getAll_Area() as $row){
                            $area_ID = $row['area_ID'];
                            $area_Name = $row['area_Name']
                    ?>
                        <option id="booking-site__choice--<?= $area_ID ?>" class="booking-site__choice--area-option" value="<?= $area_ID ?>">
                            <?= $area_Name ?>
                        </option>
                    <?php
                        }
                    ?>
                </select>
            <?php
                }
            ?>

                <!-- Choose film type -->
                <div class="booking-site__choice--header <?php if($_GET['page'] == 'clusters') echo 'booking-site__choice--header-clusters' ?>">
                    <p class="booking-site__choice--para">FILM TYPE</p>
                </div>
                <?php
                    if($_GET['page'] == 'describe'){
                ?>
                    <select class="booking-site__choice--type" name="booking-site__choice--type" id="booking-site__choice--type">
                        <?php
                            foreach(getAllFilmTypeByFilmID($film_ID) as $row){
                        ?>
                            <option id="booking-site__choice--<?= $row['type_Name'] ?>" class="booking-site__choice--type-option" value="<?= $row['type_Name'] ?>"><?= $row['type_Name'] ?></option>
                        <?php
    
                            }
                        ?>
                    </select>
       
                <?php
                    } else if($_GET['page'] == 'clusters'){
                ?>
                    <select class="booking-site__choice--type booking-site__choice--type-clusters" name="booking-site__choice--type" id="booking-site__choice--type">

                    <?php
                        foreach(getAllFilmType() as $row){
                    ?>
                        <option id="booking-site__choice--<?= $row['type_Name'] ?>" class="booking-site__choice--type-option" value="<?= $row['type_Name'] ?>"><?= $row['type_Name'] ?></option>

                    <?php
                        }
                    ?>

                    </select>
                    
                <?php
                    }
                ?>
                
            </div>
            
            <!-- Choose date -->
            <div class="booking-site__choice booking-site__choice--date col-l-11 col-md-11 col-sm-11">
                <select name="booking-site__choice--date-select" id="booking-site__choice--date-select" class="booking-site__choice--date-select">
                <!-- <option value="" class="booking-site__choice--day">DAY</option>                 -->
                    <?php  
                    for($i = 0; $i < 31; $i++){
                        $date = date("d-m-Y", strtotime("+$i day"));       
                        $dateVal = date("Y-m-d", strtotime("+$i day"));       
                    ?>
                        <option value="<?= $dateVal ?>" class="booking-site__choice--day"><?= $date ?></option>   

                    <?php
                    }
                    ?>
                </select>
            </div>

            <!-- button -->
            <?php
                if($_GET['page'] == 'describe'){
            ?>
                <button onclick="onClickToReset()" id="booking-site__btn--choose-area-reset" class="booking-site__btn col-l-2 col-md-2 col-sm-2" type="reset">RESET</button>
                <button name="btn_seacrh" onclick="onClickToSearch()" id="booking-site__btn--choose-search" class="booking-site__btn col-l-2 col-md-2 col-sm-2" type="submit">SEARCH</button>
            <?php
                }else if($_GET['page'] == 'clusters'){
            ?>
                <!-- reset btn -->
                <button onclick="onClickToResetInCluster()" id="booking-site__btn--choose-area-reset" class="booking-site__btn col-l-2 col-md-2 col-sm-2" type="reset">RESET</button>
                <!-- search btn -->
                <button name="btn_seacrh" onclick="onClickToSearchInCluster()" id="booking-site__btn--choose-search" class="booking-site__btn col-l-2 col-md-2 col-sm-2" type="submit">SEARCH</button>            

            <?php
                }
            ?>

            <?php
                if($_GET['page'] == 'describe'){
            ?>
                    <!-- Choose cluster -->
                <div id="booking-site__choice--cluster" class="booking-site__choice booking-site__choice--film d-none col-l-11 col-md-11 col-sm-11">
                    <!-- ajax here for describe -->
                </div>

                <?php
                } else if($_GET['page'] == 'clusters'){
                ?>
                    <div id="booking-site__choice--film" class="booking-site__choice booking-site__choice--film d-none col-l-11 col-md-11 col-sm-11">
                    <!-- ajax for clusters -->
                    </div>
                <?php
                    }
                ?>
        
        </div>
    </div>
</body>