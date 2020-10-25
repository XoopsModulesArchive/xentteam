<?php

include '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/modules/xentteam/class/xent_team_groups.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

global $xoopsConfig, $xoopsDB, $module_tables;
$lang = $xoopsConfig['language'];

$xentTeamGroups = new XentTeamGroups();
$versioninfo = $moduleHandler->get($xoopsModule->getVar('mid'));
$module_tables = $versioninfo->getInfo('tables');
