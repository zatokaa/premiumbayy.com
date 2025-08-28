<?php

  $sql_category = "SELECT COUNT(*) as num FROM tbl_category";
  $total_category = mysqli_query($connect, $sql_category);
  $total_category = mysqli_fetch_array($total_category);
  $total_category = $total_category['num'];

  $sql_wallpaper = "SELECT COUNT(*) as num FROM tbl_gallery";
  $total_wallpaper = mysqli_query($connect, $sql_wallpaper);
  $total_wallpaper = mysqli_fetch_array($total_wallpaper);
  $total_wallpaper = $total_wallpaper['num'];

?>

    <section class="content">

    <ol class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li class="active">Home</a></li>
    </ol>

        <div class="container-fluid">
             
             <div class="row">

                <a href="manage-category.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">MANAGE CATEGORY</div>
                            <div class="color-name"><i class="material-icons">people</i></div>
                            <div class="color-class-name">Total ( <?php echo $total_category; ?> ) Categories</div>
                            <br>
                        </div>
                    </div>
                </a>

               <a href="manage-wallpaper.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">MANAGE WALLPAPER</div>
                            <div class="color-name"><i class="material-icons">image</i></div>
                            <div class="color-class-name">Total ( <?php echo $total_wallpaper; ?> ) Wallpapers</div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="members.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">ADMINISTRATOR</div>
                            <div class="color-name"><i class="material-icons">people</i></div>
                            <div class="color-class-name">Admin Panel Privileges</div>
                            <br>
                        </div>
                    </div>
                </a>

                <a href="settings.php">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="card demo-color-box bg-blue waves-effect col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <br>
                            <div class="color-name">SETTINGS</div>
                            <div class="color-name"><i class="material-icons">settings</i></div>
                            <div class="color-class-name">Key and Privacy Settings</div>
                            <br>
                        </div>
                    </div>
                </a>

            </div>
            
        </div>

    </section>