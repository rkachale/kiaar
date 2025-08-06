<div class="portlet light ">
    <div class="portlet-title tabbable-line">
        <div class="caption caption-md">
            <span class="caption-subject font-brown bold uppercase">Permissions</span>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <tbody>
                <tr>
                    <td>Select All</td>
                    <td>
                        <input id="all_permission" name="all_permission" data-id="all_permission" data-selid="all_permission" class="all_permission_select_all method-checkbox" type="checkbox" <?php if(in_array('all_permission', $select_all_data)){ echo 'checked="checked"'; } ?>>
                        <input id="select-all-all_permission" name="selectall[]" value="<?php if(in_array('all_permission', $select_all_data)){ echo 'all_permission'; }else{ echo ''; } ?>" type="hidden">
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="permissions">
            <thead>
                <th>Module</th>
                <th>Select All</th>
                <th>Sub Module</th>
                <th>Select All</th>
                <th>Add</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>View</th>
                <th>Export</th>
            </thead>
            <tbody>
                <?php
                    if(isset($methods) && !empty($methods))
                    {
                        $mi = 0;
                        $si = 0;
                        $module_class       = '';
                        $sub_module_class   = '';
                        $pm_order_arr       = [];

                        foreach ($methods as $key => $value) {
                            $module_class = 'menuclass-'.$mi;
                            if(isset($value['sub_module']) && !empty($value['sub_module']))
                            {
                                foreach ($value['sub_module'] as $smkey => $sub_module) {
                                    $sub_module_class = 'submenuclass-'.$mi.$si;
                                    $rowspan = ($smkey < 1) ? count($value['sub_module']) : '';
                ?>
                                    <tr class="gradeX">
                                        <?php if($rowspan){ ?>
                                            <td rowspan="<?php echo $rowspan; ?>">
                                                <?php
                                                    if($smkey < 1)
                                                    {
                                                        echo $value['module_name'];
                                                    }
                                                ?>
                                            </td>
                                            <td rowspan="<?php echo $rowspan; ?>">
                                                <input type="checkbox" name="module_select_all[]" data-selid="module-<?php echo $value['module_id']; ?>" data-id="<?php echo $value['module_id']; ?>" class="all_permission_select_all select-all <?php echo $module_class; ?>" onchange="selectall('module', '<?php echo $module_class; ?>', '<?php echo $sub_module_class; ?>', this);" <?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                                <input type="hidden" id="select-all-module-<?php echo $value['module_id']; ?>" name="selectall[]" value="<?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'module-'.$value['module_id']; }else{ echo ''; } ?>">
                                            </td>
                                        <?php } ?>
                                        <td><?php echo $sub_module['module_name']; ?></td>
                                        <td>
                                            <input type="checkbox" name="" data-selid="submodule-<?php echo $value['module_id'].$sub_module['module_id']; ?>" data-id="<?php echo $value['module_id'].$sub_module['module_id']; ?>" class="all_permission_select_all select-all <?php echo $module_class.' '.$sub_module_class; ?>" onchange="selectall('submodule', '<?php echo $module_class; ?>', '<?php echo $sub_module_class; ?>', this);" <?php if(in_array('submodule-'.$value['module_id'].$sub_module['module_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                            <input type="hidden" id="select-all-submodule-<?php echo $value['module_id'].$sub_module['module_id']; ?>" name="selectall[]" value="<?php if(in_array('submodule-'.$value['module_id'].$sub_module['module_id'], $select_all_data)){ echo 'submodule-'.$value['module_id'].$sub_module['module_id']; }else{ echo ''; } ?>">
                                        </td>
                                        <?php
                                            if(isset($sub_module['methods']) && !empty($sub_module['methods']))
                                            {
                                                $pm_order_arr   = array_column($sub_module['methods'], 'pm_order');
                                                $i              = 0;
                                                foreach ($this->config->item('method_for') as $mfkey => $mfvalue) {
                                                    if(in_array($mfkey, $pm_order_arr)){
                                                        $okey = array_search($mfkey, array_column($sub_module['methods'], 'pm_order'));
                                        ?>
                                                        <td>
                                                            <?php if(isset($sub_module['methods'][$okey]) && !empty($sub_module['methods'][$okey])){ ?>
                                                                <input type="checkbox" id="checkbox-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" name="<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" data-id="sub-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" class="all_permission method-checkbox <?php echo $module_class.' '.$sub_module_class; ?>" <?php if(in_array($sub_module['methods'][$okey]['pm_id'], $permissions)){ echo 'checked="checked"'; } ?>>
                                                                <input type="hidden" id="method-sub-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" name="method-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" value="<?php if(in_array($sub_module['methods'][$okey]['pm_id'], $permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                            <?php } ?>
                                                        </td>
                                        <?php
                                                    }
                                                    else
                                                    {
                                        ?>
                                                        <td>--</td>
                                        <?php
                                                    }
                                                    ++$i;
                                                }
                                            }
                                            else
                                            {
                                                echo '
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    ';
                                            }
                                        ?>
                                    </tr>
                <?php
                                    ++$si;
                                }
                            }
                            else
                            {
                ?>
                                <tr class="gradeX">
                                    <td><?php echo $value['module_name']; ?></td>
                                    <td>
                                        <input type="checkbox" name="module_select_all[]" data-selid="module-<?php echo $value['module_id']; ?>" data-id="<?php echo $value['module_id']; ?>" class="all_permission_select_all select-all <?php echo $module_class; ?>" onchange="selectall('module', '<?php echo $module_class; ?>', '', this);" <?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                        <input type="hidden" id="select-all-module-<?php echo $value['module_id']; ?>" name="selectall[]" value="<?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'module-'.$value['module_id']; }else{ echo ''; } ?>">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <?php
                                        if(isset($value['methods']) && !empty($value['methods']))
                                        {
                                            $pm_order_arr   = array_column($value['methods'], 'pm_order');
                                            $j              = 0;
                                            foreach ($this->config->item('method_for') as $mfkey => $mfvalue) {
                                                if(in_array($mfkey, $pm_order_arr)){
                                                    $okey = array_search($mfkey, array_column($value['methods'], 'pm_order'));
                                    ?>
                                                    <td>
                                                        <?php if(isset($value['methods'][$okey]) && !empty($value['methods'][$okey])){ ?>
                                                            <input type="checkbox" id="checkbox-<?php echo $value['methods'][$okey]['pm_id']; ?>" name="<?php echo $value['methods'][$okey]['pm_id']; ?>" data-id="meth-<?php echo $value['methods'][$okey]['pm_id']; ?>" class="all_permission method-checkbox <?php echo $module_class.' '.$sub_module_class; ?>" <?php if(in_array($value['methods'][$okey]['pm_id'], $permissions)){ echo 'checked="checked"'; } ?>>
                                                            <input type="hidden" id="method-meth-<?php echo $value['methods'][$okey]['pm_id']; ?>" name="method-<?php echo $value['methods'][$okey]['pm_id']; ?>" value="<?php if(in_array($value['methods'][$okey]['pm_id'], $permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                        <?php } ?>
                                                    </td>
                                    <?php
                                                }
                                                else
                                                {
                                    ?>
                                                    <td>--</td>
                                    <?php
                                                }
                                                ++$j;
                                            }
                                        }
                                        else
                                        {
                                            echo '
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                ';
                                        }
                                    ?>
                                </tr>
                <?php
                            }
                            ++$mi;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.method-checkbox').click(function() {
            var pm_id = $(this).data('id');
            if($(this).is(':checked')){
                $('#method-'+pm_id).val(1);
            }else{
                $('#method-'+pm_id).val(0);
            }
        });

        $('#all_permission').click(function() {
            var selid = $(this).data('selid');
            if($(this).is(':checked')){
                todo = 'check';
                $('#select-all-'+selid).val(selid);
            }else{
                todo = 'uncheck';
                $('#select-all-'+selid).val('');
            }

            $('.all_permission').each(function(index, obj) {
                var page_id = $(this).data('id');
                var data_type = $(this).data('type');
                
                if(todo == 'check')
                {
                    $(this).prop('checked', true);
                    $('#method-'+page_id).val(1);
                }
                else
                {
                    $(this).prop('checked', false);
                    $('#method-'+page_id).val(0);
                }
            });

            $('.all_permission_select_all').each(function(index, obj) {
                var selid = $(this).data('selid');
                var data_type = $(this).data('type');

                if(todo == 'check')
                {
                    $(this).prop('checked', true);
                    $('#select-all-'+selid).val(selid);
                }
                else
                {
                    $(this).prop('checked', false);
                    $('#select-all-'+selid).val('');
                }
            });
        });
    });

    /*function permissions(pm_id) {
        if($('checkbox-'+pm_id).is(':checked')){
            alert('checked');
            $('#method-'+pm_id).val(1);
        }else{
            alert('unchecked');
            $('#method-'+pm_id).val(0);
        }
    }*/

    function selectall(type, moduleclass, submoduleclass, chk) {
        var todo = '';
        var selclass = '';
        var avoid1 = '';
        var avoid2 = '';
        var selid = $(this).data('selid');

        if(chk.checked == true)
        {
            todo = 'check';
            $('#select-all-'+selid).val(selid);
        }
        else
        {
            todo = 'uncheck';
            $('#select-all-'+selid).val('');
        }

        if(type == 'module')
        {
            selclass = moduleclass;
        }
        else if(type == 'submodule')
        {
            selclass = submoduleclass;
        }

        $('.'+selclass).each(function(index, obj) {
            var page_id = $(this).data('id');
            // alert('#method-'+page_id);

            if(todo == 'check')
            {
                $(this).prop('checked', true);
                $('#method-'+page_id).val(1);
            }
            else
            {
                $(this).prop('checked', false);
                $('#method-'+page_id).val(0);
            }
        });

        $('.select-all').each(function(index, obj) {
            if($(this).is(':checked'))
            {
                $('#select-all-'+$(this).data('selid')).val($(this).data('selid'));
            }
            else
            {
                $('#select-all-'+$(this).data('selid')).val('');
            }
        });
    }
</script>