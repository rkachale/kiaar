<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($video_data['image_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Video</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Video</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/video/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php
                        // echo "<pre>";
                        // print_r($video_data);
                        // exit(); 
                        ?>

                        <div class="form-group ">
                            <label for="video_title" class="control-label col-lg-2">Video Title <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="video_title" name="video_title" value="<?php echo set_value('video_title', (isset($video_data['video_text']) ? $video_data['video_text'] : '')); ?>" data-error=".video_titleerror" maxlength="250" required>
                                <div class="video_titleerror error_msg"><?php echo form_error('video_title', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="video_url" class="control-label col-lg-2">Video Url <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="url" class="form-control" id="video_url" name="video_url" value="<?php echo set_value('video_url', (isset($video_data['video_url']) ? $video_data['video_url'] : '')); ?>" data-error=".video_urlerror" maxlength="250">
                                <div class="video_urlerror error_msg"><?php echo form_error('video_url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="video_date" class="control-label col-lg-2">Video Date <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <input type="text" id="video_date" name="video_date" value="<?php if(isset($video_data['date'])) { echo $video_data['date']; } ?>" required />
                            <div class="video_dateerror error_msg"><?php echo form_error('video_date', '<label class="error">', '</label>'); ?></div>
                        </div>

                        <div class="form-group ">
                            <label for="video_description" class="control-label col-lg-2">Video Description <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="video_description" name="video_description" required data-error=".video_descriptionerror" cols="10" rows="5"><?php echo set_value('video_description', (isset($video_data['video_description']) ? $video_data['video_description'] : '')); ?></textarea>
                                <div class="video_descriptionerror error_msg"><?php echo form_error('video_description', '<label class="error">', '</label>'); ?></div>

                            </div>
                        </div>
                                                
                        <div class="form-group ">
                            <label for="embed_code" class="control-label col-lg-2">Embed Code <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="embed_code" name="embed_code" required data-error=".embed_codeerror" cols="10" rows="5"><?php echo set_value('embed_code', (isset($video_data['embed_code']) ? $video_data['embed_code'] : '')); ?></textarea>
                                <div class="embed_codeerror error_msg"><?php echo form_error('embed_code', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="spotlight_video" class="control-label col-lg-2">Spotlight Video&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="This videos are like featured video which will display on homepage"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="spotlight_checkbox" type="checkbox" <?php if(isset($video_data['spotlight_video']) && $video_data['spotlight_video'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('spotlight_video', (isset($video_data['spotlight_video']) ? $video_data['spotlight_video'] : '')); ?>" style="display: none;" id="spotlight_video" name="spotlight_video" checked="" type="text">
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="featured_video" class="control-label col-lg-2">Featured Video&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this video on homepage"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="featured_checkbox" type="checkbox" <?php if(isset($video_data['featured_video']) && $video_data['featured_video'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('featured_video', (isset($video_data['featured_video']) ? $video_data['featured_video'] : '')); ?>" style="display: none;" id="featured_video" name="featured_video" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this video on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($video_data['public']) && $video_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($video_data['public']) ? $video_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/video/'); ?>" class="btn btn-default" type="button">Cancel</a>
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

    $('#video_date').datetimepicker({
        format:'Y-m-d',
        //minDate:new Date()
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

        /* spotlight_video */

        if ($('#spotlight_checkbox').is(':checked')) {
            $('#spotlight_video').val(1);
        }else{
            $('#spotlight_video').val(0);
        }

        $('#spotlight_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#spotlight_video').val(1);
            }else{
                $('#spotlight_video').val(0);
            }
        });


        /* featured_video */

        if ($('#featured_checkbox').is(':checked')) {
            $('#featured_video').val(1);
        }else{
            $('#featured_video').val(0);
        }

        $('#featured_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#featured_video').val(1);
            }else{
                $('#featured_video').val(0);
            }
        });
            
    });
</script>

<script type="text/javascript">
    $("#formval").validate({
        rules: {
            video_title: {
                required: true,
            },
            video_url: {
                required: true,
            },
            video_description: {
                required: true,
            },
            embed_code: {
                required: true,
            },
            video_date: {
                required: true,
            },
        },
        messages: {
            video_title: {
                required: 'Please enter video title',
            },
            video_url: {
                required: 'Please enter video url',
            },
            video_description: {
                required: 'Please enter video description',
            },
            embed_code: {
                required: 'Please enter video embed code',
            },
            video_date: {
                required: 'Please select video date',
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