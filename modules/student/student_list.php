<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canAccess($_REQUEST['page'])){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("studentFxn");
$commonObj->autoload("courseFxn");
$commonObj->autoload("userFxn");
$userFxn = new userFunctions();
$studentFxn = new studentFxn();
$courseFxn = new courseFxn();
$studentData = json_decode($studentFxn->getStudentListByAccess());
//print_r($studentData);die;

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $studentFxn->getSuccessMsg();
            echo $studentFxn->getErrorMsg();
            $studentFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Student Listing</h3>
             <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=student_studentDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_employee">Add Student +</a>
             <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Student's List                    
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Student Id.</th>
                                    <th>Student Name</th>
                                    <th>Father's Name</th>
                                    <th>Password</th>
                                    <th>Batch</th>
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>


                            <tbody>

                                <?php $sno = 0; ?>
                                <?php
                                foreach ($studentData as $k => $v) {
                                    $sno++;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $v->student_id; ?></td>
                                        <td><?php echo $v->f_name." ".$v->m_name." ".$v->l_name; ?></td>
                                        <td><?php echo $v->father_name; ?></td>
                                        <?php
                                            $batch = '';
                                            $batchArr = explode(",",$v->batch_join);
                                            if(count($batchArr)>0){
                                                
                                                for($i=0;$i<sizeof($batchArr);$i++){
                                                    $batches = json_decode($courseFxn->getBatchList(array("id"=>$batchArr[$i])));
                                                if(count($batches)>0)
                                                    $batch .= $batches[0]->name.",";
                                                }
                                                $batch = rtrim($batch," ,");
                                            }
                                        ?>
                                        <td><div id="show_pwd<?php echo $sno;?>" class="btn btn-primary btn-xs" onclick = "showPassword(this.id,'<?php echo $v->password; ?>')">Show password</div></td>
                                        <td><?php echo $batch; ?></td>                                       
                                        
                                        <td><a href="<?php echo SITE_URL . "?page=student_studentDesc&id=" . $studentFxn->encode($v->id); ?>">Alter</a>
                                        </td>

                                    </tr>
                                <?php } ?>


                            </tbody>

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
                    
                    //shows password on click div of show password
                    function showPassword(id,pwd){
                        if(pwd !== '' && pwd != $("#"+id).html()){      
                            $("#"+id).html(pwd);
                        }else{
                            $("#"+id).html("Show Password");
                        }
                    }
                </script>