<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canUpdate("course_batch_list") || !$commonObj->canAccess("course_batch_list")){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}

$commonObj->autoload("examFxn");
$examFxn = new examFxn();

if (isset($_REQUEST['id']))
    $userId = $examFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($examFxn->addSubject()) {
        header("location:" . SITE_URL . "?page=exam_subjectList");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    $examFxn->updateSubject($userId);
    header("location:" . SITE_URL . "?page=exam_subjectList");
    exit;
} else if (isset($_REQUEST['id'])) {
    $examData = json_decode($examFxn->getSubjectList(array('id' => $userId)));
    
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
echo $examFxn->getSuccessMsg();
echo $examFxn->getErrorMsg();
$examFxn->unsetMessage();
?>

            <h3 class="page-header">Batch Listing</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id']) ? "Update " : "Add "; ?> Subject<br />
                    </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    
                    <center><p>    <table border="0" cellspacing="15" cellpadding="5">
                            <tr>
                                                                
                                <td id="batch_sub_course" style="display:none;"></td>
                                <td>
                                    <label>Subject Name</label>
                                    <input type="text" name="sub_name" placeholder="enter subject name" class="form-control" value="<?php if(isset($_REQUEST['sub_name']))echo $_REQUEST['sub_name'];else if(isset($examData[0]))echo $examData[0]->name;?>">                                    
                                </td>
                                <td>
                                    <label>Description</label>
                                    <textarea placeholder="Description" class="form-control" name="sub_description"><?php if(isset($_REQUEST['sub_description']))echo $_REQUEST['sub_description'];else if(isset($examData[0]))echo $examData[0]->description;?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL . "?page=exam_subjectList"; ?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>
</p></center>