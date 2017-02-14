<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canAccess($_REQUEST['page'])){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("masterFxn");

$locationFxn = new masterFxn();
$locationData = json_decode($locationFxn->getLocationList());

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $locationFxn->getSuccessMsg();
            echo $locationFxn->getErrorMsg();
            $locationFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Listing Locations </h3>
            <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=master_mstr_locationDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_location">Add Location +</a>
            <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Location's List                    
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Location Name</th>
                                    <th>Mail To</th>
                                    <th>Mail cc</th>
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $sno = 0; ?>
                                <?php
                                if(count($locationData)>0)
                                foreach ($locationData as $k => $v) {
                                    $sno++;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $v->name; ?></td>
                                        <td><?php echo $v->mail_to; ?></td>
                                        <td><?php echo $v->mail_cc; ?></td>
                                        <td><a href="<?php echo SITE_URL . "?page=master_mstr_locationDesc&id=" . $locationFxn->encode($v->id); ?>">Alter</a>
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