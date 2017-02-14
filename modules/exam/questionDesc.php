<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if (!$commonObj->canUpdate("exam_questionList") || !$commonObj->canAccess("exam_questionList")) {
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}

$commonObj->autoload("examFxn");
$examFxn = new examFxn();
$subjectList = json_decode($examFxn->getSubjectList());
$paper_list = json_decode($examFxn->getPaperList());
if (isset($_REQUEST['id']))
    $userId = $examFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($examFxn->addQuestion()) {
        header("location:" . SITE_URL . "?page=exam_questionDesc");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    if ($examFxn->updateQuestion($userId))
        header("location:" . SITE_URL . "?page=exam_questionList");
    else
        header("location:" . SITE_URL . "?page=exam_questionDesc&id=" . $_REQUEST['id']);
    exit;
} else if (isset($_REQUEST['id'])) {
    $examData = json_decode($examFxn->getQuestionList(array('id' => $userId)));
}


?>
<style>
    td,th{
        padding:10px;
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $examFxn->getSuccessMsg();
            echo $examFxn->getErrorMsg();
            $examFxn->unsetMessage();
            ?>

            <h4 class="page-header">Question Listing</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id']) ? "Update " : "Add "; ?> Question<br />
                    </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

                    <center><p> 
                        <table border="0" cellspacing="15" cellpadding="5">
                            <tr>
                                <td>
                                    <label>Select Papers</label>
                                    <select name="sel_paper_id[]" multiple="true" class="form-control" id="papers" size="2">
                                        
                                        <?php
                                        $ii = 0;
                                        if(isset($examData[0]))
                                            $sel_sub = explode(",",$examData[0]->paper_id);
                                        foreach($paper_list as $k=>$v){
                                            if($ii>=count($sel_sub))
                                                $ii=0;
                                            ?>
                                        <option value="<?php echo $v->id;?>"<?php if(@$_REQUEST['sel_paper_id'][$ii] == $v->id){echo "selected";$ii++;}else if(@$sel_sub[$ii] == $v->id){echo "selected";$ii++;}?>><?php echo $v->name;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                                
                                <td>
                                    <label>Select Subjects</label>
                                    <select name="ppr_sub_id" class="form-control" id="ppr_subject">
                                        <option value="">--Select Subject--</option>
                                        <?php
                                        foreach($subjectList as $k=>$v){?>
                                        <option value="<?php echo $v->id;?>"<?php if(@$_REQUEST['ppr_subject'][$ii] == $v->id){echo "selected";$ii++;}else if(@$examData[0]->sub_id == $v->id){echo "selected";$ii++;}?>><?php echo $v->name;?></option>
                                        <?php }?>
                                    </select>
                                </td>

                                <td>
                                    <label>Options</label>
                                    <select name="ppr_options" class="form-control" id="ppr_options">
                                        <option value="">--Select Options--</option>
                                        <option value="1"<?php if(@$_REQUEST['pkg_options']=='1'){echo "selected";}else if(@$examData[0]->options == '1'){echo "selected";}?>>4 OPTIONS</option>
                                        <option value="2"<?php if(@$_REQUEST['pkg_options']=='2'){echo "selected";}else if(@$examData[0]->options == '2'){echo "selected";}?>>5 OPTIONS</option>
                                    </select>
                                </td>
                                <td>
                                    <label>Select Choice</label>
                                    <select name="ppr_choice" class="form-control" id="ppr_choice">
                                        <option value='1'>Single</option>
                                        <option value='2'>Multiple</option>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td colspan='4'>
                                    <label>English Question</label>
                                    <?php $eng_ques = '' ;if (isset($_REQUEST['ppr_eng_ques'])) $eng_ques = $_REQUEST['ppr_eng_ques'];else if (isset($examData[0])) $eng_ques= $examData[0]->eng_ques; 
                        
                        ?>
                                    <?php $ckeditor->editor('ppr_eng_ques',$eng_ques,array("width"=>1000,"height"=>90));?>
                                </td>                                
                            </tr>                                                            
                            <tr>
                                <td colspan="4">
                                    <label>Hindi Question</label>
                        <?php $hin_ques = '' ;if (isset($_REQUEST['ppr_hin_ques'])) $hin_ques = $_REQUEST['ppr_hin_ques'];else if (isset($examData[0])) $hin_ques= $examData[0]->hin_ques; 
                        $hin_ques = utf8_decode($hin_ques);
                        ?>
                                    <?php $ckeditor->editor('ppr_hin_ques',$hin_ques,array("width"=>1000,"height"=>90,"placeholder"=>"test"));?>
                                </td>
                            </tr>
                            <tr>
                                

                            </tr>
                            
                            <tr>
                                <td colspan="4" style="text-align:center;"><label>OPTIONS IN ENGLISH</label></td>
                            </tr>
                            <tr>                                
                                <td>
                                    <label>Option 1</label>
                                    <input type="text" name="ppr_option1" placeholder="Option1" class="form-control" value="<?php if (isset($_REQUEST['ppr_option1'])) echo $_REQUEST['ppr_option1'];else if (isset($examData[0])) echo $examData[0]->option1; ?>" id="size">                                    
                                </td>
                                <td>
                                    <label>Option 2</label>
                                    <input type="text" name="ppr_option2" placeholder="Enter Option2" class="form-control" value="<?php if (isset($_REQUEST['ppr_option2'])) echo $_REQUEST['ppr_option2'];else if (isset($examData[0])) echo $examData[0]->option2; ?>" id="price">     
                                </td>
                                <td>
                                    <label>Option 3</label>
                                    <input type="text" name="ppr_option3" placeholder="Enter Option 3" class="form-control" value="<?php if (isset($_REQUEST['ppr_option3'])) echo $_REQUEST['ppr_option3'];else if (isset($examData[0])) echo $examData[0]->option3; ?>" id="price">     
                                </td>

                               
                                <td>
                                    <label>Option 4</label>
                                    <input type="text" name="ppr_option4" placeholder="Enter Option 4" class="form-control" value="<?php if (isset($_REQUEST['ppr_option4'])) echo $_REQUEST['ppr_option4'];else if (isset($examData[0])) echo $examData[0]->option4; ?>" id="">     
                                </td>
                            </tr>
                            <tr>
                                
                                
                            </tr>
                            <tr>
                                <td style="display:none;" id="ppr_option5_show">
                                    <label>Option 5</label>
                                    <input type="text" name="ppr_option5" placeholder="Enter Option 5" class="form-control" value="<?php if (isset($_REQUEST['ppr_option5'])) echo $_REQUEST['ppr_option5'];else if (isset($examData[0])) echo $examData[0]->option5; ?>" id="ppr_option5">     
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="4" style="text-align:center;"><label>OPTIONS IN HINDI</label></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Option 1</label>
                                    <input type="text" name="ppr_option1_hin" placeholder="Option1" class="form-control" value="<?php if (isset($_REQUEST['ppr_option1_hin'])) echo $_REQUEST['ppr_option1_hin'];else if (isset($examData[0])) echo utf8_decode($examData[0]->option1_hin); ?>" id="size">                                    
                                </td>
                                <td>
                                    <label>Option 2</label>
                                    <input type="text" name="ppr_option2_hin" placeholder="Enter Option2" class="form-control" value="<?php if (isset($_REQUEST['ppr_option2_hin'])) echo $_REQUEST['ppr_option2_hin'];else if (isset($examData[0])) echo utf8_decode($examData[0]->option2_hin); ?>" id="price">     
                                </td>
                                <td>
                                    <label>Option 3</label>
                                    <input type="text" name="ppr_option3_hin" placeholder="Enter Option 3" class="form-control" value="<?php if (isset($_REQUEST['ppr_option3_hin'])) echo $_REQUEST['ppr_option3_hin'];else if (isset($examData[0])) echo utf8_decode($examData[0]->option3_hin); ?>" id="price">     
                                </td>

                               
                                <td>
                                    <label>Option 4</label>
                                    <input type="text" name="ppr_option4_hin" placeholder="Enter Option 4" class="form-control" value="<?php if (isset($_REQUEST['ppr_option4_hin'])) echo $_REQUEST['ppr_option4_hin'];else if (isset($examData[0])) echo utf8_decode($examData[0]->option4_hin); ?>" id="price">     
                                </td>
                            </tr>
                            <tr>
                                
                                
                            </tr>
                            <tr>
                                <td style="display:none;" id="ppr_option5_hin_show">
                                    <label>Option 5</label>
                                    <input type="text" name="ppr_option5_hin" placeholder="Enter Option 5" class="form-control" value="<?php if (isset($_REQUEST['ppr_option5_hin'])) echo $_REQUEST['ppr_option5_hin'];else if (isset($examData[0])) echo utf8_decode($examData[0]->option5_hin); ?>" id="ppr_option5_hin">     
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1">
                                    <label>Select Answer</label>
                                    <select name="ans_answer[]" class="form-control" multiple="true" id="ans_answer">
                                        <option value="">--Select Answer--</option>
                                        <?php 
                                        $ii = 0;
                                        if(isset($examData[0]))
                                            $answer = explode(",", $examData[0]->answer);
                                            foreach($examFxn->ans_array as $k=>$v){
                                                if($ii>=count($answer))
                                                    $ii = 0;
                                        ?>
                                        <option value="<?php echo $k;?>"<?php if(@$_REQUEST['ans_answer'][$ii] == $k){echo "selected";$ii++;}else if(@$answer[$ii] == $k){echo "selected";$ii++;}?>><?php echo $v;?></option>
                                            <?php }?>
<!--                                        <option value="1">1st option</option>
                                        <option value="2">2nd option</option>
                                        <option value="3">3rd option</option>
                                        <option value="4">4th option</option>
                                        <option value="5">5th option</option>-->
                                    </select>     
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL . "?page=exam_questionList"; ?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>
                </p></center>

                <script>
                    $(document).ready(function(){
                        $('#ans_answer option[value="5"]').remove();
                        $('#ppr_options').change(function(){                            
                            if($('#ppr_options').val() ==2){
                                $('#ans_answer').append("<option value='5'>5th</th> option</option>");
                            $('#ppr_option5_show').css("display",'block');
                            $('#ppr_option5_hin_show').css('display','block');
                        }else{
                            $('#ppr_option5').val('');
                            $('#ppr_option5_hin').val('');
                            $('#ans_answer option[value="5"]').remove();
                            $('#ppr_option5_show').css("display",'none');
                            $('#ppr_option5_hin_show').css('display','none');
                        }
                        });
                        if($('#ppr_options').val() ==2){
                                $('#ans_answer').append("<option value='5'>5th</th> option</option>");
                            $('#ppr_option5_show').css("display",'block');
                            $('#ppr_option5_hin_show').css('display','block');
                        }else{
                            $('#ppr_option5').val('');
                            $('#ppr_option5_hin').val('');
                            $('#ans_answer option[value="5"]').remove();
                            $('#ppr_option5_show').css("display",'none');
                            $('#ppr_option5_hin_show').css('display','none');
                        }
                        
                        $('#ppr_choice').change(function(){
                            if($('#ppr_choice').val() == 1){
                                $('#ans_answer').removeAttr("multiple");
                            }else{
                                $('#ans_answer').attr("multiple","true");
                            }
                        });
                        if($('#ppr_choice').val() == 1){
                                $('#ans_answer').removeAttr("multiple");
                            }else{
                                $('#ans_answer').attr("multiple","true");
                            }
                    });
                    
                </script>
                