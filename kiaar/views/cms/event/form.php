<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($event_data['event_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Event</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Event</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/event/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
                        <?php
                        // echo "<pre>";
                        // print_r($event_data);
                        // echo "<br>------------<br>";
                        // print_r($event_type);
                        // exit(); 

                        $selected_event_type    = array();
                        $selected_audience_type = array();

                        if(!empty($event_data['event_type']))
                        {
                            $selected_event_type = explode(',' , $event_data['event_type']);
                        }
                        
                        if(!empty($event_data['audience_type']))
                        {
                            $selected_audience_type = explode(',' , $event_data['audience_type']);
                        }
                        ?>

                        <div class="row margin0">
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label for="event_name" class="control-label col-lg-2">Event Name <span class="asterisk">*</span></label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo set_value('event_name', (isset($event_data['event_name']) ? $event_data['event_name'] : '')); ?>" required data-error=".event_nameerror" maxlength="250" required>
                                        <div class="event_nameerror error_msg"><?php echo form_error('event_name', '<label class="error">', '</label>'); ?></div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="contents_id" value="<?php echo set_value('contents_id', (isset($event_data['contents_id']) ? $event_data['contents_id'] : '')); ?>" >
                        <input type="hidden" name="data_type" value="event">
                        <input type="hidden" name="language_id" value="1"> <!-- 1=english lang -->

                         <div class="row margin0">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="event_type" class="control-label col-lg-4">Event Type <span class="asterisk"></span></label>
                            <div class="col-lg-8">
                                <select id="event_type" class="form-control select2" name="event_type[]" data-placeholder="Please Select Event Type" multiple ><!-- <option value="">Select Event Type</option> -->
                                    <?php if(isset($event_type) && count($event_type)!=0){ ?>
                                    <?php foreach ($event_type as $key => $value) { ?>
                                        <option value="<?php echo $value['event_type_id']; ?>" <?php if( isset($selected_event_type) && in_array($value['event_type_id'], $selected_event_type)) echo"selected"; ?> > <?php echo $value['event_type_name']; ?></option>
                                    <?php } } ?>
                                </select>
                              <!--   <div class="event_typeerror error_msg"><?php echo form_error('event_type', '<label class="error">', '</label>'); ?></div> -->
                            </div></div>
                        </div>
                      

                        
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="audience_type" class="control-label col-lg-4">Audience Type <span class="asterisk"></span></label>
                            <div class="col-lg-8 col-sm-8">
                                <select id="audience_type" class="form-control select2" name="audience_type[]" data-placeholder="Please Select Audience Type" multiple ><option value="">Select Audience Type</option>
                                    <?php if(isset($audience_type) && count($audience_type)!=0){ ?>
                                    <?php foreach ($audience_type as $key => $value) { ?>
                                        <option value="<?php echo $value['audience_type_id']; ?>" <?php if( isset($selected_audience_type) && in_array($value['audience_type_id'], $selected_audience_type)) echo"selected"; ?> > <?php echo $value['audience_name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>


        <div class="row margin0">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="category_id" class="control-label col-lg-4">Category <span class="asterisk"></span></label>
                            <div class="col-lg-8">
                                <select id="category_id" class="form-control select2" name="category_id" data-placeholder="Please Select Category">
                                     <option value="">Select Category </option>    
                                    <?php if(isset($category) && count($category)!=0){ ?>
                                    <?php foreach ($category as $key => $value) { ?>
                                       <!--  <option value="<?php echo $value['category_id']; ?>" <?php if( isset($event_data['category_id']) ){ if($value['category_id']==$event_data['category_id'])echo"selected";} ?> > <?php echo $value['category_name']; ?></option> -->
                                             <option value="<?php echo $value['category_id']; ?>" <?php if( isset($event_data['category_id']) && $event_data['category_id'] == $value['category_id']) echo"selected"; ?> > <?php echo $value['category_name']; ?></option>
                                    <?php } } ?>
                                </select>
                                <!-- <div class="event_typeerror error_msg"><?php echo form_error('event_type', '<label class="error">', '</label>'); ?></div> -->
                            </div></div>
                        </div>
                      

                       
                    </div>


                 <!--     <div class="row margin0">
                        <div class="col-lg-6">
                             <div class="form-group">
                                <label for="location" class="control-label col-lg-4">Location <span class="asterisk">*</span></label>
                                <div class="col-lg-8">
                                    <select id="location" class="form-control select2" name="location" data-placeholder="Please Select Location"><option value="">Select Location</option>
                                        <?php if(isset($location) && count($location)!=0){ ?>
                                        <?php foreach ($location as $key => $value) { ?>
                                            <option value="<?php echo $value['location_id']; ?>" <?php if( isset($event_data['location_id']) && $event_data['location_id'] == $value['location_id']) echo"selected"; ?> > <?php echo $value['location_name']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                      
                        <?php
                        
                        $selected_department_id    = array();

                        if(!empty($event_data['department_id']))
                        {
                            $selected_department_id = explode(',' , $event_data['department_id']);
                        }
                        ?>
                      
                        <div class="col-lg-6">
                              <div class="form-group">
                                <label for="department_id" class="control-label col-lg-2">Departments <!-- <span class="asterisk">*</span> --></label>
                            <!--     <div class="col-lg-10 col-sm-10">
                                    <select id="department_id" class="form-control select2" name="department_id[]" data-placeholder="Please Select Department" multiple><option value="">Select Departments</option>
                                        <?php if(isset($departments) && count($departments)!=0){ ?>
                                        <?php foreach ($departments as $key => $value) { ?>
                                            <option value="<?php echo $value['Department_Id']; ?>" <?php if( isset($selected_department_id) && in_array($value['Department_Id'], $selected_department_id)) echo"selected"; ?> > <?php echo $value['Department_Name']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>  
                        </div>
                    </div> -->

                    <div class="row margin0">
                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label for="start_date" class="control-label col-md-4">Start Date <span class="asterisk">*</span></label>
                                     <div class="col-md-8">
                                        <input type="text" class="datetextbox wid60date form-control" id="start_date" name="start_date" value="<?php if(isset($event_data['to_date'])) { echo $event_data['to_date']; } ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label for="end_date" class="control-label col-md-4">End Date <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="datetextbox form-control" id="end_date" name="end_date" value="<?php if(isset($event_data['from_date'])) { echo $event_data['from_date']; } ?>" required />
                                </div>
                            </div>
                         </div>

                         <div class="">
                            <div class="col-lg-12">
                                <?php
                                    mk_hWYSItexteditor("description",_l('Description',$this),isset($event_data['description'])?$event_data['description']:'','');
                                    //mk_hurl_upload("image",_l('Image',$this),isset($event_data['image'])?$event_data['image']:'',"image");
                                ?>

                                <?php //exit(); ?>
                         </div>
                         </div>

                        <div class="">
                            <div class="col-md-12">
                                <?php $this->load->view('cms/event/event_image'); ?>
                            </div>
                        </div>
                        
                        <?php
                            //mk_hidden("event_id",isset($relation_id)?$relation_id:0);
                        ?>

                         <div class="row margin0" style="display: none;">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="featured_event" class="control-label col-lg-2">Featured Event&nbsp;&nbsp;<span><a title="Click checkbox to display this event on homepage" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="featured_checkbox" type="checkbox" <?php if(isset($event_data['featured_event']) && $event_data['featured_event'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('featured_event', (isset($event_data['featured_event']) ? $event_data['featured_event'] : '')); ?>" style="display: none;" id="featured_event" name="featured_event" checked="" type="text">
                                </div>
                        </div>
                    </div>
                    </div>
                        <?php /*
                        <div class="form-group ">
                            <label for="sticky_event" class="control-label col-lg-2">Sticky Event&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="sticky_event_checkbox" type="checkbox" <?php if(isset($event_data['sticky_event']) && $event_data['sticky_event'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('sticky_event', (isset($event_data['sticky_event']) ? $event_data['sticky_event'] : '')); ?>" style="display: none;" id="sticky_event" name="sticky_event" checked="" type="text">
                            </div>
                        </div> */ ?>

                      <!--   <div class="row margin0">

                        <div class="col-lg-12">
                            <div class="form-group">
                            <label for="whats_new" class="control-label col-lg-2">What's New&nbsp;<span><a title="Click checkbox to display this event on homepage What’s New section." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control whats_new" id="whats_new_checkbox" type="checkbox" <?php if(isset($event_data['whats_new']) && $event_data['whats_new'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('whats_new', (isset($event_data['whats_new']) ? $event_data['whats_new'] : '')); ?>" style="display: none;" id="whats_new" name="whats_new" checked="" type="text">
                            </div>
                            </div>
                        </div>
                    </div>

                        
                        <div class="row margin0">
                            <div class="expiry_wrap hidden col-lg-12">
                                <div class="form-group">
                                    <label for="data[whats_new_expiry_date]" class="control-label col-lg-2">What's New Expiry Date</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="whats_new_expiry_date" name="whats_new_expiry_date" value="<?php echo set_value('data[whats_new_expiry_date]', (isset($event_data['whats_new_expiry_date']) ? $event_data['whats_new_expiry_date'] : '')); ?>" />
                                    </div> 
                                </div>
                            </div>
                        </div> -->

                    <div class="">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this event on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($event_data['public']) && $event_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($event_data['public']) ? $event_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                          <div class="row margin0">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/event/'); ?>" class="btn btn-default" type="button">Cancel</a>
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

    $('#start_date').datetimepicker({
        format:'Y-m-d H:i',
        //minDate:new Date()
    });

    $('#end_date').datetimepicker({
        format:'Y-m-d H:i',
        //minDate:new Date()
    });

    $('#whats_new_expiry_date').datetimepicker({
        format:'Y-m-d H:i',
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

        /* featured */

        if ($('#featured_checkbox').is(':checked')) {
            $('#featured_event').val(1);
        }else{
            $('#featured_event').val(0);
        }

        $('#featured_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#featured_event').val(1);
            }else{
                $('#featured_event').val(0);
            }
        });

        /* sticky */

        if ($('#sticky_event_checkbox').is(':checked')) {
            $('#sticky_event').val(1);
        }else{
            $('#sticky_event').val(0);
        }

        $('#sticky_event_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#sticky_event').val(1);
            }else{
                $('#sticky_event').val(0);
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

        /* Sportsdisplay */

        /*if ($('#sportsdisplay_checkbox').is(':checked')) {
            $('#sportsdisplay').val(1);
        }else{
            $('#sportsdisplay').val(0);
        }

        $('#sportsdisplay_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#sportsdisplay').val(1);
            }else{
                $('#sportsdisplay').val(0);
            }
        });*/
            
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
            event_name: {
                required: true,
            },
            location: {
                required: true,
            },
            start_date: {
                required: true,
            },
            end_date: {
                required: true,
            },
        },
        messages: {
            event_name: {
                required: 'Please Enter Event Name',
            },
            location: {
                required: 'Please Select Location',
            },
            start_date: {
                required: 'Please Select Start Date',
            },
            end_date: {
                required: 'Please Select End Date',
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