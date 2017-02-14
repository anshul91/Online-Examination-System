<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canUpdate("users_user_group_list") || !$commonObj->canAccess("users_user_group_list")){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("userFxn");
$userFxn = new userFunctions();

if (isset($_REQUEST['id']))
    $userId = $userFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($userFxn->addUserGroup()) {
        header("location:" . SITE_URL . "?page=users_user_group_list");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {
    if ($userFxn->updateUserGroup($userId)) {      
      $userFxn->setSuccessMsg("Record Updated Successfully");
    } 
} else if (isset($_REQUEST['id'])) {
    $group_data = json_decode($userFxn->getUserGroupData(array('id' => $userId)));
//    print_r($group_data);die;
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $userFxn->getSuccessMsg();
            echo $userFxn->getErrorMsg();
            $userFxn->unsetMessage();
            ?>
            
            <h3 class="page-header">User Group</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id'])?"Update ":"Add ";?> User Group<br />
                        
        </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <center>
                        <table width="80%" border="0" cellspacing="5" cellpadding="5">

                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter Group name </th>
                                <td width="50%"><input type="text" name="group_name" placeholder ="Enter Group Name" size="30" class="form-control" value="<?php if (isset($_REQUEST['group_name'])) {
                echo $_REQUEST['group_name'];
            } else if (isset($group_data[0])) {
                echo $group_data[0]->group_name;
            } else {
                echo "";
            } ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;"> Description </th>
                                <td width="50%"><textarea class="form-control" placeholder="Enter Group Description" name="group_description"><?php if (isset($_REQUEST['group_description'])) {
                echo $_REQUEST['group_description'];
            } elseif (isset($group_data[0])) {
                echo $group_data[0]->group_description;
            } else {
                echo "";
            } ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center" style="padding:20px 0px;">
                                    <input type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL."?page=users_user_group_list";?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>