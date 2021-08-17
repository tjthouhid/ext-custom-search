<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__)."css/ex-style.css";?>">
<div class="eh-section-full">
    <div class="eh-header">
        <h1>Edit Year</h1>
    </div>
    <div class="eh-body">
        <div class="eh-row">
            <div class="eh-col-12">
                <h2 class="tbl-headline">Edit Year</h2>
                <form class="extra-h-form" action="<?php echo admin_url();?>admin.php?page=excs-system-year&edit=1&id=<?php echo $id;?>" method="post">
                <div class="input-box">
                    <label class="input-label">Title </label>
                    <input type="text" class="input-text" name="year" value="<?php echo $results[0]->title;?>" placeholder="Year" required>
                </div>
                
                <div class="input-box">
                    <button class="eh-btn btn-save" name="save">Update</button>
                    <a href="<?php echo admin_url();?>admin.php?page=excs-system-year" class="eh-btn btn-cancel">Cancel</a>
                </div>
            </form>
                
            </div>
        </div>
    </div>
</div>