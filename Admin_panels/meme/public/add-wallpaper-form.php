<?php

	require("public/fcm.php");
 
      $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
  $setting_result = mysqli_query($connect, $setting_qry);
  $settings_row   = mysqli_fetch_assoc($setting_result);

  $onesignal_app_id = $settings_row['onesignal_app_id']; 
  $onesignal_rest_api_key = $settings_row['onesignal_rest_api_key'];
  //$protocol_type = $settings_row['protocol_type'];

  define("ONESIGNAL_APP_ID", $onesignal_app_id);
  define("ONESIGNAL_REST_KEY", $onesignal_rest_api_key);
 
	$cat_qry = "SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result = mysqli_query($connect, $cat_qry); 
	
	if(isset($_POST['submit'])) {

        if ($_POST['upload_type'] == 'url') {

            if ($_POST['tags'] == '') {
                $sql = "SELECT * FROM tbl_category where cid = '".$_POST['cat_id']."'";
                $result = mysqli_query($connect, $sql);
                $row = mysqli_fetch_assoc($result);
                $tags = $row['category_name'];
            } else {
                $tags = $_POST['tags'];
            }

            $data = array( 
                'cat_id'    => $_POST['cat_id'],
                'image'     => '',
                'image_url' => $_POST['image_url'],
                'tags'      => $tags,
                'type'      => $_POST['upload_type']
            );  

            $qry = Insert('tbl_gallery', $data);

        } else {

            if ($_POST['tags'] == '') {
                $sql = "SELECT * FROM tbl_category where cid = '".$_POST['cat_id']."'";
                $result = mysqli_query($connect, $sql);
                $row = mysqli_fetch_assoc($result);
                $tags = $row['category_name'];
            } else {
                $tags = $_POST['tags'];
            }

    		$count = count($_FILES['wallpaper_image']['name']);

    		for ($i = 0; $i < $count; $i++) {

    			$albumimgnm = rand(0,99999)."_".$_FILES['wallpaper_image']['name'][$i];
    			 		 
    			$tpath1 = 'upload/'.$albumimgnm;			 
    	        $pic1 = $_FILES["wallpaper_image"]["tmp_name"][$i];
    			$upload = move_uploaded_file($pic1, $tpath1);
    		 
    			//$thumbpath = 'upload/thumbs/'.$albumimgnm;				
    	        //$thumb_pic1 = create_thumb_image($tpath1, $thumbpath,'300','300');			   
    			//$date = date('Y-m-j');
    	          
    			$data = array( 
                    'cat_id'    => $_POST['cat_id'],
                    'image'     => $albumimgnm,
    				'image_url' => '',
                    'tags'      => $tags,
                    'type'      => $_POST['upload_type']
    			);	

    			$qry = Insert('tbl_gallery', $data);
    			
    			$big_image = "";
        //$big_image = $protocol_type.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/upload/notification/'.$data['image'];

        $content = array(
                         "en" => 'Notification'                                                 
                         );

        $fields = array(
                        'app_id' => ONESIGNAL_APP_ID,
                        'included_segments' => array('All'),                                            
                        'data' => array("foo" => "bar","cat_id"=> "0","cat_name"=>$_POST['cat_id'], "external_link"=>'$external_link'),
                        'headings'=> array("en" => 'New Images Uploaded'),
                        'contents' => $content,
                        'big_picture' => ''       
                        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.ONESIGNAL_REST_KEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);       
    			
     	    }

        }		

        $succes =<<<EOF
            <script>
                alert('New Wallpapers Added Successfully...');
                window.location = 'manage-wallpaper.php';
            </script>
EOF;
        echo $succes;
		exit;	
		 
	}
	  
?>

<script type="text/javascript">

    $(document).ready(function(e) {

        $("#upload_type").change(function() {
            var type = $("#upload_type").val();

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
            <li class="active">Add Wallpaper</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                	<form id="form_validation" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="header">
                            <h2>ADD WALLPAPER</h2>
                            <?php if (isset($_SESSION['msg'])) { ?> 
                                <br><div class="alert alert-info"><?php echo "Wallpaper Added Successfully..."; ?></div>
                            <?php unset($_SESSION['msg']); } ?>   
                        </div>
                        <div class="body">

                        	<div class="row clearfix">
                            <div class="col-md-12">

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Category</div>
                                        <select class="form-control show-tick" name="cat_id" id="cat_id">
		          							<?php
		          								while ($cat_row = mysqli_fetch_array($cat_result)) {
		          							?>          						 
		          								<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>					 
		          							<?php
		          								}
		          							?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Image Type</div>
                                        <select class="form-control show-tick" name="upload_type" id="upload_type">
                                                <option value="upload">Upload</option>
                                                <option value="url">Image URL</option>
                                        </select>
                                    </div>                                     

                                    <div class="col-sm-6" id="upload">
                                        <div class="font-12 ex1">Image ( jpg / png )</div>
                                        <div class="form-group">
                                            <input type="file" name="wallpaper_image[]" id="fileupload" class="dropify-image" data-max-file-size="3M" data-allowed-file-extensions="jpg jpeg png gif" multiple required/>
                                        </div>
                                        <div class="font-13 ex1">( Recommended resolution : 480x854 or 720x1280 or 1080x1980 pixels)</div>
                                    </div>

                                    <div id="url">
                                        <div class="form-group col-sm-12">
                                            <div class="font-12">Image URL</div>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="image_url" id="image_url" placeholder="http://www.abc.com/image_name.jpg" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <div class="font-12">Tags (Optional)</div>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="tags" id="tags" data-role="tagsinput" placeholder="add tags" required/>
                                        </div>
                                    </div>                                                            

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