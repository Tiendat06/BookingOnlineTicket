<!-- <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head> -->

<?php
    require_once('../connectInCus.php');
    session_start();
    $count = 0;
    $film_ID = $_POST['filmID'];
    $area_ID = $_POST['areaID'];
    $type = $_POST['typeFilm'];
    $date = $_POST['Date'];

    $_SESSION['filmID'] = $film_ID;
    $_SESSION['area_ID'] = $area_ID;
    $_SESSION['film_Type'] = $type;
    $_SESSION['date'] = $date;
    #$filmID?
    foreach (getCluster_byAreaID($area_ID) as $row){
        $cluster_ID = $row['cluster_ID'];
        $cluster_Name = $row['cluster_Name'];
        $_SESSION[$cluster_Name ."_" . $area_ID] = $cluster_ID;
        // $area_ID = $row['area_ID'];
        // $area_Name = $row['area_Name'];
?>
    <div class="booking-site__choice--header booking-site__choice--header-film">
        <p class="booking-site__choice--para"><?= $cluster_Name ?></p>
    </div>
    <?php
        foreach (getShowtime($film_ID, $cluster_ID, $date, $type) as $data){
            $sht_Time = $data['sht_Time'];
            $sht_ID = $data['sht_ID'];
            $showtime_area_ID = $data['area_ID'];
            $showtime_cluster_ID = $data['cluster_ID'];
            $showtime_Type = $data['sht_Type'];
            $room_ID = $data['room_ID'];
            // $sht_Time_end = $row['sht_Time_end'];
            ?>
            <a href="?page=booking_seat&cluster=<?= $cluster_ID ?>&stID=<?= $sht_ID ?>" class="booking-site__choice--items">
                <div class="booking-site__choice-items--date">
                    <input type="hidden" value="<?= $sht_ID ?>" id="booking_ticket--shtID" name="">
                    <input type="hidden" value="<?= $room_ID ?>" id="booking_ticket--roomID" name="">
                    <input type="hidden" value="<?= $sht_Time ?>" id="booking_ticket--shtTime" name="">
                    <h1 class="booking-site__choice-items--time-items"><?=$sht_Time?></h1>
                </div>
            </a>
    <?php
        }
    ?>
<?php
    session_write_close();
    }
?>



