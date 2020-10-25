<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/kernel/groupperm.php';
require_once XOOPS_ROOT_PATH . '/modules/xentteam/class/xent_team_groups.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/class/xent_users.php';
require_once XOOPS_ROOT_PATH . '/modules/xentteam/class/xent_team_expertise.php';

$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables, $xoopsUser;

$GLOBALS['xoopsOption']['template_main'] = 'xentteam_expertise.html';

$permObject = new XoopsGroupPermHandler(XoopsDatabaseFactory::getDatabaseConnection());
$xentTeamGroups = new XentTeamGroups();
$xentUsers = new XentUsers();
$xentTeamExpertise = new XentTeamExpertise();

$resultcat = $xentTeamExpertise->getAllCat();

$display = 0;

while (false !== ($expcat = $xoopsDB->fetchArray($resultcat))) {
    if (true === $xentTeamExpertise->displayCat($expcat['ID_EXPERTISECAT'])) {
        $expcat['display'] = $display;

        $expcat['name'] = $myts->displayTarea($expcat['name']);

        if (0 == $display) {
            $display++;
        } else {
            $display--;
        }

        $itemarr = $xentTeamExpertise->getItemsForCatInArray($expcat['ID_EXPERTISECAT']);

        $expcat['item'] = $itemarr;

        $xoopsTpl->append('expcat', $expcat);
    }
}

$xoopsTpl->assign('arr', [1, 2, 3]);

$xoopsTpl->assign('expertiseTitle', _MA_TEAM_EXPERTISE);
$xoopsTpl->assign('expertiseText', $myts->displayTarea($xoopsModuleConfig['expertise_text']));

include 'footer.php';
