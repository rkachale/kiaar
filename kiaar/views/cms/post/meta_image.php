<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 

$meta_image_url         = $meta_default_image_url = base_url()."upload_file/post_upload/default.png";
$delete_meta_image                = false;
    if(isset($post_data['meta_image']) && !empty($post_data['meta_image']))
    {
        $delete_meta_image        = true;
        $meta_image_url = base_url()."upload_file/post_upload/".$post_data['meta_image'];
    }

    $post_id            = isset($post_data['post_id']) ? $post_data['post_id'] : '';
    $meta_contents_id   = isset($post_data['contents_id']) ? $post_data['contents_id'] : '';

    //echo "meta content id : ".$meta_contents_id;
?>

<div class="form-group">
    <label class="control-label col-lg-2">Meta Image&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Upload image dimensions are 621 pixels (width) x 352 pixels (height). And size of file should be less than 2mb."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
    <div class="col-lg-10 col-sm-10">
        <div class="row"> 
            <div class="col-md-12">
                <input type="text" id="croppie-meta-profile" class="croppie-input" name="meta_profile_pic" accept=".png,.jpg,.jpeg,.gif" style="display: none;">
                <?php if(isset($post_data['meta_image']) && !empty($post_data['meta_image'])){ ?>
                    <img id="croppie-meta-image" class="croppie-meta-img" src="<?php echo $meta_image_url; ?>" height="170px" width="170px" />
                    <input id="croppie_upload_meta_image" type="file" class="croppie-input" placeholder="Photo" capture style="display: none;">
                <?php } else { ?>
                    <input id="croppie_upload_meta_image" type="file" class="croppie-input cc" placeholder="Photo" capture>
                <?php } ?>
                <input type="hidden" id="croppie-meta-thumbnail" name="meta_image" class="croppie-input">
            </div>
        </div>
        
        <div class="col-md-1">
            <?php if($delete_meta_image){ ?>
                <a class="btn btn-sm btn-danger" id="delete_meta_image" href="javascript:void(0);" title="Delete" onclick="delete_meta_image('<?php echo $post_id; ?>');"><i class="icon-trash"></i></a>
            <?php } ?>
        </div>

        <div id="upload_metaimage_Modal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Crop Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="meta_image_demo"  style=""></div>
                            </div>
                            <div class="col-md-4" style="padding-top:0px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="skip" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn green crop_meta_image">Crop</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

	function delete_meta_image(post_id) {
        console.log("delete meta image called : " +post_id);
		var meta_default_image_url = '<?php echo $meta_default_image_url; ?>';
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/post/deletemetaimage');?>",
                data: "post_id="+post_id,
                success: function (response) {
                    if(response == 1)
                    {
                    	$('#delete_meta_image').addClass('hidden');
                        $('#croppie-meta-image').addClass('hidden');
                        $('#croppie_upload_meta_image').css('display','block');
                    	$('#meta_image_src').attr('src', meta_default_image_url);
                        //$(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                    }
                }
            });
        }
    }


(function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });
</script>


<!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>assets/global/plugins/croppie/croppie.css" />
<link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>assets/global/plugins/croppie/custom_croppie.css" />
<script type="text/javascript" src="<?php //echo base_url(); ?>assets/global/plugins/croppie/croppie.js"></script>  -->

<script type="text/javascript">
    $(document).ready(function() {
        $meta_image_crop = $('#meta_image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 621,
                height: 352,
                // type: 'circle',
            },
            boundary: {
                width: 621,
                height: 352
            }
        });

        $('#croppie_upload_meta_image').on('change', function() {
            var reader = new FileReader();
            var nam;
            if (event.target.value.length > 0) {
                nam = event.target.files[0].name;
                document.getElementById("croppie-meta-profile").value = nam;
                // console.log(nam);

                reader.onload = function(event) {
                    $meta_image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function() {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                console.log(this.files);
                $('#upload_metaimage_Modal').appendTo("body").modal('show');
            }
        });

        $('.crop_meta_image').click(function(event) {
            $meta_image_crop.croppie('result', {
                circle: false,
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                $('#upload_metaimage_Modal').modal('hide');
                $('#croppie-meta-image').attr('src', response);
                $('#croppie_upload_meta_image').attr('value', response);
                $('#croppie-meta-thumbnail').attr('value', response);
            })
        });
    });

    $("#croppie-meta-image").click(function(e) {
        $("#croppie_upload_meta_image").click();
    });
</script>

<style type="text/css">.cc{display: block!important;}</style>