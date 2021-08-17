<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__)."css/ex-style.css";?>">
<div class="eh-section-full">
    <div class="eh-header">
        <h1>Model</h1>
    </div>
    <div class="eh-body">
        <div class="eh-row">
            <div class="eh-col-12">
                <h2 class="tbl-headline">Model</h2>
                <a href="<?php echo admin_url();?>admin.php?page=excs-system-model&add=1" class="action-add">Add New</a>
                <table class="eh-table" id="com_tbl">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Model</th>
                            <th>Make</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php if(count($results)>0){ 
                    		
                    		foreach ($results as $result){ ?>
                    			<tr>
                    			    <th><?php echo $i;?></th>
                    			    <th><?php echo $result->title;?></th>
                                    <th><?php echo $result->make;?></th>
                                    <th><?php echo $result->year;?></th>
                    			    <th>
                    			    	<a href="<?php echo admin_url();?>admin.php?page=excs-system-model&edit=1&id=<?php echo $result->id;?>" class="action-edit">Edit</a><a href="<?php echo admin_url();?>admin.php?page=excs-system-model&delete=1&id=<?php echo $result->id;?>" class="action-delete">X</a>
                    			    </th>
                    			</tr>
                    	<?php $i++; }}?>

                    </tbody>
                </table>
                <div class="navigation">
                    <ul>
                        <?php if($current>1): ?>
                        <li><a href="<?php echo $url;?>&p=1"><<</a></li>
                        <li><a href="<?php echo $url;?>&p=<?php echo $current-1?>"><</a></li>
                        <?php endif;?>
                        <?php for($i=$start;$i<$current;$i++){ ?>
                            <li><a href="<?php echo $url;?>&p=<?php echo $i?>"><?php echo $i?></a></li>
                        <?php } ?>
                        <li class="active"><a href="<?php echo $url;?>&p=<?php echo $current?>"><?php echo $current?></a></li>
                        <?php for($i=$current+1;$i<=$end;$i++){ ?>
                            <li><a href="<?php echo $url;?>&p=<?php echo $i?>"><?php echo $i?></a></li>
                        <?php } ?>
                        <?php if($current<$end): ?>
                        <li><a href="<?php echo $url;?>&p=<?php echo $current+1?>">></a></li>
                        <li><a href="<?php echo $url;?>&p=<?php echo $pages?>">>></a></li>
                        <?php endif;?>
                  </div>
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