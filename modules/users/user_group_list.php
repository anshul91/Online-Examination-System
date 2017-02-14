<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canAccess($_REQUEST['page'])){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("userFxn");

$userFxn = new userFunctions();
$userData = json_decode($userFxn->getUserGroupData());

?>
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-12">
            <?php
            echo $userFxn->getSuccessMsg();
            echo $userFxn->getErrorMsg();
            $userFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Listing User Group </h3>
            <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=users_user_group_desc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_group">Add Group +</a>
            <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    User Group List                    
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Group Name</th>
                                    <th>Group Description</th>
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>


                            <tbody>

                                <?php $sno = 0; ?>
                                <?php
                                foreach ($userData as $k => $v) {
                                    $sno++;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $v->group_name; ?></td>
                                        <td><?php echo $v->group_description; ?></td>
                                        <td><a href="<?php echo SITE_URL . "?page=users_user_group_desc&id=" . $userFxn->encode($v->id); ?>">Alter</a>  |           
                                            <a href="<?php echo SITE_URL . "?page=users_user_group_permission&group_id=" . $userFxn->encode($v->id); ?>">Permission</a>
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
                </script>