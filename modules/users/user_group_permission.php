<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if(!$commonObj->canUpdate($_REQUEST['page']) || !$commonObj->canAccess($_REQUEST['page'])){
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}
$commonObj->autoload("userFxn");
$userFxn = new userFunctions();
if (!isset($_REQUEST['group_id'])) {
    header("location:" . SITE_URL . "?page=users_user_group_list");
}else{
    $groupId = $commonObj->decode($_REQUEST['group_id']);
    $permissionArr = json_decode($commonObj->getPermission($groupId));
    $group_data = json_decode($userFxn->getUserGroupData(array("id"=>$groupId)));
    $location_access = explode(",",$group_data[0]->access_location);
    $access_center = explode(",", $group_data[0]->access_center);
//    print_R($permissionArr);die;
//    print_R($group_data);die;
}


$userData = json_decode($userFxn->getAllLocations());
$userRole = json_decode($userFxn->getAllUserRoles());

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'save') {
    if($userFxn->addPermission())
        $userFxn->setSuccessMsg ("Record Added Successfully!");
    else
        $userFxn->setErrorMsg ("Record Cannot Be added!");
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

            <h3 class="page-header">User Group permissions</h3>

        </div>
    </div>
    <!-- /.col-lg-12 -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <form name="permission" method="post">

                <table class="table table-striped table-bordered table-hover" >
                    <tr>
                        <th colspan='4'>
                            Branch Access/Locations
                        </th>
                    </tr>
                    <tr>

                        <?php
                        $x = 0;
                        $y = 0;
                        $count_location = count($location_access);
                        
                        if (count($userData) > 0){
                            foreach ($userData as $k => $v) {
                                if ($x == 4) {
                                    $x = 0;
                                    ?>
                                <tr>
                                <?php }
                                if($y >= $count_location){
                                    $y = 0;
                                }?>
                                <td>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="per_access_location[]" value="<?php echo $v->id; ?>" onclick="chkLocations(this.value, this.checked,<?php echo $v->id; ?>);" id="per_location" <?php if($location_access[$y] == $v->id){echo "checked";$y++;} ?>><?php echo $v->name; ?>
                                    </label>
                                </td>

                                <?php
                                if ($x == 4) {
                                    ?></tr>

                                <?php
                            }$x++;
                        }
                        }
                    ?>

                </table>
                <div>
                    <table class="table table-striped table-bordered table-hover" id="centerList">
                        <tr><th colspan="4">Centers/Department's</th></tr>    
                    </table>
                </div>
                <div class="panel panel-default">

                    <div class="panel-heading" style="text-align:center;">
                        User Group List        

                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <div class="table-responsive">

                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Access</th>
                                        <th>Role Name</th>
                                        <th>Role Description</th>
 
                                        <th colspan="0" align="center">Write</th>
                                        <th colspan="0" align="center">Delete</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    <?php $sno = 0; $x=0; $i=0;
                                    
                                    if(count($permissionArr)>0)
                                        $x = count($permissionArr);
                                    ?>
                                    <?php
                                    if ($userRole && count($userRole) > 0)
                                        foreach ($userRole as $k => $v) {
                                        $read = false;
                                        $can_update = false;
                                        $can_delete = false;
//                                            if($i>=$x)
//                                                $i=0;                                        
                                            for($i=0;$i<count($permissionArr);$i++){
                                                if($permissionArr[$i]->role_id == $v->id){
                                                    $read = true;
                                                    if($permissionArr[$i]->can_update == 1)
                                                        $can_update = true;
                                                    if($permissionArr[$i]->can_delete == 1)
                                                        $can_delete = true;
                                                }
                                            }
                                            ?>

                                        <td><input type="checkbox" onclick="checkRead(this.checked, this.value)" value="<?php echo $v->id; ?>" name="per_role_id[]" id="per_role_id_<?php echo $v->id; ?>" <?php echo isset($_REQUEST['per_role_id'][$sno])? "checked": $read? "checked":'';?> ></td>
                                        <td><?php echo $v->rol_name; ?></td>
                                        <td><?php echo $v->rol_description; ?></td>
                                        <!--<input type="hidden" value="<?php echo $v->id; ?>" name="per_role_id[]">-->
                                        <!--<td>-->
<!--                                            <input type='checkbox' name='per_read[]' value='<?php echo $v->id; ?>' id="per_read_<?php echo $v->id; ?>" disabled="true" <?php echo isset($_REQUEST['per_read'][$sno])? "checked":'';?>/>
                                            <input type='hidden' name='per_read[]' value='<?php echo $v->id; ?>'/>-->
                                        <!--</td>-->
                                        <td><input type='checkbox' name='per_update[]' value='<?php echo $v->id; ?>' onclick="checkUpdate(this.checked, this.value);" id="per_update_<?php echo $v->id;?>" <?php echo isset($_REQUEST['per_update'][$sno])? "checked": $can_update? "checked":'';?>/></td>
                                        <td><input type='checkbox' name='per_delete[]' value='<?php echo $v->id; ?>' onclick="checkDelete(this.checked, this.value);" id="per_delete_<?php echo $v->id;?>" <?php echo isset($_REQUEST['per_delete'][$i])? "checked": $can_delete? "checked":'';?>/></td>
                                        </tr>
                                    <?php $sno++;} ?>

                                </tbody>
                            </table>
                        </div></div></div>

                <center><input type='submit' name='save' value='save' class="btn btn-success"></center>
            </form>
            <!-- /.table-responsive -->

            <!-- Core Scripts - Include with every page -->
            <!--<script src="<?php echo JS_URL; ?>jquery-1.10.2.js"></script>-->
            <!--<script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>-->
            <!--<script src="<?php echo JS_URL; ?>plugins/metisMenu/jquery.metisMenu.js"></script>-->

            <!-- Page-Level Plugin Scripts - Tables -->
<!--                <script src="<?php echo JS_URL; ?>plugins/dataTables/jquery.dataTables.js"></script>-->
            <!--<script src="<?php echo JS_URL; ?>plugins/dataTables/dataTables.bootstrap.js"></script>-->

            <!-- SB Admin Scripts - Include with every page -->
            <!--<script src="<?php echo JS_URL; ?>sb-admin.js"></script>-->

            <!-- Page-Level Demo Scripts - Tables - Use for reference -->
            <script>//
//                $(document).ready(function () {
//                    $('#dataTables-example').dataTable();
//                });
//            </script>
            <script>
                $(document).ready(function(){
                    var val = document.getElementById('per_location');                    
//                    $("per_access_location").each(function(index,val){
//                        alert("Test");
//                    });
//                    if (chk == true)
//                    {
//                        getCenterList(id, 'userFunctions', 'userFxn', 'centerList');
//                    } else {
//
//                        $("#loc_id" + id).remove();
//                    }
                });
                function chkLocations(id, chk, locId)
                {

                    var val = document.getElementById('per_location');
                    if (chk == true)
                    {
                        getCenterList(id, 'userFunctions', 'userFxn', 'centerList');
                    } else {

                        $("#loc_id" + id).remove();
                    }
                }
                function checkRead(chk, id) {
                    if (chk === true) {

                        $("#per_read_" + id).prop("checked", true);
                    } else {
                        
                        
                        $("#per_update_" + id).prop("checked", false);
                        $("#per_read_" + id).prop("checked", false);
                        $("#per_delete_" + id).prop("checked", false);
                        //$("#per_role_id_" + id).prop("checked", false);
                    }
                }

                function checkUpdate(chk, id) {
                    if (chk === true) {
                        $("#per_role_id_" + id).prop("checked", true);
                        $("#per_read_" + id).prop("checked", true);
                    } 
                }

                function checkDelete(chk, id) {

                    if (chk === true) {
                        $("#per_role_id_" + id).prop("checked", true);
                        $("#per_delete_" + id).prop("checked", true);
                        
                    } 
                }
            </script>