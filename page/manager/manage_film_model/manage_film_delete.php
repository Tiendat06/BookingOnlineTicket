<body>
    <?php
        if(isset($_GET['filmID'])){
            $film_ID = $_GET['filmID'];
            $dataFilm = getFilmByFilmID($film_ID);
            $film_photo = $dataFilm['film_photo'];
            $film_trailer = $dataFilm['film_trailer'];
            $film_slider = $dataFilm['film_Slider'];

            $photo = 'assets/img/'.$film_photo;
            $trailer = 'assets/video/'.$film_trailer;
            $slider = 'assets/img/'.$film_slider;

            if (file_exists($photo)){
                unlink($photo); // xóa hình ảnh
            }
            if (file_exists($trailer)){
                unlink($trailer);
            }
            if (file_exists($slider)){ 
                unlink($slider);
            }

            deleteFilmByFilmID($film_ID);
            header('location: manager_main.php?page=manage_film');
        }else{
            header('location: manager_main.php?page=manage_film');
        }
    ?>
</body>