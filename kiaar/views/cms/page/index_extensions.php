<!-- BEGIN LIST CONTENT -->
<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase"> <?=$title?></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange">
                                    <a href="<?php echo base_url('cms/page_extensions/edit/'.$relation_id); ?>">
                                        <button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New</button>
                                    </a>
                                </span>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('cms/page/page'); ?>">Back</a> </span>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($data_list) && count($data_list)!=0){ ?>
                        <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="table_id">
                            <thead>
                                <tr>
                                    <th>Language</th>
                                    <th>Content Name</th>
                                    <th>Updated Date</th>
                                    <th>Publish</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX">
                                    <td><?=$data["language_name"]?></td>
                                    <td><?=$data["name"]?></td>
                                    <td><?=$data["updated_date"]?></td>
                                    <td><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td>
                                        <a href="<?php echo base_url('cms/page_extensions/edit/'.$relation_id.'/'.$data["extension_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>

                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdeletecontent('<?php echo base_url('cms/page_extensions/delete/'.$data["relation_id"].'/'.$data["extension_id"].'/'.$data["language_id"]); ?>', '<?php echo $data["language_id"]; ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
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
                    text: 'You can not delete default page content'
                });
            }
        }
</script>