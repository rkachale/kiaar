
<!-- <div class="year" style="margin-left: -2%;color: red;"><?php echo $year; ?></div> -->
    <div class="row health-monitor-data">
        <div class="col-lg-3 col-md-12 mb-3 yearsidebar">
            <ul class="nav flex-column mb-dropdown" id="myTab" role="tablist">
                <span class="dropdown-icon"></span>
                <?php
                    $i = 1;
                    foreach ($finalArray as $key => $value) {
                        ?>
                        <div class="month"><?php echo  date("F",mktime(0,0,0,$key,1,2021)); ?></div>
                        <?php
                        if(isset( $value[0] ) && is_array( $value[0] ))
                        {
                            ?>
                            <li class="nav-item <?php if($i==1){ echo 'nav-active'; } ?>">
                                <?php
                                foreach ($value as $key1 => $value1) {
                                ?>
                                <!-- <li class="nav-item"> -->
                                    <a class="nav-link getCropImage <?php if($i==1){ echo 'active'; } ?> " data-id="<?php echo $value1['id']; ?>" data-toggle="tab" href="<?php echo '#crop_img_'.$i; ?>" role="tab" aria-controls="<?php echo 'crop_img_'.$i; ?>" aria-selected="true"><?php echo ($value1['name'] != '') ? $value1['name'] : $value1['id']; ?></a>
                            
                                <!-- </li> -->
                                <?php
                                $i++;
                                }
                                ?>
                            </li>
                            <?php    
                        }
                        else
                        {
                            ?>
                            <li class="nav-item <?php if($i==1){ echo 'nav-active'; } ?>">
                                <a class="nav-link <?php if($i==1){ echo 'active'; } ?> " data-toggle="tab" href="<?php echo '#crop_img_'.$i; ?>" role="tab" aria-controls="<?php echo 'crop_img_'.$i; ?>" aria-selected="true" style="pointer-events: none;"><?php echo "No data found"; ?></a>
                        
                            </li>
                            <?php
                            $i++;
                        }
                        
                    }
                    
                    ?>
            </ul>    
        
        </div>
        <div class="col-lg-9 col-md-12">
            <div class="tab-content" id="myTabContent">
                <?php
                $j =1;
                foreach ($finalArray as $key => $value) {
                    
                    //if(isset($value))
                        if(isset( $value[0] ) && is_array( $value[0] ))
                        {
                            foreach ($value as $ikey => $ivalue) {
                            ?>
                                <div class="tab-pane fade <?php if($j==1){ echo 'show active'; } ?>" id="<?php echo 'crop_img_'.$j; ?>" role="tabpanel"><?php if($j==1) { ?><img alt="" src="/upload_file/crop_health_upload/<?php echo $ivalue['FARMER_ID'].'_'.$ivalue['year'].'-'.$ivalue['month'].'/'.$ivalue['image'];?>" /> <?php } ?> </div>
                                <?php
                            $j++;    
                            }
                        }
                        else
                        {
                            ?>
                            <div class="tab-pane fade <?php if($j==1){ echo 'show active'; } ?>" id="<?php echo 'crop_img_'.$j; ?>" role="tabpanel"> <?php //echo "No data found"//.$j; ?></div>
                            <?php
                            $j++;    
                        }
                    
                    
                }
                ?>
            </div>
        </div>
    </div>

<?php /* //old code without empty months value
<div class="year" style="margin-left: -2%;color: red;"><?php echo $year; ?></div>
    <div class="row">
        <div class="col-md-2 mb-3">
            <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                <?php
                    $i = 1;
                    foreach ($crop_images_listing_ajax1 as $key => $value) {
                        # code...
                        ?>
                        <div class="month" style="margin-left: -1%;"><?php echo  date("F",mktime(0,0,0,$key,1,2021)); ?></div>
                        <?php
                         //echo  date("F",mktime(0,0,0,$key,1,2021));
                        
                        foreach ($value as $key1 => $value1) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if($i==1){ echo 'active'; } ?> " data-toggle="tab" href="<?php echo '#crop_img_'.$i; ?>" role="tab" aria-controls="<?php echo 'crop_img_'.$i; ?>" aria-selected="true"><?php echo ($value1['name'] != '') ? $value1['name'] : $value1['id']; ?></a>
                        
                            </li>
                        <?php
                        $i++;
                        }

                    }
                    
                    ?>
            </ul>    
        
        </div>
        <div class="col-md-10">
            <div class="tab-content" id="myTabContent">
                <?php
                $j =1;
                foreach ($crop_images_listing_ajax1 as $key => $value) {
                    
                    foreach ($value as $ikey => $ivalue) {
                    ?>
                        <div class="tab-pane fade <?php if($j==1){ echo 'show active'; } ?>" id="<?php echo 'crop_img_'.$j; ?>" role="tabpanel"> <img alt="" src="/upload_file/crop_health_upload/<?php echo $ivalue['FARMER_ID'].'_'.$ivalue['year'].'-'.$ivalue['month'];?>/<?php echo $ivalue['image'];?>" /> <?php //echo "test = ".$j; ?></div>
                        <?php
                    $j++;    
                    }
                    
                }
                ?>
            </div>
        </div>
    </div>
    <?php */ ?>


    <script type="text/javascript">
    

    $('.yearsidebar .mb-dropdown .month').click(function(){
        $('.yearsidebar').toggleClass('mb-dropup');
    });

    if ($(window).width() < 769){
        $('.yearsidebar ul .nav-item.nav-active').prev().show();

        $('.yearsidebar ul .nav-item .nav-link').click(function(){
            if(! $(this).hasClass('active')){
                $('.yearsidebar ul .nav-item.nav-active').prev().hide();
                $('.yearsidebar ul .nav-item').removeClass('nav-active');
                $('.yearsidebar').removeClass('mb-dropup');
                $(this).parents('.nav-item').addClass('nav-active');
                $(this).parents('.nav-item.nav-active').prev().show();
            } 
        });
    }

    $(document).ready(function(){
  
        $(".getCropImage").on("click", function(){
            console.log("getCropImage anchor clicked");
            var old_tabcontent_id = $(this).attr('href');
            console.log("old tab content id = "+old_tabcontent_id);
            
            var tabcontent_id = old_tabcontent_id.substring(1, old_tabcontent_id.length);
            console.log("tab content id = "+tabcontent_id);

            var crop_id = $(this).attr('data-id');
            console.log("crop id "+crop_id);
            var farmer_id = '<?php echo $farmer_id; ?>';
            var month = '<?php echo $month; ?>';
            year = $("#year_check option:selected").val();
            console.log("year"+year);

            jQuery.ajax({
                type:"post",
                url: '<?php echo base_url(); ?>kiaar_general/get_crophealth_image_by_id/',
                data:'crop_id='+crop_id+'&farmer_id='+farmer_id+'&year='+year+'&month='+month,

                beforeSend: function () {
                $('.loading').show();
                },

                success: function (html) {
                  //console.log(html);

                  //$("#"+tabcontent_id).html(html);
                  $(old_tabcontent_id).html(html);
                  //$('.loading').fadeOut("slow");
                }
            });

        });
    });

    </script>