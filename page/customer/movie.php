<!-- Loading -->
<body>
    <div class="bg--outside">
        <div class="container">
            <!-- film choices -->
            <div class="row block__films">
            <!-- Film choice -->
                <div class="films__choice col-l-12 col-md-12 col-sm-12">
                    <div class="film__choice--inner">
                        <div onclick="onClickShowTimeFilmChoice()" id="films__choice--show-time" class="films__choice--show-time">
                            <p class="films__choice--header">Showtime Films</p>
                        </div>

                        <img class="film__choice--img" src="/assets/img/webicon.png" alt="" srcset="">
        
                        <div onclick="onClickUpcomingFilmChoice()" id="films__choice--upcoming" class="films__choice--upcoming">
                            <p class="films__choice--header">Upcoming Films</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- showtimes -->
            <div id="films__showtime" class="row block__films">

            <?php
                foreach (getNowShowing(null, null, null) as $row){
                    $film_ID = $row['film_ID'];
                    $film_Name = $row['film_Name'];
                    $film_Photo = $row['film_photo'];
                    $film_Trailer = $row['film_trailer'];
                    $film_Genre = $row['film_Genre'];
                    $film_Running_time = $row['film_Running_time'];
                    $film_Release_date = $row['film_Release_date'];
            ?>
                    <a id="<?= $film_ID ?>" href="?page=describe&filmID=<?php echo $film_ID ?>" class="films__items col-l-4 col-md-6 col-sm-12">
                        <div class="films__items--inner">
                            <img class="films__items--img" src="<?php echo '/assets/img/'. $film_Photo ?>" alt="" srcset="">
                            <h1 class="films__items--header"><?php echo $film_Name ?></h1>
                            <strong class="films__items--title">Genre: </strong> <span class="films__items--para films__items--type"><?php echo $film_Genre ?></span> </br>
                            <strong class="films__items--title">Running Time: </strong> <span class="films__items--para films__items--running-time"><?php echo $film_Running_time ?></span></br>
                            <strong class="films__items--title">Release date: </strong> <span class="films__items--para films__items--release-date"><?php echo $film_Release_date ?></span></br>
                            <button name="film__items--btn" class="films__items--btn">
                                <i class="fa-solid fa-ticket"></i>    
                                View Details
                            </button>
                        </div>
                    </a>
            <?php
                }
            ?>

                <!-- <a href="?page=describe" class="films__items col-l-4 col-md-6 col-sm-12">
                    <div class="films__items--inner">
                        <img class="films__items--img" src="/assets/img/shazam-film.jfif" alt="" srcset="">
                        <h1 class="films__items--header">SHAZAM! FURY OF THE GODS</h1>
                        <strong class="films__items--title">Genre: </strong> <span class="films__items--para films__items--type">Action, Adventure</span> </br>
                        <strong class="films__items--title">Running Time: </strong> <span class="films__items--para films__items--running-time">130 minutes</span></br>
                        <strong class="films__items--title">Release date: </strong> <span class="films__items--para films__items--release-date">Mar 17, 2023</span></br>
                        <button name="film__items--btn" class="films__items--btn">
                            <i class="fa-solid fa-ticket"></i>    
                            View details
                        </button>
                    </div>
                </a> -->

            </div>

            <!-- Upcoming -->
            <div id="films__upcoming" class="row block__films d-none">
            <?php
                foreach (getComingsoon() as $row){
                    $film_ID = $row['film_ID'];
                    $film_Name = $row['film_Name'];
                    $film_Photo = $row['film_photo'];
                    $film_Trailer = $row['film_trailer'];
                    $film_Genre = $row['film_Genre'];
                    $film_Running_time = $row['film_Running_time'];
                    $film_Release_date = $row['film_Release_date'];
            ?>
                    <a id="<?= $film_ID ?>" href="?page=describe&filmID=<?php echo $film_ID ?>" class="films__items col-l-4 col-md-6 col-sm-12">
                        <div class="films__items--inner">
                            <img class="films__items--img" src="<?php echo '/assets/img/'. $film_Photo ?>" alt="" srcset="">
                            <h1 class="films__items--header"><?php echo $film_Name ?></h1>
                            <strong class="films__items--title">Genre: </strong> <span class="films__items--para films__items--type"><?php echo $film_Genre ?></span> </br>
                            <strong class="films__items--title">Running Time: </strong> <span class="films__items--para films__items--running-time"><?php echo $film_Running_time ?></span></br>
                            <strong class="films__items--title">Release date: </strong> <span class="films__items--para films__items--release-date"><?php echo $film_Release_date ?></span></br>
                            <button name="film__items--btn" class="films__items--btn">
                                <i class="fa-solid fa-ticket"></i>
                                View Details
                            </button>
                        </div>
                    </a>
            <?php
                }
            ?>
            </div>

        </div>
    </div>
</body>