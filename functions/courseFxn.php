<?php
/**
 * Description of courseFxn
 *
 * @author Anshul
 */
class courseFxn extends commonFxn {
    //put your code here
    public function addCourse(){        
        if (!$this->getRequestParamByPrefix("course_","_", "required")) {
            return false;
        } else
            
            $para = $this->getRequestParamByPrefix("course_","required","","_");

        if ($this->checkDuplicate($this->tbl_course, "name", $para['name']) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }
        if ($this->insertQry($this->tbl_course, $para)) {
            $this->setSuccessMsg("Course Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }
    
    public function updateCourse($courseId) {
        $para = $this->getRequestParamByPrefix("course_", "required","","_");

        if ($this->checkDuplicate($this->tbl_course, "name", $para['name']) > 1) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_course, $para, array('id' => $courseId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    public function getCourseList($filter = array())
    {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';
        
        $query = "SHOW COLUMNS FROM ".$this->tbl_course;
        $qry = $this->query($query);
        while($result = mysql_fetch_assoc($qry)){
            if(isset($filter) && array_key_exists($result['Field'], $filter)){
               
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0)        {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_course, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }
    
    //=====================sub course code starts------------------//
    
    
    public function addSubCourse(){
        
        if (!$this->getRequestParamByPrefix("sub_","required","","_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("sub_","required","","_");
        if($_REQUEST['courseId']==''){
            $this->setErrorMsg("Please select course first!");
            return false;
        }
        $para['course_id'] = $this->sqlEnjection($_REQUEST['courseId']);
        if ($this->CountRecord($this->tbl_sub_course, "course_id=".$para['course_id']." and name='".$para['name']."'") > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }
        
        if ($this->insertQry($this->tbl_sub_course, $para)) {
            $this->setSuccessMsg("Sub-Course Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }
    
    public function updateSubCourse($subCourseId) {
        if (!$this->getRequestParamByPrefix("sub_","required","","_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("sub_","required","","_");
        
        $para['course_id'] = $this->sqlEnjection($_REQUEST['courseId']);
        if ($this->CountRecord($this->tbl_sub_course,"course_id!=".$para['course_id']." and name='".$para['name']."'") > 1) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }

        if ($this->updateQry($this->tbl_sub_course, $para, array('id' => $subCourseId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }

    
    public function getSubCourseList($filter = array())
    {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';
        
        $query = "SHOW COLUMNS FROM ".$this->tbl_sub_course;
        $qry = $this->query($query);
        while($result = mysql_fetch_assoc($qry)){
            if(isset($filter) && array_key_exists($result['Field'], $filter)){
               
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0)        {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }
        
        $data = $this->selectQry($this->tbl_sub_course, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }
    //--------------------------sub course functions ends here------------------//
    
    //--------------------------batch functions starts here--------------------//
    public function addBatch(){
        
            if (!$this->getRequestParamByPrefix("batch_","required","","_")) {
            return false;
        } else            
            $para = $this->getRequestParamByPrefix("batch_","required","","_");
        $trainers = array();
        $trainers = implode(",",$para['trainers']);
        unset($para['trainers']);
        $para['trainers'] = $trainers;
        if ($this->checkDuplicate($this->tbl_batch, "name", $para['name']) > 0) {
            $this->setErrorMsg("Duplicate Record Found!");
            return false;
        }
        if ($this->insertQry($this->tbl_batch, $para)) {
            $this->setSuccessMsg("Batch Added Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting data!");
            return false;
        }
    }
    public function updateBatch($batchId) {
        
        if (!$this->getRequestParamByPrefix("batch_","required","","_")) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("batch_","required","","_");
        $trainers = array();
        if(isset($para['trainers'])){
            $trainers = implode(",",$para['trainers']);
            unset($para['trainers']);
            $para['trainers'] = $trainers;
        
        }
//
//        if ($this->CountRecord($this->tbl_batch,"id!=".$para['']." and name='".$para['name']."'") > 1) {
//            $this->setErrorMsg("Duplicate Record Found!");
//            return false;
//        }

        if ($this->updateQry($this->tbl_batch, $para, array('id' => $batchId))) {
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        } else {
            $this->setErrorMsg("Something Unexpected Happened when inserting Group Details!");
            return false;
        }
    }
    
    public function getBatchList($filter = array())
    {
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';
        
        $query = "SHOW COLUMNS FROM ".$this->tbl_batch;
        $qry = $this->query($query);
        while($result = mysql_fetch_assoc($qry)){
            if(isset($filter) && array_key_exists($result['Field'], $filter)){
               
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0)        {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }
        
        $data = $this->selectQry($this->tbl_batch, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
    }
    public function getBatchListLeftJoin(){
        $query = "select t1.*,t2.name as sub_course_name,t3.center_name,t4.name as course_name from tbl_batch t1 left join tbl_sub_course t2 on t1.sub_course_id=t2.id left join tbl_center t3 on t1.center_id=t3.id left join tbl_course t4 on t2.course_id=t4.id";
        
        
        $data = $this->getResult($query);
        //print_r($data);die;
        if (count($data) >= 1)
            return $data;
        else
            return false;
    }

}
