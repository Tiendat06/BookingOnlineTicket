<body>
    <div id="bg--outside__cluster" class="bg--outside bg--outside__cluster">
        <div class="container cluster__container">
            <div class="row">
                <div class="site">
                    
                    <div class="site_top"></div>
                
                    <div class = "site_content">
                        <div class="site_content--title">
                            <h1>CINEMAS</h1>
                        </div>
                            
                        <div class="site_content--area">
                            <ul>   
                                <?php
                                    foreach (getAll_Area() as $row){
                                        $area_ID = $row['area_ID'];
                                        $area_Name = $row['area_Name'];
                                        ?>
                                        <li class = 'area' id = '<?=$area_ID?>' onclick='showClusters(this.id)'><?php echo $area_Name?></li>
                                    <?php
                                    }
                                ?>
                                <li class ='area' id ='soon' onclick='showClusters(this.id)'>Đà Nẵng</li>
                            </ul>
                        </div>

                        <div class="site_content--clusters">
                            <ul>
                                <?php
                                    foreach (getAll_Cluster() as $row){
                                        $cluster_Name = $row['cluster_Name'];
                                        $cluster_ID = $row['cluster_ID'];
                                        $area_ID = $row['area_ID'];
                                        ?>
                                        <!-- onClickCluster(this.id) -->
                                        <li onclick="onClickCluster(this.id)" class = "<?= 'cluster '.$area_ID ?>" id = '<?=$cluster_ID?>' style='display: none'>
                                        <input type="hidden" id="input__<?= $cluster_ID ?>" value="<?= $cluster_ID ?>" name="">
                                            <?php echo $cluster_Name?>
                                        </li>
                                <?php
                                    }
                                ?>
                                <input type="hidden" name="" id="input__cluster" value="">
                                <li class ='cluster soon' style='display: none'>Coming soon</li>
                            </ul>
                        </div>
                    </div>

                    <div class="site_bottom"></div>  
                    <?php
                        include('booking.php');
                    ?>

                </div>
            </div>
        </div>
    </div>
</body>
