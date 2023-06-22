<body>
    <div class="bg--outside">
        <div class="container">
            <?php
            // save $_SESSION
                if(isset($_GET['filmID'])){
                    $film_ID = $_GET['filmID'];
                    $_SESSION['filmID'] = $film_ID;
                    header('location: '.deleteFilmID());
                }else{
                    $film_ID = $_SESSION['filmID'];
                }

                $row = getFilm($film_ID);

                $film_Name = $row['film_Name'];
                $film_Photo = $row['film_photo'];
                $film_Trailer = $row['film_trailer'];
                $film_Genre = $row['film_Genre'];
                $film_Running_time = $row['film_Running_time'];
                $film_Release_date = $row['film_Release_date'];
                $film_Cast = $row['film_Cast'];
                $film_Director = $row['film_Director'];
                $film_Description = $row['film_Description'];
                $film_Language = $row['film_Language'];
                $film_Rated = $row['film_Rated'];
            ?>
            <div style="background-size: cover; background-image: linear-gradient(90deg, rgb(26, 26, 26) 25%, rgb(26, 26, 26) 38%,rgba(26, 26, 26, 0.04) 98%,rgb(26, 26, 26) 100%), url('<?php echo '/assets/img/'. $row['film_photo'] ?>');" class="row block__films film__describe--bg">
                <div class="film__describe--header col-l-12 col-md-12 col-sm-12">
                    <div class="film__describe--header-inner">
                        <p class="film__describe--title">FILMS DETAILS</p>
                    </div>
                </div>
                
                <div class="film__describe--content col-l-12 col-md-12 col-sm-12">
                    <!-- left (img, trailer) -->
        
                        <div class="film__describe--left-img">
                            <img id="film__describe--img" class="film__describe--img" src="<?php echo '/assets/img/'. $film_Photo ?>" alt="" srcset="">
                            <video poster="<?php echo '/assets/img/'.  $film_Photo ?>" height="230px" controls src="<?php echo '/assets/video/'. $film_Trailer ?>" id="film__describe--video" class="film__describe--video d-none"></video>
                        </div>        
                    <?php
                    // mysqli_next_result($conn);
                    ?>
                    <!-- <div class="film__describe--left-img">
                        <img id="film__describe--img" class="film__describe--img" src="/assets/img/shazam-film.jfif" alt="" srcset="">
                        <video poster="/assets/img/shazam-film.jfif" height="230px" controls src="/assets/video/shazam_trailer.mp4" id="film__describe--video" class="film__describe--video d-none">hello</video>
                    </div> -->
                    
                    <!-- right -->
                        <div class="film__describe--right-details">
                            <h1 class="film__describe--right-details-header">
                                <?php echo $film_Name ?>
                            </h1>

                            <strong class="film__describe--right-details-strong">Director: </strong> <span class="film__describe--right-details-info"><?php echo $film_Director ?></span> </br>
                            <strong class="film__describe--right-details-strong">Cast: </strong> <span class="film__describe--right-details-info"><?php echo $film_Cast ?></span> </br>
                            <strong class="film__describe--right-details-strong">Genre: </strong> <span class="film__describe--right-details-info"><?php echo $film_Genre ?></span></br>
                            <strong class="film__describe--right-details-strong">Running Time: </strong> <span class="film__describe--right-details-info"><?php echo $film_Running_time ?></span></br>
                            <strong class="film__describe--right-details-strong">Release date: </strong> <span class="film__describe--right-details-info"><?php echo $film_Release_date ?></span></br>
                            <strong class="film__describe--right-details-strong">Language: </strong> <span class="film__describe--right-details-info"><?php echo $film_Language ?></span></br>
                            <strong class="film__describe--right-details-strong">Rated: </strong> <span class="film__describe--right-details-info"><?php echo $film_Rated ?></span></br>
                            
                        </div>
                        <!-- <div class="film__describe--right-details">
                            <h1 class="film__describe--right-details-header">
                                SHAZAM! FURY OF THE GODS
                        </h1>
                        
                        <strong class="film__describe--right-details-strong">Director: </strong> <span class="film__describe--right-details-info">David F. Sandberg</span> </br>
                        <strong class="film__describe--right-details-strong">Genre: </strong> <span class="film__describe--right-details-info">Action, Adventure</span></br>
                        <strong class="film__describe--right-details-strong">Running Time: </strong> <span class="film__describe--right-details-info">130 minutes</span></br>
                        <strong class="film__describe--right-details-strong">Language: </strong> <span class="film__describe--right-details-info">English with Vietnamese subtitle</span></br>
                        <strong class="film__describe--right-details-strong">Age: </strong> <span class="film__describe--right-details-info">13+</span></br>

                    </div> -->
                </div>
                
                <div class="film__describe--description">
                    <strong class="film__describe--right-details-strong">Description: </strong> <span class="film__describe--right-details-info"><?php echo $film_Description ?></span></br>
                </div>

                <?php
                // if showtime => show booking ticket btn else d-none
                    if (checkShowtime($film_ID)){
                        $responsiveBookingBtn = 'col-l-6 col-md-6 col-sm-12';
                        $responsivePosterBtn = 'col-l-6 col-md-6 col-sm-12';
                    }else{
                        $responsiveBookingBtn = 'col-l-0 col-md-0 col-sm-0';
                        $responsivePosterBtn = 'col-l-12 col-md-12 col-sm-12';
                    }
                ?>

                <!-- btn trailer -->
                <div class="film__describe--traier-outer <?= $responsivePosterBtn ?>">
                    <button onclick="onClickMovieTrailer()" id="btnMovieTrailer" class="film__describe--trailer">
                    <i class="fa-solid fa-film"></i>
                        MOVIE TRAILER
                    </button>
                    <button onclick="onClickMoviePoster()" id="btnMoviePoster" class="film__describe--trailer d-none">
                    <i class="fa-solid fa-image"></i>
                        POSTER
                    </button>

                </div>

                <!-- btn booking -->
                <div class="film__describe--link <?= $responsiveBookingBtn ?>">
                    <button onclick="onClickBooking(this.id)" class="film__describe--booking" id="film__describe--booking-<?= $film_ID ?>">
                    <i class="fa-solid fa-ticket"></i>        
                    BOOKING
                    </button>
                </div>
                
            </div>

            <?php
                include('booking.php');
            ?>
        </div>
    </div>
</body>