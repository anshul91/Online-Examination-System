<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}

if(!$commonObj->canAccess($_REQUEST['page'])){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("courseFxn");
$commonObj->autoload("employeeFxn");
$batchFxn = new courseFxn();
$empFxn = new employeeFxn();
$batchData = json_decode($batchFxn->getBatchListLeftJoin());
if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']='POST'){
    $courseFxn->updateStatus();
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $batchFxn->getSuccessMsg();
            echo $batchFxn->getErrorMsg();
            $batchFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Listing Batch </h3>
            <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=course_batchDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_batch">Add Batch +</a>
            <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Batch List           
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Center</th>
                                    <th>Course</th>
                                    <th>Sub-Course</th>
                                    <th>Batch Name</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                    <th>Trainers</th>
                                    
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>
<form name='form1' method='post'>
                            <tbody>
                                
                                <?php $sno = 0; ?>
                                <?php
                                if(sizeof($batchData)>0){
                                foreach ($batchData as $k => $v) {
                                    $sno++;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $v->center_name; ?></td>
                                        <td><?php echo $v->course_name; ?></td>
                                        <td><?php echo $v->sub_course_name; ?></td>
                                        <td><?php echo $v->name; ?></td>
                                        <td><?php echo $v->start_date; ?></td>
                                        <td>
                                            <input type="hidden" value="<?php $v->id?>" name="batch_id">
                                            <?php if($v->is_completed==0){?><input type="submit" value="Deactive" name="submit" onclick="return confirm('Are you sure that course has been completed!')" class="btn btn-danger"><?php }else echo '<font color="red">Completed</font>"'; ?></td>
                                        
                                        <td>
                                            <?php $trainers = explode(",",$v->trainers);if(count($trainers)>0){$fullname='';
                                                for($i=0;$i<sizeof($trainers);$i++){
                                                $empData = json_decode($empFxn->getEmployeeList(array("id"=>$trainers[$i])));
                                                $fullname .= $empData[0]->f_name." ".$empData[0]->l_name.", ";
                                            }}
                                            ?>
                                            <?php echo rtrim($fullname,", "); ?>
                                            
                                        </td>
                            
                                                
                                        <td><a href="<?php echo SITE_URL . "?page=course_batchDesc&id=" . $batchFxn->encode($v->id); ?>">Alter</a>
                                        </td>

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