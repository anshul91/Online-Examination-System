<?php
/*
 * Last Modified:14-05-16
 * by : anshul pareek
 * used: to show result of student
 */

if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
//if(!$commonObj->canAccess($_REQUEST['page'])){
//    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
//    $commonObj->redirectUrl();
//    exit();
//}

$commonObj->autoload("examFxn");
$commonObj->autoload("studentFxn");
$exmFxn = new examFxn();
$stuFxn = new studentFxn();
if(isset($_REQUEST['ppr_id'])){
    $ppr_id = $exmFxn->decode($_REQUEST['ppr_id']);
}
if(isset($_SESSION['st_id']) && $_SESSION['st_id']!='' && !isset($ppr_id)){
    $resultData = json_decode($exmFxn->getPaperAttemptData(array("student_id"=>$_SESSION['st_id'],"is_completed"=>'1')));
    
}else if(isset($_SESSION['st_id']) && $_SESSION['st_id']!='' && isset($_REQUEST['ppr_id'])){
    $resultData = json_decode($exmFxn->getPaperAttemptData(array("student_id"=>$_SESSION['st_id'],"is_completed"=>'1',"ppr_id"=>$ppr_id)));
}else if(isset($_SESSION['emp_number']) && $_SESSION['emp_number']!=''){
    $resultData = json_decode($exmFxn->getPaperAttemptData(array("student_id"=>$_SESSION['st_id'],"is_completed"=>'1',"ppr_id"=>$ppr_id)));
}else{
    $exmFxn->setErrorMsg("No paper is submitted by any of the student yet!");
}


?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $exmFxn->getSuccessMsg();
            echo $exmFxn->getErrorMsg();
            $exmFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Exam Result </h3>
 
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Result
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Paper Name</th>
                                    <th>Student Name</th>
                                    <th>Student Id</th>
                                    <th>Total Ques.</th>
                                    <th>Questions Attempt</th>
                                    <th>Right Ques.</th>
                                    <th>Wrong Ques.</th>
<!--                                    <th>Positive Marks</th>
                                    <th>Negative Marks</th>-->
                                    <th>Max Marks</th>
                                    <th>Marks Obtain</th>
                                    <th>Average Timing</th>
                                    <th>Paper Started</th>
                                    <th>Paper Ended</th>
                                    <th>Summary</th>
                                </tr>
                            </thead>
<form name='form1' method='post'>
                            <tbody>
                                
                                <?php $sno = 0; ?>
                                <?php
                                
                                if(sizeof($resultData)>0){
                                foreach ($resultData as $k => $v) {
                                    //total questions
                                    $tot_ques = count(json_decode($exmFxn->getStudentExmTakenQues(array("student_id"=>$_SESSION['st_id'],"paper_id"=>$v->ppr_id))));
                                    
                                    $sno++;
                                    
                                    ?>
            <?php $ppr_data = json_decode($exmFxn->getPaperList(array("id"=>$v->ppr_id)));
            
                    $studentData = json_decode($stuFxn->getStudentList(array("id"=>$v->student_id)));
                    
            ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>                                        
                                        <td><?php echo $ppr_data[0]->name;?></td>
                                        <td><?php echo $studentData[0]->f_name." ".$studentData[0]->l_name;?></td>
                                        <td><?php echo $studentData[0]->student_id;?></td>
                                        <td><?php echo $tot_ques;?></td>
                                        <td><?php echo $v->total_ques_attempt; ?></td>
                                        <td><?php echo $v->total_right_ques; ?></td>
                                        <td><?php echo $v->total_wrong_ques; ?></td>
<!--                                        <td><?php //echo $v->positive_mark; ?></td>
                                        <td><?php //echo $v->negative_mark; ?></td>-->
                                        <td><?php echo $v->right_mark*$tot_ques;?></td>
                                        <td><?php echo $v->obtain_marks; ?></td>
                                        <?php 
                                            
                                        ?>
                                        <td><?php echo round(((strtotime($v->last_view_time)-strtotime($v->start_time))/60)/40,2)." Min"; ?></td>
                                        <td><?php echo date("d-M-Y H:i:s",strtotime($v->start_time)); ?></td>
                                        <td><?php echo date("d-M-Y H:i:s",strtotime($v->end_time)); ?></td>
                                        <td><a href='<?php echo SITE_URL . "?page=results_exam_resultSummary&ppr_id=" . $v->ppr_id; ?>' class="btn btn-primary btn-circle fa fa-list" data-toggle="tooltip" data-original-title='View Result Summary'data-placement='top'></a></td>
                                    </tr>
                                <?php }
                                }
                                ?>
                                    

                            </tbody>
                                </form>
                        </table>

                    </div>
                    <!-- /.table-responsive -->

                <!-- Core Scripts - Include with every page -->
<!--                <script src="<?php echo JS_URL;?>jquery-1.10.2.js"></script>
                <script src="<?php echo JS_URL;?>bootstrap.min.js"></script>
                <script src="<?php echo JS_URL;?>plugins/metisMenu/jquery.metisMenu.js"></script>

                 Page-Level Plugin Scripts - Tables 
                <script src="<?php echo JS_URL;?>plugins/dataTables/jquery.dataTables.js"></script>
                <script src="<?php echo JS_URL;?>plugins/dataTables/dataTables.bootstrap.js"></script>

                 SB Admin Scripts - Include with every page 
                <script src="<?php echo JS_URL;?>sb-admin.js"></script>-->

                <!-- Page-Level Demo Scripts - Tables - Use for reference -->
                <script>
                    $(document).ready(function () {
                        $('#dataTables-example').dataTable();
                    });
                </script>