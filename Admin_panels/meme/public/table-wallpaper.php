<?php
	include 'functions.php';
	include 'fcm.php';
?>

<?php 

    if (isset($_GET['add'])) {
		$data = array('featured' => 'yes');	
		$hasil = Update('tbl_gallery', $data, "WHERE id = '".$_GET['add']."'");
		if ($hasil > 0) {
			//$_SESSION['msg'] = "";
			header( "Location:manage-wallpaper.php");
			exit;
		}
    }

    if (isset($_GET['remove'])) {
		$data = array('featured' => 'no');	
		$hasil = Update('tbl_gallery', $data, "WHERE id = '".$_GET['remove']."'");
		if ($hasil > 0) {
			//$_SESSION['msg'] = "";
			header( "Location:manage-wallpaper.php");
			exit;
		}
    }

?>

	<?php 
		// create object of functions class
		$function = new functions;
		
		// create array variable to store data from database
		$data = array();
		
		if(isset($_GET['keyword'])) {	
			// check value of keyword variable
			$keyword = $function->sanitize($_GET['keyword']);
			$bind_keyword = "%".$keyword."%";
		} else {
			$keyword = "";
			$bind_keyword = $keyword;
		}
			
		if (empty($keyword)) {
			$sql_query = "SELECT id, image, image_url, type, category_name, featured, view_count, download_count FROM tbl_gallery m, tbl_category c
					WHERE m.cat_id = c.cid  
					ORDER BY m.id DESC";
		} else {
			$sql_query = "SELECT id, image, image_url, type, category_name, featured, view_count, download_count FROM tbl_gallery m, tbl_category c
					WHERE m.cat_id = c.cid AND category_name LIKE ? 
					ORDER BY m.id DESC";
		}
		
		
		$stmt = $connect->stmt_init();
		if ($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			if (!empty($keyword)) {
				$stmt->bind_param('s', $bind_keyword);
			}
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result( 
					$data['id'],
					$data['image'],
					$data['image_url'],
					$data['type'],
					$data['category_name'],
					$data['featured'],
					$data['view_count'],
					$data['download_count']
					);
			// get total records
			$total_records = $stmt->num_rows;
		}
			
		// check page parameter
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
						
		// number of data that will be display per page		
		$offset = 10;
						
		//lets calculate the LIMIT for SQL, and save it $from
		if ($page) {
			$from 	= ($page * $offset) - $offset;
		} else {
			//if nothing was given in page request, lets load the first page
			$from = 0;	
		}	
		
		if (empty($keyword)) {
			$sql_query = "SELECT id, image, image_url, type, category_name, featured, view_count, download_count FROM tbl_gallery m, tbl_category c
					WHERE m.cat_id = c.cid  
					ORDER BY m.id DESC LIMIT ?, ?";
		} else {
			$sql_query = "SELECT id, image, image_url, type, category_name, featured, view_count, download_count FROM tbl_gallery m, tbl_category c
					WHERE m.cat_id = c.cid AND category_name LIKE ? 
					ORDER BY m.id DESC LIMIT ?, ?";
		}
		
		$stmt_paging = $connect->stmt_init();
		if ($stmt_paging ->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			if (empty($keyword)) {
				$stmt_paging ->bind_param('ss', $from, $offset);
			} else {
				$stmt_paging ->bind_param('sss', $bind_keyword, $from, $offset);
			}
			// Execute query
			$stmt_paging ->execute();
			// store result 
			$stmt_paging ->store_result();
			$stmt_paging->bind_result(
				$data['id'],
				$data['image'],
				$data['image_url'],
				$data['type'],
				$data['category_name'],
				$data['featured'],
				$data['view_count'],
				$data['download_count']
			);
			// for paging purpose
			$total_records_paging = $total_records; 
		}

		// if no data on database show "No Reservation is Available"
		if ($total_records_paging == 0) {
	
	?>

    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Manage Wallpaper</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>MANAGE WALLPAPER</h2>
                            <div class="header-dropdown m-r--5">
                                <a href="add-wallpaper.php"><button type="button" class="btn bg-blue waves-effect">ADD NEW WALLPAPER</button></a>
                            </div>
                        </div>

                        <div class="body table-responsive">
	                        
	                        <form method="get">
	                        	<div class="col-sm-10">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="text" class="form-control" name="keyword" placeholder="Search by category name...">
										</div>
									</div>
								</div>
								<div class="col-sm-2">
					                <button type="submit" name="btnSearch" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button>
								</div>
							</form>
										
							<table class='table table-hover table-striped'>
								<thead>
									<tr>
										<th>Image</th>
										<th>Category</th>
										<th>Action</th>
									</tr>
								</thead>

								
							</table>

							<div class="col-sm-10">Wopps! No data found with the keyword you entered.</div>

						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<?php 
		// otherwise, show data
		} else {
			$row_number = $from + 1;
	?>

    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Manage Wallpaper</a></li>
        </ol>

       <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>MANAGE WALLPAPER</h2>
                            <div class="header-dropdown m-r--5">
                                <a href="add-wallpaper.php"><button type="button" class="btn bg-blue waves-effect">ADD NEW WALLPAPER</button></a>
                            </div>
                        </div>

                        <div class="body table-responsive">
	                        
	                        <form method="get">
	                        	<div class="col-sm-10">
									<div class="form-group form-float">
										<div class="form-line">
											<input type="text" class="form-control" name="keyword" placeholder="Search by category name...">
										</div>
									</div>
								</div>
								<div class="col-sm-2">
					                <button type="submit" name="btnSearch" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">search</i></button>
								</div>
							</form>
										
							<table class='table table-hover table-striped'>
								<thead>
									<tr>
										<th>Image</th>
										<th>Category</th>
										<th><div align="center">Type</div></th>
										<th><div align="center">Featured</div></th>
										<th><div align="center">Views</div></th>
										<th><div align="center">Downloads</div></th>
										<th><center>Action</center></th>
									</tr>
								</thead>

								<?php 
									while ($stmt_paging->fetch()) { ?>
										<tr>
							            	<td>
							            		<?php if ($data['type'] == 'url') { ?>
							            			<img src="<?php echo $data['image_url'];?>" height="64px" width="40px"/>
							            		<?php } else { ?>
							            			<img src="upload/<?php echo $data['image'];?>" height="64px" width="40px"/>
							            		<?php } ?>
							            	</td>

											<td><?php echo $data['category_name'];?></td>

											<td align="center">
							            		<?php if ($data['type'] == 'url') { ?>
							            			<span class="label bg-orange">&nbsp;URL&nbsp;</span>
							            		<?php } else { ?>
							            			<span class="label bg-green">UPLOAD</span>
							            		<?php } ?>
							            	</td>

							            	<td align="center">
							            		<?php if ($data['featured'] == 'no') { ?>
							            			<a href="manage-wallpaper.php?add=<?php echo $data['id'];?>" onclick="return confirm('Add to featured wallpaper?')" ><span class="label bg-grey">NO</span></a>
							            		<?php } else { ?>
							            			<a href="manage-wallpaper.php?remove=<?php echo $data['id'];?>" onclick="return confirm('Remove from featured wallpaper?')" ><span class="label bg-red">YES</span></a>
							            		<?php } ?>
							            	</td>

							            	<td align="center"><?php echo $data['view_count'];?></td>
							            	<td align="center"><?php echo $data['download_count'];?></td>

											<td><center>

									            <a href="edit-wallpaper.php?id=<?php echo $data['id'];?>">
									                <i class="material-icons">mode_edit</i>
									            </a>
									                        
									            <a href="delete-wallpaper.php?id=<?php echo $data['id'];?>" onclick="return confirm('Are you sure want to delete this wallpaper?')" >
									                <i class="material-icons">delete</i>
									            </a></center>
									        </td>
										</tr>
								<?php 
									}
								?>
							</table>

							<h4><?php $function->doPages($offset, 'manage-wallpaper.php', '', $total_records, $keyword); ?></h4>
							<?php 
								}
							?>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>