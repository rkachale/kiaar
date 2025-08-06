<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['soil_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Soil test results</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Soil test results</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/soil_test_results/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
                        <div class="row margin0">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="farmer_id" class="control-label col-md-4">Farmer Name <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
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
                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label for="date" class="control-label col-md-4">Date <span class="asterisk">*</span></label>
                                     <div class="col-md-8">
                                        <input type="text" class="datetextbox wid60date form-control" id="date" name="date" value="<?php if(isset($data['date'])) { echo $data['date']; } ?>" data-error=".dateerror" required />
                                        <div class="dateerror error_msg"><?php echo form_error('date', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ph" class="control-label col-md-4">Potential of hydrogen (pH) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="ph" name="ph" value="<?php echo set_value('ph', (isset($data['ph']) ? $data['ph'] : '')); ?>" data-error=".pherror" required onkeypress="return isNumberKey(event)" >
                                        <div class="pherror error_msg"><?php echo form_error('ph', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ec" class="control-label col-md-4">Electrical conductivity (EC) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="ec" name="ec" value="<?php echo set_value('ec', (isset($data['ec']) ? $data['ec'] : '')); ?>" data-error=".ecerror" required onkeypress="return isNumberKey(event)">
                                        <div class="ecerror error_msg"><?php echo form_error('ec', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="farmer_id" class="control-label col-md-4">Organic carbon (OC) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="oc" name="oc" value="<?php echo set_value('oc', (isset($data['oc']) ? $data['oc'] : '')); ?>" data-error=".ocerror" required onkeypress="return isNumberKey(event)">
                                        <div class="ocerror error_msg"><?php echo form_error('oc', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="n" class="control-label col-md-4">Nitrogen(N) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="n" name="n" value="<?php echo set_value('n', (isset($data['n']) ? $data['n'] : '')); ?>" data-error=".nerror" required onkeypress="return isNumberKey(event)">
                                        <div class="nerror error_msg"><?php echo form_error('n', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="p" class="control-label col-md-4">Phosphorus(P) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="p" name="p" value="<?php echo set_value('p', (isset($data['p']) ? $data['p'] : '')); ?>" data-error=".perror" required onkeypress="return isNumberKey(event)">
                                        <div class="perror error_msg"><?php echo form_error('p', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="k" class="control-label col-md-4">Potassium (K) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="k" name="k" value="<?php echo set_value('k', (isset($data['k']) ? $data['k'] : '')); ?>" data-error=".kerror" required onkeypress="return isNumberKey(event)">
                                        <div class="kerror error_msg"><?php echo form_error('k', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="s" class="control-label col-md-4">Sulfur (S) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="s" name="s" value="<?php echo set_value('s', (isset($data['s']) ? $data['s'] : '')); ?>" data-error=".serror" required onkeypress="return isNumberKey(event)">
                                        <div class="serror error_msg"><?php echo form_error('s', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ca" class="control-label col-md-4">Calcium(Ca) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="ca" name="ca" value="<?php echo set_value('ca', (isset($data['ca']) ? $data['ca'] : '')); ?>" data-error=".caerror" required onkeypress="return isNumberKey(event)">
                                        <div class="caerror error_msg"><?php echo form_error('ca', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mg" class="control-label col-md-4">Magnesium (Mg) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="mg" name="mg" value="<?php echo set_value('mg', (isset($data['mg']) ? $data['mg'] : '')); ?>" data-error=".mgerror" required onkeypress="return isNumberKey(event)">
                                        <div class="mgerror error_msg"><?php echo form_error('mg', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zn" class="control-label col-md-4">Zinc (Zn) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="zn" name="zn" value="<?php echo set_value('zn', (isset($data['zn']) ? $data['zn'] : '')); ?>" data-error=".znerror" required onkeypress="return isNumberKey(event)">
                                        <div class="znerror error_msg"><?php echo form_error('zn', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fe" class="control-label col-md-4">Iron (Fe) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="fe" name="fe" value="<?php echo set_value('fe', (isset($data['fe']) ? $data['fe'] : '')); ?>" data-error=".feerror" required onkeypress="return isNumberKey(event)">
                                        <div class="feerror error_msg"><?php echo form_error('fe', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mn" class="control-label col-md-4">Manganese (Mn) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="mn" name="mn" value="<?php echo set_value('mn', (isset($data['mn']) ? $data['mn'] : '')); ?>" data-error=".mnerror" required onkeypress="return isNumberKey(event)">
                                        <div class="mnerror error_msg"><?php echo form_error('mn', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sic" class="control-label col-md-4">Soil Inorganic Carbon (SIC) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="sic" name="sic" value="<?php echo set_value('sic', (isset($data['sic']) ? $data['sic'] : '')); ?>" data-error=".sicerror" required onkeypress="return isNumberKey(event)">
                                        <div class="sicerror error_msg"><?php echo form_error('sic', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="soc" class="control-label col-md-4">Soil Organic Carbon (SOC) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="soc" name="soc" value="<?php echo set_value('soc', (isset($data['soc']) ? $data['soc'] : '')); ?>" data-error=".socerror" required onkeypress="return isNumberKey(event)">
                                        <div class="socerror error_msg"><?php echo form_error('soc', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="toc" class="control-label col-md-4">Total Carbon (TC) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="toc" name="toc" value="<?php echo set_value('toc', (isset($data['toc']) ? $data['toc'] : '')); ?>" data-error=".tocerror" required onkeypress="return isNumberKey(event)">
                                        <div class="tocerror error_msg"><?php echo form_error('toc', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cu" class="control-label col-md-4">Copper (Cu) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="cu" name="cu" value="<?php echo set_value('cu', (isset($data['cu']) ? $data['cu'] : '')); ?>" data-error=".cuerror" required onkeypress="return isNumberKey(event)">
                                        <div class="cuerror error_msg"><?php echo form_error('cu', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bulk_densilty" class="control-label col-md-4">Bulk density (BD) <span class="asterisk">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="bulk_densilty" name="bulk_densilty" value="<?php echo set_value('bulk_densilty', (isset($data['bulk_densilty']) ? $data['bulk_densilty'] : '')); ?>" data-error=".bulk_densiltyerror" required onkeypress="return isNumberKey(event)">
                                        <div class="bulk_densiltyerror error_msg"><?php echo form_error('bulk_densilty', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status" class="control-label col-md-1">Publish&nbsp;<span><a title="Click checkbox to display this on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                    <div class="col-md-offset-0 col-md-10">
                                        <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($data['status']) && $data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                        <input value="<?php echo set_value('status', (isset($data['status']) ? $data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin0">
                            <div class="col-md-offset-1 col-md-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/soil_test_results/'); ?>" class="btn btn-default" type="button">Cancel</a>
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

    $('#date').datetimepicker({
        format:'Y-m-d',
        pickTime: false
    });

    function isNumberKey(evt)
   {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
         return false;

      return true;
   }
       
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

    $("#formval").validate({
            rules: {
                farmer_id: {
                    required: true,
                },
                date: {
                    required: true,
                },
                ph: {
                    required: true,
                    // dollarsscents: true
                },
                ec: {
                    required: true,
                    // dollarsscents: true
                },
                oc: {
                    required: true,
                    // dollarsscents: true
                },
                n: {
                    required: true,
                    // dollarsscents: true
                },
                p: {
                    required: true,
                    // dollarsscents: true
                },
                k: {
                    required: true,
                    // dollarsscents: true
                },
                s: {
                    required: true,
                    // dollarsscents: true
                },
                ca: {
                    required: true,
                    // dollarsscents: true
                },
                mg: {
                    required: true,
                    // dollarsscents: true
                },
                zn: {
                    required: true,
                    // dollarsscents: true
                },
                fe: {
                    required: true,
                    // dollarsscents: true
                },
                mn: {
                    required: true,
                    // dollarsscents: true
                },
                cu: {
                    required: true,
                    // dollarsscents: true
                },
                bulk_densilty: {
                    required: true,
                    // dollarsscents: true
                },
                sic: {
                    required: true,
                    // dollarsscents: true
                },
                soc: {
                    required: true,
                    // dollarsscents: true
                },
                toc: {
                    required: true,
                    // dollarsscents: true
                },
            },
            messages: {
                farmer_id: {
                    required: 'Please select Farmer',
                },
                date: {
                    required: 'Please select Date',
                },
                ph: {
                    required: 'Please enter pH',
                },
                ec: {
                    required: 'Please select EC',
                },
                oc: {
                    required: 'Please select OC',
                },
                n: {
                    required: 'Please select N',
                },
                p: {
                    required: 'Please select P',
                },
                k: {
                    required: 'Please select K',
                },
                s: {
                    required: 'Please select S',
                },
                ca: {
                    required: 'Please select Ca',
                },
                mg: {
                    required: 'Please select Mg',
                },
                zn: {
                    required: 'Please select Zn',
                },
                fe: {
                    required: 'Please select Fe',
                },
                mn: {
                    required: 'Please select Mn',
                },
                cu: {
                    required: 'Please select Cu',
                },
                bulk_densilty: {
                    required: 'Please select Bulk densilty',
                },
                sic: {
                    required: 'Please select SIC',
                },
                soc: {
                    required: 'Please select SOC',
                },
                toc: {
                    required: 'Please select TC',
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