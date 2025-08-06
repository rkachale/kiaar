<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['pr_id'])) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Permissions</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Permission</span>
                   <?php } ?>                    
                </div>
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('permissions/view_page_permissions'); ?>">Back</a> </span>
            </div>
            <div class="panel-body">
                <div class=" form">
                    <?php error_reporting(0); ?>
                    <form id="permissions_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label for="pr_group_id" class="control-label col-lg-2">Groups <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="pr_group_id" class="form-control select2" name="pr_group_id" data-placeholder="Select Group" required data-error=".grouperror">
                                    <option value="">Select Group</option>
                                    <?php if(isset($groups) && count($groups)!=0){ ?>
                                    <?php foreach ($groups as $key2 => $data2) { if (isset($data2['group_id']) and $data2['group_id'] != '1') { ?>
                                        <option value="<?=$data2['group_id']?>" <?php if($group_id == $data2['group_id']) echo"selected"; ?>><?=$data2['group_name']?></option>
                                        <?php unset($data2); }?>
                                    <?php } } ?>
                                </select>
                                <div class="grouperror error_msg"><?php echo form_error('pr_group_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pr_inst_id" class="control-label col-lg-2">Institutions <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="pr_inst_id" class="form-control select2" name="pr_inst_id" data-placeholder="Select Institute" required data-error=".instituteerror" onchange="select_institute(this);">
                                    <option value="">Select Institute</option>
                                    <?php if(isset($institutes_list) && count($institutes_list)!=0){ ?>
                                    <?php foreach ($institutes_list as $key3 => $data3) { ?>
                                        <option value="<?=$data3['INST_ID']?>" <?php if($institute_id == $data3['INST_ID']) echo"selected"; ?>><?=$data3['INST_NAME']?></option>
                                    <?php } } ?>
                                </select>
                                <div class="instituteerror error_msg"><?php echo form_error('pr_inst_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12 col-sm-12" id="page_permissions_table">
                                <?php //$this->load->view('permissions/page_permissions_table', $this); ?> 
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit" id="submit_permissions">
                                <a href="<?php echo base_url('permissions/view_page_permissions'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var pr_id = '<?php echo $pr_id; ?>';
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

    function select_institute(sel) {
        get_menu_table(sel.value);
    }

    function get_menu_table(inst_id) {
        if(inst_id != '')
        {
            $.ajax({
                    type: "POST",
                    url: base_url+"permissions/get_menu_table",
                    data: {inst_id : inst_id, pr_id : pr_id},
                    // beforeSend: function() {
                    //     $('.loader_bg').show();
                    // },
                    success: function(html) {
                        $('#page_permissions_table').html(html);
                        // $('.loader_bg').fadeOut("slow");
                    }
                });
        }
        else
        {
            $('#page_permissions_table').html('<div class="page_per_msg"><h3>Select institute to get permission options.</h3></div>');
        }
    }

    get_menu_table('<?php echo $institute_id; ?>');
</script>