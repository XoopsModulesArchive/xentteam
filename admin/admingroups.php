<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('admingroups');

OpenTable();
echo "<div class='adminHeader'>" . _AM_TEAM_ADMINGROUPSTITLE . '</div><br>';

function GROUPSShowGroups()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamGroups = new XentTeamGroups();

    $result = $xentTeamGroups->getAllGroups();

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
                    <th>" . _AM_TEAM_NAME . '</th>
                    <th>' . _AM_TEAM_DISPLAYGROUP . '</th>
                    <th>' . _AM_TEAM_OPTIONS . '</th>
                </tr>';

    while (false !== ($groups = $xoopsDB->fetchArray($result))) {
        $xentTeamGroups->setIdGroup($groups['ID_GROUP']);

        $xentTeamGroups->setName(reference('groups', 'name', 'groupid', $xentTeamGroups->getIdGroup()));

        $xentTeamGroups->setDisplay($groups['display']);

        echo "
            	<tr>
                    <td class='even'>" . $xentTeamGroups->getName() . "</td>
                    <td class='even'>";

        if (0 == $xentTeamGroups->getDisplay()) {
            echo _AM_TEAM_NO;
        } else {
            echo _AM_TEAM_YES;
        }

        echo "</td>
                    <td class='even'><a href='admingroups.php?op=GROUPSEdit&id=" . $xentTeamGroups->getIdGroup() . "'>" . _AM_TEAM_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function GROUPSEdit()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamGroups = new XentTeamGroups();

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
        } else {
            $id = 0;
        }
    }

    if (0 != $id) {
        $group = $xentTeamGroups->getGroup($id);

        $xentTeamGroups->setIdGroup($group['ID_GROUP']);

        $xentTeamGroups->setName(reference('groups', 'name', 'groupid', $xentTeamGroups->getIdGroup()));

        $xentTeamGroups->setDisplay($group['display']);

        $sform = new XoopsThemeForm(_AM_TEAM_EDIT . ' - ' . $xentTeamGroups->getName(), 'editxentgroup', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(makeSelect(_AM_TEAM_DISPLAYGROUP, 'display_select', $xentTeamGroups->getDisplay(), makeNoYesArray(), 2));

        $save_button = new XoopsFormButton('', 'add', _AM_TEAM_SAVE, 'submit');

        $save_button->setExtra("onmouseover='document.editxentgroup.op.value=\"GROUPSSaveEdit\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.editxentgroup.op.value=\"GROUPSShowGroups\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($save_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $xentTeamGroups->getIdGroup()));

        $sform->addElement(new XoopsFormHidden('op', 'TEAMSaveEdit'));

        $sform->display();
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function GROUPSSaveEdit($ID_GROUP, $display)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamGroups = new XentTeamGroups();

    $xentTeamGroups->setIdGroup($ID_GROUP);

    $xentTeamGroups->setDisplay($display);

    $xentTeamGroups->update();
}

function GROUPSImport()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamGroups = new XentTeamGroups();

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('groups');

    $result = $xoopsDB->query($sql);

    while (false !== ($groups_to_import = $xoopsDB->fetchArray($result))) {
        $xentTeamGroups->setIdGroup($groups_to_import['groupid']);

        $xentTeamGroups->setDisplay(0);

        $xentTeamGroups->add(1);
    }

    GROUPSShowGroups();
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'GROUPSShowGroups':
        GROUPSShowGroups();
        break;
    case 'GROUPSImport':
        GROUPSImport();
        break;
    case 'GROUPSEdit':
        GROUPSEdit();
        break;
    case 'GROUPSSaveEdit':
        GROUPSSaveEdit($id, $display_select);
        break;
    default:
        GROUPSShowGroups();
        break;
}

// *************************** Fin de NTS **********************************

buildGroupsActionMenu();

CloseTable();

xoops_cp_footer();
