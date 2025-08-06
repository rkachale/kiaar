<div class="row">
    <div class="col-md-6 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-social-dribbble font-brown"></i>   
                    <span class="caption-subject font-brown bold uppercase">Insert Secondary FooterMenu </span>
                </div>
            </div>
          <div class="portlet-body form">
          <div class="form-body">
                <?php
                mk_hpostform($base_url.$page."_manipulate".(isset($data['menu_id'])?"/".$data['menu_id']:""));

                mk_htext("data[menu_name]",_l('Menu Name',$this),isset($data['menu_name'])?$data['menu_name']:'','required');
               
                foreach ($languages as $item) {
                            mk_htext("data[titles][".$item["language_id"]."]",_l('Menu name',$this)." (".$item["language_name"].")",isset($titles[$item["language_id"]])?$titles[$item["language_id"]]["title_caption"]:"",'required');
                        }

                mk_hselect("data[sub_menu]",_l('Parent',$this),$parents,"menu_id","menu_name",isset($data['sub_menu'])?$data['sub_menu']:null,""._l("Select Main Menu",$this)."");

                mk_hselect("data[page_id]",_l('Select Page',$this),$pages,"page_id","page_name",isset($data['page_id'])?$data['page_id']:null,""._l("Select Page Link",$this)."");

                mk_hurl("data[menu_url]",_l('External URL',$this),isset($data['menu_url'])?$data['menu_url']:'',"style='direction:ltr'");

                mk_hnumber("data[menu_order]",_l('Menu Order',$this),isset($data['menu_order'])?$data['menu_order']:'');

                mk_htext("data[class]",_l('CSS Class',$this),isset($data['class'])?$data['class']:'');

                mk_hcheckbox("data[public]",_l('Publish',$this),(isset($data['public']) && $data['public']==1)?1:null);

                mk_hsubmit(_l('Submit',$this),$base_url."edit".$page,_l('Cancel',$this));

                mk_closeform();
                ?>
             </div>

 </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>



    <div class="col-md-6">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-social-dribbble font-brown"></i>
                    <span class="caption-subject font-brown bold uppercase">Secondary Footer Menu List</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="portlet-body flip-scroll">
                    <table class="table table-bordered table-striped table-condensed flip-content">
                        <thead class="flip-content">
                            <tr>
                                <th> Menu Name </th>
                                <th class="numeric"> Menu Order </th>
                                <th> Publish </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($data_list as $item){ $i++; ?>
                                <tr class="gradeX">
                                   <!--  <td><?php echo $i; ?>.</td> -->
                                    <td class="mainbold"><?=$item["menu_name"]?></td>
                                    <td class="mainbold center"><?=$item["menu_order"]?></td>
                                    <td class="center"><i class="fa <?=(isset($item["public"]) && $item["public"]==1)?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td class="center">
                                        <a href="<?=$base_url?>edit<?=$page?>/<?=$item["menu_id"]?>" class="btn orange" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        <a href="<?=$base_url?>delete<?=$page?>/<?=$item["menu_id"]?>"  class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();">  <i title="<?=_l('Delete',$this)?>" class="icon-trash"></i></a>
                                    </td>
                                </tr>
                            <?php if(isset($item['sub_menu_data']) && count($item['sub_menu_data'])!=0){ ?>
                                <?php $j=0; foreach($item['sub_menu_data'] as $item2){ $j++; ?>
                                    <tr class="gradeX" style="font-style: italic;">
                                        <!-- <td><?php echo $i; ?>-<?php echo $j; ?>.</td> -->
                                        <td class="subme"><?=$item2["menu_name"]?></td>
                                        <td class="subme center"><?=$item2["menu_order"]?></td>
                                        <td class="center"><i class="fa <?=(isset($item2["public"]) && $item2["public"]==1)?"fa-check":"fa-minus-circle"?>"></i></td>
                                        <td class="center">
                                            <a href="<?=$base_url?>edit<?=$page?>/<?=$item2["menu_id"]?>" class="btn orange" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                            <a href="<?=$base_url?>delete<?=$page?>/<?=$item2["menu_id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();">  <i title="<?=_l('Delete',$this)?>" class="icon-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php } ?>
                             </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
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