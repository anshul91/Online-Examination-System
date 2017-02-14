<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canUpdate("master_mstr_center_list") || !$commonObj->canAccess("master_mstr_center_list")){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}


$commonObj->autoload("masterFxn");

$mstrFxn = new masterFxn();
$locationData = json_decode($mstrFxn->getAllLocations());

if (isset($_REQUEST['id']))
    $userId = $mstrFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($mstrFxn->addCenter()) {
        header("location:" . SITE_URL . "?page=master_mstr_center_list");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    $mstrFxn->updateCenter($userId);
    header("location:" . SITE_URL . "?page=master_mstr_center_list");
    exit;
} else if (isset($_REQUEST['id'])) {
    $centerData = json_decode($mstrFxn->getCenterList(array('id' => $userId)));    
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
echo $mstrFxn->getSuccessMsg();
echo $mstrFxn->getErrorMsg();
$mstrFxn->unsetMessage();
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
                                <label>Select Location</label>
                                    <select name="center_loc_id" class="form-control">
                                        <option value="">--Select Location--</option>
                                        <?php if($locationData){
                                            foreach($locationData as $k=>$v){                                                
                                         ?>                                        
                                        <option value="<?php echo $v->id;?>" <?php if(isset($_REQUEST['center_loc_id'])&&$_REQUEST['center_loc_id']==$v->id){echo "selected";}else if(isset($centerData[0]) && $centerData[0]->center_loc_id==$v->id){echo "selected";}?>><?php echo $v->name;?></option>
                                        <?php                                            
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                
                                <td>
                                    <label>Center Name</label>
                                    <input type="text" name="center_name" placeholder="enter center name" class="form-control" value="<?php if(isset($_REQUEST['center_name']))echo $_REQUEST['center_name'];else if(isset($centerData[0]))echo $centerData[0]->center_name;?>">
                                    
                                </td>
                                <td>
                                    <label>Center Code</label>
                                    <input type="text" placeholder="center code" class="form-control" name="center_code" value="<?php if(isset($_REQUEST['center_code']))echo $_REQUEST['center_code'];else if(isset($centerData[0]))echo $centerData[0]->center_code;?>">
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