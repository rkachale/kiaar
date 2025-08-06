<div class="portlet light ">
    <div class="portlet-title tabbable-line">
        <div class="caption caption-md">
            <span class="caption-subject font-brown bold uppercase">Page Permissions</span>
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
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <tbody>
                <tr>
                    <td>Add Page</td>
                    <td>
                        <input id="add_page" name="add_page" data-id="addpage-id" class="all_permission method-checkbox" type="checkbox" <?php if($add_permissions == 1){ echo 'checked="checked"'; } ?>>
                        <input id="method-addpage-id" name="add_page_method" value="<?php echo $add_permissions; ?>" type="hidden">
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <thead>
                <th>Menu</th>
                <th>Select All</th>
                <th>Sub Menu</th>
                <th>Select All</th>
                <th>Child Menu</th>
                <th>Select All</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>View</th>
            </thead>
            <tbody>
                <?php
                    if(isset($menu_data['main_menu_data']) && !empty($menu_data['main_menu_data']))
                    {
                        $menu_class         = '';
                        $sub_menu_class     = '';
                        $child_menu_class   = '';

                        $mi = 0;
                        $si = 0;
                        $ci = 0;
                        foreach ($menu_data['main_menu_data'] as $mkey => $menu) {
                            $menu_class = 'menuclass-'.$mi;
                            $rowspan = ($menu['rowspan'] > 0) ? $menu['rowspan'] : '';
                            if(isset($menu['sub_menu_data']) && !empty($menu['sub_menu_data'])) // When there is sub menu
                            {
                                $sub_menu_data = $menu['sub_menu_data'];
                                foreach ($sub_menu_data as $smkey => $submenu) {
                                    $sub_menu_class = 'submenuclass-'.$mi.$si;
                                    if(isset($submenu['child_menu_data']) && !empty($submenu['child_menu_data'])) // When there is child menu
                                    {
                                        $child_menu_data = $submenu['child_menu_data'];
                                        $smrowspan = (count($child_menu_data) > 0) ? count($child_menu_data) : '';
                                        foreach ($child_menu_data as $cmkey => $childmenu) {
                                            $child_menu_class = 'childmenuclass-'.$mi.$si.$ci;
                                            // echo "<pre>";print_r($childmenu);//exit;
                ?>
                                            <tr class="gradeX">
                                                <?php if($smkey < 1 && $cmkey < 1){ ?>
                                                    <td rowspan="<?php echo $rowspan; ?>">
                                                        <?php echo $menu['menu_name']; ?>
                                                    </td>
                                                    <td rowspan="<?php echo $rowspan; ?>">
                                                        <input name="menu_select_all[]" data-selid="menu-<?php echo $menu['page_id']; ?>" data-id="<?php echo $menu['page_id']; ?>" data-type="menu_select_all" value="<?php echo $menu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class; ?>" onchange="selectall('menu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '<?php echo $child_menu_class; ?>', this);" <?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                                        <input type="hidden" id="select-all-menu-<?php echo $menu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'menu-'.$menu['page_id']; }else{ echo ''; } ?>">
                                                    </td>
                                                <?php }if($cmkey < 1){ ?>
                                                    <td rowspan="<?php echo $smrowspan; ?>"><?php echo $submenu['menu_name']; ?></td>
                                                    <td rowspan="<?php echo $smrowspan; ?>">
                                                        <input name="submenu_select_all[]" data-selid="submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" data-id="<?php echo $submenu['page_id']; ?>" data-type="submenu_select_all" value="<?php echo $submenu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class.' '.$sub_menu_class; ?>" onchange="selectall('submenu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '<?php echo $child_menu_class; ?>', this);" <?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                                        <input type="hidden" id="select-all-submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'submenu-'.$menu['page_id'].$submenu['page_id']; }else{ echo ''; } ?>">
                                                    </td>
                                                <?php } ?>
                                                <td><?php echo $childmenu['menu_name']; ?></td>
                                                <td>
                                                    <?php if($childmenu['page_id'] > 0){ ?>
                                                        <input name="child_select_all[]" data-selid="childmenu-<?php echo $menu['page_id'].$submenu['page_id'].$childmenu['page_id']; ?>" data-id="<?php echo $childmenu['page_id']; ?>" data-type="child_select_all" value="<?php echo $childmenu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" onchange="selectall('childmenu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '<?php echo $child_menu_class; ?>', this);" <?php if(in_array('childmenu-'.$menu['page_id'].$submenu['page_id'].$childmenu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                                        <input type="hidden" id="select-all-childmenu-<?php echo $menu['page_id'].$submenu['page_id'].$childmenu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('childmenu-'.$menu['page_id'].$submenu['page_id'].$childmenu['page_id'], $select_all_data)){ echo 'childmenu-'.$menu['page_id'].$submenu['page_id'].$childmenu['page_id']; }else{ echo ''; } ?>">
                                                    <?php } ?>
                                                </td>
                                                <?php
                                                    if($childmenu['page_id'] > 0)
                                                    {
                                                ?>
                                                        <input type="hidden" name="page_id[]" value="<?php echo $childmenu['page_id']; ?>">
                                                        <td>
                                                            <input type="checkbox" id="checkbox-edit-<?php echo $childmenu['page_id']; ?>" name="edit-<?php echo $childmenu['page_id']; ?>" data-id="edit-child-<?php echo $childmenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" <?php if(in_array($childmenu['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                                                            <input type="hidden" id="method-edit-child-<?php echo $childmenu['page_id']; ?>" name="editval-<?php echo $childmenu['page_id']; ?>" value="<?php if(in_array($childmenu['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" id="checkbox-delete-<?php echo $childmenu['page_id']; ?>" name="delete-<?php echo $childmenu['page_id']; ?>" data-id="delete-child-<?php echo $childmenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" <?php if(in_array($childmenu['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                                                            <input type="hidden" id="method-delete-child-<?php echo $childmenu['page_id']; ?>" name="deleteval-<?php echo $childmenu['page_id']; ?>" value="<?php if(in_array($childmenu['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" id="checkbox-view-<?php echo $childmenu['page_id']; ?>" name="view-<?php echo $childmenu['page_id']; ?>" data-id="view-child-<?php echo $childmenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" <?php if(in_array($childmenu['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                                                            <input type="hidden" id="method-view-child-<?php echo $childmenu['page_id']; ?>" name="viewval-<?php echo $childmenu['page_id']; ?>" value="<?php if(in_array($childmenu['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                        </td>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                        echo '
                                                            <td>--</td>
                                                            <td>--</td>
                                                            <td>--</td>
                                                        ';
                                                    }
                                            ++$ci;
                                        }
                                    }
                                    else
                                    {
                ?>
                                        <tr class="gradeX">
                                            <?php if($smkey < 1){ ?>
                                                <td rowspan="<?php echo $rowspan; ?>">
                                                    <?php echo $menu['menu_name']; ?>
                                                </td>
                                                <td rowspan="<?php echo $rowspan; ?>">
                                                    <input name="menu_select_all[]" data-selid="menu-<?php echo $menu['page_id']; ?>" data-id="<?php echo $menu['page_id']; ?>" data-type="menu_select_all" value="<?php echo $menu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class; ?>" onchange="selectall('menu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '', this);" <?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                                    <input type="hidden" id="select-all-menu-<?php echo $menu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'menu-'.$menu['page_id']; }else{ echo ''; } ?>">
                                                </td>
                                            <?php } ?>
                                            <td><?php echo $submenu['menu_name']; ?></td>
                                            <td>
                                                <?php if($submenu['page_id'] > 0){ ?>
                                                    <input name="submenu_select_all[]" data-selid="submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" data-id="<?php echo $submenu['page_id']; ?>" data-type="submenu_select_all" value="<?php echo $submenu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class.' '.$sub_menu_class; ?>" onchange="selectall('submenu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '', this);" <?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                                    <input type="hidden" id="select-all-submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'submenu-'.$menu['page_id'].$submenu['page_id']; }else{ echo ''; } ?>">
                                                <?php } ?>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                                if($submenu['page_id'] > 0)
                                                {
                                            ?>
                                                    <input type="hidden" name="page_id[]" value="<?php echo $submenu['page_id']; ?>">
                                                    <td>
                                                        <input type="checkbox" id="checkbox-edit-<?php echo $submenu['page_id']; ?>" name="edit-<?php echo $submenu['page_id']; ?>" data-id="edit-submenu-<?php echo $submenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class; ?>" <?php if(in_array($submenu['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                                                        <input type="hidden" id="method-edit-submenu-<?php echo $submenu['page_id']; ?>" name="editval-<?php echo $submenu['page_id']; ?>" value="<?php if(in_array($submenu['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id="checkbox-delete-<?php echo $submenu['page_id']; ?>" name="delete-<?php echo $submenu['page_id']; ?>" data-id="delete-submenu-<?php echo $submenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class; ?>" <?php if(in_array($submenu['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                                                        <input type="hidden" id="method-delete-submenu-<?php echo $submenu['page_id']; ?>" name="deleteval-<?php echo $submenu['page_id']; ?>" value="<?php if(in_array($submenu['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" id="checkbox-view-<?php echo $submenu['page_id']; ?>" name="view-<?php echo $submenu['page_id']; ?>" data-id="view-submenu-<?php echo $submenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class; ?>" <?php if(in_array($submenu['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                                                        <input type="hidden" id="method-view-submenu-<?php echo $submenu['page_id']; ?>" name="viewval-<?php echo $submenu['page_id']; ?>" value="<?php if(in_array($submenu['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                                    </td>
                                            <?php
                                                }
                                                else
                                                {
                                                    echo '
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    ';
                                                }
                                    }
                                    ++$si;
                                }
                ?>
                            </tr>
                <?php
                            }
                            else // When there is no sub menu
                            {
                ?>
                                <tr class="gradeX">
                                    <td><?php echo $menu['menu_name']; ?></td>
                                    <td>
                                        <?php if($menu['page_id'] > 0){ ?>
                                            <input name="menu_select_all[]" data-selid="menu-<?php echo $menu['page_id']; ?>" data-id="<?php echo $menu['page_id']; ?>" data-type="menu_select_all" value="<?php echo $menu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class; ?>" onchange="selectall('menu', '<?php echo $menu_class; ?>', '', '', this);" <?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                            <input type="hidden" id="select-all-menu-<?php echo $menu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'menu-'.$menu['page_id']; }else{ echo ''; } ?>">
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php
                                        if($menu['page_id'] > 0)
                                        {
                                    ?>
                                            <input type="hidden" name="page_id[]" value="<?php echo $menu['page_id']; ?>">
                                            <td>
                                                <input type="checkbox" id="checkbox-edit-<?php echo $menu['page_id']; ?>" name="edit-<?php echo $menu['page_id']; ?>" data-id="edit-menu-<?php echo $menu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class; ?>" <?php if(in_array($menu['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                                                <input type="hidden" id="method-edit-menu-<?php echo $menu['page_id']; ?>" name="editval-<?php echo $menu['page_id']; ?>" value="<?php if(in_array($menu['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                            </td>
                                            <td>
                                                <input type="checkbox" id="checkbox-delete-<?php echo $menu['page_id']; ?>" name="delete-<?php echo $menu['page_id']; ?>" data-id="delete-menu-<?php echo $menu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class; ?>" <?php if(in_array($menu['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                                                <input type="hidden" id="method-delete-menu-<?php echo $menu['page_id']; ?>" name="deleteval-<?php echo $menu['page_id']; ?>" value="<?php if(in_array($menu['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                            </td>
                                            <td>
                                                <input type="checkbox" id="checkbox-view-<?php echo $menu['page_id']; ?>" name="view-<?php echo $menu['page_id']; ?>" data-id="view-menu-<?php echo $menu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class; ?>" <?php if(in_array($menu['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                                                <input type="hidden" id="method-view-menu-<?php echo $menu['page_id']; ?>" name="viewval-<?php echo $menu['page_id']; ?>" value="<?php if(in_array($menu['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                            </td>
                                    <?php
                                        }
                                        else
                                        {
                                            echo '
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
                    else
                    {
                ?>
                        <tr class="gradeX">
                            <td colspan="6" class="text-center">No Data Found</td>
                        </tr>
                <?php
                    }
                    if(isset($otherpage) && !empty($otherpage))
                    {
                        foreach ($otherpage as $okey => $ovalue) {
                            $page_class = 'page_'.$okey.$ovalue['page_id'];
                ?>
                            <tr class="gradeX">
                                <td><?php echo $ovalue['page_name']; ?></td>
                                <td>
                                    <?php if($ovalue['page_id'] > 0){ ?>
                                        <input name="menu_select_all[]" data-selid="method-<?php echo $ovalue['page_id']; ?>" data-id="<?php echo $ovalue['page_id']; ?>" data-type="menu_select_all" value="<?php echo $ovalue['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $page_class; ?>" onchange="selectall('menu', '<?php echo $page_class; ?>', '', '', this);" <?php if(in_array('method-'.$ovalue['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                                        <input type="hidden" id="select-all-method-<?php echo $ovalue['page_id']; ?>" name="selectall[]" value="<?php if(in_array('method-'.$ovalue['page_id'], $select_all_data)){ echo 'method-'.$ovalue['page_id']; }else{ echo ''; } ?>">
                                    <?php } ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php
                                    if($ovalue['page_id'] > 0)
                                    {
                                ?>
                                        <input type="hidden" name="page_id[]" value="<?php echo $ovalue['page_id']; ?>">
                                        <td>
                                            <input type="checkbox" id="checkbox-edit-<?php echo $ovalue['page_id']; ?>" name="edit-<?php echo $ovalue['page_id']; ?>" data-id="edit-page-<?php echo $ovalue['page_id']; ?>" class="all_permission method-checkbox <?php echo $page_class; ?>" <?php if(in_array($ovalue['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                                            <input type="hidden" id="method-edit-page-<?php echo $ovalue['page_id']; ?>" name="editval-<?php echo $ovalue['page_id']; ?>" value="<?php if(in_array($ovalue['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="checkbox-delete-<?php echo $ovalue['page_id']; ?>" name="delete-<?php echo $ovalue['page_id']; ?>" data-id="delete-page-<?php echo $ovalue['page_id']; ?>" class="all_permission method-checkbox <?php echo $page_class; ?>" <?php if(in_array($ovalue['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                                            <input type="hidden" id="method-delete-page-<?php echo $ovalue['page_id']; ?>" name="deleteval-<?php echo $ovalue['page_id']; ?>" value="<?php if(in_array($ovalue['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="checkbox-view-<?php echo $ovalue['page_id']; ?>" name="view-<?php echo $ovalue['page_id']; ?>" data-id="view-page-<?php echo $ovalue['page_id']; ?>" class="all_permission method-checkbox <?php echo $page_class; ?>" <?php if(in_array($ovalue['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                                            <input type="hidden" id="method-view-page-<?php echo $ovalue['page_id']; ?>" name="viewval-<?php echo $ovalue['page_id']; ?>" value="<?php if(in_array($ovalue['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                        </td>
                                <?php
                                    }
                                    else
                                    {
                                        echo '
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                            ';
                                    }
                                ?>
                            </tr>
                <?php
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
            var page_id = $(this).data('id');
            if($(this).is(':checked')){
                $('#method-'+page_id).val(1);
            }else{
                $('#method-'+page_id).val(0);
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

    function selectall(type, menuclass, submenuclass, childmenuclass, chk) {
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

        if(type == 'menu')
        {
            selclass = menuclass;
        }
        else if(type == 'submenu')
        {
            selclass = submenuclass;
            // avoid1 = 'menu_select_all';
        }
        else if(type == 'childmenu')
        {
            selclass = childmenuclass;
            // avoid1 = 'menu_select_all';
            // avoid2 = 'submenu_select_all';
        }
        
        $('.'+selclass).each(function(index, obj) {
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