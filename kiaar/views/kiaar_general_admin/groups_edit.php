<?php //mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <span class="caption-subject font-brown bold uppercase">Users Permission</span>
                    </div>
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('admin/groups/'); ?>">Back </a></span>
                                     
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <?php
                            mk_hpostform($base_url.$page."_manipulate".(isset($data['group_id'])?"/".$data['group_id']:""));

                            mk_htext("data[group_name]",_l('Group Name',$this),isset($data['group_name'])?$data['group_name']:'','required');
                            ?>
                            <?php //$permissions = $data['permissions']; 
                            //$arr1 = explode(',' , $permissions);?>

                                <!-- <ul class="list-group">
                                    <?php foreach($data_list as $value){ ?> 
                                        <li class="list-group-item">
                                            <?php echo "<h5>"._l($value,$this)."</h5>";?>
                                            <div class="material-switch pull-right">
                                                <input type="checkbox" name="permissions[]" id="someSwitchOptionDefault<?php echo $value;?>" value="<?php echo $value;?>" <?= in_array($value, $arr1) ? 'checked="checked"' : '' ?>/>  
                                                <label for="someSwitchOptionDefault<?php echo $value;?>" class="label-default"></label>
                                            </div>
                                        </li>
                                    <?php } ?>     
                                </ul> -->
                                <?php
                                mk_hsubmit(_l('Submit',$this),$base_url.$page,_l('Cancel',$this));
                                mk_closeform();
                        ?>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>
<?php
// mk_popup_uploadfile(_l('Upload Avatar',$this),"avatar",$base_url."upload_image/20/");
?>
<style type="text/css">
    .material-switch > input[type="checkbox"] {
    display: none;   
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
}

.material-switch > label::before {
    /*background: rgb(0, 0, 0);*/
    background: #999!important;
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 20px;
    margin-top: -25px;
    position: absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    /*background: rgb(255, 255, 255);*/
    background: #ff6c60;
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -18px;
    position: absolute;
    top: -10px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
}
.label-default {
    background-color: #43bf45;
}
</style>