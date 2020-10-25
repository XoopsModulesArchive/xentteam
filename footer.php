<?php

$result = $xentTeamGroups->getDisplayedGroups();

while (false !== ($displayed_groups = $xoopsDB->fetchArray($result))) {
    $displayed_groups['name'] = $myts->displayTarea(reference('groups', 'name', 'groupid', $displayed_groups['ID_GROUP']));

    $xoopsTpl->append('displayed_groups', $displayed_groups);
}

$xoopsTpl->assign('menuExpertise', _MA_TEAM_EXPERTISE);
$xoopsTpl->assign('xoops_module_header', '<link rel="stylesheet" type="text/css" media="all" href="include/xentteam.css">');

require XOOPS_ROOT_PATH . '/footer.php';
