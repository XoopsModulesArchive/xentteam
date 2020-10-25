<?php

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';

foreach ($_REQUEST as $a => $b) {
    $$a = $b;
}

$eh = new ErrorHandler();
xoops_cp_header();
echo $oAdminButton->renderButtons('adminexpertise');

OpenTable();
echo "<div class='adminHeader'>" . _AM_TEAM_ADMINTEAMTITLE . '</div><br>';

function EXPShowCat()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentTeamExpertise = new XentTeamExpertise();

    $result = $xentTeamExpertise->getAllCat();

    echo "<div align='right' class='adminActionMenu'><a href='adminexpertise.php?op=EXPAddCat'>" . _AM_TEAM_ADDCAT . '</a></div>';

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
                    <th>" . _AM_TEAM_NAME . '</th>
                    <th>' . _AM_TEAM_PRIORITY . '</th>
                    <th>' . _AM_TEAM_OPTIONS . '</th>
                </tr>';

    while (false !== ($exp_cat = $xoopsDB->fetchArray($result))) {
        $xentTeamExpertise->setIdCat($exp_cat['ID_EXPERTISECAT']);

        $xentTeamExpertise->setNameCat($exp_cat['name']);

        $xentTeamExpertise->setPriorityCat($exp_cat['priority']);

        echo "
            	<tr>
                    <td class='even'>" . $myts->displayTarea($xentTeamExpertise->getNameCat()) . "</td>
                    <td class='even'>" . $xentTeamExpertise->getPriorityCat() . "</td>
                    <td class='even'><a href='adminexpertise.php?op=EXPEditCat&id=" . $xentTeamExpertise->getIdCat() . "'>" . _AM_TEAM_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function EXPShowItems()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentTeamExpertise = new XentTeamExpertise();

    $result = $xentTeamExpertise->getAllItems();

    echo "<div align='right' class='adminActionMenu'><a href='adminexpertise.php?op=EXPAddItem'>" . _AM_TEAM_ADDITEM . '</a></div>';

    echo "
        	<table width='100%' class='outer' cellspacing='1'>
            	<tr>
                    <th>" . _AM_TEAM_NAME . '</th>
                    <th>' . _AM_TEAM_ADMINEXPCAT . '</th>
                    <th>' . _AM_TEAM_ADMINEXPCATALWAYSSHOWN . '</th>
                    <th>' . _AM_TEAM_ADMINEXPCATDISPLAY . '</th>
                    <th>' . _AM_TEAM_OPTIONS . '</th>
                </tr>';

    while (false !== ($exp_items = $xoopsDB->fetchArray($result))) {
        $xentTeamExpertise->setIdItem($exp_items['ID_EXPERTISEITEM']);

        $xentTeamExpertise->setNameItem($exp_items['name']);

        $xentTeamExpertise->setIdCatItem($exp_items['id_expertisecat']);

        $xentTeamExpertise->setNameCatItem(reference($module_tables[1], 'name', 'ID_EXPERTISECAT', $xentTeamExpertise->getIdCatItem()));

        $xentTeamExpertise->setAlwaysShownItem($exp_items['alwaysShown']);

        $xentTeamExpertise->setDisplayItem($exp_items['display']);

        echo "
            	<tr>
                    <td class='even'>" . $myts->displayTarea($xentTeamExpertise->getNameItem()) . "</td>
                    <td class='even'>" . $xentTeamExpertise->getNameCatItem() . "</td>
                    <td class='even'>" . $xentTeamExpertise->getAlwaysShownItemText() . "</td>
                    <td class='even'>" . $xentTeamExpertise->getDisplayItemText() . "</td>
                    <td class='even'><a href='adminexpertise.php?op=EXPEditItem&id=" . $xentTeamExpertise->getIdItem() . "'>" . _AM_TEAM_EDIT . '</a></td>
                </tr>
            ';
    }

    echo '
        	</table>
        ';
}

function EXPAddCat()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    $myts = MyTextSanitizer::getInstance();

    if (!empty($_GET['name'])) {
        $xentTeamExpertise->setNameCat($_GET['name']);
    } else {
        $xentTeamExpertise->setNameCat('[fr][/fr][en][/en]');
    }

    if (!empty($_GET['priority'])) {
        $xentTeamExpertise->setPriorityCat($_GET['priority']);
    } else {
        $xentTeamExpertise->setPriorityCat('');
    }

    $sform = new XoopsThemeForm(_AM_TEAM_ADDCAT, 'addexpcat', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_AM_TEAM_EXPCATNAME, 'cat_name', 50, 255, $xentTeamExpertise->getNameCat()));

    $sform->addElement(new XoopsFormText(_AM_TEAM_PRIORITY, 'priority', 5, 5, $xentTeamExpertise->getPriorityCat()));

    $save_button = new XoopsFormButton('', 'add', _AM_TEAM_ADD, 'submit');

    $save_button->setExtra("onmouseover='document.addexpcat.op.value=\"EXPSaveAddCat\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_CANCEL, 'submit');

    $cancel_button->setExtra("onmouseover='document.addexpcat.op.value=\"EXPShowCat\"'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'EXPSaveAddCat'));

    $sform->display();
}

function EXPAddItem()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    $myts = MyTextSanitizer::getInstance();

    if (!empty($_GET['name'])) {
        $xentTeamExpertise->setNameItem($_GET['name']);
    } else {
        $xentTeamExpertise->setNameItem('[fr][/fr][en][/en]');
    }

    if (!empty($_GET['alwaysshown'])) {
        $xentTeamExpertise->setAlwaysShownItem($_GET['alwaysshown']);
    } else {
        $xentTeamExpertise->setAlwaysShownItem(0);
    }

    if (!empty($_GET['display'])) {
        $xentTeamExpertise->setDisplayItem($_GET['display']);
    } else {
        $xentTeamExpertise->setDisplayItem(0);
    }

    if (!empty($_GET['id_expertisecat'])) {
        $xentTeamExpertise->setIdCatItem($_GET['id_expertisecat']);
    } else {
        $xentTeamExpertise->setIdCatItem($xentTeamExpertise->getFirstIdInCatSelect());
    }

    $sform = new XoopsThemeForm(_AM_TEAM_ADDITEM, 'addexpitem', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement(new XoopsFormText(_AM_TEAM_EXPITEMNAME, 'item_name', 50, 255, $xentTeamExpertise->getNameItem()));

    $sform->addElement(makeSelect(_AM_TEAM_ADMINEXPCATALWAYSSHOWN, 'alwaysshown_select', $xentTeamExpertise->getAlwaysShownItem(), makeNoYesArray(), 2));

    $sform->addElement(makeSelect(_AM_TEAM_ADMINEXPCATDISPLAY, 'display_select', $xentTeamExpertise->getDisplayItem(), makeNoYesArray(), 2));

    $thearray = getTopic($module_tables[1], 'name', 'ID_EXPERTISECAT', 'name');

    $sform->addElement(makeSelect(_AM_TEAM_ADMINEXPCAT, 'item_select', $xentTeamExpertise->getIdCatItem(), $thearray, 1));

    $save_button = new XoopsFormButton('', 'add', _AM_TEAM_ADD, 'submit');

    $save_button->setExtra("onmouseover='document.addexpitem.op.value=\"EXPSaveAddItem\"'");

    $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_CANCEL, 'submit');

    $cancel_button->setExtra("onmouseover='document.addexpitem.op.value=\"EXPShowItems\"'");

    $button_tray = new XoopsFormElementTray('', '');

    $button_tray->addElement($save_button);

    $button_tray->addElement($cancel_button);

    $sform->addElement($button_tray);

    $sform->addElement(new XoopsFormHidden('op', 'EXPSaveEditItem'));

    $sform->display();
}

function EXPEditCat()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    $myts = MyTextSanitizer::getInstance();

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
        $exp_cat = $xentTeamExpertise->getCat($id);

        $xentTeamExpertise->setNameCat($exp_cat['name']);

        $xentTeamExpertise->setIdCat($exp_cat['ID_EXPERTISECAT']);

        $xentTeamExpertise->setPriorityCat($exp_cat['priority']);

        $sform = new XoopsThemeForm(_AM_TEAM_EDIT . ' - ' . $myts->displayTarea($xentTeamExpertise->getNameCat()), 'editexpcat', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormText(_AM_TEAM_EXPCATNAME, 'cat_name', 50, 255, $xentTeamExpertise->getNameCat()));

        $sform->addElement(new XoopsFormText(_AM_TEAM_PRIORITY, 'priority', 5, 5, $xentTeamExpertise->getPriorityCat()));

        $save_button = new XoopsFormButton('', 'add', _AM_TEAM_MODIFY, 'submit');

        $save_button->setExtra("onmouseover='document.editexpcat.op.value=\"EXPSaveEditCat\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_DELETE, 'submit');

        $cancel_button->setExtra("onmouseover='document.editexpcat.op.value=\"EXPAreYouSureToDeleteCat\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($save_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $xentTeamExpertise->getIdCat()));

        $sform->addElement(new XoopsFormHidden('op', 'EXPSaveEditCat'));

        $sform->display();
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function EXPEditItem()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    $myts = MyTextSanitizer::getInstance();

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
        $exp_item = $xentTeamExpertise->getItem($id);

        $xentTeamExpertise->setIdItem($exp_item['ID_EXPERTISEITEM']);

        $xentTeamExpertise->setNameItem($exp_item['name']);

        $xentTeamExpertise->setIdCatItem($exp_item['id_expertisecat']);

        $xentTeamExpertise->setNameCatItem(reference($module_tables[1], 'name', 'ID_EXPERTISECAT', $xentTeamExpertise->getIdCatItem()));

        $xentTeamExpertise->setAlwaysShownItem($exp_item['alwaysShown']);

        $xentTeamExpertise->setDisplayItem($exp_item['display']);

        $sform = new XoopsThemeForm(_AM_TEAM_EDIT . ' - ' . $myts->displayTarea($xentTeamExpertise->getNameItem()), 'editexpitem', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormText(_AM_TEAM_EXPITEMNAME, 'item_name', 50, 255, $xentTeamExpertise->getNameItem()));

        $sform->addElement(makeSelect(_AM_TEAM_ADMINEXPCATALWAYSSHOWN, 'alwaysshown_select', $xentTeamExpertise->getAlwaysShownItem(), makeNoYesArray(), 2));

        $sform->addElement(makeSelect(_AM_TEAM_ADMINEXPCATDISPLAY, 'display_select', $xentTeamExpertise->getDisplayItem(), makeNoYesArray(), 2));

        $thearray = getTopic($module_tables[1], 'name', 'ID_EXPERTISECAT');

        $sform->addElement(makeSelect(_AM_TEAM_ADMINEXPCAT, 'item_select', $xentTeamExpertise->getIdCatItem(), $thearray, 1));

        $save_button = new XoopsFormButton('', 'add', _AM_TEAM_MODIFY, 'submit');

        $save_button->setExtra("onmouseover='document.editexpitem.op.value=\"EXPSaveEditItem\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_DELETE, 'submit');

        $cancel_button->setExtra("onmouseover='document.editexpitem.op.value=\"EXPAreYouSureToDeleteItem\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($save_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $xentTeamExpertise->getIdItem()));

        $sform->addElement(new XoopsFormHidden('op', 'EXPSaveEditItem'));

        $sform->display();
    }  

    // s'il n'y a rien dans le paramètre id de l'adresse
}

function EXPSaveAddCat($name, $priority)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    if (empty($priority)) {
        $priority = 0;
    }

    $xentTeamExpertise->setNameCat($name);

    $xentTeamExpertise->setPriorityCat($priority);

    $xentTeamExpertise->addCat();
}

function EXPSaveAddItem($name, $alwaysShown, $display, $id_expertisecat)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    $xentTeamExpertise->setNameItem($name);

    $xentTeamExpertise->setAlwaysShownItem($alwaysShown);

    $xentTeamExpertise->setDisplayItem($display);

    $xentTeamExpertise->setIdCatItem($id_expertisecat);

    $xentTeamExpertise->addItem();
}

function EXPSaveEditCat($id, $name, $priority)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    $xentTeamExpertise->setIdCat($id);

    $xentTeamExpertise->setNameCat($name);

    $xentTeamExpertise->setPriorityCat($priority);

    $xentTeamExpertise->updateCat();
}

function EXPSaveEditItem($id, $name, $alwaysShown, $display, $id_catitem)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $xentTeamExpertise = new XentTeamExpertise();

    $xentTeamExpertise->setIdItem($id);

    $xentTeamExpertise->setNameItem($name);

    $xentTeamExpertise->setIdCatItem($id_catitem);

    $xentTeamExpertise->setAlwaysShownItem($alwaysShown);

    $xentTeamExpertise->setDisplayItem($display);

    $xentTeamExpertise->updateItem();
}

function EXPAreYouSureToDeleteCat()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentTeamExpertise = new XentTeamExpertise();

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $exp_cat = $xentTeamExpertise->getCat($id);

    if (!empty($exp_cat['ID_EXPERTISECAT'])) {
        $sform = new XoopsThemeForm(_AM_TEAM_AREYOUSUREDELTE, 'delexp', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormLabel(_AM_TEAM_EXPCATNAME, $myts->displayTarea($exp_cat['name'])));

        $delete_button = new XoopsFormButton('', 'add', _AM_TEAM_DELETE, 'submit');

        $delete_button->setExtra("onmouseover='document.delexp.op.value=\"EXPDeleteCat\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.delexp.op.value=\"EXPEditCat\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($delete_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $id));

        $sform->addElement(new XoopsFormHidden('op', ''));

        $sform->display();
    }  

    // aucun projet, msg d'erreur
}

function EXPAreYouSureToDeleteItem()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $module_tables;

    $myts = MyTextSanitizer::getInstance();

    $xentTeamExpertise = new XentTeamExpertise();

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $exp_item = $xentTeamExpertise->getItem($id);

    if (!empty($exp_item['ID_EXPERTISEITEM'])) {
        $sform = new XoopsThemeForm(_AM_TEAM_AREYOUSUREDELTE, 'delexp', xoops_getenv('PHP_SELF'));

        $sform->setExtra('enctype="multipart/form-data"');

        $sform->addElement(new XoopsFormLabel(_AM_TEAM_EXPITEMNAME, $myts->displayTarea($exp_item['name'])));

        $delete_button = new XoopsFormButton('', 'add', _AM_TEAM_DELETE, 'submit');

        $delete_button->setExtra("onmouseover='document.delexp.op.value=\"EXPDeleteItem\"'");

        $cancel_button = new XoopsFormButton('', 'add', _AM_TEAM_CANCEL, 'submit');

        $cancel_button->setExtra("onmouseover='document.delexp.op.value=\"EXPEditItem\"'");

        $button_tray = new XoopsFormElementTray('', '');

        $button_tray->addElement($delete_button);

        $button_tray->addElement($cancel_button);

        $sform->addElement($button_tray);

        $sform->addElement(new XoopsFormHidden('id', $id));

        $sform->addElement(new XoopsFormHidden('op', ''));

        $sform->display();
    }  

    // aucun projet, msg d'erreur
}

function EXPDeleteCat($id)
{
    $xentTeamExpertise = new XentTeamExpertise();

    $xentTeamExpertise->deleteCat($id);
}

function EXPDeleteItem($id)
{
    $xentTeamExpertise = new XentTeamExpertise();

    $xentTeamExpertise->deleteItem($id);
}

// ** NTS : À mettre à la fin de chaque fichier nécessitant plusieurs ops **

$op = $_POST['op'] ?? $_GET['op'] ?? 'main';

switch ($op) {
    case 'EXPAddCat':
        EXPAddCat();
        break;
    case 'EXPEditCat':
        EXPEditCat();
        break;
    case 'EXPSaveAddCat':
        EXPSaveAddCat($cat_name, $priority);
        break;
    case 'EXPSaveEditCat':
        EXPSaveEditCat($id, $cat_name, $priority);
        break;
    case 'EXPAreYouSureToDeleteCat':
        EXPAreYouSureToDeleteCat();
        break;
    case 'EXPDeleteCat':
        EXPDeleteCat($id);
        break;
    case 'EXPAddItem':
        EXPAddItem();
        break;
    case 'EXPSaveAddItem':
        EXPSaveAddItem($item_name, $alwaysshown_select, $display_select, $item_select);
        break;
    case 'EXPShowItems':
        EXPShowItems();
        break;
    case 'EXPEditItem':
        EXPEditItem();
        break;
    case 'EXPSaveEditItem':
        EXPSaveEditItem($id, $item_name, $alwaysshown_select, $display_select, $item_select);
        break;
    case 'EXPAreYouSureToDeleteItem':
        EXPAreYouSureToDeleteItem();
        break;
    case 'EXPDeleteItem':
        EXPDeleteItem($id);
        break;
    default:
        EXPShowCat();
        break;
}

// *************************** Fin de NTS **********************************

buildExpActionMenu();

CloseTable();

xoops_cp_footer();
