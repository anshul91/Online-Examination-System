<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employeeFxn
 *
 * @author Anshul
 */
class employeeFxn extends commonFxn {

    //put your code here
    public function addEmployee() {
        $chk=true;
        $level = array();
        $discipline = array();
        $college = array();
        $specialization = array();
        $passYear = array();
        $gpa_score = array();

        if (!$this->getRequestParamByPrefix("emp_", "required", '', '_')) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("emp_", "required", '', '_');
        
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
        
        if(!filter_var($para['email'], FILTER_VALIDATE_EMAIL)){
            $error['email'] = "Not a valid Email Id!";
        }
        if(!is_numeric($para['mobile'])){
            $error['mobile'] = "Mobile no. must be numeric!";
        }
        if(!is_numeric($para['zipcode']))
            $error['zipcode'] = "Zipcode can be numeric only!";
        if(!is_numeric($para['home_telephone']))
            $error['home_telephone'] = "home telephone can be numeric only!";
        if(!is_numeric($para['emer_mobile']))
            $error['emer_mob'] = "Emergency mobile no. can be numeric only!";
        $str = '';
        if(count($error)>0){
            foreach($error as $k=>$v){
                $str .=$v."   |  ";                 
            }
            $this->setErrorMsg(rtrim($str,"|  "));
            $chk=false;
        
        }
        
        if ($this->checkDuplicate($this->tbl_employee, "email", $para['email']) > 0) {
            $this->setErrorMsg("Duplicate Email Id Found!");
            return false;
        }
        
        $this->begin();
        $pwd = base64_encode(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"));
        $para['password'] = substr($pwd, 0,11);
        
        if(isset($_FILES['emp_image']) && !empty($_FILES['emp_image']['name'])){
            if($_FILES['emp_image']['error'] == 0)
            {
                if($imgName = $this->uploadImage($_FILES['emp_image']['name'],$_FILES['emp_image']['tmp_name']))
                {
                    $para['image'] = $imgName;
                    
                    $chk = true;
                }
            }else{
                $chk = false;
                
            }
        }
        if (!$this->insertQry($this->tbl_employee, $para)) {
            $chk = false;
        }
        $lst_id = mysql_insert_id();
        //adding new employee number
        $emp_number = "NAT/".date("Ymd")."/".$lst_id;
        
        if(!$this->updateQry($this->tbl_employee, array("emp_number"=>$emp_number), array("id"=>$lst_id)))
        {
            $chk= false;
        }
        for($i=0;$i<sizeof($level);$i++){
            $query = "insert into ".$this->tbl_emp_qualification." set emp_id=".$lst_id.",level='".$level[$i]."',discipline='".$discipline[$i]."',college='".$college[$i]."' ,specialization='".$specialization[$i]."' ,passYear='".$passYear[$i]."' ,gpa_score='".$gpa_score[$i]."'";
            if(!$this->query($query)){
                $chk=false;                
            }
        }
        
        
        if($chk){
            $this->query("COMMIT");
            
            //mail password if record inserted
            $msg= "testing message for email <br><b>username:</b>".$para['email']."<br><b>password:</b>".$para['password'];
            if(mail($para['email'],"Registered successfully!",$msg))
            {
                $this->setSuccessMsg("Email Sent Successfully!");
            }else{
                $this->setErrorMsg("Email cannot be Sent!");
            }
            $this->setSuccessMsg("Record Added Successfully!");
        }else{
            $this->query ("ROLLBACK");
            $this->setErrorMsg("Something Unexpected Happened! Record cannot be added!");
        }
            
        }
    
    public function updateEmployee($empId) {
        $chk=true;
        $level = array();
        $discipline = array();
        $college = array();
        $specialization = array();
        $passYear = array();
        $gpa_score = array();

        if (!$this->getRequestParamByPrefix("emp_", "required", '', '_')) {
            return false;
        } else
            $para = $this->getRequestParamByPrefix("emp_", "required", '', '_');
        
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
        
        if(!filter_var($para['email'], FILTER_VALIDATE_EMAIL)){
            $error['email'] = "Not a valid Email Id!";
        }
//        if(!is_numeric($gpa_score['gpa_score'])){
//            $error['gpa'] = "GPA/Score must be numeric";
//        }
        if(!is_numeric($para['mobile'])){
            $error['mobile'] = "Mobile no. must be numeric!";
        }
        if(!is_numeric($para['zipcode']))
            $error['zipcode'] = "Zipcode can be numeric only!";
        if(!is_numeric($para['home_telephone']))
            $error['home_telephone'] = "home telephone can be numeric only!";
        if(!is_numeric($para['emer_mobile']))
            $error['emer_mob'] = "Emergency mobile no. can be numeric only!";
        $str = '';
        if(count($error)>0){
            foreach($error as $k=>$v){
                $str .=$v."   |  ";                 
            }
            $this->setErrorMsg(rtrim($str,"|  "));
            $chk=false;
        
        }
       
        if ($this->CountRecord($this->tbl_employee, "id!=".$empId." and email='".$para['email']."'") > 0) {
            $this->setErrorMsg("Duplicate Email Id Found!");
            return false;
        }
        
        $this->begin();
        $emp_data = json_decode($this->getEmployeeList(array("id"=>$empId)));
        
        $old_image = $emp_data[0]->image;
        if(isset($_FILES['emp_image']) && !empty($_FILES['emp_image']['name'])){
            if($_FILES['emp_image']['error'] == 0)
            {
                if($imgName = $this->uploadImage($_FILES['emp_image']['name'],$_FILES['emp_image']['tmp_name']))
                {
                    $para['image'] = $imgName;
                    $chk = true;
                }
            }else{
                $chk = false;
                
            }
        }else{
           // $para['image'] = $old_image;
        }
        
        if (!$this->updateQry($this->tbl_employee, $para,array("id"=>$empId))) {
            $chk = false;
            
        }
        if(count($this->selectQry($this->tbl_emp_qualification,'',array("emp_id"=>$empId)))>0){
            if(!$this->deleteData($this->tbl_emp_qualification, array("emp_id"=>$empId))){
                $chk = false;
                
            }
        }
        for($i=0;$i<sizeof($level);$i++){
            $query = "insert into ".$this->tbl_emp_qualification." set emp_id=".$empId.",level='".$level[$i]."',discipline='".$discipline[$i]."',college='".$college[$i]."' ,specialization='".$specialization[$i]."' ,passYear='".$passYear[$i]."' ,gpa_score='".$gpa_score[$i]."'";
            if(!$this->query($query)){
                $chk=false;                
            }
        }
        if($chk){
            if(isset($_FILES['emp_image']) && !empty($_FILES['emp_image']['name'])){
                unlink(BASE_PATH.$this->empImgUploadPath.$old_image);
            }            
            $this->query("COMMIT");
            
            $this->setSuccessMsg("Record Updated Successfully!");
            return true;
        }else{
            $this->query ("ROLLBACK");
            $this->setErrorMsg("Something Unexpected Happened! Record cannot be Updated!");
            return false;
        }
            
        }
    public function getEmployeeList($filter = array()){
        $condition = array();
        $columnFilter = '*';
        $groupordercondition = '';
        $limitrecord = '';
        
        $query = "SHOW COLUMNS FROM ".$this->tbl_employee;
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

        $data = $this->selectQry($this->tbl_employee, $columnFilter, $condition, $groupordercondition, $limitrecord);
        if (count($data) > 0)
            return json_encode($data);
        else
            return false;
        
    }
}
    