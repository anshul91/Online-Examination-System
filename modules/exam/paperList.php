<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}

if (!$commonObj->canAccess($_REQUEST['page'])) {
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("examFxn");

$exmFxn = new examFxn();
$exmData = json_decode($exmFxn->getPaperList());

//if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']='POST'){
//    $courseFxn->updateStatus();
//}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $exmFxn->getSuccessMsg();
            echo $exmFxn->getErrorMsg();
            $exmFxn->unsetMessage();
            ?>

            <h3 class="page-header">Listing Exam Paper's </h3>
            <?php if ($commonObj->canUpdate($_REQUEST['page'])) { ?>
                <a href="<?php echo SITE_URL . "?page=exam_paperDesc"; ?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_paper">Add Paper +</a>
            <?php } ?>
        </div>
    </div>
    <!-- /.col-lg-12 -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading" style="text-align:center;">
                    Paper List  
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Name</th>
                                    <th>subjects</th>
                                    <th>Duration(in minutes)</th>
                                    <th>Total Question</th>
                                    <th>Activation Code</th>
                                    <th>Right Marks</th>
                                    <th>Wrong Marks</th>
                                    <th>Choice option</th>
                                    <th>Question Ratio</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <form name='form1' method='post'>
                                <tbody>

                                    <?php $sno = 0; ?>
                                    <?php
                                    if (sizeof($exmData) > 0) {
                                        foreach ($exmData as $k => $v) {
                                            $sno++;
                                            ?>

                                            <tr>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $v->name; ?></td>
                                                <?php
                                                $subject = explode(",", $v->subject_id);
                                                $subjectname = array();
                                                foreach ($subject as $ke => $va) {
                                                    $sub_data = json_decode($exmFxn->getSubjectList(array("id" => $va)));

                                                    @$subjectname[$ke] = $sub_data[0]->name;
                                                }
                                                ?>


                                                <td><?php echo implode(",", $subjectname); ?></td>
                                                <td><?php echo $v->duration . " minutes"; ?></td>
                                                <td><?php echo $v->tot_question; ?></td>
                                                <td><?php echo $v->activation_code; ?></td>
                                                <td><?php echo $v->right_mark; ?></td>
                                                <td><?php echo $v->wrong_mark; ?></td>
                                                <td><?php echo ($v->options == '1') ? "4 OPTIONS" : "5 OPTIONS"; ?></td>
                                                <td><?php
                                                    $cnt = json_decode($exmFxn->getQuestionByPaperId($v->id));
                                                    echo count($cnt) . "/" . $v->tot_question;
                                                    ?>
                                                </td>
                                                <td><a href="<?php echo SITE_URL . "?page=exam_paperDesc&id=" . $exmFxn->encode($v->id); ?>">Alter</a>
                                                </td>

                                            </tr>
                                        <?php
                                        }
                                    }
                                    ?>


                                </tbody>
                            </form>
                        </table>

                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#dataTables-example').dataTable();
                        });
                    </script>