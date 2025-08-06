<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Plot</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Plot</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/plot_master/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
                        <div class="row margin0">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="farmer_id" class="control-label col-md-4">Farmer Name <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <select id="farmer_id" class="form-control select2" name="farmer_id" data-placeholder="Please Select Farmer Name" data-error=".farmer_iderror" required>
                                            <option value="">Select Farmer Name</option>
                                            <?php if(isset($farmers_list) && count($farmers_list)!=0){ ?>
                                            <?php foreach ($farmers_list as $key => $value) { ?>
                                                <option value="<?php echo $value['FARMER_ID']; ?>" <?php if( isset($data['FARMER_ID']) && $data['FARMER_ID'] == $value['FARMER_ID']) echo"selected"; ?>> <?php echo ucwords(strtolower($value['FIRST_NAME'])); ?> <?php echo ucwords(strtolower($value['MIDDLE_NAME'])); ?> <?php echo ucwords(strtolower($value['LAST_NAME'])); ?></option>
                                            <?php } } ?>
                                        </select>
                                        <div class="farmer_iderror error_msg"><?php echo form_error('farmer_id', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="survey_no" class="control-label col-md-4">Survey No <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="survey_no" name="survey_no" value="<?php echo set_value('survey_no', (isset($data['survey_no']) ? $data['survey_no'] : '')); ?>" data-error=".survey_noerror" required>
                                        <div class="survey_noerror error_msg"><?php echo form_error('survey_no', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="plot_no" class="control-label col-md-4">Plot No <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="plot_no" name="plot_no" value="<?php echo set_value('plot_no', (isset($data['plot_no']) ? $data['plot_no'] : '')); ?>" data-error=".plot_noerror" required>
                                        <div class="plot_noerror error_msg"><?php echo form_error('plot_no', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="plot_area" class="control-label col-md-4">Area <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="plot_area" name="plot_area" value="<?php echo set_value('area', (isset($data['area']) ? $data['area'] : '')); ?>" data-error=".plot_areaerror" required>
                                        <div class="plot_areaerror error_msg"><?php echo form_error('plot_area', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="future_crop" class="control-label col-md-4">Future Crop <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="future_crop" name="future_crop" value="<?php echo set_value('future_crop', (isset($data['future_crop']) ? $data['future_crop'] : '')); ?>" data-error=".future_croperror" required>
                                        <div class="future_croperror error_msg"><?php echo form_error('future_crop', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="soil_type" class="control-label col-md-4">Soil Type <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="soil_type" name="soil_type" value="<?php echo set_value('soil_type', (isset($data['soil_type']) ? $data['soil_type'] : '')); ?>" data-error=".soil_typeerror" required>
                                        <div class="soil_typeerror error_msg"><?php echo form_error('soil_type', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                    <div class="col-lg-10 col-sm-10">
                                        <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($data['status']) && $data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                        <input value="<?php echo set_value('status', (isset($data['status']) ? $data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-offset-1 col-md-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/plot_master/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() 
    {
        /* status */

        if ($('#status_checkbox').is(':checked')) {
            $('#status').val(1);
        }else{
            $('#status').val(0);
        }

        $('#status_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#status').val(1);
            }else{
                $('#status').val(0);
            }
        });
    });
</script>

<script type="text/javascript">
    $("#formval").validate({
        rules: {
            farmer_id: {
                required: true,
            },
            survey_no: {
                required: true,
            },
            plot_no: {
                required: true,
            },
            plot_area: {
                required: true,
            },
            future_crop: {
                required: true,
            },
            soil_type: {
                required: true,
            },
        },
        messages: {
            farmer_id: {
                required: 'Please select farmer',
            },
            survey_no: {
                required: 'Please enter survey no.',
            },
            plot_no: {
                required: 'Please enter plot no.',
            },
            plot_area: {
                required: 'Please enter plot area',
            },
            future_crop: {
                required: 'Please enter future crop',
            },
            soil_type: {
                required: 'Please enter soil type',
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
    });
</script>