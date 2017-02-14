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
$centerFxn = new masterFxn();

$centerData = json_decode($centerFxn->getCenterList(array("order_by_asc"=>"center_loc_id")));
if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']='POST'){
    $centerFxn->updateStatus();
}

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $centerFxn->getSuccessMsg();
            echo $centerFxn->getErrorMsg();
            $centerFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Listing Batch </h3>
             <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=master_mstr_centerDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_center">Add center +</a>
             <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Center's List           
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Location</th>
                                    <th>Center Name</th>
                                    <th>Center Code</th>
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>
<form name='form1' method='post'>
                            <tbody>
                                
                                <?php $sno = 0; ?>
                                <?php
                                if(sizeof($centerData)>0){
                                foreach ($centerData as $k => $v) {
                                    $sno++;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <?php $loc = json_decode($centerFxn->getLocationList(array("id"=>$v->center_loc_id)));?>
                                        <td><?php echo $loc[0]->name;?></td>
                                        
                                        <td><?php echo $v->center_name; ?></td>
                                        <td><?php echo $v->center_code; ?></td>
                                        <td><a href="<?php echo SITE_URL . "?page=master_mstr_centerDesc&id=" . $centerFxn->encode($v->id); ?>">Alter</a>
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