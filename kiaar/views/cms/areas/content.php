<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase">Area Content</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange">
                                        <a href="<?php echo base_url('areas/manage'.$page.'/'.$relation_id); ?>">
                                            <button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New</button>
                                        </a>
                                    </span>
                                    <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('areas/area'); ?>">Back</a> </span>
                                </div>                                                         
                            </div>
                        </div> 

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_id">
                            <thead>
                                <tr>
                                    <th>Language</th>
                                    <th>Title</th>
                                    <th>Public</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($data_list) > 0){
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <td><?=$data["language_name"]?></td>
                                                <td><?=$data["title"]?></td>
                                                <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                                <td>
                                                    <?php
                                                        if(isset($data['created_on']) && !empty($data['created_on']) && $data['created_on'] !== '0000-00-00 00:00:00')
                                                        {
                                                          echo date('d F, Y H:i:s', strtotime($data['created_on']));
                                                        }
                                                        else
                                                        {
                                                          echo 'NA';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="wd100 text-center">
                                                        <a href="<?php echo base_url('areas/manage'.$page.'/'.$relation_id.'/'.$data["contents_id"]); ?>" class="btn btn_bg_custblue" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>

                                                        <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdeletecontent('<?php echo base_url('areas/delete'.$page.'/'.$relation_id.'/'.$data["contents_id"].'/'.$data["language_id"]); ?>', '<?php echo $data["language_id"]; ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                ?>
                                        <tr class="gradeX">
                                            <td class="text-center" colspan="6">No Area Content Available</td>
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

        function confirmdeletecontent(url, language_id)
        {
            if(language_id != 1)
            {
                swal({
                    title: "Are you sure?",
                    text: 'Do you really want to delete this permanently?',
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonClass: "btn btn-success mr10",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false,
                    confirmButtonText: "Yes, Delete!"
                }).then(function () {
                    window.location.href = url;
                }, function(dismiss) {});
            }
            else
            {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You can not delete default area content'
                });
            }
        }
    </script>