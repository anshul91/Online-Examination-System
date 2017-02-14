<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if (!$commonObj->canUpdate("course_batch_list") || !$commonObj->canAccess("course_batch_list")) {
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}

$commonObj->autoload("examFxn");
$examFxn = new examFxn();
$subjectList = json_decode($examFxn->getSubjectList());
if (isset($_REQUEST['id']))
    $userId = $examFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($examFxn->addPaper()) {
        header("location:" . SITE_URL . "?page=exam_paperList");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    if ($examFxn->updatePaper($userId))
        header("location:" . SITE_URL . "?page=exam_paperList");
    else
        header("location:" . SITE_URL . "?page=exam_paperDesc&id=" . $_REQUEST['id']);
    exit;
} else if (isset($_REQUEST['id'])) {
    $examData = json_decode($examFxn->getPaperList(array('id' => $userId)));
}
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

            <h3 class="page-header">Paper</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id']) ? "Update " : "Add "; ?> Paper<br />
                    </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

                    <center><p>    <table border="0" cellspacing="15" cellpadding="5">
                            <tr>

                                <td id="package_name" style="display:none;"></td>
                                <td>
                                    <label>Paper Name</label>
                                    <input type="text" name="pkg_name" placeholder="Enter Package name" class="form-control" value="<?php if (isset($_REQUEST['pkg_name'])) echo $_REQUEST['pkg_name'];else if (isset($examData[0])) echo $examData[0]->name; ?>">                                    
                                </td>

                                <td>
                                    <label>Paper duration(in minutes)</label>
                                    <input type="text" name="pkg_duration" placeholder="Enter paper duration" class="form-control" value="<?php if (isset($_REQUEST['pkg_duration'])) echo $_REQUEST['pkg_duration'];else if (isset($examData[0])) echo $examData[0]->duration; ?>" id="duration">                                    
                                </td>
                                <td>
                                    <label>Options</label>
                                    <select name="pkg_options" class="form-control">
                                        <option value="">--Select Options--</option>
                                        <option value="1"<?php
                                        if (@$_REQUEST['pkg_options'] == '1') {
                                            echo "selected";
                                        } else if (@$examData[0]->options == '1') {
                                            echo "selected";
                                        }
                                        ?>>4 OPTIONS</option>
                                        <option value="2"<?php
                                        if (@$_REQUEST['pkg_options'] == '2') {
                                            echo "selected";
                                        } else if (@$examData[0]->options == '2') {
                                            echo "selected";
                                        }
                                        ?>>5 OPTIONS</option>
                                    </select>
                                </td>

                                <td>
                                    <label>Select Subjects</label>
                                    <select name="ppr_subject[]" class="form-control" id="pkg_subject" onclick="showPaid(this.value)" multiple="true">

                                        <?php
                                        $ii = 0;
                                        $sub_arr = array();
                                        if (isset($examData[0])) {
                                            $sub_arr = explode(",", $examData[0]->subject_id);
                                        }
                                        foreach ($subjectList as $k => $v) {
                                            ?>
                                            <option value="<?php echo $v->id; ?>"<?php
                                            if (@$_REQUEST['ppr_subject'][$ii] == $v->id) {
                                                echo "selected";
                                                $ii++;
                                            } else if (@$sub_arr[$ii] == $v->id) {
                                                echo "selected";
                                                $ii++;
                                            }
                                            ?>><?php echo $v->name; ?></option>
                                                <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="display:nne;">
                                    <label>Total Questions</label>
                                    <input type="text" name="pkg_tot_question" placeholder="Enter Total question" class="form-control" value="<?php if (isset($_REQUEST['pkg_tot_question'])) echo $_REQUEST['pkg_tot_question'];else if (isset($examData[0])) echo $examData[0]->tot_question; ?>" id="size">                                    
                                </td>
                                <td style="display:one;">
                                    <label>Activation code</label>
                                    <input type="text" name="pkg_activation_code" placeholder="Enter paper activation code" class="form-control" value="<?php if (isset($_REQUEST['pkg_activation_code'])) echo $_REQUEST['pkg_activation_code'];else if (isset($examData[0])) echo $examData[0]->activation_code; ?>" id="price">     
                                </td>

                                <td>
                                    <label>Marks for right answer</label>
                                    <input type="number" name="pkg_right_mark" placeholder="Enter Right marks" class="form-control" value="<?php if (isset($_REQUEST['pkg_right_marks'])) echo $_REQUEST['pkg_right_marks'];else if (isset($examData[0])) echo $examData[0]->right_mark; ?>" id="right" step='.1'>
                                </td>

                                <td>
                                    <label>Marks for wrong answer</label>
                                    <input type="number" name="pkg_wrong_mark" placeholder="Enter wrong marks" class="form-control" value="<?php if (isset($_REQUEST['pkg_right_marks'])) echo $_REQUEST['pkg_right_marks'];else if (isset($examData[0])) echo $examData[0]->right_mark; ?>" id="right" step='.1'>
                                </td>
                            </tr>
                            <tr>

                                <td colspan="5">
                                    <label>Description/Declarations</label>
<!--                                    <textarea name="pkg_description" placeholder="Enter Package Declaration" class="form-control"><?php
                                    $pkg_description = '';
                                    if (isset($_REQUEST['pkg_description']))
                                        $pkg_description = $_REQUEST['pkg_description'];else if (isset($examData[0]))
                                        $pkg_description = $examData[0]->description;
                                    ?></textarea>-->
<?php $ckeditor->editor('pkg_description', $pkg_description, array("width" => 1000, "height" => 90, "placeholder" => "test")); ?>

                                </td>


                            </tr>

                            <tr>
                                <td colspan="5" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning" id='save'/>
                                    <a href="<?php echo SITE_URL . "?page=exam_packageList"; ?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>
                </p></center>

                <script>
                    $(function () {                        
                        $("#save").click(function () {
                            cnt=0;
                            $("#pkg_subject option:selected").each(function () {
                                cnt++;
                            });         
                            
                            if((parseInt($("#size").val()%cnt)) !== 0){
                                alert("Please enter size of questions divisible by No. of subjects");
                                return false;
                            }
                        });
                    });
                </script>
