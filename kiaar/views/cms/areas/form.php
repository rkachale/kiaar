<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>

<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Area</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Area</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/areas/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="name" class="control-label col-lg-2">Area Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                    <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="slug" class="control-label col-lg-2">Slug <span class="asterisk">*</span> <span><a title="Add slug in proper format like test-slug or test." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="slug" name="slug" value="<?php echo set_value('slug', (isset($post_data['slug']) ? $post_data['slug'] : '')); ?>" required data-error=".slugerror" maxlength="250">
                                    <div class="slugerror error_msg"><?php echo form_error('slug', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <?php 
                                $permissions = $post_data['institute_id']; 
                                $arr1 = explode(',' , $permissions);
                            ?>
                           

                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">Email <span class="asterisk">*</span> <span><a title="You can add email ids separated by comma, on which applicant's details will be sent." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email', (isset($post_data['email']) ? $post_data['email'] : '')); ?>" required data-error=".emailerror" maxlength="250">
                                    <div class="emailerror error_msg"><?php echo form_error('email', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">Grid Image <span class="asterisk">*</span> <span><a title="Here you can crop image according to you." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="grid_image" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['grid_image']) && !empty($post_data['grid_image'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/areas_upload/<?php echo $post_data['grid_image']; ?>" height="170px" width="170px" />
                                                <input id="croppie_upload_image" type="file" class="croppie-input" placeholder="Photo" capture>
                                            <?php } else { ?>
                                                <input id="croppie_upload_image" type="file" class="croppie-input cc" placeholder="Photo" capture required>
                                            <?php } ?>
                                            <input type="hidden" id="croppie-thumbnail" name="thumbnail" class="croppie-input" required>
                                        </div>
                                    </div>
                                
                                    <div id="uploadimageModal" class="modal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Crop Image</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 text-center">
                                                            <div id="profile_image_demo"  style=""></div>
                                                        </div>
                                                        <div class="col-md-4" style="padding-top:0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="skip" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn green crop_image">Crop</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if(isset($data_image) && is_array($post_data) && count($post_data)): $i=1; ?>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Uploaded Images</label>
                                    <div class="col-lg-10 col-sm-10 row_position">
                                        <?php
                                            foreach ($data_image as $key => $data) { 
                                            $ext = pathinfo($data['image'], PATHINFO_EXTENSION);
                                        ?>
                                            <ul class="imagelocation<?php echo $data['id'] ?> gallerybg" id="sortable">
                                                <li style="list-style: none;" data-id="<?php echo $data['id'] ?>">
                                                    <?php if($ext == 'mp4') { ?>
                                                        <video class="respimg" width="200" height="200" controls>
                                                            <source src="<?php echo base_url(); ?>upload_file/areas_upload/<?=$data['image']?>" type="video/<?=$ext?>"></source>
                                                        </video>
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>upload_file/areas_upload/<?php echo $data['image']; ?>" style="vertical-align:middle;" width="200" height="200">
                                                    <?php } ?>
                                                    <a href="javascript:void(0);" class="btn btn_bg_custred height200btn" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/areas/delete_banner_image/'.$data["id"]); ?>');">X</a>
                                                </li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Upload Banner Images <span class="asterisk">*</span> <span><a title="Add banner image for Area detail page." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="custom-file-upload">
                                    <input type="file" name="userfile[]" id="image_file" accept=".png,.jpg,.jpeg,.gif,.mp4,.mpeg,.mpg,.avi,.mov"  data-max-size="8192‬"  multiple <?php if($data_image == '') {?>required<?php } else { ?> <?php } ?>>
                                </div>
                                </div>
                            </div>


                            <?php $predifined_consultancy = '<div class="psub-head mtop40">Connect with us</div><ul class="contli"><li><img src="/assets/research/img/phone.svg" alt=""/> (91-22) 672 83181</li><li><img src="/assets/research/img/mail.svg" alt=""/> research@somaiya.edu</li></ul>';
                            $predifined_description = '';?>
                            <?php
                                mk_hWYSItexteditor("description",_l('Description',$this),isset($post_data['description'])?$post_data['description']:$predifined_description,'required');
                            ?>

                            <?php $this->load->view('cms/areas/consultancy'); ?>

                            <?php
                                mk_hWYSItexteditor("consultancy",_l('Connect with us',$this),isset($post_data['consultancy'])?$post_data['consultancy']:$predifined_consultancy,'');
                            ?>

                            <div class="form-group ">
                                <label for="meta_title" class="control-label col-lg-2">Meta Title</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="meta_title" name="meta_title" type="text" value="<?=$post_data['meta_title']?>" maxlength="80">
                                    (Maximum Character Limit is 80)
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="post_data[meta_description]" class="control-label col-lg-2">Meta Description</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="meta_description" name="meta_description" type="text" value="<?=$post_data['meta_description']?>" maxlength="180">
                                    (Maximum Character Limit is 180)
                                </div>
                            </div>
                            <?php
                                mk_htextarea("meta_keywords",_l('Meta keywords',$this),isset($post_data['meta_keywords'])?$post_data['meta_keywords']:'');
                            ?>
                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this event on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/areas/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<script type="text/javascript">
    $("#manage_form").validate({
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                institute: {
                    required: true,
                },
                email: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Please enter area name',
                },
                slug: {
                    required: 'Please enter slug',
                },
                institute: {
                    required: 'Please select institute',
                },
                email: {
                    required: 'Please enter email id',
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
<style type="text/css">.fa-info-circle{font-size: 18px;}</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/croppie/croppie.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/croppie/custom_croppie.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/croppie/croppie.js"></script> 

<script type="text/javascript">

    $(document).ready(function() {
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

    $(document).ready(function() {
        $image_crop = $('#profile_image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 350,
                height: 200,
                // type: 'circle',
            },
            boundary: {
                width: 350,
                height: 200
            }
        });

        $('#croppie_upload_image').on('change', function() {
            var reader = new FileReader();
            var nam;
            if (event.target.value.length > 0) {
                nam = event.target.files[0].name;
                document.getElementById("croppie-profile").value = nam;
                // console.log(nam);

                reader.onload = function(event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function() {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                console.log(this.files);
                $('#uploadimageModal').appendTo("body").modal('show');
            }
        });

        $('.crop_image').click(function(event) {
            $image_crop.croppie('result', {
                circle: false,
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                $('#uploadimageModal').modal('hide');
                $('#croppie-image').attr('src', response);
                $('#croppie_upload_image').attr('value', response);
                $('#croppie-thumbnail').attr('value', response);
            })
        });
    });

    $("#croppie-image").click(function(e) {
        $("#croppie_upload_image").click();
    });
</script>

<style type="text/css">
.cc{display: block!important;}
.croppie-input {
    overflow: visible;
     font-size: 14px!important; 
     background: none!important; 
     padding: 0px!important; 
     border-radius: 0px!important; 
     margin: 0px!important; 
}
</style>


<script type="text/javascript">

    (function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });

</script>