<?php
/**
 * Created by Kiaar.
 * User: Kiaar
 * Date: 9/15/2016
 * Time: 8:35 PM
 * Project: Somaiya Vidyavihar
 * Website: http://www.Kiaar.com
 */


$config['Kiaar_general_templateFolderName'] 		= 'kiaar_general';
$config['Kiaar_general_admin_templateFolderName'] 	= 'kiaar_general_admin';


$config['max_upload_size'] = 20000; // KG

/* Here you can declare backend models */

$config['backend_models'] = array('Kiaar_general_admin_model','Usermodule_model','Permethod_model','Permissions_model');

$config['backend_helpers'] = array('admin_page_type','kiaar_form');

/* Here you can declare frontend models */

$config['frontend_models'] = array('Kiaar_general_model');

$config['frontend_helpers'] = array();

$config['method_for_add'] 		= 1;
$config['method_for_edit'] 		= 2;
$config['method_for_delete'] 	= 3;
$config['method_for_view'] 		= 4;
$config['method_for_export'] 	= 5;
$config['method_for'] 			= 	[
                                        $config['method_for_add'] 		=> 'Add',
                                        $config['method_for_edit'] 		=> 'Edit',
                                        $config['method_for_delete'] 	=> 'Delete',
                                        $config['method_for_view'] 		=> 'View',
                                        $config['method_for_export'] 	=> 'Export'
                                    ];