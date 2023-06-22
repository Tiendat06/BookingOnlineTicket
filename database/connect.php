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

    function createCustomer($name, $email, $phone, $address, $dob, $sex ,$password){
        #Kiểm tra đã có customer nào chưa
        $query = "select count(*) from customer";
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $id ='';
        //Nếu chưa có customer nào
        if ($row[0] < 1){
            $id = 'cus00001';
        }
        ///Đã có customer
        else{
            $query = "select max(cus_ID) from customer";

            $result = mysqli_query($conn, $query);

            $row = mysqli_fetch_row($result);

            #Set ID

            $prev_id = substr($row[0],3,7); #Lấy ra ID lớn nhất

            $stt = (int)$prev_id + 1; # tạo ra ID mới

            if ($stt < 10){
                $id = 'cus0000'.$stt;
            }
            else if ($stt < 100){
                $id = 'cus000'.$stt;
            }
            else if ($stt < 1000){
                $id = 'cus00'.$stt;
            }
            else if ($stt < 10000){
                $id = 'cus0'.$stt;
            }
            else if ($stt < 100000){
                $id = 'cus'.$stt;
            }
        }

        $query = "INSERT INTO customer VALUES('$id','$name','$email','$phone','$address','$dob','$sex')";
        mysqli_query($conn,$query);

        $query = "INSERT INTO account VALUES('$id','$phone','$password','Active', null)";
        mysqli_query($conn,$query);

        mysqli_close($conn);
    }
    //createCustomer(null, null, null, null, null, null, null);
    function checkDuplicateEmail($sign_up_email): bool
    {
        $conn = open_Database();
        $query = "select * from customer where cus_Email = '$sign_up_email'";
        $result = mysqli_query($conn, $query );

        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        if ($row){
            return true;
        }
        return false;
    }
    function checkDuplicatePhone($sign_up_phone): bool
    {
        $conn = open_Database();
        $query = "select * from customer where cus_Phone_number = '$sign_up_phone'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        if ($row){
            return true;
        }
        return false;
    }

    function checkLogin($phone, $password): bool
    {
        $conn = open_Database();
        //Kiểm tra có tồn tại phone và pass?
        $query = "Select acc_Username, acc_Password from account 
                                  WHERE acc_Username like ? and acc_Password LIKE ? ";

        $stm = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stm,'ss',$phone, $password);

        mysqli_stmt_execute($stm);

        $result = mysqli_stmt_get_result($stm);

        $row = mysqli_fetch_row($result);
        //Nếu có tài khoản thì true
        mysqli_close($conn);
        if ($row){
            return true;
        }
        return false;
    }

    function getAll_Area(): array
    {
        $query = "select * from area";
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        $data = array();
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }
    function getAll_Cluster(): array
    {
        $query = "select * from cluster";
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        $data = array();
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }
    function getName($phone): string
    {
        $conn = open_Database();
        $query = "SELECT cus_Name as 'Name'  FROM customer where '$phone' like cus_Phone_number";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        //In hoa
        $Name = mb_strtoupper($row['Name'], 'UTF-8');
        mysqli_close($conn);
        return $Name;
    }
    function getNowShowing($type_Name, $date, $cluster_ID): array
    {
        if ($type_Name ==  null){
            $query = "SELECT * FROM film WHERE film.film_ID	IN (SELECT film_ID FROM showtime
                                                         where datediff(CURRENT_DATE, showtime.sht_Date) <= 0) 
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
    function getComingsoon(): array
    {
        $query = "Select * from film where(Datediff(film_Release_date,CURRENT_DATE()) <= 100 
                        and Datediff(film_Release_date, CURRENT_DATE()) > 0)
                            GROUP BY film.film_ID";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }
    function getFilm($film_ID){
        //describe
        $query = "Select * from film where film.film_ID like '$film_ID'";
        //select from cluster
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $data = $row;
        mysqli_close($conn);
        return $data;
    }
//    print_r(getNowShowing('2D','2023-04-17','cluster0101'));
//    print_r(getComingsoon());
    function creSeat(){
        $conn = open_Database();
        $query = "select * from room";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
                for ($i = 1 ; $i < 51; $i++){
                    $room = substr($row['room_ID'],4,9);
                    if ($i < 10) {
                        $seat_ID = "seat".$room ."0". $i;
                    }
                    else{
                        $seat_ID = "seat".$room.$i;
                    }
                    $room = $row['room_ID'];
                    if ($i <= 20){
                        $type = 'Standard';
                    }
                    elseif ($i <= 40){
                        $type = "Vip";
                    }
                    else{
                        $type = 'Couple';
                    }
                    $query = "Insert into seat values ('$seat_ID','$room','$i', '$type')";
                    mysqli_query($conn, $query);
                }
        }
    }
    //creSeat();
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
    function getRoom_byClusterID($cluster_ID){
        $query = "select * from room where 'cluster_ID' like '$cluster_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function displayAccount(): array
    {
        $query = "select * from customer inner JOIN account ON cus_ID like acc_ID;";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }
    function checkShowtime($filmID){
            $query = "select * from showtime where showtime.film_ID like '$filmID'";
            $conn = open_Database();
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result)==0){
                return false;
            }
            return true;
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
    function addShowtime($filmID, $roomID, $type, $date, $time, $time_end){
        $query = "select count(*) from showtime where room_ID like '$roomID'";
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $id_room = substr($roomID,4,9);
        IF ($row[0] < 1){
            $new_ID = 'show'.$id_room.'00001';
        }
        ELSE{
            $query = "select Max(sht_ID) from showtime where room_ID like '$roomID'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            $pre_ID = substr($row[0],10,5);
            $new_ID = (int)$pre_ID + 1;
            if($new_ID < 10){
                $new_ID = 'show'.$id_room.'0000'.$new_ID;
            }
            elseif ($new_ID < 100){
                $new_ID = 'show'.$id_room.'000'.$new_ID;
            }
            elseif ($new_ID < 1000){
                $new_ID = 'show'.$id_room.'00'.$new_ID;
            }
            elseif ($new_ID < 10000){
                $new_ID = 'show'.$id_room.'0'.$new_ID;
            }
            elseif ($new_ID < 100000){
                $new_ID = 'show'.$id_room.$new_ID;
            }
        }
        $query = "INSERT into showtime values('$new_ID','$filmID','$roomID','$type','$date','$time','$time_end')";
        mysqli_query($conn,$query);
        mysqli_close($conn);
        createShowtime_seat($new_ID,$roomID);
        creaShowtime_room($new_ID, $roomID);
    }
    //note 3 4 11 9 12 10 16 (upcoming)
    //2D: 1 7 8 9 10 12 13 15 20 06 16 05 04 19
    //3D: 01 02 13 17 03 18 11 04 07 05
    //4D: 11 06 18 17 02 03


    // area01
        //cluster0101
            //room010101 2D


    function createShowtime_seat($showtimeID,$roomID){
        $query = "select seat_ID from seat where room_ID like '$roomID'";
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $seat_ID = $row['seat_ID'];
            $query = "insert into showtime_seat values ('$showtimeID','$seat_ID',null)";
            mysqli_query($conn, $query);
            // echo $seat_ID;
        }
        mysqli_close($conn);
        }
    function creaShowtime_room($showtimeID,$roomID){
        $query = "insert into showtime_room values ('$showtimeID','$roomID')";
        $conn = open_Database();
        mysqli_query($conn, $query);
        mysqli_close($conn);
    }


    function getCluster_byFilmID($filmID): array
    {
        $query = "select cluster.cluster_ID, cluster.cluster_Name, area.area_ID, area.area_Name
                        from cluster
                            inner join area on cluster.area_ID like area.area_ID
                        where cluster.cluster_ID
                            in (select cluster_ID from room
                                where room.room_ID in(select room_ID from showtime where film_ID like '$filmID'))";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }


    // ====================================<<Dat>>===================================-->
    function getMonth($month): string
    {
        $Mon = '';
        switch($month){
            case '1': $Mon = 'Jan';
                break;
            case '2': $Mon = 'Feb';
                break;
            case '3': $Mon = 'Mar';
                break;
            case '4': $Mon = 'Apr';
                break;
            case '5': $Mon = 'May';
                break;
            case '6': $Mon = 'Jun';
                break;
            case '7': $Mon = 'Jul';
                break;
            case '8': $Mon = 'Aug';
                break;
            case '9': $Mon = 'Sep';
                break;
            case '10': $Mon = 'Oct';
                break;
            case '11': $Mon = 'Nov';
                break;
            case '12': $Mon = 'Dec';
                break;
        }
        return $Mon;
    }

    function dayReverse($date): string{
        $date_str = $date;
        $date_arr = explode('-', $date_str);                    // tách chuỗi thành mảng các phần tử
        $date_reversed = implode('-', array_reverse($date_arr)); // đảo ngược mảng và nối lại bằng dấu gạch ngang
        return $date_reversed;
    }

    function getAllFilmType(): array
    {
        $query = "select * from film_type";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getAllFilmTypeByFilmID($filmID): array
    {
        $query = "select * from film_choice
                    where film_ID = ?";
        $data = array();
        $conn = open_Database();

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        mysqli_stmt_bind_param($stmt, "s", $filmID);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $data;
    }

    function getClusterByFilmID($filmID): array
    {
        $query = "select * from showtime st, room r, cluster c, area a
                    where st.film_ID = ? 
                    and r.room_ID = st.room_ID 
                    and c.cluster_ID = r.cluster_ID
                    and c.area_ID = c.area_ID";
        $data = array();
        $conn = open_Database();

        // prepare input
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $filmID);

        // truy vấn
        mysqli_stmt_execute($stmt);
        // lấy giá trị
        $result = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $data;
    }

    function getAllFilmLimitSixFilm(): array
    {
        $query = "SELECT * FROM film WHERE film.film_ID	IN (SELECT film_ID FROM showtime) 
                                                                    AND Datediff(film_Release_date,CURRENT_DATE()) <= 10
                                                                    GROUP BY film.film_ID limit 6";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getCusByPhone($phone): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from customer where cus_Phone_number = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $phone);

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

    function deleteCusByCusID($cus_ID){

        $conn = open_Database();

        $query = "delete from customer where cus_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $cus_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        mysqli_stmt_get_result($stmt);


        $query = "delete from account where acc_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $cus_ID);

        // thực thi
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    function getShowTimeByShowTimeID($sht_ID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from showtime where sht_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $sht_ID);

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

    function getSeatByShtID($sht_ID): array{
        $query = "SELECT * FROM showtime_seat, seat
                            where showtime_seat.sht_ID = '$sht_ID'
                            and showtime_seat.seat_ID = seat.seat_ID; ";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getRoomByRoomID($room_ID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from room where room_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $room_ID);

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

    function getFilmByFilmID($filmID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from film where film_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $filmID);

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

    function getAreaByAreaID($area_ID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from area where area_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $area_ID);

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

    function getSeatByRoomIDNoPrepare($room_ID): array{
        $query = "select * from seat where room_ID = '$room_ID' ";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getSeatByRoomID($room_ID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from seat where room_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $room_ID);

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

    // function getSeatBySeatID($seat_ID){
    //     $conn = open_Database();
    //     $data = array();

    //     $query = "select * from seat where seat_ID = ?";
    //     $stmt = mysqli_stmt_init($conn);
    //     mysqli_stmt_prepare($stmt, $query);

    //     // gán giá trị
    //     mysqli_stmt_bind_param($stmt, "s", $seat_ID);

    //     // thực thi
    //     mysqli_stmt_execute($stmt);

    //     $result = mysqli_stmt_get_result($stmt);
    //     while($row = mysqli_fetch_assoc($result)){
    //         $data = $row;
    //     }
    //     mysqli_stmt_close($stmt);
    //     mysqli_close($conn);
    //     return $data;
    // }

    function getNewURL(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);

        // Xóa tất cả các phần tử trong mảng query
        foreach ($query_parts as $key => $value) {
            unset($query_parts[$key]);
        }

        // Tạo lại chuỗi query mới
        $new_query = http_build_query($query_parts);

        // Tạo lại URL với chuỗi query mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query;
        return $new_url;
    }

    function deleteBookingDone(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts['booking']);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function deleteURLFilmID_AreaID(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts['filmID']);
        unset($query_parts['area']);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function deleteURLCluster_ShtID(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts['cluster']);
        unset($query_parts['stID']);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function deleteFilmID(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts['filmID']);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function deleteOneURL($name): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts[$name]);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function deleteURLPackageIDInPackage(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts['package']);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function deleteURLVoucherIDInVoucher(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts['voucher']);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    // ========================<<New>>====================

    function getSeatBySeatIDJoinSeatType($seat_ID): array{
        $query = "SELECT * FROM seat, seat_type
        where seat.seat_type = seat_type.type_Name
        and seat_ID = '$seat_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function updateAccountCustomer($cusID, $name, $phone, $email, $dob, $gender, $pass){
        $query = "UPDATE customer, account
        
        SET customer.cus_Name = '$name',
        customer.cus_Email = '$email',
        customer.cus_Phone_number = '$phone',
        customer.cus_DOB = '$dob',
        customer.cus_Sex = '$gender',

        account.acc_Username = '$phone',
        account.acc_Password = '$pass'
        WHERE customer.cus_ID = account.acc_ID AND customer.cus_ID = '$cusID'";

        $conn = open_Database();
        mysqli_query($conn, $query);
        
        mysqli_close($conn);

    }

    function checkCustomerPass($pass): bool{
        $conn = open_Database();

        $query = "select * from account where acc_Password = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $pass);

        // thực thi
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if($row){
            return true;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return false;
    }

    function getcusIDByPhone($phone): string{
        $query = "SELECT * FROM customer where cus_Phone_number = '$phone'";

        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data[0]['cus_ID'];
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

    function getAllVoucher(): array{
        $query = "SELECT * FROM voucher";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        
        mysqli_close($conn);
        return $data;
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

    function getFilmTypePrice($film_type): string{
        $query = "SELECT * FROM film_type where type_Name = '$film_type'";

        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data[0]['Price'];
    }

    function insertTicket($acc_ID, $cluster_ID, $film_ID, $type_Name, $sht_ID, $seat_ID, $room_ID, $voucher_ID, $ticket_Price, $combo_ID){

        #Kiểm tra đã có customer nào chưa
        $query = "select count(*) from ticket where sht_ID = '$sht_ID'";
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($result);
        $ticket_ID ='';
        $showtime_ID = substr($sht_ID,4,11);
        //Nếu chưa có customer nào
        if ($row[0] < 1){
            $ticket_ID = 'ticket'.$showtime_ID . 'TK01';
        }
        else{
            $query = "select max(ticket_ID) from ticket where sht_ID like '$sht_ID'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);

            #Set ID

            $prev_id = substr($row[0],19,2); #Lấy ra ID lớn nhất

            $stt = (int)$prev_id + 1; # tạo ra ID mới

            if ($stt < 10){
                $ticket_ID = 'ticket'.$showtime_ID . 'TK0' . $stt;
            }
            elseif ($stt < 51){
                $ticket_ID = 'ticket'.$showtime_ID . 'TK' . $stt;
            }
        }

        $date = date("Y-m-d");
        $query = "insert into ticket values('$ticket_ID', '$acc_ID', '$cluster_ID', '$film_ID', '$type_Name', '$sht_ID', '$seat_ID', '$room_ID', '$voucher_ID', '$ticket_Price', '$date')";
        mysqli_query($conn, $query);
        // print_r($query);
        $query = "insert into ticket_combo values('$ticket_ID', '$combo_ID')";

        mysqli_query($conn, $query);

        $query = "insert into cus_voucher values('$voucher_ID', '$acc_ID')";
        
        mysqli_query($conn, $query);

        mysqli_close($conn);
    }

    function updateShowTimeSeat($seat_ID, $sht_ID){
        $query = "UPDATE showtime_seat
        
        SET isBook = 'Book'
        
        WHERE seat_ID = '$seat_ID' and sht_ID = '$sht_ID'";

        $conn = open_Database();
        mysqli_query($conn, $query);
        
        mysqli_close($conn);
    }

    function getMyTicketTable($acc_ID){
        $query = "SELECT * FROM ticket, account, cluster, film, showtime, seat, room, area
        where ticket.acc_ID LIKE '$acc_ID'
        and ticket.acc_ID LIKE account.acc_ID
        and ticket.cluster_ID LIKE cluster.cluster_ID
        and ticket.film_ID LIKE film.film_ID
        and ticket.sht_ID LIKE showtime.sht_ID
        and ticket.seat_ID LIKE seat.seat_ID
        and ticket.room_ID LIKE room.room_ID
        and area.area_ID LIKE cluster.area_ID";


        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getAccByPhone($phone): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from account where acc_Username = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $phone);

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

    function getAccByAccID($acc_ID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from account where acc_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $acc_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $data;
    }

    // đang sửa
    function activeAndLockAccount($acc_ID, $isActive){
        $conn = open_Database();
        // $query = "select * from account where acc_ID = '$acc_ID'";
        // $result = mysqli_query($conn, $query);
        // $data = array();
        // while($row = mysqli_fetch_assoc($result)){
        //     $data[] = $row;
        // }
        
        if($isActive == 'Active'){
            $query = "UPDATE account
        
            SET acc_isActive = 'Lock'
            
            WHERE acc_ID = '$acc_ID'";
        }else if($isActive == 'Lock'){
            $query = "UPDATE account
        
            SET acc_isActive = 'Active'
            
            WHERE acc_ID = '$acc_ID'";
        }        

        mysqli_query($conn, $query);
        
        mysqli_close($conn);
    }

    function getAllAccount(): array{
        $query = "SELECT * FROM account";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getAllCombo(): array{
        $query = "SELECT * FROM combo";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getComboNameByTicketID($ticket_ID): string{
        $query = "SELECT * FROM ticket_combo, combo
        where ticket_combo.combo_ID = combo.combo_ID
        and ticket_ID = '$ticket_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        if(!empty($data)){
            return $data[0]['combo_Name'];
        }
        mysqli_close($conn);
        
        return "none";
    }

    function getComboByComboID($comboID): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from combo where combo_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $comboID);

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

    function getAllFilm():array{
        $query = "SELECT * FROM film";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function uploadFile($fileName): string{
        $file_name = $_FILES[$fileName]["name"];
        $file_tmp = $_FILES[$fileName]["tmp_name"];
        $file_size = $_FILES[$fileName]["size"];
        $file_error = $_FILES[$fileName]["error"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // check exist
        $file_dir = "assets/img/" . basename($file_name);
        if (file_exists($file_dir)) {
            return "File". " $file_name ". "is already exists.";
        }

        // check size
        if ($file_size > 50000000) { // 50MB
            return "File "."$file_name"." is too large.";
        }
        
        // check ext
        if($file_ext != "jpg" && $file_ext != "png" && $file_ext != "jpeg") {
            return "Only JPG, JPEG, PNG files are allowed for photo and slider.";
        }

        if ($file_error === 0) {
            move_uploaded_file($file_tmp, "assets/img/" . $file_name);

        } else {
            return "Upload ". "$file_name". " error";
        }
        return "";
    }

    function uploadTrailer($fileName): string{
        $file_name = $_FILES[$fileName]["name"];
        $file_tmp = $_FILES[$fileName]["tmp_name"];
        $file_size = $_FILES[$fileName]["size"];
        $file_error = $_FILES[$fileName]["error"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // check exist
        $file_dir = "assets/video/" . basename($file_name);
        if (file_exists($file_dir)) {
            return "File". " $file_name ". "is already exists.";
        }

        // check size
        if ($file_size > 50000000) { // 50MB
            return "File "."$file_name"." is too large.";
        }
        
        // check ext
        if($file_ext != "mp4") {
            return "Only MP4 files are allowed for trailer.";
        }

        if ($file_error === 0) {
            move_uploaded_file($file_tmp, "assets/video/" . $file_name);

        } else {
            return "Upload ". "$file_name". " error";
        }
        return "";
    }

    function editFilmByFilmID($film_ID, $film_Name, $film_Director, $film_Cast, $film_Genre, 
    $film_Running_time, $film_Release_date, $film_Describe, $film_Language, $film_Rated){
        $query = "UPDATE film
        
        SET film_Name = '$film_Name',
        film_Director = '$film_Director',
        film_Cast = '$film_Cast',
        film_Genre = '$film_Genre',
        film_Running_time = '$film_Running_time',
        film_Release_date = '$film_Release_date',
        film_Description = '$film_Describe',
        film_Language = '$film_Language',
        film_Rated = '$film_Rated'
        
        WHERE film_ID = '$film_ID'";

        $conn = open_Database();
        mysqli_query($conn, $query);
        
        mysqli_close($conn);
    }

    function editPhotoTrailerSliderByFilmID($film_ID, $film_photo, $film_trailer, $film_slider){
        $query = "UPDATE film
        
        SET film_photo = '$film_photo',
        film_trailer = '$film_trailer',
        film_Slider = '$film_slider'
        
        WHERE film_ID = '$film_ID'";

        $conn = open_Database();
        mysqli_query($conn, $query);
        
        mysqli_close($conn);
    }

    function insertFilm($film_Name, $film_Director, $film_Cast, $film_Genre, 
    $film_Running_time, $film_Release_date, $film_Describe, $film_Language, $film_Rated, $film_photo, $film_trailer, $film_slider, $film_Type){
        // Lấy ID lớn nhất 
        $conn = open_Database();
        $query = "select max(film_ID) as max_id from film";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $prev_id = $row['max_id'];

        // Tạo mã cho bản ghi tiếp theo
        if ($prev_id) {
            $stt = (int) substr($prev_id, 4) + 1;
        } else {
            $stt = 1;
        }

        $id = sprintf("film%02d", $stt);

        $query = "INSERT INTO film VALUES ('$id', '$film_Name', '$film_Director', '$film_Cast', '$film_Genre', '$film_Running_time', '$film_Release_date', 
        '$film_Describe', '$film_Language', '$film_Rated', '$film_photo', '$film_trailer', '$film_slider')";
        mysqli_query($conn, $query);

        insertFilmChoice($id, $film_Type);

        mysqli_close($conn);
    }

    function insertFilmChoice($film_ID, $film_Type){
        $conn = open_Database();
        $query = "INSERT INTO film_choice VALUES ('$film_ID', '$film_Type')";
        mysqli_query($conn, $query);
        mysqli_close($conn);
    }

    function deleteFilmByFilmID($film_ID){

        $conn = open_Database();

        $query = "delete from film where film_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $film_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);
        deleteFilmChoiceByFilmID($film_ID);
        // deleteShtByFilmID($film_ID);
        mysqli_close($conn);
    }

    function deleteShtByFilmID($film_ID){
        $conn = open_Database();

        $query = "delete from showtime where film_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $film_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);

        mysqli_close($conn);
        foreach(getShtByFilmID($film_ID) as $row){
            $sht_ID = $row['sht_ID'];
            deleteShowtimeRoom($sht_ID);
            deleteShowtimeSeat($sht_ID);
        }
    }

    function deleteTicketByFilmID($film_ID){
        $conn = open_Database();
        $query = "delete from ticket where film_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $film_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);

        mysqli_close($conn);
    }

    function getShtByFilmID($film_ID): array{
        $conn = open_Database();
        $query = "select * from showtime where film_ID = '$film_ID'";
        $data = array();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }

    function deleteFilmChoiceByFilmID($film_ID){
        $conn = open_Database();
        $query = "delete from film_choice where film_ID = '$film_ID'";
        mysqli_query($conn, $query);
        mysqli_close($conn);
    }

    function createRandomCode($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    function getCusByEmail($email): array{
        $conn = open_Database();
        $data = array();

        $query = "select * from customer where cus_Email = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $email);

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

    function updateAccCodeForgot($code, $acc_ID){
        $query = "UPDATE account
        
        SET account.acc_code_forgot = '$code'
        
        WHERE account.acc_ID = '$acc_ID'";

        $conn = open_Database();
        mysqli_query($conn, $query);
        
        mysqli_close($conn);
    }

    function checkAccCodeForgot($code, $acc_ID){
        $conn = open_Database();
        $query = "select * from account
        where acc_ID = '$acc_ID' and acc_code_forgot = '$code'";

        $result = mysqli_query($conn, $query);

        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        if ($row){
            return true;
        }
        return false;
    }

    function updatePassWord($newPass, $acc_ID){
        $query = "UPDATE account
        
        SET account.acc_Password = '$newPass'
        
        WHERE account.acc_ID = '$acc_ID'";

        $conn = open_Database();
        mysqli_query($conn, $query);
        
        mysqli_close($conn);
    }

    function getFilmeTypeByFilmId($film_ID): array{
        $query = "SELECT * FROM film_choice 
        where film_ID = '$film_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getRoomAndCluster($film_ID): array{
        $query = "SELECT * FROM room, cluster, film_choice
        where room.cluster_ID = cluster.cluster_ID
        and room.room_Type = film_choice.type_Name
        and film_choice.film_ID = '$film_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getClusterByRoomID($sht_ID, $room_ID, $film_ID): array{
        $query = "SELECT * FROM showtime, room, cluster
        where showtime.room_ID = room.room_ID
        and room.cluster_ID = cluster.cluster_ID
        and sht_ID = '$sht_ID'
        and showtime.film_ID = '$film_ID' and showtime.room_ID = '$room_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getShowtimeByFilmID($film_ID):array{
        $query = "SELECT * FROM showtime where film_ID = '$film_ID'";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getAllShowTime(): array{

        $query = "SELECT * FROM showtime";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function deleteShtByShtID($sht_ID){
        
        $conn = open_Database();

        $query = "delete from showtime where sht_ID= ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $sht_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        deleteShowtimeRoom($sht_ID);
        deleteShowtimeSeat($sht_ID);
    }

    function deleteShowtimeRoom($sht_ID){
        $conn = open_Database();

        $query = "delete from showtime_room where sht_ID= ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $sht_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    
    function deleteShowtimeSeat($sht_ID){
        $conn = open_Database();

        $query = "delete from showtime_seat where sht_ID= ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);

        // gán giá trị
        mysqli_stmt_bind_param($stmt, "s", $sht_ID);

        // thực thi
        mysqli_stmt_execute($stmt);

        mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    function updateShowTime($sht_ID, $film_ID, $room_ID, $sht_Type, $sht_Date, $sht_Time, $sht_End){
        $query = "UPDATE showtime
        
        SET showtime.film_ID = '$film_ID',
        showtime.room_ID = '$room_ID',
        showtime.sht_Type = '$sht_Type',
        showtime.sht_Date = '$sht_Date',
        showtime.sht_Time = '$sht_Time',
        showtime.sht_Time_end = '$sht_End'
        WHERE showtime.sht_ID = '$sht_ID'";

        $conn = open_Database();
        mysqli_query($conn, $query);
        
        mysqli_close($conn);
    }

    function getAllTicket(): array{
        $query = "SELECT * FROM ticket";
        $data = array();
        $conn = open_Database();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getAllRoom(): array{
        $conn = open_Database();
        $data = array();
        $query = "select * from room";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function getCusByCusID($cus_ID):array{
        $conn = open_Database();
        $data = array();
        $query = "select * from account, customer 
        where customer.cus_ID = '$cus_ID'
        and account.acc_Username = customer.cus_Phone_number";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        mysqli_close($conn);
        return $data;
    }

?>



