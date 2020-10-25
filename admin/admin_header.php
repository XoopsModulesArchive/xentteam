<?php

//echo "<link rel='stylesheet' type='text/css' media='all' href='include/admin.css'>";

require __DIR__ . '/admin_buttons.php';
include '../../../mainfile.php';
require dirname(__DIR__, 3) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsmodule.php';
require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once dirname(__DIR__) . '/include/functions.php';
require_once dirname(__DIR__, 2) . '/xentgen/class/xent_users.php';
require_once dirname(__DIR__) . '/class/xent_team_groups.php';
require_once dirname(__DIR__) . '/class/xent_team_expertise.php';
require_once dirname(__DIR__) . '/class/xent_team_display.php';

global $xoopsModule;

$versioninfo = $moduleHandler->get($xoopsModule->getVar('mid'));
$module_tables = $versioninfo->getInfo('tables');

if (is_object($xoopsUser)) {
    $xoopsModule = XoopsModule::getByDirname('xentteam');

    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 1, _NOPERM);

        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/', 1, _NOPERM);

    exit();
}

$module_id = $xoopsModule->getVar('mid');
$oAdminButton = new AdminButtons();
$oAdminButton->AddTitle(_AM_TEAM_ADMINMENUTITLE);

$oAdminButton->AddButton(_AM_TEAM_INDEX, 'index.php', 'index');
$oAdminButton->AddButton(_AM_TEAM_ADMINTEAM, 'adminteam.php', 'adminteam');
$oAdminButton->AddButton(_AM_TEAM_ADMINGROUPS, 'admingroups.php', 'admingroups');
$oAdminButton->AddButton(_AM_TEAM_ADMINEXP, 'adminexpertise.php', 'adminexpertise');

$oAdminButton->AddTopLink(_AM_TEAM_PREFERENCES, XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $module_id);
$oAdminButton->addTopLink(_AM_TEAM_UPDATEMODULE, XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=xentteam');

$myts = MyTextSanitizer::getInstance();
