<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
$commonObj->autoload("examFxn");
$exmFxn = new examFxn();
//if(!$commonObj->canAccess($_REQUEST['page'])){
//    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
//    $commonObj->redirectUrl();
//    exit();
//}
if (isset($_REQUEST['ppr_id']) && $_REQUEST['ppr_id'] != '') {
    $ppr_id = $_REQUEST['ppr_id'];
} else {
    $exmFxn->setErrorMsg("Something Unexpected Happened! Please Try again Later!");
    $exmFxn->redirectUrl("myExamPackage");
}




$exmData = json_decode($exmFxn->getStudentExmTakenQues(array("paper_id" => $ppr_id, "student_id" => $_SESSION['st_id'])));

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

            <h3 class="page-header">Exam Result Summary </h3>

        </div>
    </div>
    <!-- /.col-lg-12 -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading" style="text-align:center;">
                    Summary
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Question</th>
                                    <th>subject</th>
                                    <th>Option 1</th>
                                    <th>Option 2</th>
                                    <th>Option 3</th>
                                    <th>Option 4</th>
                                    <th>Your Answer</th>
                                    <th>Answer</th>
                                </tr>
                            </thead>
                            <form name='form1' method='post'>
                                <tbody>

                                    <?php $sno = 0; ?>
                                    <?php
                                    if (sizeof($exmData) > 0) {
                                        foreach ($exmData as $k => $v) {
                                            $sno++;
                                            $sub_data = json_decode($exmFxn->getSubjectList(array("id" => $v->sub_id)));
                                            $ques_data = json_decode($exmFxn->getQuestionList(array("id" => $v->ques_id)));

                                            $sub_name = $sub_data[0]->name;
                                            $ques_name = $ques_data[0]->eng_ques;

                                            $option1 = $ques_data[0]->option1;
                                            $option2 = $ques_data[0]->option2;
                                            $option3 = $ques_data[0]->option3;
                                            $option4 = $ques_data[0]->option4;
                                            //$option5 = $ques_data[0]->option5;

                                            $answer = $ques_data[0]->answer;
                                            
                                            ?>

                                            <tr>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $ques_name; ?></td>
                                                <td><?php echo $sub_name; ?></td>
                                                <?php
                                                if ($v->st_ans == '1' && $answer == '1') {
                                                    $op1_color = "Blue";
                                                } else if ($v->st_ans == '2' && $answer == '2') {
                                                    $op2_color = 'Blue';
                                                } else if ($v->st_ans == '3' && $answer == '3') {
                                                    $op3_color = "Blue";
                                                } else if ($v->st_ans == '4' && $answer == '4') {
                                                    $op4_color = "Blue";
                                                }
                                                $bg = "";
                                                ?>
                                                <td style="color:<?php echo $op1_color; echo $bg;?>"><?php echo $option1; ?></td>
                                                
                                                <td style="color:<?php echo $op2_color; ?>"><?php echo $option2; ?></td>
                                                <td style="color:<?php echo $op3_color; ?>"><?php echo $option3; ?></td>
                                                <td style="color:<?php echo $op4_color; ?>"><?php echo $option4; ?></td>
                                                
                                                <th style="color:<?php echo ($answer == $v->st_ans) ? "green" : "Red"; ?>"><?php echo ($v->st_ans != '0')? "Option " . $v->st_ans:"No Answer"; ?></th>
                                                <th style="color:green;"><?php echo "Option " . $answer; ?></th>

                                            </tr>
                                            <?php
                                        }
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