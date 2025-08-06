<div class="row">
    <div class="col-md-6 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-social-dribbble font-brown"></i>   
                    <span class="caption-subject font-brown bold uppercase">Insert FooterMenu <?= "- ". $institutes_details['INST_NAME'] ?>  (<?= $institutes_details['INST_SHORTNAME']?>)</span>
                </div>
            </div>
             <?php 

                $instituteId=$this->uri->segment(4);

                $_SESSION['inst_id']=$this->uri->segment(4);
                if(isset($instituteId) AND $instituteId!="") {
                    $_SESSION['inst_id']=$instituteId;
                } else {
                    $_SESSION['inst_id']=50;
                }

            ?>       
            <div class="portlet-body form">
                <?php mk_hpostform($base_url.$page."_manipulate".(isset($data['menu_id'])?"/".$data['menu_id']:"")); ?>
                    <div class="form-body">
                        <?php 
                        mk_htext("data[menu_name]",_l('Menu Name',$this),isset($data['menu_name'])?$data['menu_name']:'','required'); 

                        foreach ($languages as $item) {
                            mk_htext("data[titles][".$item["language_id"]."]",_l('Menu name',$this)." (".$item["language_name"].")",isset($titles[$item["language_id"]])?$titles[$item["language_id"]]["title_caption"]:"",'required');
                        }
                        mk_hidden("data[institute_id]",$_SESSION['inst_id']);

                        mk_hselect("data[sub_menu]",_l('Parent',$this),$parents,"menu_id","menu_name",isset($data['sub_menu'])?$data['sub_menu']:null,""._l("Select Main Menu",$this)."");

                        // mk_hselect("data[sub_sub_menu]",_l('Sub Parent',$this),$subparents,"menu_id","menu_name",isset($data['sub_sub_menu'])?$data['sub_sub_menu']:null,""._l("Select Sub Menu",$this)."");

                        mk_hselect("data[page_id]",_l('Select Page',$this),$pages,"page_id","page_name",isset($data['page_id'])?$data['page_id']:null,""._l("Select Page Link",$this)."");

                        // mk_hselect("data[institute_id]",_l('Select Institute',$this),$institutes,"INST_ID","INST_NAME",isset($data['institute_id'])?$data['institute_id']:null,""._l("Select Institute",$this)."");

                        mk_hurl("data[menu_url]",_l('External URL',$this),isset($data['menu_url'])?$data['menu_url']:'',"style='direction:ltr'");

                        mk_hnumber("data[menu_order]",_l('Menu Order',$this),isset($data['menu_order'])?$data['menu_order']:'');

                        mk_htext("data[class]",_l('CSS Class',$this),isset($data['class'])?$data['class']:'');

                        mk_hpostcheckbox("data[public]",_l('Publish',$this),(isset($data['public']) && $data['public']==1)?1:null);

                        mk_hpostcheckbox("data[target]",_l('New Tab',$this),(isset($data['target']) && $data['target']==1)?1:null);
                        
                        mk_hsubmit(_l('Submit',$this),$base_url."edit".$page.(isset($_SESSION['inst_id'])?"/institute/".$_SESSION['inst_id']:""),_l('Cancel',$this));

                        ?>
                    </div>
                <?php mk_closeform(); ?>
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
                    <span class="caption-subject font-brown bold uppercase">Footer Menu List</span>
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
                                <tr>
                                    <td> <?=$item["menu_name"]?> </td>
                                    <td class="center"> <?=$item["menu_order"]?> </td>
                                    <td class="center"> <i class="fa <?=(isset($item["public"]) && $item["public"]==1)?"icon-check":"icon-close icons"?>"></i>
                                    </td>
                                    <td class="center">
                                        <a href="<?=$base_url?>edit<?=$page?>/institute/<?=$_SESSION['inst_id']?>/<?=$item["menu_id"]?>" class="btn orange" title="<?=_l('Edit',$this)?>">
                                        <i title="<?=_l('Edit',$this)?>" class="icon-note"></i>
                                        </a>
                                        <a href="<?=$base_url?>delete<?=$page?>/institute/<?=$_SESSION['inst_id']?>/<?=$item["menu_id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();">
                                         <i title="<?=_l('Delete',$this)?>" class="icon-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php if(isset($item['sub_menu_data']) && count($item['sub_menu_data'])!=0){ ?>
                                    <?php $j=0; foreach($item['sub_menu_data'] as $item2){  ?>
                                        <tr>
                                            <td><?=$item2["menu_name"]?></td>
                                            <td class="center"><?=$item2["menu_order"]?></td>
                                            <td class="center"><i class="fa <?=(isset($item2["public"]) && $item2["public"]==1)?"fa-check":"fa-minus-circle"?>"></i>
                                            </td>
                                            <td class="center">
                                                <a href="<?=$base_url?>edit<?=$page?>/institute/<?=$_SESSION['inst_id']?>/<?=$item2["menu_id"]?>" class="btn orange" title="<?=_l('Edit',$this)?>">
                                                <i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i>
                                                </a>
                                                <a href="<?=$base_url?>delete<?=$page?>/institute/<?=$_SESSION['inst_id']?>/<?=$item2["menu_id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();">
                                                 <i title="<?=_l('Delete',$this)?>" class="icon-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php if(isset($item['sub_menu_data'][$j]['sub_sub_menu_data']) && count($item['sub_menu_data'][$j]['sub_sub_menu_data'])!=0){  
                                                ?>
                                            <?php $k=1; foreach($item['sub_menu_data'][$j]['sub_sub_menu_data'] as $item3){ ?>
                                                <tr class="gradeX" style="font-style: italic;">
                                                    <td class="childme"><?=$item3["menu_name"]?></td>
                                                    <td class="childme center"><?=$item3["menu_order"]?></td>
                                                    <td class="center"><i class="fa <?=(isset($item3["public"]) && $item3["public"]==1)?"fa-check":"fa-minus-circle"?>"></i>
                                                    </td>
                                                    <td class="center"style="width: 100px">
                                                        <a href="<?=$base_url?>edit<?=$page?>/institute/<?=$_SESSION['inst_id']?>/<?=$item3["menu_id"]?>" class="btn orange" title="<?=_l('Edit',$this)?>">
                                                        <i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i>
                                                        </a>
                                                        <a href="<?=$base_url?>delete<?=$page?>/institute/<?=$_SESSION['inst_id']?>/<?=$item3["menu_id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();">
                                                         <i title="<?=_l('Delete',$this)?>" class="icon-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php $k++;} ?>
                                        <?php } ?>
                                    <?php $j++;} ?>
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
<style type="text/css">
    .form-control{margin-bottom: 15px;}
</style>
<script>
function doconfirm()
{
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
}
</script>