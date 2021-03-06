<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}

if(!$commonObj->canAccess($_REQUEST['page'])){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("examFxn");

$exmFxn = new examFxn();
$exmData = json_decode($exmFxn->getSubjectList());
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
            
            <h3 class="page-header">Listing Subjects </h3>
            <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=exam_subjectDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_subject">Add Subject +</a>
            <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Subject List           
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>
<form name='form1' method='post'>
                            <tbody>
                                
                                <?php $sno = 0; ?>
                                <?php
                                if(sizeof($exmData)>0){
                                foreach ($exmData as $k => $v) {
                                    $sno++;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $v->name; ?></td>
                                        <td><?php echo $v->description; ?></td>
                                        <td><a href="<?php echo SITE_URL . "?page=exam_subjectDesc&id=" . $exmFxn->encode($v->id); ?>">Alter</a>
                                        </td>

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