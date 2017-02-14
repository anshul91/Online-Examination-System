<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if (!$commonObj->canUpdate("course_batch_list") || !$commonObj->canAccess("course_batch_list")) {
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}

$commonObj->autoload("examFxn");
$examFxn = new examFxn();
$paper_list = json_decode($examFxn->getPaperList());

if (isset($_REQUEST['id'])){
    //getting subjects which to be selected when editing
    $sel_sub = array();
    $userId = $examFxn->decode($_REQUEST['id']);
    $paperOfPkgList= json_decode($examFxn->getPaperOfPkg(array("pkg_id"=>$userId)));
    if(count($paperOfPkgList)>0){
        foreach($paperOfPkgList as $k=>$v){
            $sel_sub[] = $v->paper_id;
        }
        
    }
}
if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($examFxn->addPackage()) {
        header("location:" . SITE_URL . "?page=exam_packageList");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    if($examFxn->updatePackage($userId))
        header("location:" . SITE_URL . "?page=exam_packageList");
    else
        header("location:" . SITE_URL . "?page=exam_packageDesc&id=".$_REQUEST['id']);
    exit;
} else if (isset($_REQUEST['id'])) {
    $examData = json_decode($examFxn->getPackageList(array('id' => $userId)));
}

$timingArr = array(0 => "1")
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

            <h3 class="page-header">Package Listing</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id']) ? "Update " : "Add "; ?> Package<br />
                    </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

                    <center><p>    <table border="0" cellspacing="15" cellpadding="5">
                            <tr>

                                <td id="package_name" style="display:none;"></td>
                                <td>
                                    <label>Package Name</label>
                                    <input type="text" name="pkg_name" placeholder="Enter Package name" class="form-control" value="<?php if (isset($_REQUEST['pkg_name'])) echo $_REQUEST['pkg_name'];else if (isset($examData[0])) echo $examData[0]->name; ?>">                                    
                                </td>
                                <td>
                                    <label>Select Package</label>
                                    <select name="pkg_type" class="form-control" id="pkg_type" onclick="showPaid(this.value)">
                                        <option value="">--Select Package--</option>
                                        <option value="1" <?php if(isset($_REQUEST['pkg_type'])&&$_REQUEST['pkg_type'] == 1){echo 'selected';}else if(@$examData[0]->type == 1){echo "selected";}?>>Paid</option>
                                        <option value="2"<?php if(@$_REQUEST['pkg_type'] == 2)echo 'selected';else if(@$examData[0]->type == 2)echo "selected";?>>Free</option>
                                    </select>
                                </td>
                            
                                <td>
                                    <label>Package duration(in days)</label>
                                    <input type="text" name="pkg_duration_in_days" placeholder="Enter Package duration" class="form-control" value="<?php if (isset($_REQUEST['pkg_duration_in_days'])) echo $_REQUEST['pkg_duration_in_days'];else if (isset($examData[0])) echo $examData[0]->duration_in_days; ?>" id="duration">                                    
                                </td>
                                
                                
                            </tr>
                            <tr>
                                <td style="display:nne;">
                                    <label>Package size</label>
                                    <input type="text" name="pkg_size" placeholder="Enter package size" class="form-control" value="<?php if (isset($_REQUEST['pkg_size'])) echo $_REQUEST['pkg_size'];else if (isset($examData[0])) echo $examData[0]->size; ?>" id="size">                                    
                                </td>
                                <td style="display:one;">
                                    <label>Package Price</label>
                                    <input type="text" name="pkg_price" placeholder="Enter Package price" class="form-control" value="<?php if (isset($_REQUEST['pkg_price'])) echo $_REQUEST['pkg_price'];else if (isset($examData[0])) echo $examData[0]->price; ?>" id="price">     
                                </td>
                                
                                <td>
                                    <label>Select Papers in package</label>
                                    <select name="pkgs_paper_id[]" multiple="true" class="form-control" id="papers">
                                        <option value="">--Select Papers--</option>
                                        <?php
                                        $ii = 0;
                                        
                                        foreach($paper_list as $k=>$v){?>
                                        <option value="<?php echo $v->id;?>"<?php if(@$_REQUEST['pkgs_paper_id'][$ii] == $v->id){echo "selected";$ii++;}else if(@$sel_sub[$ii] == $v->id){echo "selected";$ii++;}?>><?php echo $v->name;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="5" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL . "?page=exam_packageList"; ?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>
                </p></center>

                <script>
                    function showPaid(val){
                        if(val == 2){
                            $("#duration").val("");
                            $("#size").val("");
                            $("#package").val("");
                            $("#price").val("");
                            
                            $("#duration").attr("disabled","true");
                            $("#size").attr("disabled","true");
                            $("#package").attr("disabled","true");
                            $("#price").attr("disabled","true");
//                            $("#papers").attr("disabled","true");
                        }else{
                            $("#duration").removeAttr("disabled");
                            $("#size").removeAttr("disabled","false");
                            $("#package").removeAttr("disabled","false");
                            $("#price").removeAttr("disabled","false");
//                            $("#papers").removeAttr("disabled","false");
                        }
                    }
                    $(function(){
                        pkg = $("#pkg_type").val();
                        if(pkg == 2){
                            
                            $("#duration").attr("disabled","true");
                            $("#size").attr("disabled","true");
                            $("#package").attr("disabled","true");
                            $("#price").attr("disabled","true");
//                            $("#papers").attr("disabled","true");
                        }else{
                            $("#duration").removeAttr("disabled");
                            $("#size").removeAttr("disabled","false");
                            $("#package").removeAttr("disabled","false");
                            $("#price").removeAttr("disabled","false");
//                            $("#papers").removeAttr("disabled","false");
                        }
                    });
                </script>