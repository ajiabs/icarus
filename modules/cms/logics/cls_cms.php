<?php
// +----------------------------------------------------------------------+
// | File name : CMS                                                      |
// |(AUTOMATED CUSTOM CMS LOGIC)                          |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: Armia Systems<info@armia.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems &copy; 2018                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// |   ICARUS is free software: you can redistribute it and/or modify
// |   it under the terms of the GNU General Public License as published by
// |   the Free Software Foundation, either version 3 of the License, or
// |   (at your option) any later version.

// |   ICARUS is distributed in the hope that it will be useful,
// |   but WITHOUT ANY WARRANTY; without even the implied warranty of
// |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// |   GNU General Public License for more details.

// |   You should have received a copy of the GNU General Public License
// |   along with ICARUS.  If not, see <https://www.gnu.org/licenses/>.   
// |
// +----------------------------------------------------------------------+

class Cms extends Filehandler {


    public static function loadMenu() {

        $dbh     = new Db();
        $session    =   new LibSession();

        // Added for CUP
        $module     = $session->get("module");

        if($session->get("admin_type")=="developer"){
            $module        = "admin";
            $privileges    =   "  ";
        }else
            $privileges    =   " AND cs.user_privilege='all' AND cg.user_privilege='all' ";
        //echo "SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published = 'Y' AND cg.module='".$module."' $privileges  ORDER BY position,display_order ASC";
        $res = $dbh->execute("SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published = 'Y' AND cg.module='".$module."' $privileges  ORDER BY position,display_order ASC");
        $groups = $dbh->fetchAll($res);
       /* $menu = array();
        foreach($groups as $group) {
            $menu[$group->group_id]->name = $group->group_name;
            $menu[$group->group_id]->sections[] = $group;
        }
        die("res");*/
        return $groups;
    }



     public static function loadTitle($sectiontype) {



        $dbh     = new Db();
        $session    =   new LibSession();

        $res = $dbh->execute("SELECT section_name FROM cms_sections WHERE section_alias = '$sectiontype'");
        $groups = $dbh->fetchOne($res);
       /* $menu = array();
        foreach($groups as $group) {
            $menu[$group->group_id]->name = $group->group_name;
            $menu[$group->group_id]->sections[] = $group;
        }
        die("res");*/
        return $groups;
    }

      public static function loadTable($sectiontype) {



        $dbh     = new Db();
        $session    =   new LibSession();

        $res = $dbh->execute("SELECT table_name FROM cms_sections WHERE section_alias = '$sectiontype'");
        $groups = $dbh->fetchOne($res);
       /* $menu = array();
        foreach($groups as $group) {
            $menu[$group->group_id]->name = $group->group_name;
            $menu[$group->group_id]->sections[] = $group;
        }
        die("res");*/
        return $groups;
    }


    public static function getParentRoleList($roleId,$parentRoleIDArray="") {
        return $parentRoleIDArray= Cms::getParentRoleIdArray($roleId,$parentRoleIDArray);
        //echopre($parentRoleIDArray);
    }

    public static function  getPrivileges($parentRoleIDArray) {
        $parentRoleIDString  =  "" ;
        for($loop=0;$loop<count($parentRoleIDArray);$loop++) {
            $parentRoleIDString  .=  $parentRoleIDArray[$loop].",";
        }
        $parentRoleIDString = substr($parentRoleIDString, 0, -1);

        $privilegedGroups = Cms::getPrivilegedGroups($parentRoleIDString);

        $privilegedSections = Cms::getPrivilegedSections($parentRoleIDString);


        if($privilegedGroups!="")
            //$privileges   .=   " AND cg.id IN($privilegedGroups) ";
        $privileges   .=   " AND cg.id NOT IN($privilegedGroups) ";
        if($privilegedSections!="")
            //$privileges   .=   "  AND cs.id IN($privilegedSections)";
        $privileges   .=   "  AND cs.id NOT IN($privilegedSections)";
        return $privileges;


    }

    public static function getAllRoles() {

        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT role_name,role_id,parent_role_id   FROM cms_roles  ");
        $roles = $dbh->fetchAll($res);


        $loop = 0;
        foreach($roles as $role) {
            $rolesArry[$loop]->value = $role->role_id;
            $rolesArry[$loop]->text = $role->role_name;
            $loop++;
        }
        return $rolesArry;
    }

    public static function getAllRolesArray($page,$perPageSize) {
        if($page)
            $startPage=($page-1)*$perPageSize;
        else
            $startPage =0;
        $limit=" LIMIT $startPage,$perPageSize";
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT role_name,role_id,parent_role_id FROM cms_roles ORDER BY `role_id` DESC $limit");
        $roles = $dbh->fetchAll($res);



        return $roles;
    }
    public static function getAllUsers($request) {

        $dbh 	 = new Db();
        if($request['searchField']=='username' || $request['searchField']=='email') {

        	$searchText=$request['searchText'];
        	$search=" AND ".$request['searchField']." LIKE '%".$searchText."%' ";
        }
        $orderby=" ORDER BY id ";
        //  ORDER BY clause from the $_GET params
        if(isset($request['orderField']))
        	$orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];

        $res = $dbh->execute("SELECT username,id,role_id   FROM cms_users  where status='active' and visibility='1' $search $orderby ");
        $users = $dbh->fetchAll($res);



        return $users;
    }
    public static function getAllUserArray($page,$perPageSize,$request){
        if($page)
            $startPage=($page-1)*$perPageSize;
        else
            $startPage =0;
        $limit=" LIMIT $startPage,$perPageSize";
        if($request['searchField']=='username' || $request['searchField']=='email') {

        	$searchText=$request['searchText'];
        	$search=" AND ".$request['searchField']." LIKE '%".$searchText."%' ";

        }
        $orderby=" ORDER BY id DESC";
        //  ORDER BY clause from the $_GET params
        if(isset($request['orderField']))
        	$orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];

        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT username,email,id,role_id   FROM cms_users where status='active' and visibility='1'  $search $orderby $limit ");

        $users = $dbh->fetchAll($res);



        return $users;
    }
    public static function getUserDetails($userId = "") {
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT *   FROM cms_users WHERE id= '$userId' ");
        $users = $dbh->fetchRow($res);

        return $users;
    }
    public static function getRoleDetails($roleId = "") {
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT *   FROM cms_roles WHERE role_id= '$roleId' ");
        $roles = $dbh->fetchRow($res);

        return $roles;
    }
    public static function getSectionId($sectionName = "") {
        $dbh 	    = new Db();
        $session    = new LibSession();

        // Added for CUP
        $module     = $session->get("module");

        $res = $dbh->execute("SELECT id   FROM cms_sections WHERE section_alias= '$sectionName' AND module='".$module."'");
        $sections = $dbh->fetchOne($res);

        return $sections;
    }

    public static function getprivilegedMenuList($roleId,$parentRoleIDArray) {
        //echopre1($parentRoleIDArray);
        $dbh 	    = new Db();
        $session    = new LibSession();

        // Added for CUP
        $module     = $session->get("module");

        if($session->get("admin_type")=="developer"){
            $module        = "admin";
            $privileges    = "  ";
        }else {
            $privileges = Cms::getPrivileges($parentRoleIDArray);
            $userprivilege  = " AND cs.user_privilege!='dev'";
        }
        //echopre($privileges);

        //echo "SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published='Y' AND cg.module='".$module."' $privileges  $userprivilege ORDER BY position,display_order ASC";
        $res = $dbh->execute("SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published='Y' AND cg.module='".$module."' $privileges  $userprivilege ORDER BY position,display_order ASC");
        $groups = $dbh->fetchAll($res);
        $menu = array();
        foreach($groups as $group) {
            $menu[$group->group_id]->name = $group->group_name;
            $menu[$group->group_id]->sections[] = $group;
        }
        //echopre1($menu);
        return $menu;

    }
    public static function loadDefaultMenu($roleId,$parentRoleIDArray) {

        if($roleId) {
            $dbh 	 = new Db();
            $session    =   new LibSession();

            // Added for CUP
            $module     = $session->get("module");

            if($session->get("admin_type")=="developer"){
                $module        = "admin";
                $privileges    =   "  ";
            }else {
                $privileges = Cms::getPrivileges($parentRoleIDArray);
            }

            //echo "SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published='Y' AND cg.module='".$module."' $privileges  ORDER BY position,display_order ASC";
            $res = $dbh->execute("SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published='Y' AND cg.module='".$module."' $privileges  ORDER BY position,display_order ASC");
            return $groups = $dbh->fetchRow($res);
        }
        else {
            $dbh 	 = new Db();
            $session    =   new LibSession();

            // Added for CUP
            $module     = $session->get("module");

            if($session->get("admin_type")=="developer"){
                $module        = "admin";
                $privileges    =   "  ";
            }else
                $privileges    =   " AND cs.user_privilege='all' AND cg.user_privilege='all' ";

            //echo "SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published='Y' AND cg.module='".$module."' $privileges  ORDER BY position,display_order ASC";
            $res = $dbh->execute("SELECT cs.*,cg.group_name FROM cms_sections cs  LEFT JOIN cms_groups cg ON cs.group_id=cg.id WHERE cs.visibilty!='0' AND cg.published='Y' AND cg.module='".$module."' $privileges  ORDER BY position,display_order ASC");
            return $groups = $dbh->fetchRow($res);
        }
    }
     //function to get parent roles from a role id
    public static function getPrivilegedSections($parentRoleIDString = "") {
        if($parentRoleIDString!="") {
            $dbh 	 = new Db();
            $res = $dbh->execute("SELECT group_concat(entity_id)   FROM cms_privileges WHERE entity_type= 'section' AND view_role_id   IN($parentRoleIDString) ");
            $sections = $dbh->fetchOne($res);
        }
        return $sections;
    }

    public static function savePrivileges($privilegeId, $postAarray) {
         // echopre1($postAarray);
        $dbh    =   new Db();
        if(!empty($postAarray)) {
            if($privilegeId > 0) {
                $updateQuery = "UPDATE  cms_privileges set  view_role_id ='".$postAarray['view_role_id']."', add_role_id ='".$postAarray['add_role_id']."', edit_role_id='".$postAarray['edit_role_id']."', delete_role_id ='".$postAarray['delete_role_id']."', publish_role_id='".$postAarray['publish_role_id']."' WHERE privilege_id=$privilegeId";
                $res = $dbh->execute($updateQuery);
                return $res;
            }else {
                $insertQuery = "INSERT INTO cms_privileges (entity_type,entity_id, view_role_id , add_role_id , edit_role_id, delete_role_id , publish_role_id ) values('".$postAarray['entity_type']."','".$postAarray['entity_id']."','".$postAarray['view_role_id']."','".$postAarray['add_role_id']."','".$postAarray['edit_role_id']."','".$postAarray['delete_role_id']."','".$postAarray['publish_role_id']."') ";
                $res = $dbh->execute($insertQuery);
                $insert_id = $dbh->lastInsertId();
                return $insert_id;
            }
        }

    }
    public static function saveRoles($roleId, $postAarray) {
        $dbh    =   new Db();
        if(!empty($postAarray)) {
            if($roleId > 0) {
                $updateQuery = "UPDATE  cms_roles set  role_name ='".$postAarray['role_name']."', parent_role_id ='".$postAarray['parent_role_id']."' WHERE role_id=$roleId";
                $res = $dbh->execute($updateQuery);
                return $res;
            }else {
                $insertQuery = "INSERT INTO cms_roles (role_name,parent_role_id ) values('".$postAarray['role_name']."','".$postAarray['parent_role_id']."') ";
                $res = $dbh->execute($insertQuery);
                $insert_id = $dbh->lastInsertId();
                return $insert_id;
            }
        }

    }

    public static function saveUser($id, $postAarray) {
        $dbh    =   new Db();
        if(!empty($postAarray)) {
            if($id > 0) {
                $updateQuery = "UPDATE  cms_users set  username ='".$postAarray['username']."',email='".$postAarray['email']."',role_id ='".$postAarray['role_id']."' ,type ='".$postAarray['type']."' WHERE id=$id";
                $res = $dbh->execute($updateQuery);
                return $res;
            }else {
                $insertQuery = "INSERT INTO cms_users (username,password,email,role_id,type ) values('".$postAarray['username']."','".md5($postAarray['password'])."','".$postAarray['email']."','".$postAarray['role_id']."','".$postAarray['type']."') ";
                $res = $dbh->execute($insertQuery);
                $insert_id = $dbh->lastInsertId();
                return $insert_id;
            }
        }

    }

    public static function saveUserDetails($id, $postAarray) {
        $dbh    =   new Db();
        if(!empty($postAarray)) {
            if($id > 0) {
                $updateQuery = "UPDATE `".$dbh->tablePrefix."users` set
                                  user_fname       = '".$postAarray['user_fname']."',
                                  user_lname       = '".$postAarray['user_lname']."',
                                  user_address1    = '".$postAarray['user_address1']."',
                                  user_city        = '".$postAarray['user_city']."',
                                  user_zipcode     = '".$postAarray['user_zipcode']."',
                                  user_phone       = '".$postAarray['user_phone']."'
                                  WHERE `cms_user_id` = $id";
                $res = $dbh->execute($updateQuery);
                return $res;
            }else {
                $insertQuery = "INSERT INTO `".$dbh->tablePrefix."users` (user_fname,user_lname,user_address1,user_city,user_zipcode,user_phone,cms_user_id)
                values('".$postAarray['user_fname']."','".$postAarray['user_lname']."','".$postAarray['user_address1']."','".$postAarray['user_city']."','".$postAarray['user_zipcode']."','".$postAarray['user_phone']."','".$id."') ";
                $res = $dbh->execute($insertQuery);
                $insert_id = $dbh->lastInsertId();
                return $insert_id;
            }
        }

    }

    public static function changeUserPassword($id, $postAarray) {
        $dbh    =   new Db();
        if(!empty($postAarray)) {
            if($id > 0) {
                $updateQuery = "UPDATE  cms_users set  password ='".md5($postAarray['newpassword'])."' WHERE id=$id";
                $res = $dbh->execute($updateQuery);
                return $res;
            }
        }

    }

    public static function getPrivilegeDetails($privilegeId = "") {
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT *   FROM cms_privileges WHERE privilege_id=$privilegeId ");
        $sections = $dbh->fetchRow($res);

        return $sections;
    }
    public static function getPrivilegedSectionsArray($parentRoleIDString = "") {
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT entity_id   FROM cms_privileges WHERE entity_type= 'section' AND view_role_id   IN($parentRoleIDString) ");
        $sections = $dbh->fetchAll($res);

        return $sections;
    }
    public static function getSectionRoles($sectionId = "") {
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT *   FROM cms_privileges WHERE entity_type= 'section' AND entity_id=$sectionId ");
        $sections = $dbh->fetchAll($res);

        return $sections[0];
    }
    //function to get parent categoies from a category id
    public static function getPrivilegedGroups($parentRoleIDString = "") {
        if($parentRoleIDString!="") {
            $dbh 	 = new Db();
            $res = $dbh->execute("SELECT group_concat(entity_id) as entity_id   FROM cms_privileges WHERE entity_type= 'group' AND view_role_id   IN($parentRoleIDString) ");
            $sections = $dbh->fetchOne($res);
        }
        return $sections;
    }

     //function to get parent roles from a role id
    public static function getParentRoleIdArray($roleId = "",  $parentRoleIdArray) {
        $parentRoleId           =   Cms::getParentRoleId($roleId);
        if($parentRoleId!="")
            $parentRoleIdArray = array();
            $parentRoleIdArray    =   $parentRoleId;
        //$parentIdArray[]    =   $parentId;

        if($parentRoleId != 0 ) {
            return  $parentRoleId       =   Cms::getParentRoleIdArray($parentRoleId,$parentRoleIdArray);
        }
        else {

            return $parentRoleIdArray;
        }

    }
    //function to get parent roles from a role id
    public static function getParentRoleId($roleId = "") {
        $dbh 	 = new Db();
        if($roleId > 0){
            $res = $dbh->execute("SELECT parent_role_id  FROM cms_roles WHERE role_id = $roleId");
            $user = $dbh->fetchOne($res);
        }

        return $user;
    }

    //function to get roles in same hierarchy level & there roles under them from a role id
    public static function getSkipRoleList($roleId = "",$RoleIDString) {
    	$dbh 	 = new Db();
    	$childRoleIDArray = array();
    	//     	echo $RoleIDString;
      //$roleStr = $RoleIDString!=''?($roleId?$roleId:$RoleIDString):$roleId;
    	$roleStr = $RoleIDString!=''?($roleId?$RoleIDString.",".$roleId:$RoleIDString):$roleId; //echopre1($roleStr);
    	$childRoleIDArray= Cms::getChildRoleIdArray($roleId,$childRoleIDArray);
    	$childRoleIDStr = implode(',', $childRoleIDArray);
    	$roleStr = $childRoleIDStr?($roleStr?$childRoleIDStr.",".$roleStr:$childRoleIDStr):$roleStr;

    	/*$res = $dbh->execute("SELECT group_concat(role_id)  FROM cms_roles WHERE role_id
    			IN ( $roleStr )  "); */

          $res = $dbh->execute("SELECT group_concat(role_id)  FROM cms_roles WHERE role_id NOT
        			IN ( $roleStr )  ");
    			$user = $dbh->fetchOne($res);
    			$result = $RoleIDString!=''?($user?$RoleIDString.",".$user:$RoleIDString):$user;
          //$result = $RoleIDString!=''?($user?$user:$RoleIDString):$user;
    			return $result;
    }

    //function to get child roles from a role id
    			public static function getChildRoleId($roleId = 0) {
    			$dbh 	 = new Db();
    			$user = '';
    			$res = $dbh->execute("SELECT role_id  FROM cms_roles WHERE parent_role_id IN ($roleId)");
    			$user1 = $dbh->fetchAll($res);
    			foreach ($user1 as $key=>$val){
    			$user .= $val->role_id.",";
    			}
    			$user = trim($user,',');
    					return $user;
    }

    //function to get child roles from a role id
    public static function getChildRoleIdArray($roleId = 0,  $childRoleIDArray) {
        $parentRoleId           =   Cms::getChildRoleId($roleId);
        if($parentRoleId!="")
            $childRoleIDArray[]    =   $parentRoleId;
        if($parentRoleId != 0 ) {
            return  $parentRoleId       =   Cms::getChildRoleIdArray($parentRoleId,$childRoleIDArray);
        }
        else {
            return $childRoleIDArray;
        }
    }

    public static function getprivilege($sectionId = "") {
        $dbh 	  = new Db();
        $res    = $dbh->execute("SELECT * FROM `cms_privileges` ORDER BY `privilege_id` DESC");
        $privileges = $dbh->fetchAll($res);
        return $privileges;
    }

    public static function  deleteprivilege($privilegeId) {
        $dbh 	  = new Db();
        $res    = $dbh->execute("DELETE FROM `cms_privileges` WHERE privilege_id=$privilegeId");
        return $res;
    }

    public static function deleteRole($roleId){
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT role_id FROM cms_roles WHERE parent_role_id = $roleId");
        $roleExist = $dbh->fetchAll($res);
        if(count($roleExist))
            return "roleExist";

        $res = $dbh->execute("SELECT id FROM cms_users WHERE role_id = $roleId");
        $userExist = $dbh->fetchAll($res);
        if(count($userExist))
            return "userExist";
        $res = $dbh->execute("delete    FROM cms_roles where role_id=$roleId");
        return ;


    }
    public static function  checkUserExist($username,$id) {

        $dbh 	 = new Db();
        if($id)
            $res = $dbh->execute("SELECT   id FROM cms_users WHERE  username='$username' and id!= $id");
        else
            $res = $dbh->execute("SELECT   id FROM cms_users where username='$username'  ");
        $userExist = $dbh->fetchAll($res);
        return count($userExist);






    }
    public static function  deleteUser($userId) {

        $dbh 	 = new Db();

        $res = $dbh->execute("DELETE FROM `cms_users` where `id` = $userId");
        $res1 = $dbh->execute("DELETE FROM `".$dbh->tablePrefix."users` where `cms_user_id` = $userId");
        return ;


    }

    public static function getprivilegeList($page,$perPageSize) {
        if($page)
            $startPage=($page-1)*$perPageSize;
        else
            $startPage =0;
        $limit=" LIMIT $startPage,$perPageSize";
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT * FROM cms_privileges ORDER BY `privilege_id` DESC $limit ");
        $privileges = $dbh->fetchAll($res);

        return $privileges;
    }

    public static function getAllPrivileges() {

        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT * FROM `cms_privileges` ORDER BY `privilege_id` DESC");
        $privileges = $dbh->fetchAll($res);

        return $privileges;
    }

    public static function getNewSections($addedSections) {
        $dbh 	 = new Db();
        if($addedSections!="")
            $in = " where id not in ($addedSections)";
        $res = $dbh->execute("SELECT section_name,id   FROM cms_sections $in");
        $sections = $dbh->fetchAll($res);

        return $sections;
    }
    public static function getSections() {
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT section_name,id   FROM cms_sections ");
        $sections = $dbh->fetchAll($res);

        return $sections;
    }
    public static function getGroupId($sectionId) {
        if($sectionId) {
            $dbh 	 = new Db();
            $res = $dbh->execute("SELECT group_id 	   FROM cms_sections where id=$sectionId ");
            $sections = $dbh->fetchOne($res);
        }
        return $sections;
    }
    public static function getNewGroups($addedGroups) {
        $dbh 	 = new Db();
        if($addedGroups!="")
            $in = " where id not in ($addedGroups)";
        $res = $dbh->execute("SELECT group_name,id   FROM cms_groups $in");
        $groups = $dbh->fetchAll($res);

        return $groups;
    }
    public static function getGroups() {
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT group_name,id   FROM cms_groups ");
        $groups = $dbh->fetchAll($res);

        return $groups;
    }
    public static function getEntityName($entityId,$entityType) {

        $dbh 	 = new Db();
        if($entityType=='group') {
            $res = $dbh->execute("SELECT group_name    FROM cms_groups where id= $entityId");
            $name = $dbh->fetchOne($res);

            return $name;
        }
        if($entityType=='section') {
            $dbh 	 = new Db();
            $res = $dbh->execute("SELECT section_name    FROM cms_sections where id= $entityId");
            $name = $dbh->fetchOne($res);

            return $name;
        }
    }
    public static function getRoleName($roleId = "") {
        if($roleId==0)
            return "sadmin";
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT role_name    FROM cms_roles where role_id= $roleId");
        $role = $dbh->fetchOne($res);

        return $role;
    }



     public static function getRoleId($roleName = "") {
        if($roleName=="sadmin")
            return 0;
        $dbh     = new Db();
        $res = $dbh->execute("SELECT role_id FROM cms_roles where role_name= '$roleName'");
        $role = $dbh->fetchOne($res);

        return $role;
    }


     public static function getEntityId($roleName = "") {
        $dbh     = new Db();
        $res = $dbh->execute("SELECT id FROM cms_sections where section_name= '$roleName'");
        $role = $dbh->fetchOne($res);

        return $role;
    }

    public static function hasSectionPrivileges($section) {
        $session    =   new LibSession();

        $dbh 	 = new Db();
        if($session->get("admin_type")=="sadmin")
            $privileges    =   "  ";
        if($session->get("admin_type")=="admin")
            $privileges    =   " AND user_privilege='all'  ";

        $res = $dbh->execute("SELECT count(id) FROM cms_sections  WHERE 1  AND section_alias='".$section."'   $privileges  ");

        $count = $dbh->fetchOne($res);

        return $count;
    }

    public static function loadSection($request) {

        $section_alias  = $request['section'];
        $dbh 	 = new Db();
        $res 			= $dbh->execute("SELECT * FROM cms_sections where section_alias='".$section_alias."' limit 1");
        $section_data 	= $dbh->fetchRow($res);

        if(!$section_data->section_config || $section_data->section_config=='')return $section_data;
//$listData 		= Cms::listData($section_data,$request);
//$listRenderData = Cms::renderSectionListing($listData, $section_data->section_config,$request);
        return $section_data;
    }
    public static function checkLogin($username,$password,$roleEnabled) {

        $dbh 	 = new Db();
        if($roleEnabled){
            $res = $dbh->execute("SELECT id,type,role_id,module,username FROM cms_users WHERE (username='".$username."' OR email='".$username."') AND password='".$password."' AND status='active' ");
            }
        else{
            $res = $dbh->execute("SELECT id,type,module,username FROM cms_users WHERE (username='".$username."' OR email='".$username."') AND password='".$password."' AND status='active' ");
            }
        $user = $dbh->fetchRow($res);
        return $user;
    }
    public static function getSectionData($request) {

        $section_alias  = $request['section'];
        $dbh 	 = new Db();
        $res 			= $dbh->execute("SELECT * FROM cms_sections where section_alias='$section_alias' limit 1");
        $section_data 	= $dbh->fetchRow($res);

        if(!$section_data->section_config || $section_data->section_config=='')return $section_data;
//$listData 		= Cms::listData($section_data,$request);
//$listRenderData = Cms::renderSectionListing($listData, $section_data->section_config,$request);
        return $section_data;
    }
    public static function getlayoutSectionData() {

        $section_alias  = 'cms_layout';
        $dbh 	 = new Db();
        $res 			= $dbh->execute("SELECT * FROM cms_sections where section_alias='$section_alias' limit 1");
        $section_data 	= $dbh->fetchRow($res);

        if(!$section_data->section_config || $section_data->section_config=='')return $section_data;
//$listData 		= Cms::listData($section_data,$request);
//$listRenderData = Cms::renderSectionListing($listData, $section_data->section_config,$request);
        return $section_data;
    }
    public  static function getParentSectionData($request) {

        $section_alias  = $request['parent_section'];
        $dbh 	 = new Db();
        $res 			= $dbh->execute("SELECT * FROM cms_sections where section_alias='$section_alias' limit 1");
        $section_data 	= $dbh->fetchRow($res);

        if(!$section_data->section_config || $section_data->section_config=='')return $section_data;
//$listData 		= Cms::listData($section_data,$request);
//$listRenderData = Cms::renderSectionListing($listData, $section_data->section_config,$request);
        return $section_data;
    }
// Function to perform join opertaions

    public static function getJoinResult($section_data,$joinConfig,$listData) {

        $dbh            =   new Db();
        $parentColumn   =   json_decode($section_data->section_config);
        $key            =   $parentColumn->keyColumn;

        $val            =   $listData->$key;
//select
        $query          =   " SELECT ";
//get columns to retreive
        $columns        =   " count(*) AS count";
//from table (joins?)
        $from           =   " FROM ".$section_data->table_name." AS parent ";
//join clause
        $join="  JOIN $joinConfig->child_table AS child ON parent.".$joinConfig->parent_join_column."=child.".$joinConfig->child_join_column;

//where condition
        $where = " WHERE 1 AND parent.".$parentColumn->keyColumn."=$val  ";
        if($joinConfig->where)
            $where .= " AND ".$joinConfig->where." ";
//Final Query
        $query = $query.$columns.$from.$join.$where;
// resultset
        $res = $dbh->execute($query);
        $listData = $dbh->fetchOne($res);
// returning count of result
//         return $listData['count'];
        return $listData;
    }
  public static function sectionconfig($request) {
        $section_config  = $request['section'];
        $dbh     = new Db();
        $res            = $dbh->execute("SELECT * FROM cms_sections where section_alias='$section_config' limit 1");
        $section_config   = $dbh->fetchRow($res);
       return $section_config;
    }


//function for returning section listing
    public  static function listData($section_data,$request,$perPageSize) {

        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " ";
        $refVar=1;
        $combineFlag    =   0;





        foreach($section_config->combineTables as $combineTable => $combineOptions) {
            $combineFlag=0;
            foreach($combineOptions->combineColumns as $column) {
                foreach($section_config->columns as $key => $col) {
                    if($column==$key) {

                        $columns    .= " combine$refVar.".$column." AS ".$column.",";
                        $combineFlag=1;
                        if($combineOptions->isPrimaryKey) {
                            $combineReferenceColumn =$combineOptions->combineReferenceColumn;
                            $combineTableForiegnKey =$combineOptions->combineTableForiegnKey;
                        }
                        else {
                            $combineReferenceColumn =$combineOptions->combineTableForiegnKey;
                            $combineTableForiegnKey =$combineOptions->combineReferenceColumn;
                        }
                        if($request['searchField']==$column && $request['searchField']!="ALL" ) {

                            $searchText=$request['searchText'];
                            $search=" AND combine$refVar.".$request['searchField']." LIKE '%".$searchText."%'";

                        }
                        else  if( $request['searchField']=="ALL" ) {

                            $searchText=$request['searchText'];
                            $wildSearch .="OR combine$refVar.".$request['searchField']." LIKE '%".$searchText."%' ";

                        }



                    }
                }
            }
            if($combineFlag ==1) {
                $join       .=  " LEFT JOIN ". $combineTable." AS combine$refVar ON ".$section_data->table_name.".".$combineTableForiegnKey."=combine$refVar.".$combineReferenceColumn;

                if($groupBy =="")
                    $groupBy    .= " GROUP BY ";
                $groupBy    .= "  combine$refVar.".$combineReferenceColumn." ,";

            }




            $refVar++;



        }
        foreach($section_config->detailColumns as $col) {
            $columnInserted=0;
// one to one relation for combininf two tables
            if($section_config->combineTables) {

                foreach($section_config->combineTables as $combineTable => $combineOptions) {
                    $combineFlag=0;
                    foreach($combineOptions->combineColumns as $column) {

                        if($column==$col) {
                            $columnInserted =1;

                        }
                    }

                }

            }
            if($section_config->combineReferenceColumn) {
                foreach($section_config->combineReferenceColumn as $combineCol) {

                    if($combineCol==$col) {


                        $externalOptions    =   $section_config->columns->$col->externalCombineOptions;
                        $columns    .= " externalCombine$refVar.".$externalOptions->externalCombineShowColumn." AS ".$col.",";
                        $join       .=  " LEFT JOIN ". $externalOptions->externalCombineTable." AS externalCombine$refVar ON ".$section_data->table_name.".".$section_config->keyColumn."=externalCombine$refVar.".$externalOptions->externalCombineForeigenKey;


                        $combineReferenceFlag    =   1;


                    }
                }
            }




// if column is a foreign key
            if($section_config->columns->$col->external) {
                $externalOptions    =   $section_config->columns->$col->externalOptions;
                $columns    .= " external$refVar.".$externalOptions->externalShowColumn." AS ".$col.",".$section_data->table_name.".".$col." as external_$col,";
                $join       .=  " LEFT JOIN ". $externalOptions->externalTable." AS external$refVar ON external$refVar.".$externalOptions->externalColumn."=".$section_data->table_name.".".$col;
                if($request['searchField']==$col && $request['searchField']!="ALL" ) {

                    $searchText=$request['searchText'];
                    $search=" AND external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%'";

                }
                else if($request['searchField']=="ALL" ) {

                    $searchText=$request['searchText'];
                    $wildSearch .="OR external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%' ";

                }

            }

// primary table colummn
            else if($section_config->reference->referenceColumn==$col ) {

                $columns    .= $section_data->table_name.".".$col." ,";
                if($request['searchField']==$col && $request['searchField']!="ALL" ) {

                    $searchText=$request['searchText'];
                    $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%'";

                }
                else if($request['searchField']=="ALL") {
                    $searchText=$request['searchText'];
                    $wildSearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                }

            }

            else if($columnInserted==0 && !$section_config->columns->$col->customColumn) {
                $columns    .= $section_data->table_name.".".$col.",";
                if($request['searchField']==$col && $request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    if($request['searchField']==$section_config->keyColumn)
                        $search=" AND ".$section_data->table_name.".".$col." LIKE '".$searchText."' ";
                    else {

                        if($section_config->columns->$col->listoptions) {
                            $listEnumvalues = json_decode($section_config->columns->$col->listoptions->enumvalues);

                            foreach($section_config->columns->$col->listoptions->enumvalues as $lisOptionKey=>$listOptionValue) {
                                if(strtolower($listOptionValue)==strtolower($searchText))
                                    $search=" AND ".$section_data->table_name.".".$col." LIKE '".$lisOptionKey."' ";
                            }

                        }
                        else {

                            $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                        }
                    }

                }
                else if($request['searchField']=="ALL") {
//                     $searchText=mysql_real_escape_string($request['searchText']);
//                     if($request['searchField']==$section_config->keyColumn)
//                         $wildSearch .="OR ".$section_data->table_name.".".$col." LIKE '".$searchText."' ";
//                     else
//                         $wildSearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                	$searchText = $request['searchText'];

                	if (count($section_config->columns->$col->listoptions->enumvalues) != 0) {
                		//All field search for enum values[supports wild search as well as starts with] wild search is used if not specified
                		foreach ($section_config->columns->$col->listoptions->enumvalues as $lisOptionKey => $listOptionValue) {
                			$position = strpos(strtolower(trim($listOptionValue)), strtolower(trim($searchText)));
                			if (empty($section_config->columns->$col->all_search_type) && $position !== false)
                				$wildSearch .= " OR " . $section_data->table_name . "." . $col . " LIKE '" . $lisOptionKey . "' ";
                			else if ($section_config->columns->$col->all_search_type == 'starts_with' && $position === 0) {
                				$wildSearch .= " OR " . $section_data->table_name . "." . $col . " LIKE '" . $lisOptionKey . "' ";
                			}
                		}
                	} else {
                		if ($request['searchField'] == $section_config->keyColumn)
                			$wildSearch .="OR " . $section_data->table_name . "." . $col . " LIKE '" . $searchText . "' ";
                		else
                			$wildSearch .="OR " . $section_data->table_name . "." . $col . " LIKE '%" . $searchText . "%' ";
                	}
                }
            }

            $refVar++;

        }

        if($section_config->publishColumn) { //publish column
            $columns .= $section_data->table_name.".".$section_config->publishColumn;
        }
        if(!substr_count($columns, $section_data->table_name.".".$section_config->keyColumn.","))
            $columns   .= " ".$section_data->table_name.".".$section_config->keyColumn.",";
        $columns = rtrim($columns,",");
//from table (joins?)
        if($section_config->reference)
            $from = " FROM ".$section_config->reference->referenceTable." AS ".$section_config->reference->referenceTable ;
        if($section_config->filter && isset($request['parent_id']))
            $from = " FROM ".$section_config->filter->filterTable ;
        else
            $from = " FROM $section_data->table_name ";
// join

        if($section_config->reference) {

            $join .= "  JOIN ".$section_config->reference->referenceTable." AS reference ON ".$section_data->table_name.".".$section_config->reference->referenceColumn."=reference.".$section_config->reference->referenceTableForiegnKey;


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $join .= " LEFT JOIN ".$section_data->table_name." AS ".$section_data->table_name." ON ".$section_data->table_name.".".$section_config->keyColumn."=".$section_config->filter->filterTable.".".$section_config->filter->filterColumn;


        }

//        if($combineFlag ==  1) {
//            $combineOptions =   $section_config->combineOptions;
//            $join       .=  " LEFT JOIN ". $combineOptions->combineTable." AS combine ON combine.".$combineOptions->combineColumn."=".$section_data->table_name.".".$combineOptions->combineTableForiegnKey;
//
//            $groupBy    = "GROUP BY  $combineOptions->combineColumn";
//
//        }

//where condition //publish, page limit, page offset //sort
        $where = " WHERE 1   ";

//        if($section_config->where) {
//            foreach($section_config->where as $wherekey=>$whereval) {
//
//                for($whrLoop=0;$whrLoop<count($whereval);$whrLoop++) {
//                    $where .= " AND ".$section_data->table_name.".".$wherekey.$whereval[$whrLoop]."";
//                }
//
//            }
//        }
        if($section_config->where) {
            $where .= " AND ".$section_config->where." ";
        }
        if($section_config->reference) {

            $where .= " AND ".$section_data->table_name.".".$section_config->reference->referenceColumn."=".$request['parent_id'];


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $where .= " AND ".$section_data->table_name.".".$section_config->filter->filterTableForiegnKey."=".$request['parent_id'];


        }
        if($request['searchField']=="ALL") {
            $wildSearch = substr($wildSearch, 2);
            $where .=   " AND ($wildSearch) ";
        }
        if($groupBy !="") {
            $groupBy    .=" ".$section_data->table_name.".".$section_config->keyColumn.",";
            $groupBy    = substr($groupBy, 0, -1);
        }
        $section_config=json_decode($section_data->section_config);
// default ORDER BY clause
        foreach($section_config->orderBy as  $key => $value)
            $orderby=" ORDER BY ".$key." ".$value;
//  ORDER BY clause from the $_GET params
        if(isset($request['orderField']))
            $orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];
//logic for pagination
        $page=$request['page'];
// if page is not set
        if($page=="")
            $page=1;
//finding start page
        $startPage=($page-1)*$perPageSize;
        $limit=" LIMIT $startPage,$perPageSize";
//combine and execute query

        $query = $query.$columns.$from.$join.$where.$search.$groupBy.$orderby.$limit;
        Logger::info($query);
        $res = $dbh->execute($query);

        $listData = $dbh->fetchAll($res);
//return result
        return $listData;


    }
//function for get report
    public function getReport($section_data,$request,$reportStartDate,$reportEndDate) {

        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " ";
        $refVar=1;
        $combineFlag    =   0;




        foreach($section_config->combineTables as $combineTable => $combineOptions) {
            $combineFlag=0;
            foreach($combineOptions->combineColumns as $column) {
                foreach($section_config->columns as $key => $col) {
                    if($column==$key) {

                        $columns    .= " combine$refVar.".$column." AS ".$column.",";
                        $combineFlag=1;
                        if($combineOptions->isPrimaryKey) {
                            $combineReferenceColumn =$combineOptions->combineReferenceColumn;
                            $combineTableForiegnKey =$combineOptions->combineTableForiegnKey;
                        }
                        else {
                            $combineReferenceColumn =$combineOptions->combineTableForiegnKey;
                            $combineTableForiegnKey =$combineOptions->combineReferenceColumn;
                        }
                        if($request['searchField']==$column && $request['searchField']!="ALL") {

                            $searchText=$request['searchText'];
                            $search=" AND combine$refVar.".$request['searchField']." LIKE '%".$searchText."%'";

                        }
                        else if($request['searchField']=="ALL") {
                            $searchText=$request['searchText'];
                            $wildsearch .="OR combine$refVar.".$request['searchField']." LIKE '%".$searchText."%' ";
                        }


                    }
                }
            }
            if($combineFlag ==1) {
                $join       .=  " LEFT JOIN ". $combineTable." AS combine$refVar ON ".$section_data->table_name.".".$combineTableForiegnKey."=combine$refVar.".$combineReferenceColumn;

                if($groupBy =="")
                    $groupBy    .= " GROUP BY ";
                $groupBy    .= "  combine$refVar.".$combineReferenceColumn." ,";

            }




            $refVar++;



        }
        foreach($section_config->detailColumns as $col) {
            $columnInserted=0;
// one to one relation for combininf two tables
            if($section_config->combineTables) {

                foreach($section_config->combineTables as $combineTable => $combineOptions) {
                    $combineFlag=0;
                    foreach($combineOptions->combineColumns as $column) {

                        if($column==$col) {


                            $columnInserted =1;


                        }
                    }



                }



            }
            if($section_config->combineReferenceColumn) {
                foreach($section_config->combineReferenceColumn as $combineCol) {

                    if($combineCol==$col) {


                        $externalOptions    =   $section_config->columns->$col->externalCombineOptions;
                        $columns    .= " externalCombine$refVar.".$externalOptions->externalCombineShowColumn." AS ".$col.",";
                        $join       .=  " LEFT JOIN ". $externalOptions->externalCombineTable." AS externalCombine$refVar ON ".$section_data->table_name.".".$section_config->keyColumn."=externalCombine$refVar.".$externalOptions->externalCombineForeigenKey;


                        $combineReferenceFlag    =   1;


                    }
                }
            }




// if column is a foreign key
            if($section_config->columns->$col->external) {
                $externalOptions    =   $section_config->columns->$col->externalOptions;
                $columns    .= " external$refVar.".$externalOptions->externalShowColumn." AS ".$col.",".$section_data->table_name.".".$col." as external_$col,";
                $join       .=  " LEFT JOIN ". $externalOptions->externalTable." AS external$refVar ON external$refVar.".$externalOptions->externalColumn."=".$section_data->table_name.".".$col;
                if($request['searchField']==$col && $request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    $search=" AND external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%'";

                }
                else if($request['searchField']=="ALL") {
                    $searchText=$request['searchText'];
                    $wildsearch .="OR external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%' ";
                }

            }

// primary table colummn
            else if($section_config->reference->referenceColumn==$col ) {

                $columns    .= $section_data->table_name.".".$col." ,";
                if($request['searchField']==$col && $request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%'";

                }
                else if($request['searchField']=="ALL") {
                    $searchText=$request['searchText'];
                    $wildsearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                }

            }

            else if($columnInserted==0 && !$section_config->columns->$col->customColumn) {
                $columns    .= $section_data->table_name.".".$col.",";
                if($request['searchField']==$col && $request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    if($request['searchField']==$section_config->keyColumn)
                        $search=" AND ".$section_data->table_name.".".$col." LIKE '".$searchText."'";
                    else {

                        if($section_config->columns->$col->listoptions) {
                            $listEnumvalues = json_decode($section_config->columns->$col->listoptions->enumvalues);

                            foreach($section_config->columns->$col->listoptions->enumvalues as $lisOptionKey=>$listOptionValue) {
                                if(strtolower($listOptionValue)==strtolower($searchText))
                                    $search=" AND ".$section_data->table_name.".".$col." LIKE '".$lisOptionKey."' ";
                            }

                        }
                        else {

                            $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                        }
                    }


                }
                else if( $request['searchField']=="ALL") {

                    $searchText=$request['searchText'];
                    if($request['searchField']==$section_config->keyColumn)
                        $wildsearch .="OR ".$section_data->table_name.".".$col." LIKE '".$searchText."' ";
                    else
                        $wildsearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";


                }
            }

            $refVar++;

        }

        if($section_config->publishColumn) { //publish column
            $columns .= $section_data->table_name.".".$section_config->publishColumn;
        }
        if(!substr_count($columns, $section_data->table_name.".".$section_config->keyColumn.","))
            $columns   .= " ".$section_data->table_name.".".$section_config->keyColumn.",";
        $columns = rtrim($columns,",");
//from table (joins?)
        if($section_config->reference)
            $from = " FROM ".$section_config->reference->referenceTable." AS ".$section_config->reference->referenceTable ;
        if($section_config->filter && isset($request['parent_id']))
            $from = " FROM ".$section_config->filter->filterTable ;
        else
            $from = " FROM $section_data->table_name ";
// join

        if($section_config->reference) {

            $join .= "  JOIN ".$section_config->reference->referenceTable." AS reference ON ".$section_data->table_name.".".$section_config->reference->referenceColumn."=reference.".$section_config->reference->referenceTableForiegnKey;


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $join .= " LEFT JOIN ".$section_data->table_name." AS ".$section_data->table_name." ON ".$section_data->table_name.".".$section_config->keyColumn."=".$section_config->filter->filterTable.".".$section_config->filter->filterColumn;


        }

//        if($combineFlag ==  1) {
//            $combineOptions =   $section_config->combineOptions;
//            $join       .=  " LEFT JOIN ". $combineOptions->combineTable." AS combine ON combine.".$combineOptions->combineColumn."=".$section_data->table_name.".".$combineOptions->combineTableForiegnKey;
//
//            $groupBy    = "GROUP BY  $combineOptions->combineColumn";
//
//        }

//where condition //publish, page limit, page offset //sort
        $where = " WHERE 1   ";
//        if($section_config->where) {
//            foreach($section_config->where as $wherekey=>$whereval) {
//
//                for($whrLoop=0;$whrLoop<count($whereval);$whrLoop++) {
//                    $where .= " AND ".$section_data->table_name.".".$wherekey.$whereval[$whrLoop]."";
//                }
//
//            }
//        }
        if($section_config->where) {
            $where .= " AND ".$section_config->where." ";
        }

        if($section_config->report) {
            if(GLOBAL_DATE_FORMAT_SEPERATOR)
                $date_separator =  GLOBAL_DATE_FORMAT_SEPERATOR;
            else {
                $date_separator = "-";
            }


            $where .= " AND   DATE_FORMAT(".$section_data->table_name.".".$section_config->report->dateColumn.",'%Y-%m-%d')>= '".$reportStartDate."' AND DATE_FORMAT(".$section_data->table_name.".".$section_config->report->dateColumn.",'%Y-%m-%d')<= '".$reportEndDate."'";
        }
        if($section_config->reference) {

            $where .= " AND ".$section_data->table_name.".".$section_config->reference->referenceColumn."=".$request['parent_id'];


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $where .= " AND ".$section_data->table_name.".".$section_config->filter->filterTableForiegnKey."=".$request['parent_id'];


        }
        if($request['searchField']=="ALL") {
            $wildsearch = substr($wildsearch, 2);
            $where .=   " AND ($wildsearch) ";
        }
        if($groupBy !="") {
            $groupBy    .=" ".$section_data->table_name.".".$section_config->keyColumn.",";
            $groupBy    = substr($groupBy, 0, -1);
        }
        $section_config=json_decode($section_data->section_config);
// default ORDER BY clause
        foreach($section_config->orderBy as  $key => $value)
            $orderby=" ORDER BY ".$key." ".$value;
//  ORDER BY clause from the $_GET params
        if(isset($request['orderField']))
            $orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];

//combine and execute query

        $query = $query.$columns.$from.$join.$where.$search.$groupBy.$orderby;
        Logger::info($query);
        $res = $dbh->execute($query);

        $listData = $dbh->fetchAll($res);
//return result
        return $listData;


    }
    //function for returning one item details
    public  static function getRecordDetails($section_data,$request,$perPageSize) {

        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " ";
        $refVar=1;
        $combineFlag    =   0;





        foreach($section_config->combineTables as $combineTable => $combineOptions) {
            $combineFlag=0;
            foreach($combineOptions->combineColumns as $column) {
                foreach($section_config->columns as $key => $col) {
                    if($column==$key) {

                        $columns    .= " combine$refVar.".$column." AS ".$column.",";
                        $combineFlag=1;
                        if($combineOptions->isPrimaryKey) {
                            $combineReferenceColumn =$combineOptions->combineReferenceColumn;
                            $combineTableForiegnKey =$combineOptions->combineTableForiegnKey;
                        }
                        else {
                            $combineReferenceColumn =$combineOptions->combineTableForiegnKey;
                            $combineTableForiegnKey =$combineOptions->combineReferenceColumn;
                        }
                        if($request['searchField']==$column && $request['searchField']!="ALL" ) {

                            $searchText=$request['searchText'];
                            $search=" AND combine$refVar.".$request['searchField']." LIKE '%".$searchText."%'";

                        }
                        else  if( $request['searchField']=="ALL" ) {

                            $searchText=$request['searchText'];
                            $wildSearch .="OR combine$refVar.".$request['searchField']." LIKE '%".$searchText."%' ";

                        }



                    }
                }
            }
            if($combineFlag ==1) {
                $join       .=  " LEFT JOIN ". $combineTable." AS combine$refVar ON ".$section_data->table_name.".".$combineTableForiegnKey."=combine$refVar.".$combineReferenceColumn;

                if($groupBy =="")
                    $groupBy    .= " GROUP BY ";
                $groupBy    .= "  combine$refVar.".$combineReferenceColumn." ,";

            }




            $refVar++;



        }
        foreach($section_config->detailColumns as $col) {
            $columnInserted=0;
// one to one relation for combininf two tables
            if($section_config->combineTables) {

                foreach($section_config->combineTables as $combineTable => $combineOptions) {
                    $combineFlag=0;
                    foreach($combineOptions->combineColumns as $column) {

                        if($column==$col) {
                            $columnInserted =1;

                        }
                    }

                }

            }
            if($section_config->combineReferenceColumn) {
                foreach($section_config->combineReferenceColumn as $combineCol) {

                    if($combineCol==$col) {


                        $externalOptions    =   $section_config->columns->$col->externalCombineOptions;
                        $columns    .= " externalCombine$refVar.".$externalOptions->externalCombineShowColumn." AS ".$col.",";
                        $join       .=  " LEFT JOIN ". $externalOptions->externalCombineTable." AS externalCombine$refVar ON ".$section_data->table_name.".".$section_config->keyColumn."=externalCombine$refVar.".$externalOptions->externalCombineForeigenKey;


                        $combineReferenceFlag    =   1;


                    }
                }
            }




// if column is a foreign key
            if($section_config->columns->$col->external) {
                $externalOptions    =   $section_config->columns->$col->externalOptions;
                $columns    .= " external$refVar.".$externalOptions->externalShowColumn." AS ".$col.",".$section_data->table_name.".".$col." as external_$col,";
                $join       .=  " LEFT JOIN ". $externalOptions->externalTable." AS external$refVar ON external$refVar.".$externalOptions->externalColumn."=".$section_data->table_name.".".$col;
                if($request['searchField']==$col && $request['searchField']!="ALL" ) {

                    $searchText=$request['searchText'];
                    $search=" AND external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%'";

                }
                else if($request['searchField']=="ALL" ) {

                    $searchText=$request['searchText'];
                    $wildSearch .="OR external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%' ";

                }

            }

// primary table colummn
            else if($section_config->reference->referenceColumn==$col ) {

                $columns    .= $section_data->table_name.".".$col." ,";
                if($request['searchField']==$col && $request['searchField']!="ALL" ) {

                    $searchText=$request['searchText'];
                    $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%'";

                }
                else if($request['searchField']=="ALL") {
                    $searchText=$request['searchText'];
                    $wildSearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                }

            }

            else if($columnInserted==0 && !$section_config->columns->$col->customColumn) {
                $columns    .= $section_data->table_name.".".$col.",";
                if($request['searchField']==$col && $request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    if($request['searchField']==$section_config->keyColumn)
                        $search=" AND ".$section_data->table_name.".".$col." LIKE '".$searchText."' ";
                    else
                        $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";


                }
                else if($request['searchField']=="ALL") {
                    $searchText=$request['searchText'];
                    if($request['searchField']==$section_config->keyColumn)
                        $wildSearch .="OR ".$section_data->table_name.".".$col." LIKE '".$searchText."' ";
                    else
                        $wildSearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                }
            }

            $refVar++;

        }

        if($section_config->publishColumn) { //publish column
            $columns .= $section_data->table_name.".".$section_config->publishColumn;
        }
        if(!substr_count($columns, $section_data->table_name.".".$section_config->keyColumn.","))
            $columns   .= " ".$section_data->table_name.".".$section_config->keyColumn.",";
        $columns = rtrim($columns,",");
//from table (joins?)
        if($section_config->reference)
            $from = " FROM ".$section_config->reference->referenceTable." AS ".$section_config->reference->referenceTable ;
        if($section_config->filter && isset($request['parent_id']))
            $from = " FROM ".$section_config->filter->filterTable ;
        else
            $from = " FROM $section_data->table_name ";
// join

        if($section_config->reference) {

            $join .= "  JOIN ".$section_config->reference->referenceTable." AS reference ON ".$section_data->table_name.".".$section_config->reference->referenceColumn."=reference.".$section_config->reference->referenceTableForiegnKey;


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $join .= " LEFT JOIN ".$section_data->table_name." AS ".$section_data->table_name." ON ".$section_data->table_name.".".$section_config->keyColumn."=".$section_config->filter->filterTable.".".$section_config->filter->filterColumn;


        }

//        if($combineFlag ==  1) {
//            $combineOptions =   $section_config->combineOptions;
//            $join       .=  " LEFT JOIN ". $combineOptions->combineTable." AS combine ON combine.".$combineOptions->combineColumn."=".$section_data->table_name.".".$combineOptions->combineTableForiegnKey;
//
//            $groupBy    = "GROUP BY  $combineOptions->combineColumn";
//
//        }

//where condition //publish, page limit, page offset //sort
        $where = " WHERE ".$section_data->table_name.".".$section_config->keyColumn."='".$request['key']."'";

//        if($section_config->where) {
//            foreach($section_config->where as $wherekey=>$whereval) {
//
//                for($whrLoop=0;$whrLoop<count($whereval);$whrLoop++) {
//                    $where .= " AND ".$section_data->table_name.".".$wherekey.$whereval[$whrLoop]."";
//                }
//
//            }
//        }
        if($section_config->where) {
            $where .= " AND ".$section_config->where." ";
        }
        if($section_config->reference) {

            $where .= " AND ".$section_data->table_name.".".$section_config->reference->referenceColumn."=".$request['parent_id'];


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $where .= " AND ".$section_data->table_name.".".$section_config->filter->filterTableForiegnKey."=".$request['parent_id'];


        }
        if($request['searchField']=="ALL") {
            $wildSearch = substr($wildSearch, 2);
            $where .=   " AND ($wildSearch) ";
        }
        if($groupBy !="") {
            $groupBy    .=" ".$section_data->table_name.".".$section_config->keyColumn.",";
            $groupBy    = substr($groupBy, 0, -1);
        }
        $section_config=json_decode($section_data->section_config);
// default ORDER BY clause
        foreach($section_config->orderBy as  $key => $value)
            $orderby=" ORDER BY ".$key." ".$value;
//  ORDER BY clause from the $_GET params
        if(isset($request['orderField']))
            $orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];
//logic for pagination
        $page=$request['page'];
// if page is not set
        if($page=="")
            $page=1;
//finding start page
        $startPage=($page-1)*$perPageSize;
        // $limit=" LIMIT $startPage,$perPageSize";
//combine and execute query

        $query = $query.$columns.$from.$join.$where.$search.$groupBy.$orderby.$limit;
        Logger::info($query);
        $res = $dbh->execute($query);

        $listDataResults = $dbh->fetchAll($res);
        //process listData for displaying in tpl
        //   echopre($listDataResults);
        $loopVar=0;
        $listData= array();

        foreach($listDataResults  as $record) {

            foreach($section_config->detailColumns as $col) {
                foreach($section_config->columns as $key =>  $val) {

                    if($col==$key) {

                        if($val->editoptions->type   ==   "file") {
                            $record->$col   =   Cms::getThumbImage($record->$col,60,60);
                        }

                        // if it is date, then convert it into a standard format
                        if($val->editoptions->type   ==   "datepicker") {
                            $record->$col   =   Cms::getTimeFormat($record->$col,$val->editoptions->dbFormat,$val->editoptions->displayFormat);
                        }
                        else  if($val->dbFormat) {

                            $record->$col   =   Cms::getTimeFormat($record->$col,$val->dbFormat,$val->displayFormat);
                        }
                        else if($val->editoptions->type   ==   "htmlEditor") {

                            $record->$col   =   htmlspecialchars_decode($record->$col);
                            $record->$col = str_replace("&#160;", "", $record->$col);
                        }

                        else if($val->customColumn) {

                            $columnName     =   $section_config->keyColumn;
                            $primaryKeyValue =   $record->$columnName;

                            $record->$col      =  call_user_func_refined($val->customaction,$primaryKeyValue);

                            if($val->popupoptions) {
                                $functionName   =   $val->popupoptions->customaction;
                                $columnName     =   $section_config->keyColumn;
                                $params['id']         =   $record->$columnName;
                                $params['value']         =   $record->$col;

                                $externalLink   =   call_user_func_refined($functionName,$params);

                                $colValue=  substr($record->$col,0,30);

                                $record->$col =  "<a href='".$externalLink."' class='jqPopupLink btn btn-link' rel='link_".$params['id']."' >".$colValue."</a>";
                            }

                        }
                        else {
                            if(trim($record->$col)!=   "" ) {

                                if($val->externalNavigation) {
                                    $functionName   =   $val->externalNavigationOptions->source;
                                    if($val->external)
                                        $columnName     =   "external_".$key;
                                    else
                                        $columnName     =   $section_config->keyColumn;
                                    $params         =   $record->$columnName;

                                    $externalLink   =  call_user_func_refined($functionName,$params);

                                    $colValue=  substr($record->$col,0,30);

                                    $record->$col =   "<a href='".$externalLink."' target='_blank'>".$colValue."</a>";
                                }
                                else if($val->listoptions) {
                                    $functionName   =   $val->listoptions->customaction;
                                    $columnName     =   $section_config->keyColumn;
                                    $params['id']   =   $record->$columnName;
                                    $params['value']=   $record->$col;

                                    $externalLink   =  call_user_func_refined($functionName,$params);

                                    $colValue=  substr($record->$col,0,30);
                                    foreach($val->listoptions->enumvalues as $enumKey  => $enumValue) {
                                        $buttonColor  =   $val->listoptions->buttonColors->$enumKey;
                                        if($buttonColor=="green")
                                            $buttonClass  =   "btn-success";
                                        else if($buttonColor=="red")
                                            $buttonClass  =   "btn-danger";

                                        if($enumKey==$record->$col) {

                                             $record->$col =  $enumKey.'{cms_separator}<a href="'.$externalLink.'" rel="button_'.$key.':'.$enumKey.':'.$params.'" class=" jqCustom btn btn-sm '.$buttonClass.'" >'.$enumValue.'</a>';
                                        }
                                    }
                                }
                                else if($val->popupoptions) {
                                    $functionName   =   $val->popupoptions->customaction;
                                    $columnName     =   $section_config->keyColumn;
                                    $params['id']         =   $record->$columnName;
                                    $params['value']         =   $record->$col;

                                    $externalLink   =  call_user_func_refined($functionName,$params);

                                    $colValue=  substr($record->$col,0,30);

                                    $record->$col =  "<a href='".$externalLink."' class='jqPopupLink btn btn-link' rel='link_".$params['id']."' >".$colValue."</a>";


                                }
                                else if($val->decimalPoint) {
                                    $record->$col =  $val->prefix.number_format($record->$col,$val->decimalPoint).$val->postfix;
                                }
                                else
                                    $record->$col =  $val->prefix.html_entity_decode($record->$col).$val->postfix;
                            }
                            else {

                                if($val->editoptions->defaulttext) {


                                    $record->$col = '<small class="muted">'.$val->editoptions->defaulttext.'</small>';

                                }
                                else
                                    $record->$col = '<small class="muted">-</small>';
                            }
                        }
                        break;

                    }

                }
                foreach($section_config->combineColumns as $key) {
                    if($col==$key) {
                        if(trim($record->$col)!=   "" )
                            $record->$col =   $record->$col;
                        else {

                            if($val->defaulttext) {


                                $record->$col = '<small class="muted">'.$val->defaulttext.'</small>';

                            }
                            else
                                $record->$col = '<small class="muted">-</small>';
                        }
                    }

                }


            }

            $listData[]=$record;

            foreach($section_config->relations  as $key => $val) {

                $joinCount  =   Cms::getJoinResult($section_data,$val,$record);
                $listData[$loopVar]->$key   =   $joinCount;

            }


            $loopVar++;
        }
        return $listData;


    }
//function for returning section listing
    public function listItem($section_data,$request) {

        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " ";
        foreach($section_config->detailColumns as $col) {
            $columnInserted=0;
// one to one relation for combininf two tables
            if($section_config->combineTables) {

                foreach($section_config->combineTables as $combineTable => $combineOptions) {
                    $combineFlag=0;
                    foreach($combineOptions->combineColumns as $column) {

                        if($column==$col) {

                            $columns    .= " combine$refVar.".$column." AS ".$column.",";
                            $combineFlag=1;
                            $combineReferenceColumn =$combineOptions->combineReferenceColumn;
                            $columnInserted =1;


                        }
                    }
                    if($combineFlag ==1) {
                        $join       .=  " LEFT JOIN ". $combineTable." AS combine$refVar ON ".$section_data->table_name.".".$section_config->keyColumn."=combine$refVar.".$combineReferenceColumn;

                        if($groupBy =="")
                            $groupBy    .= " GROUP BY ";
                        $groupBy    .= "  combine$refVar.".$combineReferenceColumn." ,";

                    }


                }



            }
            if($section_config->combineReferenceColumn) {
                foreach($section_config->combineReferenceColumn as $combineCol) {

                    if($combineCol==$col) {


                        $externalOptions    =   $section_config->columns->$col->externalCombineOptions;
                        $columns    .= " externalCombine$refVar.".$externalOptions->externalCombineShowColumn." AS ".$col.",";
                        $join       .=  " LEFT JOIN ". $externalOptions->externalCombineTable." AS externalCombine$refVar ON ".$section_data->table_name.".".$section_config->keyColumn."=externalCombine$refVar.".$externalOptions->externalCombineForeigenKey;


                        $combineReferenceFlag    =   1;


                    }
                }
            }




// if column is a foreign key
            if($section_config->columns->$col->external) {
                $externalOptions    =   $section_config->columns->$col->externalOptions;
            	if($externalOptions->externalTable == $dbh->tablePrefix.'files')
            		$columns .= "external".$refVar.".file_mime_type,";
                $columns    .= " CONCAT(external".$refVar.".".$externalOptions->externalShowColumn.",'{valSep}', external".$refVar.".".$externalOptions->externalColumn.") AS ".$col.",";
                $join       .=  " LEFT JOIN ". $externalOptions->externalTable." AS external$refVar ON external$refVar.".$externalOptions->externalColumn."=".$section_data->table_name.".".$col;
            }

// primary table colummn
            else if($section_config->reference->referenceColumn==$col ) {

                $columns    .= $section_data->table_name.".".$col." ,";

            }

            else if($columnInserted==0 && !$section_config->columns->$col->customColumn)
                $columns    .= $section_data->table_name.".".$col.",";

            $refVar++;

        }

        $columns = rtrim($columns,",");
//from table (joins?)
        $from = " FROM $section_data->table_name ";

//where condition //publish, page limit, page offset //sort
        $where = " WHERE ".$section_data->table_name.".".$section_config->keyColumn."='".$request[$section_config->keyColumn]."'";

//combine and execute query
        $query = $query.$columns.$from.$join.$where.$search.$orderby.$limit;
        $res = $dbh->execute($query);
        $listData = $dbh->fetchAll($res);
//return result
        return $listData;


    }
//function for returning section listing
    public function listDataNumRows($section_data,$request) {

        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " ";
        $refVar=1;
        $combineFlag    =   0;
        foreach($section_config->combineTables as $combineTable => $combineOptions) {
            $combineFlag=0;
            foreach($combineOptions->combineColumns as $column) {
                foreach($section_config->columns as $key => $col) {
                    if($column==$key) {

                        $columns    .= " combine$refVar.".$column." AS ".$column.",";
                        $combineFlag=1;
                        if($combineOptions->isPrimaryKey) {
                            $combineReferenceColumn =$combineOptions->combineReferenceColumn;
                            $combineTableForiegnKey =$combineOptions->combineTableForiegnKey;
                        }
                        else {
                            $combineReferenceColumn =$combineOptions->combineTableForiegnKey;
                            $combineTableForiegnKey =$combineOptions->combineReferenceColumn;
                        }
                        if($request['searchField']==$column && $request['searchField']!="ALL") {

                            $searchText=$request['searchText'];
                            $search=" AND combine$refVar.".$request['searchField']." LIKE '%".$searchText."%'";

                        }
                        else if($request['searchField']=="ALL") {
                            $searchText=$request['searchText'];
                            $wildsearch .="OR combine$refVar.".$request['searchField']." LIKE '%".$searchText."%' ";
                        }


                    }
                }
            }
            if($combineFlag ==1) {
                $join       .=  " LEFT JOIN ". $combineTable." AS combine$refVar ON ".$section_data->table_name.".".$combineTableForiegnKey."=combine$refVar.".$combineReferenceColumn;

                if($groupBy =="")
                    $groupBy    .= " GROUP BY ";
                $groupBy    .= "  combine$refVar.".$combineReferenceColumn." ,";

            }




            $refVar++;



        }
        foreach($section_config->detailColumns as $col) {
            $columnInserted=0;
// one to one relation for combininf two tables
            if($section_config->combineTables) {

                foreach($section_config->combineTables as $combineTable => $combineOptions) {
                    $combineFlag=0;
                    foreach($combineOptions->combineColumns as $column) {

                        if($column==$col) {


                            $columnInserted =1;


                        }
                    }



                }



            }
            if($section_config->combineReferenceColumn) {
                foreach($section_config->combineReferenceColumn as $combineCol) {

                    if($combineCol==$col) {


                        $externalOptions    =   $section_config->columns->$col->externalCombineOptions;
                        $columns    .= " externalCombine$refVar.".$externalOptions->externalCombineShowColumn." AS ".$col.",";
                        $join       .=  " LEFT JOIN ". $externalOptions->externalCombineTable." AS externalCombine$refVar ON ".$section_data->table_name.".".$section_config->keyColumn."=externalCombine$refVar.".$externalOptions->externalCombineForeigenKey;


                        $combineReferenceFlag    =   1;


                    }
                }
            }




// if column is a foreign key
            if($section_config->columns->$col->external) {
                $externalOptions    =   $section_config->columns->$col->externalOptions;
                $columns    .= " external$refVar.".$externalOptions->externalShowColumn." AS ".$col.",";
                $join       .=  " LEFT JOIN ". $externalOptions->externalTable." AS external$refVar ON external$refVar.".$externalOptions->externalColumn."=".$section_data->table_name.".".$col;
                if($request['searchField']==$col &&$request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    $search=" AND external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%'";

                }
                else if ($request['searchField']=="ALL") {
                    $searchText=$request['searchText'];
                    $wildsearch .="OR  external$refVar.".$externalOptions->externalShowColumn." LIKE '%".$searchText."%' ";
                }

            }

// primary table colummn
            else if($section_config->reference->referenceColumn==$col ) {

                $columns    .= $section_data->table_name.".".$col." ,";
                if($request['searchField']==$col && $request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%'";

                }
                else if($request['searchField']=="ALL") {
                    $searchText=$request['searchText'];
                    $wildsearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                }

            }

            else if($columnInserted==0 && !$section_config->columns->$col->customColumn) {
                $columns    .= $section_data->table_name.".".$col.",";
                if($request['searchField']==$col && $request['searchField']!="ALL") {

                    $searchText=$request['searchText'];
                    if($request['searchField']==$section_config->keyColumn)
                        $search=" AND ".$section_data->table_name.".".$col." LIKE '".$searchText."'";
                    else {

                        if($section_config->columns->$col->listoptions) {
                            $listEnumvalues = json_decode($section_config->columns->$col->listoptions->enumvalues);

                            foreach($section_config->columns->$col->listoptions->enumvalues as $lisOptionKey=>$listOptionValue) {
                                if(strtolower($listOptionValue)==strtolower($searchText))
                                    $search=" AND ".$section_data->table_name.".".$col." LIKE '".$lisOptionKey."' ";

                            }

                        }
                        else {

                            $search=" AND ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                        }
                    }

                }
                else if ($request['searchField']=="ALL") {
//                     $searchText=mysql_real_escape_string($request['searchText']);
//                     if($request['searchField']==$section_config->keyColumn)
//                         $wildsearch .="OR ".$section_data->table_name.".".$col." LIKE '".$searchText."' ";
//                     else
//                         $wildsearch .="OR ".$section_data->table_name.".".$col." LIKE '%".$searchText."%' ";
                	$searchText = $request['searchText'];

                	if (count($section_config->columns->$col->listoptions->enumvalues) != 0) {
                		//All field search for enum values[supports wild search as well as starts with] wild search is used if not specified
                		foreach ($section_config->columns->$col->listoptions->enumvalues as $lisOptionKey => $listOptionValue) {
                			$position = strpos(strtolower(trim($listOptionValue)), strtolower(trim($searchText)));
                			if (empty($section_config->columns->$col->all_search_type) && $position !== false)
                				$wildsearch .= " OR " . $section_data->table_name . "." . $col . " LIKE '" . $lisOptionKey . "' ";
                			else if ($section_config->columns->$col->all_search_type == 'starts_with' && $position === 0) {
                				$wildsearch .= " OR " . $section_data->table_name . "." . $col . " LIKE '" . $lisOptionKey . "' ";
                			}
                		}
                	} else {
                		if ($request['searchField'] == $section_config->keyColumn)
                			$wildsearch .="OR " . $section_data->table_name . "." . $col . " LIKE '" . $searchText . "' ";
                		else
                			$wildsearch .="OR " . $section_data->table_name . "." . $col . " LIKE '%" . $searchText . "%' ";
                	}
                }
            }

            $refVar++;

        }


        if($section_config->publishColumn) { //publish column
            $columns .= $section_data->table_name.".".$section_config->publishColumn;
        }
        $columns = rtrim($columns,",");
//from table (joins?)
        if($section_config->reference)
            $from = " FROM ".$section_config->reference->referenceTable." AS ".$section_config->reference->referenceTable ;
        if($section_config->filter && isset($request['parent_id']))
            $from = " FROM ".$section_config->filter->filterTable ;
        else
            $from = " FROM $section_data->table_name ";
// join

        if($section_config->reference) {

            $join .= "  JOIN ".$section_config->reference->referenceTable." AS reference ON ".$section_data->table_name.".".$section_config->reference->referenceColumn."=reference.".$section_config->reference->referenceTableForiegnKey;


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $join .= " LEFT JOIN ".$section_data->table_name." AS ".$section_data->table_name." ON ".$section_data->table_name.".".$section_config->keyColumn."=".$section_config->filter->filterTable.".".$section_config->filter->filterColumn;


        }

//        if($combineFlag ==  1) {
//            $combineOptions =   $section_config->combineOptions;
//            $join       .=  " LEFT JOIN ". $combineOptions->combineTable." AS combine ON combine.".$combineOptions->combineColumn."=".$section_data->table_name.".".$combineOptions->combineTableForiegnKey;
//
//            $groupBy    = "GROUP BY  $combineOptions->combineColumn";
//
//        }

//where condition //publish, page limit, page offset //sort
        $where = " WHERE 1   ";
//        if($section_config->where) {
//            foreach($section_config->where as $wherekey=>$whereval) {
//
//                for($whrLoop=0;$whrLoop<count($whereval);$whrLoop++) {
//                    $where .= " AND ".$section_data->table_name.".".$wherekey.$whereval[$whrLoop]."";
//                }
//
//            }
//        }
        if($section_config->where) {
            $where .= " AND ".$section_config->where." ";
        }
        if($section_config->reference) {

            $where .= " AND ".$section_data->table_name.".".$section_config->reference->referenceColumn."=".$request['parent_id'];


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $where .= " AND ".$section_data->table_name.".".$section_config->filter->filterTableForiegnKey."=".$request['parent_id'];


        }

        if($request['searchField']=="ALL") {
            $wildsearch = substr($wildsearch, 2);
            $where .=   " AND ($wildsearch) ";
        }

        if($groupBy !="") {
            $groupBy    .=" ".$section_data->table_name.".".$section_config->keyColumn.",";
            $groupBy    = substr($groupBy, 0, -1);
        }
        $section_config=json_decode($section_data->section_config);


        $query = $query.$columns.$from.$join.$where.$search.$groupBy;
        Logger::info($query);
        $res = $dbh->execute($query);

        $listData = $dbh->fetchAll($res);

//returning count of results
        return count($listData);




    }
//function for returning parent section listing
    public function listParentItem($section_data,$request) {

        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        if($section_config->breadCrumbColumn!="")
            $columns = $section_config->breadCrumbColumn;
        else
            $columns = "*";

//from table (joins?)
        $from = " FROM $section_data->table_name ";

//where condition //publish, page limit, page offset //sort
        $where = " WHERE $section_config->keyColumn='".$request['parent_id']."'";

//combine and execute query
        $query = $query.$columns.$from.$where.$search.$orderby.$limit;
        $res = $dbh->execute($query);
        if($section_config->breadCrumbColumn!="") {

            $listData = $dbh->fetchRow($res);
            $breadCrumbColumns  =   explode(",",$section_config->breadCrumbColumn);
            foreach($breadCrumbColumns as $column) {
                $breadCrumb .=$listData->$column." ";
            }
            return $breadCrumb ;
        }
        else {
            $listData = $dbh->fetchOne($res);
        }
//return result
        return $listData;


    }
// finding count of resultset
    public function listDataNumRows_old($section_data,$request) {

        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " count(*) AS count ";
//from table (joins?)
//from table (joins?)
        if($section_config->reference)
            $from = " FROM ".$section_config->reference->referenceTable ;
        if($section_config->filter && isset($request['parent_id']))
            $from = " FROM ".$section_config->filter->filterTable ;
        else
            $from = " FROM $section_data->table_name ";
// join
        $where = " WHERE 1   ";
        if($section_config->reference) {

            $where .= " AND reference.".$section_config->reference->referenceTableForiegnKey."=".$request['parent_id'];


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $join .= " LEFT JOIN ".$section_data->table_name." AS ".$section_data->table_name." ON ".$section_data->table_name.".".$section_config->keyColumn."=".$section_config->filter->filterTable.".".$section_config->filter->filterColumn;


        }
// search parameters
        $search=" ";
        if($request['searchField']) {
            $searchText=$request['searchText'];
            $search=" AND ".$request['searchField']." LIKE '%".$searchText."%'";
        }

//where condition //publish, page limit, page offset //sort

        if($section_config->reference) {

            $where .= " AND ".$section_data->table_name.".".$section_config->reference->referenceColumn."=".$request['parent_id'];


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $where .= " AND ".$section_config->filter->filterTable.".".$section_config->filter->filterTableForiegnKey."=".$request['parent_id'];


        }
//combine and execute query
        $query = $query.$columns.$from.$join.$where.$search;
        $res = $dbh->execute($query);
        $rowNum = $dbh->fetchOne($res);

        Logger::info($rowNum);
//returning count of results
        return $rowNum;


    }
// finding count of resultset
    public function listDataNumRowsOld($section_data,$request) {
        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " ";
        $refVar=1;
        foreach($section_config->listColumns as $col) {

// if column is a foreign key
            if($section_config->columns->$col->external) {
                $externalOptions    =   $section_config->columns->$col->externalOptions;
                $columns    .= " external$refVar.".$externalOptions->externalShowColumn." AS ".$col.",";
                $join       .=  " LEFT JOIN ". $externalOptions->externalTable." AS external$refVar ON external$refVar.".$externalOptions->externalColumn."=".$section_data->table_name.".".$col;
            }
            else if($section_config->reference->referenceColumn==$col) {

                $columns    .= $section_data->table_name.".".$col.",";

            }
            else
                $columns    .= $section_data->table_name.".".$col.",";
            $refVar++;

        }
        if($section_config->publishColumn) { //publish column
            $columns .= $section_data->table_name.".".$section_config->publishColumn;
        }
        $columns = rtrim($columns,",");
//from table (joins?)
        if($section_config->reference)
            $from = " FROM ".$section_config->reference->referenceTable." AS ".$section_config->reference->referenceTable ;
        if($section_config->filter && isset($request['parent_id']))
            $from = " FROM ".$section_config->filter->filterTable ;
        else
            $from = " FROM $section_data->table_name ";
// join

        if($section_config->reference) {

            $join .= "  JOIN ".$section_config->reference->referenceTable." reference ON ".$section_data->table_name.".".$section_config->reference->referenceColumn."=reference.".$section_config->keyColumn;


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $join .= " LEFT JOIN ".$section_data->table_name." AS ".$section_data->table_name." ON ".$section_data->table_name.".".$section_config->keyColumn."=".$section_config->filter->filterTable.".".$section_config->filter->filterColumn;


        }
// search parameters
        $search=" ";
        if($request['searchField']) {

            $searchText=$request['searchText'];
            $search=" AND ".$request['searchField']." LIKE '%".$searchText."%'";

        }
//where condition //publish, page limit, page offset //sort
        $where = " WHERE 1   ";
        if($section_config->reference) {

            $where .= " AND ".$section_data->table_name.".".$section_config->reference->referenceColumn."=".$request['parent_id'];


        }
        if($section_config->filter && isset($request['parent_id'])) {

            $where .= " AND ".$section_data->table_name.".".$section_config->filter->filterTableForiegnKey."=".$request['parent_id'];


        }
        $section_config=json_decode($section_data->section_config);
// default ORDER BY clause
        foreach($section_config->orderBy as  $key => $value)
            $orderby=" ORDER BY ".$key." ".$value;
//  ORDER BY clause from the $_GET params
        if(isset($request['orderField']))
            $orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];


        $query = $query.$columns.$from.$join.$where.$search.$orderby;
        Logger::info($query);
        $res = $dbh->execute($query);
        $listData = $dbh->fetchAll($res);
//return result
        return count($listData);


    }
// function to get section config values
    public function getSectionListingData($section_data,$request) {
        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);
//select
        $query = " SELECT ";
//get columns to retreive
        $columns = " ";
        foreach($section_config->columns as $key => $val) $columns .= $key.",";

        $columns = rtrim($columns,",");
//from table (joins?)
        $from = " FROM $section_data->table_name ";
//where condition //publish, page limit, page offset //sort
        $where = " LIMIT 10";
//combine and execute query
        $query = $query.$columns.$from.$where;

        $res = $dbh->execute($query);
        $listData = $dbh->fetchAll($res);
        Logger::info($query);
        return $listData;
    }
    public static function getSearchableColumns($section_data) {
        $searchableColumns  =   array();
        $section_config = json_decode($section_data->section_config);
        foreach($section_config->detailColumns as $col) {

            foreach($section_config->columns as $key => $value) {
                if($key==$col) {
                    if($section_config->columns->$col->searchable) {
                        $searchableColumns[$key]=$section_config->columns->$col->name;
                    }
                }
            }



        }
        return $searchableColumns;

    }

// function to get current url using GET params
    public static function formUrl($request,$sectionConfig,$removeActionParam='0') {

        $url   = BASE_URL."cms?section=".$request['section'];
        if($request['page']!="")  $url    .=  "&page=".$request['page'];

        if($request['reportStartDate']!="")  $url    .=  "&reportStartDate=".$request['reportStartDate'];
        if($request['reportEndDate']!="")  $url    .=  "&reportEndDate=".$request['reportEndDate'];
        if($request['dateRange']!="")  $url    .=  "&dateRange=".$request['dateRange'];

        if($request['orderField']!="")  $url    .=  "&orderField=".$request['orderField']."&orderType=".$request['orderType'];
        if($request['searchField']!="") $url    .=  "&searchField=".$request['searchField']."&searchText=".$request['searchText'];
        if($removeActionParam==0) {
            if($request['action']=="edit")  $url     .=  "&action=edit&".$sectionConfig->keyColumn."=".$request[$sectionConfig->keyColumn];
            if($request['action']=="add")  $url     .=  "&action=add";
        }
        if($request['parent_section']!="") $url .=  "&parent_section=".$request['parent_section'];
        if($request['parent_section']!="") $url .=  "&parent_id=".$request['parent_id'];

        return $url;
    }
    // function to get current url using GET params
    public static function formPagingUrl($request) {

        $url   = BASE_URL."cms?section=".$request['section'];
        if($request['page']!="")  $url    .=  "&page=".$request['page'];
        if($request['orderField']!="")  $url    .=  "&orderField=".$request['orderField']."&orderType=".$request['orderType'];
        if($request['searchField']!="") $url    .=  "&searchField=".$request['searchField']."&searchText=".$request['searchText'];
        if($request['parent_section']!="") $url .=  "&parent_section=".$request['parent_section'];
        if($request['parent_section']!="") $url .=  "&parent_id=".$request['parent_id'];

        return $url;
    }
    // function to get search url using GET params
    public static function formSearchUrl($request) {

        $url   = BASE_URL."cms?section=".$request['section'];


        if($request['parent_section']!="") $url .=  "&parent_section=".$request['parent_section'];
        if($request['parent_section']!="") $url .=  "&parent_id=".$request['parent_id'];

        return $url;
    }

// function to delete an entry from listing
    public static function deleteEntry($section_data,$request) {
        $dbh 	 = new Db();
        $section_config = json_decode($section_data->section_config);

        $customActions  =   $section_config->customActions;

        //pre submit action
        if($customActions->beforeDeleteRecord) {

        	$params    = call_user_func_refined($customActions->beforeDeleteRecord,$request);

        	if($params['error']) {
        		return $params;
        	}
        }

//delete
        $query = " DELETE ";

//from table ()
        $from = " FROM $section_data->table_name ";
//where condition //publish, page limit, page offset //sort
        $where = " WHERE ".$section_config->keyColumn."=".$request[$section_config->keyColumn];
//combine and execute query
        $query = $query.$columns.$from.$where;

        $res = $dbh->execute($query);
//delete from referance table
//TODO
        if($section_config->reference) {
            $referanceQuery = " DELETE ";

//from table ()
            $referanceFrom = " FROM ".$section_config->reference->referenceTable ;
//where condition //publish, page limit, page offset //sort
            $referanceWhere = " WHERE ".$section_config->reference->referenceTableForiegnKey."=".$request['parent_id']." AND ".$section_config->reference->referenceColumn."=".$request[$section_config->keyColumn];
//combine and execute query
            $referanceQuery = $referanceQuery.$referanceFrom.$referanceWhere;

// $res = $dbh->execute($referanceQuery);

        }
        // post submit action
        if($customActions->afterDeleteRecord) {
        	$params    = call_user_func_refined($customActions->afterDeleteRecord,$request[$section_config->keyColumn],$params);
        }
          $lastInsertedId = $request[$section_config->keyColumn];
        return $lastInsertedId;

    }

//function to change publish status
    public function changePublishStatus($sectionData,$request) {
        $dbh 	 = new Db();
        $section_config = json_decode($sectionData->section_config);
        $query = "UPDATE `".$sectionData->table_name."` SET ";
        if($request['action']=="publish")
            $status=1;
        if($request['action']=="unpublish")
            $status=0;
        $columns .= "`".$section_config->publishColumn."` = ".$status;
        $where=" WHERE `".$section_config->keyColumn."` = '".$request[$section_config->keyColumn]."'";
        $querys=$query.$columns.$where;
        $res = $dbh->execute($querys);
        return true;
    }




//function to delete all datas
    public static function deleteallDatas($request) {
        $dbh     = new Db();
       // echopre1($request['tableName']);
        $query = "DELETE FROM ".$request['tableName'];

       // $columns .= $section_config->publishColumn."=".$status;
       // $where=" WHERE ".$section_config->keyColumn."=".$request[$section_config->keyColumn];
       // $query=$query.$columns.$where;
         $query=$query;
        $res = $dbh->execute($query);
        return $res;
    }


    public function formValidation_old($sectionData,$params,$request) {

        $section_config = json_decode($sectionData->section_config);
        foreach($section_config->showColumns as $col) {
            $key = $col;
            $val = $section_config->columns->$col;
            if($key!=$section_config->keyColumn) {
                foreach($val->editoptions->validations as $validations) {
                    echopre($validations);
                }

            }
        }

    }
    public static  function before($params) {

        return $params;
    }
//function to saveimage
    public static function saveImageForm($request) {

    $random = $request;
    $fileHandler = new Filehandler();
    $fileDetails = $fileHandler->handleUpload($_FILES['file'],$random);

    return $_FILES['file'];
    }


   /*  public static function updateImageForm($request,$image) {
    $image = $image;
    $random = $request;
    $dbh     = new Db();
    $fileHandler = new Filehandler();

    $fileDetails = $fileHandler->handleUpload($_FILES['file'],$random);

     $query = " UPDATE tbl_files SET ";
        $columns = "file_orig_name = '$fileDetails->file_orig_name',file_extension = '$fileDetails->file_extension', file_mime_type = '$fileDetails->file_mime_type' , file_width = '$fileDetails->file_width', file_height = '$fileDetails->file_height' , file_size = '$fileDetails->file_size' , file_path = '$fileDetails->file_path'";
        $where =" WHERE file_id=".$image;
        $query=$query.$columns.$where;
        $res = $dbh->execute($query);

    return $_FILES['file'];
    }
*/

    //function to saveimage
    public static function saveLogoForm() {
    $random = time();
    $fileHandler = new Filehandler();
    $fileDetails = $fileHandler->handleUpload($_FILES['file'],$random);

    return $fileDetails->file_path;
    }

//function to save
    public static function saveForm($sectionData,$params,$request) {
  //echopre1($params);
        $random = $params['random_key'];


        $dbh     = new Db();
        $section_config = json_decode($sectionData->section_config);
        $globalutils      = new Globalutils;
        $aliasColumn     =   $section_config->alias;
        $table           =  $sectionData->table_name;

        $customActions  =   $section_config->customActions;

//update

        if($request['action']=="edit") {

            //pre submit action
            if($customActions->beforeEditRecord) {

                $parameters    = call_user_func_refined($customActions->beforeEditRecord,$params);

                if($parameters['error']) {
                    return $parameters;
                }

            }
            if($aliasColumn!="") {
                $exclude_id = ($params[$section_config->keyColumn]>0)?$params[$section_config->keyColumn]:'';
                $alias = $globalutils->checkAndValidateEntityAlias($table,$params[$aliasColumn], $section_config->keyColumn,$exclude_id, $alias_column="alias");

            }
            $query = " UPDATE ".$sectionData->table_name." SET ";
            $loop   =   0;
              $f_j = 0;
               $f_m = 1;
            foreach($section_config->columns as $key => $val) {



                foreach($section_config->showColumns as $showColumn) {
                    if($showColumn == $key ) {

                        $combineColumn=0;
// creating alias
                        if($loop==0 && $aliasColumn!="") {
                            //$columns .=     "alias="."'".$alias."',";
                            $loop++;

                        }
                        foreach($section_config->combineTables as $combineTable => $combineOptions) {

                            foreach($combineOptions->combineColumns as $column) {

                                if($column==$key) {

                                    $combineColumn=1;
                                }
                            }
                        }
                        if($combineColumn==0) {
                            if($key!=$section_config->keyColumn) {
                                if($section_config->reference->referenceColumn==$key) {
                                     $columns .= $section_config->reference->referenceColumn."=". $request['parent_id'].",";


                                }
                                else {

                                    if($val->editoptions->type=="password" && key_exists($key, $params) ) {
                                        if($params[$key])
                                            // $columns .= $key."="."".$dbh->escapeString(md5($params[$key])).",";
                                            $columns .= $key."="."'".md5($params[$key])."',";

                                    }
                                    else if($val->editoptions->type=="file" ) {
                                        //echopre($random[$f_j]);
                                        $randomDetails = self::getRandomId($random,$f_m);
                                        if( $randomDetails != null){
                                           $fileDetails = self::getRandomimageId($randomDetails);
                                        // $fileDetails = self::getRandomimageId($random[$f_j]);
                                      //  if($_FILES[$key]['tmp_name']!="") {
                                        if($fileDetails['file_id']!=0){
                                            $fileHandler = new Filehandler();


                                            $fileHandler->allowed_extensions=  array("gif","jpg", "jpeg", "png","bmp");

                                            try {
                                               //  $random="1374321008";
                                          //   $fileDetails = $fileHandler->handleUpload($_FILES[$key]);
                                           // $fileDetails = $fileHandler->handleUpload($dataa);

                                            $fileArray["fileId"] = $dbh->escapeString($fileDetails['file_id']);
                                             $columns .= $key."=".$fileArray["fileId"].",";
                                            }catch(Exception $e) {
                                                $params['error'] = 'error';
                                                $params['errormessage'] = $e->getMessage();
                                                return $params;
                                            }

                                        }

                                    }

                                         $f_j++;$f_m++;
                                    }
                                    else if($val->editoptions->type=="autocomplete") {
                                        $autoCompleteId =   explode(":",$params["selected_".$key]);
                                        $autoCompleteId =   $autoCompleteId[0];
                                        $columns .= $key."="."".$dbh->escapeString($autoCompleteId).",";

                                    }

                                    else if($val->editoptions->type=="tags") {
                                       // print_r($params['conference_id']);
                                       // $autoCompleteId =   explode(":",$params['"selected_".$key']);
                                         $autoCompleteId = ($params['conference_id']);
                                         foreach ($params['conference_id'] as $key2 => $value2) {
                                           $tagId .= $value2['id'].",";
                                         }
                                        $tagId = rtrim($tagId,',');
                                        //$autoCompleteId =   $autoCompleteId[0];
                                        $columns .= $key."="."".$dbh->escapeString($tagId).",";

                                    }
                                    else if($val->editoptions->type=="checkbox") {
                                        if($params[$key]=="")
                                            $params[$key]   =   0;
                                        $columns .= $key."="."".$dbh->escapeString($params[$key]).",";


                                    }
                                    else if($val->editoptions->type=="datepicker") {
                                        $time = strtotime($params[$key]);
                                        if($val->editoptions->dbFormat == "date"){
                                            $params[$key] = date("Y-m-d", $time);
                                        }
                                        if($val->editoptions->dbFormat == "datetime"){
                                            $params[$key] = date("Y-m-d H:i:s", $time);
                                        }

                                        /* if($params[$key] == "" && $val->dbFormat == "date"){
                                            $params[$key]           =   date();
                                        }else{
                                            $time = strtotime("+330 minutes",strtotime($params[$key]));
                                            if($val->editoptions->dbFormat == "date"){
                                                $params[$key] = date("Y-m-d", $time);
                                            }
                                            if($val->editoptions->dbFormat == "datetime"){
                                                $params[$key] = date("Y-m-d H:i:s", $time);
                                            } */



                                            

                                            /* $datePickerDate         =   $params[$key];
                                            $date_separator =  GLOBAL_DATE_FORMAT_SEPERATOR;
                                            if($date_separator=="")
                                                $date_separator = "-";
                                            $datePickerDateArray    =   explode($date_separator, $datePickerDate);

                                             if($val->dbFormat=="date"){
                                                  if (preg_match("^\\d{1,2}/\\d{2}/\\d{4}^",$params[$key]))
                                                    {

                                                        $params[$key] = $params[$key];
                                                        $params[$key] = date('Y-m-d',strtotime($params[$key]));
                                                    }else{
                                                         $params[$key]   =  $datePickerDateArray[2]."-".$datePickerDateArray[0]."-".$datePickerDateArray[1];
                                                         $p = substr($datePickerDateArray[0], 0, strrpos($datePickerDateArray[0], ':'));

                                                         $params[$key] = date('Y-m-d',strtotime($p));
                                                    }

                                            }
                                            if($val->dbFormat=="datetime")
                                                $params[$key]   =   $datePickerDateArray[2]."-".$datePickerDateArray[0]."-".$datePickerDateArray[1]; */
                                        //}
                                        $columns .= $key."="."".$dbh->escapeString($params[$key]).",";

                                    }
                                    else if($val->editoptions->type=="hidden") {
                                         $columns  .=  $key."="."".$dbh->escapeString($params[$key]).",";
                                    }
                                    else if($key!="alias" && key_exists($key, $params) ){
                                         $columns .= $key."="."".$dbh->escapeString($params[$key]).",";
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $columns = rtrim($columns,",");
            $where=" WHERE ".$section_config->keyColumn."='".$params[$section_config->keyColumn]."'";
             $query=$query.$columns.$where;


            Logger::info($query);
            $res = $dbh->execute($query);
//$lastInsertedId =   $dbh->lastInsertId();

// insert into comine table



            if($section_config->combineTables) {

                $query      =   " update  ".$combineTable;

                $columns    =   " SET ";

                foreach($section_config->combineTables as $combineTable => $combineOptions) {

//                     $query      =   " update  ".$combineTable;

//                     $columns    =   " SET ";


                    foreach($combineOptions->combineColumns as $column) {
                        foreach($section_config->showColumns as $showColumn) {
                            if($showColumn==$column)

                                foreach($section_config->columns as $key => $val) {
                                    if($column==$key) {
                                        $updateCombineTableFlag =   1;
                                        $columns    .=  $key."="."".$dbh->escapeString($params[$key]).",";
//$values  .=   "'".mysql_real_escape_string($params[$key])."',";
                                        $combineColumn=$combineOptions->combineReferenceColumn;


                                    }
                                }
                        }
                    }
                        $where=" WHERE ".$combineColumn."='".$params[$section_config->keyColumn]."'";

                        $columns = rtrim($columns,",");

                        $query=$query.$columns.$where;
                        Logger::info($query);
                        if($updateCombineTableFlag)
                            $res = $dbh->execute($query);

//                     }

                }
            }
            $lastInsertedId = $params[$section_config->keyColumn];
            // post submit action
            if($customActions->afterEditRecord) {
                $params    = call_user_func_refined($customActions->afterEditRecord,$params[$section_config->keyColumn],$params);
            }

            return $lastInsertedId;
        }
        else {
//insert
// check for alias
//pre submit action


               // echopre($_POST['imgData'][0]);die();
              //  $imgdata = $_POST['banner_image_id'];

               /* $destination_file = $_POST['imgData'][0];*/
               /* list($type, $imgdata) = explode(';', $imgdata);
               list(, $imgdata)      = explode(',', $imgdata);
               $imgdata = str_replace(' ', '+', $imgdata);

               $imgdata = base64_decode($imgdata);

               //echopre1($destination_file);

                file_put_contents($destination_file, $imgdata);*/

               /* $destination_filetype =  getimagesize($destination_file);
                $destination_filesize =  filesize($destination_file);
                $destination_filepth =  pathinfo($destination_file); */
                $destination_filetmp =  tempnam($_POST['imgData'][0],"TMP0");

            //    echopre1(self::saveImageForm());
                $type = $_POST['imgData'][2];
                $size = $_POST['imgData'][1];
                $name = $_POST['imgData'][0];
                $tmp_name = $destination_filetmp;

                 $dataa = array( 'name' => $name,
                 'type' => $type,
                 'tmp_name' => $tmp_name,
                 'error' => 0,
                 'size' => $size
                 );

                   //  echopre1($dataa);

            if($customActions->beforeAddRecord) {

                $parameters    = call_user_func_refined($customActions->beforeAddRecord,$params);
                if($parameters['error']) {
                    return $parameters;
                }

            }
            $query      =   " INSERT INTO ".$sectionData->table_name;
            $values     =   " VALUES(";
            $columns    =   " ( ";
            $loop       =   0;
            if($aliasColumn!="") {
                $alias = $globalutils->checkAndValidateEntityAlias($table,$params[$aliasColumn], $section_config->keyColumn,"", $alias_column="alias");

            }
            $f_i = 0;
            $f_n = 1;
            foreach($section_config->columns as $key => $val) {
                foreach($section_config->showColumns as $showColumn) {
                    if($showColumn == $key ) {
                        $combineColumn=0;
// creating alias
                        if($loop==0 && $aliasColumn!="") {

                            $columns .=     "alias,";
                            $values  .=     "'".$alias."',";
                            $loop++;

                        }
                         if($section_config->combineTables) {
                            foreach($section_config->combineTables as $combineTable => $combineOptions) {

                                foreach($combineOptions->combineColumns as $column) {

                                    if($column==$key) {

                                        $combineColumn=1;
                                    }
                                }
                            }
                    }
                        if($combineColumn==0) {
                            if($key!=$section_config->keyColumn) {
                             //echo $key."---------->";  echo $section_config->reference->referenceColumn; echo "<br>";

                                if($section_config->reference->referenceColumn==$key && $key != 'school_tier_id') {
                                    //echo $key." --ddd---"; echo "<br>";
                                    $columns .= $section_config->reference->referenceColumn.",";
                                    $values  .=   $request['parent_id'].",";

                                }
                                else {
                                    //echopre($val->editoptions->type);
                                    if( $key!="alias")
                                        $columns .= $key.",";
                                    if($val->editoptions->type=="password")
                                        $values  .=   "".$dbh->escapeString(md5($params[$key])).",";
                                    // && ($_FILES[$key]['tmp_name']!="")
                                    else if($val->editoptions->type=="file") {
                                        //echo $f_i;
                                        $fileHandler = new Filehandler();
                                        $fileHandler->allowed_extensions=  array("gif","jpg", "jpeg", "png","bmp","wmv","pdf");
                                        try {
                                           // echopre($dataa);die();
                                          //   $fileDetails = $fileHandler->handleUpload($_FILES[$key]);
                                           // $fileDetails = $fileHandler->handleUpload($dataa);
                                          //   $random = "1479295355";



                                           $randomDetails = self::getRandomId($random,$f_n);

                                           $fileDetails = self::getRandomimageId($randomDetails);

                                         //getRandomimageId  echopre($fileDetails);
                                          /* if (($pos = strpos($random[$f_i], "_")) !== FALSE) {
                                                $whatIWant = substr($random[$f_i], $pos+1);
                                            }*/
                                            //$ran_f = $f_i+1;
                                           // echo "whatIWant--".$whatIWant."<br/>";
                                           // echo $f_n."<br/>";
                                            $fileArray["fileId"] = $dbh->escapeString($fileDetails['file_id']);
                                           /* echopre($random[$f_i]);
                                            if($whatIWant == $f_n){

                                                echo $fileArray["fileId"].",";
                                                $values  .=  $fileArray["fileId"].",";
                                            }else{
                                                $values  .=  "0,";
                                            }*/

                                         $values  .=  $fileArray["fileId"].",";

                                        }catch(Exception $e) {
                                            $params['error'] = 'error';
                                            $params['errormessage'] = $e->getMessage();
                                            return $params;
                                        }
                                        $f_i++;$f_n++;
                                    }
                                    else if($val->editoptions->type=="autocomplete") {
                                        $autoCompleteId =   explode(":",$params["selected_".$key]);
                                        $autoCompleteId =   $autoCompleteId[0];
                                        $values  .=   "".$dbh->escapeString($autoCompleteId).",";
                                    }

                                    else if($val->editoptions->type=="tags") {
                                   // echopre1($params['conference_id']);
                                       // $autoCompleteId =   explode(":",$params['"selected_".$key']);
                                         $autoCompleteId = ($params['conference_id']);
                                         foreach ($params['conference_id'] as $key2 => $value2) {
                                           $tagId .= $value2['id'].",";
                                         }
                                        $tagId = rtrim($tagId,',');
                                        //$autoCompleteId =   $autoCompleteId[0];
                                        $values .= "".$dbh->escapeString($tagId).",";

                                    }

                                    else if($val->editoptions->type=="checkbox") {
                                        if($params[$key]=="")
                                            $params[$key]=0;
                                        $values  .=   "".$dbh->escapeString($params[$key]).",";
                                    }
                                    else if($val->editoptions->type=="datepicker") {

                                 $time1 = substr(  $params[$key],4,11);
          
                                  $time= date("Y-m-d", strtotime($time1));
                                  

                                        if($val->editoptions->dbFormat == "date"){
                                            $params[$key] = date("Y-m-d", $time);
                                        }
                        
                                        if($val->editoptions->dbFormat == "datetime"){
                                            $params[$key] = date("Y-m-d H:i:s", $time);
                                        }

                                        /*if($params[$key]=="" && $val->dbFormat=="date"){
                                            $params[$key]           =   date();
                                        }else{
                                            $time = strtotime("+330 minutes",strtotime($params[$key]));
                                            if($val->editoptions->dbFormat == "date"){
                                                $params[$key] = date("Y-m-d", $time);
                                            }
                                            if($val->editoptions->dbFormat == "datetime"){
                                                $params[$key] = date("Y-m-d H:i:s", $time);
                                            } */



                                            /* $datePickerDate   =   $params[$key];
                                            $date_separator     =  GLOBAL_DATE_FORMAT_SEPERATOR;
                                            if($date_separator == ""){
                                                $date_separator = "-";
                                            }
                                            $datePickerDateArray = explode($date_separator, $datePickerDate);
                                            if($val->dbFormat == "date"){
                                                 $params[$key]  =  $datePickerDateArray[2]."-".$datePickerDateArray[0]."-".$datePickerDateArray[1];
                                                 $p             = substr($datePickerDateArray[0], 0, strrpos($datePickerDateArray[0], ':'));
                                                 $params[$key]  = date('Y-m-d',strtotime($p));
                                            }
                                            if($val->dbFormat=="datetime"){
                                                $params[$key]   =   $datePickerDateArray[2]."-".$datePickerDateArray[0]."-".$datePickerDateArray[1];
                                            } */
                                        //}                                                                                           //  echopre1($params[$key]);
                                        $values  .=   "".$dbh->escapeString($params[$key]).",";

                                    }
                                    else if($val->editoptions->type=="hidden") {
                                        $values  .=   "".$dbh->escapeString($params[$key]).",";
                                    }
                                    else if($key!="alias" ) {
                                        //echo "<br/>".$key."<-->".$params[$key]."<br/>Params="; echopre($params);
                                        $values  .=   "".$dbh->escapeString($params[$key]).",";
                                    }
                                }
                            }
                        }
                    }
                }

            }
            $columns = rtrim($columns,",");
            $values = rtrim($values,",");
            $values     .=  " )";
            $columns    .=  ")";
            $query=$query.$columns.$values;
            //echopre1($query);
            Logger::info($query);
            $res = $dbh->execute($query);
            $lastInsertedId =   $dbh->lastInsertId();

// insert into referance table



            if($section_config->combineTables) {

                foreach($section_config->combineTables as $combineTable => $combineOptions) {
                    $query      =   " INSERT INTO ".$combineTable;
                    $values     =   " VALUES(";
                    $columns    =   " ( ";


                    foreach($combineOptions->combineColumns as $column) {

                        foreach($section_config->columns as $key => $val) {
                            if($column==$key) {

                                $columns    .=  $key.",";
                                $values  .=   "".$dbh->escapeString($params[$key]).",";
                                $combineColumn=$combineOptions->combineReferenceColumn;


                            }
                        }
                    }
                    $columns .=$combineColumn.",";
                    $values     .=$lastInsertedId.",";
                    $columns = rtrim($columns,",");
                    $values = rtrim($values,",");
                    $values     .=  " )";
                    $columns    .=  ")";
                    $query=$query.$columns.$values;

                    Logger::info($query);
                    $res = $dbh->execute($query);





                }
            }
            // after submit action
            //pre submit action
            if($customActions->afterAddRecord) {
                $params    = call_user_func_refined($customActions->afterAddRecord,$lastInsertedId,$params);
            }
        }



        return $lastInsertedId;
    }
//function to get getBreadCrumb from url
    public function getBreadCrumb($request) {
        $html   =   '<ul class="breadcrumb">';

        $html   .=    '</ul>';
        if($request['section'])
            $html   .=   '<li class="active"><?php echo PageContext::$request["section"]; ?></li>' ;
        if($request['parent_section'])
            $html   .=   '<li><a href="#">'.PageContext::$request["parent_section"].'</a> <span class="divider">&raquo;</span></li>' ;
    }
    public static  function imageResize($width, $height, $target) {


        if ($width > $height) {
            $percentage = ($target / $width);
        } else {
            $percentage = ($target / $height);
        }


        $width = round($width * $percentage);
        $height = round($height * $percentage);


        return "width:".$width."px ;height:".$height."px";

    }
//function to get thumb image of file
   public static function getThumbImage($fileId,$width,$height) {
//         $fileName       =   Cms::getImageName($fileId);
//         $filePath       =   BASE_URL. 'project/files/'.$fileName;
//         if($fileId=="")
//             $filePath  =   BASE_URL. 'modules/cms/images/'."noImagePlaceholder.JPG";
//         if(!file_exists('project/files/'.$fileName))
//             $filePath  =   BASE_URL. 'modules/cms/images/'."missing-image.png";
//         list($originalWidth, $originalHeight) = getimagesize($filePath);
//         $dimensions =  self::imageResize($originalWidth, $originalHeight, 60);
//         return  '   <ul class="thumbnails">
//                     <li class="span">
//                     <a href="#" class="thumbnail">
//                     <img src="'.$filePath.'" style="'.$dimensions.' ">
//                     </a>
//                     </li>
//                     </ul>';
    	$fileDetails       =   Cms::getImageName($fileId);
    	$fileName = $fileDetails[0];
    	$fileType = $fileDetails[2];

    	$filePath       =   BASE_URL. 'project/files/'.$fileName;

    	if($fileId==""){
            $fileName = "erroor.jpg";
    		$fileType = "image/jpg";
    		$filePath  =   BASE_URL. 'modules/cms/images/'."noImagePlaceholder.JPG";
    	}
    	if(!file_exists('project/files/'.$fileName)){
    		$filePath  =   BASE_URL. 'modules/cms/images/'."missing-image.png";
        }
        if(file_exists('project/files/'.$fileName)){
    		$filePath  =   BASE_URL. 'project/files/'.$fileName;
        }else{
            $filePath  =   BASE_URL. 'modules/cms/images/'."noImagePlaceholder.JPG";
        }

    	list($originalWidth, $originalHeight) = getimagesize($filePath);
    	$dimensions =  self::imageResize($originalWidth, $originalHeight, 60);
    	//echo $fileType;
    	if(strstr($fileType, 'photo')!== false){
            $fileString = '<a href="'.$filePath.'" class="thumbnail" target="new">
                    <img src="'.$filePath.'" style="'.$dimensions.' ">
                    </a>';
        }else if(strstr($fileType, 'pdf')!== false){
            $fileString = '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail file-size red fa fa-file-pdf-o" target="new">
                    </a></li>
                    </ul>
                   ';
        }else if(strstr($fileType, 'video')!== false){
            $fileString = '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail file-size yellow fa fa-file-video-o" target="new">
                    </a></li>
                    </ul>
                   ';
        }else if(strstr($fileType, 'audio')!== false){
            $fileString = '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail file-size yellow fa fa-file-audio-o" target="new">
                    </a></li>
                    </ul>
                   ';
        }else if(strstr($fileType, 'excel')!== false){
            $fileString = '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail file-size blue fa fa-file-excel-o" target="new">
                    </a></li>
                    </ul>
                   ';
        }else if(strstr($fileType, 'powerpoint')!== false){
            $fileString = '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail file-size blue fa fa-file-powerpoint-o" target="new">
                    </a></li>
                    </ul>
                   ';
        }else if(strstr($fileType, 'octet-stream')!== false){
            $fileString = '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail file-size green fa fa-file-zip-o" target="new">
                    </a></li>
                    </ul>
                   ';
        }else if(strstr($fileType, 'word')!== false){
            $fileString = '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail file-size blue fa fa-file-word-o" target="new">
                    </a></li>
                    </ul>
                   ';
        }else{
            //Something other than image
            $fileString     .= '<ul class="thumbnails text-center">
                    <li class="span">
                    <a href="'.$filePath.'" class="thumbnail" target="new">
                    <img src="'.$filePath.'" style="'.$dimensions.' ">
                    </a></li>
                    </ul>';
        }
    	return $fileString ;
    }
//function to get image file path from fileid
    public static function getImageName($fileId) {

//         $dbh 	 = new Db();
//         $tableprefix    =   $dbh->tablePrefix;
//         $res        = $dbh->execute("SELECT file_path FROM  ".$tableprefix."files where file_id='$fileId' ");
//         $filePath   =   $dbh->fetchRow($res);
//         return $filePath->file_path;
    	$dbh 	 = new Db();
    	$tableprefix    =   $dbh->tablePrefix;
    	$res        = $dbh->execute("SELECT file_path,file_mime_type FROM  ".$tableprefix."files where file_id='$fileId' ");
    	$filePath   =   $dbh->fetchRow($res);
    	return array($filePath->file_path,$filePath->file_mime_type);

    }
// function to display pagination
    public static function pagination($total, $perPage  =   5, $url  =   '',$page) {
        //echo "total = ".$total;
        //echo "perPage = ".$perPage;

        $adjacents          =   "2";
        $page               =   ($page == 0 ? 1 : $page);
        $start              =   ($page - 1) * $perPage;
        $prev               =   $page - 1;
        $next               =   $page + 1;
        $lastPage           =   ceil($total/$perPage);
        $lpm1               =   $lastPage - 1;
        $pagination         =   "";
        if($lastPage > 1) {
            $pagination     .=  "<ul class='pagination'>";
            if($page>1)
                $pagination .=  "<li><a href='{$url}page=$prev'>&laquo;</a></li>";
//             if ($lastPage < 5 + ($adjacents * 2)) {
            if ($lastPage <= 5 + ($adjacents * 2)) {
                for ($counter = 1;
                $counter <= $lastPage;
                $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li><a class='current'>$counter</a></li>";
                    else
                        $pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                }
            }
            elseif($lastPage > 5 + ($adjacents * 2)) {
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1;
                    $counter < 4 + ($adjacents * 2);
                    $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                    $pagination .= "<li><a class='current'>..</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lastPage'>$lastPage</a></li>";
                }
                elseif($lastPage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li><a href='#'>..</a></li>";
                    for ($counter = $page - $adjacents;
                    $counter <= $page + $adjacents;
                    $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                    $pagination .= "<li><a class='current'>..</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lastPage'>$lastPage</a></li>";
                }
                else {
                    $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li><a href='#'>..</a></li>";
                    for ($counter = $lastPage - (2 + ($adjacents * 2));
                    $counter <= $lastPage;
                    $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                }
            }
            if ($page < $counter - 1) {
                $pagination .= "<li><a href='{$url}page=$next'>&raquo;</a></li>";

            }

            $pagination .='<li class="is-padded">Page<input type="text" name="goto" class="input goto is-padded" value="'.$page.'"> of  '.$lastPage.'</li>';
            $pagination .= "</ul>\n";
        }
//echo $pagination;exit;

        return $pagination;


    }
// function to display format
    public static function getTimeFormat($date,$dbFormat,$displayFormat) {

        if($dbFormat=="date") {
            $timeArray=explode("-",$date);

            $time=mktime(0,0,0,$timeArray[1],$timeArray[2],$timeArray[0]);
            return date($displayFormat,$time);
        }
        if($dbFormat=="time") {

            return date($displayFormat,$date);
        }
        if($dbFormat=="timestamp") {
            list($date,$time)=explode(" ", $date);
            list($year,$month,$day)=explode("-",$date);
            list($hour,$minute,$second)=explode(":",$time);

            $time=mktime($hour,$minute,$second,$month,$day,$year);
            return date($displayFormat,$time);
            //return   $newdate=$month."-".$day."-".$year." ".$time;

        }
        if($dbFormat=="datetime") {
            list($date,$time)=explode(" ", $date);
            list($year,$month,$day)=explode("-",$date);
            list($hour,$minute,$second)=explode(":",$time);

            $time=mktime($hour,$minute,$second,$month,$day,$year);
            return date($displayFormat,$time);
            //return   $newdate=$month."-".$day."-".$year." ".$time;

        }

    }
    //function to get image file path from fileid
    public static function getCmsSettings() {

        $dbh 	 = new Db();
        $tableprefix    =   $dbh->tablePrefix;
        $res        = $dbh->execute("SELECT cms_set_name,cms_set_value from  ".$tableprefix."cms_settings  ");
        $settings   =   $dbh->fetchAll($res);
        $cmsSettings = array();
        foreach($settings as $setting) {
            $cmsSettings[$setting->cms_set_name] = $setting->cms_set_value;

        }
        return $cmsSettings;

    }

    //function to get image file path from fileid
    public static function link($params) {
        $href = "www.googlec.om";
        return $href;


    }

    public static function getSettingsTableData($groupLabel,$tablename,$fieldList) {

        $dbh 	 = new Db();

        $fieldString  = implode(",",$fieldList);

        $res      = $dbh->execute("SELECT $fieldString FROM  $tablename WHERE groupLabel='$groupLabel' order by display_order ASC ");
        $settings = $dbh->fetchAll($res);

        return $settings;
    }
    public static function getTabContent($settingsArray) {
        echopre($settingsArray);

    }

    public static function getSettingsTabs($tablename,$fieldAssignmentList) {
        $tableprefix    =   $dbh->tablePrefix;
        $tablename      =   str_replace($tableprefix, "", $tablename);

        $valueField     = $fieldAssignmentList->value;
        $labelField     = $fieldAssignmentList->settingfield;

        $dbh 	 = new Db();

        $res = $dbh->execute("SELECT $valueField FROM  $tablename WHERE $labelField='groupLabelOrder'");
        $groupLabelOrder = $dbh->fetchOne($res);
        $groupLabelOrderArray = explode(",",$groupLabelOrder);
        foreach($groupLabelOrderArray as $order)
            $orderString .= "'".$order."',";
        $orderString = substr($orderString, 0,-1);
        $dbh         =   new db();
        $tableprefix    =   $dbh->tablePrefix;
        $tablename =    str_replace($tableprefix, "", $tablename);
        $settingstabs = $dbh->selectResult(trim($tablename),"distinct groupLabel"," 1 order by FIELD(groupLabel,$orderString)");
        return $settingstabs;



    }
    public static function getSettingsTabId($groupLabel) {
        //format alias
        $groupId = str_replace("&amp;", "and", $groupLabel);
        $groupId = htmlspecialchars_decode($groupId, ENT_QUOTES);
        $groupId = str_replace("-", " ", $groupId);
        $groupId = preg_replace("/[^a-zA-Z0-9\s]/", "", $groupId);
        $groupId = preg_replace('/[\r\n\s]+/xms', ' ', trim($groupId));
        $groupId = strtolower(str_replace(" ", "-", $groupId));
        return $groupId;
    }
    public static function saveSettings($postArray,$tablename,$fieldAssignmentList) {

        $dbh            =   new db();

        $valueField     = $fieldAssignmentList->value;
        $labelField     = $fieldAssignmentList->settingfield;

        foreach($postArray as $key=>$val) {
            $updateQuery   =   "UPDATE ".$tablename." SET ";
            $updateQuery   .=  "$valueField='".  addslashes($val)."' where $labelField='$key'";

           // echo  $updateQuery;

            $dbh->execute($updateQuery);
        }


    }

    public static function test($id) {

        $array['status'] = "success";
        return  $array;
        $array['status'] = "error";
        $array['message'] = "nothing";
        return $array;

    }

    public static function getAllGroups(){
        $dbh 	        = new Db();
        $res          = $dbh->execute("SELECT group_name,id FROM cms_groups WHERE `module` = 'admin'");
        $groupsArray  = $dbh->fetchAll($res);
        foreach($groupsArray as $group){
            $groupList        = new stdClass();
            $groupList->value = $group->id;
            $groupList->text  = $group->group_name;
            $groups[]         = $groupList;
        }
        return $groups;
    }

    public static function checkPassword($currentPassword,$userId){
        $dbh 	 = new Db();
        $res = $dbh->execute("SELECT `password` FROM `cms_users` WHERE `id` = $userId");
        $pass = $dbh->fetchOne($res);
        return $pass;
    }
    public static function formValidation($sectionConfig,$post,$files,$action) {

        $files = $post['file'];
        foreach($sectionConfig->detailColumns as  $col) {
            $val = $sectionConfig->columns->$col;
            if($val->editoptions) {

                $objFormElement                     =   new Formelement();

                $objFormElement->name               =   $col;

                $objFormElement->label              =   $val->editoptions->label;

                if($action  ==    "edit") {
                    if( $objFormElement->type=="hidden") {
                        if($listItem[0]->$col)
                            $objFormElement->value          =   $listItem[0]->$col;
                        else
                            $objFormElement->value          =   $val->editoptions->value;
                    } else
                        $objFormElement->value          =   $listItem[0]->$col;
                    ////$val->editoptions->value;
                }
                else if($action  ==    "add") {
                    if( $objFormElement->type=="hidden")
                        $objFormElement->value          =   $val->editoptions->value;
                    else
                        $objFormElement->value          =   $_POST[$col];//$val->editoptions->value;
                }else {
                    $objFormElement->value          =   $val->editoptions->value;
                }

                $objFormElement->validations        =   $val->editoptions->validations;

                if(isset($post)) {

                    $objFormValidation                      =   new Formvalidation();


                    if($val->editoptions->type  ==   "file") {

                        // if($val->editoptions->value=="")
                        if($action) {
                            // $response   =   $objFormValidation->validateForm($files[$col]['name'],$objFormElement->label,$objFormElement);
                             $response   =   $objFormValidation->validateForm($files,$objFormElement->label,$objFormElement);


                        }
                        else if($action ==    "edit" && $files[$col]['name']) {
                            //$response   =   $objFormValidation->validateForm($files[$col]['name'],$objFormElement->label,$objFormElement);
                            $response   =   $objFormValidation->validateForm($files,$objFormElement->label,$objFormElement);
                        }
                    }
                    else if($val->editoptions->type  ==   "password") {
                        if($action=="add") {
                            $response   =   $objFormValidation->validateForm($post[$objFormElement->name],$objFormElement->label,$objFormElement);
                        }
                    }
                    else {
                        $response   =   $objFormValidation->validateForm($post[$objFormElement->name],$objFormElement->label,$objFormElement);

                    }



                }

            }
           if($response!="")
                return $response;

        }

    }

    //function for returning report listing
    public  static function listDataReport($section_data,$request,$perPageSize,$date_separator) {

    	$dbh 	 = new Db();
    	$section_config = json_decode($section_data->section_config);

    	//get columns to retreive
    	$columns = " ";
    	$refVar=1;
    	$combineFlag    =   0;

    	$query = call_user_func_refined($section_config->dataSource->queryFunction);


    	//where condition //publish, page limit, page offset //sort
    	if(stripos($query, 'where') == FALSE)
    	{
    		$where = " WHERE 1   ";
    	}
    	else{
    		$where = " ";
    	}
    	$dateFilter = '';
    if($request['dateRange'] && $request['dateRange'] != 'all') {
    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    		$dateField = $section_config->dateField;
    		if($request['dateRange'] == 'weekly'){
    			$dotw = $dotw = date('w', strtotime($currentDate));
    			 $startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    			 $enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    		}else if($request['dateRange'] == 'monthly'){
    			$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    			$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    		}else if($request['dateRange'] == 'custom'){
    			$startdate = $request['reportStartDate'];
    			$enddate = $request['reportEndDate'];
    		}
    		$col = $section_config->columns->$dateField;
    		if($col->dbFormat == 'date'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'time'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'datetime'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'timestamp'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    	}
    	else if($section_config->defaultDateRange && $section_config->defaultDateRange != 'all' && $section_config->defaultDateRange != 'custom' && $request['dateRange'] != 'all') {

    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    		$dateField = $section_config->dateField;
    		if($section_config->defaultDateRange == 'weekly'){
    			$dotw = $dotw = date('w', strtotime($currentDate));
    			$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    			$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    		}else if($section_config->defaultDateRange == 'monthly'){
    			$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    			$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    		}else if($section_config->defaultDateRange == 'custom'){
    			//$startdate = $request['reportStartDate'];
    			//$enddate = $request['reportEndDate'];
    		}
    		$col = $section_config->columns->$dateField;
    		if($col->dbFormat == 'date'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'time'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'datetime'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'timestamp'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    	}
    	else if(!empty($section_config->dateRange) && $section_config->dateRange[0] != 'all' && $section_config->dateRange[0] != 'custom' && $request['dateRange'] != 'all' && $section_config->defaultDateRange != 'all') {

    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    			$dateField = $section_config->dateField;
    			if($section_config->dateRange[0] == 'weekly'){
    				$dotw = $dotw = date('w', strtotime($currentDate));
    				$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    				$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    			}else if($section_config->dateRange[0] == 'monthly'){
    				$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    				$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    			}else if($section_config->dateRange[0] == 'custom'){
    				//$startdate = $request['reportStartDate'];
    				//$enddate = $request['reportEndDate'];
    			}
    			$col = $section_config->columns->$dateField;
    			if($col->dbFormat == 'date'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'time'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'datetime'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'timestamp'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    	}

    	foreach($section_config->columns as $key => $col) {
    		if($request['searchField']==$key) {
    			if($col->dbFormat == 'date'){
    				$searchText=date('Y-m-d',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'time'){
    				$searchText=date('H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'datetime'){
    				$searchText=date('Y-m-d H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'timestamp'){
    				$searchText=date('Y-m-d H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->type == 'amount'){
    				$searchText=$request['searchText'];
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else{
    				$searchText=$request['searchText'];
    				$search .=   " AND (".$request['searchField']." LIKE '%".$searchText."%') ";
    			}
    		}

    	}
    	if($request['searchField']=="ALL") {
    		$wildSearch = substr($wildSearch, 2);
    		$where .=   " AND ($wildSearch) ";
    	}

    	$section_config=json_decode($section_data->section_config);
    	// default group BY clause
    	if(!empty($section_config->dataSource->groupBy)){
    		$groupBy=" GROUP BY ";
    		foreach($section_config->dataSource->groupBy as  $key => $value)
    			$groupBy.=$value." , ";

    		$groupBy =trim($groupBy,", ");
    	}
    	// default ORDER BY clause
    	if(!empty($section_config->dataSource->orderBy)){
    		$orderby=" ORDER BY ";
    		foreach($section_config->dataSource->orderBy as  $key => $value)
    			$orderby.=$key." ".$value." , ";

    		$orderby =trim($orderby,", ");
    	}
    	//  ORDER BY clause from the $_GET params
    	if(isset($request['orderField']))
    		$orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];
    	//logic for pagination
    	$page=$request['page'];
    	// if page is not set
    	if($page=="")
    		$page=1;
    	//finding start page
    	$startPage=($page-1)*$perPageSize;
    	$limit=" LIMIT $startPage,$perPageSize";
    	//combine and execute query

    	$query = $query.$where.$search.$dateFilter." ".$groupBy." ".$orderby.$limit;
    	Logger::info($query);
    	$res = $dbh->execute($query);

    	$listData = $dbh->fetchAll($res);
    	//return result
    	return $listData;


    }

    //function for returning report listing count
    public  static function listDataReportCount($section_data,$request,$date_separator) {

    	$dbh 	 = new Db();
    	$section_config = json_decode($section_data->section_config);

    	//get columns to retreive
    	$columns = " ";
    	$refVar=1;
    	$combineFlag    =   0;

    	$query = call_user_func_refined($section_config->dataSource->queryFunction);


    	//where condition //publish, page limit, page offset //sort
    	if(stripos($query, 'where') == FALSE)
    	{
    		$where = " WHERE 1   ";
    	}
    	else{
    		$where = " ";
    	}
    	$dateFilter = '';
    if($request['dateRange'] && $request['dateRange'] != 'all') {
    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    		$dateField = $section_config->dateField;
    		if($request['dateRange'] == 'weekly'){
    			$dotw = $dotw = date('w', strtotime($currentDate));
    			$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    			$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    		}else if($request['dateRange'] == 'monthly'){
    			$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    			$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    		}else if($request['dateRange'] == 'custom'){
    			$startdate = $request['reportStartDate'];
    			$enddate = $request['reportEndDate'];
    		}
    		$col = $section_config->columns->$dateField;
    		if($col->dbFormat == 'date'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'time'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'datetime'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'timestamp'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    	}
    else if($section_config->defaultDateRange && $section_config->defaultDateRange != 'all' && $section_config->defaultDateRange != 'custom' && $request['dateRange'] != 'all') {

    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    		$dateField = $section_config->dateField;
    		if($section_config->defaultDateRange == 'weekly'){
    			$dotw = $dotw = date('w', strtotime($currentDate));
    			$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    			$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    		}else if($section_config->defaultDateRange == 'monthly'){
    			$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    			$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    		}else if($section_config->defaultDateRange == 'custom'){
    			//$startdate = $request['reportStartDate'];
    			//$enddate = $request['reportEndDate'];
    		}
    		$col = $section_config->columns->$dateField;
    		if($col->dbFormat == 'date'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'time'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'datetime'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'timestamp'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    	}
    	else if(!empty($section_config->dateRange) && $section_config->dateRange[0] != 'all' && $section_config->dateRange[0] != 'custom' && $request['dateRange'] != 'all' && $section_config->defaultDateRange != 'all') {

    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    			$dateField = $section_config->dateField;
    			if($section_config->dateRange[0] == 'weekly'){
    				$dotw = $dotw = date('w', strtotime($currentDate));
    				$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    				$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    			}else if($section_config->dateRange[0] == 'monthly'){
    				$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    				$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    			}else if($section_config->dateRange[0] == 'custom'){
    				//$startdate = $request['reportStartDate'];
    				//$enddate = $request['reportEndDate'];
    			}
    			$col = $section_config->columns->$dateField;
    			if($col->dbFormat == 'date'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'time'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'datetime'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'timestamp'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    	}

    	foreach($section_config->columns as $key => $col) {
    		if($request['searchField']==$key) {
    			if($col->dbFormat == 'date'){
    				$searchText=date('Y-m-d',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'time'){
    				$searchText=date('H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'datetime'){
    				$searchText=date('Y-m-d H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'timestamp'){
    				$searchText=date('Y-m-d H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->type == 'amount'){
    				$searchText=$request['searchText'];
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else{
    				$searchText=$request['searchText'];
    				$search .=   " AND (".$request['searchField']." LIKE '%".$searchText."%') ";
    			}
    		}

    	}
    	if($request['searchField']=="ALL") {
    		$wildSearch = substr($wildSearch, 2);
    		$where .=   " AND ($wildSearch) ";
    	}

    	$section_config=json_decode($section_data->section_config);
    	// default group BY clause
    	if(!empty($section_config->dataSource->groupBy)){
    		$groupBy=" GROUP BY ";
    		foreach($section_config->dataSource->groupBy as  $key => $value)
    			$groupBy.=$value." , ";

    		$groupBy =trim($groupBy,", ");
    	}
    	// default ORDER BY clause
    	if(!empty($section_config->dataSource->orderBy)){
    		$orderby=" ORDER BY ";
    		foreach($section_config->dataSource->orderBy as  $key => $value)
    			$orderby.=$key." ".$value." , ";

    		$orderby =trim($orderby,", ");
    	}
    	//  ORDER BY clause from the $_GET params
    	if(isset($request['orderField']))
    		$orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];


    	//combine and execute query

    	$query = $query.$where.$search.$dateFilter." ".$groupBy." ".$orderby;
    	Logger::info($query);
    	$res = $dbh->execute($query);

    	$listData = $dbh->fetchAll($res);
    	//return result
    	return count($listData);


    }

    //function for get report - export
    public function getReportExport($section_data,$request,$date_separator ) {
    	$dbh 	 = new Db();
    	$section_config = json_decode($section_data->section_config);
    	//select
    	$query = " SELECT ";
    	//get columns to retreive
    	$columns = " ";
    	$refVar=1;
    	$combineFlag    =   0;

    	$query = call_user_func_refined($section_config->dataSource->queryFunction);


    	//where condition //publish, page limit, page offset //sort
    	if(stripos($query, 'where') == FALSE)
    	{
    		$where = " WHERE 1   ";
    	}
    	else{
    		$where = " ";
    	}
    	$dateFilter = '';
    if($request['dateRange'] && $request['dateRange'] != 'all') {
    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    		$dateField = $section_config->dateField;
    		if($request['dateRange'] == 'weekly'){
    			$dotw = $dotw = date('w', strtotime($currentDate));
    			$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    			$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    		}else if($request['dateRange'] == 'monthly'){
    			$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    			$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    		}else if($request['dateRange'] == 'custom'){
    			$startdate = $request['reportStartDate'];
    			$enddate = $request['reportEndDate'];
    		}
    		$col = $section_config->columns->$dateField;
    		if($col->dbFormat == 'date'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'time'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'datetime'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'timestamp'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    	}
    else if($section_config->defaultDateRange && $section_config->defaultDateRange != 'all' && $section_config->defaultDateRange != 'custom' && $request['dateRange'] != 'all') {

    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    		$dateField = $section_config->dateField;
    		if($section_config->defaultDateRange == 'weekly'){
    			$dotw = $dotw = date('w', strtotime($currentDate));
    			$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    			$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    		}else if($section_config->defaultDateRange == 'monthly'){
    			$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    			$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    		}else if($section_config->defaultDateRange == 'custom'){
    			//$startdate = $request['reportStartDate'];
    			//$enddate = $request['reportEndDate'];
    		}
    		$col = $section_config->columns->$dateField;
    		if($col->dbFormat == 'date'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (".$dateField." BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'time'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'datetime'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    		else if($col->dbFormat == 'timestamp'){
    			$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    			$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    		}
    	}
    	else if(!empty($section_config->dateRange) && $section_config->dateRange[0] != 'all' && $section_config->dateRange[0] != 'custom' && $request['dateRange'] != 'all' && $section_config->defaultDateRange != 'all') {

    		$currentDate    =   date("m".$date_separator."d".$date_separator."Y");
    			$dateField = $section_config->dateField;
    			if($section_config->dateRange[0] == 'weekly'){
    				$dotw = $dotw = date('w', strtotime($currentDate));
    				$startdate = ($dotw == 1 /* monday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('last monday', strtotime($currentDate)));
    				$enddate = ($dotw == 0 /* sunday */) ? $currentDate : date("m".$date_separator."d".$date_separator."Y",strtotime('next sunday', strtotime($currentDate)));
    			}else if($section_config->dateRange[0] == 'monthly'){
    				$startdate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),1,date("Y")));
    				$enddate =  date("m".$date_separator."d".$date_separator."Y",mktime(0,0,0,date("m"),date("t"),date("Y")));
    			//$enddate = date("m".$date_separator."d".$date_separator."Y", strtotime('last day of this month', strtotime($currentDate)));
    			}else if($section_config->dateRange[0] == 'custom'){
    				//$startdate = $request['reportStartDate'];
    				//$enddate = $request['reportEndDate'];
    			}
    			$col = $section_config->columns->$dateField;
    			if($col->dbFormat == 'date'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'time'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'datetime'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    			else if($col->dbFormat == 'timestamp'){
    				$dateRange=date('Y-m-d',strtotime($startdate));
    				$dateRange1=date('Y-m-d',strtotime($enddate));
    				$dateFilter .=   " AND (DATE_FORMAT(".$dateField.",'%Y-%m-%d') BETWEEN '".$dateRange."' AND '".$dateRange1."') ";
    			}
    	}

    	foreach($section_config->columns as $key => $col) {
    		if($request['searchField']==$key) {
    			if($col->dbFormat == 'date'){
    				$searchText=date('Y-m-d',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'time'){
    				$searchText=date('H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'datetime'){
    				$searchText=date('Y-m-d H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->dbFormat == 'timestamp'){
    				$searchText=date('Y-m-d H:i:s',strtotime($request['searchText']));
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else if($col->type == 'amount'){
    				$searchText=$request['searchText'];
    				$search .=   " AND (".$request['searchField']." = '".$searchText."') ";
    			}
    			else{
    				$searchText=$request['searchText'];
    				$search .=   " AND (".$request['searchField']." LIKE '%".$searchText."%') ";
    			}
    		}

    	}
    	if($request['searchField']=="ALL") {
    		$wildSearch = substr($wildSearch, 2);
    		$where .=   " AND ($wildSearch) ";
    	}

    	$section_config=json_decode($section_data->section_config);
    	// default group BY clause
    	if(!empty($section_config->dataSource->groupBy)){
    		$groupBy=" GROUP BY ";
    		foreach($section_config->dataSource->groupBy as  $key => $value)
    			$groupBy.=$value." , ";

    		$groupBy =trim($groupBy,", ");
    	}
    	// default ORDER BY clause
    	if(!empty($section_config->dataSource->orderBy)){
    		$orderby=" ORDER BY ";
    		foreach($section_config->dataSource->orderBy as  $key => $value)
    			$orderby.=$key." ".$value." , ";

    		$orderby =trim($orderby,", ");
    	}
    	//  ORDER BY clause from the $_GET params
    	if(isset($request['orderField']))
    		$orderby=" ORDER BY ".$request['orderField']." ".$request['orderType'];


    	//combine and execute query

    	$query = $query.$where.$search.$dateFilter." ".$groupBy." ".$orderby;
    	Logger::info($query);
    	$res = $dbh->execute($query);

    	$listData = $dbh->fetchAll($res);
    	//return result
    	return $listData;


    }

    public static function checkCurrentPassword($currentPassword,$userId) {
    	$dbh 	 = new Db();
    	$res = $dbh->execute("SELECT password FROM cms_users WHERE id = $userId");
    	$pass = $dbh->fetchOne($res);
    	return $pass;
    }

    public static function changePassword($id, $postAarray) {

       // echo $id; exit;
        $dbh    =   new Db();
        if(!empty($postAarray)) {
            if($id > 0) {
                $updateQuery = "UPDATE cms_users set password ='".md5($postAarray['newpassword'])."' WHERE id=$id";
                //echo $updateQuery; exit;
                $res = $dbh->execute($updateQuery);
                $selectQuery = "SELECT * FROM cms_users  WHERE id=$id";
                $res = $dbh->execute($selectQuery);
                $pass = $dbh->fetchRow($res);
                $resultEmail = $pass->email;
                      //  if($salesrep_id){
                $updateQuery2 = "UPDATE  tbl_clubmember set  clubmember_password ='".md5($postAarray['newpassword'])."' WHERE clubmember_email='$resultEmail'";
                $res = $dbh->execute($updateQuery2);
                        //}

                return $res;
            }
        }

    }

    // function to get parent url using GET params
    public static function formParentUrl($request) {
        $url   = BASE_URL."cms?section=".$request['parent_section'];
        return $url;

    }


    public static function setLoginSession($res,$username,$roleEnabled="") {

        $session      =   new LibSession();

        $sessionPrefix = self::getLoginSessionType($res->module);


        if($res->type   ==   "admin")
            $session->set($sessionPrefix."admin_type","admin");

        if($res->type   ==   "sadmin")
            $session->set($sessionPrefix."admin_type","sadmin");

        $session->set($sessionPrefix."admin_logged_in","1");



        $session->set($sessionPrefix."cms_username",$res->username);
        $session->set($sessionPrefix."user_id",$res->id);
        $session->set("module",$res->module);

        if($roleEnabled)
           $session->set($sessionPrefix."role_id",$res->role_id);

                $_SESSION['default_kb_user']='{"id":null,"email":"from_email_address","first_name":"Admin","last_name":"a","photos":null,"clubmember_id":"0","state":"IL","user_type":"clubmember"}';
        }



    public static function getLoginSessionType($module="") {

        $session    =   new LibSession();

        $sessionPrefix = "";
        if($module =="")
            $module = $session->get("module");

        if($module=="user")
            $sessionPrefix = "UM_";

        return $sessionPrefix;
    }

    public static function resetLoginSession(){

        $session       =   new LibSession();
        $sessionPrefix = (CUP)?"":"UM_";

        $session->set($sessionPrefix."admin_logged_in","");
        $session->set($sessionPrefix."admin_type","");
        $session->set($sessionPrefix."cms_username","");
        $session->set($sessionPrefix."user_id","");

        if(CMS_ROLES_ENABLED)
            $roleEnabled    =   1;
        if($roleEnabled){
            $session->set($sessionPrefix."role_id","");
        }

    }

      //function to get image file path from fileid
    public static function getCmscolorSettings() {

        $dbh     = new Db();
        $tableprefix    =   $dbh->tablePrefix;
        $res        = $dbh->execute("SELECT vLookUp_Value from  ".$tableprefix."lookup WHERE vLookUp_Name='bg_color'");
        $settings   =   $dbh->fetchAll($res);
        $cmscolorSettings = array();
        foreach($settings as $setting) {
            $cmscolorSettings['bg_color'] = $setting->vLookUp_Value;

        }

        return $cmscolorSettings;

    }

    public static  function getRandomimageId($r_id) {
       // echopre($r_id);
       $dbh    = new Db();
        $tableprefix    =   $dbh->tablePrefix;
        $res        = $dbh->execute("SELECT * from  ".$tableprefix."files WHERE random_key='$r_id'" );
        $settings   =   $dbh->fetchAll($res);

        $fileDetails = array();
        if($r_id!=''){
            foreach($settings as $setting) {
                $fileDetails = array('file_id' => $setting->file_id);
            }
        }else{
           $fileDetails = array('file_id' => 0);
        }
        return $fileDetails;

    }


    public static  function getRandomId($random,$id) {

        foreach($random as $random1) {
            if (($pos = strpos($random1, "_")) !== FALSE) {
                $whatIWant = substr($random1, $pos+1);
            }

            if($whatIWant == $id){
                return $random1;
            }
        }
        return null;

    }




     public static function saveAccessToken($data){

    $dbh = new Db();
    $insertQuery = "INSERT INTO cms_usertoken (user_id , accessToken , deviceType , deviceID , created_at, updated_at , status ) values('".$data['user_id']."','".$data['accesToken']."','".$data['deviceType']."','".$data['deviceID']."','".$data['created_at']."','".$data['updated_at']."','".$data['status']."') ";
    //echo $insertQuery;exit();
    $res = $dbh->execute($insertQuery);
    $insert_id = $dbh->lastInsertId();
    return $insert_id;



   }


	   public static  function authAccessToken($token){

	   	$dbh 	 = new Db();

	   		$res = $dbh->execute("SELECT ut_id,user_id,deviceType,deviceID FROM cms_usertoken WHERE accessToken='".$token."'  AND status='1' ");
	   		$user = $dbh->fetchRow($res);
	   		return $user;


	   }
	   /**
	    *
	    * Logout API call.
	    */

	   public static function removeAccessToken($token){


	   	$dbh 	 = new Db();
	   	$res = $dbh->execute("delete    FROM cms_usertoken where accessToken='$token'");
	   	return ;
	   }



}




?>
