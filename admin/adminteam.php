<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('adminteam');

OpenTable();
echo "<div class='adminHeader'>" . _AM_TEAM_ADMINTEAMTITLE . '</div><br>';

function TEAMShowTeam()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUsers = new XentUsers();

    $xentTeamDisplay = new XentTeamDisplay();

    $xentTeamDisplay->synchronize();

    $result = $xentUsers->getAllUsers();

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
            		<th>" . _AM_TEAM_IMAGE . '</th>
                    <th>' . _AM_TEAM_NAME . '</th>
                    <th>' . _AM_TEAM_DISPLAYUSER . '</th>
                    <th>' . _AM_TEAM_OPTIONS . '</th>
                </tr>';

    while (false !== ($cie_users = $xoopsDB->fetchArray($result))) {
        $xentUsers->setName($cie_users['name']);

        $xentUsers->setPictPro($cie_users['pictpro']);

        $xentTeamDisplay->setIdUser($cie_users['ID_USER']);

        $display_info = $xentTeamDisplay->getUserDisplayInfos($xentTeamDisplay->getIdUser());

        $xentTeamDisplay->setPictProWhereTo($display_info['pictprowhereto']);

        $xentTeamDisplay->setDisplay($display_info['display']);

        $tmp = $xentUsers->getPictPro();

        if (!empty($tmp)) {
            switch ($xentTeamDisplay->getPictProWhereto()) {
                case 0:
                    $pictProWhereTo = _AM_TEAM_IMAGEWHERETODISPLAYEDOPT0;
                    break;
                case 1:
                    $pictProWhereTo = _AM_TEAM_IMAGEWHERETODISPLAYEDOPT1;
                    break;
                case 2:
                    $pictProWhereTo = _AM_TEAM_IMAGEWHERETODISPLAYEDOPT2;
                    break;
            }

            $pictpro = "<center><img height='30%' width='30%' src='" . XOOPS_URL . $xoopsModuleConfig['image_upload_dir'] . '/' . $xentUsers->getPictPro() . "'></img><br>$pictProWhereTo</center>";
        } else {
            $pictpro = '';
        }

        echo "
            	<tr>
                	<td class='even' width='15%'>" . $pictpro . "</td>
                    <td class='even'>" . $xentUsers->getName() . "</td>
                    <td class='even'>";

        if (0 == $xentTeamDisplay->getDisplay()) {
            echo _AM_TEAM_NO;
        } else {
            echo _AM_TEAM_YES;
        }

        echo "</td>
                    <td class='even'><a href='adminteam.php?op=TEAMEdit&id=" . $cie_users['ID_USER'] . "'>" . _AM_TEAM_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function TEAMEdit()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUsers = new XentUsers();

    $xentTeamDisplay = new XentTeamDisplay();

    $xentTeamExpertise = new XentTeamExpertise();

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
        $user = $xentUsers->getUser($id);

        $display_info = $xentTeamDisplay->getUserDisplayInfos($id);

        $xentUsers->setName($user['name']);

        $xentTeamDisplay->setIdUser($user['ID_USER']);

        $xentTeamDisplay->setPictProWhereTo($display_info['pictprowhereto']);

        $xentTeamDisplay->setDisplay($display_info['display']);

        $sform = new XoopsThemeForm(_AM_TEAM_EDIT . ' - ' . $xentUsers->getName(), 'editxentuser', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $thearray = getTopic($module_tables[2], 'name', 'ID_EXPERTISEITEM', 'name');

        $sform->addElement(makeSelect(_AM_TEAM_EXPERTISE, 'expertise_select', $xentTeamExpertise->getArrayUserExpertise($id), $thearray, 7, 0, true));

        $sform->addElement(makeSelect(_AM_TEAM_IMAGEWHERETODISPLAYED, 'imagewhereto_select', $xentTeamDisplay->getPictProWhereto(), makeImageWhereToDisplayArray(), 3));

        $sform->addElement(makeSelect(_AM_TEAM_DISPLAYUSER, 'display_select', $xentTeamDisplay->getDisplay(), makeNoYesArray(), 2));

        $save_button = new XoopsFormButton('', 'add', _AM_TEAM_SAVE, 'submit');

        $save_button->setExtra("onmouseover='document.editxentuser.op.value=\"TEAMSaveEdit\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.editxentuser.op.value=\"TEAMShowTeam\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($save_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $xentTeamDisplay->getIdUser()));

        $sform->addElement(new XoopsFormHidden('op', 'TEAMSaveEdit'));

        $sform->display();
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function TEAMSaveEdit($ID_USER, $pictprowhereto, $display, $expertise)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentUser = new XentUsers();

    $xentTeamDisplay = new XentTeamDisplay();

    $xentTeamExpertise = new XentTeamExpertise();

    $xentUser->setIdUser($ID_USER);

    $xentTeamDisplay->setIdUser($xentUser->getIdUser());

    $xentTeamDisplay->setPictProWhereTo($pictprowhereto);

    $xentTeamDisplay->setDisplay($display);

    $xentTeamExpertise->setIdUser($xentUser->getIdUser());

    $xentTeamExpertise->setExpertise($expertise);

    $xentTeamDisplay->update();

    $xentTeamExpertise->update();
}

function TEAMSynchronize()
{
    $xentTeamDisplay = new XentTeamDisplay();

    $xentTeamDisplay->synchronize();
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'TEAMShowTeam':
        TEAMShowTeam();
        break;
    case 'TEAMEdit':
        TEAMEdit();
        break;
    case 'TEAMSaveEdit':

        if (empty($expertise_select)) {
            $expertise_select = [];
        }

        TEAMSaveEdit($id, $imagewhereto_select, $display_select, $expertise_select);
        break;
    default:
        TEAMShowTeam();
        break;
}

// *************************** Fin de NTS **********************************

buildTeamActionMenu();

CloseTable();

xoops_cp_footer();
