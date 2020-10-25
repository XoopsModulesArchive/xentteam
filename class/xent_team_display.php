<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

class XentTeamDisplay
{
    public $db;

    public $display;

    public $pictprowhereto;

    public $id_user;

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function setIdUser($id)
    {
        $this->id_user = $id;
    }

    public function setPictProWhereTo($pictprowhereto)
    {
        $this->pictprowhereto = $pictprowhereto;
    }

    // getters

    public function getDisplay()
    {
        return $this->display;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getPictProWhereto()
    {
        return $this->pictprowhereto;
    }

    // methods

    // if table xoops_xent_team_display is empty

    public function add($inBatch = 0)
    {
        global $module_tables;

        $sql = 'INSERT INTO ' . $this->db->prefix($module_tables[4]) . ' (display, pictprowhereto, id_user) VALUES(' . $this->getDisplay() . ', ' . $this->getPictProWhereto() . ', ' . $this->getIdUser() . ')';

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('adminteam.php?op=TEAMShowTeam', 1, _AM_TEAM_DBUPDATED);
            } else {
                redirect_header('adminteam.php?op=TeamShowTeam', 4, $this->db->error());
            }
        }
    }

    public function delete($id)
    {
        global $module_tables;

        $sql = 'DELETE FROM ' . $this->db->prefix($module_tables[4]) . " WHERE id_user=$id";

        $this->db->queryF($sql);
    }

    public function exists($iduser)
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[4]) . " WHERE id_user=$iduser";

        $result = $this->db->query($sql);

        if (0 == $this->db->getRowsNum($result)) {
            return false;
        }
  

        return true;
    }

    public function isEmpty()
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[4]);

        $result = $this->db->query($sql);

        $display_table = $this->db->fetchArray($result);

        if (empty($display_table['ID_DISPLAY'])) {
            return true;
        }
  

        return false;
    }

    public function getAllDisplayedUsers()
    {
        global $module_tables;

        $sql = 'SELECT DISTINCT id_user FROM ' . $this->db->prefix($module_tables[4]) . ' ORDER BY id_user';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getPictProWhereToForUser($id)
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[4]) . " WHERE id_user=$id";

        $result = $this->db->query($sql);

        $info = $this->db->fetchArray($result);

        return $info['pictprowhereto'];
    }

    public function getUserDisplayInfos($id)
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[4]) . " WHERE id_user=$id";

        $result = $this->db->query($sql);

        $display_info = $this->db->fetchArray($result);

        return $display_info;
    }

    public function synchronize()
    {
        // we need to get the users in gen_users

        $xentUsers = new XentUsers();

        $result = $xentUsers->getAllUsers();

        // init the data in team_display

        while (false !== ($users = $this->db->fetchArray($result))) {
            $this->setIdUser($users['ID_USER']);

            if (false === $this->exists($this->getIdUser())) {
                $this->setDisplay(0);

                $this->setPictProWhereTo(0);

                $this->add(1);
            }
        }

        $result = $this->getAllDisplayedUsers();

        while (false !== ($dis_users = $this->db->fetchArray($result))) {
            $this->setIdUser($dis_users['id_user']);

            if (false === $xentUsers->exists($this->getIdUser())) {
                $this->delete($dis_users['id_user']);
            }
        }
    }

    public function update()
    {
        global $module_tables;

        $sql = 'UPDATE ' . $this->db->prefix($module_tables[4]) . ' SET display=' . $this->getDisplay() . ', pictprowhereto=' . $this->getPictProWhereto() . ' WHERE id_user=' . $this->getIdUser();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
        } else {
            redirect_header('adminteam.php', 4, $this->db->error());
        }
    }
}
