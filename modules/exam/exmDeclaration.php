<?php
if (!defined(BASE_PATH)) {
    header(SITE_URL);
}

$commonObj->autoload("examFxn");
$exmFxn = new examFxn();

if (isset($_REQUEST['ppr_id'])) {
    
    $ppr_id = $exmFxn->decode($_REQUEST['ppr_id']);
    if($exmFxn->getPaperAttemptData(array("ppr_id"=>$ppr_id,"student_id"=>$_SESSION['st_id']))){
        $_SESSION['ppr_id'] = $ppr_id;
        
//        $start_new_win =  "<script>window.open('http://localhost/school_project/?page=exam_startExam');</script>";
//        echo $start_new_win;
        $commonObj->redirectUrl("exam_startExam");
    }
    $pprData = json_decode($exmFxn->getPaperList(array("id" => $ppr_id)));
} else {
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
}
//print_r($_REQUEST);die;
if (isset($_REQUEST['ppr_id']) && isset($_REQUEST['aUserSubmit']) && isset($_REQUEST['strt_accept_declaration']) && $_REQUEST['strt_accept_declaration'] == '1' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if($exmFxn->addAttemptedPaper($ppr_id)){
        $_SESSION['ppr_id'] = $ppr_id;
//        $start_new_win =  "<script>window.open('http://localhost/school_project/?page=exam_startExams');</script>";
//        echo $start_new_win;
        $commonObj->redirectUrl("exam_startExam");
    }
} else if (isset($_REQUEST['ppr_id']) && $_SERVER['REQUEST_METHOD'] == 'POST' && (!isset($_REQUEST['strt_accept_declaration']) || $_REQUEST['strt_accept_declaration'] != '1') && $_REQUEST['aUserSubmit']) {
    $exmFxn->setErrorMsg("Please Accept Declaration!");
//    $exmFxn->redirectUrl('startExam');
//    exit;
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $commonObj->getSuccessMsg();
            echo $commonObj->getErrorMsg();
            $commonObj->unsetMessage();
            ?>

            <!--            <h4 class="page-header">Exam Declarations</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading" style="text-align: center;">
                        Declarations
                    </div>
                    <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                            <table width="100%" align="center" class="table" id="dataTables-example">
                                
                                <tr>
                                    <td> <label>Declarations</label></td>
                                </tr>
                                <tr>
                                    <td style="width:100%; height: 350px; background-color: #D7D7D7; border-radius: 10px;"><?php echo $pprData[0]->description; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="strt_accept_declaration" value="1" id="strt_accept_declaration"> <label>I accept above given terms and conditions</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" name="aUserSubmit" class="btn btn-primary btn-success" id="aUserSubmit">
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <!--                    </div>
                                            <div class="panel-footer" style="text-align: center;">
                                                
                                            </div>-->

                    </div>
                </div>

                <!--Core Scripts - Include with every page--> 
               <!--<script src="js/jquery-1.10.2.js"></script>-->
               <!--<script src="js/bootstrap.min.js"></script>-->
           <!--    <script src="<?php echo JS_URL; ?>/plugins/metisMenu/jquery.metisMenu.js"></script>
           
                Page-Level Plugin Scripts - Dashboard 
               <script src="<?php echo JS_URL; ?>/plugins/morris/raphael-2.1.0.min.js"></script>
               <script src="<?php echo JS_URL; ?>/plugins/morris/morris.js"></script>
           
                SB Admin Scripts - Include with every page 
               <script src="<?php echo JS_URL; ?>/sb-admin.js"></script>
           
                Page-Level Demo Scripts - Dashboard - Use for reference 
               <script src="<?php echo JS_URL; ?>/demo/dashboard-demo.js"></script>-->

                <script>
                    $(function () {
                     $("#aUserSubmit").click(function(){
                        if($('#strt_accept_declaration').prop("checked") === false){
                            alert("Please Check on Accept Condition!");
                        return false;
                    }
                     })  ; 
                    });
                </script>