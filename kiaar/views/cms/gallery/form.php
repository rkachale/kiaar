<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
         
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                            
                              <?php if(isset($data['g_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Gallery</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Gallery</span>
                    <?php } ?>
                    </div>   
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/gallery/'); ?>">Back </a></span>
                                  
                </div>
                
              
            <div class="panel-body">
                <div class=" form">
                    <form method="POST" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' id="formval">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="span_small" class="control-label col-lg-2">Title <span class="asterisk">*</span></label>
                                    <div class="col-lg-10 col-sm-10">
                                        <input type="text" name="title" class="form-control"   value="<?php echo set_value('title', (isset($data['title']) ? $data['title'] : '')); ?>" required id="title" />
                                        <input type="hidden" name="name" class="form-control"   value="<?php echo set_value('name', (isset($data['name']) ? $data['name'] : '')); ?>"  required id="name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Type</label>
                                    <div class="col-lg-10 col-sm-10">
                                        <select id="galtype" class="form-control select2" name="type_id" data-placeholder="Select Type">
                                            <option value="">Select Type</option>
                                            <?php if(isset($type) && count($type)!=0){ ?>
                                            <?php foreach ($type as $key => $data6) { ?>
                                                <option value="<?=$data6['id']?>" <?php if(isset($data['type_id']) && !empty($data['type_id'])){if( $data6['id'] == $data['type_id']){ echo"selected";}} ?> ><?=$data6['type_name']?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group ">
                                    <label for="date" class="control-label col-lg-2">Date <span class="asterisk">*</span></label>&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="datetimepicker2" name="date" value="<?php if(isset($data['date'])) { echo $data['date']; } ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" style="display:none;">
                                <label class="control-label col-lg-2">Featured Image <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <?php error_reporting(0);
                                        if(isset($data['featured_img']) && !empty($data['featured_img']) && count($data['featured_img']) > 0){ 
                                    ?>
                                        <ul class="imagelocation<?php echo $data['g_id'] ?> gallerybg" id="sortable">
                                            <li id="item-<?php echo $data['g_id'] ?>">
                                                <img src="<?php echo base_url(); ?>upload_file/gallery_upload/<?php echo $data['name']; ?>/<?php echo $data['featured_img']; ?>"  style="vertical-align:middle;" width="80" height="80">
                                                <span class="close" style="cursor:pointer;" onclick="javascript:deletefeaimage(<?php echo $data['g_id'] ?>)">X<span>
                                            </li>
                                        </ul>                        

                                    <?php 
                                        } else{
                                    ?> 
                                    <div class="form-group">
                                        <div class="col-lg-12 col-sm-10">
                                            <div class="custom-file-upload">
                                                <input type="file" name="featured" id="featured">
                                                 <div data-error=".featurederror" class="featurederror error_msg"><?php echo form_error('featured', '<label class="error">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if(isset($gallery_data_image) && is_array($data) && count($data)): $i=1; ?>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Uploaded Images</label>
                                    <div class="col-lg-10 col-sm-10">
                                        <?php 
                                        foreach ($gallery_data_image as $key => $data1) { 
                                        ?>
                                            <ul class="imagelocation<?php echo $data1['id'] ?> gallerybg" id="sortable">
                                              <li>
                                                <img src="<?php echo base_url(); ?>upload_file/gallery_upload/<?php echo $data1['name']; ?>/<?php echo $data1['image']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                <span class="close" style="cursor:pointer;" onclick="javascript:deleteimage(<?php echo $data1['id'] ?>)">X<span>
                                              </li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Multiple Image</label>
                                    <div class="col-lg-10 col-sm-10">
                                        <div class="uploader__box js-uploader__box l-center-box">
                                            <div class="uploader__contents">
                                                <label class="button button--secondary" for="fileinput">Multiple Images</label>
                                                <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files">
                                            </div>
                                            <input class="button button--big-bottom" type="submit" value="Upload Selected Files">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                             <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this event on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['public']) && $data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($data['public']) ? $data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="col-lg-offset-2 col-lg-10">
                            <input class="btn green" type="submit" value="Submit">
                            <a href="<?=base_url()?>cms/gallery/" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

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
</script>

<script type="text/javascript">

    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d',
        //minDate:new Date()
    });

</script>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>



<script type="text/javascript">
$(document).ready(function(){


    
});

function deleteimage(image_id)
{
var answer = confirm ("Are you sure you want to delete from this post?");
if (answer)
{
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/gallery/deleteimage');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
      }
}

    function deletefeaimage(image_id)
{ 
var answer = confirm ("Are you sure you want to delete from this post?");
window.location.reload();
if (answer)
{
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/gallery/deletefeaimage');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
      }
}
</script>

<style type="text/css">
 .gallerybg li{float:left;list-style-type: none;    width: 15%;}
 .close{position: absolute;margin-left: 10px;}
</style>

<script type="text/javascript">
    $(function() {
    $('#name').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});


$("#sortable").sortable();
</script>

<style type="text/css">#newgaltype{display: none;}</style>
<script type="text/javascript">
$("#gallery_for").on("change", function(){
    document.getElementById("galtype").style.display = "none";
    document.getElementById("newgaltype").style.display = "block";
      var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('admin/appendgaltype');?>",
                data:'institute_id='+countryID,
                success:function(html){
                    $('#single2').html(html);
                }
            }); 
        }else{
            $('#single2').html('<option value="">Select Institute First</option>');
        }
})

(function(){
    var options = {};
    $('.js-uploader__box').uploader(options);
}());
</script>


<script type="text/javascript">
    $("#formval").validate({
            rules: {
                gallery_for: {
                    required: true,
                },
                title: {
                    required: true,
                },
                date: {
                    required: true,
                },
            },
            messages: {
                gallery_for: {
                    required: 'Please select institute',
                },
                title: {
                    required: 'Please enter name',
                },
                date: {
                    required: 'Please select date',
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