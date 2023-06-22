<body>
    <?php
        if(isset($_GET['shtID'])){
            $sht_ID = $_GET['shtID'];
            deleteShtByShtID($sht_ID);
            header('location: manager_main.php?page=manage_showtime');
        }
    ?>
</body>