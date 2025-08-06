<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['post_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Post</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Post</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/post/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                      <!-- 
                            <div class="form-group">
                                <label for="category_id" class="control-label col-lg-2">Category</label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="single" class="form-control select2" name="category_id" data-placeholder="Category"><option value="">Select Category</option>
                                        <?php if(isset($category) && count($category)!=0){ ?>
                                        <?php foreach ($category as $key => $value) { ?>
                                            <option value="<?php echo $value['category_id']; ?>" <?php if( isset($post_data['category_id']) && $post_data['category_id'] == $value['category_id']) echo "selected"; ?> > <?php echo $value['category_name']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div> -->
                    

                        <div class="form-group ">
                            <label for="post_name" class="control-label col-lg-2">Post Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="post_name" name="post_name" value="<?php echo set_value('post_name', (isset($post_data['post_name']) ? $post_data['post_name'] : '')); ?>" required data-error=".post_nameerror" maxlength="250" required>
                                <div class="post_nameerror error_msg"><?php echo form_error('post_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <input type="hidden" name="contents_id" value="<?php echo set_value('contents_id', (isset($post_data['contents_id']) ? $post_data['contents_id'] : '')); ?>" >
                        <input type="hidden" name="data_type" value="post">
                        <input type="hidden" name="language_id" value="1"> <!-- 1=english lang -->

                       
                           <!--  <div class="form-group">
                                <label for="location" class="control-label col-lg-2">Location</label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="single" class="form-control select2" name="location" data-placeholder="Location"><option value="">Select Location</option>
                                        <?php if(isset($location) && count($location)!=0){ ?>
                                        <?php foreach ($location as $key => $value) { ?>
                                            <option value="<?php echo $value['location_id']; ?>" <?php if( isset($post_data['location_id']) && $post_data['location_id'] == $value['location_id']) echo"selected"; ?> > <?php echo $value['location_name']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                 
 -->
                        <?php 
                           // mk_htext("paper",_l('Paper',$this),isset($post_data['paper'])?$post_data['paper']:'');
                           
                        ?>

                       <!-- 
                            <div class="form-group ">
                                <label for="person_name" class="control-label col-lg-2">Person's Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="person_name" name="person_name" value="<?php echo set_value('person_name', (isset($post_data['person_name']) ? $post_data['person_name'] : '')); ?>" maxlength="250">
                                </div>
                            </div> -->


                          <!--   <div class="form-group ">
                                <label for="designation" class="control-label col-lg-2">Designation</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="designation" name="designation" value="<?php echo set_value('designation', (isset($post_data['designation']) ? $post_data['designation'] : '')); ?>" maxlength="250">
                                </div>
                            </div> -->
                     

                        <div class="form-group ">
                            <label for="publish_date" class="control-label col-lg-2">Publish Date <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <input type="text" id="datetimepicker2" name="publish_date" value="<?php if(isset($post_data['publish_date'])) { echo $post_data['publish_date']; } ?>" required />
                        </div>

                        <?php
                            mk_hWYSItexteditor("description",_l('Description',$this),isset($post_data['description'])?$post_data['description']:'','');
                            //mk_hurl_upload("image",_l('Image',$this),isset($post_data['image'])?$post_data['image']:'',"image");
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php $this->load->view('cms/post/post_image'); ?>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="meta_title" class="control-label col-lg-2">Meta Title&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Maximum Character Limit is 180"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_title" name="meta_title" type="text" value="<?php if(isset($post_data['meta_title'])) { echo $post_data['meta_title']; } ?>" maxlength="80">
                                <!-- (Maximum Character Limit is 80) -->
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="post_data[meta_description]" class="control-label col-lg-2">Meta Description&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Maximum Character Limit is 180"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_description" name="meta_description" type="text" value="<?php if(isset($post_data['meta_description'])) { echo $post_data['meta_description']; } ?>" maxlength="180">
                                <!-- (Maximum Character Limit is 180) -->
                            </div>
                        </div>
                        
                        <?php
                            mk_htextarea("meta_keywords",_l('Meta keywords',$this),isset($post_data['meta_keywords'])?$post_data['meta_keywords']:'');

                            //mk_hurl_upload("meta_image",_l('Meta Image',$this),isset($post_data['meta_image'])?$post_data['meta_image']:'',"imagemeta");

                            mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php $this->load->view('cms/post/meta_image'); ?>
                            </div>
                        </div>
                       <!--  <div class="form-group">
                            <label for="whats_new" class="control-label col-lg-2">What's New&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this post on homepage What’s New section." aria-describedby="tooltip453958"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control whats_new" id="whats_new_checkbox" type="checkbox" <?php if(isset($post_data['whats_new']) && $post_data['whats_new'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('whats_new', (isset($post_data['whats_new']) ? $post_data['whats_new'] : '')); ?>" style="display: none;" id="whats_new" name="whats_new" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group expiry_wrap hidden">
                            <label for="data[whats_new_expiry_date]" class="control-label col-lg-2">What's New Expiry Date</label>
                            <div class="col-lg-10">
                                <input type="text" id="whats_new_expiry_date" name="whats_new_expiry_date" value="<?php echo set_value('data[whats_new_expiry_date]', (isset($post_data['whats_new_expiry_date']) ? $post_data['whats_new_expiry_date'] : '')); ?>" />
                            </div>
                        </div> -->

                      
                         <!--    <div class="form-group ">
                                <label for="html_slider" class="control-label col-lg-2">HTML Slider</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="html_checkbox" type="checkbox" <?php if(isset($post_data['html_slider']) && $post_data['html_slider'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('html_slider', (isset($post_data['html_slider']) ? $post_data['html_slider'] : '')); ?>" style="display: none;" id="html_slider" name="html_slider" checked="" type="text">
                                </div>
                            </div>
                     -->

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this post on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/post/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>
<?php
    mk_popup_uploadfile(_l('Upload Image',$this),"image",$base_url."upload_image/20/");
    mk_popup_uploadfile(_l('Upload Meta Image',$this),"imagemeta",$base_url."upload_image/20/");
?>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
    $('#datetimepicker1').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
    });

    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d',
        //minDate:new Date()
    });

    $('#whats_new_expiry_date').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
    });
</script>

<script type="text/javascript">
    $(document).ready(function() 
    {
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

        /* whats new */

        if ($('#whats_new_checkbox').is(':checked')) {
            $('#whats_new').val(1);
        }else{
            $('#whats_new').val(0);
        }

        $('#whats_new_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#whats_new').val(1);
            }else{
                $('#whats_new').val(0);
            }
        });

        /* HTML slider */

        if ($('#html_checkbox').is(':checked')) {
            $('#html_slider').val(1);
        }else{
            $('#html_slider').val(0);
        }

        $('#html_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#html_slider').val(1);
            }else{
                $('#html_slider').val(0);
            }
        });
            
    });
</script>

<script type="text/javascript">
    $(document).ready(function(event) 
    {
        if($('.whats_new').is(':checked')) 
        {
            $('.expiry_wrap').removeClass('hidden');
            $('#whats_new1').val(1);
        }else{
            $('.expiry_wrap').addClass('hidden');
            $('#whats_new1').val(0);
        }
            
        $('.whats_new').click(function() 
        {
            if($(this).is(':checked'))
            {
                $('.expiry_wrap').removeClass('hidden');
                $('#whats_new1').val(1);
            }else{
                $('.expiry_wrap').addClass('hidden');
                $('#whats_new1').val(0);
            }
        });

        $('.cmxform').submit(function(event)
        {
            if($('.whats_new').is(':checked')) 
            {
                if($('#whats_new_expiry_date').val() == '' || $('#whats_new_expiry_date').val() == '0000-00-00')
                {
                    swal({
                        title: "Oops...",
                        text: "Please select expiry date for what's new section",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonClass: "btn btn-success mr10",
                        cancelButtonClass: "btn btn-danger",
                        buttonsStyling: false,
                        confirmButtonText: "Ok"
                    }).then(function () {
                    }, function(dismiss) {});
                    event.preventDefault();
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $("#formval").validate({
        rules: {
            // language_id: {
            //     required: true,
            // },
            post_name: {
                required: true,
            },
            publish_date: {
                required: true,
            },
        },
        messages: {
            // language_id: {
            //     required: 'Please select language',
            // },
            post_name: {
                required: 'Please enter post name',
            },
            publish_date: {
                required: 'Please select publish date',
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