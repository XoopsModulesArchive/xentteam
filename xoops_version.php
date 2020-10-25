<?php
// ------------------------------------------------------------------------- //
//                  Module xentTeam pour Xoops 2.0.7                     //
//                              Version:  1.0                                //
// ------------------------------------------------------------------------- //
// Author: Milhouse                                        				     //
// Purpose:                           				     //
// email: hotkart@hotmail.com                                                //
// URLs:                      												 //
//---------------------------------------------------------------------------//
global $xoopsModuleConfig;
$modversion['name'] = _MI_TEAM_NAME;
$modversion['version'] = '1.0';
$modversion['description'] = _MI_TEAM_DESC;
$modversion['credits'] = 'Alexandre Parent (hotkart@hotmail.com)';
$modversion['author'] = 'Ecrit pour Xoops2<br>par Alexandre Parent (Milhouse)';
$modversion['license'] = '';
$modversion['official'] = 1;
$modversion['image'] = 'images/xent_team_logo.png';
$modversion['help'] = '';
$modversion['dirname'] = 'xentteam';

// MYSQL FILE
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
//If you hack this modules, dont change the order of the table.
//All
$modversion['tables'][0] = 'xent_team_groups';
$modversion['tables'][1] = 'xent_team_expertise_cat';
$modversion['tables'][2] = 'xent_team_expertise_item';
$modversion['tables'][3] = 'xent_team_link_expertise_users';
$modversion['tables'][4] = 'xent_team_display';

$modversion['onInstall'] = 'include/functions.php';
$modversion['templates'][1]['file'] = 'xentteam_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'xentteam_header.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'xentteam_footer.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'xentteam_groups.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'xentteam_expertise.html';
$modversion['templates'][5]['description'] = '';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;
/*$modversion['sub'][1]['name'] = _MI_EV_SMNAME1;
$modversion['sub'][1]['url'] = "emplois.php";
$modversion['sub'][2]['name'] = _MI_EV_SMNAME2;
$modversion['sub'][2]['url'] = "temoignage.php"; */

// Blocks
/*$modversion['blocks'][1]['file'] = "user_rents.php";
$modversion['blocks'][1]['name'] = _MI_CM_BLOCKS_USERRES_TITLE;
$modversion['blocks'][1]['description'] = _MI_CM_BLOCKS_USERRES_DESC;
$modversion['blocks'][1]['show_func'] = "user_rents_show";
$modversion['blocks'][1]['template'] = "xentcdmanager_user_rents.html";*/

//CONFIG
$modversion['config'][1]['name'] = 'mod_title';
$modversion['config'][1]['title'] = '_MI_TEAM_CONFIG_MODTITLE';
$modversion['config'][1]['description'] = '_MI_TEAM_CONFIG_MODTITLEDESC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = '';

$modversion['config'][2]['name'] = 'mod_desc';
$modversion['config'][2]['title'] = '_MI_TEAM_CONFIG_MODDESC';
$modversion['config'][2]['description'] = '_MI_TEAM_CONFIG_MODDESCDESC';
$modversion['config'][2]['formtype'] = 'textarea';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = '';

$modversion['config'][3]['name'] = 'expertise_text';
$modversion['config'][3]['title'] = '_MI_TEAM_CONFIG_EXPERTISETEXT';
$modversion['config'][3]['description'] = '_MI_TEAM_CONFIG_EXPERTISETEXTDESC';
$modversion['config'][3]['formtype'] = 'textarea';
$modversion['config'][3]['valuetype'] = 'text';
$modversion['config'][3]['default'] = '';

$modversion['config'][4]['name'] = 'image_upload_dir';
$modversion['config'][4]['title'] = '_MI_TEAM_CONFIG_IMGUD';
$modversion['config'][4]['description'] = '_MI_TEAM_CONFIG_IMGUDDESC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = '';

$modversion['config'][5]['name'] = 'image_extension';
$modversion['config'][5]['title'] = '_MI_TEAM_CONFIG_IMGEXT';
$modversion['config'][5]['description'] = '_MI_TEAM_CONFIG_IMGEXTDESC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = 'image/gif;image/pjpeg;image/x-png';

$modversion['config'][6]['name'] = 'max_file_size';
$modversion['config'][6]['title'] = '_MI_TEAM_CONFIG_MAXFILESIZE';
$modversion['config'][6]['description'] = '_MI_TEAM_CONFIG_EXPERTISETEXTD';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = '250000';

/*$modversion['config'][2]['name'] = 'mod_desc';
$modversion['config'][2]['title'] = '_MI_PRJ_CONFIG_MODDESC';
$modversion['config'][2]['description'] = '_MI_PRJ_CONFIG_MODDESCDESC';
$modversion['config'][2]['formtype'] = 'textarea';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = '';

$modversion['config'][3]['name'] = 'image_upload_dir';
$modversion['config'][3]['title'] = '_MI_PRJ_CONFIG_IMGUD';
$modversion['config'][3]['description'] = '_MI_PRJ_CONFIG_IMGUDDESC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'text';
$modversion['config'][3]['default'] = '';

$modversion['config'][4]['name'] = 'image_extension';
$modversion['config'][4]['title'] = '_MI_PRJ_CONFIG_IMGEXT';
$modversion['config'][4]['description'] = '_MI_PRJ_CONFIG_IMGEXTDESC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = 'image/gif;image/jpg';

$modversion['config'][5]['name'] = 'max_file_size';
$modversion['config'][5]['title'] = '_MI_PRJ_CONFIG_MAXFILESIZE';
$modversion['config'][5]['description'] = '_MI_PRJ_CONFIG_MAXFILESIZEDESC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = '250000';

$modversion['config'][6]['name'] = 'isImage';
$modversion['config'][6]['title'] = '_MI_PRJ_CONFIG_ISIMAGE';
$modversion['config'][6]['description'] = '_MI_PRJ_CONFIG_ISIMAGEDESC';
$modversion['config'][6]['formtype'] = 'yesno';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = '0';*/

/*$modversion['config'][7]['name'] = 'isImageOpt';
$modversion['config'][7]['title'] = '_MI_PRJ_CONFIG_ISIMAGEOPT';
$modversion['config'][7]['description'] = '_MI_PRJ_CONFIG_ISIMAGEOPTDESC';
$modversion['config'][7]['formtype'] = 'select';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['options'] = array(_MI_PRJ_CONFIG_ISIMAGEOPT1 => '1', _MI_PRJ_CONFIG_ISIMAGEOPT2 => '2');;
$modversion['config'][7]['default'] = '1';

/*$modversion['config'][2]['name'] = 'module_title';
$modversion['config'][2]['title'] = '_MI_CM_CONFIG_TITLE_TITLE';
$modversion['config'][2]['description'] = '_MI_CM_CONFIG_TITLE_DESC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'Système de réservation de CD';

$modversion['config'][3]['name'] = 'cdno';
$modversion['config'][3]['title'] = '_MI_CM_CONFIG_CDNO_TITLE';
$modversion['config'][3]['description'] = '_MI_CM_CONFIG_CDNO_DESC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 100000;

$modversion['config'][4]['name'] = 'version';
$modversion['config'][4]['title'] = '_MI_CM_CONFIG_VERSION_TITLE';
$modversion['config'][4]['description'] = '_MI_CM_CONFIG_VERSION_DESC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'text';
$modversion['config'][4]['default'] = 'xentCdManager v1.0';

$modversion['config'][5]['name'] = 'records_display';
$modversion['config'][5]['title'] = '_MI_CM_CONFIG_RECDISP_TITLE';
$modversion['config'][5]['description'] = '_MI_CM_CONFIG_RECDISP_DESC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = '10';

$modversion['config'][6]['name'] = 'resview_display';
$modversion['config'][6]['title'] = '_MI_CM_CONFIG_RESDISP_TITLE';
$modversion['config'][6]['description'] = '_MI_CM_CONFIG_RESDISP_DESC';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = '3';

$modversion['config'][7]['name'] = 'adminemail';
$modversion['config'][7]['title'] = '_MI_CM_CONFIG_ADMMAIL_TITLE';
$modversion['config'][7]['description'] = '_MI_CM_CONFIG_ADMMAIL_DESC';
$modversion['config'][7]['formtype'] = 'textbox';
$modversion['config'][7]['valuetype'] = 'text';
$modversion['config'][7]['default'] = '';

$modversion['config'][8]['name'] = 'isPrefix';
$modversion['config'][8]['title'] = '_MI_CM_CONFIG_isP_TITLE';
$modversion['config'][8]['description'] = '_MI_CM_CONFIG_isP_DESC';
$modversion['config'][8]['formtype'] = 'yesno';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = '0';*/
