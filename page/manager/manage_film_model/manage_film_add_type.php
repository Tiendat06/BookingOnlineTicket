<body>
    <?php
        require('../connectInMan.php');
        if(!empty($_POST['type']) && !empty($_POST['filmID'])){

            $film_ID = $_POST['filmID'];
            $type = $_POST['type'];
            if(!checkFilmType($film_ID, $type)){
                insertFilmChoice($film_ID, $type);
            }

            header('location: manager_main.php?page=manage_film');
        }
    ?>
</body>