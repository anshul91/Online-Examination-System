<?php

class studentFxn extends commonFxn {

//        public function __construct() {
//            parent::construct();
//        }
    public function addCourse() {
        $para = $this->getCourseParam();
        if ($this->insertQry($this->tbl_course, $para)) {
            $this->setSuccessMsg("Course Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting course Name!");
            return false;
        }
    }

    public function getCourseParam() {
        $param = array();
        if (isset($_REQUEST)) {
            $param['name'] = $this->sqlEnjection($_REQUEST['name']);
            return $param;
        }
    }

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

    public function getStudentList($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_student;
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

        $data = $this->selectQry($this->tbl_student, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

//getting all package which selected by a students.
    public function getStudentOptPaper($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_exm_st_select_pkg;
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

        $data = $this->selectQry($this->tbl_exm_st_select_pkg, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    public function getStudentListByAccess() {
        $query = "SELECT * from " . $this->tbl_student . " where study_center_id IN(" . $_SESSION['access_center'] . ") and batch_status='1' and is_deleted='0'";
        $res = $this->query($query);
        $row = array();
        if ($res) {
            while ($data = mysql_fetch_assoc($res)) {
                $row[] = $data;
            }

            return json_encode($row);
        } else
            return false;
    }

    public function getStuQualification($filter = array()) {

        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_stu_qualification;
        $qry = $this->query($query);
        while ($result = mysql_fetch_assoc($qry)) {
            if (isset($filter) && array_key_exists($result['Field'], $filter)) {

                $condition[$result['Field']] = $this->sqlEnjection($filter[$result['Field']]);
            }
        }
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

        $data = $this->selectQry($this->tbl_stu_qualification, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    public function addStudent() {

        $chk = true;
        $level = array();
        $discipline = array();
        $college = array();
        $specialization = array();
        $passYear = array();
        $gpa_score = array();

        if (!$this->getRequestParamByPrefix("stu_", "required", '', '_')) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("stu_", "required", '', '_');

        $level = $para['level'];
        unset($para['level']);
        $discipline = $para['discipline'];
        unset($para['discipline']);
        $college = $para['college'];
        unset($para['college']);
        $specialization = $para['specialization'];
        unset($para['specialization']);
        $passYear = $para['passYear'];
        unset($para['passYear']);
        $gpa_score = $para['gpa_score'];
        unset($para['gpa_score']);
        $error = array();
        $para['batch_join'] = implode(",", $_REQUEST['batch_join']);

        if (!filter_var($para['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Not a valid Email Id!";
        }
        if (!is_numeric($para['mobile'])) {
            $error['mobile'] = "Mobile no. must be numeric!";
        }
        if (!is_numeric($para['zipcode']))
            $error['zipcode'] = "Zipcode can be numeric only!";
        if (!is_numeric($para['home_telephone']))
            $error['home_telephone'] = "home telephone can be numeric only!";
        if (!is_numeric($para['emer_mobile']))
            $error['emer_mob'] = "Emergency mobile no. can be numeric only!";
        $str = '';
        if (count($error) > 0) {
            foreach ($error as $k => $v) {
                $str .=$v . "   |  ";
            }
            $this->setErrorMsg(rtrim($str, "|  "));
            $chk = false;
            return false;
        }

        if ($this->checkDuplicate($this->tbl_student, "email", $para['email']) > 0) {
            $this->setErrorMsg("Duplicate Email Id Found!");
            return false;
        }

        $this->begin();
        $pwd = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890");
        $para['password'] = substr($pwd, 0, 8);
        if (isset($_FILES['stu_image']) && !empty($_FILES['stu_image']['name'])) {
            if ($_FILES['stu_image']['error'] == 0) {
                if ($imgName = $this->uploadImageStu($_FILES['stu_image']['name'], $_FILES['stu_image']['tmp_name'])) {
                    $para['image'] = $imgName;

                    $chk = true;
                }
            } else {

                $chk = false;
            }
        }
        if (!$this->insertQry($this->tbl_student, $para)) {

            $chk = false;
        }
        $lst_id = mysql_insert_id();

        //Adding data if user wants to buy package of exam
        if ($para['pkg_opt'] == '1') {
            if (!$this->getRequestParamByPrefix("sel_", "required", '', '_')) {
                return false;
            } else
                $pkg = $this->getRequestParamByPrefix("sel_", "required", '', '_');
            $pkg_arr = $this->doit($pkg);

            if (!$this->addStuOptPkg($pkg_arr, $lst_id)) {
                $chk = false;
            }
        }

        //adding new student number
        $student_id = "stu/" . date("Ymd") . "/" . $lst_id;

        if (!$this->updateQry($this->tbl_student, array("student_id" => $student_id), array("id" => $lst_id))) {

            $chk = false;
        }
        for ($i = 0; $i < sizeof($level); $i++) {
            $query = "insert into " . $this->tbl_stu_qualification . " set emp_id=" . $lst_id . ",level='" . $level[$i] . "',discipline='" . $discipline[$i] . "',college='" . $college[$i] . "' ,specialization='" . $specialization[$i] . "' ,passYear='" . $passYear[$i] . "' ,gpa_score='" . $gpa_score[$i] . "'";
            if (!$this->query($query)) {

                $chk = false;
            }
        }


        if ($chk) {
            $this->query("COMMIT");

            //mail password if record inserted
            $msg = "testing message for email <br><b>username:</b>" . $para['email'] . "<br><b>password:</b>" . $para['password'];
            if (mail($para['email'], "Registered successfully!", $msg)) {
                $this->setSuccessMsg("Email Sent Successfully!");
            } else {
                $this->setErrorMsg("Email cannot be Sent!");
            }
            $this->setSuccessMsg("Record Added Successfully!");
        } else {
            $this->query("ROLLBACK");
            $this->setErrorMsg("Something Unexpected Happened! Record cannot be added!");
        }
    }

    public function updateStuOptPkg(array $pkg_id, $student_id) {
        $errors = array();
        $chk = true;
        $stu_old_pkg = array();
        $old_pkg_arr = array();
        $to_delete = array(); //to be used to get extra pkgs which were selected at add time now at update time not selected
        $to_add = array(); //new pkgs selected which to be added at update time

        if ($student_id != '') {
            $this->begin();
            $stu_old_pkg = $this->selectQry($this->tbl_exm_st_select_pkg, '*', array("stu_id" => $student_id));
            foreach ($stu_old_pkg as $k => $v) {
                $old_pkg_arr[] = $v['pkg_id'];
            }
//            echo "<pre><center>";print_R($stu_old_pkg[0]['pkg_id']);die;
            $to_delete = array_diff($old_pkg_arr, $pkg_id);
            $to_add = array_diff($pkg_id, $old_pkg_arr);

            foreach ($to_delete as $k => $v) {

                if (!$this->deleteData($this->tbl_exm_st_select_pkg, array("stu_id" => $student_id, "pkg_id" => $v))) {
                    $chk = false;
                } else {
                    if (!$this->deleteData($this->tbl_exm_stu_selected_ppr, array("st_id" => $student_id, "pkg_id" => $v))) {

                        $chk = false;
                    }
                }
            }
            $this->autoload("examFxn");
            $exmFxn = new examFxn();
            foreach ($to_add as $k => $v) {
                $duration = $this->getPkgStartEndDate($v);
                
                $pkg_pprs = json_decode($exmFxn->getPaperOfPkg(array("pkg_id" => $v)));
                foreach ($pkg_pprs as $pk => $pv) {
                    $duration_ppr = $this->getPaperStartEndDate($pv->paper_id);

                    if (!$this->insertQry($this->tbl_exm_stu_selected_ppr, array("pkg_id" => $pv->pkg_id, "ppr_id" => $pv->paper_id, "st_id" => $student_id, "start_date" => $duration_ppr['start_date'], "end_date" => $duration_ppr['end_date']))) {
                        return false;
                    }
                }
                if (!$this->insertQry($this->tbl_exm_st_select_pkg, array("pkg_id" => $v, "stu_id" => $student_id, "start_date" => $duration['start_date'], "end_date" => $duration['end_date'], "created_by" => $_SESSION['id'], "created" => date('Y-m-d H:i:s')))) {
                    $chk = false;
                }
            }
            if ($chk) {
                $this->commit();
                return true;
            } else {
                $this->rollback();
                return false;
            }
        }
    }

    public function addStuOptPkg(array $pkg_id, $student_id) {
        $errors = array();
        $chk = true;
        if ($student_id != '') {
            foreach ($pkg_id as $k => $v) {
//                if($this->CountRecord($this->tbl_exm_st_select_pkg, array("pkg_id"=>$v,"stu_id"=>$student_id))>0)
//                {
//                    $this->setErrorMsg("this Package is already purchased by you!");
//                    return false;
//                }
                $duration = $this->getPkgStartEndDate($v);

                if ($this->addStuOptPaper($v, $student_id)) {
                    if (!$this->insertQry($this->tbl_exm_st_select_pkg, array("pkg_id" => $v, "stu_id" => $student_id, "start_date" => $duration['start_date'], "end_date" => $duration['end_date'], "created_by" => $_SESSION['id'], "created" => date('Y-m-d H:i:s')))) {
                        $this->setErrorMsg("Package not added!");
                        return false;
                    }
                } else {
                    return false;
                }
                return true;
            }
        }
    }

    public function addStuOptPaper($pkg_id, $student_id) {
        $errors = array();
        $chk = true;
        $this->autoload("examFxn");
        $exmFxn = new examFxn();
        if ($student_id != '' && $pkg_id != '') {
            $pkg_pprs = json_decode($exmFxn->getPaperOfPkg(array("pkg_id" => $pkg_id)));
            foreach ($pkg_pprs as $k => $v) {
                $duration = $this->getPaperStartEndDate($v->paper_id);

                if (!$this->insertQry($this->tbl_exm_stu_selected_ppr, array("pkg_id" => $pkg_id, "ppr_id" => $v->paper_id, "st_id" => $student_id, "start_date" => $duration['start_date'], "end_date" => $duration['end_date']))) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function getPaperStartEndDate($paper_id) {
        $pprData = $this->selectQry($this->tbl_papers, '*', array("id" => $paper_id));
        $duration = $pprData[0]['ppr_view_duration'];
        $returnDate['start_date'] = date('Y-m-d H:i:s');
        $returnDate['end_date'] = date('Y-m-d H:i:s', strtotime("+ " . $duration . "days"));
        return $returnDate;
    }

    public function getPkgStartEndDate($pkg_id) {
        $pkgData = $this->selectQry($this->tbl_package, '*', array("id" => $pkg_id));
        $duration = $pkgData[0]['duration_in_days'];
        $returnDate['start_date'] = date('Y-m-d H:i:s');
        $returnDate['end_date'] = date('Y-m-d H:i:s', strtotime("+ " . $duration . "days"));
        
        return $returnDate;
    }

    public function updateStudent($studentId) {
        $chk = true;
        $level = array();
        $discipline = array();
        $college = array();
        $specialization = array();
        $passYear = array();
        $gpa_score = array();

        if (!$this->getRequestParamByPrefix("stu_", "required", '', '_')) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("stu_", "required", '', '_');

        $level = $para['level'];
        unset($para['level']);
        $discipline = $para['discipline'];
        unset($para['discipline']);
        $college = $para['college'];
        unset($para['college']);
        $specialization = $para['specialization'];
        unset($para['specialization']);
        $passYear = $para['passYear'];
        unset($para['passYear']);
        $gpa_score = $para['gpa_score'];
        unset($para['gpa_score']);
        $error = array();
        if ($_REQUEST['batch_join'] == '') {
            $error['batch_join'] = "batch cannot be empty!";
        } else {
            $para['batch_join'] = implode(",", $_REQUEST['batch_join']);
        }
        if (!filter_var($para['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Not a valid Email Id!";
        }
//        if(!is_numeric($gpa_score['gpa_score'])){
//            $error['gpa'] = "GPA/Score must be numeric";
//        }
        if (!is_numeric($para['mobile'])) {
            $error['mobile'] = "Mobile no. must be numeric!";
        }
        if (!is_numeric($para['zipcode']))
            $error['zipcode'] = "Zipcode can be numeric only!";
        if (!is_numeric($para['home_telephone']))
            $error['home_telephone'] = "home telephone can be numeric only!";
        if (!is_numeric($para['emer_mobile']))
            $error['emer_mob'] = "Emergency mobile no. can be numeric only!";
        $str = '';
        if (count($error) > 0) {
            foreach ($error as $k => $v) {
                $str .=$v . "   |  ";
            }
            $this->setErrorMsg(rtrim($str, "|  "));
            $chk = false;
            return false;
        }

        if ($this->CountRecord($this->tbl_student, "id!=" . $studentId . " and email='" . $para['email'] . "'") > 0) {
            $this->setErrorMsg("Duplicate Email Id Found!");
            return false;
        }

        $this->begin();
        $student_data = json_decode($this->getStudentList(array("id" => $studentId)));

        $old_image = $student_data[0]->image;
        if (isset($_FILES['stu_image']) && !empty($_FILES['stu_image']['name'])) {
            if ($_FILES['stu_image']['error'] == 0) {
                if ($imgName = $this->uploadImageStu($_FILES['stu_image']['name'], $_FILES['stu_image']['tmp_name'])) {
                    $para['image'] = $imgName;
                }
            } else {
                $para = $old_image;
                $chk = false;
            }
        } else {
            // $para['image'] = $old_image;
        }

        if (!$this->updateQry($this->tbl_student, $para, array("id" => $studentId))) {

            $chk = false;
        }
        if (count($this->selectQry($this->tbl_stu_qualification, '', array("emp_id" => $studentId))) > 0) {
            if (!$this->deleteData($this->tbl_stu_qualification, array("emp_id" => $studentId))) {

                $chk = false;
            }
        }


        //Adding data if user wants to buy package of exam
        if ($para['pkg_opt'] == '1') {
            if (!$this->getRequestParamByPrefix("sel_", "required", '', '_')) {
                return false;
            } else {
                $pkg = $this->getRequestParamByPrefix("sel_", "required", '', '_');
            }
            $pkg_arr = $this->doit($pkg);

            if (!$this->updateStuOptPkg($pkg_arr, $studentId)) {
                $chk = false;
            }
        }

        for ($i = 0; $i < sizeof($level); $i++) {
            $query = "insert into " . $this->tbl_stu_qualification . " set emp_id=" . $studentId . ",level='" . $level[$i] . "',discipline='" . $discipline[$i] . "',college='" . $college[$i] . "' ,specialization='" . $specialization[$i] . "' ,passYear='" . $passYear[$i] . "' ,gpa_score='" . $gpa_score[$i] . "'";
            if (!$this->query($query)) {

                $chk = false;
            }
        }
        if ($chk) {
            if (isset($_FILES['stu_image']) && !empty($_FILES['stu_image']['name'])) {
                unlink(BASE_PATH . $this->stuImgUploadPath . $old_image);
            }
            $this->query("COMMIT");

            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->query("ROLLBACK");
            $this->setErrorMsg("Something Unexpected Happened! Record cannot be Updated!");
            return false;
        }
    }
    public function getStudentSelectedPapers($filter = array()){        
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_exm_stu_selected_ppr;
        $qry = $this->query($query);
        while ($result = mysql_fetch_assoc($qry)) {
            if (isset($filter) && array_key_exists($result['Field'], $filter)) {

                $condition[$result['Field']] = $this->sqlEnjection($filter[$result['Field']]);
            }
        }
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

        $data = $this->selectQry($this->tbl_exm_stu_selected_ppr, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }
}

?>