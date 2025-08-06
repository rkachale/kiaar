<!-- BEGIN LIST CONTENT -->
<?php $institute = $_SESSION['sess_institute_id'] ?>
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase">Funders</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row"><?php error_reporting(0); ?>
                                <div class="col-lg-12">
                                    <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/projects/index/'.$institute); ?>">Back </a> </span>
                                    <?php if(count($data_list) > 0){ 

 foreach($data_list as $data1){
    $id=$data1['project_id'];}
                                ?>
                                        <span class="custorange pull-right"><a href="<?php echo base_url('cms/projects/export_funders/'.$id); ?>" class="btn sbold orange">Export</a></span>
                                    <?php } ?>
                                </div>                                                         
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_id">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($data_list) > 0){
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <td><?=$data["name"]?></td>
                                                <td><?=$data["amount"]?></td>
                                                <!-- <td>
                                                    <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('public_lectures/delete'.$page.'/'.$lecture_id.'/'.$data["interest_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                </td> -->
                                            </tr>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                ?>
                                        <tr class="gradeX">
                                            <td class="text-center" colspan="4">No Funders Found</td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_id').DataTable({
                "order": []
            });
        });
    </script>