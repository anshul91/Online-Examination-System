<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}

if(!$commonObj->canUpdate("course_subCourseList") || !$commonObj->canAccess('course_subCourseList')){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("courseFxn");
$courseFxn = new courseFxn();

$courseData = json_decode($courseFxn->getCourseList());
    
if (isset($_REQUEST['id']))
    $userId = $courseFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($courseFxn->addSubCourse()) {
        header("location:" . SITE_URL . "?page=course_subCourseList");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    $courseFxn->updateSubCourse($userId);
    header("location:" . SITE_URL . "?page=course_subCourseList");
    exit;
} else if (isset($_REQUEST['id'])) {
    $subCourseData = json_decode($courseFxn->getSubCourseList(array('id' => $userId)));
    
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
                    <center><?php echo isset($_REQUEST['id']) ? "Update " : "Add "; ?> Course<br />

                    </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <center>
                        <table width="80%" border="0" cellspacing="5" cellpadding="5">
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;">Select Course </th>
                                <td width="50%"><select name="courseId">
                                    <option value="">--Select Course--</option>    
                                    <?php if($courseData){
                                            foreach($courseData as $k=>$v){                                                
                                         ?>                                        
                                        <option value="<?php echo $v->id;?>" <?php if(isset($_REQUEST['courseId'])&&$_REQUEST['courseId']==$v->id){echo "selected";}else if(isset($subCourseData[0]) && $subCourseData[0]->course_id==$v->id){echo "selected";}?>><?php echo $v->name;?></option>
                                        <?php                                            
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td id="sub_course">
                                    
                                </td>
                            </tr>
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter Sub-Course name </th>
                                <td width="50%"><input type="text" name="sub_name" placeholder ="Enter Sub-Course Name" size="30" class="form-control" value="<?php
                                    if (isset($_REQUEST['sub_name'])) {
                                        echo $_REQUEST['sub_name'];
                                    } else if (isset($subCourseData[0])) {
                                        echo $subCourseData[0]->name;
                                    } else {
                                        echo "";
                                    }
                                    ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;"> Description </th>
                                <td width="50%"><textarea class="form-control" placeholder="Enter Sub-Group Description" name="sub_description"><?php
                                        if (isset($_REQUEST['sub_description'])) {
                                            echo $_REQUEST['sub_description'];
                                        } elseif (isset($subCourseData[0])) {
                                            echo $subCourseData[0]->description;
                                        } else {
                                            echo "";
                                        }
                                        ?></textarea>
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