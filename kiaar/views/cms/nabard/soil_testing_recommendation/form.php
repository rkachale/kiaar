<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['test_tran_ID'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Soil test results</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Soil test results</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/soil_testing_recommendation/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
                        <div class="row margin0">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="test_ID" class="control-label col-md-4">Test Name <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <select id="test_ID" class="form-control select2" name="test_ID" data-placeholder="Please Select Test Name" data-error=".test_IDerror" required onchange="select_testname(this);">
                                            <option value="">Select Test Name</option>
                                            <?php if(isset($test_list) && count($test_list)!=0){ ?>
                                            <?php foreach ($test_list as $key => $value) { ?>
                                                <option value="<?php echo $value['testID']; ?>" <?php if( isset($data['test_ID']) && $data['test_ID'] == $value['testID']) echo"selected"; ?>> <?php echo $value['test_name']; ?></option>
                                            <?php } } ?>
                                        </select>
                                        <div class="test_IDerror error_msg"><?php echo form_error('test_ID', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="farmer_id" class="control-label col-md-4">Farmer Name <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <select id="farmer_id" class="form-control select2" name="farmer_id" data-placeholder="Please Select Farmer Name" data-error=".farmer_iderror" required>
                                            <option value="">Select Farmer Name</option>
                                            <?php if(isset($farmers_list) && count($farmers_list)!=0){ ?>
                                            <?php foreach ($farmers_list as $key => $value) { ?>
                                                <option value="<?php echo $value['FARMER_ID']; ?>" <?php if( isset($data['farmer_ID']) && $data['farmer_ID'] == $value['FARMER_ID']) echo"selected"; ?>> <?php echo ucwords(strtolower($value['FIRST_NAME'])); ?> <?php echo ucwords(strtolower($value['MIDDLE_NAME'])); ?> <?php echo ucwords(strtolower($value['LAST_NAME'])); ?></option>
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
                                        <input type="text" class="form-control" id="plot_area" name="plot_area" value="<?php echo set_value('plot_area', (isset($data['plot_area']) ? $data['plot_area'] : '')); ?>" data-error=".plot_areaerror" required>
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sample_date" class="control-label col-md-4">Sample Date <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="sample_date" name="sample_date" value="<?php echo set_value('sample_date', (isset($data['sample_date']) ? $data['sample_date'] : '')); ?>" data-error=".sample_dateerror" required>
                                        <div class="sample_dateerror error_msg"><?php echo form_error('sample_date', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="test_date" class="control-label col-md-4">Test Date <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="test_date" name="test_date" value="<?php echo set_value('test_date', (isset($data['test_date']) ? $data['test_date'] : '')); ?>" data-error=".test_dateerror" required>
                                        <div class="test_dateerror error_msg"><?php echo form_error('test_date', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="s3_link" class="control-label col-md-4">Recommendation Report </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="s3_link" name="s3_link" value="<?php echo set_value('s3_link', (isset($data['s3_link']) ? $data['s3_link'] : '')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="page_permissions_table">
                        </div>
                        <div class="row margin0">
                            <div class="col-md-offset-1 col-md-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/soil_testing_recommendation/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">

    $('#sample_date').datetimepicker({
        format:'Y-m-d',
        pickTime: false
    });

    $('#test_date').datetimepicker({
        format:'Y-m-d',
        pickTime: false
    });

    function isNumberKey(evt)
    {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
         return false;

      return true;
    }

    
    $("#formval").validate({
        rules: {
            test_ID: {
                required: true,
            },
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
            sample_date: {
                required: true,
            },
            test_date: {
                required: true,
            },
        },
        messages: {
            test_ID: {
                required: 'Please select test name',
            },
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
            sample_date: {
                required: 'Please select sample date',
            },
            test_date: {
                required: 'Please select test date',
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

<script type="text/javascript">

    var pr_id = '<?php echo $data['test_tran_ID'] ?>';
    var test_id = '<?php echo $data['test_ID'] ?>';
    
    function select_testname(sel) {
        get_menu_table(sel.value);
    }

    function get_menu_table(test_id) {
        if(test_id != '')
        {
            $.ajax({
                    type: "POST",
                    url: base_url+"cms/soil_testing_recommendation/get_menu_table",
                    data: {test_id : test_id, pr_id : pr_id},
                    success: function(html) {
                        $('#page_permissions_table').html(html);
                    }
                });
        }
        else
        {
            $('#page_permissions_table').html('<div class="page_per_msg"><h3>Select Test Name to get permission options.</h3></div>');
        }
    }

    get_menu_table();
</script>

