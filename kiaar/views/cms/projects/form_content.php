    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($project_content_id) && !empty($project_content_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Project Content</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Project Content</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/projects/project_content/'.$project_id); ?>">Back </a></span>
                </div>  
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                           <input type="hidden" name="project_content_id" value="<?php echo $project_content_id; ?>">
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                            <div class="form-group">
                                <label for="language_id" class="control-label col-lg-2">Language <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="language_id" class="form-control" name="language_id" required data-error=".languageerror">
                                        <option value="">-- Select Language --</option>
                                        <?php foreach ($languages as $key => $value) { ?>
                                            <option value="<?php echo $value['language_id']; ?>" <?php if(isset($post_data['language_id']) && $post_data['language_id'] == $value['language_id']){ echo 'selected="selected"'; } ?>><?php echo $value['language_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="languageerror error_msg"><?php echo form_error('language_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="title" class="control-label col-lg-2">Title <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', (isset($post_data['title']) ? $post_data['title'] : '')); ?>" required data-error=".titleerror" maxlength="250">
                                    <div class="titleerror error_msg"><?php echo form_error('title', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <?php 
                                mk_hWYSItexteditor("description",_l('Description',$this),isset($post_data['description'])?$post_data['description']:'','required');
                                mk_hWYSItexteditor("content",_l('Content',$this),isset($post_data['content'])?$post_data['content']:'','required');
                            ?>
                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/projects/project_content/'.$project_id) ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            if ($('#public_checkbox').is(':checked')) {
                $('#public').val(1);
            }else{
                $('#public').val(0);
            }

            $('#public_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#public').val(1);
                }else{
                    $('#public').val(0);
                }
            });
        });

        $("#manage_form").validate({
            rules: {
                language_id: {
                    required: true,
                },
                title: {
                    required: true,
                },
            },
            messages: {
                language_id: {
                    required: 'Please select language',
                },
                title: {
                    required: 'Please enter title',
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
                var project_content_id   = '<?php echo $project_content_id; ?>';
                var project_id                  = '<?php echo $project_id; ?>';
                var language_id                 = $('#language_id').val();
                var check_result                = true;
                $('.languageerror').html('');

                function check_language(project_content_id, language_id) {
                    var check_language_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"projects/ajax_check_language",
                        async: false,
                        data: {project_content_id : project_content_id, project_id : project_id, language_id : language_id},
                        success: function(response){
                            if(response == '')
                            {
                                check_language_result = false;
                            }
                        }
                    });
                    return check_language_result;
                }

                check_result = check_language(project_content_id, language_id);

                if(check_result == false)
                {
                    $('.languageerror').html('Project content for this language is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
        });
    </script>