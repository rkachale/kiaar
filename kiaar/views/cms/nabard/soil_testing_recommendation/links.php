<div class="form-group ">
    <label for="status" class="control-label col-lg-2">Links and Values</label>
    <div class="col-lg-10 col-sm-10">
        <div class="boxform">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Parameter Name</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Value</th>
                        <th scope="col">Range</th>
                        <!-- <th scope="col">Link</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($links) && count($links)!=0){ ?>
                        <input type="hidden" name="links_array_check" value="2">
                        <?php
                            $in = 0;
                            foreach ($links as $key5 => $data5) { 
                        ?>
                        <tr data-id="<?php echo $data5['id'] ?>">
                            <?php //if($data5['comes_under'] == 0) { ?>
                                <!-- <td><b><?=$data5['parameter_name']?></b></td> -->
                                <!-- <input type="hidden" id="test_parameterid<?php echo $key5; ?>" name="test_parameterid[]" value="<?=$data5['parameter_ID']?>"> -->
                            <?php //} else { ?>
                                <td><?=$data5['parameter_name']?>
                                    <input type="hidden" id="test_parameterid<?php echo $key5; ?>" name="test_parameterid[]" value="<?=$data5['parameter_ID']?>">
                                </td>
                            <?php //} ?>
                            <td><?=$data5['measure_unit']?></td>
                            <?php //if($data5['comes_under'] == 0) { ?>
                                <!-- <td><input type="hidden" name="test_value[]"/></td> -->
                            <?php //} else { ?>
                                <td><input type="text" id="test_value<?php echo $key5; ?>" name="test_value[]" value="<?=$data5['parameter_value']?>" onkeypress="return isNumberKey(event)" required/></td>
                            <?php //} ?>
                            <td><?=$data5['standard_range']?></td>
                            <?php //if($data5['comes_under'] == 0) { ?> 
                                <!-- <td><input type="hidden" name="s3_link[]"/></td> -->
                            <?php //} else { ?>
                                <!-- <td><input type="text" id="s3_link<?php //echo $key5; ?>" name="s3_link[]" value="<?=$data5['s3_link']?>"/></td> -->
                            <?php //} ?>
                            <input type='hidden' name='id2[]' value='<?php echo $data5['tran_tail_ID'] ?>' />
                            <input type='hidden' name='template_id[]' value='<?php echo $data5['template_ID'] ?>' />
                        </tr>
                    <?php $in++;}} else { ?>
                        <input type="hidden" name="links_array_check" value="1">
                        <?php foreach ($otherpage as $key => $value) { ?>
                            <tr>
                                <?php //if($value['comes_under'] == 0) { ?>
                                    <!-- <td><b><?=$value['parameter_name']?></b></td> -->
                                    <!-- <input type="hidden" name="test_parameterid[]" value="<?=$value['parameter_ID']?>"> -->
                                <?php //} else { ?>
                                    <td><?=$value['parameter_name']?>
                                        <input type="hidden" name="test_parameterid[]" value="<?=$value['parameter_ID']?>">
                                    </td>
                                <?php //} ?>
                                <td><?=$value['measure_unit']?></td>
                                <?php //if($value['comes_under'] == 0) { ?>
                                    <!-- <td><input type="hidden" name="test_value[]"/></td> -->
                                <?php //} else { ?>
                                    <td><input type="text" name="test_value[]" value="<?=$value['parameter_value']?>" onkeypress="return isNumberKey(event)" required/></td>
                                <?php //} ?>
                                <td><?=$value['standard_range']?></td>
                                <?php //if($value['comes_under'] == 0) { ?>
                                    <!-- <td><input type="hidden" name="s3_link[]"/></td> -->
                                <?php //} else { ?>
                                    <!-- <td><input type="text" name="s3_link[]"/></td> -->
                                <?php //} ?>
                                <input type='hidden' name='id2[]' value='<?php echo $value['tran_tail_ID'] ?>' />
                                <input type='hidden' name='template_id[]' value='<?php echo $value['template_ID'] ?>' />
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
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
.all-scroll {cursor: all-scroll;}
</style>