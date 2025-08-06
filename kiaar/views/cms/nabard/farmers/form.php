<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Farmers</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Farmers</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/farmers/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" id="FARMER_ID" name="FARMER_ID" value="<?php echo set_value('FARMER_ID', (isset($data['FARMER_ID']) ? $data['FARMER_ID'] : '')); ?>">
                        <div class="row margin0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="FIRST_NAME" class="control-label col-md-4">First Name </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="FIRST_NAME" name="FIRST_NAME" value="<?php echo set_value('FIRST_NAME', (isset($data['FIRST_NAME']) ? $data['FIRST_NAME'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="MIDDLE_NAME" class="control-label col-md-4">Middle Name </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="MIDDLE_NAME" name="MIDDLE_NAME" value="<?php echo set_value('MIDDLE_NAME', (isset($data['MIDDLE_NAME']) ? $data['MIDDLE_NAME'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="LAST_NAME" class="control-label col-md-4">Last Name </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="LAST_NAME" name="LAST_NAME" value="<?php echo set_value('LAST_NAME', (isset($data['LAST_NAME']) ? $data['LAST_NAME'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="MOBILE_NO" class="control-label col-md-4">Mobile Number </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="MOBILE_NO" name="MOBILE_NO" value="<?php echo set_value('MOBILE_NO', (isset($data['MOBILE_NO']) ? $data['MOBILE_NO'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="CLUSTER_CD" class="control-label col-md-4">Cluster CD </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="CLUSTER_CD" name="CLUSTER_CD" value="<?php echo set_value('CLUSTER_CD', (isset($data['CLUSTER_CD']) ? $data['CLUSTER_CD'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="CLUSTER_NAME" class="control-label col-md-4">Cluster Name </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="CLUSTER_NAME" name="CLUSTER_NAME" value="<?php echo set_value('CLUSTER_NAME', (isset($data['CLUSTER_NAME']) ? $data['CLUSTER_NAME'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="VILLAGE_CD" class="control-label col-md-4">Village ID </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="VILLAGE_CD" name="VILLAGE_CD" value="<?php echo set_value('VILLAGE_CD', (isset($data['VILLAGE_CD']) ? $data['VILLAGE_CD'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="VILLAGE_NAME" class="control-label col-md-4">Village Name </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="VILLAGE_NAME" name="VILLAGE_NAME" value="<?php echo set_value('VILLAGE_NAME', (isset($data['VILLAGE_NAME']) ? $data['VILLAGE_NAME'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="AADHAAR_CARD_NO" class="control-label col-md-4">Aadhar Number </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="AADHAAR_CARD_NO" name="AADHAAR_CARD_NO" value="<?php echo set_value('AADHAAR_CARD_NO', (isset($data['AADHAAR_CARD_NO']) ? $data['AADHAAR_CARD_NO'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pincode" class="control-label col-md-4">Pincode </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo set_value('pincode', (isset($data['pincode']) ? $data['pincode'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-10 col-md-offset-2">
                                <div class="">
                                    <img src="<?=$data['IMAGE_FILE_NAME']?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-offset-2 col-md-10" style="margin-top:20px;">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/farmers/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>