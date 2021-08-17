<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__)."css/ex-style.css";?>">
<div class="eh-section-full">
    <div class="eh-header">
        <h1>Add Drive Type</h1>
    </div>
    <div class="eh-body">
        <div class="eh-row">
            <div class="eh-col-12">
                <h2 class="tbl-headline">Add Drive Type</h2>
                <form class="extra-h-form" action="<?php echo admin_url();?>admin.php?page=excs-system-drive-type&add=1" method="post">
                <div class="input-box">
                    <label class="input-label">Drive Type </label>
                    <input type="text" class="input-text" name="drive_type" placeholder="Drive Type" required>
                </div>

                <div class="input-box">
                    <label class="input-label">Year </label>
                    <select class="input-select" name="year" id="ex_year" required>
                        <option value="-1">Year</option>
                        <?php if(count($years)>0){
                            foreach ($years as $year){ ?>
                                <option value="<?php echo $year->id;?>"><?php echo $year->title;?></option>
                        <?php } } ?>
                        
                    </select>
                    
                </div>
                <div class="input-box">
                    <label class="input-label">Make </label>
                    <select class="input-select" name="make" id="ex_make" required>
                        <option value="-1">Make</option>
                        
                    </select>
                    
                </div>
                <div class="input-box">
                    <label class="input-label">Model </label>
                    <select class="input-select" name="model" id="ex_model" required>
                        <option value="-1">Model</option>
                        
                    </select>
                    
                </div>
                
                <div class="input-box">
                    <button class="eh-btn btn-save" name="save">Save</button>
                    <a href="<?php echo admin_url();?>admin.php?page=excs-system-drive-type" class="eh-btn btn-cancel">Cancel</a>
                </div>
            </form>
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function($){
        var $year = $("#ex_year");
        var $make = $("#ex_make");
        var $model = $("#ex_model");
        var year_selected = -1;
        var make_selected = -1;
        var model_selected = -1;
        function getMake(year,selected){
            $make.attr("disabled", true);
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
                if(data.type=="success"){
                    $make.html(data.res);
                }
                $make.attr("disabled", false);
                $make.trigger('change');
                //console.log(data);
            })
            .fail(function() {
                console.log("error");
            });
            
        }
        function getModel(make,selected){
            $model.attr("disabled", true);
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
                if(data.type=="success"){
                    $model.html(data.res);
                }
                $model.attr("disabled", false);
                //$model.attr("disabled", false);
                //$mode.trigger('change');
                //console.log(data);
            })
            .fail(function() {
                console.log("error");
            });
            
        }
        $year.on("change",function(){
            var year = $year.val();
            getMake(year,make_selected);
            make_selected = -1;

        });
        $make.on("change",function(){
            var make = $make.val();
            getModel(make,model_selected);
            model_selected = -1;

        });
    });
</script>