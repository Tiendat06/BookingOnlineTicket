<body>
    <?php
        if(isset($_GET['filmID'])){
            $filmID = $_GET['filmID'];
            $_SESSION['filmID'] = $filmID;
            header('location: '.deleteFilmID());
        }
        else{
            $filmID = $_SESSION['filmID'];
        }
        $dataFilm = getFilmByFilmID($filmID);
        $film_Name = $dataFilm['film_Name'];
        $film_Director = $dataFilm['film_Director'];
        $film_Cast = $dataFilm['film_Cast'];
        $film_Genre = $dataFilm['film_Genre'];
        $film_Running_time = $dataFilm['film_Running_time'];
        $film_Release_date = $dataFilm['film_Release_date'];
        $film_Description = $dataFilm['film_Description'];
        $film_Language = $dataFilm['film_Language'];
        $film_Rated = $dataFilm['film_Rated'];
        $film_photo = $dataFilm['film_photo'];
        $film_trailer = $dataFilm['film_trailer'];
        $film_Slider = $dataFilm['film_Slider'];

    ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="manage-film__edit--content">

                <h1 class="manage-film__edit-title">EDIT FILM</h1>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Film Name</p>
                    <input value="<?= $film_Name ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="name">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Director</p>
                    <input value="<?= $film_Director ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="director">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Cast</p>
                    <textarea class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" name="cast" id="" cols="30" rows="10"><?= $film_Cast ?></textarea>
                    
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Genre</p>
                    <input value="<?= $film_Genre ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="genre">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Running Time</p>
                    <input value="<?= $film_Running_time ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="running_time">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Released Date</p>
                    <input value="<?= $film_Release_date ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="date" id="" name="release_date">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Description</p>
                    <textarea class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" name="description" id="" cols="30" rows="10"><?= $film_Description ?></textarea>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Language</p>
                    <input value="<?= $film_Language ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="language">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Rated</p>
                    <textarea class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" name="rated" id="" cols="30" rows="10"><?= $film_Rated ?></textarea>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Photo (Blank for no editing)</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" type="file" id="photo" name="photo">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Trailer (Blank for no editing)</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" type="file" id="" name="trailer">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Slider (Blank for no editing)</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" type="file" id="" name="slider">
                </div>

                <?php
                // ini_set('upload_max_filesize', '800M');
                // ini_set('post_max_size', '800M');
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['edit_btn'])){
                        if(!empty($_POST['name']) && !empty($_POST['director'])
                        && !empty($_POST['cast']) && !empty($_POST['genre'])
                        && !empty($_POST['running_time']) && !empty($_POST['release_date'])
                        && !empty($_POST['description']) && !empty($_POST['language'])
                        && !empty($_POST['rated'])){

                            $film_Name = $_POST['name'];
                            $film_Director = $_POST['director'];
                            $film_Cast = $_POST['cast'];
                            $film_Genre = $_POST['genre'];
                            $film_Running_time = $_POST['running_time'];
                            $film_Release_date = $_POST['release_date'];
                            $film_Description = $_POST['description'];
                            $film_Language = $_POST['language'];
                            $film_Rated = $_POST['rated'];
                            $film_photo = $_FILES['photo']['name'];
                            $film_trailer = $_FILES['trailer']['name'];
                            $film_slider = $_FILES['slider']['name'];
                            editFilmByFilmID($filmID, $film_Name, $film_Director, $film_Cast, $film_Genre, $film_Running_time, $film_Release_date, $film_Description, $film_Language, $film_Rated);

                            if(!empty($_POST['photo']) && !empty($_POST['trailer']) && !empty($_POST['slider'])){
                                $photo = uploadFile('photo');
                                $trailer = uploadTrailer('trailer');
                                $slider = uploadFile('slider');
                                if($photo != "" && $trailer != "" && $slider != ""){
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
                                    echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>$photo</p>";
                                    echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>$trailer</p>";
                                    echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>$slider</p>";
                                }else{
                                    editPhotoTrailerSliderByFilmID($filmID, $film_photo, $film_trailer, $film_slider);
                                }
                                echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Edit Successfully</p>";
                            }
                            

                        }else{
                            echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Please enter full informations</p>";
                        }
                    }
                }
                ?>
                <button name="edit_btn" class="manage-film__edit--btn">EDIT</button>
            </div>
            
        </form>


</body>