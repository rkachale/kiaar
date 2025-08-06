    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($data['module_id'])) {      ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Module</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Module</span>
                       <?php } ?>                    
                   </div>
                    &nbsp;&nbsp;<span class="custpurple"><button class="brownsmall btn brown" onclick="history.go(-1);">Back</button> </span>
                                                      
                </div>
            <div class="panel-body">
                <div class=" form">
                    <?php error_reporting(0);
                    mk_hpostform(base_url().'usermanagement_module'."/add_module".(isset($data['module_id'])?"/".$data['module_id']:""));
                    ?>

                    <div class="form-group">
                        <label for="data[parent_id]" class="control-label col-lg-2">Parent Module</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="group" class="form-control select2" name="data[parent_id]" data-placeholder="Select Parent Module">
                            <option value="">Select Parent Module</option>
                                <?php if(isset($module) && count($module)!=0){ ?>
                                <?php foreach ($module as $key2 => $data2) { ?>
                                    <option value="<?=$data2['module_id']?>" <?php if($data['parent_id'] == $data2['module_id']) echo"selected"; ?>><?=$data2['module_name']?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <?php
                    mk_htext("data[module_name]",_l('Module Name',$this),isset($data['module_name'])?$data['module_name']:'','required');
                    mk_hsubmit(_l('Submit',$this),$base_url.$page,_l('Cancel',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>