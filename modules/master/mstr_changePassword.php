<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
//if (!$commonObj->canUpdate("master_mstr_changePassword") || !$commonObj->canAccess("master_mstr_changePassword")) {
//    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
//    $commonObj->redirectUrl();
//    exit();
//}

$commonObj->autoload("masterFxn");
$masterFxn = new masterFxn();

if (isset($_REQUEST['id']))
    $locId = $masterFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($masterFxn->updatePassword($_SESSION['id'])) {
        $masterFxn->logout($_SESSION);
        $masterFxn->setSuccessMsg("Password changed Successfully!");
        header("location:" . SITE_URL . "login.php");
        exit;
    }
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

            <h3 class="page-header">Change Credentials</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><?php echo isset($_REQUEST['id']) ? "Update " : "Reset"; ?> Password<br />

                    </center>
                </div>


                <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <center>
                        <table width="80%" border="0" cellspacing="5" cellpadding="5">

                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter New Password</th>
                                <td width="50%"><input type="password" name="password_pwd" placeholder ="Enter New Password" size="30" class="form-control" id="password" value="<?php
                                    if (isset($_REQUEST['password'])) {
                                        echo $_REQUEST['loc_name'];
                                    }
                                    ?>" /><span style="color:red;" id="pwd"></span>
                                </td>
                            </tr>
                            <tr>
                                <th width="50%" align="left" valign="top" style="padding:20px 0px;">Retype password</th>
                                <td width="50%"><input type="password" class="form-control" placeholder="retype password" name="password_retype" id="retype_password" value="<?php
                                    if (isset($_REQUEST['retype_password'])) {
                                        echo $_REQUEST['retype_password'];
                                    }
                                    ?>">
                                    <div style="color:red;" id="repwd"></div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center" style="padding:20px 0px;">
                                    <input id="submit" type="submit" name="save" value="Save"  class="btn btn-outline btn-warning"/>
                                    <a href="<?php echo SITE_URL . "?page=master_mstr_location_list"; ?>"class="btn btn-outline btn-primary">Back</a>
                                </td>
                            </tr>
                        </table>
                </form>
                <script>
                    $(document).ready(function ()
                    {
                        $('#password_pwd').keyup(function () {
                            var password = document.getElementById("password_pwd").value;
                            var repass = document.getElementById("password_retype").value;
                            if (password.length < 6) {
                                document.getElementById("pwd").innerHTML = "password must be 6 chars. long";
                                return false;
                            } else
                                document.getElementById("pwd").innerHTML = "";

                        });
                        $('#password_retype').keyup(function () {
                            var password = document.getElementById("password_pwd").value;
                            var repass = document.getElementById("password_retype").value;
                            
//                            if (password != repass) {
//                                document.getElementById("repwd").innerHTML = "password Do not match";
//                                return false;
//                            } else
//                                document.getElementById("pwd").innerHTML = "password matched";
                        });
                    });
                </script>