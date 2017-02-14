<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canUpdate("course_batch_list") || !$commonObj->canAccess("course_batch_list")){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}

$commonObj->autoload("courseFxn");
$commonObj->autoload("masterFxn");
$commonObj->autoload("employeeFxn");
$courseFxn = new courseFxn();
$empFxn = new employeeFxn();
$mstrFxn = new masterFxn();
$centerData = json_decode($mstrFxn->getCenterList());
$courseData = json_decode($courseFxn->getCourseList());
$empData = json_decode($empFxn->getEmployeeList());

if (isset($_REQUEST['id']))
    $userId = $courseFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($courseFxn->addBatch()) {
        header("location:" . SITE_URL . "?page=course_batch_list");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    $courseFxn->updateBatch($userId);
    header("location:" . SITE_URL . "?page=course_batch_list");
    exit;
} else if (isset($_REQUEST['id'])) {
    $batchData = json_decode($courseFxn->getBatchList(array('id' => $userId)));
    
}

$timingArr = array(0=>"1")
?>
<style>
    td,th{
        padding:10px;
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
<?php
echo $courseFxn->getSuccessMsg();
echo $courseFxn->getErrorMsg();
$courseFxn->unsetMessage();
?>

            <h3 class="page-header">Batch Listing</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id']) ? "Update " : "Add "; ?> Batch<br />

                    </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    
                    <center><p>    <table border="0" cellspacing="15" cellpadding="5">
                            <tr>
                                <td>
                                <label>Select Center </label>
                                    <select name="batch_center_id" class="form-control">
                                        <option value="">--Select Center--</option>
                                        <?php if($centerData){
                                            foreach($centerData as $k=>$v){                                                
                                         ?>                                        
                                        <option value="<?php echo $v->id;?>" <?php if(isset($_REQUEST['batch_center_id'])&&$_REQUEST['batch_center_id']==$v->id){echo "selected";}else if(isset($batchData[0]) && $batchData[0]->center_id==$v->id){echo "selected";}?>><?php echo $v->center_name;?></option>
                                        <?php                                            
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                
                                
                                <td>
                                    <label>Select Course </label>
                                    <select name="batch_course_id" class="form-control" onchange="getSubCourseList(this.value,'courseFxn','courseFxn','batch_sub_course','')">
                                        <option value=" ">--Select Course--</option>    
                                        <?php if($courseData){
                                            foreach($courseData as $k=>$v){                                                
                                         ?>                                        
                                        <option value="<?php echo $v->id;?>" <?php if(isset($_REQUEST['batch_course_id'])&&$_REQUEST['batch_course_id']==$v->id){echo "selected";}else if(isset($batchData[0]) && $batchData[0]->course_id==$v->id){echo "selected";}?>><?php echo $v->name;?></option>
                                        <?php                                            
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td id="batch_sub_course" style="display:none;"></td>
                            
                                
                                
                                <td>
                                    <label>Batch Name</label>
                                    <input type="text" name="batch_name" placeholder="enter batch name" class="form-control" value="<?php if(isset($_REQUEST['batch_name']))echo $_REQUEST['batch_name'];else if(isset($batchData[0]))echo $batchData[0]->name;?>">
                                    
                                </td>
                                
                                        
                       
                            <tr>
                                <td><?php 
                                    if(isset($batchData[0])){
                                        $trainer_data = explode(",", $batchData[0]->trainers);
                                        $x = sizeof($trainer_data);
                                    }
                                    ?>
                                    <label>Select Trainers</label>
                                    <select name="batch_trainers[]" class="form-control" multiple="" id="batch_trainers">
                          
                                        <?php 
                                        $i=0;
                                        foreach($empData as $empKey=>$empVal){
                                            if($i>=$x)
                                                $i=0;
                                        ?>
                                        <option value="<?php echo $empVal->id;?>" <?php if(isset($_REQUEST['batch_trainers']) && in_array($empVal->id,$_REQUEST['batch_trainers']))echo "selected";else if(isset($batchData[0]) && $trainer_data[$i]==$empVal->id){echo "selected";}?>><?php echo $empVal->f_name." ".$empVal->m_name." ".$empVal->l_name;?></option>
                                        <?php 
                                            $i++;                                        
                                        }
                                        ?>
                                    </select>
                                    
                                </td>
                                                               <td>
                                    <label>Start date</label>
                                    <input type="date" placeholder="start Date" class="form-control" name="batch_start_date" value="<?php if(isset($_REQUEST['batch_start_date']))echo $_REQUEST['batch_start_date'];else if(isset($batchData[0]))echo $batchData[0]->start_date;?>">
                                </td>
 
                                <td>
                                    <label>Description</label>
                                    <textarea placeholder="Description" class="form-control" name="batch_description"><?php if(isset($_REQUEST['batch_description']))echo $_REQUEST['batch_description'];else if(isset($batchData[0]))echo $batchData[0]->description;?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL . "?page=course_subCourseList"; ?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>
</p></center>

                    
<script>
    $(document).ready(function(){        
        var course_id = document.form1.batch_course_id.value;
        getSubCourseList(course_id,'courseFxn','courseFxn','batch_sub_course','<?php echo $batchData[0]->sub_course_id; ?>');
    });
</script>