<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}

if(!$commonObj->canUpdate("course_courseList") || !$commonObj->canAccess("course_courseList")){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("courseFxn");
$courseFxn = new courseFxn();

if (isset($_REQUEST['id']))
    $userId = $courseFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($courseFxn->addCourse()) {
        header("location:" . SITE_URL . "?page=course_courseList");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    $courseFxn->updateCourse($userId);
      
    
} else if (isset($_REQUEST['id'])) {
    $courseData = json_decode($courseFxn->getCourseList(array('id' => $userId)));
//    print_r($group_data);die;
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $courseFxn->getSuccessMsg();
            echo $courseFxn->getErrorMsg();
            $courseFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">User Group</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id'])?"Update ":"Add ";?> Course<br />
                        
        </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <center>
                        <table width="80%" border="0" cellspacing="5" cellpadding="5">

                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter Course name </th>
                                <td width="50%"><input type="text" name="course_name" placeholder ="Enter Course Name" size="30" class="form-control" value="<?php if (isset($_REQUEST['course_name'])) {
                echo $_REQUEST['course_name'];
            } else if (isset($courseData[0])) {
                echo $courseData[0]->name;
            } else {
                echo "";
            } ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;"> Description </th>
                                <td width="50%"><textarea class="form-control" placeholder="Enter Group Description" name="course_description"><?php if (isset($_REQUEST['course_description'])) {
                echo $_REQUEST['course_description'];
            } elseif (isset($courseData[0])) {
                echo $courseData[0]->description;
            } else {
                echo "";
            } ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL."?page=course_courseList";?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>