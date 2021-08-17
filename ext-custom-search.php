<?php
/**
 * Plugin Name: EXTERNAL CUSTOM SEARCH
 * Plugin URI: http://www.tjthouhid.com
 * Description: EXTERNAL CUSTOM SEARCH
 * Version: 1.0.0
 * Author: Tj Thouhid
 * Author URI: https://tjthouhid.me
 * Text Domain: ext_cs
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: GPL2
 */

/**
 *
 */


/*
* Plugin Active
* Author : Tj Thouhid
* Date : 06-15-2020
*
 */
register_activation_hook( __FILE__, 'excs_install' );
function excs_install() {

    generate_extCs_table();
}


/*
* Plugin Deactive
* Author : Tj Thouhid
* Date : 06-15-2020
*
 */
register_deactivation_hook( __FILE__, 'excs_deactivation' );
function excs_deactivation() {
    delete_extCs_table();
}

/**
 * Extra Hour Addons table Create on Plugin Activate
 */
function generate_extCs_table(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();


    $table_name = $wpdb->prefix . 'year';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
             PRIMARY KEY  (id)
             ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    $table_name2 = $wpdb->prefix . 'make';
    $sql2 = "CREATE TABLE IF NOT EXISTS $table_name2 (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `year_id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
             PRIMARY KEY  (id)
             ) $charset_collate;";
    dbDelta( $sql2 );
    $table_name3 = $wpdb->prefix . 'model';
    $sql3 = "CREATE TABLE IF NOT EXISTS $table_name3 (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `year_id` int(11) NOT NULL,
            `make_id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
             PRIMARY KEY  (id)
             ) $charset_collate;";
    dbDelta( $sql3 );
    $table_name4 = $wpdb->prefix . 'drive_type';
    $sql4 = "CREATE TABLE IF NOT EXISTS $table_name4 (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `year_id` int(11) NOT NULL,
            `make_id` int(11) NOT NULL,
            `model_id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
             PRIMARY KEY  (id)
             ) $charset_collate;";
    dbDelta( $sql4 );
    $table_name5 = $wpdb->prefix . 'search_product';
    $sql5 = "CREATE TABLE IF NOT EXISTS $table_name5 (
            `id` int(25) NOT NULL AUTO_INCREMENT,
            `product_id` int(25) NOT NULL,
            `year_id` int(25) NOT NULL,
            `make_id` int(25) NOT NULL,
            `model_id` int(25) NOT NULL,
            `drive_type_id` int(25) NOT NULL,
             PRIMARY KEY  (id)
             ) $charset_collate;";
    dbDelta( $sql5 );
}


/**
 * Extra Hour Addons table Delete on Plugin Deactivate
 */
function delete_extCs_table(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'year';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

    $table_name2 = $wpdb->prefix . 'make';
    $sql2 = "DROP TABLE IF EXISTS $table_name2;";
    $wpdb->query($sql2);

    $table_name3 = $wpdb->prefix . 'model';
    $sql3 = "DROP TABLE IF EXISTS $table_name3;";
    $wpdb->query($sql3);

    $table_name4 = $wpdb->prefix . 'drive_type';
    $sql4 = "DROP TABLE IF EXISTS $table_name4;";
    $wpdb->query($sql4);

    $table_name5 = $wpdb->prefix . 'search_product';
    $sql5 = "DROP TABLE IF EXISTS $table_name5;";
    $wpdb->query($sql5);
}

function custom_product_search_mb() {

    add_meta_box(
        'custom-search-info',
        __( 'Custom Search Info', '' ),
        'custom_product_search_mb_func',
        'product'
    );
}

add_action( 'add_meta_boxes', 'custom_product_search_mb' );

function custom_product_search_mb_func(){
	global $wpdb;
	$product_id = get_the_ID();
	$table_name = $wpdb->prefix . 'year';
	$sql = "SELECT * FROM  $table_name";
	$results = $wpdb->get_results($sql);


	$if_add = check_if_available_cs($product_id);
	$year_selected = -1;
	$make_selected = -1;
	$mode_selected = -1;
	$drive_selected = -1;
	//echo "<pre>";print_r($if_add);echo "</pre>";
?>
<style type="text/css">
	.sf{
		width: 20%;
	    display: inline-block;
	    margin-right: 10px;
	    padding: 5px 24px 5px 8px !important;
	}
	.option-box{
		position: relative;
		margin: 10px 0px;
	}
	.has-loading{}
	.has-loading::before{
		content: "";
	    position: absolute;
	    background-color: rgba(0,0,0,0.7);
	    width: 100%;
	    top: 0px;
	    bottom: 0px;
	    display: block;
	}
	.loading{
		color: white;
	    position: absolute;
	    top: 5px;
	    left: 0px;
	    text-align: center;
	    width: 100%;
	    display: none;
	}
	.has-loading .loading{display: block;}
	.add_more_btn{
		text-decoration: none;
	    border: 1px solid blue;
	    color: blue;
	    padding: 4px 10px;
	    margin-top: 20px;
	    display: inline-block;
	}
	.add_more_btn:hover{
		color: #fff;
		background-color: blue;
	}
	.remove_more_btn{
		text-decoration: none;
	    border: 1px solid #e2340d;
	    color: #e2340d;
	    padding: 7px 15px;
	    display: inline-block;
	}
	.remove_more_btn:hover{
		color: #fff;
		background-color: #e2340d;
	}
</style>
<script type="text/javascript">
	jQuery(function($){
		var $year = $(".ex_year");
		var $make = $(".ex_make");
		var $mode = $(".ex_mode");
		var $drive_type = $(".ex_drive_type");

		var year_selected = <?php echo $year_selected;?>;
		var make_selected = <?php echo $make_selected;?>;
		var mode_selected = <?php echo $mode_selected;?>;
		var drive_selected = <?php echo $drive_selected;?>;
		if(year_selected !== -1){
			//getMake(year_selected,make_selected);
			year_selected = -1;
			make_selected = -1;

		}
		//$year.trigger('change');
		function getMake($this,year,selected){
			startLoading($this);
			var data = {
                action : 'getMake',
                year : year,
                selected : selected,

            };
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' );?>',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(data) {
				make = $this.closest('.option-box').find('.ex_make');
				if(data.type=="success"){
					make.html(data.res);
				}
				endLoading($this);
				make.trigger('change');
				//console.log(data);
			})
			.fail(function() {
				console.log("error");
			});
			
		}

		function getMode($this,make,selected){
			startLoading($this);
			var data = {
                action : 'getMode',
                make : make,
                selected : selected,

            };
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' );?>',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(data) {
				mode = $this.closest('.option-box').find('.ex_mode');
				if(data.type=="success"){
					mode.html(data.res);
				}
				endLoading($this);
				mode.trigger('change');
				//console.log(data);
			})
			.fail(function() {
				console.log("error");
			});
			
		}
		function getDriveType($this,mode,selected){
			startLoading($this);
			var data = {
                action : 'getDriveType',
                mode : mode,
                selected : selected,

            };
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' );?>',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(data) {
				drive_type = $this.closest('.option-box').find('.ex_drive_type');
				if(data.type=="success"){
					drive_type.html(data.res);
				}
				endLoading($this);
				//console.log(data);
			})
			.fail(function() {
				console.log("error");
			});
			
		}

		$("body").on("change",".ex_year",function(){
			var year = $(this).val();
			//console.log($(this))
			getMake($(this),year,make_selected);
			make_selected = -1;

		});
		$("body").on("change",".ex_make",function(){
			var make = $(this).val();
			getMode($(this),make,mode_selected);
			mode_selected = -1;

		});
		$("body").on("change",".ex_mode",function(){
			var mode = $(this).val();
			getDriveType($(this),mode,drive_selected);
			drive_selected = -1;

		});
		function startLoading($this){
			//console.log($this)
			$this.closest(".option-box").addClass('has-loading');
		}
		function endLoading($this){
			//console.log($this)
			$this.closest(".option-box").removeClass('has-loading');
		}

		$optionBox = '<div class="option-box">';
		$optionBox += '<select class="sf ex_year" name="ex_year[]">';
		$optionBox += '<option value="-1">Year</option>;'
		$optionBox += '<?php if(count($results)>0){foreach ($results as $result) { ?>';
		$optionBox += '<option value="<?php echo $result->id;?>" <?php if($year_selected==$result->id){ echo "selected";}?>><?php echo $result->title;?></option>';
		$optionBox += '<?php }}?>';
		$optionBox += '</select>';
		$optionBox += '<select class="sf ex_make" name="ex_make[]">';
		$optionBox += '<option value="-1">Make</option>';
		$optionBox += '</select>';
		$optionBox += '<select class="sf ex_mode" name="ex_mode[]">';
		$optionBox += '<option value="-1">Model</option>';
		$optionBox += '</select>';
		$optionBox += '<select class="sf ex_drive_type" name="ex_drive_type[]">';
		$optionBox += '<option value="-1">Drive Type</option>';
		$optionBox += '</select>';
		$optionBox += '<a href="javascript:void(0);" class="remove_more_btn">X</a>';
		$optionBox += '<span class="loading">Loading</span>';
		$optionBox += '</div>';
		//console.log($optionBox);
		$(".add_more_btn").on("click",function(e){
			e.preventDefault();
			$(".option-boxes").append($optionBox);
		});
		$("body").on("click",".remove_more_btn",function(e){
			e.preventDefault();
			$(this).closest(".option-box").remove();
		});

	});
</script>
<div class="option-boxes">
	<?php if($if_add){
		$j=1; 
		foreach ($if_add as $cs) {
			$year_selected = $cs->year_id;
			$make_selected = $cs->make_id;
			$mode_selected = $cs->model_id;
			$drive_selected = $cs->drive_type_id;
			$table_name2 = $wpdb->prefix . 'make';
			$sql2 = "SELECT * FROM  $table_name2 WHERE year_id = '$year_selected'";
			$results2 = $wpdb->get_results($sql2);

			$table_name3 = $wpdb->prefix . 'model';
			$sql3 = "SELECT * FROM  $table_name3 WHERE year_id = '$year_selected' AND make_id = '$make_selected'";
			$results3 = $wpdb->get_results($sql3);

			$table_name4 = $wpdb->prefix . 'drive_type';
			$sql4 = "SELECT * FROM  $table_name4 WHERE year_id = '$year_selected' AND make_id = '$make_selected' AND model_id= '$mode_selected'";
			$results4 = $wpdb->get_results($sql4);
		?>
		<div class="option-box">
			<select class="sf ex_year" name="ex_year[]">
				<option value="-1">Year</option>
				<?php if(count($results)>0){foreach ($results as $result) {?>
					<option value="<?php echo $result->id;?>" <?php if($year_selected==$result->id){ echo "selected";}?>><?php echo $result->title;?></option>
				<?php }}?>
			</select>
			<select class="sf ex_make" name="ex_make[]">
				<option value="-1">Make</option>
				<?php if(count($results2)>0){foreach ($results2 as $result) {?>
					<option value="<?php echo $result->id;?>" <?php if($make_selected==$result->id){ echo "selected";}?>><?php echo $result->title;?></option>
				<?php }}?>
			</select>
			<select class="sf ex_mode" name="ex_mode[]">
				<option value="-1">Model</option>
				<?php if(count($results3)>0){foreach ($results3 as $result) {?>
					<option value="<?php echo $result->id;?>" <?php if($mode_selected==$result->id){ echo "selected";}?>><?php echo $result->title;?></option>
				<?php }}?>
			</select>
			<select class="sf ex_drive_type" name="ex_drive_type[]">
				<option value="-1">Drive Type</option>
				<?php if(count($results4)>0){foreach ($results4 as $result) {?>
					<option value="<?php echo $result->id;?>" <?php if($drive_selected==$result->id){ echo "selected";}?>><?php echo $result->title;?></option>
				<?php }}?>
			</select>
			<input type="hidden" name="cs_id[]" value="<?php echo $cs->id;?>">
			<?php if($j>1){ ?>
			<a href="javascript:void(0);" class="remove_more_btn">X</a>
			<?php } ?>
			<span class="loading">Loading</span>
		</div>

	<?php $j++;} }  else { ?>
		<div class="option-box">
			<select class="sf ex_year" name="ex_year[]">
				<option value="-1">Year</option>
				<?php if(count($results)>0){foreach ($results as $result) {?>
					<option value="<?php echo $result->id;?>"><?php echo $result->title;?></option>
				<?php }}?>
			</select>
			<select class="sf ex_make" name="ex_make[]">
				<option value="-1">Make</option>
			</select>
			<select class="sf ex_mode" name="ex_mode[]">
				<option value="-1">Model</option>
			</select>
			<select class="sf ex_drive_type" name="ex_drive_type[]">
				<option value="-1">Drive Type</option>
			</select>
			<span class="loading">Loading</span>
		</div>
	<?php } ?>
</div>
<a href="javascript:void(0);" class="add_more_btn">Add More</a>



<?php
}

function save_custom_product_search( $post_id ) {
	global $wpdb;
	global $post; 
    if ($post->post_type != 'product'){
        return;
    }
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    $table_name = $wpdb->prefix . 'search_product';
    if(isset($_POST['cs_id'])){
    	$cs_ids = $_POST['cs_id'];
    }else{
    	$cs_ids = array();
    }
	
	$years = $_POST['ex_year'];
	$makes = $_POST['ex_make'];
	$modes = $_POST['ex_mode'];
	$drive_types = $_POST['ex_drive_type'];
	$if_add = check_if_available_cs($post_id);
	$delete_array = array();
   if($if_add){
       foreach ($if_add as $key => $value) {
           if (in_array($value->id, $cs_ids)){
           } else {
               $delete_array[] = $value->id;
           }
       }
    }

//	echo "<pre>";print_r($delete_array);echo "</pre>";
//	echo "<pre>sdsd";print_r($cs_ids);echo "</pre>";
//	echo "<pre>";print_r($years);echo "</pre>";
//	echo "<pre>";print_r($makes);echo "</pre>";
//	echo "<pre>";print_r($modes);echo "</pre>";
//	echo "<pre>";print_r($drive_types);echo "</pre>";
//	exit;
	foreach ($cs_ids as $ck => $cs_id) {
		$wpdb->update( $table_name, array(
		    'year_id' => $years[$ck],
		    'make_id' => $makes[$ck],
		    'model_id' => $modes[$ck],
		    'drive_type_id' => $drive_types[$ck],
		),
		array('id'=>$cs_id));
		unset($years[$ck]);
		unset($makes[$ck]);
		unset($modes[$ck]);
		unset($drive_types[$ck]);
	}
	foreach ($delete_array as $d) {
		$wpdb->delete( $table_name, array( 'id' => $d ) );
	}
	foreach ($years as $y => $year) {
		$wpdb->insert($table_name, array(
		    'product_id' => $post_id,
		    'year_id' => $years[$y],
		    'make_id' => $makes[$y],
		    'model_id' => $modes[$y],
		    'drive_type_id' => $drive_types[$y],
		));
	}
	
	//echo $post_id;
	// if($if_add == false){
	// 	//echo $post_id;
	// 	foreach ($years as $year) {
	// 		$wpdb->insert($table_name, array(
	// 		    'product_id' => $post_id,
	// 		    'year_id' => $year,
	// 		    'make_id' => $make,
	// 		    'model_id' => $mode,
	// 		    'drive_type_id' => $drive_type,
	// 		));
	// 	}
		
	// }else{
	// 	//print_r($if_add);
	// 	$wpdb->update( $table_name, array(
	// 	    'year_id' => $year,
	// 	    'make_id' => $make,
	// 	    'model_id' => $mode,
	// 	    'drive_type_id' => $drive_type,
	// 	),
	// 	array('id'=>$if_add->id));
	// }
	//exit;
}
add_action( 'save_post', 'save_custom_product_search' );

function check_if_available_cs($product_id){
	global $wpdb;
	$table_name = $wpdb->prefix . 'search_product';
    $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE product_id = '$product_id'" );

    if(count($results)>0){
    	return $results;
    }else{
    	return false;
    }
}

include 'includes/hooks.php';
include 'includes/ajaxReq.php';
include 'includes/excs.php';
include 'includes/search.php';
