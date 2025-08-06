<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase">Projects</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange">
                                        <a href="<?php echo base_url('cms/projects/manageproject'); ?>">
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
                                    <th>Research Project Title</th>
                                   <!--  <th>Contact no</th> -->
                                    <th>Featured Project</th>
                                    <th>Publish</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($data_list) > 0){
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <td><?=$data["name"]?></td>
                                               <!--  <td><?=$data["contact_no"]?></td> -->

                                                <td class="chwidth center"><i class="fa <?=$data["featured_project"]==1?"fa-check":"fa-minus-circle"?>"></i></td>

                                                <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                                <!-- <td>
                                                    <div class="wd100 text-center">
                                                        <a href="<?php echo base_url('projects/project_content/'.$data["project_id"]); ?>" class="btn btn_bg_orange" title="<?=_l('Content Edit',$this)?>"><i title="<?=_l('Content Edit',$this)?>" class="icon-note"></i></a>

                                                        <a href="<?php echo base_url('projects/manageproject/'.$data["project_id"]); ?>" class="btn btn_bg_custblue" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>

                                                        <a href="<?php echo base_url('projects/funder/'.$data["project_id"]); ?>" class="btn btn_bg_purple_seance" title="<?=_l('Donated People',$this)?>"><i title="<?=_l('Donated People',$this)?>" class="fa fa-thumbs-up"></i></a>

                                                        <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('projects/deleteproject/'.$data["project_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td> -->

                                                <td>
                                                    <a href="<?php echo base_url('cms/projects/manageproject/'.$data["project_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit English Content',$this)?>"><i title="<?=_l('Edit English Content',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                                    <a href="<?php echo base_url('cms/projects/project_content/'.$data["project_id"]); ?>" class="btn orange" title="<?=_l('Edit Other language Contents',$this)?>"><i title="<?=_l('Edit Other language Contents',$this)?>" class="fa fa-edit"></i></a>
                                                    
                                                    <a href="<?php echo base_url('cms/projects/funder/'.$data["project_id"]); ?>" class="btn custred" title="<?=_l('Donated People',$this)?>"><i title="<?=_l('Donated People',$this)?>" class="fa fa-thumbs-up"></i></a>
                                                    
                                                    <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/projects/deleteproject/'.$data["project_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                </td>
                                                
                                            </tr>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                ?>
                                        <tr class="gradeX">
                                            <td class="text-center" colspan="4">No Project Available</td>
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