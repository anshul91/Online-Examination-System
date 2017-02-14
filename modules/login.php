<?php
require_once('../core/config.php');
require_once('../functions/commonFxn.php');
require_once('../functions/masterFxn.php');

$commonObj->autoload("masterFxn");

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $commonObj->redirectUrl();
}
if ((isset($_REQUEST['username']) && trim($_REQUEST['username']) == '') || (isset($_REQUEST['password']) && trim($_REQUEST['password']) == '') || (isset($_REQUEST['usertype']) && trim($_REQUEST['user_type']) == '')) {
    $commonObj->setErrorMsg("Enter username or password!");
}
if ((isset($_REQUEST['username']) && !empty($_REQUEST['username'])) && (isset($_REQUEST['password']) && !empty($_REQUEST['password'])) && (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] != '' && $_REQUEST['user_type'] == '2')) {
    $uname = $_REQUEST['username'];
    $pass = base64_encode(trim($_REQUEST['password']));
    if ($commonObj->employeeUserNameExist($uname)) {
        $loginarr = $commonObj->employeeCheckLogin($uname, $pass);

        if ($loginarr) {
            $loginarr = json_decode($loginarr);
            $_SESSION['id'] = $loginarr[0]->id;
            $_SESSION['emp_number'] = $loginarr[0]->emp_number;
            $_SESSION['f_name'] = $loginarr[0]->f_name;
            $_SESSION['m_name'] = $loginarr[0]->m_name;
            $_SESSION['l_name'] = $loginarr[0]->l_name;
            $_SESSION['employee_type'] = $loginarr[0]->employee_type;
            $_SESSION['email'] = $loginarr[0]->email;
            $_SESSION['joining_date'] = $loginarr[0]->joining_date;
            $_SESSION['group_id'] = $loginarr[0]->group_id;
            $_SESSION['center_id'] = $loginarr[0]->center_id;
            $user_group_data = json_decode($commonObj->getUserGroupData(array("id" => $loginarr[0]->group_id)));
            $_SESSION['access_location'] = $user_group_data[0]->access_location;
            $_SESSION['access_center'] = $user_group_data[0]->access_center;
            $centerFxn = new masterFxn();

            $permissionArr = json_decode($commonObj->getPermission($loginarr[0]->group_id));
            //print_r($permissionArr);
            $roleArr = array();
            foreach ($permissionArr as $k => $v) {
                $role_data = json_decode($commonObj->getUserRole($v->role_id));

                $roleArr[$k]['page_name'] = $role_data[0]->rol_page_name;
                $roleArr[$k]['can_read'] = $v->can_read;
                $roleArr[$k]['can_update'] = $v->can_update;
                $roleArr[$k]['can_delete'] = $v->can_delete;
            }
            $_SESSION['permission'] = $roleArr;

            $getUserGroupData = json_decode($commonObj->getUserGroupData(array("id" => $loginarr[0]->group_id)));

            $_SESSION['access_location'] = $getUserGroupData[0]->access_location;
            $_SESSION['access_center'] = $getUserGroupData[0]->access_center;
            header("location:" . SITE_URL);
        }
    }
} else if ((isset($_REQUEST['username']) && !empty($_REQUEST['username'])) && (isset($_REQUEST['password']) && !empty($_REQUEST['password'])) && (isset($_REQUEST['user_type']) && $_REQUEST['user_type'] != '' && $_REQUEST['user_type'] == '1')) {
    $uname = $_REQUEST['username'];
//    $pass = base64_encode($_REQUEST['password']);
        $pass = $_REQUEST['password'];

    if ($commonObj->studentUserNameExist($uname)) {
        $loginarr = json_decode($commonObj->studentCheckLogin($uname, $pass));
        if ($loginarr) {
            
            $_SESSION['st_id'] = $loginarr[0]->id;
            $_SESSION['student_id'] = $loginarr[0]->student_id;
            
            $_SESSION['f_name'] = $loginarr[0]->f_name;
            $_SESSION['m_name'] = $loginarr[0]->m_name;
            $_SESSION['l_name'] = $loginarr[0]->l_name;
            $_SESSION['employee_type'] = $loginarr[0]->employee_type;
            $_SESSION['email'] = $loginarr[0]->email;
            $_SESSION['batch_status'] = $loginarr[0]->batch_status;
            $_SESSION['study_center_id'] = $loginarr[0]->study_center_id;
            $_SESSION['batch_join'] = $loginarr[0]->batch_join;            
            $_SESSION['sub_course_join'] = $user_group_data[0]->sub_course_join;
            $_SESSION['pkg_opt'] = $user_group_data[0]->pkg_opt;
            $_SESSION['st_type'] = $user_group_data[0]->st_type;
            
            header("location:" . SITE_URL);
        }
    }
}

?>
<html>
    <head>
        <title>Admin Panel</title>
        <!-- Core CSS - Include with every page -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- SB Admin CSS - Include with every page -->
        <link href="../css/sb-admin.css" rel="stylesheet">
    </head>
    <body>   
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <?php
                    echo $commonObj->getSuccessMsg();
                    echo $commonObj->getErrorMsg();
                    $commonObj->unsetMessage();
                    ?>
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>

<!--            <img src="images/logo.gif" style="overflow:hidden" width="280px" width="350px"><br>-->

                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <fieldset>

                                    <!--                    <div class="form-group">
                                                              <div style="color:blue;text-align:center;margin-top:5px;"><b>STUDENT LOGIN</b></div>                  
                                                        </div>-->

                                    <div class="form-group">

                                        <input class="form-control" placeholder="Username" name="username" type="text" value="" id="username" autofocus>
                                    </div>


                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <select name='user_type' class="form-control">
                                            <option value='1'>Student's</option>
                                            <option value='2'>Employee's</option>
                                        </select>
                                    </div>

                                    <div class="checkbox">
                                        <input type="checkbox" name="remember" id="remember"/>Remember Me
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" name="submit" value="Login" class="btn btn-lg btn-success btn-block">
                                </fieldset><br>
                                <a href="forget_password.php" style="padding:10px;">Forget Password?</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Core Scripts - Include with every page -->
        <script src="../js/jquery-1.10.2.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>

        <!-- SB Admin Scripts - Include with every page -->
        <script src="../js/sb-admin.js"></script>

    </body>

</html>
