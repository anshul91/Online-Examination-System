<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canAccess($_REQUEST['page'])){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("employeeFxn");
$commonObj->autoload("userFxn");
$userFxn = new userFunctions();
$empFxn = new employeeFxn();
$empData = json_decode($empFxn->getEmployeeList());

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $empFxn->getSuccessMsg();
            echo $empFxn->getErrorMsg();
            $empFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Listing Employee's </h3>
             <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=employee_employeeDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_employee">Add Employee +</a>
             <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Employee List                    
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Employee No.</th>
                                    <th>Employee Name</th>
                                    <th>Emp. No.</th>
                                    <th>Password</th>
                                    <th>User Group</th>
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>


                            <tbody>

                                <?php $sno = 0; ?>
                                <?php
                                foreach ($empData as $k => $v) {
                                    $sno++;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $v->emp_number; ?></td>
                                        <td><?php echo $v->f_name." ".$v->m_name." ".$v->l_name; ?></td>
                                        <td><?php echo $v->emp_number; ?></td>
                                        <td><div id="show_pwd<?php echo $sno;?>" class="btn btn-primary btn-xs" onclick = "showPassword(this.id,'<?php echo base64_decode($v->password); ?>')">Show password</div></td>
                                        <?php
                                        $userGroupData = json_decode($userFxn->getUserGroupData(array("id"=>$v->group_id)));
                                        ?>
                                        <td><?php echo $userGroupData[0]->group_name; ?></td>
                                        <td><a href="<?php echo SITE_URL . "?page=employee_employeeDesc&id=" . $empFxn->encode($v->id); ?>" class="btn btn-primary btn-xs">Alter</a>
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
                