<?php 
    include('public/fcm.php');
	require_once("public/thumbnail_images.class.php");

	if(isset($_GET['id'])) {
 		$qry 	= "SELECT * FROM tbl_gallery WHERE id ='".$_GET['id']."'";
		$result = mysqli_query($connect, $qry);
		$row 	= mysqli_fetch_assoc($result);
 	}

	if(isset($_POST['submit'])) {

		if ($_POST['upload_type'] == 'url') {

			$wallpaper_image = '';
			$image_url = $_POST['image_url'];
			if ($row['image'] != '') {
				unlink('upload/'.$_POST['old_image']);
			}			

		} else {

			if ($_POST['tags'] == '') {
                $sql = "SELECT * FROM tbl_category where cid = '".$_POST['cat_id']."'";
                $result = mysqli_query($connect, $sql);
                $row = mysqli_fetch_assoc($result);
                $tags = $row['category_name'];
            } else {
                $tags = $_POST['tags'];
            }

			if ($_FILES['wallpaper_image']['name'] != '') {
				unlink('upload/'.$_POST['old_image']);
				$wallpaper_image = time().'_'.$_FILES['wallpaper_image']['name'];
				$pic2			 = $_FILES['wallpaper_image']['tmp_name'];
   				$tpath2			 = 'upload/'.$wallpaper_image;
				copy($pic2, $tpath2);
			} else {
				$wallpaper_image = $_POST['old_image'];
			}

			$image_url = '';

		}
 
		$data = array(											 
			'cat_id'  	=> $_POST['cat_id'],
			'image' 	=> $wallpaper_image,
			'image_url' => $image_url,
			'tags' 		=> $tags,
			'type' 		=> $_POST['upload_type']
		);	

		$hasil = Update('tbl_gallery', $data, "WHERE id = '".$_POST['id']."'");

		if ($hasil > 0) {
        $succes =<<<EOF
            <script>
                alert('Wallpaper Updated Successfully...');
                window.location = 'manage-wallpaper.php';
            </script>
EOF;
        echo $succes;
			exit;
		}

	}

 	$sql_query = "SELECT * FROM tbl_category";
	$ringtone_qry_cat = mysqli_query($connect, $sql_query);

?>

<script src="assets/js/ckeditor/ckeditor.js"></script>
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>

<script type="text/javascript">

$(document).ready(function(e) {
    $("#upload_type").change(function() {
	var type=$("#upload_type").val();

		if (type == "url") {
			$("#upload").hide();
			$("#url").show();
		}

		if (type == "upload") {
			$("#url").hide();
			$("#upload").show();
		}	

	});

	$( window ).load(function() {
		var type=$("#upload_type").val();

		if (type == "url") {
			$("#upload").hide();
			$("#url").show();
		}

		if (type == "upload") {
			$("#url").hide();
			$("#upload").show();
		}

	});

});	

</script>

   <section class="content">
   
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage-wallpaper.php">Manage Wallpaper</a></li>
            <li class="active">Edit Wallpaper</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form id="form_validation" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="header">
                            <h2>EDIT WALLPAPER</h2> 
                        </div>
                        <div class="body">

                        	<div class="row clearfix">
                            	<div class="col-md-12">

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Category</div>
                                        <select class="form-control show-tick" name="cat_id" id="cat_id">
                                           <?php 	
												while ($r_c_row = mysqli_fetch_array($ringtone_qry_cat)) {
													$sel = '';
													if ($r_c_row['cid'] == $row['cat_id']) {
													$sel = "selected";	
												}	
											?>
										    <option value="<?php echo $r_c_row['cid'];?>" <?php echo $sel; ?>><?php echo $r_c_row['category_name'];?></option>
										        <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Image Type</div>
                                        <select class="form-control show-tick" name="upload_type" id="upload_type">
										    <option <?php if($row['type'] == 'upload'){ echo 'selected';} ?> value="upload">Upload</option>
										    <option <?php if($row['type'] == 'url'){ echo 'selected';} ?> value="url">Image URL</option>
                                        </select>
                                    </div>                                    

                                    <div id="upload" class="col-sm-6">
	                                    <div class="font-12 ex1">Image ( jpg / png )</div>
	                                    <div class="form-group">
	                                        <input type="file" name="wallpaper_image" id="wallpaper_image" class="dropify-image" data-max-file-size="3M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/<?php echo $row['image']; ?>" data-show-remove="false"/>
	                                    </div>
	                                    <div class="font-13 ex1">( Recommended resolution : 480x854 or 720x1280 or 1080x1980 pixels)</div>
                                    </div>                                

                                    <div id="url">
                                        <div class="form-group col-sm-12">
                                            <div class="font-12">Image URL</div>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="image_url" id="image_url" placeholder="http://www.abc.com/image_name.jpg" value="<?php echo $row['image_url']; ?>" required/>
                                            </div>
                                        </div>
                                    	<div class="col-sm-6">
                                    		<?php if ($row['image_url'] != '') { ?>
	                                    	<div class="font-12 ex1">Image Preview</div>
	                                    	<div class="form-group">
		                                        <input type="file" class="dropify-image" data-max-file-size="3M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="<?php echo $row['image_url']; ?>" data-show-remove="false" disabled/>
		                                    </div>
		                                    <?php } else { } ?>
	                                	</div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Tags (Optional)</div>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="tags" id="tags" data-role="tagsinput" value="<?php echo $row['tags']; ?>" required/>
                                        </div>
                                    </div>                                     

								    <input type="hidden" name="old_image" value="<?php echo $row['image'];?>">
									<input type="hidden" name="id" value="<?php echo $row['id'];?>">

	                                <div class="col-sm-12">
	                                    <button type="submit" name="submit" class="btn bg-blue waves-effect pull-right ">SUBMIT</button>
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