    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($project_id) && !empty($project_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Project</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Project</span>
                       <?php } ?>                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/projects/'); ?>">Back </a></span>
                </div> <?php //print_r($post_data); exit();?>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="project_form" class="cmxform form-horizontal tasi-form" method="post" action="" enctype='multipart/form-data'>
                            <div class="form-group ">
                                <label for="name" class="control-label col-lg-2">Research Project Title<span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                    <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="area" class="control-label col-lg-4 area-lbl">Area <span class="asterisk">*</span></label>
                                <div class="col-lg-8 col-sm-10">
                                    <select id="area_id" class="form-control select2" data-error=".areaerror" name="area_id" data-placeholder="Select Area" required>
                                    <option value="">Select Area</option>
                                        <?php if(isset($areas) && count($areas)!=0){ ?>
                                        <?php foreach ($areas as $key4 => $data4) { ?>
                                            <option value="<?=$data4['area_id']?>" <?php if($post_data['area_id'] == $data4['area_id']) echo"selected"; ?>><?=$data4['name']?></option>
                                        <?php } } ?>
                                    </select>
                                     <div class="areaerror error_msg"><?php echo form_error('area_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                   
                            
                            <div class="form-group col-lg-6">
                                <label for="type" class="control-label col-lg-4 type-lbl">Type <span class="asterisk">*</span></label>
                                <div class="col-lg-8 col-sm-12">
                                    <select id="type" class="form-control select2" name="type" data-placeholder="Select Type" data-error=".typeerror"  required>
                                        <option value="">Select Type</option>
                                        <option value="research" <?php if($post_data['type'] == 'research') echo"selected"; ?>>Research</option>
                                        <option value="consultancy" <?php if($post_data['type'] == 'consultancy') echo"selected"; ?>>Consultancy</option>
                                    </select>
                                     <div class="typeerror error_msg"><?php echo form_error('type', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
        
                            <div class="form-group col-lg-6">
                            <label for="project_status" class="control-label col-lg-4 area-lbl proj-status-lbl"> Research Project Status <span class="asterisk">*</span></label>
                            <div class="col-lg-8 col-sm-12">
                                <select id="project_status" class="form-control select2"  name="project_status" data-placeholder="Select Research Project Status" data-error=".statuserror" required>
                                <option value="">Select Research Project Status</option>    
                                  <?php if(isset($post_data['project_status'])){ ?>
                                    
                                        <option value="<?=$post_data['project_status']?>" selected><?=$post_data['project_status']?></option>
                                    <?php } ?>
                                    <option value="On-Going">On-Going</option>
                                    <option value="Completed">Completed</option>
                                   
                                </select>
                                <div class="statuserror error_msg"><?php echo form_error('project_status', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                     <div class="form-group col-lg-6">
                                                <label for="date" class="control-label col-lg-4 startingyr proj-status-lbl">Starting Year and Month of the project <span class="asterisk">*</span></label>&nbsp;&nbsp;
                                             <div class="col-lg-8">
                                           <!--   <input type="text" id="datetimepicker2" name="date" value="<?php if(isset($post_data['date'])) { echo $post_data['date']; } ?>"  />  -->
                                             <input class="date-own form-control"  data-error=".dateserror"  name="date" value="<?php if(isset($post_data['date'])) { echo $post_data['date']; }else{ echo date('Y-m'); } ?>" style="width: 300px;    margin-top: -15px;" type="text" required>

                                              <div class="dateserror error_msg"><?php echo form_error('date', '<label class="error">', '</label>'); ?></div>
                                            </div>
                                             </div>

                                              <div class="form-group col-lg-6">
                                <label for="area_id" class="control-label col-lg-4 area-lbl">Category <span class="asterisk"></span></label>
                                <div class="col-lg-8 col-sm-10">
                                     <select id="single" class="form-control select2"  name="category_id" data-placeholder="Select Category" >
                                <option value="">Select Category</option>
                                    <?php if(isset($category) && count($category)!=0){ ?>  
                                    <?php foreach ($category as $key3 => $data3) { ?>
                                        <option value="<?=$data3['id']?>" <?php if($post_data['category_id'] == $data3['id']) echo"selected"; ?>><?=$data3['category_name']?></option>
                                    <?php } } ?>
                                </select>
                                <!-- <div class="catagoryerror error_msg"><?php echo form_error('category_id', '<label class="error">', '</label>'); ?></div>-->
                                </div> 
                            </div>

                   
                            
                            <div class="form-group col-lg-6">
                                <label for="type" class="control-label col-lg-4 type-lbl">Project Level <span class="asterisk"></span></label>
                                <div class="col-lg-8 col-sm-12">
                                    <select id="project_level" class="form-control select2"  name="project_level" data-placeholder="Select Project Level" data-error=".project_levelerror">
                                <option value="">Select Project Level</option>    
                                  <?php if(isset($post_data['project_level'])){ ?>
                                    
                                        <option value="<?=$post_data['project_level']?>" selected><?=$post_data['project_level']?></option>
                                    <?php } ?>
                                    <option value="Post-Doctoral">Post-Doctoral</option>
                                   <option value="Doctoral">Doctoral</option>
                                    <option value="Graduate">Graduate</option>
                                     <option value="Undergraduate">Undergraduate</option>
                                        <option value="Schools">Schools</option>
                                </select>
                               <!--  <div class="project_levelerror error_msg"><?php echo form_error('project_level', '<label class="error">', '</label>'); ?></div>-->
                                </div> 
                            </div>
                      <div class="form-group ">
                                <label for="Duration" class="control-label col-lg-2">Research Project Duration <span class="asterisk"></span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="duration" name="duration" value="<?php echo set_value('duration', (isset($post_data['duration']) ? $post_data['duration'] : '')); ?>"  data-error=".durationerror" maxlength="250">
                                    <div class="durationerror error_msg"><?php echo form_error('duration', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                             <div class="form-group">
                            <label for="projects_level" class="control-label col-lg-2"> Tags </label>
                            <div class="col-lg-10 col-sm-10">

                                    <input type="text" name ="tags" id="tags" value="<?=$post_data['tags']?>" data-role="tagsinput" />
                                </div>
                                </div>


<!-- 
                                <div class="form-group ">
                                <label for="Written_by" class="control-label col-lg-2">Written by<span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="Written_by" name="Written_by" value="<?php echo set_value('Written_by', (isset($post_data['Written_by']) ? $post_data['Written_by'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                    <div class="nameerror error_msg"><?php echo form_error('Written_by', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div> -->
                            
                          <!--   <div class="form-group ">
                                <label for="contact_no" class="control-label col-lg-2">Contact Number<span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo set_value('contact_no', (isset($post_data['contact_no']) ? $post_data['contact_no'] : '')); ?>" required data-error=".contact_noerror" maxlength="15">
                                    <div class="contact_noerror error_msg"><?php echo form_error('contact_no', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
 -->
                            <div class="form-group">
                                <label class="control-label col-lg-2">Featured Image <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <?php error_reporting(0);
                                        if(isset($post_data['image']) && !empty($post_data['image']) && count($post_data['image']) > 0){ 
                                    ?>
                                        <ul class="imagelocation<?php echo $post_data['project_id'] ?> gallerybg" id="sortable">
                                            <li id="item-<?php echo $post_data['project_id'] ?>">
                                                <img src="<?php echo base_url(); ?>upload_file/project_upload/<?php echo $post_data['image']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/projects/deletefeaimage/'.$post_data["project_id"]); ?>');">X</a>
                                            </li>
                                        </ul>                        

                                    <?php 
                                        } else{
                                    ?> 
                                    <div class="form-group">
                                        <div class="col-lg-12 col-sm-10">
                                            <div class="custom-file-upload">
                                                <input type="file" name="image" id="image" required>
                                                 <div data-error=".imageerror" class="imageerror error_msg"><?php echo form_error('image', '<label class="error">', '</label>'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>

<div class="form-group">
                            <?php if(isset($data_image) && is_array($post_data) && count($post_data)): $i=1; ?>
                         
                                <?php
                                    foreach ($data_image as $key => $data) { 
                                        $ext = pathinfo($data['image'], PATHINFO_EXTENSION);
                                ?>   
                                <label class="control-label col-lg-2">Uploaded Images</label>
                                <div class="col-lg-10 col-sm-10 row_position">
                                    <ul class="imagelocation<?php echo $data['id'] ?> gallerybg" id="sortable">
                                        <li style="list-style: none;" data-id="<?php echo $data['id'] ?>">
                                            <?php if($ext == 'mp4') { ?>
                                                <video class="respimg" width="200" height="200" controls>
                                                    <source src="<?php echo base_url(); ?>upload_file/project_upload/<?=$data['image']?>" type="video/<?=$ext?>"></source>
                                                </video>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url(); ?>upload_file/project_upload/<?php echo $data['image']; ?>" style="vertical-align:middle;" width="200" height="200">
                                            <?php } ?>
                                            <a href="javascript:void(0);" class="btn btn_bg_custred height200btn" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/projects/deleteimage/'.$data["id"].'?area_id='.$data["area_id"]); ?>');">X</a>
                                        </li>
                                    </ul></div>
                                <?php } ?>
                                
                            </div>

                            <?php endif; ?>

                                <div class="form-group">
                                    <label class="control-label col-lg-2">Upload Banner Images/video <span class="asterisk">*</span></label>
                                    <div class="col-lg-10 col-sm-10">
                                        <div class="custom-file-upload">
                                        <input type="file" name="userfile[]" id="image_file" accept=".png,.jpg,.jpeg,.gif,.mp4,.mpeg,.mpg,.avi,.mov"  data-max-size="8192‬"  multiple <?php if($data_image == '') {?>required<?php } else { ?> <?php } ?>>
                                    </div>
                                    </div>
                                </div>
                            

                            <label class="control-label col-lg-2 area-lbl"><b>Project Funders :</b></label><br />
                            <div class="boxform">
                                <table style="width: 100%;" class="research-teamtable"      >
                                <?php if(isset($uservalue) && count($uservalue)!=0){ ?>
                                    <input type="hidden" name="user_array_check" value="2">
                                    <?php
                                        $in = 0;
                                        foreach ($uservalue as $key5 => $data5) { 
                                    ?>

                                       <tr class="group_wrap">
                                            <td class="group_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2 funders-lbl">Name  </label>
                                                </div>
                                            </td>
                                            <td class="institute_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2 funders-lbl">Amount  </label>
                                                </div>
                                            </td>
                                            <td class="institute_td">
                                                <div class="p10">
                                                    <label class="control-label col-lg-2 funders-lbl">Logo  </label>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                            <tr class="group_wrap">
                                                <td class="group_td">
                                                    <div class="p10">
                                                        <input type="text" id="singlegrp<?php echo $key5; ?>" name="pname[]" value="<?php if(isset($data5['name'])) { echo $data5['name']; } ?>" Placeholder="Name">
                                                    </div>
                                                </td>
                                                <td class="institute_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleinst<?php echo $key5; ?>" name="amount[]" value="<?php if(isset($data5['amount'])) { echo $data5['amount']; } ?>" Placeholder="Amount">
                                                    </div>
                                                </td>
                                                <td class="institute_td">
                                                    <div class="p10">
                                                        <img src="<?php echo base_url(); ?>upload_file/project_upload/project_logos/<?php echo $data5['logo']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                    </div>
                                                </td>
                                                <td class="add_remove_td">
                                                    <div class="p10">
                                                        <?php if($key5 == 0){ ?>
                                                            <a class="add" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                        <?php }else{ ?>
                                                            <a class="removeMore" data-id="<?php echo $data5['pid'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <input type='hidden' name='id2[]' value='<?php echo $data5['pid'] ?>' />
                                            </tr>
                                    <?php $in++;}} else { ?>
                                        <input type="hidden" name="user_array_check" value="1">

                                        <tr class="group_wrap">
                                            <td class="group_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Name  </label>
                                                </div>
                                            </td>
                                            <td class="institute_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Amount  </label>
                                                </div>
                                            </td>
                                            <td class="institute_td">
                                                <div class="p10">
                                                    <label class="control-label col-lg-2">Logo  </label>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                        <tr class="group_wrap">
                                            <td class="group_td">
                                                <div class="p10">
                                                    <input type="text" id="singlegrp0" name="pname[]" Placeholder="Name">
                                                </div>
                                            </td>
                                            <td class="institute_td">
                                                <div class="p10">
                                                    <input type="text" id="singleinst0" name="amount[]" Placeholder="Amount">
                                                </div>
                                            </td>
                                            <td class="institute_td">
                                                <div class="p10">
                                                    <input type="file" id="singleimg0" name="logo[]" accept=".png,.jpg,.jpeg,.gif" multiple>
                                                </div>
                                            </td>
                                            <td class="add_remove_td">
                                                <div class="p10">
                                                    <a class="add" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>

                            <input type="hidden" name="project_content_id" value="<?php echo $post_data['project_content_id']; ?>">
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                            <input type="hidden" name="language_id" value="1">



<!--       <label class="control-label col-lg-4"><b>Project Research Team :</b></label><br /> -->
   


                                <div class="form-group">
                                    <label class="control-label col-lg-3"><b>Project Research Team </b></label>
                                    <div class="col-lg-4 col-sm-5">
                                         <label class="control-label " style="float: left;margin-right:10px;"> Existing User<span class="asterisk"></span></label>
                                       <input type='checkbox' style="width: 20px;height: 34px;float: left;" name='Existing' id="Existing_user" value='Existing'  <?php if(isset($uservalueExisting) && count($uservalueExisting)!=0){ ?> checked="checked" <?php } else{ ?>  <?php }?>>
                                    </div>

                                    <div class="col-lg-4 col-sm-5">
                                         <label class="control-label " style="float: left;margin-right:10px;">External User </label>
                                          <input type='checkbox'  style="width: 20px;height: 34px;float: left;" name='External' id="External_user" value='External'  <?php if(isset($uservalueExternal) && count($uservalueExternal)!=0){ ?> checked="checked" <?php } else{ ?>  <?php }?> >
                                    </div>
                                </div>


                            <table width="200" style="display: none;">
                              <tr>
                                <td>

                                


                                <!--   <label>Existing User</label>  -->
                                 
                             
                                <!--  <input type='checkbox' class="checkbox form-control" name='Existing' id="Existing_user" value='Existing'  <?php if(isset($uservalueExisting) && count($uservalueExisting)!=0){ ?> checked="checked" <?php } else{ ?>  <?php }?>> <br> -->
                                </td>
                                <td>
                                <!--   <label>External User</label> -->
                              <!--    <input type='checkbox' class="checkbox form-control" name='External' id="External_user" value='External'  <?php if(isset($uservalueExternal) && count($uservalueExternal)!=0){ ?> checked="checked" <?php } else{ ?>  <?php }?> > --> <br>
                                </td>  
                              </tr>
                            </table> 


                            <div class="boxform" id="Existing_user_Box"  <?php if(isset($uservalueExisting) && count($uservalueExisting)!=0){ ?>style="display: block" <?php } else{ ?> style="display: none" <?php }?> >
                                  <div class="dataerror error_msg"><label class="error" id="eiderror"></label></div>

                                <table style="width: 100%;" class="research-teamtable">
                                <?php if(isset($uservalueExisting) && count($uservalueExisting)!=0){ ?>
                                    <input type="hidden" name="user_array_checkexi" value="2">
                                    <?php
                                        $in = 0;
                                        foreach ($uservalueExisting as $key6 => $data6) { 
                                    ?>
                                    <tr class="group_wrapexi">
                                            <td class="empid_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Somaiya Emp Id  </label>
                                                </div>
                                            </td>
                                            <td class="exiname_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Name  </label>
                                                </div>
                                            </td>
                                            <td class="existingInstitute_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Institute Name  </label>
                                                </div>
                                            </td>
                                            <td class="existingaboutemp_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">About Employee  </label>
                                                </div>
                                            </td>
                                           <td class="exitype_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Type  </label>
                                                </div>
                                            </td>
                                            <td class="exiemail_td">
                                                <div class="p10">
                                                    <label class="control-label col-lg-2">Email  </label>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                  
                                            <tr class="group_wrapexi">

                                                <td class="empid_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleempid<?php echo $key6; ?>" onfocusout="checkempdata(this.id,<?php echo $key6; ?>)"  name="empid[]" value="<?php if(isset($data6['e_id'])) { echo $data6['e_id']; } ?>" Placeholder="Somaiya Emp Id">
                                                    </div>
                                                </td>

                                             
                                                <td class="exiname_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleexiname<?php echo $key6; ?>" name="existing_name[]" value="<?php if(isset($data6['name'])) { echo $data6['name']; } ?>" Placeholder="Existing name">
                                                    </div>
                                                </td>
                                               
                                                   <td class="existingInstitute_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleexiInstitute<?php echo $key6; ?>" name="Institute_name[]" style="display:none" value="<?php if(isset($data6['institute_id'])) { echo $data6['institute_id']; } ?>" Placeholder="Institute name">
                                                         <input type="text" id="singleexiInstituten<?php echo $key6; ?>" name="Institute_namen[]" value="<?php if(isset($data6['INST_NAME'])) { echo $data6['INST_NAME']; } ?>" Placeholder="Institute name">
                                                    </div>
                                                </td>

                                                 <td class="existingaboutemp_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleexiabout<?php echo $key6; ?>" name="Existing_about[]" value="<?php if(isset($data6['about_employee'])) { echo $data6['about_employee']; } ?>" Placeholder="About Employee">
                                                        
                                                    </div>
                                                </td>
                                                      <td class="Exitype_td">
                                                        <div class="p10">
                                                         

                                                            <select id="singleExitype<?php echo $key6; ?>" class=""  name="existing_type[]" data-placeholder="Select Team Type" data-error=".typeerror" required>
                                                                <option value="">Select Team Type</option>    
                                                                  <?php if(isset($data6['type'])){ ?>
                                                                     <option value="<?=$data6['type']?>" selected><?=$data6['type']?></option>
                                                                    <?php } ?>
                                                                    <option value="Principal_Investigator">Principal Investigator</option>
                                                                    <option value="Co-Investigator">Co-Investigator</option>
                                                                   
                                                                </select>
                                                        </div>
                                                    </td>
                                                <td class="Exiemail_td">
                                                    <div class="p10">
                                                       <input type="text" id="singleExiemail<?php echo $key6; ?>" name="Existing_email[]" value="<?php if(isset($data6['email'])) { echo $data6['email']; } ?>" Placeholder="Email" >
                                                    </div>
                                                </td>

                                                <td class="add_remove_tdexi">
                                                    <div class="p10">
                                                        <?php if($key6 == 0){ ?>
                                                            <a class="addexi" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                        <?php }else{ ?>
                                                            <a class="removeMoreexi" data-id="<?php echo $data6['prid'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>

                                                <input type='hidden' name='idexi[]' value='<?php echo $data6['prid'] ?>' />
                                            </tr>
                                    <?php $in++;}} else { ?>
                                        <input type="hidden" name="user_array_checkexi" value="1">

                                          <tr class="group_wrapexi">
                                            <td class="empid_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Somaiya Emp Id  </label>
                                                </div>
                                            </td>
                                            <td class="exiname_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Name  </label>
                                                </div>
                                            </td>
                                            <td class="existingInstitute_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Institute Name  </label>
                                                </div>
                                            </td>
                                             <td class="existingaboutemp_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">About Employee  </label>
                                                </div>
                                            </td>
                                           <td class="exitype_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Type  </label>
                                                </div>
                                            </td>
                                            <td class="exiemail_td">
                                                <div class="p10">
                                                    <label class="control-label col-lg-2">Email  </label>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                        <tr class="group_wrapexi">
                                            <td class="empid_td">
                                                <div class="p10">

                                                    <input type="text" onfocusout="checkempdata(this.id,0)" id="singleempid0" name="empid[]" Placeholder="smomaiya Employee Id">
                                                </div>
                                            </td>
                                            <td class="exiname_td">
                                                <div class="p10">
                                                    <input type="text" id="singleexiname0" name="existing_name[]" Placeholder="Name">
                                                </div>
                                            </td>
                                            <td class="existingInstitute_td">
                                                <div class="p10">
                                                      <input type="text" id="singleexiInstitute0"  style="display:none" name="Institute_name[]" Placeholder="Institute name">
                                                       <input type="text" id="singleexiInstituten0" name="Institute_namen[]" Placeholder="Institute name">
                                                </div>
                                            </td>
                                             <td class="existingaboutemp_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleexiabout0" name="Existing_about[]" Placeholder="About Employee">
                                                        
                                                    </div>
                                                </td>
                                              <td class="exitype_td">
                                                <div class="p10">
                                                    <select id="singleExitype0" class=""  required name="existing_type[]" data-placeholder="Select Team Type" data-error=".typeerror">
                                <option value="">Select Team Type</option>    
                                  <?php if(isset($data['existing_type'])){ ?>
                                     <option value="<?=$post_data['existing_type']?>" selected><?=$post_data['existing_type']?></option>
                                    <?php } ?>
                                    <option value="Principal Investigator">Principal Investigator</option>
                                    <option value="Co-Investigator">Co-Investigator</option>
                                   
                                </select> </div>
                                            </td>
                                            <td class="exiemail_td">
                                                <div class="p10">
                                                    <input type="text" id="singleExiemail0" name="Existing_email[]"  />
                                               </div>
                                            </td>

                                            <td class="add_remove_tdexi">
                                                <div class="p10">
                                                    <a class="addexi" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="boxform" id="External_user_Box" <?php if(isset($uservalueExternal) && count($uservalueExternal)!=0){ ?>style="display: block" <?php } else{ ?> style="display: none" <?php }?>  >
                                <table style="width: 100%;" class="research-teamtable">
                                <?php if(isset($uservalueExternal) && count($uservalueExternal)!=0){ ?>
                                    <input type="hidden" name="user_array_checkExt" value="2">
                                    <?php
                                        $in = 0;

                                        foreach ($uservalueExternal as $key7 => $data7) { 

                                    ?>

                                     <tr class="group_wrapext">
                                            <td class="Extname_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Name  </label>
                                                </div>
                                            </td>
                                             <td class="ExtInstname_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Institute Name  </label>
                                                </div>
                                            </td>
                                             <td class="Extdesig_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Designation  </label>
                                                </div>
                                            </td>
                                             <td class="Extaboutemp_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">About Employee  </label>
                                                </div>
                                            </td>
                                            <td class="Exttype_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Type  </label>
                                                </div>
                                            </td>
                                            <td class="extemail_td">
                                                <div class="p10">
                                                    <label class="control-label col-lg-2">Email  </label>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                            <tr class="group_wrapext">
                                                <td class="extname_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleExtname<?php echo $key7; ?>" name="Extname[]" value="<?php if(isset($data7['name'])) { echo $data7['name']; } ?>" Placeholder="Name" required>
                                                    </div>
                                                </td>
                                                 <td class="extname_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleExtInstname<?php echo $key7; ?>" name="ExtInstname[]" value="<?php if(isset($data7['department'])) { echo $data7['department']; } ?>" Placeholder="Institute Name" >
                                                    </div>
                                                </td>
                                                 <td class="extname_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleExtdesig<?php echo $key7; ?>" name="Extdesig[]" value="<?php if(isset($data7['designation'])) { echo $data7['designation']; } ?>" Placeholder="Designation" >
                                                    </div>
                                                </td>
                                                 <td class="extaboutemp_td">
                                                    <div class="p10">
                                                        <input type="text" id="singleExtaboutemp<?php echo $key7; ?>" name="Extabout_emp[]" value="<?php if(isset($data7['about_employee'])) { echo $data7['about_employee']; } ?>" Placeholder="About Employee" >
                                                    </div>
                                                </td>
                                                <td class="exttype_td">
                                                    <div class="p10">

                                                         <select id="singleExttype<?php echo $key7; ?>" class=""  required name="external_type[]" data-placeholder="Select Team Type" data-error=".typeerror" required>
                                                                <option value="">Select Team Type</option>    
                                                                  <?php if(isset($data7['type'])){ ?>
                                                                     <option value="<?=$data7['type']?>" selected><?=$data7['type']?></option>
                                                                    <?php } ?>
                                                                    <option value="principal Investigator">Principal Investigator</option>
                                                                    <option value="Co-Investigator">Co-Investigator</option>
                                                                   
                                                                </select>

                                                    </div>
                                                </td>
                                                <td class="extemail_td">
                                                    <div class="p10">
                                                       <input type="text" id="singleExtemail<?php echo $key7; ?>" name="external_email[]"  value="<?php if(isset($data7['email'])) { echo $data7['email']; } ?>" Placeholder="Email" >
                                                    </div>
                                                </td>
                                                <td class="add_remove_tdext">
                                                    <div class="p10">
                                                        <?php if($key7 == 0){ ?>
                                                            <a class="addext" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                        <?php }else{ ?>
                                                            <a class="removeMoreext" data-id="<?php echo $data7['prid'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <input type='hidden' name='idext2[]' value='<?php echo $data7['prid'] ?>' />
                                            </tr>
                                    <?php $in++;}} else { ?>
                                        <input type="hidden" name="user_array_checkExt" value="1">

                                          <tr class="group_wrapext">
                                            <td class="Extname_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Name  </label>
                                                </div>
                                            </td>
                                             <td class="ExtInstname_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Institute Name  </label>
                                                </div>
                                            </td>
                                             <td class="Extdesig_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Designation  </label>
                                                </div>
                                            </td>
                                             <td class="Extaboutemp_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">About Employee  </label>
                                                </div>
                                            </td>
                                            <td class="Exttype_td">
                                                <div class="p10">
                                                   <label class="control-label col-lg-2">Type  </label>
                                                </div>
                                            </td>
                                            <td class="extemail_td">
                                                <div class="p10">
                                                    <label class="control-label col-lg-2">Email  </label>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                        <tr class="group_wrapext">
                                            <td class="Extname_td">
                                                <div class="p10">

                                                    <input type="text" id="singleExtname0" name="Extname[]" Placeholder="Name" required>
                                                </div>
                                            </td>
                                             <td class="ExtInstname_td">
                                                <div class="p10">

                                                    <input type="text" id="singleExtInstname0" name="ExtInstname[]" Placeholder="Institute Name" >
                                                </div>
                                            </td>
                                             <td class="Extdesig_td">
                                                <div class="p10">

                                                    <input type="text" id="singleExtdesig0" name="Extdesig[]" Placeholder="Designation" >
                                                </div>
                                            </td>
                                            <td class="Extaboutemp_td">
                                                <div class="p10">

                                                    <input type="text" id="singleExtaboutemp0" name="Extabout_emp[]" Placeholder="About Employee" >
                                                </div>
                                            </td>
                                            <td class="Exttype_td">
                                                <div class="p10">
                                                    <select id="singleExttype0" class=""  name="external_type[]" required data-placeholder="Select Team Type" data-error=".typeerror" required>
                                <option value="">Select Team Type</option>    
                                 <!--  <?php if(isset($data['external_type'])){ ?>
                                    
                                        <option value="<?=$post_data['external_type']?>" selected><?=$post_data['external_types']?></option>
                                    <?php } ?> -->
                                    <option value="Principal Investigator">Principal Investigator</option>
                                    <option value="Co-Investigator">Co-Investigator</option>
                                   
                                </select> </div>
                                            </td>
                                            <td class="extemail_td">
                                                <div class="p10">
                                                    <input type="text" id="singleExtemail0"  name="external_email[]"  />
                                               </div>
                                            </td>
                                            <td class="add_remove_tdext">
                                                <div class="p10">
                                                    <a class="addext" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>

                            <?php 
                                mk_hWYSItexteditor("description",_l('Description',$this),isset($post_data['description'])?$post_data['description']:'','required');
                                mk_hWYSItexteditor("content",_l('Content',$this),isset($post_data['content'])?$post_data['content']:'','required');
                            ?>

                            
                           <!--  <div class="form-group">
                                <label for="chknogoal" class="control-label col-lg-2">Select Multiple Files</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input type="file" class="form-control" name="files" id="files" multiple />
                                </div>

                                <br />  <br />

                                <?php
                                    if(isset($projects_documents) && count($projects_documents)!=0){ 
                                    foreach ($projects_documents as $key3 => $data3) { 
                                ?>  
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <?php $ext = pathinfo($data3["document"], PATHINFO_EXTENSION); //echo $ext;
                                        if($ext=='jpg' or $ext=='jpeg' or $ext=='png') { ?>
                                            <img src=<?php echo base_url().'assets/project_upload/'.$data3["document"]?> class="img-responsive img-thumbnail" height="200" />                                         
                                        <?php } elseif($ext=='doc' OR $ext=='docx') { ?>
                                            <a href='<?php echo base_url().'assets/project_upload/'.$data3["document"]?>'><img src="<?php echo base_url()?>assets/project_upload/doc.png" height="200"></a>
                                        <?php } elseif($ext=='pdf') { ?>
                                            <a href='<?php echo base_url().'assets/project_upload/'.$data3["document"]?>'><img src="<?php echo base_url()?>assets/project_upload/pdf.png" height="200"></a>
                                        <?php } ?>

                                        <span class="close" style="cursor:pointer;" onclick="javascript:deletedocument(<?php echo $data3['doc_id'] ?>)">X</span>
                                    </div>
                                <?php
                                    } }
                                ?>
                                <div style="clear:both"></div>
                                <br />
                                <br />
                                <div id="uploaded_images"></div>
                            </div> -->

                            <div class="form-group ">
                                <label for="pdf_path" class="control-label col-lg-2">PDF Path <span class="asterisk"></span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="pdf_path" name="pdf_path" value="<?php echo set_value('pdf_path', (isset($post_data['pdf_path']) ? $post_data['pdf_path'] : '')); ?>"   >
                                <!--             <div class="durationerror error_msg"><?php echo form_error('duration', '<label class="error">', '</label>'); ?></div> -->
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="featured_project" class="control-label col-lg-2">Featured</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="featured_project_checkbox" type="checkbox" <?php if(isset($post_data['featured_project']) && $post_data['featured_project'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('featured_project', (isset($post_data['featured_project']) ? $post_data['featured_project'] : '')); ?>" style="display: none;" id="featured_project" name="featured_project" checked="" type="text">
                                </div>
                            </div>

                            <div class="form-group ">
                               <label for="public" class="control-label col-lg-2">Publish&nbsp;&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this post on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/projects/index/'.$institute) ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>


<style>
input[type=text] {
    padding: 12px;
    margin: 3px 0;
    border: 1px solid #ddd;
     width: 92%;
}
div.boxform{
    border: 1px solid lightgrey;
    padding: 10px;
    margin: 25px;
    margin-left: 0;
}
.area-lbl{
    padding-left: 0;
    padding-top: 4px;
}
.type-lbl{
    padding-left: 0;
  padding-top: 4px;
}
table tr td input[type=text]{
    width: 90%;
}
.research-teamtable tr td label{
    width: 100%;
    padding: 0;
}
.research-teamtable tr td input[type=text] {
    height: 34px;
}
.research-teamtable tr td select{
    height: 34px;
    border: 1px solid #ddd;
        width: 90%;

}
.startingyr{
    padding-right:0;
    padding-left: 0;
}
.funders-lbl{
    padding-left: 0;
    margin-bottom: -10px !important;
}
.gallerybg {
    padding-left: 0;
    list-style-type: none;
}
.btn_bg_custred{
top: -40px;
    padding: 4px 10px 4px !important;

}
.height200btn{
        top: -100px;

}
.custom-file-upload-hidden {
    display: none;
    visibility: hidden;
    position: absolute;
    left: -9999px;
}
.custom-file-upload {
    display: block;
    width: auto;

   
}
.custom-file-upload  label {
        display: block;
        margin-bottom: 5px;
    }
.file-upload-wrapper {
    position: relative; 
    margin-bottom: 5px;
    //border: 1px solid #ccc;
}
.file-upload-input {
     width: 80% !important;
    color: #464961;
     font-size: 14px;
    padding: 11px 17px;
    border: none;
    border-bottom:1px solid #464961;
    background-color: transparent;
    transition:all 0.2s ease; 
    padding: 10px 10px !important;
    margin: 0 !important;
    float: left; /* IE 9 Fix */
}
.file-upload-input:hover, .file-upload-input:focus { 
    outline: none; 
}

.file-upload-button {
    cursor: pointer; 
    display: inline-block; 
    color: #464961;
    font-size: 14px;
     outline:none;
     border:none;
    text-transform: uppercase;
    padding: 0px 20px;
        margin-left:-1px;
    background-color: #f0efe9; 
    float: left; /* IE 9 Fix */
    transition:all 0.2s ease;
        height: 42px;

}
.file-upload-button:hover {
    background-color:#D7D6D0;
}
.form-horizontal .control-label{
        font-weight: 600;

}
.proj-status-lbl{
    padding-top:0 !important;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
<script>
//Reference: 
//https://www.onextrapixel.com/2012/12/10/how-to-create-a-custom-file-input-with-jquery-css3-and-php/
;(function($) {

          // Browser supports HTML5 multiple file?
          var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
              isIE = /msie/i.test( navigator.userAgent );

          $.fn.customFile = function() {

            return this.each(function() {

              var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
                  $wrap = $('<div class="file-upload-wrapper">'),
                  $input = $('<input type="text" class="file-upload-input" />'),
                  // Button that will be used in non-IE browsers
                  $button = $('<button type="button" class="file-upload-button">Browse</button>'),
                  // Hack for IE
                  $label = $('<label class="file-upload-button" for="'+ $file[0].id +'">Browse</label>');

              // Hide by shifting to the left so we
              // can still trigger events
              $file.css({
                position: 'absolute',
                left: '-9999px'
              });

              $wrap.insertAfter( $file )
                .append( $file, $input, ( isIE ? $label : $button ) );

              // Prevent focus
              $file.attr('tabIndex', -1);
              $button.attr('tabIndex', -1);

              $button.click(function () {
                $file.focus().click(); // Open dialog
              });

              $file.change(function() {

                var files = [], fileArr, filename;

                // If multiple is supported then extract
                // all filenames from the file array
                if ( multipleSupport ) {
                  fileArr = $file[0].files;
                  for ( var i = 0, len = fileArr.length; i < len; i++ ) {
                    files.push( fileArr[i].name );
                  }
                  filename = files.join(', ');

                // If not supported then just take the value
                // and remove the path to just show the filename
                } else {
                  filename = $file.val().split('\\').pop();
                }

                $input.val( filename ) // Set the value
                  .attr('title', filename) // Show filename in title tootlip
                  .focus(); // Regain focus

              });

              $input.on({
                blur: function() { $file.trigger('blur'); },
                keydown: function( e ) {
                  if ( e.which === 13 ) { // Enter
                    if ( !isIE ) { $file.trigger('click'); }
                  } else if ( e.which === 8 || e.which === 46 ) { // Backspace & Del
                    // On some browsers the value is read-only
                    // with this trick we remove the old input and add
                    // a clean clone with all the original events attached
                    $file.replaceWith( $file = $file.clone( true ) );
                    $file.trigger('change');
                    $input.val('');
                  } else if ( e.which === 9 ){ // TAB
                    return;
                  } else { // All other keys
                    return false;
                  }
                }
              });

            });

          };

          // Old browser fallback
          if ( !multipleSupport ) {
            $( document ).on('change', 'input.customfile', function() {

              var $this = $(this),
                  // Create a unique ID so we
                  // can attach the label to the input
                  uniqId = 'customfile_'+ (new Date()).getTime(),
                  $wrap = $this.parent(),

                  // Filter empty input
                  $inputs = $wrap.siblings().find('.file-upload-input')
                    .filter(function(){ return !this.value }),

                  $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');

              // 1ms timeout so it runs after all other events
              // that modify the value have triggered
              setTimeout(function() {
                // Add a new input
                if ( $this.val() ) {
                  // Check for empty fields to prevent
                  // creating new inputs when changing files
                  if ( !$inputs.length ) {
                    $wrap.after( $file );
                    $file.customFile();
                  }
                // Remove and reorganize inputs
                } else {
                  $inputs.parent().remove();
                  // Move the input so it's always last on the list
                  $wrap.appendTo( $wrap.parent() );
                  $wrap.find('input').focus();
                }
              }, 1);

            });
          }

}(jQuery));

$('input[type=file]').customFile();

</script>

<script type="text/javascript">

$('#files').change(function(){
    var relation_id =  "<?php echo $post_data['id']; ?>";
    var files = $('#files')[0].files;
    var error = '';
    var form_data = new FormData();
    for(var count = 0; count<files.length; count++)
    {
       var name = files[count].name;
       var extension = name.split('.').pop().toLowerCase();
       if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf', 'doc', 'docx']) == -1)
       {
        error += "Invalid " + count + " Image File"
       }
       else
       {
        form_data.append("files[]", files[count]);
       }
    }
    if(error == '')
    { 
       $.ajax({
        url:"<?php echo base_url(); ?>cms/projects/projects_documents/"+relation_id, //base_url() return http://localhost/tutorial/codeigniter/
        method:"POST",
        data:form_data,
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function()
        {
         $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
        },
        success:function(data)
        {
         $('#uploaded_images').html(data);
         $('#files').val('');
        }
       })
    }
    else
    {
       alert(error);
    }
});
function deletedocument(image_id)
    {
    var answer = confirm ("Are you sure you want to delete from this document?");
    if (answer)
    {
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/projects/deletedocument');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
        window.location.reload();
    }
    }
   $('#image_file').on('change', function() { 
            const size =  
               (this.files[0].size / 1024 / 1024).toFixed(2); 
  
            if (size > 8 || size == 8 ) { 
                alert("File size must be less than 8 MB"); 
               
            } else { 
               
            } 
        });  

        $(function () {
        $("#External_user").click(function () {
            if ($(this).is(":checked")) {
                $("#External_user_Box").show();
            } else {
                $("#External_user_Box").hide();
            }
        });
    });


            $(function () {
        $("#Existing_user").click(function () {
            if ($(this).is(":checked")) {
                $("#Existing_user_Box").show();
            } else {
                $("#Existing_user_Box").hide();
            }
        });
    });
    // i=$('.group_wrap').length;
i=1;
$(document).on('click', 'a.add', function (e) {
    e.preventDefault();
    $(".group_wrap:last").after('<tr class="group_wrap"><td class="group_td"><div class="p10"> <input type="text" id="singlegrp'+i+'" name="pname[]" Placeholder="Name"></div></td><td class="institute_td"><div class="p10"><input type="text" id="singleinst'+i+'" name="amount[]" Placeholder="Amount"></div></td><td class="institute_td"><div class="p10"><input type="file" name="logo[]" id="singleimg'+i+'" accept=".png,.jpg,.jpeg,.gif" multiple></div></td><td class="add_remove_td"><div class="p10"><a class="removeMore'+i+'" data-id="'+i+'"><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMore"+i).click(function(){
        var pid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('projects/deletedonor');?>",
                data: "pid="+pid,
                success: function (response) {
                  if (response == 1) {
                   // $(".imagelocation"+pid).remove(".imagelocation"+pid);
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
            url: "<?php echo site_url('projects/deletedonor');?>",
            data: "pid="+pid,
            success: function (response) {
              if (response == 1) {
              //  $(".imagelocation"+pid).remove(".imagelocation"+pid);
              };
            }
        });
    }
    $(this).parent().parent().parent().fadeOut("slow", function() {
        // $(this).parent().parent().parent().remove();
        $(this).remove();
    });
});

$(document).on('click', 'a.addext', function (e) {
    e.preventDefault();
    $(".group_wrapext:last").after('<tr class="group_wrapext"> <td class="Extname_td"><div class="p10"> <input type="text" id="singleExtname'+i+'" name="Extname[]" Placeholder="Name"></div></td><td class="ExtInstname_td"><div class="p10"> <input type="text" id="singleExtInstname'+i+'" name="ExtInstname[]" Placeholder="Institute Name"></div></td><td class="Extdesig_td"><div class="p10"> <input type="text" id="singleExtdesig'+i+'" name="Extdesig[]" Placeholder="Designation"></div></td><td class="Extabout_td"><div class="p10"> <input type="text" id="singleExtaboutemp'+i+'" name="Extabout_emp[]" Placeholder="About Employee"></div></td><td class="Exttype_td"><div class="p10"><select id="singleExttype'+i+'" required class=""  name="external_type[]" data-placeholder="Select Team Type" data-error=".typeerror"><option value="">Select Team Type</option> <option value="Principal Investigator">Principal Investigator</option><option value="Co-Investigator">Co-Investigator</option> </select></div></td><td class="extemail_td"><div class="p10"><input type="text"  name="external_email[]" id="singleExtemail'+i+'"  /></div></td><td class="add_remove_tdext"><div class="p10"><a class="removeMoreext'+i+'" data-id="'+i+'"><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMoreext"+i).click(function(){
        var pid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('projects/deleteExternal');?>",
                data: "pid="+pid,
                success: function (response) {
                  if (response == 1) {
                   // $(".imagelocation"+pid).remove(".imagelocation"+pid);
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

$(".removeMoreext").click(function(){

    var pid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('projects/deleteExternal');?>",
            data: "pid="+pid,
            success: function (response) {
              if (response == 1) {
              //  $(".imagelocation"+pid).remove(".imagelocation"+pid);
              };
            }
        });
    }
    $(this).parent().parent().parent().fadeOut("slow", function() {
        // $(this).parent().parent().parent().remove();
        $(this).remove();
    });
});

$(document).on('click', 'a.addexi', function (e) {
    e.preventDefault();
    $(".group_wrapexi:last").after('<tr class="group_wrapexi"><td class="empid_td"><div class="p10"> <input type="text" id="singleempid'+i+'" onfocusout="checkempdata(this.id,'+i+')" name="empid[]" Placeholder="smomaiya Emp Id"></div></td><td class="exiname_td"><div class="p10"> <input type="text" id="singleexiname'+i+'" name="existing_name[]" Placeholder="Name"></div></td><td class="existingInstitute_td"><div class="p10"><input type="text" name="Institute_name[]" id="singleexiInstitute'+i+'" style="display:none" ><input type="text" name="Institute_namen[]" id="singleexiInstituten'+i+'" ></div></td><td class="exiaboutemp_td"><div class="p10"> <input type="text" id="singleExiaboutemp'+i+'" name="Existing_about[]" Placeholder="About employee"></div></td><td class="exitype_td"><div class="p10"><select id="singleExitype'+i+'" required class=""  name="existing_type[]" data-placeholder="Select Team Type" data-error=".typeerror"><option value="">Select Team Type</option> <option value="Principal Investigator">Principal Investigator</option><option value="Co-Investigator">Co-Investigator</option> </select></div></td><td class="exiemail_td"><div class="p10"> <input type="text" id="singleExiemail'+i+'" name="Existing_email[]"  Placeholder="Email"></div></td><td class="add_remove_tdexi"><div class="p10"><a class="removeMoreexi'+i+'" data-id="'+i+'"><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMoreexi"+i).click(function(){
        var pid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('projects/deleteExisting');?>",
                data: "pid="+pid,
                success: function (response) {
                  if (response == 1) {
                   // $(".imagelocation"+pid).remove(".imagelocation"+pid);
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
$(".removeMoreexi").click(function(){

    var pid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('projects/deleteExisting');?>",
            data: "pid="+pid,
            success: function (response) {
              if (response == 1) {
              //  $(".imagelocation"+pid).remove(".imagelocation"+pid);
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script type="text/javascript">

var checkempdata;

 $(document).ready(function() {
         //   strat here
         
          $('#eiderror').text("");
    checkempdata = function (id,index)
  {    console.log( id);
    var empid =$('#'+id).val();
    console.log( empid);
      console.log( index);
if (empid === '' || empid ===null){
    
        $('#singleexiname'+index).val('');
        $('#singleexiInstitute'+index).val('');
         $('#singleexiInstituten'+index).val('');
        $('#singleExiemail'+index).val('');
  }else{
  $('#eiderror').text("");

  $.ajax({
            type: "POST",
            url: "<?php echo site_url('projects/get_employee_data');?>",
            data: {empid: empid},
           dataType: 'json',
     success: function(response){
       var len = response.length;
     //  $('#suname,#sname,#semail').text('');
       if(len > 0){
        var name =response[0].SALUTATION+" "+response[0].FIRST_NAME+" "+response[0].MIDDLE_NAME+ " "+response[0].LAST_NAME;
         var Institute_name = response[0].INST_ID;
         var email = response[0].CAMPUS_EMAIL_ID;
         var instname=response[0].INST_NAME;
   
         $('#singleexiname'+index).val(name);
         $('#singleexiInstitute'+index).val(Institute_name);
         $('#singleExiemail'+index).val(email);
           $('#singleexiInstituten'+index).val(instname);
        
       }else{


         $('#eiderror').text('Somaiya employee ID not found');
       }
   }

        });
    

  }
  }

    // $('#datetimepicker2').datepicker({
    //   format: "mm-yyyy",
    // viewMode: "months", 
    // minViewMode: "months"
    //     // minDate:new Date()
    // });


    $('.date-own').datepicker({
           minViewMode: 1,
           format: 'yyyy-mm'

         });
    // $('.date-own').datepicker('setDate', new Date());

   



            if ($('#public_checkbox').is(':checked')) {
                $('#public').val(1);
            }else{
                $('#public').val(0);
            }

            $('#public_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#public').val(1);
                }else{
                    $('#public').val(0);
                }
            });

            if ($('#featured_project_checkbox').is(':checked')) {
                $('#featured_project').val(1);
            }else{
                $('#featured_project').val(0);
            }

            $('#featured_project_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#featured_project').val(1);
                }else{
                    $('#featured_project').val(0);
                }
            });
            
        });

        $("#project_form").validate({
            rules: {
                name: {
                    required: true,
                },
                type: {
                    required: true,
                }, 
                area_id: {
                    required: true,
                },
                contact_no: {
                    required: true,
                },project_status: {
                    required: true,
                },date: {
                    required: true,
                },image:{
                    required:true,
                }/*,category_id:{
                    required:true,
                },project_level:{
                    required:true,
                }*/
            },
            messages: {
                name: {
                    required: 'Please enter project name',
                },
                type: {
                    required: 'Please select type',
                },
                area_id: {
                    required: 'Please select area',
                },
                contact_no: {
                    required: 'Please enter contact',
                },project_status: {
                    required:  'Please select  project Status',
                },
                date: {
                    required: 'Please select date',
                },image:{

                    required:'Please upload image',
                } ,/*category_id: {
                    required: 'Please select Category ',
                },
                project_level:{
                    required:'Please select Project Level',
                },*/
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            },
        });
    </script>



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {



        $( ".row_position" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var programme_id_array = new Array();
                $('.row_position>ul li').each(function(){
                    programme_id_array.push($(this).attr("data-id"));
                });
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/save_projectimg_order');?>",
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

