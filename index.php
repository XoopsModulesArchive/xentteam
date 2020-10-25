<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/kernel/groupperm.php';
require_once XOOPS_ROOT_PATH . '/modules/xentteam/class/xent_team_groups.php';

$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables, $xoopsUser;

$GLOBALS['xoopsOption']['template_main'] = 'xentteam_index.html';

$permObject = new XoopsGroupPermHandler(XoopsDatabaseFactory::getDatabaseConnection());
$xentTeamGroups = new XentTeamGroups();

$xoopsTpl->assign('modTitre', $myts->displayTarea($xoopsModuleConfig['mod_title']));
$xoopsTpl->assign('modDesc', $myts->displayTarea($xoopsModuleConfig['mod_desc']));

include 'footer.php';
