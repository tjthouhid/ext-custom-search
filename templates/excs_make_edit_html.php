<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__)."css/ex-style.css";?>">
<div class="eh-section-full">
    <div class="eh-header">
        <h1>Edit Make</h1>
    </div>
    <div class="eh-body">
        <div class="eh-row">
            <div class="eh-col-12">
                <h2 class="tbl-headline">Edit Make</h2>
                <form class="extra-h-form" action="<?php echo admin_url();?>admin.php?page=excs-system-make&edit=1&id=<?php echo $id;?>" method="post">
                <div class="input-box">
                    <label class="input-label">Make </label>
                    <input type="text" class="input-text" name="make" value="<?php echo $results[0]->title;?>" placeholder="Make" required>
                </div>

                <div class="input-box">
                    <label class="input-label">Year </label>
                    <select class="input-select" name="year" required>
                        <option value="-1">Year</option>
                        <?php if(count($years)>0){
                            foreach ($years as $year){ ?>
                                <option value="<?php echo $year->id;?>" <?php if($results[0]->year_id==$year->id){ echo "selected";}?>><?php echo $year->title;?></option>
                        <?php } } ?>
                        
                    </select>
                    
                </div>
                
                <div class="input-box">
                    <button class="eh-btn btn-save" name="save">Save</button>
                    <a href="<?php echo admin_url();?>admin.php?page=excs-system-make" class="eh-btn btn-cancel">Cancel</a>
                </div>
            </form>
                
            </div>
        </div>
    </div>
</div>