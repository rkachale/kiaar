<!-- BEGIN LIST CONTENT -->
<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Post contents </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange"> <a class="sizebtn btn sbold orange" href="<?php echo base_url(); ?>cms/posts_content/edit/<?php echo $post_id; ?>">Add New</a></span>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('cms/post/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>    
                                <th>Post Name</th>
                                <th>Language Code</th>
                                <th>Publish</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody class="list-unstyled" id="page_list">
                            <?php foreach($content_list as $data){ ?>
                                <tr class="gradeX" id="<?=$data['contents_id']?>">
                                    <td><?=$data["name"]?></td>
                                    <td><?=$data["language_code"]?></td>
                                    <td class="chwidth"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td class="actbtn">
                                        
                                        <a href="<?php echo base_url('cms/posts_content/edit/'.$post_id.'/'.$data["contents_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/posts_content/delete/'.$post_id.'/'.$data["contents_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
            "order": [[ 3, "desc" ]],
            "iDisplayLength": 25
        } );
    } );
    window.alert = function() {};
</script>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
    /*$(document).ready(function()
    {
        $( "#page_list" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var post_id_array = new Array();
                $('#page_list tr').each(function(){
                    post_id_array.push($(this).attr("id"));
                });
                $.ajax({
                    type: "POST",
                    url: "<?php //echo site_url('admin/save_post_order');?>",
                    data: {post_id_array:post_id_array},
                    success:function(data)
                    {
                        alert(data);
                    }
                });
            }
        });
    });*/
</script>