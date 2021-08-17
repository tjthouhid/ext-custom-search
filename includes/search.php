<?php 
 function exproduct_page($atts){
 	$a = shortcode_atts( array(
 		'foo' => 'something',
 	), $atts );
 	global  $wpdb;
     if(isset($_GET['exyear'])){
         $year_selected = $_GET['exyear'];
         $tbl_make = $wpdb->prefix . 'make';
         $sql3 = "SELECT * FROM  $tbl_make WHERE year_id = '$year_selected'";
         $makes = $wpdb->get_results($sql3);

     }else{
         $makes = array();
         $year_selected = -1;
     }
     if(isset($_GET['exmake'])){
         $make_selected = $_GET['exmake'];
         $tbl_mode = $wpdb->prefix . 'model';
         $sql4 = "SELECT * FROM  $tbl_mode WHERE year_id = '$year_selected' AND make_id = '$make_selected'";
         $modes = $wpdb->get_results($sql4);
     }else{
         $make_selected = -1;
         $modes = array();
     }
     if(isset($_GET['exmodel'])){
         $mode_selected = $_GET['exmodel'];
         $tbl_dt = $wpdb->prefix . 'drive_type';
         $sql5 = "SELECT * FROM  $tbl_dt WHERE year_id = '$year_selected' AND make_id = '$make_selected' AND model_id= '$mode_selected'";
         $drive_types = $wpdb->get_results($sql5);
     }else{
         $mode_selected = -1;
         $drive_types = array();
     }
     if(isset($_GET['exdrive_type'])){
         $drive_selected = $_GET['exdrive_type'];
     }else{
         $drive_selected = -1;
     }

     $tbl_year = $wpdb->prefix . 'year';
     $sql2 = "SELECT * FROM  $tbl_year";
     $years = $wpdb->get_results($sql2);

     $table_name = $wpdb->prefix . 'search_product';

     if(isset($_GET['p_no'])){
         $current = $_GET['p_no'];
     }else{
         $current = 1;
     }

     if($year_selected == -1 && $make_selected == -1 && $mode_selected == -1 && $drive_selected == -1){
         $totalQr = $wpdb->get_results( "SELECT id FROM $table_name GROUP BY product_id" );

     }else{
         $totalQr = $wpdb->get_results( "SELECT id FROM $table_name WHERE year_id='$year_selected' AND make_id ='$make_selected' AND model_id='$mode_selected' AND drive_type_id='$drive_selected' GROUP BY product_id" );
     }
     $total = count($totalQr);
     $perPage = 12;
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

     if($year_selected == -1 && $make_selected == -1 && $mode_selected == -1 && $drive_selected == -1){
         $sql = "SELECT * FROM $table_name GROUP BY product_id Limit $lim,$perPage";
     }else{
         $sql = "SELECT * FROM $table_name WHERE year_id='$year_selected' AND make_id ='$make_selected' AND model_id='$mode_selected' AND drive_type_id='$drive_selected' GROUP BY product_id  Limit $lim,$perPage";
     }
     $results = $wpdb->get_results($sql);

     global $wp;
     $url = home_url( $wp->request )."/";
     if($year_selected == -1 && $make_selected == -1 && $mode_selected == -1 && $drive_selected == -1){
         $page_url = $url."?";
     }else{
         $page_url = $url."?exyear=".$year_selected."&exmake=".$make_selected."&exmodel=".$mode_selected."&exdrive_type=".$drive_selected."&";
     }

 	///echo "<pre>";print_r($results);echo "</pre>";



 	ob_start();
 	include dirname(dirname(__FILE__)).'/templates/product-search.php';
 	return ob_get_clean();

 }

 add_shortcode( 'ex-product-page', 'exproduct_page' );
?>