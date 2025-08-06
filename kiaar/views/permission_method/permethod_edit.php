    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($data['pm_id'])) {      ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Permission Module</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Permission Module</span>
                       <?php } ?>                    
                   </div>
                    &nbsp;&nbsp;<span class="custpurple"><button class="brownsmall btn brown" onclick="history.go(-1);">Back</button> </span>
                                                      
                </div>
            <div class="panel-body">
                <div class=" form">
                    <?php error_reporting(0);
                    mk_hpostform(base_url().'permission_method'."/add_permission_method".(isset($data['pm_id'])?"/".$data['pm_id']:""));
                    ?>

                    <div class="form-group">
                        <label for="data[pm_module_id]" class="control-label col-lg-2">Module</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="single" class="form-control select2" name="data[pm_module_id]" data-placeholder="Select Module" required>
                            <option value="">Select Module</option>
                                <?php if(isset($module) && count($module)!=0){ ?>
                                <?php foreach ($module as $key4 => $data4) { ?>
                                    <option value="<?=$data4['module_id']?>" <?php if($data['pm_module_id'] == $data4['module_id']) echo"selected"; ?>><?=$data4['module_name']?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <?php  mk_htext("data[pm_name]",_l('Name',$this),isset($data['pm_name'])?$data['pm_name']:'','required'); ?>
                    
                    <div class="form-group">
                        <label for="data[pm_controller_name]" class="control-label col-lg-2">Controller</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="controller" class="form-control select2" name="data[pm_controller_name]" data-placeholder="Select Controller" required>
                                <option value="">Select Controller</option>
                                <?php foreach ($controller as $value) { ?>
                                    <option value="<?php echo $value; ?>" <?php if($data['pm_controller_name'] == $value) echo"selected"; ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="data[pm_order]" class="control-label col-lg-2">Method For</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="single" class="form-control select2" name="data[pm_order]" data-placeholder="Method For" required>
                                <option value="">Method For</option>
                                <?php foreach ($this->config->item('method_for') as $mfkey => $mfvalue) { ?>
                                    <option value="<?php echo $mfkey; ?>" <?php if($data['pm_order'] == $mfkey) echo"selected"; ?>><?php echo $mfvalue; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <?php if(!isset($data['pm_id'])) { ?>
                    <div class="form-group">
                        <label for="data[pm_method]" class="control-label col-lg-2">Method</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="method" class="form-control select2" name="data[pm_method]" data-placeholder="Select Method" required>
                              <option value="">Select Method</option>
                            </select>
                        </div>
                    </div>
                    <?php } else {?>

                    <div class="form-group">
                        <label for="data[pm_method]" class="control-label col-lg-2">Method</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="single" class="form-control select2" name="data[pm_method]" data-placeholder="Select Method" required>
                            <option value="">Select Method</option>
                                <?php if(isset($controller_method) && count($controller_method)!=0){ //print_r($controller_method);?>
                                <?php foreach ($controller_method as $key5 => $data5) { //print_r($data5);?>
                                    <option value="<?=$data5?>" <?php if($data['pm_method'] == $data5) echo"selected"; ?>><?=$data5?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <?php } ?>

                    <div class="form-group">
                        <label for="data[pm_type]" class="control-label col-lg-2">Type</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="single" class="form-control select2" name="data[pm_type]" data-placeholder="Select Type">
                            <option value="">Select Type</option>
                                <option value="Page" <?php if($data['pm_type'] == 'Page') echo"selected"; ?>>Page</option>
                                <option value="CMS-Form" <?php if($data['pm_type'] == 'CMS-Form') echo"selected"; ?>>CMS-Form</option>
                            </select>
                        </div>
                    </div>

                    <?php
                      mk_htext("data[pm_code]",_l('Code',$this),isset($data['pm_code'])?$data['pm_code']:'','');
                      mk_htext("data[pm_description]",_l('Description',$this),isset($data['pm_description'])?$data['pm_description']:'','');                    
                      mk_htext("data[pm_slug]",_l('Slug',$this),isset($data['pm_slug'])?$data['pm_slug']:'','');                   
                    ?>
                    
                    <?php 
                    mk_hsubmit(_l('Submit',$this),$base_url.$page,_l('Cancel',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#controller').on('change',function(){
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('permission_method/appendmethod');?>",
                data:'controller='+countryID,
                success:function(html){
                    $('#method').html(html);
                }
            }); 
        }else{
            $('#method').html('<option value="">Select Controller First</option>');
        }
    });
    
});
</script>