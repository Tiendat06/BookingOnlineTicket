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

    function insertFilmChoice($film_ID, $film_Type){
        $conn = open_Database();
        $query = "INSERT INTO film_choice VALUES ('$film_ID', '$film_Type')";
        mysqli_query($conn, $query);
        mysqli_close($conn);
    }

    function checkFilmType($film_ID, $type_Name){
        $conn = open_Database();
        $query = "select * from film_choice where type_Name = '$type_Name' and film_ID = '$film_ID'";
        $result = mysqli_query($conn, $query);

        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        if ($row){
            return true;
        }
        return false;
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

    function sumTicketPriceInMonth($month): array{
        $conn = open_Database();
        $data = array();
        $query = "select sum(ticket_Price) as sumTicket from ticket
        where MONTH(ticket_Date) = '$month' and YEAR(ticket_Date) = YEAR(CURRENT_DATE())";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function countTicketInMonth($month): array{
        $conn = open_Database();
        $data = array();
        $query = "select COUNT(*) as ticket_Count from ticket 
        where MONTH(ticket_Date) = '$month' and YEAR(ticket_Date) = YEAR(CURRENT_DATE()) ";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function hotFilmInMonth($month):array{
        $conn = open_Database();
        $data = array();
        $query = "select film_ID as film, count(film_ID) as film_quan 
        from ticket where MONTH(ticket_Date) = '$month' and YEAR(ticket_Date) = YEAR(CURRENT_DATE())
        GROUP BY ticket.film_ID asc";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        mysqli_close($conn);
        return $data;
    }

    function seatOfRoomBookedInMonth($room_ID, $month){
        $conn = open_Database();
        $data = array();
        $query = "SELECT count(seat_ID) as total_seats from ticket
        where room_ID = '$room_ID' and MONTH(ticket_Date) = '$month' and YEAR(ticket_Date) = YEAR(CURRENT_DATE())";
        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        mysqli_close($conn);
        return $data;
    }

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

?>