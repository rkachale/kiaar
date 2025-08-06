<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Farmers</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Farmers</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/farmers/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="<?php echo base_url('cms/farmers/add_farmer_api'); ?>" enctype="multipart/form-data">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="farmer_id" class="control-label col-lg-4">Farmers ID <span class="asterisk">*</span></label>
                            <div class="col-lg-8 col-sm-8">
                                <input type="text" class="form-control" id="farmer_id" name="farmer_id" data-error=".farmer_iderror" required>
                                <div class="farmer_iderror error_msg"><?php echo form_error('farmer_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                            </div>
                        </div>

                        <div class="row margin0">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/farmers/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>

<script>
$("#formval").validate({
            rules: {
                farmer_id: {
                    required: true,
                },
            },
            messages: {
                farmer_id: {
                    required: 'Please enter Farmer ID',
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