<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
$commonObj->autoload("examFxn");
$commonObj->autoload("studentFxn");
$exmFxn = new examFxn();
$stdntFxn = new studentFxn();

if($commonObj->canAccess($_REQUEST['page']) || isset($_REQUEST['st_id'])){
    $st_id = $exmFxn->decode($_REQUEST['st_id']);
    $stdntData = json_decode($stdntFxn->getStudentOptPaper(array("stu_id"=>$st_id)));

}else if($commonObj->canAccess($_REQUEST['page'])){
    $stdntData = json_decode($stdntFxn->getStudentOptPaper());
}else{
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
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
            
            <h3 class="page-header">Listing Exam Packages </h3>
            
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    My Exam Package List  
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Package Name</th>
                                    <th>Type</th>
                                    <th>Duration</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th colspan="0" align="center">Status</th>
                                    <th colspan="0" align="center">Start Exam</th>
                                </tr>
                            </thead>
<form name='form1' method='post'>
                            <tbody>
                                
                                <?php $sno = 0; ?>
                                <?php
                                if(sizeof($stdntData)>0){
                                foreach ($stdntData as $k => $v) {
                                    $sno++;
                                    
                                    $pkg_data = json_decode($exmFxn->getPackageList(array("id"=>$v->pkg_id)));
                                            
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $pkg_data[0]->name; ?></td>
                                        <td><?php echo ($pkg_data[0]->type == 1)?'Paid':'Free'; ?></td>
                                        <td><?php echo $pkg_data[0]->duration_in_days." days"; ?></td>
                                        <td><?php echo $pkg_data[0]->size. " Papers."; ?></td>
                                        <td><?php echo $pkg_data[0]->price." /-Rs.   "; ?></td>
                                        <td><?php echo date('d-M-Y H:i:s',strtotime($v->start_date)); ?></td>
                                        <td><?php echo date('d-M-Y H:i:s',strtotime($v->end_date)); ?></td>
                                        <td><?php  if($v->paper_status == '0')echo "<font color='green'>Go For it!</font>";else if($v->paper_status == '1'){echo "<font color='orange'>Attempted Result Awaited!</font>";}else if($v->paper_status == '2'){echo "<font color='red'>Partially Attempted</font>";}?>
                                        </td><?php if(($v->start_date<=date('Y-m-d H:i:s')) && ($v->end_date>=date('Y-m-d H:i:s'))){?>
                                        <?php $ppr_url = SITE_URL . "?page=student_myExamPapers&pkg_id=". $exmFxn->encode($v->pkg_id);?>
                                        <td><a href="<?php echo $ppr_url;?>">Show Paper's</a></td>
                                        <?php }else{?>
                                        <td>Cannot attempt</td>
                                        <?php }?>
                                    </tr>
                                <?php } 
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