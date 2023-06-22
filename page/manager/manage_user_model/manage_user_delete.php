<body>
    <?php
        if(isset($_GET['cusID'])){
            $cus_ID = $_GET['cusID'];
            deleteCusByCusID($cus_ID);
            header('location: manager_main.php?page=manage_user');
        }
    ?>
</body>