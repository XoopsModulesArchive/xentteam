<?php

require_once XOOPS_ROOT_PATH . '/modules/xentgen/include/xent_gen_tables.php';

class XentTeamGroups
{
    public $db;

    public $name;

    public $display;

    public $id_group;

    // constructor

    public function __construct()
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
    }

    // setters

    public function setDisplay($display)
    {
        $this->display = $display;
    }

    public function setIdGroup($id_group)
    {
        $this->id_group = $id_group;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // getters

    public function getDisplay()
    {
        return $this->display;
    }

    public function getIdGroup()
    {
        return $this->id_group;
    }

    public function getName()
    {
        return $this->name;
    }

    // methods

    public function add($inBatch = 0)
    {
        global $module_tables;

        $sql = 'INSERT INTO ' . $this->db->prefix($module_tables[0]) . ' (ID_GROUP, display) VALUES(' . $this->getIdGroup() . ', ' . $this->getDisplay() . ')';

        $this->db->queryF($sql);

        if (0 == $inBatch) {
            if (0 == $this->db->errno()) {
                redirect_header('admingroups.php', 1, _AM_TEAM_DBUPDATED);
            } else {
                redirect_header('admingroups.php', 4, $this->db->error());
            }
        }
    }

    public function getAllGroups()
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[0]);

        $result = $this->db->query($sql);

        return $result;
    }

    public function getDisplayedGroups()
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[0]) . ' WHERE display=1';

        $result = $this->db->query($sql);

        return $result;
    }

    public function getGroup($id)
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[0]) . " WHERE ID_GROUP=$id";

        $result = $this->db->query($sql);

        $theGroup = $this->db->fetchArray($result);

        return $theGroup;
    }

    public function getSmallestDisplayedGroupID()
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[0]) . ' WHERE display=1 ORDER BY ID_GROUP ASC';

        $result = $this->db->query($sql);

        $theGroups = $this->db->fetchArray($result);

        $theId = $theGroups['ID_GROUP'];

        return $theId;
    }

    public function getDisplayedUsers()
    {
        global $module_tables;

        #$sql = "SELECT DISTINCT t1.ID_USER, t1.pictpro, t1.career_summary, t1.id_job, t1.id_title, t1.priority, t3.display FROM ".$this->db->prefix(XENT_DB_XENT_GEN_USERS)." AS t1, ".$this->db->prefix("groups_users_link")." AS t2, ".$this->db->prefix($module_tables[4])." as t3 WHERE (t1.ID_USER = t2.uid AND groupid=$idgroup AND display=1) ORDER BY t1.priority";

        #$sql = "SELECT DISTINCT t1.id_user FROM ".$this->db->prefix($module_tables[4])." as t1, ".$this->db->prefix("groups_users_link")." as t2, ".$this->db->prefix(XENT_DB_XENT_GEN_USERS)." as t3 WHERE display = 1 AND t1.id_user = t2.uid and t2.groupid=$idgroup ORDER BY t3.priority";

        $sql = 'SELECT xoops_xent_team_display.id_user, xoops_xent_gen_users.priority
FROM (xoops_xent_gen_users LEFT JOIN xoops_xent_team_display ON xoops_xent_gen_users.ID_USER = xoops_xent_team_display.id_user) LEFT JOIN xoops_groups_users_link ON xoops_xent_gen_users.ID_USER = xoops_groups_users_link.linkid
WHERE xoops_xent_team_display.display = 1 
ORDER BY xoops_xent_gen_users.priority';

        #echo $sql;

        $result = $this->db->query($sql);

        return $result;
    }

    public function idExists($id)
    {
        global $module_tables;

        $sql = 'SELECT * FROM ' . $this->db->prefix($module_tables[0]) . " WHERE ID_GROUP=$id AND display=1";

        $result = $this->db->query($sql);

        $group = $this->db->fetchArray($result);

        if (!empty($group['ID_GROUP'])) {
            return true;
        }
  

        return false;
    }

    public function isUserInGroup($iduser)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('groups_users_link') . ' WHERE groupid=' . $this->getIdGroup() . " AND uid=$iduser";

        $result = $this->db->query($sql);

        $groupuser = $this->db->fetchArray($result);

        if (!empty($groupuser['uid'])) {
            return true;
        }
  

        return false;
    }

    public function update()
    {
        global $module_tables;

        $sql = 'UPDATE ' . $this->db->prefix($module_tables[0]) . ' SET display=' . $this->getDisplay() . ' WHERE ID_GROUP=' . $this->getIdGroup();

        $this->db->queryF($sql);

        if (0 == $this->db->errno()) {
            redirect_header('admingroups.php', 1, _AM_DBUPDATED);
        } else {
            redirect_header('admingroups.php', 4, $this->db->error());
        }
    }
}
