<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}

//if(!$commonObj->canAccess($_REQUEST['page'])){
//    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
//    $commonObj->redirectUrl();
//    exit();
//}

$commonObj->autoload("examFxn");
$exmFxn = new examFxn();
if (isset($_REQUEST['pkg_id'])) {
    $pkg_id = $exmFxn->decode($_REQUEST['pkg_id']);
    $pprData = json_decode($exmFxn->getPaperOfPkg(array("pkg_id" => $pkg_id)));
    $pkg_data = json_decode($exmFxn->getPackageList(array("pkg_id" => $pkg_id)));
    $pkg_name = $pkg_data[0]->name;
} else {
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
}


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

            <h3 class="page-header">My Exam Paper's </h3>

        </div>
    </div>
    <!-- /.col-lg-12 -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading" style="text-align:center;">
                    Package: <b><?php echo ucwords($pkg_name); ?></b>
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
                                    <th>Duration(in min.)</th>
                                    <th>Total Ques.</th>
                                    <th>Activation Code</th>
                                    <th>Right Marks</th>
                                    <th>Wrong Marks</th>
                                    <!--<th>Choice option</th>-->
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <form name='form1' method='post'>
                                <tbody>

                                    <?php $sno = 0;
                                    $ii = 0; 
                                    $ppr_cnt = 0;
                                    ?>
                                    <?php
                                    if (sizeof($pprData) > 0) {
                                        //getting papers already attempted
                                        
//                                        PRINT_r($attempted_ppr);
                                        foreach ($pprData as $k => $v) {
                                            $selected_ppr_data = json_decode($exmFxn->getStudentSelectedPapers(array("ppr_id"=>$v->paper_id,"st_id"=>$_SESSION['st_id'])));
                                            
                                            $sno++;
                                            //getting paper details by pkg id
                                            $exmData = json_decode($exmFxn->getPaperList(array("paper_id" => $v->paper_id)));
                                            ?>

                                            <tr>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $exmData[$ii]->name; ?></td>
                                                <?php
                                                $subject = explode(",", $exmData[$ii]->subject_id);
                                                $subjectname = array();

                                                foreach ($subject as $ke => $va) {
                                                    $sub_data = json_decode($exmFxn->getSubjectList(array("id" => $va)));
                                                    @$subjectname[$ke] = $sub_data[0]->name;
                                                }
                                                ?>


                                                <td><?php echo implode("<br>", $subjectname); ?></td>
                                                <td><?php echo $exmData[$ii]->duration . " minutes"; ?></td>
                                                <td><?php echo $exmData[$ii]->tot_question; ?></td>
                                                <td><?php echo $exmData[$ii]->activation_code; ?></td>
                                                <td><?php echo $exmData[$ii]->right_mark; ?></td>
                                                <td><?php echo $exmData[$ii]->wrong_mark; ?></td>
<!--                                                <td><?php echo ($exmData[$ii]->options == '1') ? "4 OPTIONS" : "5 OPTIONS"; ?>
                                                </td>-->
                                                <td>
                                                    <?php
                                                        
                                                        if($ppr_cnt>count($selected_ppr_data)){
                                                            $ppr_cnt = 0;
                                                        }
                                                    ?>
                                                    <?php if ($selected_ppr_data[0]->attempt_status ==='1') {?>
                                                    <a href="<?php echo SITE_URL . "?page=exam_exmDeclaration&ppr_id=" . $exmFxn->encode($v->paper_id); ?>" class="btn btn-primary btn-warning btn-xs">Incomplete Exam</a>
                                                    <?php 
                                                    }else if ($selected_ppr_data[0]->attempt_status ==='2') {
                                                    ?>                                                    
                                                    <a href="<?php echo SITE_URL . "?page=results_exam_result_list&ppr_id=" . $exmFxn->encode($v->paper_id); ?>" class="btn btn-primary btn-info btn-xs">View Result</a>
                                                    <?php $ppr_cnt++;}else{ ?>
                                                    <a href="<?php echo SITE_URL . "?page=exam_exmDeclaration&ppr_id=" . $exmFxn->encode($v->paper_id); ?>" class="btn btn-primary btn-success btn-xs">Start Paper</a>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                            <?php
                                            $ii++;
                                        }
                                    }
                                    ?>


                                </tbody>
                            </form>
                        </table>
                        <center><a href="<?php echo SITE_URL . "?page=student_myExamPackage&st_id=" . $exmFxn->encode($_SESSION['st_id']); ?>" class="btn btn-outline btn-primary" >Back</a></center>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#dataTables-example').dataTable();
                        });
                    </script>