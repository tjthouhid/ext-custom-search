<?php 
function getMake(){
	global $wpdb;
	$year = $_REQUEST['year'];
	$selected = $_REQUEST['selected'];
    $resultarr = array();
    $str = "";
    $table_name = $wpdb->prefix . 'make';
    $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE year_id = '$year'" );
    $str .= '<option value="-1">Make</option>';
    $selectedHtml = "";
    if(count($results)>0){

        foreach ($results as $result){
        	if($selected==$result->id){
        		$selectedHtml = "selected";
        	}else{
        		$selectedHtml = "";
        	}
        	$str .= '<option value="'.$result->id.'" '.$selectedHtml.'>'.$result->title.'</option>';
           

        }
        
    }
    $resultarr['res'] = $str;
    $resultarr['type'] = "success";
    echo json_encode($resultarr);
    exit;
} 
function getMode(){
	global $wpdb;
	$make = $_REQUEST['make'];
	$selected = $_REQUEST['selected'];
    $resultarr = array();
    $str = "";
    $table_name = $wpdb->prefix . 'model';
    $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE make_id = '$make'" );
    $str .= '<option value="-1">Model</option>';
    $selectedHtml = "";
    if(count($results)>0){

        foreach ($results as $result){
        	if($selected==$result->id){
        		$selectedHtml = "selected";
        	}else{
        		$selectedHtml = "";
        	}
        	$str .= '<option value="'.$result->id.'" '.$selectedHtml.'>'.$result->title.'</option>';
           

        }
        
    }
    $resultarr['res'] = $str;
    $resultarr['type'] = "success";
    echo json_encode($resultarr);
    exit;
} 
function getDriveType(){
	global $wpdb;
	$mode = $_REQUEST['mode'];
	$selected = $_REQUEST['selected'];
    $resultarr = array();
    $str = "";
    $table_name = $wpdb->prefix . 'drive_type';
    $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE model_id = '$mode'" );
    $str .= '<option value="-1">Drive Type</option>';
    $selectedHtml = "";
    if(count($results)>0){

        foreach ($results as $result){
        	if($selected==$result->id){
        		$selectedHtml = "selected";
        	}else{
        		$selectedHtml = "";
        	}
        	$str .= '<option value="'.$result->id.'" '.$selectedHtml.'>'.$result->title.'</option>';
           

        }
        
    }
    $resultarr['res'] = $str;
    $resultarr['type'] = "success";
    echo json_encode($resultarr);
    exit;
}
?>