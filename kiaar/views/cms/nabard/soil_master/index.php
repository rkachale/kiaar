<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase">Soil Master</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange">
                                        <a href="<?php echo base_url('cms/soil_master/edit'); ?>">
                                            <button id="sample_editable_1_new" class="sizebtn btn sbold orange"> Add New</button>
                                        </a>
                                    </span>
                                    <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a> </span>
                                </div>                                                         
                            </div>
                        </div> 

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_id">
                            <thead>
                                <tr>
                                    <th>Farmer Name</th>
                                    <!-- <th>Plot No</th> -->
                                    <!-- <th>Send SMS</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <td><?php echo ucwords(strtolower($data['FIRST_NAME'])); ?> <?php echo ucwords(strtolower($data['MIDDLE_NAME'])); ?> <?php echo ucwords(strtolower($data['LAST_NAME'])); ?></td>
                                                <!-- <td><?php //echo $data["plot_no"]; ?></td> -->
                                                <?php if($data['MOBILE_NO'] !='') { ?>
                                                    <td><a class="text-black" href="javascript:void(0);" onclick="send_credential_to_user(<?php echo $data['id']; ?>);"><div class="label label-default label-form wd-100-px background-red">Send Credential</div></a></td>
                                                <?php } else { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <td>
                                                    <a href="<?php echo base_url('cms/soil_master/edit/'.$data["id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                                    
                                                    <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/soil_master/delete/'.$data["id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                </td>
                                                
                                            </tr>
                                <?php
                                        }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#table_id').DataTable( {
            "order": [[ 1, "desc" ]],
            "iDisplayLength": 25
        } );
    } );
</script>

    <script type="text/javascript">
        function send_credential_to_user(user_id) 
        {
            if(user_id != '')
            {
                swal({
                    title: "Are you sure?",
                    text: "Do you really want to send credential to this user?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Send it!",
                }).then(function (result) {
                    //if(result.value)
                    if(result)
                    {
                        window.location.href = base_url+'cms/soil_master/send_credential_to_user/'+user_id;
                    }
                }, function(dismiss) {});
            }
        }
    </script>