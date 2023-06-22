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
        <!-- <form action="" method="post" enctype="multipart/form-data"> -->
            <div class="manage-film__edit--content">

                <h1 class="manage-film__edit-title">INFO FILM</h1>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Film Name</p>
                    <input readonly value="<?= $film_Name ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="name">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Director</p>
                    <input readonly value="<?= $film_Director ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="director">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Cast</p>
                    <textarea readonly class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" name="cast" id="" cols="30" rows="10"><?= $film_Cast ?></textarea>
                    
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Genre</p>
                    <input readonly value="<?= $film_Genre ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="genre">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Running Time</p>
                    <input readonly value="<?= $film_Running_time ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="running_time">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Released Date</p>
                    <input readonly value="<?= $film_Release_date ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="date" id="" name="release_date">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Description</p>
                    <textarea readonly class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" name="description" id="" cols="30" rows="10"><?= $film_Description ?></textarea>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Language</p>
                    <input readonly value="<?= $film_Language ?>" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="language">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Rated</p>
                    <textarea readonly class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" value="" name="rated" id="" cols="30" rows="10"><?= $film_Rated ?></textarea>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Photo (<?= $film_photo ?>)</p>
                    <div class="manage-film__edit--img-out col-l-8 col-md-8 col-sm-6">
                        <img class="manage-film__edit--img" src="/assets/img/<?= $film_photo ?>" alt="" srcset="">
                    </div>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Trailer (<?= $film_trailer ?>)</p>
                    <div class="manage-film__edit--img-out col-l-8 col-md-8 col-sm-6">
                        <!-- <img class="manage-film__edit--img" src="/assets/video/<?= $film_trailer ?>" alt="" srcset=""> -->
                        <video controls class="manage-film__edit--video" src="/assets/video/<?= $film_trailer ?>"></video>
                    </div>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Slider (<?= $film_Slider ?>)</p>
                    <div class="manage-film__edit--img-out col-l-8 col-md-8 col-sm-6">
                        <img class="manage-film__edit--slider" src="/assets/img/<?= $film_Slider ?>" alt="" srcset="">
                    </div>
                </div>

                <!-- <button name="edit_btn" class="manage-film__edit--btn">EDIT</button> -->
            </div>
            
        <!-- </form> -->


</body>