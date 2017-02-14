<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <?php header( 'Content-Type: text/html; charset=utf-8' ); ?>
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
$exmData = json_decode($exmFxn->getQuestionList());

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
            
            <h3 class="page-header">Listing Exam Question's </h3>
            <?php if($commonObj->canUpdate($_REQUEST['page'])){?>
            <a href="<?php echo SITE_URL."?page=exam_questionDesc";?>"class="btn btn-success" style="margin-bottom: 5px;" name="add_paper">Add Question +</a>
            <?php }?>
        </div>
        </div>
        <!-- /.col-lg-12 -->
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                    
                <div class="panel-heading" style="text-align:center;">
                    Question List  
                </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Subject</th>
                                    <th>English Question</th>
                                    <th>Hindi Question</th>
                                    <th>Answer</th>
                                    <th>Choice</th>
                                    <th>Question Options</th>
                                    <th>Options</th>
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
                                        
                                        <?php
//                                        print_r($v->name);
                                            $sub_data = json_decode($exmFxn->getSubjectList(array("id"=>$v->sub_id)));
                                        ?> 
                                        <td><?php echo$sub_data[0]->name; ?></td>
                                        <td><?php echo $v->eng_ques; ?></td>
                                        <td><?php echo utf8_decode($v->hin_ques); ?></td>
                                        <td><?php echo $v->answer; ?></td>
                                        <td><?php echo ($v->choice == 1)?"Single Choice":"Multiple Choice"; ?></td>                                        
                                        <td><?php echo ($v->options == '1')? "4 OPTIONS" : "5 OPTIONS"; ?></td>
                                        <td><a href="<?php echo SITE_URL . "?page=exam_questionDesc&id=" . $exmFxn->encode($v->id); ?>">Alter</a> | <a href="#">Activate</a>
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