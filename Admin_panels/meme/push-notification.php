<?php include('session.php'); ?>
<?php include('public/menubar.php'); ?>

<?php


  $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
  $setting_result = mysqli_query($connect, $setting_qry);
  $settings_row   = mysqli_fetch_assoc($setting_result);

  $onesignal_app_id = $settings_row['onesignal_app_id']; 
  $onesignal_rest_api_key = $settings_row['onesignal_rest_api_key'];
  //$protocol_type = $settings_row['protocol_type'];

  define("ONESIGNAL_APP_ID", $onesignal_app_id);
  define("ONESIGNAL_REST_KEY", $onesignal_rest_api_key);
 
  if (isset($_POST['submit'])) {

        $cat_name = '';

	    if ($_POST['external_link'] != "") {
	    	$external_link = $_POST['external_link'];
	    } else {
	        $external_link = "no_url";
	    } 

        $targetFile = 'upload/notification/' . basename($_FILES["file"]["name"]);

    move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
        //$big_image = "https://www.ssbwiki.com/images/thumb/2/23/HWL_Toon_Link_Artwork.png/1200px-HWL_Toon_Link_Artwork.png";
        $big_image = $protocol_type.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/'.$targetFile;
        

        $content = array(
                         "en" => $_POST['message']                                                 
                         );

        $fields = array(
                        'app_id' => ONESIGNAL_APP_ID,
                        'included_segments' => array('All'),                                            
                        'data' => array("foo" => "bar","cat_id"=> "0","cat_name"=>$cat_name, "external_link"=>$external_link),
                        'headings'=> array("en" => $_POST['title']),
                        'contents' => $content,
                        'big_picture' => 'http://'.$big_image       
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
        
        $_SESSION['msg'] = "Congratulations, push notification sent...";
        header("Location:push-notification.php");
        exit; 

  }
  
  
?>

	<section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Send Notification</a></li>
        </ol>

        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<form id="form_validation" method="post" enctype="multipart/form-data">
	                	<div class="card">
	                        <div class="header">
	                            <h2>SEND NOTIFICATION</h2>
                                <?php if(isset($_SESSION['msg'])) { ?>
                                    <div class='alert alert-info'>
                                        <?php echo $_SESSION['msg']; ?>
                                    </div>
                                <?php unset($_SESSION['msg']); }?>	                            
	                        </div>
	                        <div class="body">

	                        	<div class="row clearfix">

			                        <div class="form-group form-float col-sm-12">
			                            <div class="form-line">
			                                <input type="text" class="form-control" name="title" id="title" required>
			                                <label class="form-label">Title</label>
			                            </div>
			                       	</div>

			                       	<div class="form-group form-float col-sm-12">
			                            <div class="form-line">
			                                <input type="text" class="form-control" name="message" id="message" required>
			                                <label class="form-label">Message</label>
			                            </div>
			                       	</div>

                                    <div class="form-group form-float col-sm-12">
			                            <div class="form-line">
			                                <input type="text" class="form-control" name="external_link" id="external_link" >
			                                <label class="form-label">Url (Optional)</label>
			                            </div>
			                       	</div>
			                       	
			                       	 <div class="col-sm-6" id="upload">
                                        <div class="font-12 ex1">Image ( jpg / png )</div>
                                        <div class="form-group">
                                            <input type="file" name="file" id="file" />
                                        </div>
                                        <div class="font-13 ex1">( Recommended resolution : 480x854 or 720x1280 or 1080x1980 pixels)</div>
                                    </div>
			                       	
			                       	<input type="hidden" name="id" id="id" value="0" />
                                    
                                    <div class="col-sm-12">
                                		<button class="btn bg-blue waves-effect pull-right" type="submit" name="submit">SEND NOW</button>
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