<?php

//include('../core/config.php');

class commonClass {

    public $db_name;
    public $db_pass;
    public $db_user;
    public $db_host;
    public $message;
    public $connectionId;
    public $lastInsertId;
    protected $tbl_course = "tbl_course";
    protected $tbl_user_group = "tbl_user_group";
    protected $tbl_user_permission = "tbl_user_permission";
    protected $tbl_user_roles = "tbl_user_roles";
    protected $tbl_locations = "tbl_locations";
    protected $tbl_center = "tbl_center";
    protected $tbl_sub_course = "tbl_sub_course";
    protected $tbl_qualification = "tbl_qualification";
    protected $tbl_emp_qualification = "tbl_emp_qualification";
    protected $tbl_employee = "tbl_employee";
    protected $tbl_batch = "tbl_batch";
    protected $tbl_student = "tbl_student";
    protected $tbl_stu_qualification = "tbl_stu_qualification";
    protected $tbl_subject = "tbl_exm_subject";
    protected $tbl_package = "tbl_exm_package";
    protected $tbl_papers = "tbl_exm_papers";
    protected $tbl_exm_pkg_paper = "tbl_exm_pkg_paper";
    protected $tbl_exm_questions = "tbl_exm_questions";
    protected $tbl_exm_st_select_pkg = "tbl_exm_st_select_pkg";
     protected $tbl_exm_stu_selected_ppr = 'tbl_exm_stu_selected_ppr';
    protected $tbl_exm_ppr_opt_by_st = "tbl_exm_ppr_opt_by_st";
    protected $tbl_exm_ppr_attmpted = "tbl_exm_ppr_attmpted";
    protected $tbl_student_exm_taken = "tbl_student_exm_taken";
//used for recursive function doit
    protected $tempArr = array();
    public $extensionarr = array('jpg', 'jpeg', 'gif', 'png');
    public $msgArr = array('insert' => 'Data inserted Successfully!', 'updated' => 'Data Updated Successfully', '');

    public function __construct() {
        $this->db_host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->db_pass = DB_PASS;
        $this->db_user = DB_USER;
        $this->dbConnection();
    }

    private function dbConnection() {
        if (!empty($this->db_host) && !empty($this->db_user)) {
            $this->connectionId = mysql_connect($this->db_host, $this->db_user, $this->db_pass);
            if ($this->connectionId) {
                mysql_select_db($this->db_name, $this->connectionId) or die(mysql_error());
            } else {
                echo die('connection error');
            }
            return $this->connectionId;
        } else {
            echo die('database parameters not found');
        }
    }

    function autoload($classname) {
        $filename = FUNCTION_URL . $classname . ".php";
        include_once($filename);
    }

    public function insertError() {
        $query = "insert into tbl_error_log set error_type='test'";
        $this->query($query);
    }

    public function my_error_handler($e_type, $e_message, $e_file, $e_line) {
        $this->insertError();
    }

    //-----------login function starts-----------------//
    public function employeeUserNameExist($username) {
        if ($this->connectionId) {
            if ($username != '') {
                $userSql = "select emp_number from " . $this->tbl_employee . " where `emp_number` = '" . $this->sqlEnjection($username) . "' and `status` = '1'";
                $cnt = $this->CountRecord($this->tbl_employee, array("emp_number" => $this->sqlEnjection($username)));
                if ($cnt > 0) {
                    return true;
                } else {
                    $this->setErrorMsg('Whoops! We didn\'t recognise your username or password. Please try again.');
                    return false;
                }
            } else {
                $this->setErrorMsg('Whoops! We didn\'t recognise your username. Please try again.');
                return false;
            }
        } else {
            $this->setErrorMsg('Database not connected.');
            return false;
        }
    }

    public function employeeCheckLogin($username, $pass) {
        if ($this->connectionId) {
            if ($username != '' && $pass != '') {
                $row = '';
//                echo $username." ".$pass;die;
                $userSql = "select * from " . $this->tbl_employee . " where `emp_number` = '" . $this->sqlEnjection($username) . "' and `password` = '" . $this->sqlEnjection($pass) . "' and `status` = '1'";
                $cnt = $this->CountRecord($this->tbl_employee, array("emp_number" => $this->sqlEnjection($username), "password" => $this->sqlEnjection($pass)));
                
                if ($cnt > 0) {
                    if ($row = $this->getResult($userSql)) {

                        return $row;
                    }
                } else {
                    $this->setErrorMsg('Invalid username or password.');
                    return false;
                }
            } else {
                $this->setErrorMsg('Please enter username or password.');
                return false;
            }
        } else {
            $this->setErrorMsg('Database not connected.');
        }
    }

    public function getPermission($group_id) {
        $query = "select role_id,can_read,can_update,can_delete from " . $this->tbl_user_permission . " where group_id='" . $group_id . "'";
        if ($permission = $this->getResult($query)) {
            return $permission;
        } else
            return false;
    }

    public function getUserRole($role_id) {
        $query = "select * from " . $this->tbl_user_roles . " where id='" . $role_id . "'";
        if ($role = $this->getResult($query)) {
            return $role;
        } else
            return false;
    }

    public function getUserGroupData($filter = array()) {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';

        $query = "SHOW COLUMNS FROM " . $this->tbl_user_group;
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

        $data = $this->selectQry($this->tbl_user_group, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }

    public function logout($sessionarr) {
        if (is_array($sessionarr)) {
            foreach ($sessionarr as $key => $value) {
                unset($_SESSION[$key]);
            }
            return;
        }
    }

    //-----------login function End's-----------------//

    public function getPageNfolderName($fullPageName) {
        $returnArr = array();
        $pageName = '';
        if ($fullPageName != '') {
            $page_arr = explode("_", $fullPageName);
            $returnArr['folder'] = $page_arr[0];

            unset($page_arr[0]);
            foreach ($page_arr as $k => $v) {
                $pageName .=$v . "_";
            }
            $pageName = rtrim($pageName, "_");
            $returnArr['pagename'] = $pageName . ".php";
            return json_encode($returnArr);
        }
    }

    public function sqlEnjection($param) {
        $trimStr = array();
        $retArr = array();
        if (!empty($param)) {
            if (!is_array($param)) {
                $trimStr = trim($param);
                $sqlStr = mysql_real_escape_string($trimStr);
                return $sqlStr;
            } else {
                foreach ($param as $k => $v) {
                    $trimStr[$k] = trim($v);
                    $retArr[$k] = mysql_real_escape_string($trimStr[$k]);
                }
                return $retArr;
            }
        }
    }

    public function deleteData($tableName, $condition) {
        $cond = '';
        $query = "delete from " . $tableName . " where 1=1 ";
        if ($tableName != '') {
            if (is_array($condition)) {
                foreach ($condition as $k => $v) {
                    $cond.=" and " . $k . "='" . $v . "'";
                }
            } else
                $cond = $condition;

            $query .= $cond;
            return $this->query($query);
        }
    }

    public function convertRecursive($item, $key) {
        $this->tempArr[$key] = $item;
    }

//get last element in hierarchy of data last element in a tree of array
    public function doit($arr = array()) {
        array_walk_recursive($arr, 'commonClass::convertRecursive');
        return $this->tempArr;
    }

    public function validation($param = array(), $validation, $is_required = '') {
        $temp = true;
        if (isset($param) && isset($validation) && $is_required == 'required') {
            $param = $this->doit($param);
            foreach ($param as $k => $v) {
                if (empty($v) && $v == '') {
                    $this->setErrorMsg("please Fill Require Field!");
                    $temp = false;
                }
                if ($validation === 'numeric') {
                    if (!is_numeric($v)) {
                        $this->setErrorMsg($v . " must be numeric.");
                        $temp = false;
                    }
                }
                if ($validation === 'text') {
                    if (!is_string($v)) {
                        $this->setErrorMsg($v . " must be text.");
                        $temp = false;
                    }
                }
                if ($validation == 'email') {
                    if (!filter_var($v, FILTER_SANITIZE_EMAIL)) {
                        $this->setErrorMsg("Email Id is not valid.");
                        $temp = false;
                    }
                }
                if ($validation == 'alphanum') {
                    if (!ctype_alnum($v)) {
                        $this->setErrorMsg($v . " must be alphanumeric.");
                        $temp = false;
                    }
                }
            }
            if ($temp) {
                return $param;
            } else {
                return false;
            }
        }
    }

    public function redirectUrl($page = '') {
        if ($page != '') {
            exit(header('Location:' . SITE_URL . '?page=' . $page));
        } else {
            header('Location:' . SITE_URL);
            exit();
        }
    }

//just pass prefix and it will sanatize and sqlenjection then return full array  in remove symbol enter symbol to remove from prefix 
    public function getRequestParamByPrefix($prefix, $required = '', $msg = '', $remove_symbol = '') {
        $key = '';
        if ($prefix != '') {
            $ctr = 0;
            $form_Para = array();
            $tempArr = array();
            $prefixLen = strlen($prefix);
            foreach ($_REQUEST as $k => $v) {
                if (substr($k, 0, $prefixLen) == $prefix) {
                    $form_Para[$k] = $this->sqlEnjection($_REQUEST[$k]);
                }
            }
            $str = '';
            if ($required != '' && $required == 'required') {

                foreach ($form_Para as $k => $v) {
                    if ($v == '') {
                        if ($msg == '') {
                            $x = explode($remove_symbol, $k);
                            unset($x[0]);
                            $k = implode(" ", $x);
                            $str .= $k . " is required Field!  |  ";
                            //$this->setErrorMsg($k . " is Required Field!");
                        } else {
                            $this->setErrorMsg($msg);
                        }
                        $ctr++;
                    }
                }
                $this->setErrorMsg(rtrim($str, "|  "));
                if ($ctr > 0)
                    return false;
            }$form_Para1 = array();
            if ($remove_symbol != '') {
                $x = 0;
                foreach ($form_Para as $arrkey => $val) {
                    $key_temp = explode($remove_symbol, $arrkey);

                    if (count($key_temp) > 1)
                        unset($key_temp[0]);

                    $key = '';
                    foreach ($key_temp as $k => $v) {
                        $key .= $v . $remove_symbol;
                    }
                    $key = rtrim($key, $remove_symbol);
                    $form_Para1[$key] = $val;
                    $x++;
                }
                return $form_Para1;
            }
            return $form_Para;
        } else
            return false;
    }

    public function selectQry($tableName, $field = '*', $condition = '', $groupBy = '', $orderBy = '', $limit='') {
        $retData = array();

        if ($tableName != '') {
            if (is_array($field)) {
                foreach ($field as $f)
                    $field .= $f . ",";
                $field = rtrim($f, ',');
            }

            $selectQry = 'select ' . $field . ' from ' . $tableName . ' WHERE 1 ';

            if ($condition != '' && is_array($condition)) {
                foreach ($condition as $k => $v) {
                    $selectQry .= ' and ' . $k . '=' . "'" . $v . "'";
                }
            } else {
                $selectQry .= $condition;
            }
            $selectQry .= $groupBy . " " . $orderBy . " ".$limit;
            $res = mysql_query($selectQry);
            if ($res) {
                while ($data = mysql_fetch_assoc($res)) {
                    //echo $k . ":" . $v . "<br>";
                    $retData[] = $data;
                }
                return $retData;
            } else {
                return false;
            }
        } else
            return false;
    }

    public function encode($val) {
        $str = base64_encode($val);
        $str = strrev($str);
        return $str;
    }

    public function decode($val) {
        return $str = base64_decode(strrev($val));
    }

    public function query($query) {
        if ($query != '') {
            $res = mysql_query($query);
            if ($res)
                return $res;
            else
                return false;
        }
    }

    public function insertQry($tableName, $param) {
        
        if ($tableName != '' && is_array($param)) {
            $insertQry = 'insert into ' . $tableName . " SET ";
            foreach ($param as $k => $v) {
                $insertQry .= $k . '=' . "'" . $v . "',";
            }
            $insertQry = rtrim($insertQry, ',');

            $res = mysql_query($insertQry);
            if ($res) {
                $lastInsertId = mysql_insert_id();
                $this->setLastInsertId($lastInsertId);
                return true;
            } else
                return false;
        }
    }

    public function setLastInsertId($lastInsertId) {
        $this->lastInsertId = $lastInsertId;
    }

    public function getLastInsertId() {
        return $this->lastInsertId;
    }

    public function setSuccessMsg($msg) {
        if ($msg != '') {
            $_SESSION['success'][] = $msg;
        }
    }

    public function getSuccessMsg() {
        $msg = '';
        if (isset($_SESSION['success'])) {
            foreach ($_SESSION['success'] as $k => $v) {
                $msg .= '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="width:300px;">x</button>' . $v . '</div>';
            }
            return $msg;
        }
    }

    public function setErrorMsg($msg) {
        if ($msg != '')
            $_SESSION['error'][] = $msg;
    }

    public function getErrorMsg() {
        $msg = '';
        if (isset($_SESSION['error'])) {
            foreach ($_SESSION['error'] as $k => $v) {
                $msg .= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>' . $v . '</div>';
            }
            return $msg;
        }
    }

    public function unsetMessage() {
        if (isset($_SESSION['error']) || isset($_SESSION['success'])) {
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        }
    }

    public function checkDuplicate($tableName, $colName, $colData) {
        $num = 0;
        $query = "select * from " . $tableName . " where " . $colName . " = '" . $colData . "'";
        $res = $this->query($query);
        if ($res) {

            $num = mysql_num_rows($res);
            if ($num > 0) {
                return $num;
            } else
                return $num;
        }
    }

    public function CountRecord($tableName, $condition) {
        $num = 0;
        $cond = ' Where 1=1 ';

        if (is_array($condition)) {
            foreach ($condition as $k => $v) {
                $cond .= " and " . $k . "='" . $v . "'";
            }
        } else if ($condition != '')
            $cond .= " and " . $condition;
        $query = "select * from " . $tableName . $cond;
        $res = $this->query($query);
        if ($res) {

            $num = mysql_num_rows($res);
            if ($num > 0) {
                return $num;
            } else
                return $num;
        }
    }

    public function updateQry($tableName, $param, $cond = '', $limit = '', $orderBy = '') {
        
        $condition = '';
        if ($tableName != '') {
            $updateQry = 'update ' . $tableName . " SET ";
            if (is_array($param) && count($param) > 0) {

                foreach ($param as $k => $v) {
                    $updateQry .= $k . '=' . "'" . $v . "',";
                }
                $updateQry = rtrim($updateQry, ',');
                $condition .= " WHERE 1=1 ";
            } else {
                $updateQry .= $param;
            }
            if (is_array($cond) && count($cond) > 0) {
                foreach ($cond as $k => $v) {
                    $condition .= " and " . $k . "=" . $v;
                }
            } else if ($cond != '' && !is_array($cond)) {
                $condition .= " and " . $cond;
            }
            if ($limit != '') {
                $limit .= $limit;
            }
            if ($orderBy != '') {
                $orderBy .= $orderBy;
            }
            $update = $updateQry . "" . $condition . $orderBy . $limit;
            return $this->query($update);
        }
    }

    public function getResult($query) {

        $returnArray = array();
        if ($query != '') {

            $result = mysql_query($query);
            if ($result) {
                while ($data = mysql_fetch_assoc($result)) {
                    $returnArray[] = $data;
                }
                return json_encode($returnArray);
            } else
                return false;
        }
    }

    public function getLastInsertedId($tableName) {
        if ($tableName != '') {
            $query = "select id from " . $tableName . " order by id DESC limit 0,1";
            $data = json_decode($this->getResult($query));
            return $data[0]->id;
        }
    }

    //-----------------session function----------------------//
    //pass listing pagename with folder name without .php extension to check
    public function canAccess($pagename) {
        $pageNfolder = json_decode($this->getPageNfolderName($pagename));
        $pagename = $pageNfolder->pagename;
//        print_R($_SESSION['permission']);die;
        if (isset($_SESSION['permission']) && count($_SESSION['permission']) > 0) {
            foreach ($_SESSION['permission'] as $k => $v) {
                if ($pagename == $v['page_name'] . ".php") {
                    return true;
                }
            }
        } else
            return false;
    }

    public function canUpdate($pagename) {
        $pageNfolder = json_decode($this->getPageNfolderName($pagename));
        $pagename = $pageNfolder->pagename;

        if (isset($_SESSION['permission']) && count($_SESSION['permission']) > 0) {
            foreach ($_SESSION['permission'] as $keysession => $valuesession) {
                if ($pagename == $valuesession['page_name'] . ".php" && $valuesession['can_update'] == 1) {

                    return true;
                }
            }
        } else
            return false;
    }

    public function canDelete($pagename) {
        $pageNfolder = json_decode($this->getPageNfolderName($pagename));
        $pagename = $pageNfolder->pagename;
        if (isset($_SESSION['permission']) && count($_SESSION['permission']) > 0) {
            foreach ($_SESSION['permission'] as $keysession => $valuesession) {
                if ($pagename == $_SESSION['page_name'] && $valuesession['can_delete'] == 1) {
                    return true;
                } else
                    return false;
            }
        } else
            return false;
    }

    //-----------------session ends here---------------------//
    //-----------------student credential related functios starts here----------------------//
    
    public function studentUserNameExist($username) {
        if ($this->connectionId) {
            if ($username != '') {
                $userSql = "select student_id from " . $this->tbl_student . " where `student_id` = '" . $this->sqlEnjection($username) . "' and `status` = '1'";
                $cnt = $this->CountRecord($this->tbl_student, array("student_id" => $this->sqlEnjection($username)));
                if ($cnt > 0) {
                    return true;
                } else {
                    $this->setErrorMsg('Whoops! We didn\'t recognise your username or password. Please try again.');
                    return false;
                }
            } else {
                $this->setErrorMsg('Whoops! We didn\'t recognise your username. Please try again.');
                return false;
            }
        } else {
            $this->setErrorMsg('Database not connected.');
            return false;
        }
    }

    public function studentCheckLogin($username, $pass) {
        if ($this->connectionId) {
            if ($username != '' && $pass != '') {
//                $row = '';echo $username." ".$pass;die;
                $userSql = "select * from " . $this->tbl_student . " where `student_id` = '" . $this->sqlEnjection($username) . "' and `password` = '" . $this->sqlEnjection($pass) . "' and `status` = '1'";
                $cnt = $this->CountRecord($this->tbl_student, array("student_id" => $this->sqlEnjection($username), "password" => $this->sqlEnjection($pass)));
                
                if ($cnt > 0) {
                    if ($row = $this->getResult($userSql)) {
                        
                        return $row;
                    }
                } else {
                    $this->setErrorMsg('Invalid username or password.');
                    return false;
                }
            } else {
                $this->setErrorMsg('Please enter username or password.');
                return false;
            }
        } else {
            $this->setErrorMsg('Database not connected.');
        }
    }

}

//$cmn = new commonClass();
//
////$a = array('title' => 'Delhi', 'created' => 'now()');
////$cmn-> insertQry('tbl_state', $a );
////$ret = $cmn->selectQry('tbl_state');
//$res = $cmn->updateQry("tbl_state", array("title" => 'Rajasthan'), "id='4'");
//
//if ($res) {
//    $cmn->setSuccessMsg("Updated SuccessFully!");
//} else {
//    $cmn->setErrorMsg("Something-Unexpected Happened!");
//}
//echo$cmn->getSuccessMsg();
//echo$cmn->  getErrorMsg();
//$cmn->unsetMessage();
//echo "<pre>";
//echo$cmn->getLastInsertedId("tbl_state");
////print_R($ret);
?>