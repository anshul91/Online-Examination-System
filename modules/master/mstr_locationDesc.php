<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canUpdate("master_mstr_location_list") || !$commonObj->canAccess("master_mstr_location_list")){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}

$commonObj->autoload("masterFxn");
$masterFxn = new masterFxn();

if (isset($_REQUEST['id']))
    $locId = $masterFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($masterFxn->addLocation()) {
        header("location:" . SITE_URL . "?page=master_mstr_location_list");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    $masterFxn->updateLocation($locId);      
} else if (isset($_REQUEST['id'])) {
    $courseData = json_decode($masterFxn->getLocationList(array('id' => $locId)));
//    print_r($group_data);die;
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $masterFxn->getSuccessMsg();
            echo $masterFxn->getErrorMsg();
            $masterFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">Location</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id'])?"Update ":"Add ";?> Location<br />
                        
        </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <center>
                        <table width="80%" border="0" cellspacing="5" cellpadding="5">

                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter Location </th>
                                <td width="50%"><input type="text" name="loc_name" placeholder ="Enter Location Name" size="30" class="form-control" value="<?php if (isset($_REQUEST['loc_name'])) {
                echo $_REQUEST['loc_name'];
            } else if (isset($courseData[0])) {
                echo $courseData[0]->name;
            } else {
                echo "";
            } ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;"> Mail To </th>
                                <td width="50%"><textarea class="form-control" placeholder="Enter Mail To" name="loc_mail_to"><?php if (isset($_REQUEST['loc_mail_to'])) {
                echo $_REQUEST['loc_mail_to'];
            } elseif (isset($courseData[0])) {
                echo $courseData[0]->mail_to;
            } else {
                echo "";
            } ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;"> Mail Cc </th>
                                <td width="50%"><textarea class="form-control" placeholder="Enter Mail cc" name="loc_mail_cc"><?php if (isset($_REQUEST['loc_mail_cc'])) {
                echo $_REQUEST['loc_mail_cc'];
            } elseif (isset($courseData[0])) {
                echo $courseData[0]->mail_cc;
            } else {
                echo "";
            } ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL."?page=master_mstr_location_list";?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>