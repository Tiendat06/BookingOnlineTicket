<?php
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    define('database', 'test');

    function open_Database(){
        $conn = mysqli_connect(host, user,pass,database);
        if (mysqli_error($conn)){
            die(mysqli_error($conn));
        }
        return $conn;
    }
    function checkVoucher($voucher_ID): bool{
        $query = "SELECT * FROM voucher
        where voucher_ID = '$voucher_ID'";

        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if($row){
            return true;
        }
        mysqli_close($conn);
        return false;
    }

    function getVoucherByVoucherID($voucher_ID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from voucher where voucher_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $voucher_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $data;
    }

    // booking_cluster
    function getNowShowing($type_Name, $date, $cluster_ID): array
    {
        if ($type_Name ==  null){
            $query = "SELECT * FROM film WHERE film.film_ID	IN (SELECT film_ID FROM showtime
                                                         where datediff(CURRENT_DATE,showtime.sht_Date) <= 0) 
                                                                AND Datediff(film_Release_date,CURRENT_DATE()) <= 0
                                                                GROUP BY film.film_ID";
        }
        else{
            $query = "Select * from film where film.film_ID in 
                         (select film_ID from showtime where sht_Type like '$type_Name' and sht_Date like '$date' 
                         and room_ID in (select room_ID from room 
                                            where cluster_ID like
                                                  (select cluster_ID from cluster where cluster_ID like '$cluster_ID')))";
        }
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getShowtime($filmID, $clusterID, $date, $type)
    {
        $query = "select *
                     from showtime
                            inner JOIN room
                                on showtime.room_ID like room.room_ID
                            inner JOIN cluster
                                ON room.cluster_ID like cluster.cluster_ID
                            inner join area
                                ON cluster.area_ID like area.area_ID
                    where showtime.film_ID like '$filmID' and cluster.cluster_ID like '$clusterID'
                                    and showtime.sht_Type like '$type' and showtime.sht_Date like '$date'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getAreaIDByClusterID($cluster_ID):string{
        $query = "SELECT * FROM cluster
        where cluster_ID = '$cluster_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }

        mysqli_close($conn);
        return $data[0]['area_ID'];
    }

    function getClusterByClusterID($clusterID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from cluster where cluster_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $clusterID);

        // thực thi
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $data;
    }

    function getCluster_byAreaID($areaID): array
    {
        $query = "select * from cluster where '$areaID' like cluster.area_ID";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    
?>