<?php

class masterFxn extends commonFxn {

//-------------location functions starts here-------------------//
    public function addLocation() {
        if (!$this->getRequestParamByPrefix("loc_", "required", "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("loc_", "required", "", "_");

        if ($this->checkDuplicate($this->tbl_locations, "name", $para['name']) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }
        if ($this->insertQry($this->tbl_locations, $para)) {
            $this->setSuccessMsg("Location Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function updateLocation($locId) {
        if (!$para = $this->getRequestParamByPrefix("loc_", "required", "", "_"))
            return false;
        else
            $para = $this->getRequestParamByPrefix("loc_", "required", "", "_");

        if ($this->CountRecord($this->tbl_locations, " id!='" . $locId . "' and name='" . $para['name'] . "'") > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_locations, $para, array('id' => $locId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function getLocationList($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_locations;
        $qry = $this->query($query);
        while ($result = mysql_fetch_assoc($qry)) {
            if (isset($filter) && array_key_exists($result['Field'], $filter)) {

                $condition[$result['Field']] = $this->sqlEnjection($filter[$result['Field']]);
            }
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0) {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_locations, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

//-------------location functions ends here-------------------//
//-------------Qualification functions starts here-------------------//
    public function addQualification() {
        if (!$this->getRequestParamByPrefix("quali_", "required", "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("quali_", "required", "", "_");

        if ($this->checkDuplicate($this->tbl_qualification, "name", $para['name']) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }
        if ($this->insertQry($this->tbl_qualification, $para)) {
            $this->setSuccessMsg("Qualification Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function updateQualification($qualiId) {
        if (!$para = $this->getRequestParamByPrefix("quali_", "required", "", "_"))
            return false;
        else
            $para = $this->getRequestParamByPrefix("quali_", "required", "", "_");

        if ($this->CountRecord($this->tbl_qualification, " id!='" . $qualiId . "' and name='" . $para['name'] . "'") > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_qualification, $para, array('id' => $qualiId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function getQualificationList($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_qualification;
        $qry = $this->query($query);
        while ($result = mysql_fetch_assoc($qry)) {
            if (isset($filter) && array_key_exists($result['Field'], $filter)) {

                $condition[$result['Field']] = $this->sqlEnjection($filter[$result['Field']]);
            }
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0) {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_qualification, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

//-------------qualification functions ends here-------------------//
    public function getCenterList($filter = array()) {

        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';
        $in_clause = '';
        $query = "SHOW COLUMNS FROM " . $this->tbl_center;
        $qry = $this->query($query);
        while ($result = mysql_fetch_assoc($qry)) {
            if (isset($filter) && array_key_exists($result['Field'], $filter)) {

                $condition[$result['Field']] = $this->sqlEnjection($filter[$result['Field']]);
            }
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0) {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_center, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    public function getCenterListByAccess() {
        $query = "select * from " . $this->tbl_center . " where id IN(" . $_SESSION['access_center'] . ")";
        $res = $this->query($query);
        if ($res) {
            if(mysql_num_rows($res)>0)
            while ($data = mysql_fetch_assoc($res)) {
                $row[] = $data;
            }
            if (count($row) > 0)
                return json_encode($row);
            else
                return false;
        }else {
            return false;
        }
    }

    public function addCenter() {

        if (!$this->getRequestParamByPrefix("center_", "required", "")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("center_", "required", "");

        if ($this->checkDuplicate($this->tbl_center, "center_code", $para['center_code']) > 0) {
            $this->setErrorMsg("Duplicate Record Found center code must be unique!");
            return false;
        }
        if ($this->insertQry($this->tbl_center, $para)) {
            $this->setSuccessMsg("Center Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Center Details!");
            return false;
        }
    }

    public function updateCenter($centerId) {
        if (!$para = $this->getRequestParamByPrefix("center_", "required", ""))
            return false;
        else
            $para = $this->getRequestParamByPrefix("center_", "required", "");

        if ($this->CountRecord($this->tbl_center, " id!='" . $centerId . "' and center_code='" . $para['center_code'] . "'") > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_center, $para, array('id' => $centerId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    ///--------------------batch functions starts here------------------------//

    public function updatePassword($userId) {
        if (!$para = $this->getRequestParamByPrefix("password", "required", "", "_"))
            return false;
        else
            $para = $this->getRequestParamByPrefix("password", "required", "", "_");

        if ($_REQUEST['password_pwd'] != $_REQUEST['password_retype']) {
            $this->setErrorMsg("Password Do not Matched!");
            return false;
        }
        $password = $_REQUEST['password_pwd'];

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($_REQUEST['password_pwd']) < 6) {
            $this->setErrorMsg("Password should contains: ( 6 characters long | 1 uppercase char. | 1 lowercase char. | 1 numeric value. )");
            return false;
        }
        $para1['password'] = base64_encode($para['pwd']);
        unset($para);


        if ($this->updateQry($this->tbl_employee, $para1, array('id' => $userId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Details!");
            return false;
        }
    }

}

?>