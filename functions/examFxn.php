<?php

/**
 * Description of examFxn
 *
 * @author Anshul
 */
class examFxn extends commonFxn {
    /*
     * @author anshul pareek
     * function desc: used to add subject for exam
     */

    public $ans_array = array(1 => "1st Option", 2 => '2nd Option', 3 => "3rd Option", 4 => "4th Option", 5 => "5th Option");

    public function addSubject() {

        if (!$this->getRequestParamByPrefix("sub_", "required", "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("sub_", "required", "", "_");

        if ($this->CountRecord($this->tbl_exm_subject, "sub_name=" . $para['name'] . "'") > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->insertQry($this->tbl_subject, $para)) {
            $this->setSuccessMsg("Subject Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function updateSubject($subjectId) {
        if (!$this->getRequestParamByPrefix("sub_", "required", "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("sub_", "required", "", "_");


        if ($this->CountRecord($this->tbl_subject, "id!=" . $subjectId . " and name='" . $para['name'] . "'") > 1) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_subject, $para, array('id' => $subjectId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function getSubjectList($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_subject;
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

        $data = $this->selectQry($this->tbl_subject, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    //subject functions ends here
    //package functions starts here
    public function getPackageList($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_package;
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

        $data = $this->selectQry($this->tbl_package, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    public function addPackage() {
//        ECHO "<center><pre>";print_r($_REQUEST);DIE;
        $chk = true;
        if (!$this->getRequestParamByPrefix("pkg_", '', "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("pkg_", "", "", "_");

        if ($para['name'] == '' || $para['type'] == '') {
            $this->setErrorMsg("please fill mandatory fields!");
            return false;
        }
        if (!$this->getRequestParamByPrefix("pkgs_", '', "", "_")) {
            return false;
        } else {
            $paras = $this->getRequestParamByPrefix("pkgs_", "", "", "_");
        }

        if ($para['type'] == 1) {
            if ($para['duration_in_days'] == '' || $para['size'] == '' || $para['price'] == '') {
                $this->setErrorMsg("please fill mandatory fields!");
                return false;
            }
        }

        if (!isset($paras['paper_id']) || $paras['paper_id'][0] == '') {
            $this->setErrorMsg("please select at least one paper in package!");
            return false;
        }
        $this->begin();
        if ($this->CountRecord($this->tbl_package, array("name" => $para['name'])) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->insertQry($this->tbl_package, $para)) {
            $lastInsertId = $this->getLastInsertId();
            foreach ($paras['paper_id'] as $k => $v) {
                if (!$this->insertQry($this->tbl_exm_pkg_paper, array("paper_id" => $v, "pkg_id" => $lastInsertId, "created" => date('Y-m-d H:i:s'), "created_by" => $_SESSION['id']))) {
                    $chk = false;
                }
            }
        } else {
            $chk = false;
        }
        if ($chk) {
            $this->commit();
            $this->setSuccessMsg("Subject Added Successfully!");
            return true;
        } else {
            $this->rollback();
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function updatePackage($pkg_id) {


        if (!$this->getRequestParamByPrefix("pkg_", '', "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("pkg_", "", "", "_");
        
        if ($para['name'] == '' || $para['type'] == '') {
            $this->setErrorMsg("please fill mandatory fields!");
            return false;
        }
        if (!$this->getRequestParamByPrefix("pkgs_", '', "", "_")) {
            $this->setErrorMsg("please select at least one paper in package!");
            return false;
        } else {
            $paras = $this->getRequestParamByPrefix("pkgs_", "", "", "_");
        }

        if ($para['type'] == 1) {
            if ($para['duration_in_days'] == '' || $para['size'] == '' || $para['price'] == '') {
                $this->setErrorMsg("please fill mandatory fields!");
                return false;
            }
        }
        $chk = true;
        $this->begin();

        if (!isset($paras['paper_id']) || $paras['paper_id'][0] == '') {
            $this->setErrorMsg("please select at least one paper in package!");
            return false;
        }
        if ($this->CountRecord($this->tbl_package, "name=" . $para['name'] . ",id!=" . $pkg_id) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_package, $para, "id=" . $pkg_id)) {
            if ($this->deleteData($this->tbl_exm_pkg_paper, array("pkg_id" => $pkg_id))) {
                foreach ($paras['paper_id'] as $k => $v) {
                    if (!$this->insertQry($this->tbl_exm_pkg_paper, array("paper_id" => $v, "pkg_id" => $pkg_id, "created" => date('Y-m-d H:i:s'), "created_by" => $_SESSION['id']))) {
                        $chk = false;
                    }
                }
            } else
                $chk = false;
        } else {
            $chk = false;
        }

        if ($chk) {
            $this->commit();
            $this->setSuccessMsg("Subject Added Successfully!");
            return true;
        } else {
            $this->rollback();
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    //package function ends here
    /*
     * paper functions starts here
     */
    public function getPaperList($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_papers;
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

        $data = $this->selectQry($this->tbl_papers, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }
    public function getStudentSelectedPapers($filter = array()) {
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

        $data = $this->selectQry($this->tbl_exm_stu_selected_ppr, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }
    
    public function getPaperAttemptedAlready($stu_id){
        $query = "select t3.*,t2.* from tbl_Exm_ppr_attmpted as t1 left join tbl_exm_pkg_paper as t2 on t1.ppr_id=t2.paper_id left join tbl_exm_st_select_pkg as t3 on t3.pkg_id=t2.pkg_id where t1.stu_id='".$stu_id."'";
        $data = $this->getResult($query);
        return $data;
        
    }
    
    public function addPaper() {
//        ECHO "<center><pre>";print_r($_REQUEST);DIE;

        if (!$this->getRequestParamByPrefix("pkg_", 'required', "", "_")) {
            return false;
        } else {
            $para = $this->getRequestParamByPrefix("pkg_", "required", "", "_");
        }

        if (!$this->getRequestParamByPrefix("ppr_", 'required', "", "_")) {
            return false;
        } else {
            $para1 = $this->getRequestParamByPrefix("ppr_", "required", "", "_");
        }

        $subject = implode(",", $para1['subject']);
        $para['subject_id'] = $subject;
        $para['center_id'] = $_SESSION['center_id'];
        if ($this->CountRecord($this->tbl_papers, array("name" => $para['name'], "center_id" => $_SESSION['center_id'])) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->insertQry($this->tbl_papers, $para)) {
//            echo$lastInsertId= $this->getLastInsertId();die;

            $this->setSuccessMsg("Data Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Details!");
            return false;
        }
    }

    public function updatePaper($id) {
//        ECHO "<center><pre>";print_r($_REQUEST);DIE;

        if (!$this->getRequestParamByPrefix("pkg_", 'required', "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("pkg_", "required", "", "_");

        if (!$this->getRequestParamByPrefix("ppr_", 'required', "", "_")) {
            return false;
        } else
            $para1 = $this->getRequestParamByPrefix("ppr_", "required", "", "_");
//        echo "<center><pre>";print_r();die;
        $subject = implode(",", $para1['subject']);
        $para['subject_id'] = $subject;

//        if ($this->CountRecord($this->tbl_papers, array("name" => $para['name'], "center_id" => $_SESSION['center_id'])) > 1) {
//            $this->setErrorMsg("Duplicate Record Found!");
//            return false;
//        }
        $dup_qry = "select * from " . $this->tbl_papers . " where name='" . $para['name'] . "' and center_id='" . $_SESSION['center_id'] . " AND id!='" . $id . "'";
        $res = $this->query($dup_qry);
        if (mysql_num_rows($res) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_papers, $para, array("id" => $id))) {
//            echo$lastInsertId= $this->getLastInsertId();die;

            $this->setSuccessMsg("Data Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Details!");
            return false;
        }
    }

    //getting data of a particular package's papers
    public function getPaperOfPkg($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_exm_pkg_paper;
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
        
        $data = $this->selectQry($this->tbl_exm_pkg_paper, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    //paper functions ends here
    /*
     * ALL QUESTION FUNCTIONS IS DEFINED BELOW
     */
    public function getQuestionByPaperId($paper_id){
        $query = "select * from ".$this->tbl_exm_questions." where find_in_set(".$paper_id.",paper_id)";
        $data = $this->getResult($query);
        if(count($data)>0)
            return $data;
        else
            return false;
    }
    public function getQuestionList($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_exm_questions;
        $qry = $this->query($query);
        while ($result = mysql_fetch_assoc($qry)) {
            if (isset($filter) && array_key_exists($result['Field'], $filter)) {
                if (array_key_exists("paper_id", $filter))
                    continue;
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

        $data = $this->selectQry($this->tbl_exm_questions, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    public function addQuestion() {
//        ECHO "<center><pre>";print_r($_REQUEST);DIE;
        if ($_REQUEST['ppr_options'] == 1) {
            unset($_REQUEST['ppr_option5_hin']);
            unset($_REQUEST['ppr_option5']);
        }
        if (!$this->getRequestParamByPrefix("ppr_", '', "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("ppr_", "", "", "_");

        if (!$this->getRequestParamByPrefix("sel_", '', "", "_")) {
            return false;
        } else
            $paper = $this->getRequestParamByPrefix("sel_", "", "", "_");

        if (!$this->getRequestParamByPrefix("ans_", '', "", "_")) {
            return false;
        } else
            $answer = $this->getRequestParamByPrefix("ans_", "required", "", "_");

        $papers = implode(",", $paper['paper_id']);
        $para['paper_id'] = $papers;

        $answers = implode(',', $answer['answer']);
        $para['answer'] = $answers;
        if (isset($para['eng_ques']) && $para['eng_ques'] == '') {
            $this->setErrorMsg("Please Enter English Question!");
            return false;
        }
        if ($para['option1'] == '' || $para['option2'] == '' || $para['option3'] == '' || $para['option4'] == '') {
            $this->setErrorMsg("Please fill options properly!");
            return false;
        }
        $para['hin_ques'] = utf8_encode($para['hin_ques']);
        $para['option1_hin'] = utf8_encode($para['option1_hin']);
        $para['option2_hin'] = utf8_encode($para['option2_hin']);
        $para['option3_hin'] = utf8_encode($para['option3_hin']);
        $para['option4_hin'] = utf8_encode($para['option4_hin']);
        if (array_key_exists("option5_hin", $para)) {
            $para['option5_hin'] = utf8_encode($para['option5_hin']);
        }
        if ($this->CountRecord($this->tbl_exm_questions, array("eng_ques" => $para['eng_ques'], "center_id" => $_SESSION['center_id'])) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->insertQry($this->tbl_exm_questions, $para)) {
//            echo$lastInsertId= $this->getLastInsertId();die;

            $this->setSuccessMsg("Data Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Details!");
            return false;
        }
    }

    public function updateQuestion($id) {
//        ECHO "<center><pre>";print_r($_REQUEST);DIE;

        if ($_REQUEST['ppr_options'] == 1) {
            unset($_REQUEST['ppr_option5_hin']);
            unset($_REQUEST['ppr_option5']);
        }
        if (!$this->getRequestParamByPrefix("ppr_", '', "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("ppr_", "", "", "_");

        if (!$this->getRequestParamByPrefix("sel_", '', "", "_")) {
            return false;
        } else
            $paper = $this->getRequestParamByPrefix("sel_", "", "", "_");

        if (!$this->getRequestParamByPrefix("ans_", '', "", "_")) {
            return false;
        } else
            $answer = $this->getRequestParamByPrefix("ans_", "", "", "_");

        $papers = implode(",", $paper['paper_id']);
        $para['paper_id'] = $papers;

        $answers = implode(',', $answer['answer']);
        $para['answer'] = $answers;


        if (isset($para['eng_ques']) && $para['eng_ques'] == '') {
            $this->setErrorMsg("Please Enter English Question!");
            return false;
        }
        if ($para['option1'] == '' || $para['option2'] == '' || $para['option3'] == '' || $para['option4'] == '') {
            $this->setErrorMsg("Please fill options properly!");
            return false;
        }
        $para['hin_ques'] = utf8_encode($para['hin_ques']);
        $para['option1_hin'] = utf8_encode($para['option1_hin']);
        $para['option2_hin'] = utf8_encode($para['option2_hin']);
        $para['option3_hin'] = utf8_encode($para['option3_hin']);
        $para['option4_hin'] = utf8_encode($para['option4_hin']);
        if (array_key_exists("option5_hin", $para)) {
            $para['option5_hin'] = utf8_encode($para['option5_hin']);
        }
        if ($this->CountRecord($this->tbl_exm_questions, array("eng_ques" => $para['eng_ques'], "center_id" => $_SESSION['center_id'])) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_exm_questions, $para, array("id" => $id))) {
//            echo$lastInsertId= $this->getLastInsertId();die;

            $this->setSuccessMsg("Data Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Details!");
            return false;
        }
    }

    /*
     * Functions below used after exam starts or going to be start by student
     */

    public function getPaperAttemptData($filter = array()) {
        
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_exm_ppr_attmpted;
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
        
        $count = $this->CountRecord($this->tbl_exm_ppr_attmpted, $condition);
        if ($count > 0) {
            $data = $this->selectQry($this->tbl_exm_ppr_attmpted, $columnFilter, $condition, $groupordercondition, $limitrecord);
            return json_encode($data);
        } else {
            return false;
        }
    }

    //ADDING ATTEMPTED PAPER IN TABLE AND ADDING START TIME ALONG WITH QUESTIONS WOULD BE SELECTED FOR AN INDIVIDUAL STUDENT WITH TIMESTAMP
    public function addAttemptedPaper() {
//        ECHO "<center><pre>";print_r($_REQUEST);DIE;

        $ppr_id = $this->decode($_REQUEST['ppr_id']);
        if (!$this->getRequestParamByPrefix("strt_", 'required', "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("strt_", "required", "", "_");

        $paper_data = json_decode($this->getPaperList(array("id" => $ppr_id)));
        

//        echo "<pre>";print_R($declaration);die;
        $duration = $paper_data[0]->duration;
        $ppr_detail['student_id'] = $_SESSION['st_id'];
        $ppr_detail['ppr_id'] = $ppr_id;
        $ppr_detail['declaration'] = $paper_data[0]->description;

        $ppr_detail['start_time'] = date('YmdHis');
        $ppr_detail['last_view_time'] = date('YmdHis');

        $endtime = date('YmdHis', strtotime("+" . $duration . " minutes", strtotime(date('YmdHis'))));
        $ppr_detail['end_time'] = $endtime;
        $ppr_detail['right_mark'] = $paper_data[0]->right_mark;
        $ppr_detail['wrong_mark'] = $paper_data[0]->wrong_mark;
        $ppr_detail['attempt_count'] = '1';
        $para1 = array_merge($para, $ppr_detail);

        $this->begin();
        $chk = true;
        if ($this->insertQry($this->tbl_exm_ppr_attmpted, $para1)) {
            $lst_attempt_id = $this->getLastInsertId();
            $paper_data = $this->selectQry($this->tbl_papers, '*', array("id" => $ppr_id));
//            echo "<pre>";print_r($paper_data);die;
            $sub = explode(",", $paper_data[0]['subject_id']);
            //total subjects 
            $count_sub = count($sub);
            $tot_ques = $paper_data[0]['tot_question'];
            //question per subject dividation
            $ques_per_sub = floor($tot_ques / $count_sub);
            //storing question into table according subject for student exam

            $quest_exm_qry = "INSERT INTO `tbl_student_exm_taken`(`student_id`,`attempt_ppr_id`, `paper_id`, `sub_id`,`ques_id`, `ques_status`,`answer`,`created`) VALUES";
            $old_ques = array();
            foreach ($sub as $subkey => $subval) {

                //getting distinct records to be stored in new exm taken table    
                $question_sel_qry = "select DISTINCT * from " . $this->tbl_exm_questions . " where find_in_set(" . $ppr_id . ",paper_id) and sub_id='" . $subval . "' and status = '1' ORDER BY RAND() LIMIT 1," . $ques_per_sub;

                //getting all distinct questions from table and making qry

                $question = json_decode($this->getResult($question_sel_qry));
                $ii = 0;
                foreach ($question as $quesK => $quesV) {
                    if ($ii == 0) {
                        $q_strt_time = date('YmdHis');
                        $ii++;
                    } else
                        $q_strt_time = 0;
                    $quest_exm_qry .="('" . $_SESSION['st_id'] . "','".$lst_attempt_id."','" . $ppr_id . "','" . $subval . "','" . $quesV->id . "','0','" . $quesV->answer . "',created=now()),";
                }
            }
            echo$exm_taken_qry = rtrim($quest_exm_qry, ",");
//            echo $exm_taken_qry;die;
            if (!$this->query($exm_taken_qry)) {echo "Test";die;
                $chk = false;
            }
        } else {
            $chk = false;
        }
        if(!$this->updateQry($this->tbl_exm_stu_selected_ppr,array("attempt_status"=>'1'),array("st_id"=>$_SESSION['st_id'],"ppr_id"=>$ppr_id))){
            $chk = false;
        }
        
        if ($chk) {
            $this->commit();
            $this->setSuccessMsg("Exam started! All the Best!!!");
            return true;
        } else {
            $this->rollback();
            $this->setErrorMsg("Something Unexpected Happened when Starting Exam!");

            return false;
        }
    }

    public function updateAttemptPaper($id) {
//        ECHO "<center><pre>";print_r($_REQUEST);DIE;

        if (!$this->getRequestParamByPrefix("pkg_", 'required', "", "_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("pkg_", "required", "", "_");

        if (!$this->getRequestParamByPrefix("ppr_", 'required', "", "_")) {
            return false;
        } else
            $para1 = $this->getRequestParamByPrefix("ppr_", "required", "", "_");
//        echo "<center><pre>";print_r();die;
        $subject = implode(",", $para1['subject']);
        $para['subject_id'] = $subject;

        if ($this->CountRecord($this->tbl_papers, array("name" => $para['name'], "center_id" => $_SESSION['center_id'])) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_papers, $para, array("id" => $id))) {
//            echo$lastInsertId= $this->getLastInsertId();die;

            $this->setSuccessMsg("Data Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Details!");
            return false;
        }
    }
    function updateExmCompleteStatus($attmpt_id,$status){
        if($attmpt_id !='' && $status !=''){
            $qry = "UPDATE ".$this->tbl_exm_ppr_attmpted." set is_completed='".$status."' where attmpt_id='".$attmpt_id."'";
            if($this->updateQry($this->tbl_exm_ppr_attmpted, array("is_completed"=>$status), array("id"=>$attmpt_id)))
                return true;
            else
                return false;
        }
    }
    /*
     * This function used to get student question on start page to show one by one or list at right side
     */

    public function getStudentExmTakenQues($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupcondition = '';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_student_exm_taken;
        $qry = $this->query($query);
        while ($result = mysql_fetch_assoc($qry)) {
            if (isset($filter) && array_key_exists($result['Field'], $filter)) {
                $condition[$result['Field']] = $this->sqlEnjection($filter[$result['Field']]);
            }
        }
        // Group by and Order by condition
        if (array_key_exists('group_by', $filter)) {
            $groupcondition .= " group by " . $this->sqlEnjection($filter['group_by']);
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
        if (array_key_exists("limitRecord", $filter)) {
            $limitrecord = " limit " . $this->sqlEnjection($filter['limitRecord']);
        }

        $count = $this->CountRecord($this->tbl_student_exm_taken, $condition);
        if ($count > 0) {
            $data = $this->selectQry($this->tbl_student_exm_taken, $columnFilter, $condition, $groupcondition, $groupordercondition, $limitrecord);
            return json_encode($data);
        } else {
            return false;
        }
    }

    function getQuestionMaxEndTime($st_id, $ppr_id) {
        $query = "select last_view_time as max_end_time from " . $this->tbl_exm_ppr_attmpted . " where student_id='" . $st_id . "' and ppr_id='" . $ppr_id . "'";

        $data = json_decode($this->getResult($query));
        if (count($data) > 0)
            return $data[0]->max_end_time;
        else
            return false;
    }

    function updateQuestionEndTime($st_id, $ppr_id) {
        if ($this->updateQry($this->tbl_exm_ppr_attmpted, array('last_view_time' => date('YmdHis')), array("ppr_id" => $ppr_id, "student_id" => $st_id)))
            return "1";
        else
            return "0";
    }

    /*
     * definition: this function used to get new question data by using exm_taken table id and 
     */

    function getNextQuestion($nxt_attempt_id, $nxtNprev) {
        //incrementing to get next exm id
//        print_R($_REQUEST);die;
        $nxt_attempt_id;
        if ($nxtNprev === 'next' || $nxtNprev === 'markFrReviewNxt') {
            $query = "SELECT * from " . $this->tbl_student_exm_taken . " where id > " . $nxt_attempt_id . " and student_id='" . $_SESSION['st_id'] . "' and paper_id='" . $_SESSION['ppr_id'] . "' limit 0,1";
        } else if ($nxtNprev === 'prev') {
            $query = "SELECT * from " . $this->tbl_student_exm_taken . " where id < " . $nxt_attempt_id . " and student_id='" . $_SESSION['st_id'] . "' and paper_id='" . $_SESSION['ppr_id'] . "' order by id desc limit 0,1";
        } else {
            $query = "SELECT * from " . $this->tbl_student_exm_taken . " where id = " . $nxt_attempt_id . " and student_id='" . $_SESSION['st_id'] . "' and paper_id='" . $_SESSION['ppr_id'] . "' order by id desc limit 0,1";
        }


        $exm_taken_data = json_decode($this->getResult($query));
        if (count($exm_taken_data) > 0) {

            $ques_data = json_decode($this->getQuestionList(array("id" => $exm_taken_data[0]->ques_id)));

            unset($ques_data[0]->answer);
            if ($nxtNprev == 'next' || $nxtNprev === 'markFrReviewNxt') {
                $ques_data[0]->nxt_attempt_id = $exm_taken_data[0]->id;
            } else if ($nxtNprev == 'prev') {
                $ques_data[0]->nxt_attempt_id = $exm_taken_data[0]->id;
            } else {
                $ques_data[0]->nxt_attempt_id = $exm_taken_data[0]->id;
            }
            $sub_arr =  json_decode($this->getSubjectList(array("id"=>$exm_taken_data[0]->sub_id)));
            $ques_data[0]->sub_name = $sub_arr[0]->name;
            $ques_data[0]->exm_tkn_id = $exm_taken_data[0]->id;
            $ques_data[0]->ques_status = $exm_taken_data[0]->ques_status;
            $ques_data[0]->st_ans = $exm_taken_data[0]->st_ans;
            $ques_data[0]->tot_ques = count($ques_data);

            if (count($ques_data) > 0) {
                return json_encode($ques_data);
            } else {
                return false;
            }
        } else {
            return "1";
        }
    }

    function updateAnswer($ques_id, $ans, $q_status) {//echo $ques_id."   ";
//        echo "Test";
//        print_R($_REQUEST);
//        die;
        $status = array('1', '2', '3', '0', '4');
        if (in_array($q_status, $status)) {
            if ($this->updateQry($this->tbl_student_exm_taken, array("st_ans" => $ans, "ques_status" => $q_status), array("id" => $ques_id))) {
                $returnData = $this->selectQry($this->tbl_student_exm_taken, "*", array("id" => $ques_id));
                $q_status = $returnData[0]['ques_status'];
                return $q_status;
            } else {
                return '0';
            }
        }
    }

    /*
     * this function is used to update status of question if student choose option of mark for review
     */

    public function markForReviewStatusUpdate($ques_id, $new_status) {
        //status should be only 0 to 4 is user console and changes any thing then it works and dnt update status
        $status = array('1', '2', '3', '0', '4');
        if (in_array($new_status, $status)) {
            if ($this->updateQry($this->tbl_student_exm_taken, array("ques_status" => $new_status), array("id" => $ques_id))) {
                return "1";
            } else {
                return "0";
            }
        }
    }

    function examFinalSubmit() {
        $chk = true;
        $exm_attempt_data = $this->selectQry($this->tbl_exm_ppr_attmpted, '*', array("student_id" => $_SESSION['st_id'], "ppr_id" => $_SESSION['ppr_id']));
        $tot_r_marks = 0;
        $tot_w_marks = 0;

        $tot_q_attempt = 0;
        $tot_r_ques = 0;
        $tot_w_ques = 0;
//        print_R($exm_attempt_data);die;
        $r_marks = $exm_attempt_data[0]['right_mark'];
        $w_marks = $exm_attempt_data[0]['wrong_mark'];
        $tot_marks_got = 0;
        $this->begin();
        $exm_givn_data = $this->selectQry($this->tbl_student_exm_taken, '*', array("student_id" => $_SESSION['st_id'], "paper_id" => $_SESSION['ppr_id']));
//        echo "<center><pre>";print_r($data);die;
        foreach ($exm_givn_data as $k => $v) {
            
            if ($v['st_ans'] == 0 || $v['st_ans'] === '0') {
                continue;
            } else if ($v['st_ans'] == $v['answer']) {
                $tot_r_marks = $r_marks + $tot_r_marks;
                ++$tot_r_ques;
            } else {
                $tot_w_marks = $w_marks + $tot_w_marks;
                ++$tot_w_ques;
            }
            if ($v['st_ans'] != 0) {
                $tot_q_attempt++;
            }
        }
        $tot_marks_got = round($tot_r_marks - $tot_w_marks, 2);
$pkg_id = '';
        if ($this->updateQry($this->tbl_exm_ppr_attmpted, array("total_ques_attempt" => $tot_q_attempt, "total_right_ques" => $tot_r_ques, "total_wrong_ques" => $tot_w_ques, "positive_mark" => $tot_r_marks, "negative_mark" => $tot_w_marks, "obtain_marks" => $tot_marks_got,"last_view_time"=>date("YmdHis"), "is_completed" => '1'), array("student_id" => $_SESSION['st_id'], "ppr_id" => $_SESSION['ppr_id']))) {
            //getting pkg id to update status of paper attempt
            $pkg_data = json_decode($this->getPaperOfPkg(array("paper_id" => $_SESSION['ppr_id'])));
//            print_R($pkg_data[0]->pkg_id);die;
            $pkg_id = $pkg_data[0]->pkg_id;
//            print_R($pkg_);die;
            //changing paper status means fully attempted not remaining
//            if (!$this->updateQry($this->tbl_exm_st_select_pkg, array("paper_status" => '1', 'modified' => date('Y-m-d H:i:s')), array('stu_id' => $_SESSION['st_id'], "pkg_id" => $pkg_id))) {
//                $chk = false;
//            }
        } else {
            $chk = false;
//            return false;
        }
        if(!$this->updateQry($this->tbl_exm_stu_selected_ppr,array("attempt_status"=>'2'),array("st_id"=>$_SESSION['st_id'],"ppr_id"=>$_SESSION['ppr_id'],"pkg_id"=>$pkg_id))){
            $chk = false;
        }
        if ($chk) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }
    }

    
    //--------------------------- RESULT FUNCTIONS STARTS HERE----------------------//
    
}
