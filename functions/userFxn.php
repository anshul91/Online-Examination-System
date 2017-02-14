<?php

class userFunctions extends commonFxn {

//        public function __construct() {
//            parent::construct();
//        }
    public function addUserGroup() {
        if (!$this->getRequestParamByPrefix("group_", "required")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("group_", "required");

        if ($this->checkDuplicate($this->tbl_user_group, "group_name", $para['group_name']) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->insertQry($this->tbl_user_group, $para)) {
            $this->setSuccessMsg("Group Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function updateUserGroup($groupId) {
        $para = $this->getRequestParamByPrefix("group_", "required");

        if ($this->checkDuplicate($this->tbl_user_group, "group_name", $para['group_name']) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_user_group, $para, array('id' => $groupId))) {
            $this->setSuccessMsg("Group Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function getUserGroupData($filter = array()) {

        $condition = '';
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        if (array_key_exists('id', $filter)) {
            $condition['id'] = $this->sqlEnjection($filter['id']);
        }
        if (array_key_exists('group_name', $filter) && $filter['group_name'] != '') {
            $condition['group_name'] = $this->sqlEnjection($filter['group_name']);
        }
        if (array_key_exists('group_description', $filter) && $filter['group_description'] != '') {
            $condition['group_description'] = $this->sqlEnjection($filter['group_description']);
        }

        // Group by and Order by condition
        if (array_key_exists('group_by', $filter)) {
            $groupordercondition .= " group by " . $this->sqlEnjection($filter['group_by']);
        }
        if (array_key_exists('order_by_asc', $filter)) {
            $groupordercondition .= " order by " . $this->sqlEnjection($filter['order_by_asc']) . " asc";
        }
        if (array_key_exists('order_by_dsc', $filter)) {
            $groupordercondition .= " order by " . $this->sqlEnjection($filter['order_by_dsc']) . " desc";
        }
//        if (array_key_exists('startfrom', $filter)) {
//            $limitrecord .= " limit " .  $this->sqlEnjection($filter['startfrom']) . "," . $_SESSION['recordLimit'];
//        }
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0) {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_user_group, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    //----------------User group functions ends here------------------//
    //----------------User permission functions starts---------------//

    public function getCenterList($filter = array()) {

        $condition = '';
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        if (array_key_exists('id', $filter)) {
            $condition['id'] = $this->sqlEnjection($filter['id']);
        }
        if (array_key_exists('center_loc_id', $filter)) {
            $condition['center_loc_id'] = $this->sqlEnjection($filter['center_loc_id']);
        }

        // Group by and Order by condition
        if (array_key_exists('group_by', $filter)) {
            $groupordercondition .= " group by " . $this->sqlEnjection($filter['group_by']);
        }
        if (array_key_exists('order_by_asc', $filter)) {
            $groupordercondition .= " order by " . $this->sqlEnjection($filter['order_by_asc']) . " asc";
        }
        if (array_key_exists('order_by_dsc', $filter)) {
            $groupordercondition .= " order by " . $this->sqlEnjection($filter['order_by_dsc']) . " desc";
        }
//        if (array_key_exists('startfrom', $filter)) {
//            $limitrecord .= " limit " .  $this->sqlEnjection($filter['startfrom']) . "," . $_SESSION['recordLimit'];
//        }
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0) {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_center, $columnFilter, $condition, $groupordercondition, $limitrecord);

        if ($data && count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    public function addPermission() {
       
        $chk = true;
        
//        print_r($_REQUEST);
//        die;
         if (!$this->getRequestParamByPrefix("per", '', '', "_")){
             
             return false;
         }else{
             
             $data = $this->getRequestParamByPrefix("per", '', '', "_");
         }
         
        // print_r($data);die;
        $this->query("BEGIN");
        $group_id = $this->sqlEnjection($this->decode($_REQUEST['group_id']));
        if(!isset($data['access_location']) || !isset($data['access_center']))
        {
            
            $this->setErrorMsg("Please Select At least one location and center!");
            return false;
        }
//        print_R($_REQUEST);
        
        //if group id data already present then delete it
        if ($this->checkDuplicate($this->tbl_user_permission, "group_id", $group_id) > 0)
            if (!$this->deleteData($this->tbl_user_permission, array("group_id" => $group_id))){
             
                $chk = false;
            }
        $query = "insert into " . $this->tbl_user_permission . " (group_id,role_id,can_read,can_update,can_delete) VALUES";
        $x=$u=$d = 0;
        
        $update = sizeof($data['update']);
        $delete = sizeof($data['delete']);
        
        foreach ($data['role_id'] as $v) {
//            if (isset($data['read'][$x]) && $v == $data['read'][$x]) {
                $read = '1';
  //          } else
//    //            $read = '0';
//        if($u>=$update){
//            $u=0;
//        }        
//        if($u>=$delete){
//            $d=0;
//        }
//            if (isset($data['update'][$u]) && $v == $data['update'][$u]) {
//                $update = '1';
//            } else
//                $update = '0';
//            if (isset($data['delete'][$d]) && $v == $data['delete'][$d]) {
//                $delete = '1';
//            } else
//                $delete = '0';
            $query .= "('" . $group_id . "','" . $v . "','".$read."','".$update."','".$delete."'),";
            $x++;$d++;$u++;
        }
        $query = rtrim($query, ",");
        if (!$this->query($query)){
         
            $chk = false;
        }

//        foreach ($data['read'] as $v) {
//            if (!$this->updateQry($this->tbl_user_permission, array("can_read" => '1'), array("group_id" => $group_id, "role_id" => $v)))
//                $chk = false;
//        }
        foreach ($data['update'] as $v) {
            if (!$this->updateQry($this->tbl_user_permission, array("can_update" => '1'), array("group_id" => $group_id, "role_id" => $v)))
                $chk = false;
        }
        foreach ($data['delete'] as $v) {
            if (!$this->updateQry($this->tbl_user_permission, array("can_delete" => '1'), array("group_id" => $group_id, "role_id" => $v)))
                $chk = false;
        }
        $access_locations = implode(",", $data['access_location']);
        $access_centers = implode(",", $data['access_center']);
        if (!$this->updateQry($this->tbl_user_group, array("access_location" => $access_locations, "access_center" => $access_centers), array("id" => $group_id))){
            
            $chk = false;
        }

        if ($chk){
            
            $this->query("COMMIT");
            return true;
        }
        else{
            $this->query("ROLLBACK");
            return false;
        }
    }

    public function getPermissionData($groupId, $roleId) {
        if ($groupId != '' && $roleId != '') {
            
        }
    }

    public function getPermissionDetails($data) {
        
    }

    //---------------User permission functions ends here--------------//

    public function addStudentData() {
        $para = $this->getStudentParam();
        unset($para['submit']);

        if ($this->insertQry('tbl_students', $para)) {
            echo "inserted";
        } else {
            echo "error";
        }
    }

    public function getStudentParam() {
        $paramArr = array();
        foreach ($_REQUEST as $k => $v) {
            $paramArr[$k] = $this->sqlEnjection($v);
        }
        return $paramArr;
    }

}

?>