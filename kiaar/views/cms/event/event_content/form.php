
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($contents_id) && !empty($contents_id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Event Content</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add New Event Content</span>
                    <?php } ?>
                </div>      
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/event_content/contents/'.$event_id); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php 
                        // echo "<pre>";
                        // print_r($event_content_data);
                        // echo "<br>---------------<br>";
                        // echo "<pre>";
                        // print_r($languages);
                        // exit();
                        // echo "contents_id : ".$contents_id;exit();
                        ?>
                        <input type="hidden" id="contents_id" name="contents_id" value="<?php if(isset($contents_id) && !empty($contents_id)) { echo $contents_id; } ?>">
                        <input type="hidden" name="data_type" value="event">                                
                        <div class="form-group">
                            <label for="language_id" class="control-label col-lg-2">Language <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="language_id" class="form-control" name="language_id" required data-error=".language_iderror" onchange="check_content_by_lang()">
                                    <option value="">-- Select Language --</option>
                                    <?php foreach ($languages as $key => $value) { ?>
                                    <option value="<?php echo $value['language_id']; ?>" <?php if(isset($event_content_data['language_id']) && $event_content_data['language_id'] == $value['language_id']){ echo 'selected="selected"'; } ?>><?php echo $value['language_name']; ?></option>
                                        <?php } ?>
                                </select>
                                <div class="language_iderror error_msg"><?php echo form_error('language_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Event Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($event_content_data['name']) ? $event_content_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <?php
                            mk_hWYSItexteditor("description",_l('Description',$this),isset($event_content_data['description'])?$event_content_data['description']:'','');

                            mk_hidden("relation_id",isset($event_id)?$event_id:0);
                        ?>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($event_content_data['public']) && $event_content_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($event_content_data['public']) ? $event_content_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/event_content/contents/'.$event_id) ?>" class="btn btn-default" type="button">Cancel</a>
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
	function check_content_by_lang()
	{
		var language_id = $("#language_id").val();
		var event_id  	= $("#relation_id").val();
		var contents_id = $("#contents_id").val();

		//console.log("event_id : "+event_id);
		//var check_language_result   = '';

		$.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'cms/event_content/check_content_by_lang'; ?>",
	        //async: false,
	        data: {event_id : event_id, event_content_id : contents_id, language_id : language_id},
	        success: function(response){
	        	console.log("response : "+response);

	            if(response == "false")
	            {
	                $('.language_iderror').html('Event content for this language is already exist.');
	                $('.language_iderror').addClass("error");
	                $('.language_iderror').css("display", "block");
	                var check_language_result = "false";
	                //return false;
	            }
	            else
	            {
	            	$('.language_iderror').html('');
	                $('.language_iderror').removeClass("error");
	                $('.language_iderror').css("display", "none");
	                var check_language_result = "true";
	                // $("#submitId").html("Please Wait...");
	                // $("#submitId").attr('disabled', 'disabled');
	                // showLoader();
	                // form.submit();
	            }
	            return check_language_result;
	        }
	    });

	    

	}

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
            var language_id = $("#language_id").val();
			var event_id  	= $("#relation_id").val();
			var contents_id = $("#contents_id").val();
			$.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'cms/event_content/check_content_by_lang'; ?>",
		        //async: false,
		        data: {event_id : event_id, event_content_id : contents_id, language_id : language_id},
		        success: function(response){
		        	console.log("response : "+response);

		            if(response == "false")
		            {
		                $('.language_iderror').html('Event content for this language is already exist.');
		                $('.language_iderror').addClass("error");
		                $('.language_iderror').css("display", "block");
		                
		            }
		            else
		            {
		            	// $('.language_iderror').html('');
		             //    $('.language_iderror').removeClass("error");
		             //    $('.language_iderror').css("display", "none");
		                
		                form.submit();
		            }
		        }
		    });
        }
    });


</script>