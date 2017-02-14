<div style="width:900px;min-height:700px; background-color:transparent; z-index:10;margin-top: 180px;margin-left: 500px;position:absolute; display:none;" id='img'><img src='<?php echo IMAGE_URL."loading.gif";?>'></div>

<?php
if (!defined(BASE_PATH)) {
    header(SITE_URL);
}
$commonObj->autoload("examFxn");
$exmFxn = new examFxn();

if (isset($_REQUEST['auserSubmit'])) {
    if ($exmFxn->examFinalSubmit()) {
        $exmFxn->setSuccessMsg("Exam Submitted Successfully!");
        $exmFxn->redirectUrl("student_myExamPackage");
    } else {
        $exmFxn->setErrorMsg("Sorry! something unexpected happened1!");
    }
}
if (isset($_SESSION['st_id']) && isset($_SESSION['ppr_id'])) {
    $st_id = $_SESSION['st_id'];
    $ppr_id = $_SESSION['ppr_id'];
//getting online question alloted to student
    if (isset($_REQUEST['nxt_attmpt_id']) && trim($_REQUEST['nxt_attmpt_id']) != '') {
        $online_data = json_decode($exmFxn->getStudentExmTakenQues(array("id" => $exmFxn->decode($_REQUEST['nxt_attmpt_id']), "order_by_asc" => "id")));
    } else {
        $online_data = json_decode($exmFxn->getStudentExmTakenQues(array("student_id" => $_SESSION['st_id'], "paper_id" => $_SESSION['ppr_id'], "order_by_asc" => "id")));
//        echo "<pre><center>";print_R($online_data);die;
    }

    //getting last time viewed the question
    $max_time = $exmFxn->getQuestionMaxEndTime($st_id, $ppr_id);
    //getting questions and other data one by one
    $ques_data = json_decode($exmFxn->getQuestionList(array("id" => $online_data[0]->ques_id)));

    //getting exam attempted data
    if (!$exm_attempt_data = json_decode($exmFxn->getPaperAttemptData(array("student_id" => $_SESSION['st_id'], "ppr_id" => $_SESSION['ppr_id'])))) {
        $exmFxn->setErrorMsg("No a valid paper to attempt!");
        $exmFxn->redirectUrl("student_myExamPapers");
    }

    if ($exm_attempt_data[0]->is_completed != '0') {
        $exmFxn->setErrorMsg("This paper is already given!");
        $exmFxn->redirectUrl("results_exam_result_list");
    }
    //checking exm expired if end time is less than today timestamp
    if (date("YmdHis") >= $exm_attempt_data[0]->end_time) {
        $exmFxn->updateExmCompleteStatus($exm_attempt_data[0]->id,"1");
        $exmFxn->setErrorMsg("Already Attempted this exam or Incomplete exam!");        
        $exmFxn->redirectUrl("results_exam_result_list");
    }
} else {
    $exmFxn->setErrorMsg("Invalid Access!");
    $exmFxn->redirectUrl();
}
//print_R($exm_attempt_data);die;
?>

<script type="text/javascript">
    var TimeLimit = new Date('<?php echo date('r', strtotime($exm_attempt_data[0]->end_time)); ?>');
    function getTimeRemaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }
//setTimeout("getTimeRemaining()",1000);

    function initializeClock(id, endtime) {
        var timeinterval = setInterval(function () {
            var t = getTimeRemaining(endtime);
//    document.getElementById('hour').innerHTML = 'days: ' + t.days;
            t.hours = (t.hours < 10) ? t.hours = "0" + t.hours : t.hours;
            t.minutes = (t.minutes < 10) ? t.minutes = "0" + t.minutes : t.minutes;
            t.seconds = (t.seconds < 10) ? t.seconds = "0" + t.seconds : t.seconds;

            $("#hour").html(t.hours);
            $("#minute").html(t.minutes);
            $("#second").html(t.seconds);
            if (t.total <= 0) {
                var hidden = document.createElement("input");
                hidden.type = "hidden";
                hidden.name = "auserSubmit";
                hidden.value = "Final Submit";
                var f = document.getElementById("form1");
                f.appendChild(hidden);
                f.submit();
//                document.getElementById("form1").submit();
                clearInterval(timeinterval);
            }
        }, 1000);
    }
    initializeClock('timer', TimeLimit);
</script>

<div id="page-wrapper" style="margin:0 0 0 0px !important;">
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

        <div id="timer" style="text-align: center;">
            <div id="hour" style="" class="btn btn-warning btn-sm"></div>
            <div id="minute" class="btn btn-info btn-sm"></div>
            <div id="second" class="btn btn-danger btn-sm"></div>
        </div>        
        <div id="timer" style="text-align: center; margin: 10px;">
            <div id="hour1" class="btn btn-warning btn-xs" style="min-width:55px !important">Hour&nbsp;&nbsp; </div>
            <div id="minute1" class="btn btn-info btn-xs" style="min-width:55px !important">Minute</div>
            <div id="second1" class="btn btn-danger btn-xs" style="min-width:55px !important">Second</div>
        </div>
        <?php $sub_arr =  json_decode($exmFxn->getSubjectList(array("id"=>$online_data[0]->sub_id)));
            
        ?>
        <div id="sub" style="text-align: center; margin: 10px;">
        <?php ?>
            <div id="subject" class="btn btn-success btn-xs" style="min-width:55px !important"><?php echo "<B>SUBJECT : ".$sub_arr[0]->name."</B>";?>&nbsp;&nbsp; </div>
            
        </div>            


        <div class="col-lg-12" style="width:80%;">
            <div class="panel panel-default" style="overflow-y:scroll; max-height: 270px;">
                <div class="panel-body">
                    <h4 style="text-align: center; margin:-5px 0 -5px 0px !important; font-size: 15px;">Question<span id="qno"> 1 </span> of <?php echo count($online_data); ?></h4><hr>
                    <p style=" font-size: 15px !important; color: #0000C0; margin-left: 20px;" id='eng_ques'><?php echo strip_tags($ques_data[0]->eng_ques); ?></p>
                    <p style="font-size: 15px !important; color: #0000C0; margin-left: 20px;" id='hin_ques'><?php echo strip_tags(utf8_decode($ques_data[0]->hin_ques)); ?></p>

<div style="">

                                <label id='option1_lbl'>(A) <?php echo $ques_data[0]->option1 . "   " . utf8_decode($ques_data[0]->option1_hin); ?></label>

                            </div>
                            <div style="margin-top:10px;">

                                <label id='option2_lbl'>(B) <?php echo $ques_data[0]->option2 . "   " . utf8_decode($ques_data[0]->option2_hin); ?></label>
                            </div>

                            <!-- Add the extra clearfix for only the required viewport -->
                            <div></div>

                            <div style="margin-top:10px;">

                                <label id='option3_lbl'>(C) <?php echo $ques_data[0]->option3 . "   " . utf8_decode($ques_data[0]->option3_hin); ?>
                            </div>
                            <div style="margin-top:10px;">

                                <label id='option4_lbl'>(D) <?php echo $ques_data[0]->option4 . "   " . utf8_decode($ques_data[0]->option4_hin); ?></label>
                            </div>
                </div>


                <!--</div>-->
                <!-- .panel-body -->
            </div>

                    <form method="post" enctype="multipart/form-data" name="form1" id="form1">

                        <div class="row show-grid" style="">
                            

                            <div class="row">
                                <div class="col-lg-4" style="background-color:transparent !important; border: transparent !important; width:70%; height: 120px;">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            Please Choose correct Answer
                                        </div>
                                        <div class="panel-body" id="options">
                                            <span id="option1" style="margin-left:10px;"><label>(A)</label> <input type="radio" name="userAns" value="1" id='userAns'<?php echo($online_data[0]->st_ans == '1') ? 'checked' : ''; ?>></span>
                                            <span id="option2" style="margin-left:10px;"><label>(B)</label> <input type="radio" name="userAns" value="2" id='userAns'<?php echo($online_data[0]->st_ans == '2') ? 'checked' : ''; ?>></span>
                                            <span id="option3" style="margin-left:10px;"><label>(C)</label> <input type="radio" name="userAns" value="3" id="userAns"<?php echo($online_data[0]->st_ans == '3') ? 'checked' : ''; ?>></span>
                                            <span id="option4" style="margin-left:10px;"><label>(D)</label> <input type="radio" name="userAns" value="4" id='userAns'<?php echo($online_data[0]->st_ans == '4') ? 'checked' : ''; ?>></span>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div style="text-align: center;">

                                <input type="button" onclick="showAjaxQues(parseInt($('#nxtQuesId').val()), 'examFxn', 'examFxn', 'prev');" class="btn btn-info btn-sm" disabled="true" id="prev_btn" value="<< Previous">

                                <button name='auserSubmit' class="btn btn-danger btn-sm" onclick = "return confirm('Are sure to finally submit your Exam!');">Final Submit</button>
                                <?php if (count($online_data) > 1) { ?>
                                    <input type='button' onclick="showAjaxQues($('#nxtQuesId').val(), 'examFxn', 'examFxn', 'next');" class="btn btn-warning btn-sm" value='Save & Next >>' id='nxtQues'>
                                <?php } ?>
                                <input type='button' onclick="" class="btn btn-info btn-sm" value='Mark for review & next >>' id='markFrReviewNxt'>
                                <input type='button' onclick="updateAnswer($('#nxtQuesId').val(), '0', '4');
                                        clearans();" class="btn btn-info btn-sm" value='Clear Response' id='clearResponse'>
                            </div>
                            <input type="hidden" value='<?php echo $online_data[0]->id; ?>' id="nxtQuesId">
                            <input name="sno_ques" value="1" id="sno_ques" type="hidden">
                        </div>
                    </form>            
                                            <!--showing questions one by one with button-->

                                </div>
        
        
                                        <div class="col-lg-4" style="background-color:transparent !important; border: transparent !important;width: 20%;height: 470px; overflow-y: scroll;">
                                            <div class="panel panel-warning" style="height:470px;">
                                                <div class="panel-heading" style="text-align:center; ">
                                            <span href="#" class="btn btn-default btn-xs">Not Attempted</span>
                                            <span href="#" class="btn btn-success btn-xs">Attempt</span>
                                            <span href="#" class="btn btn-danger btn-xs">Mark for Review</span>
                                            <!--<span href="#" class="btn btn-primary btn-xs">Not Attempt</span>-->
                                            <span href="#" class="btn btn-info btn-xs">Viewed</span>
                                        </div>
                                        <div class="panel-body" id="options" style="height: 409px;;overflow-y: scroll;"">
                                            <?php
                                            $ii = 1;
                                            foreach ($online_data as $qKey => $qVal) {
                                                ?>
                                                <span id="q<?php echo $ii; ?>">
                                                    <?php
                                                    if ($qVal->ques_status == '0') {
                                                        $bg = " btn-default btn-xs";
                                                    } else if ($qVal->ques_status == '1') {
                                                        $bg = " btn-success btn-xs";
                                                    } else if ($qVal->ques_status == '2') {
                                                        $bg = " btn-danger btn-xs";
                                                    } else if ($qVal->ques_status == '3') {
                                                        $bg = " btn-primary btn-xs";
                                                    } else if ($qVal->ques_status == '4') {
                                                        $bg = " btn-info btn-xs";
                                                    }
                                                    ?>
                                                    <input type='button' onclick="showAjaxQues('<?php echo $qVal->id ?>', 'examFxn', 'examFxn', '0');
                                                                changeSno('<?php echo $ii; ?>')" name="directJmp_<?php echo $qVal->id; ?>" value="<?php echo $ii; ?>" class="btn <?php echo $bg; ?>" id="directJmp_<?php echo $qVal->id; ?>" style="width: 26px !important; margin-top:5px;">
                                                </span>
                                                <?php
                                                $ii++;
                                            }
                                            ?>
                                        </div>
                                    </div>

        
        
            
            <!-- /.panel -->
        </div>
    </div>
</form>
<!--                    </div>
                    <div class="panel-footer" style="text-align: center;">
                        
                    </div>-->




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
        $("#aUserSubmit").click(function () {
            if ($('#strt_accept_declaration').prop("checked") === false) {
                alert("Please Check on Accept Condition!");
                return false;
            }
        });
    });
//whenever user select or choose new answer then it update that
    $(function () {
        $("input:radio[name='userAns']").change(function () {
            updateAnswer($('#nxtQuesId').val(), $("input[name='userAns']:checked").val(), "1");
        });
    })
    function changeSno(val1) {
        $("#sno_ques").val(val1);
    }
    //checking if user select mark for review then one option must be selected
    $(function () {
        $("#markFrReviewNxt").click(function () {
            if (typeof ($("input[name='userAns']:checked").val()) === 'undefined') {
                alert("Please Choose answer!");
                return false;
            }else{
            markForReview($('#nxtQuesId').val(), "2");    
            showAjaxQues($('#nxtQuesId').val(), 'examFxn', 'examFxn', 'markFrReviewNxt');
                //changing status for question and changing color too
            }
        });
    });
    $(function () {
        $("#clearResponse").click(function () {

            $("#userAns").prop("checked", false);
            $("#userAns2").prop("checked", false);
            $("#userAns3").prop("checked", false);
            $("#userAns4").prop("checked", false);
        });
    })
</script>