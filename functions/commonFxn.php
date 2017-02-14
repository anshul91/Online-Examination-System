<?php
class commonFxn extends commonClass
{
    
    public $imgExtension = array("jpg","jpeg","png");
    public $empImgUploadPath = "images/emp_img/";
    public $stuImgUploadPath = "images/stu_img/";
    
    public function begin(){
        
        $this->query("BEGIN");
    }
    public function commit(){
        $this->query("COMMIT");
    }
    public function rollback(){
        $this->query("ROLLBACK");
    }
    
    public function getAllLocations(){
        $data = $this->selectQry ($this->tbl_locations, '*', array("status"=>'1'));     
            return json_encode($data);     
    }    
    public function getAllUserRoles(){
        $data = $this->selectQry ($this->tbl_user_roles);     
        if(count($data)>0){
            return json_encode($data);     
        }else
            return false;
    }
   
    public function getQualification($filter = array()){
        
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';
        
        $query = "SHOW COLUMNS FROM ".$this->tbl_qualification;
        $qry = $this->query($query);
        while($result = mysql_fetch_assoc($qry)){
            if(isset($filter) && array_key_exists($result['Field'], $filter)){
               
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0)        {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_qualification, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
        
    }
    public function getEmpQualification($filter = array()){
        
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';
        
        $query = "SHOW COLUMNS FROM ".$this->tbl_emp_qualification;
        $qry = $this->query($query);
        while($result = mysql_fetch_assoc($qry)){
            if(isset($filter) && array_key_exists($result['Field'], $filter)){
               
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
        if (array_key_exists('tblcolumns', $filter) && is_array($filter['tblcolumns']) && count($filter['tblcolumns']) > 0)        {
            $columnFilter = implode(',', $this->sqlEnjection($filter['tblcolumns']));
        }

        $data = $this->selectQry($this->tbl_emp_qualification, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
        
    }
    
    public function uploadImage($filename,$imagetemp_path){
        if($this->checkExtension($filename)){
            $newName = time().md5($filename)."_".$filename;
        
            if(move_uploaded_file($imagetemp_path,BASE_PATH. $this->empImgUploadPath.$newName)){
                $this->setSuccessMsg("File uploaded successfully!");
                return $newName;
            }else{
                $this->setErrorMsg("Error in uploading file1....");
                return false;
            }
        }else{
            $this->setErrorMsg("allowed extensions is jpeg,jpg,png only");
            return false;
        }
            
    }
    public function uploadImageStu($filename,$imagetemp_path){
        if($this->checkExtension($filename)){
            $newName = time().md5($filename)."_".$filename;
        
            if(move_uploaded_file($imagetemp_path,BASE_PATH. $this->stuImgUploadPath.$newName)){
                $this->setSuccessMsg("File uploaded successfully!");
                return $newName;
            }else{
                $this->setErrorMsg("Error in uploading file1....");
                return false;
            }
        }else{
            $this->setErrorMsg("allowed extensions is jpeg,jpg,png only");
            return false;
        }
            
    }
    public function checkExtension($name){
        $chk = false;
        $fileName = explode(".", $name);
        $currentExtn = end($fileName);
        foreach($this->imgExtension as $k=>$v){
            if($currentExtn == $v){
                $chk = true;
                break;
            }
        }
        if($chk)
            return true;
        else
            return false;
    }
}
?>