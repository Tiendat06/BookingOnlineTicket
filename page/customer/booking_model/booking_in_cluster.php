<?php

    require_once('../connectInCus.php');
    session_start();
    $type_Name = $_POST['typeFilm'];
    $date = $_POST['Date'];
    $cluster_ID = $_POST['clusterID'];

    $_SESSION['date'] = $date;
    $_SESSION['film_Type'] = $type_Name;
    $dataClus = getClusterByClusterID($cluster_ID);
    $cluster_photo = $dataClus['cluster_Photo'];
    $cluster_Address = $dataClus['cluster_Address'];
    $cluster_Name = $dataClus['cluster_Name'];
    ?>
    <h1 class="booking-site__choice--cluster-title">Theater <?= $cluster_Name ?></h1>
    <img class="booking-site__choice--cluster-img" src="/assets/img/<?= $cluster_photo ?>" alt="" srcset="">
    <?php
    foreach (getNowShowing($type_Name,$date,$cluster_ID) as $film_row){
        $film_ID = $film_row['film_ID'];
        $film_Name = $film_row['film_Name'];
        $film_Photo = $film_row['film_photo'];
        $film_Trailer = $film_row['film_trailer'];
        $film_Genre = $film_row['film_Genre'];
        $film_Running_time = $film_row['film_Running_time'];
        $film_Release_date = $film_row['film_Release_date'];
?>

        <div class="booking-site__choice--film-items">
            <img class="booking-site__choice--film-img" src= <?php echo"/assets/img/$film_Photo"?> alt="" srcset="">
            <?php
                foreach (getShowtime($film_ID,$cluster_ID,$date,$type_Name) as $showtime_row){
                    $sht_Time = $showtime_row['sht_Time'];
                    $sht_ID = $showtime_row['sht_ID'];
                    $showtime_area_ID = $showtime_row['area_ID'];
                    $showtime_cluster_ID = $showtime_row['cluster_ID'];
                    $showtime_Type = $showtime_row['sht_Type'];
                    $room_ID = $showtime_row['room_ID'];
            ?>
            <div class="booking-site__choice--film-date">
                <a href="/booking_seat?cluster=<?= $cluster_ID ?>&stID=<?= $sht_ID ?>&filmID=<?= $film_ID ?>&area=<?= getAreaIDByClusterID($cluster_ID) ?>" class="booking-site__choice--items">
                    <h1 class="booking-site__choice-items--time-items"><?= $sht_Time?></h1>
                </a>
            </div>
            <?php
                }
            ?>
        </div>
        <?php
    }
    ?>