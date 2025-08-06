<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['pr_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Permissions</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Permissions</span>
                   <?php } ?>                    
                </div>
                &nbsp;&nbsp;<span class="custpurple"><button class="brownsmall btn brown" onclick="history.go(-1);">Back</button> </span>
            </div>
            <div class="panel-body">
                <div class=" form">
                    <?php error_reporting(0); ?>
                    <form id="permissions_form" class="cmxform form-horizontal tasi-form" method="post" action="<?php echo base_url('permissions/edit_permissions/'.(isset($data['pr_id']) ? '/'.$data['pr_id'] : '')); ?>">
                        <div class="form-group">
                            <label for="pr_group_id" class="control-label col-lg-2">Groups <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="pr_group_id" class="form-control select2" name="pr_group_id" data-placeholder="Select Group" required data-error=".grouperror">
                                    <option value="">Select Group</option>
                                    <?php if(isset($groups) && count($groups)!=0){ ?>
                                    <?php foreach ($groups as $key2 => $data2) { if (isset($data2['group_id']) and $data2['group_id'] != '1') { ?>
        
                                        <option value="<?=$data2['group_id']?>" <?php if($data['pr_group_id'] == $data2['group_id']) echo"selected"; ?>><?=$data2['group_name']?></option>
                                        <?php unset($data2);
    }?>
                                    <?php } } ?>
                                </select>
                                <div class="grouperror error_msg"><?php echo form_error('pr_group_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="pr_inst_id" class="control-label col-lg-2">Institutions <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="pr_inst_id" class="form-control select2" name="pr_inst_id" data-placeholder="Select Institute" required data-error=".instituteerror">
                                    <option value="">Select Institute</option>
                                    <?php if(isset($institutes_list) && count($institutes_list)!=0){ ?>
                                    <?php foreach ($institutes_list as $key3 => $data3) { ?>
                                        <option value="<?=$data3['INST_ID']?>" <?php if($data['pr_inst_id'] == $data3['INST_ID']) echo"selected"; ?>><?=$data3['INST_NAME']?></option>
                                    <?php } } ?>
                                </select>
                                <div class="instituteerror error_msg"><?php echo form_error('pr_inst_id', '<label class="error">', '</label>'); ?></div>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-12 col-sm-12">
                                <?php $this->load->view('permissions/permissions_table', $this); ?> 
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit" id="submit_permissions">
                                <a href="<?php echo base_url('permissions/view_permissions'); ?>" class="btn btn-default" type="button">Cancel</a>
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
    $('#datetimepicker1').datetimepicker({
        format:'Y-m-d H:i:s',
    });

    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d H:i:s',
    });

    var grouprequired = 'Please select group';
    var instituterequired = 'Please select institute';

    $("#permissions_form").validate({
        rules: {
            pr_group_id: {
                required: true
            },
            pr_inst_id: {
                required: true
            },
        },
        messages: {
            pr_group_id:{
                required: grouprequired
            },
            pr_inst_id:{
                required: instituterequired
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
        submitHandler: function(form){
            function error_message(message) {
                swal({
                    title: "Oops...",
                    text: message,
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonClass: "btn btn-success mr10",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false,
                    confirmButtonText: "Ok"
                }).then(function () {
                    return false;
                }, function(dismiss) {});
            }

            if(!$('input[type="checkbox"]').is(':checked'))
            {
                error_message('Please check at least one checkbox');
            }
            else
            {
                $("#submit_permissions").val("Please Wait...");
                $("#submit_permissions").attr('disabled', 'disabled');
                form.submit();
            }
        }
    });
</script>