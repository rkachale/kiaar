<!-- BEGIN LIST CONTENT -->
<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Videos</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange"> <a class="sizebtn btn sbold orange" href="<?php echo base_url(); ?>cms/video/edit/">Add New</a></span>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>
                    </div>
                    
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>    
                                <th>Video Title</th>
                                <th>Video</th>
                                <th>Spotlight</th>
                                <th>Featured</th>
                                <th>Publish</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody class="list-unstyled" id="page_list">
                            <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX" id="<?=$data['video_id']?>">
                                    <td><?=$data["video_text"]?></td>
                                    <?php 
                                        $videoURL=$data['video_url'];
                                        $explodeurl=explode("/", $videoURL);
                                        $stringValue=substr($explodeurl[3], strpos($explodeurl[3], "=") + 1);
                                        $youtubeURL="https://www.youtube.com/embed/$stringValue";
                                    ?> 
                                    <td>
                                        <iframe width="360" height="250" src="<?php echo $youtubeURL; ?>">
                                        </iframe>
                                    </td>
                                    
                                    <td class="chwidth center"><i class="fa <?=$data["spotlight_video"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td class="chwidth center"><i class="fa <?=$data["featured_video"]==1?"fa-check":"fa-minus-circle"?>"></i></td>          
                                    <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td class="actbtn">
                                        <a href="<?php echo base_url('cms/video/edit/'.$data["video_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/video/delete/'.$data["video_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
