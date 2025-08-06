<div class="form-group ">
    <label for="status" class="control-label col-lg-2">Recommendation Report</label>
    <div class="col-lg-10 col-sm-10">
        <div class="boxform">
            <table style="width: 100%;">
                <tbody id="page_list">
            <?php if(isset($links) && count($links)!=0){ ?>
                <input type="hidden" name="links_array_check" value="2">
                <?php
                    $in = 0;
                    foreach ($links as $key5 => $data5) { 
                ?>
                        <tr class="group_wrap all-scroll" data-id="<?php echo $data5['id'] ?>">
                            <td class="link_name">
                                <div class="p10">
                                    <input type="text" id="linkname<?php echo $key5; ?>" name="link_name[]" value="<?php if(isset($data5['link_name'])) { echo $data5['link_name']; } ?>" Placeholder="File Name" required>
                                </div>
                            </td>
                            <td class="link_url">
                                <div class="p10">
                                    <input type="url" id="linkurl<?php echo $key5; ?>" name="link_url[]" value="<?php if(isset($data5['link_url'])) { echo $data5['link_url']; } ?>" Placeholder="File S3 URL" required>
                                </div>
                            </td>
                            <td class="add_remove_td">
                                <div class="p10">
                                    <?php if($key5 == 0){ ?>
                                        <!-- <a class="add" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a> -->
                                    <?php }else{ ?>
                                        <a class="removeMore" data-id="<?php echo $data5['id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </div>
                            </td>
                            <input type='hidden' name='id2[]' value='<?php echo $data5['id'] ?>' />
                        </tr>
                        <?php if($key5 == 0){ ?> 
                            <div style="padding-bottom:20px;">
                                <a style="font-weight: bold;border: 1px solid #337ab7;padding: 5px 10px;" class="add btn btn-secondary" href="javascript:void(0);">ADD MULTIPLE LINKS</a>
                                &nbsp; &nbsp; &nbsp; 
                                <span><a title="You can change the sequence by using drag and drop" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
                            </div>
                        <?php } ?>
                <?php $in++;}} else { ?>
                    <input type="hidden" name="links_array_check" value="1">
                    <tr class="group_wrap">
                        <td class="link_name">
                            <div class="p10">
                                <input type="text" id="linkname0" name="link_name[]" Placeholder="File Name" required>
                            </div>
                        </td>
                        <td class="link_url">
                            <div class="p10">
                                <input type="url" id="linkurl0" name="link_url[]" Placeholder="File S3 URL" required>
                            </div>
                        </td>
                    </tr>
                    <div style="padding-bottom:20px;">
                        <a style="font-weight: bold;border: 1px solid #337ab7;padding: 5px 10px;" class="add btn btn-secondary" href="javascript:void(0);">ADD MULTIPLE LINKS</a>
                        &nbsp; &nbsp; &nbsp; 
                        <span><a title="You can change the sequence by using drag and drop" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
                    </div>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.fa-info-circle{font-size: 18px;}
tr.group_wrap
{
    position:relative;
    float:left;
    margin-bottom:12px; 
    width:100%;
    padding: 10px; 
    border: 1px dotted #ccc;
}
td.link_url, td.link_name 
{
    width: 48%;
    float: left;
}
td.add_remove_td
{
    width: 4%;
}
input[type=text] 
{
    padding: 12px;
    margin: 3px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 90%;
}
input[type=url] 
{
    padding: 12px;
    margin: 3px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 90%;
}
.all-scroll {cursor: all-scroll;}
</style>

<script type="text/javascript">
    // i=$('.group_wrap').length;
i=1;
$(document).on('click', 'a.add', function (e) {
    e.preventDefault();
    $(".group_wrap:last").after('<tr class="group_wrap"><td class="link_name"><div class="p10"><input type="text" id="linkname'+i+'" name="link_name[]" Placeholder="File Name" required></div></td><td class="link_url"><div class="p10"><input type="url" id="linkurl'+i+'" name="link_url[]" Placeholder="File S3 URL" required></div></td><td class="add_remove_td"><div class="p10"><a class="removeMore'+i+'" data-id=""><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMore"+i).click(function(){
        var pid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/soil_master/delete_links');?>",
                data: "pid="+pid,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+pid).remove(".imagelocation"+pid);
                  };
                }
            });
        }
        $(this).parent().parent().parent().fadeOut("slow", function() {
            // $(this).parent().parent().parent().remove();
            $(this).remove();
        });
    });
    i++;
});

$(".removeMore").click(function(){
    var pid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('cms/soil_master/delete_links');?>",
            data: "pid="+pid,
            success: function (response) {
              if (response == 1) {
                $(".imagelocation"+pid).remove(".imagelocation"+pid);
              };
            }
        });
    }
    $(this).parent().parent().parent().fadeOut("slow", function() {
        // $(this).parent().parent().parent().remove();
        $(this).remove();
    });
});
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $( "#page_list" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var programme_id_array = new Array();
                $('#page_list tr').each(function(){
                    programme_id_array.push($(this).attr("data-id"));
                });
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('cms/soil_master/save_links_order');?>",
                    data: {programme_id_array:programme_id_array},
                    success:function(data)
                    {
                        alert(data);
                    }
                });
            }
        });
    });
</script>