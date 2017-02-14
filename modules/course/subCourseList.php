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
$courseFxn = new courseFxn();
$subCourseData = json_decode($courseFxn->getSubCourseList());

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $courseFxn->getSuccessMsg();
            echo $courseFxn->getErrorMsg();
            $courseFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Listing Sub Courses </h3>
             <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=course_subCourseDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_course">Add Sub Course +</a>
             <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Sub Course List                    
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Course Name</th>
                                    <th>Sub Course Name</th>
                                    <th>Course Description</th>
                                    <th colspan="0" align="center">Options</th>
                                </tr>
                            </thead>


                            <tbody>

                                <?php $sno = 0; ?>
                                <?php if($subCourseData){
                                foreach ($subCourseData as $k => $v) {
                                    $sno++;
                                    $course_data = json_decode($courseFxn->getCourseList(array("id"=>$v->course_id)));
                                    
                                    $course_name = $course_data[0]->name;
                                    ?>

                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td><?php echo $course_name; ?></td>
                                        <td><?php echo $v->name; ?></td>
                                        <td><?php echo $v->description; ?></td>
                                        <td><a href="<?php echo SITE_URL . "?page=course_subCourseDesc&id=" . $courseFxn->encode($v->id); ?>">Alter</a>
                                        </td>

                                    </tr>
                                <?php } }?>


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