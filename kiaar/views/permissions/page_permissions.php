 <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Page Permissions</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                         <span class="custorange"> <a href="<?php echo base_url(); ?>permissions/edit_page_permissions"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New
                                        </button></a></span>
                                     <span class="custpurple">&nbsp;&nbsp;<button class="sizebtn btn brown" onclick="history.go(-1);">Back </button> </span>
                                </div>                                                         
                            </div>
                        </div>

                        <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Group</th>
                                    <th>Institute</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(!empty($data_list))
                                    {
                                        foreach($data_list as $value){
                                ?>
                                            <tr class="gradeX">
                                                <td><?php echo $value['group_name']; ?></td>
                                                <td><?php echo $value['institute_name']; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>permissions/edit_page_permissions/<?=$value["pr_id"]?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                                    <a href="<?php echo base_url(); ?>permissions/delete_page_permissions/<?=$value["pr_id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                ?>
                                        <tr class="gradeX">
                                            <td colspan="3" class="text-center">No Page Permissions Found.</td>
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
function doconfirm()
{
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
}
</script>

<script type="text/javascript">
        $(document).ready(function() {
            $('#sample_1').DataTable( {
                "order": [[ 1, "desc" ]],
                "iDisplayLength": 25
            } );
        } );

        window.alert = function() {};
    </script>