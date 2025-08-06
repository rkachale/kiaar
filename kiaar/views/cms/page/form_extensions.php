<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12 ">
    <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($extension_id) && !empty($extension_id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Page Content</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add New Page Content</span>
                    <?php } ?>
                </div>      
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/page_extensions/extensions/'.$relation_id); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php error_reporting(0); ?>
                        <input type="hidden" name="contents_id" value="<?php echo $data['extension_id']; ?>">
                        <input type="hidden" name="data_type" value="page">                                
                        <div class="form-group">
                            <label for="language_id" class="control-label col-lg-2">Language <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="language_id" class="form-control" name="language_id" required data-error=".languageerror">
                                    <option value="">-- Select Language --</option>
                                    <?php foreach ($languages as $key => $value) { ?>
                                    <option value="<?php echo $value['language_id']; ?>" <?php if(isset($data['language_id']) && $data['language_id'] == $value['language_id']){ echo 'selected="selected"'; } ?>><?php echo $value['language_name']; ?></option>
                                        <?php } ?>
                                </select>
                                <div class="languageerror error_msg"><?php echo form_error('language_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($data['name']) ? $data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <?php
                            mk_hWYSItexteditor("description",_l('Description',$this),isset($data['description'])?$data['description']:'','');

                            mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                        ?>

                        <div class="form-group ">
                            <label for="meta_title" class="control-label col-lg-2">Meta Title</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_title" name="meta_title" type="text" value="<?=$data['meta_title']?>" maxlength="80">
                                (Maximum Character Limit is 80)
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="data[meta_description]" class="control-label col-lg-2">Meta Description</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_description" name="meta_description" type="text" value="<?=$data['meta_description']?>" maxlength="180">
                                (Maximum Character Limit is 180)
                            </div>
                        </div>
                        <?php
                            //mk_htext("meta_title",_l('Meta Title',$this),isset($data['meta_title'])?$data['meta_title']:'');
                            //mk_htextarea("meta_description",_l('Meta Description',$this),isset($data['meta_description'])?$data['meta_description']:'');
                            mk_htextarea("meta_keywords",_l('Meta keywords',$this),isset($data['meta_keywords'])?$data['meta_keywords']:'');
                            mk_hurl_upload("meta_image",_l('Meta Image',$this),isset($data['meta_image'])?$data['meta_image']:'',"imagemeta");
                        ?>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['public']) && $data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($data['public']) ? $data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/page_extensions/extensions/'.$relation_id) ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- END SAMPLE FORM PORTLET-->                                
    </div>
</div>
<?php
    mk_popup_uploadfile(_l('Upload Image',$this),"image",$base_url."upload_image/20/");
    mk_popup_uploadfile(_l('Upload Meta Image',$this),"imagemeta",$base_url."upload_image/20/");
?>


<script type="text/javascript">
    $(document).ready(function() {
        /* public */

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
        $("#formval").validate({ 
            rules: {
                language_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
            },
            messages: {
                language_id: {
                    required: 'Please select language',
                },
                name: {
                    required: 'Please enter name',
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
                var contents_id                 = '<?php echo $data[extension_id]; ?>';
                var relation_id                 = '<?php echo $relation_id; ?>';
                var language_id                 = $('#language_id').val();
                var formname                    = "page";
                var check_result                = true;
                $('.languageerror').html('');

                function check_language(contents_id, language_id) {
                    var check_language_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"admin/ajax_check_common_language",
                        async: false,
                        data: {contents_id : contents_id, relation_id : relation_id, language_id : language_id, formname : formname},
                        success: function(response){
                            if(response == '')
                            {
                                check_language_result = false;
                            }
                        }
                    });
                    return check_language_result;
                }

                check_result = check_language(contents_id, language_id);

                if(check_result == false)
                {
                    $('.languageerror').html('Page content for this language is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
        });
</script>