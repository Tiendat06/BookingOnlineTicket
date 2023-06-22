<body>

<div class="manage-user">
        <!-- <form onsubmit="" action="" method="post"> -->

            <h1 class="manage-film__title manage-user__title">MANAGE FILM</h1>

            <div class="manage-film__bar">
                
                <input placeholder="Search Film On All" type="text" name="" id="search-input" class="manage-film__input">
                <div class="manage-film__btn">
                    <a href="?page=manage_film_add_film" class="manage-film__add manage-film__add-film">Add Film</a>
                </div>
            </div>

            <table id="table" class="manage-user__table">
                <tbody id="tbody" class="manage-film__tbody manage-user__tbody">
                    <tr class="manage-film__tr-main manage-user__tr">
                        <th class="manage-film__th manage-user__th">ID</th>
                        <th class="manage-film__th manage-user__th">Name</th>
                        <!-- <th class="manage-film__th manage-user__th">Director</th>
                        <th class="manage-film__th manage-user__th">Cast</th> -->
                        <th class="manage-film__th manage-user__th">Genre</th>
                        <th class="manage-film__th manage-user__th">Running_Time</th>
                        <th class="manage-film__th manage-user__th">Realease_Date</th>
                        <!-- <th class="manage-film__th manage-user__th">Describe</th> -->
                        <!-- <th class="manage-film__th manage-user__th">Language</th> -->
                        <!-- <th class="manage-film__th manage-user__th">Rated</th> -->
                        <th class="manage-film__th manage-user__th">Edit</th>
                        <th class="manage-film__th manage-user__th">Delete</th>
                        <th class="manage-film__th manage-user__th">Add Showtime</th>
                        <th class="manage-film__th manage-user__th">More Info</th>
                        <th class="manage-film__th manage-user__th">Add Film Type</th>
                    </tr>
    
                    <?php
                        foreach (getAllFilm() as $row){
                            $film_ID = $row['film_ID'];
                            $film_Name = $row['film_Name'];
                            $film_Director = $row['film_Director'];
                            $film_Cast = $row['film_Cast'];
                            $film_Genre = $row['film_Genre'];
                            $film_Running_time = $row['film_Running_time'];
                            $film_released= $row['film_Release_date'];
                            $film_Describe= $row['film_Description'];
                            $film_Language= $row['film_Language'];
                            $film_Rated= $row['film_Rated'];
                            $film_photo= $row['film_photo'];
                            $film_trailer= $row['film_trailer'];
                            $film_slider= $row['film_Slider'];

                    ?>
                        <tr id="manage-film__tr" class="manage-film__tr">

                            <td title="<?= $film_ID ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $film_ID ?></p>
                            </td>
                            
                            <td title="<?= $film_Name ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $film_Name ?></p>
                            </td>

                            <td title="<?= $film_Genre ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $film_Genre ?></p>
                            </td>

                            <td title="<?= $film_Running_time ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= $film_Running_time ?></p>
                            </td>

                            <td title="<?= $film_released ?>" class="manage-film__td manage-user__td">
                                <p class="manage-film__para"><?= dayReverse($film_released) ?></p>
                            </td>

                            <td class="manage-user__td">
                                <a href="?page=manage_film_edit&filmID=<?= $film_ID ?>" id="" class="manage-user__btn">
                                    <i class="manage-user__icon fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>

                            <td id="" class="manage-user__td">
                                <!-- onClickDelete(this.id) -->
                                <div onclick="onClickDeleteFilm(this.id)" id="<?= $film_ID ?>" class="manage-user__btn">
                                    <i class="manage-user__icon fa-solid fa-trash"></i>
                                </div>
                            </td>

                            <td class="manage-user__td">
                                <a href="?page=manage_film_addsht&filmID=<?= $film_ID ?>" id="" class="manage-user__btn">
                                    <i class="manage-user__icon fa-sharp fa-solid fa-calendar-plus"></i>
                                </a>
                            </td>
                            <td class="manage-user__td">
                                <a href="?page=manage_film_info&filmID=<?= $film_ID ?>" id="" class="manage-user__btn">
                                    <i class="manage-user__icon fa-solid fa-circle-info"></i>
                                </a>
                            </td>

                            <td class="manage-user__td">
                                <div onclick="onClickAddFilmType(this.id)" id="<?= $film_ID ?>" class="manage-user__btn">
                                    <!-- <i class="manage-user__icon fa-solid fa-circle-info"></i> -->
                                    <!-- <i class="manage-user__icon fa-solid fa-video-plus"></i> -->
                                    <i class="manage-user__icon fa-solid fa-plus"></i>

                                </div>
                            </td>
                        </tr>                   
                    <?php
                        }
                        
                    ?>
                    <div id="div"></div>
                    <input type="hidden" id="manage-lock-btn" name="manage-lock-btn" value="">
                </tbody>

                <div onclick="onClickModal(this.id)" id="modal" class="modal d-none"></div>
                <!-- delete response -->
                <div id="delete-res" class="delete-res d-none">
                    <h1 id="delete-res__title" class="delete-res__title"></h1>
                    <div class="delete-res__site">
                        <a id="delete-res__link" class="delete-res__items" href="">Yes</a>
                        <a class="delete-res__items" href="?page=manage_film">No</a>
                    </div>
                </div>


                <div onclick="onClickModalAddType(this.id)" id="modal-add-type" class="modal d-none"></div>
                <div id="add-type" class="delete-res d-none">
                    <h1 id="add-type__title" class="delete-res__title"></h1>

                    <select name="select-type" class="manage-film__input--edit" id="select-type">
                        <?php
                            foreach(getAllFilmType() as $row){
                                $type = $row['type_Name'];
                                ?>
                                    <option value="<?= $type ?>"><?= $type ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    
                    <h1 id="add-type__title-done" class="delete-res__title"></h1>

                    <div class="delete-res__site">
                        <div style="cursor: pointer;" onclick="onClickYes()" id="add-type__link" class="delete-res__items">Yes</div>
                        <a class="delete-res__items" href="?page=manage_film">No</a>
                    </div>
                </div>

            </table>

    </div>
  
</body>

<script>

    addFilmTypeAjax();

    searchFilm()
</script>








