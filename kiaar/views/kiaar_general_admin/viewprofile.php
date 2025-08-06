<?php if(isset($data_list) && count($data_list)!=0){ ?>
    <?php foreach($data_list as $data){ ?>
        <div class="col-md-6">
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo base_url(); ?>/<?php echo $data["avatar"]; ?>" class="img-responsive" alt=""> </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"><?=$data["username"]?> </div>
                    <div class="profile-usertitle-job"> <?=$data["fullname"]?> </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->                             

                <div class="profile-usertitle">
                        <i class="fa fa-globe"></i>
                        <a href="http://www.kiaar.com">www.kiaar.com</a>
                    </div>                                    
                </div>  
            </div>   
        </div>
        <!-- END PORTLET MAIN -->       
        <?php } ?>       
    <?php } ?>
