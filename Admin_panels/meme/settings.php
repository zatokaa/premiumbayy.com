<?php include('session.php'); ?>
<?php include("public/menubar.php"); ?>
<link href="assets/css/bootstrap-select.css" rel="stylesheet">
<script src="assets/js/ckeditor/ckeditor.js"></script>
<style>
div.ex1 {
    margin-bottom: 8px;
}
</style>

<?php

    include('public/fcm.php');

	$qry = "SELECT * FROM tbl_settings where id = '1'";
	$result = mysqli_query($connect, $qry);
	$settings_row = mysqli_fetch_assoc($result);

	if(isset($_POST['submit'])) {

	    $sql_query = "SELECT * FROM tbl_settings WHERE id = '1'";
	    $img_res = mysqli_query($connect, $sql_query);
	    $img_row=  mysqli_fetch_assoc($img_res);

	    $data = array(
            'limit_recent_wallpaper' => $_POST['limit_recent_wallpaper'],
            'category_sort' => $_POST['category_sort'],
            'category_order' => $_POST['category_order'],
            'onesignal_app_id' => $_POST['onesignal_app_id'],
            'onesignal_rest_api_key' => $_POST['onesignal_rest_api_key'],
            'protocol_type' => $_POST['protocol_type'],
            'privacy_policy' => $_POST['privacy_policy']
	    );

	    $update_setting = Update('tbl_settings', $data, "WHERE id = '1'");

	    if ($update_setting > 0) {
	        $_SESSION['msg'] = "";
	        header( "Location:settings.php");
	        exit;
	    }
	}

?>


    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Settings</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="header">
                            <h2>SETTINGS</h2>
                            <div class="header-dropdown m-r--5">
                                <button type="submit" name="submit" class="btn bg-blue waves-effect">SAVE SETTINGS</button>
                            </div>
                                <?php if(isset($_SESSION['msg'])) { ?>
                                    <br><div class='alert alert-info'>Successfully Saved...</div>
                                    <?php unset($_SESSION['msg']); } ?>
                        </div>
                        <div class="body">

                        	<div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Limit Load More
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12">Limit Load More</div>
                                            <input type="number" class="form-control" name="limit_recent_wallpaper" id="limit_recent_wallpaper" value="<?php echo $settings_row['limit_recent_wallpaper'];?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Category Order
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12">Category Order</div>
                                            <select name="category_sort" id="category_sort" class="form-control show-tick">
                                                <option value="cid" <?php if($settings_row['category_sort']=='cid'){?>selected<?php }?>>ID</option>
                                                <option value="category_name" <?php if($settings_row['category_sort']=='category_name'){?>selected<?php }?>>Name</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12">Category Order</div>
                                            <select name="category_order" id="category_order" class="form-control show-tick">
                                                <option value="ASC" <?php if($settings_row['category_order']=='ASC'){?>selected<?php }?>>ASC</option>
                                                <option value="DESC" <?php if($settings_row['category_order']=='DESC'){?>selected<?php }?>>DESC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>OneSignal APP ID</b>
                                        <br>
                                        <a href="" data-toggle="modal" data-target="#modal-onesignal">Where do I get my OneSignal app id?</a>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12">OneSignal APP ID</div>
                                            <input type="text" class="form-control" name="onesignal_app_id" id="onesignal_app_id" value="<?php echo $settings_row['onesignal_app_id'];?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>OneSignal Rest API Key</b>
                                        <br>
                                        <a href="" data-toggle="modal" data-target="#modal-onesignal">Where do I get my OneSignal Rest API Key?</a>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12">OneSignal Rest API Key</div>
                                            <input type="text" class="form-control" name="onesignal_rest_api_key" id="onesignal_rest_api_key" value="<?php echo $settings_row['onesignal_rest_api_key'];?>" required>
                                        </div>
                                    </div>
                                </div>

                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Privacy Policy</b>
                                        <br>
                                        <font color="#337ab7">This privacy policy will be displayed in your android app</font>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12">Privacy Policy</div>
                                            <textarea class="form-control" name="privacy_policy" id="privacy_policy" class="form-control" cols="60" rows="10" required><?php echo $settings_row['privacy_policy'];?></textarea>

                                            <?php if ($ENABLE_RTL_MODE == 'true') { ?>
                                            <script>                             
                                                CKEDITOR.replace( 'privacy_policy' );
                                                CKEDITOR.config.contentsLangDirection = 'rtl';
                                            </script>
                                            <?php } else { ?>
                                            <script>                             
                                                CKEDITOR.replace( 'privacy_policy' );
                                            </script>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>                                                             

                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
            
        </div>

    </section>


<?php include('public/footer.php'); ?>