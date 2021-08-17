<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__)."css/ex-style.css";?>">
<div class="eh-section-full">
    <div class="eh-header">
        <h1>Years</h1>
    </div>
    <div class="eh-body">
        <div class="eh-row">
            <div class="eh-col-12">
                <h2 class="tbl-headline">Years</h2>
                <a href="<?php echo admin_url();?>admin.php?page=excs-system-year&add=1" class="action-add">Add New</a>
                <table class="eh-table" id="com_tbl">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php if(count($results)>0){ 
                    		$i = 1;
                    		foreach ($results as $result){ ?>
                    			<tr>
                    			    <th><?php echo $i;?></th>
                    			    <th><?php echo $result->title;?></th>
                    			    <th>
                    			    	<a href="<?php echo admin_url();?>admin.php?page=excs-system-year&edit=1&id=<?php echo $result->id;?>" class="action-edit">Edit</a><a href="<?php echo admin_url();?>admin.php?page=excs-system-year&delete=1&id=<?php echo $result->id;?>" class="action-delete">X</a>
                    			    </th>
                    			</tr>
                    	<?php $i++; }}?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	jQuery(function($){
		$(".action-delete").on("click",function(e){
			//e.preventDefault();
			var r = confirm("Are you sure?");
			if(r){
				return true;
			}else{
				return false;
			}
		});
	});
</script>