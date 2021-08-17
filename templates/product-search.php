<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__)."css/product-search.css";?>">
<style>
    .search-product-header{
        background-color: #0f3a5f;
        padding: 15px 20px;
        color: #fff;
        margin-bottom: 10px;
        position: relative;
    }
    .sp-h-title{

    }
    .sp-h-title img{
        width: 120px;
    }
    .sp-h-title span{
        font-weight: 700;
        font-size: 24px;
        position: relative;
        bottom: 10px;
        margin-left: 20px;
    }
    .search-box{
        position: relative;
        padding-top: 10px;
    }
    .has-loading{}
    .has-loading::before{
        content: "";
        position: absolute;
        background-color: rgba(0,0,0,0.8);
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
    .loading img{
        width: 40px;
    }
    .has-loading .loading{display: block;}
    .search-box form{
        display: flex;
        align-items: center;
    }
    .search-box select{
        width: 25%;
        margin-right: 15px;

    }
    .xclearbtn{
        position: absolute;
        top: 10px;
        right: 15px;
        color: #fff;
        text-decoration: none;
    }
    .xclearbtn span{
        background: #fff;
        color: #0f3a5f;
        padding: 3px 10px 4px;
        border-radius: 60px
    }
    .xclearbtn:hover{
        color: #ff5454;
    }
    .xclearbtn:hover span{
        background: #ff5454;
    }
</style>
<script type="text/javascript">
    jQuery(function($){
        var year_selected = -1;
        var make_selected = -1;
        var mode_selected = -1;
        var drive_selected = -1;
        function getMake(year,selected){
            startLoading();
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
                    make = $('.class-make');
                    if(data.type=="success"){
                        make.html(data.res);
                    }
                    endLoading();
                    make.trigger('change');
                    //console.log(data);
                })
                .fail(function() {
                    console.log("error");
                });

        }
        function getMode(make,selected){
            startLoading();
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
                    mode = $('.class-model');
                    if(data.type=="success"){
                        mode.html(data.res);
                    }
                    endLoading();
                    mode.trigger('change');
                    //console.log(data);
                })
                .fail(function() {
                    console.log("error");
                });

        }
        function getDriveType(mode,selected){
            startLoading();
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
                    drive_type = $('.class-drive-type');
                    if(data.type=="success"){
                        drive_type.html(data.res);
                    }
                    endLoading();
                    //console.log(data);
                })
                .fail(function() {
                    console.log("error");
                });

        }
        $("body").on("change",".class-year",function(){
            var year = $(this).val();
            //console.log($(this))
            getMake(year,make_selected);
            make_selected = -1;

        });
        $("body").on("change",".class-make",function(){
            var make = $(this).val();
            getMode(make,mode_selected);
            mode_selected = -1;

        });
        $("body").on("change",".class-model",function(){
            var mode = $(this).val();
            getDriveType(mode,drive_selected);
            drive_selected = -1;

        });
        $("body").on("change",".class-drive-type",function(){
            $("#search_form").submit();

        });
        function startLoading(){
            $(".search-box").addClass('has-loading');
        }
        function endLoading(){
            $(".search-box").removeClass('has-loading');
        }
    });
</script>
<div class="search-product-header">
    <a href="<?php echo $url;?>" class="xclearbtn">Clear <span>x</span></a>
    <div class="sp-h-title">
        <img src="https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_230/https://richmondtransmissionservice.com/wp-content/uploads/2020/04/Richmond-Logo-75.jpg">
        <span>FIND IT. TRUST IT. BUY IT</span>
    </div>
    <div class="search-box">
        <form action="<?php echo $url;?>" method="get" id="search_form">
            <select class="class-year" name="exyear">
                <option value="-1">Year</option>
                <?php if(count($years)>0){foreach ($years as $year) {?>
                    <option value="<?php echo $year->id;?>" <?php if($year_selected==$year->id){ echo "selected";}?>><?php echo $year->title;?></option>
                <?php }}?>
            </select>
            <select  class="class-make" name="exmake">
                <option value="-1">Make</option>
                <?php if(count($makes)>0){foreach ($makes as $make) {?>
                    <option value="<?php echo $make->id;?>" <?php if($make_selected==$make->id){ echo "selected";}?>><?php echo $make->title;?></option>
                <?php }}?>
            </select>
            <select  class="class-model" name="exmodel">
                <option value="-1">Model</option>
                <?php if(count($modes)>0){foreach ($modes as $mode) {?>
                    <option value="<?php echo $mode->id;?>" <?php if($mode_selected==$mode->id){ echo "selected";}?>><?php echo $mode->title;?></option>
                <?php }}?>
            </select>
            <select  class="class-drive-type" name="exdrive_type">
                <option value="-1">Drive Type</option>
                <?php if(count($drive_types)>0){foreach ($drive_types as $drive_type) {?>
                    <option value="<?php echo $drive_type->id;?>" <?php if($drive_selected==$drive_type->id){ echo "selected";}?>><?php echo $drive_type->title;?></option>
                <?php }}?>
            </select>
        </form>
        <div class="loading">
            <img src="<?php echo plugin_dir_url(__FILE__)."img/loader.gif";?>" >
        </div>
    </div>
    
</div>
<?php
$_pf = new WC_Product_Factory();
woocommerce_product_loop_start();
/**
 * Hook: woocommerce_before_shop_loop.
 *
 * @hooked woocommerce_output_all_notices - 10
 * @hooked woocommerce_result_count - 20
 * @hooked woocommerce_catalog_ordering - 30
 */
do_action( 'woocommerce_before_shop_loop' );
foreach ($results as $result){
    $_product = $_pf->get_product($result->product_id);
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        'post__in'=> array($result->product_id),
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
        //$_product = &new WC_Product( $loop->post->ID );
        $_product = $_pf->get_product($result->product_id);
        /**
         * Hook: woocommerce_shop_loop.
         */
        do_action( 'woocommerce_shop_loop' );
        wc_get_template_part( 'content', 'product' );
    endwhile;
    wp_reset_postdata();
}
woocommerce_product_loop_end();
/**
 * Hook: woocommerce_after_shop_loop.
 *
 * @hooked woocommerce_pagination - 10
 */
do_action( 'woocommerce_after_shop_loop' );

?>
<div class="navigation">
    <ul>
        <?php if($current>1): ?>
            <li><a href="<?php echo $page_url;?>p_no=1"><<</a></li>
            <li><a href="<?php echo $page_url;?>p_no=<?php echo $current-1?>"><</a></li>
        <?php endif;?>
        <?php for($i=$start;$i<$current;$i++){ ?>
            <li><a href="<?php echo $page_url;?>p_no=<?php echo $i?>"><?php echo $i?></a></li>
        <?php } ?>
        <li class="active"><a href="<?php echo $page_url;?>p_no=<?php echo $current?>"><?php echo $current?></a></li>
        <?php for($i=$current+1;$i<=$end;$i++){ ?>
            <li><a href="<?php echo $page_url;?>p_no=<?php echo $i?>"><?php echo $i?></a></li>
        <?php } ?>
        <?php if($current<$end): ?>
            <li><a href="<?php echo $page_url;?>p_no=<?php echo $current+1?>">></a></li>
            <li><a href="<?php echo $page_url;?>p_no=<?php echo $pages?>">>></a></li>
        <?php endif;?>
</div>
<style type="text/css">
    .navigation{text-align: center;margin: 20px auto;}
    .navigation ul{list-style: none;display: inline-block;padding: 0px;margin: 0px;}
    .navigation ul li{display: inline-block;margin: 5px;}
    .navigation ul li a{padding: 5px 10px;border: 1px solid #1d3cad;color: #1d3cad;text-decoration: none;}
    .navigation ul li:hover a{background-color: #1d3cad; color: #fff;}
    .navigation ul li.active a{background-color: #1d3cad; color: #fff;}
</style>
