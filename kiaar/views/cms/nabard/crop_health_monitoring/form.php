<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">
<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['crop_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Crop health monitoring</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Crop health monitoring</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/crop_health_monitoring/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
                        <div class="row margin0">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="farmer_id" class="control-label col-lg-4">Farmer Name <span class="asterisk">*</span></label>
                                    <div class="col-lg-8 col-sm-8">
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
                        </div>
                        <div class="row margin0">
                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label for="year_month" class="control-label col-md-4">Year and Month <span class="asterisk">*</span></label>
                                     <div class="col-md-8">
                                        <input type="text" class="datetextbox wid60date form-control" id="year_month" name="year_month" value="<?php if(isset($data['year_month'])) { echo $data['year_month']; } ?>" data-error=".year_montherror" required />
                                        <div class="year_montherror error_msg"><?php echo form_error('year_month', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if(isset($gallery_data_image) && is_array($data) && count($data)): $i=1; ?>
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Crop Health Map</label>
                                        <div class="col-lg-10 col-sm-10">
                                            <?php 
                                                foreach ($gallery_data_image as $key => $data1) { 
                                            ?>
                                                <ul class="imagelocation<?php echo $data1['id'] ?> gallerybg" id="sortable">
                                                  <li>
                                                    <img src="<?php echo base_url(); ?>upload_file/crop_health_upload/<?php echo $data1['FARMER_ID']."_".$data1['year_month']; ?>/<?php echo $data1['image']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                    <span class="close" style="cursor:pointer;" onclick="javascript:deleteimage(<?php echo $data1['id'] ?>)">X</span>
                                                    <input class="form-control" type="hidden" name="existing_image_id[]" value="<?php echo $data1['id'] ?>">
                                                    <input class="form-control" type="text" name="existing_image_name[]" value="<?php echo $data1['name']; ?>">
                                                    <input class="form-control" type="text" name="existing_image_description[]" value="<?php echo $data1['description']; ?>">
                                                  </li>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Crop Health Map</label>
                                    <div class="col-lg-10 col-sm-10">
                                        <div class="uploader__box js-uploader__box l-center-box">
                                            <div class="uploader__contents">
                                                <label class="button button--secondary" for="fileinput">Crop Health Map</label>
                                                <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files" required>
                                            </div>
                                            <input class="button button--big-bottom" type="submit" value="Upload Selected Files">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
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
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/crop_health_monitoring/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>

<style type="text/css">
.gallerybg li {
    position: relative;
    float: left;
    list-style-type: none;
}

ul#sortable {
    float: left;
}
#sortable .close {
    display: inline-block;
    margin-top: 0;
    margin-right: -1px;
    width: 104px;
    height: 9px;
    background-repeat: no-repeat!important;
    text-indent: -10000px;
    outline: 0;
    /*background-image: url(../img/remove-icon-small.png)!important;*/
    opacity: 9!important;
    /* right: 10px; */
    /* background-position: -21px 0; */
    position: relative;
    right: 4px;
    top: -6px;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">
    $('#year_month').datepicker({
       minViewMode: 1,
       format: 'yyyy-mm'
    });

    (function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());
</script>

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
    });

    function deleteimage(image_id)
    {
        var answer = confirm ("Are you sure you want to delete image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/crop_health_monitoring/deleteimage');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
        }
    }

    $("#manage_form").validate({
        rules: {
            farmer_id: {
                required: true,
            },
            year_month: {
                required: true,
            },
        },
        messages: {
            farmer_id: {
                required: 'Please select Farmer',
            },
            year_month: {
                required: 'Please select Month and Year',
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
                <?php if(isset($data['crop_id']) && !empty($data['crop_id'])) { ?>
                    var id                       = '<?php echo $data[crop_id]; ?>';
                <?php } else { ?>
                    var id                       = '';
                <?php } ?>
                var farmer_id                    = $('#farmer_id').val();
                var year_month                   = $('#year_month').val();
                var check_result                 = true;
                $('.farmer_iderror').html('');

                function check_graph(id,farmer_id,year_month) {
                    var check_mmg_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"cms/crop_health_monitoring/ajax_check",
                        async: false,
                        data: { id : id, farmer_id : farmer_id, year_month : year_month},
                        success: function(response){
                            if(response == '')
                            {
                                check_mmg_result = false;
                            }
                        }
                    });
                    return check_mmg_result;
                }

                check_result = check_graph(id,farmer_id,year_month);
                if(check_result == false)
                {   
                    $('.farmer_iderror').html('Farmer data for this Year and Month is already exist.');
                    return false;
                }
                else
                {   
                    form.submit();
                }
            }
    });

</script>