<div class="form-group ">
    <label for="status" class="control-label col-lg-2">Area Counsultancy</label>
    <div class="col-lg-10 col-sm-10">
        <div class="boxform">
            <table style="width: 100%;">
                <tbody id="">
            <?php if(isset($consultancy_offered) && count($consultancy_offered)!=0){ ?>
                <input type="hidden" name="consultancy_offered_array_check" value="2">
                <?php
                    $in = 0;
                    foreach ($consultancy_offered as $key5 => $data5) { 
                ?>
                        <tr class="group_wrap " data-id="<?php echo $data5['id'] ?>">
                            <td class="consultancy_offered">
                                <div class="p10">
                                    <input type="text" id="linkname<?php echo $key5; ?>" name="consultancy_offered[]" value="<?php if(isset($data5['consultancy_offered'])) { echo $data5['consultancy_offered']; } ?>" Placeholder="Consultancy">
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
                                <a style="font-weight: bold;border: 1px solid #337ab7;padding: 5px 10px;" class="add btn btn-secondary" href="javascript:void(0);">ADD MULTIPLE CONSULTANCY</a>
                                <!-- &nbsp; &nbsp; &nbsp; 
                                <span><a title="You can change the sequence by using drag and drop" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span> -->
                            </div>
                        <?php } ?>
                <?php $in++;}} else { ?>
                    <input type="hidden" name="consultancy_offered_array_check" value="1">
                    <tr class="group_wrap">
                        <td class="consultancy_offered">
                            <div class="p10">
                                <input type="text" id="linkname0" name="consultancy_offered[]" Placeholder="Consultancy">
                            </div>
                        </td>
                        <!-- <td class="add_remove_td">
                            <div class="p10">
                                <a class="add" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </td> -->
                    </tr>
                    <div style="padding-bottom:20px;">
                        <a style="font-weight: bold;border: 1px solid #337ab7;padding: 5px 10px;" class="add btn btn-secondary" href="javascript:void(0);">ADD MULTIPLE CONSULTANCY</a>
                        <!-- &nbsp; &nbsp; &nbsp; 
                        <span><a title="You can change the sequence by using drag and drop" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span> -->
                    </div>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/*.all-scroll {cursor: all-scroll;}
table {
    border-collapse: collapse;
}

td {
    padding-top: .5em;
    padding-bottom: .5em;
}
input[type=text] {
    padding: 12px;
    margin: 3px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 90%;
}
div.boxform{
    border: 1px solid lightgrey;
    padding: 25px;
}*/
span.select2.select2-container.select2-container--bootstrap.select2-container--focus {
    width: auto!important;
    margin-right: 20px;
}
span.select2.select2-container.select2-container--bootstrap{  width: auto!important;
    margin-right: 20px;}
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
td.link_url, td.consultancy_offered 
{
    width: 90%;
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
.all-scroll {cursor: all-scroll;}
</style>


<script type="text/javascript">
function select_institute(id) {
    $.ajax({
      url: '<?php echo site_url("cms/mmg/appendmmg");?>',
      success: function(data) {
        $('#singleinst'+id).html(data);
        $('#singleinst'+id).select2();
      }
    });
}
</script>


<script type="text/javascript">
    // i=$('.group_wrap').length;
i=1;
$(document).on('click', 'a.add', function (e) {
    e.preventDefault();
    $(".group_wrap:last").after('<tr class="group_wrap"><td class="consultancy_offered"><div class="p10"><input type="text" id="linkname'+i+'" name="consultancy_offered[]" Placeholder="Consultancy"></div></td><td class="add_remove_td"><div class="p10"><a class="removeMore'+i+'" data-id=""><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMore"+i).click(function(){
        var pid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/areas/delete_consultancy_offered');?>",
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
    select_institute(i);
    i++;
});

$(".removeMore").click(function(){
    var pid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('cms/areas/delete_consultancy_offered');?>",
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
                    url: "<?php echo site_url('cms/mmg/save_mmglinks_order');?>",
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