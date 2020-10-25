<?php

include 'header.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/kernel/groupperm.php';
require_once XOOPS_ROOT_PATH . '/modules/xentteam/class/xent_team_groups.php';
require_once XOOPS_ROOT_PATH . '/modules/xentgen/class/xent_users.php';
require_once XOOPS_ROOT_PATH . '/modules/xentteam/class/xent_team_display.php';

$myts = MyTextSanitizer::getInstance();
$eh = new ErrorHandler();

global $xoopsDB, $xoopsTpl, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables, $xoopsUser;

$GLOBALS['xoopsOption']['template_main'] = 'xentteam_groups.html';

$permObject = new XoopsGroupPermHandler(XoopsDatabaseFactory::getDatabaseConnection());
$xentTeamGroups = new XentTeamGroups();
$xentUsers = new XentUsers();
$xentTeamDisplay = new XentTeamDisplay();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = $xentTeamGroups->getSmallestDisplayedGroupID();
}

if (false === $xentTeamGroups->idExists($id)) {
    $id = $xentTeamGroups->getSmallestDisplayedGroupID();
} else {
    $xentTeamGroups->setIdGroup($id);
}

$result = $xentTeamGroups->getDisplayedUsers();

while (false !== ($users = $xoopsDB->fetchArray($result))) {
    $theUser = $xentUsers->getUser($users['id_user']);

    if ($xentTeamGroups->isUserInGroup($users['id_user'])) {
        $theUser['name'] = $xentUsers->transformName($myts->displayTarea(reference('users', 'name', 'uid', $users['id_user'])));

        $theUser['job'] = $myts->displayTarea(reference(XENT_DB_XENT_GEN_JOBS, 'job', 'ID_JOB', $theUser['id_job']));

        $theUser['title'] = $xentUsers->getTitleName($theUser['id_title']);

        $theUser['career_summary'] = $myts->displayTarea($theUser['career_summary']);

        $theUser['pictprowhereto'] = $xentTeamDisplay->getPictProWhereToForUser($theUser['ID_USER']);

        $xoopsTpl->append('users', $theUser);
    }
}

$xoopsTpl->assign('groupTitle', reference('groups', 'name', 'groupid', $id));
$xoopsTpl->assign('upload_dir', XOOPS_URL . $xoopsModuleConfig['image_upload_dir'] . '/');

include 'footer.php';
