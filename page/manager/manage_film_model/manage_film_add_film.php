<body>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="manage-film__edit--content">

                <h1 class="manage-film__edit-title">ADD FILM</h1>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Film Name</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="name">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Film Type</p>
                    <select name="type" class="manage-film__input--edit col-l-8 col-md-8 col-sm-6">
                        <?php
                            foreach(getAllFilmType() as $row){
                                $film_type = $row['type_Name'];
                                ?>
                                    <option class="manage-film__option--add-room" value="<?= $film_type ?>"><?= $film_type ?></option>
                                <?php
                            }
                        
                        ?>
                    </select>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Director</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="director">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Cast</p>
                    <textarea class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" name="cast" id="" cols="30" rows="10"></textarea>
                    
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Genre</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="genre">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Running Time</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="running_time">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Released Date</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="date" id="" name="release_date">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Description</p>
                    <textarea class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" name="description" id="" cols="30" rows="10"></textarea>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Language</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="text" id="" name="language">
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Rated</p>
                    <textarea class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" name="rated" id="" cols="30" rows="10"></textarea>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Photo (At least 50MB for JPG, JPEG, PNG)</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="file" id="photo" name="photo" required>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Trailer (At least 50MB for MP4)</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="file" id="" name="trailer" required>
                </div>

                <div class="manage-film__edit col-l-12 col-md-12 col-sm-12">
                    <p class="manage-film__edit--para col-l-4 col-md-4 col-sm-6">Slider (At least 50MB for JPG, JPEG, PNG)</p>
                    <input class="manage-film__input--edit col-l-8 col-md-8 col-sm-6" type="file" id="" name="slider" required>
                </div>

                <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['edit_btn'])){
                        if(!empty($_POST['name']) && !empty($_POST['director'])
                        && !empty($_POST['cast']) && !empty($_POST['genre'])
                        && !empty($_POST['running_time']) && !empty($_POST['release_date'])
                        && !empty($_POST['description']) && !empty($_POST['language']) && !empty($_POST['type'])
                        && !empty($_POST['rated']) && isset($_FILES['photo']) 
                        && isset($_FILES['trailer']) && isset($_FILES['slider'])){

                            $film_Name = $_POST['name'];
                            $film_type = $_POST['type'];
                            // echo $film_type;
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
                            
                            
                            $photo = uploadFile('photo');
                            $trailer = uploadTrailer('trailer');
                            $slider = uploadFile('slider');
                            if($photo == "" && $trailer == "" && $slider == ""){
                                insertFilm($film_Name, $film_Director, $film_Cast, $film_Genre, $film_Running_time, $film_Release_date, $film_Description, $film_Language, $film_Rated, $film_photo, $film_trailer, $film_slider, $film_type);
                                echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Add Successfully</p>";
                            }else{
                                $fphoto = 'assets/img/'.$film_photo;
                                $ftrailer = 'assets/video/'.$film_trailer;
                                $fslider = 'assets/img/'.$film_slider;

                                if (file_exists($fphoto)){
                                    unlink($fphoto); // xóa hình ảnh
                                }
                                if (file_exists($ftrailer)){
                                    unlink($ftrailer);
                                }
                                if (file_exists($fslider)){ 
                                    unlink($fslider);
                                }

                                echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>$photo</p>";
                                echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>$trailer</p>";
                                echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>$slider</p>";
                            }

                        }else{
                            echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Please enter full informations</p>";
                        }
                    }
                }
                ?>
                <button name="edit_btn" class="manage-film__edit--btn">ADD</button>
            </div>
            
        </form>


</body>