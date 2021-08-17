<?php 
 function excs_system_func(){

 }

 function hexcs_system_db_func(){
 	global $wpdb;
 	$table_name = $wpdb->prefix . 'search_product';
 	if(isset($_GET['sync'])){
 		$all_ids = get_posts( array(
 		        'post_type' => 'product',
 		        'numberposts' => -1,
 		        'post_status' => 'publish',
 		        'fields' => 'ids',
 		   ) );
 		   foreach ( $all_ids as $id ) {
 		        if(check_if_available_cs($id)){

 		        }else{
 		        	$wpdb->insert($table_name, array(
 		        	    'product_id' => $id,
 		        	    'year_id' => -1,
 		        	    'make_id' => -1,
 		        	    'model_id' => -1,
 		        	    'drive_type_id' => -1,
 		        	));
 		        }
 		   }
 		   echo "success";
 	}else{
 		include dirname(dirname(__FILE__)).'/templates/excs_sync_html.php';
 	}
 }

 function hexcs_system_year_func(){
 	global $wpdb;
 	$table_name = $wpdb->prefix . 'year';
 	if(isset($_GET['add'])){
 		if(isset($_POST['save'])){
 			$year = $_POST['year'];
 			$wpdb->insert($table_name, array(
        	    'title' => $year
        	));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-year');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		include dirname(dirname(__FILE__)).'/templates/excs_year_add_html.php';
 	}elseif(isset($_GET['edit'])){
 		$id = $_GET['id'];
 		if(isset($_POST['save'])){
 			$year = $_POST['year'];
 			$wpdb->update( $table_name, array(
 			    'title' => $year
 			),
 			array('id'=>$id));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-year');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = '$id'" );
 		include dirname(dirname(__FILE__)).'/templates/excs_year_edit_html.php';
 	}elseif(isset($_GET['delete'])){
 		$id = $_GET['id'];
 		$wpdb->delete( $table_name, array( 'id' => $id ) );
 		?>
		<script type="text/javascript">
			var url = "<?php echo admin_url('admin.php?page=excs-system-year');?>";
			window.location.href = url;
		</script>
		<?php
		exit;
 	}else{
 		$results = $wpdb->get_results( "SELECT * FROM $table_name" );
 		include dirname(dirname(__FILE__)).'/templates/excs_year_html.php';
 	}
 }
 function hexcs_system_make_func(){
 	global $wpdb;
 	$table_name = $wpdb->prefix . 'make';
 	$table_name2 = $wpdb->prefix . 'year';
 	if(isset($_GET['add'])){
 		if(isset($_POST['save'])){
 			$make = $_POST['make'];
 			$year = $_POST['year'];
 			$wpdb->insert($table_name, array(
        	    'title' => $make,
        	    'year_id' => $year,
        	));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-make');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		$years = $wpdb->get_results( "SELECT * FROM $table_name2" );
 		include dirname(dirname(__FILE__)).'/templates/excs_make_add_html.php';
 	}elseif(isset($_GET['edit'])){
 		$id = $_GET['id'];
 		if(isset($_POST['save'])){
 			$make = $_POST['make'];
 			$year = $_POST['year'];
 			$wpdb->update( $table_name, array(
 			    'title' => $make,
        	    'year_id' => $year,
 			),
 			array('id'=>$id));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-make');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = '$id'" );
 		$years = $wpdb->get_results( "SELECT * FROM $table_name2" );
 		include dirname(dirname(__FILE__)).'/templates/excs_make_edit_html.php';
 	}elseif(isset($_GET['delete'])){
 		$id = $_GET['id'];
 		$wpdb->delete( $table_name, array( 'id' => $id ) );
 		?>
		<script type="text/javascript">
			var url = "<?php echo admin_url('admin.php?page=excs-system-make');?>";
			window.location.href = url;
		</script>
		<?php
		exit;
 	}else{
 		if(isset($_GET['p'])){
			$current = $_GET['p'];	
		}else{
			$current = 1;
		}
		
		$totalQr = $wpdb->get_results( "SELECT id FROM $table_name " );
		$total = count($totalQr);
		$perPage = 20;
		$pages = ceil($total/$perPage);
		$both_side = 4;
		$start = $current-$both_side;
		if($start<1){
			$start = 1;
		}
		$end = $current+$both_side;
		if($end>$pages){
			$end = $pages;
		}
		$lim =($current-1)*$perPage;
		$i=$lim+1;
		//echo $i;
		$url = admin_url('admin.php?page=excs-system-make');
		$sql = "SELECT t1.*,t2.title as year FROM $table_name t1 LEFT JOIN $table_name2 as t2 ON t2.id = t1.year_id Limit $lim,$perPage";
 		$results = $wpdb->get_results( $sql);
 		include dirname(dirname(__FILE__)).'/templates/excs_make_html.php';
 	}
 }
 function hexcs_system_model_func(){
 	global $wpdb;
 	$table_name = $wpdb->prefix . 'model';
 	$table_name2 = $wpdb->prefix . 'year';
 	$table_name3 = $wpdb->prefix . 'make';
 	if(isset($_GET['add'])){
 		if(isset($_POST['save'])){
 			$make = $_POST['make'];
 			$model = $_POST['model'];
 			$year = $_POST['year'];
 			$wpdb->insert($table_name, array(
        	    'title' => $model,
        	    'year_id' => $year,
        	    'make_id' => $make,
        	));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-model');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		$years = $wpdb->get_results( "SELECT * FROM $table_name2" );
 		include dirname(dirname(__FILE__)).'/templates/excs_model_add_html.php';
 	}elseif(isset($_GET['edit'])){
 		$id = $_GET['id'];
 		if(isset($_POST['save'])){
 			$make = $_POST['make'];
 			$model = $_POST['model'];
 			$year = $_POST['year'];
 			$wpdb->update( $table_name, array(
 			    'title' => $model,
        	    'year_id' => $year,
        	    'make_id' => $make,
 			),
 			array('id'=>$id));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-model');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = '$id'" );
 		$years = $wpdb->get_results( "SELECT * FROM $table_name2" );
 		include dirname(dirname(__FILE__)).'/templates/excs_model_edit_html.php';
 	}elseif(isset($_GET['delete'])){
 		$id = $_GET['id'];
 		$wpdb->delete( $table_name, array( 'id' => $id ) );
 		?>
		<script type="text/javascript">
			var url = "<?php echo admin_url('admin.php?page=excs-system-model');?>";
			window.location.href = url;
		</script>
		<?php
		exit;
 	}else{
 		if(isset($_GET['p'])){
			$current = $_GET['p'];	
		}else{
			$current = 1;
		}
		
		$totalQr = $wpdb->get_results( "SELECT id FROM $table_name " );
		$total = count($totalQr);
		$perPage = 20;
		$pages = ceil($total/$perPage);
		$both_side = 4;
		$start = $current-$both_side;
		if($start<1){
			$start = 1;
		}
		$end = $current+$both_side;
		if($end>$pages){
			$end = $pages;
		}
		$lim =($current-1)*$perPage;
		$i=$lim+1;
		//echo $i;
		$url = admin_url('admin.php?page=excs-system-model');
		$sql = "SELECT t1.*,t2.title as year, mk.title as make FROM $table_name t1 LEFT JOIN $table_name2 as t2 ON t2.id = t1.year_id LEFT JOIN $table_name3 as mk on mk.id = t1.make_id Limit $lim,$perPage";
 		$results = $wpdb->get_results( $sql);
 		include dirname(dirname(__FILE__)).'/templates/excs_model_html.php';
 	}
 }
 function hexcs_system_drive_type_func(){
 	global $wpdb;
 	$table_name = $wpdb->prefix . 'drive_type';
 	$table_name2 = $wpdb->prefix . 'year';
 	$table_name3 = $wpdb->prefix . 'make';
 	$table_name4 = $wpdb->prefix . 'model';
 	if(isset($_GET['add'])){
 		if(isset($_POST['save'])){
 			$drive_type = $_POST['drive_type'];
 			$make = $_POST['make'];
 			$model = $_POST['model'];
 			$year = $_POST['year'];
 			$wpdb->insert($table_name, array(
        	    'title' => $drive_type,
        	    'year_id' => $year,
        	    'make_id' => $make,
        	    'model_id' => $model,
        	));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-drive-type');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		$years = $wpdb->get_results( "SELECT * FROM $table_name2" );
 		include dirname(dirname(__FILE__)).'/templates/excs_drive_type_add_html.php';
 	}elseif(isset($_GET['edit'])){
 		$id = $_GET['id'];
 		if(isset($_POST['save'])){
 			$drive_type = $_POST['drive_type'];
 			$make = $_POST['make'];
 			$model = $_POST['model'];
 			$year = $_POST['year'];
 			$wpdb->update( $table_name, array(
 			    'title' => $drive_type,
        	    'year_id' => $year,
        	    'make_id' => $make,
        	    'model_id' => $model,
 			),
 			array('id'=>$id));
        	?>
			<script type="text/javascript">
				var url = "<?php echo admin_url('admin.php?page=excs-system-drive-type');?>";
				window.location.href = url;
			</script>
			<?php
			exit;
 		}
 		$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = '$id'" );
 		$years = $wpdb->get_results( "SELECT * FROM $table_name2" );
 		include dirname(dirname(__FILE__)).'/templates/excs_drive_type_edit_html.php';
 	}elseif(isset($_GET['delete'])){
 		$id = $_GET['id'];
 		$wpdb->delete( $table_name, array( 'id' => $id ) );
 		?>
		<script type="text/javascript">
			var url = "<?php echo admin_url('admin.php?page=excs-system-drive-type');?>";
			window.location.href = url;
		</script>
		<?php
		exit;
 	}else{
 		if(isset($_GET['p'])){
			$current = $_GET['p'];	
		}else{
			$current = 1;
		}
		
		$totalQr = $wpdb->get_results( "SELECT id FROM $table_name " );
		$total = count($totalQr);
		$perPage = 20;
		$pages = ceil($total/$perPage);
		$both_side = 4;
		$start = $current-$both_side;
		if($start<1){
			$start = 1;
		}
		$end = $current+$both_side;
		if($end>$pages){
			$end = $pages;
		}
		$lim =($current-1)*$perPage;
		$i=$lim+1;
		//echo $i;
		$url = admin_url('admin.php?page=excs-system-drive-type');
		$sql = "SELECT t1.*,t2.title as year, mk.title as make, md.title as model FROM $table_name t1 LEFT JOIN $table_name2 as t2 ON t2.id = t1.year_id LEFT JOIN $table_name3 as mk on mk.id = t1.make_id LEFT JOIN $table_name4 as md on md.id = t1.model_id Limit $lim,$perPage";
 		$results = $wpdb->get_results( $sql);
 		include dirname(dirname(__FILE__)).'/templates/excs_drive_type_html.php';
 	}
 }
?>