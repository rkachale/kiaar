<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Soil Master</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Soil Master</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/soil_master/'); ?>">Back </a></span>
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
                                    <label for="plot_no" class="control-label col-md-4">Plot No <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <select id="plot_no" class="form-control select2" name="plot_no" data-placeholder="Please Select Plot no." data-error=".plot_noerror" required <?php //if(isset($data['plot_no']) && $data['plot_no']) echo"disabled"; ?>>
                                            <option value="">Select Plot no.</option>
                                            <?php if(isset($plot_list) && count($plot_list)!=0){ ?>
                                            <?php foreach ($plot_list as $key => $value) { ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if( isset($data['plot_no']) && $data['plot_no'] == $value['id']) echo"selected"; ?>><?php echo $value['plot_no']; ?></option>
                                            <?php } } ?>
                                        </select>
                                        <div class="plot_noerror error_msg"><?php echo form_error('plot_no', '<label class="error">', '</label>'); ?></div>
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
                                    <label for="report_name" class="control-label col-md-4">Recommendation Report Name <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="report_name" name="report_name" value="<?php echo set_value('report_name', (isset($data['report_name']) ? $data['report_name'] : '')); ?>" data-error=".report_nameerror" required>
                                        <div class="report_nameerror error_msg"><?php echo form_error('report_name', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="report_link" class="control-label col-md-4">Recommendation Report Link <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="url" class="form-control" id="report_link" name="report_link" value="<?php echo set_value('report_link', (isset($data['report_link']) ? $data['report_link'] : '')); ?>" data-error=".report_linkerror" required>
                                        <div class="report_linkerror error_msg"><?php echo form_error('report_link', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="">
                            <?php //$this->load->view('cms/nabard/soil_master/links'); ?>
                        </div> -->
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
                                <a href="<?php echo base_url('cms/soil_master/'); ?>" class="btn btn-default" type="button">Cancel</a>
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


        /* status */

        if ($('#sms_flag_checkbox').is(':checked')) {
            $('#sms_flag').val(1);
        }else{
            $('#sms_flag').val(0);
        }

        $('#sms_flag_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#sms_flag').val(1);
            }else{
                $('#sms_flag').val(0);
            }
        });
        
    });
</script>

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

    $("#formval").validate({
        rules: {
            farmer_id: {
                required: true,
            },
            plot_no: {
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
            farmer_id: {
                required: 'Please select farmer',
            },
            plot_no: {
                required: 'Please enter plot no.',
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