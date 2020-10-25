<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xentfunctions.php';

function makeImageWhereToDisplayArray()
{
    $arr = [];

    $arr[0] = _AM_TEAM_IMAGEWHERETODISPLAYEDOPT0;

    $arr[1] = _AM_TEAM_IMAGEWHERETODISPLAYEDOPT1;

    $arr[2] = _AM_TEAM_IMAGEWHERETODISPLAYEDOPT2;

    return $arr;
}

function buildTeamActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=adminteam.php class='adminActionMenu'>" . _AM_TEAM_ADMINTEAMTITLE . '</a></div>';
}

function buildGroupsActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=admingroups.php class='adminActionMenu'>" . _AM_TEAM_ADMINGROUPSTITLE . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo "<a href=admingroups.php?op=GROUPSImport class='adminActionMenu'>" . _AM_TEAM_IMPORT . '</a></div>';
}

function buildExpActionMenu()
{
    echo "<br><div class='adminActionMenu'><a href=adminexpertise.php?op=EXPShowCat class='adminActionMenu'>" . _AM_TEAM_ADMINEXPCATTITLE . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo "<a href=adminexpertise.php?op=EXPShowItems class='adminActionMenu'>" . _AM_TEAM_ADMINEXPITEMSTITLE . '</a></div>';
}
