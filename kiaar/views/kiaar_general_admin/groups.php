    <!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Groups</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange"> <a href="<?=$base_url?>edit<?=$page?>"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New<!-- <i class="fa fa-plus"></i> -->
                                        </button></a></span>
                                  
                                     <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                                </div>                                                         
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>                                                               
                                    <!-- <th>#</th> -->
                                    <th> Groups </th>
                                    <th> Action </th>                                           
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; foreach($data_list as $data){ $i++; ?>
                                <tr class="gradeX">
                                    <!-- <td><?php echo $i; ?>.</td> -->
                                    <td>
                                       
                                        <?=$data["group_name"]?> 
                                    </td>
                                    <td>
                                        <a href="<?=$base_url?>edit<?=$page?>/<?=$data["group_id"]?>" class="btn yellow-crusta" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="icon-note"></i>Edit Group</a>
                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('admin/deletegroups/'.$data["group_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LIST CONTENT -->

        <script type="text/javascript">
        $(document).ready(function() {
            $('#sample_1').DataTable( {
                "order": [[ 2, "desc" ]],
                "iDisplayLength": 25
            } );
        } );

        window.alert = function() {};
    </script>
 