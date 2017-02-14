<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
//if(!$commonObj->canUpdate("employee_employeeList") || !$commonObj->canAccess("employee_employeeList")){
//    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
//    $commonObj->redirectUrl();
//    exit();
//}

$commonObj->autoload("employeeFxn");
$commonObj->autoload("userFxn");
$empFxn = new employeeFxn();
$userFxn = new userFunctions();
$quali_list = json_decode($empFxn->getQualification());
$user_group_list = json_decode($userFxn->getUserGroupData());

if (isset($_REQUEST['id']))
    $userId = $empFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {    
    $empFxn->updateEmployee($userId);
    header("location:" . SITE_URL . "?page=employee_myDetailDesc&id=".$empFxn->encode($userId));
    exit;
} else if (isset($_REQUEST['id'])) {
    $empData = json_decode($empFxn->getEmployeeList(array('id' => $userId)));
    $empQualiData = json_decode($empFxn->getEmpQualification(array("emp_id" => $userId)));
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
            echo $empFxn->getSuccessMsg();
            echo $empFxn->getErrorMsg();
            $empFxn->unsetMessage();
            ?>
            <h3 class="page-header">My Profile</h3>
            <div class="panel panel-default">
                <form name="employee_frm" id="employee_frm" enctype="multipart/form-data" method="post">
                    <div class="panel-heading">
                        My Personal Details
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#personal" data-toggle="tab">Personal</a>
                            </li>
                            <li class=""><a href="#contact" data-toggle="tab">Contact</a>
                            </li>
                            <li class=""><a href="#education" data-toggle="tab">Education</a>
                            </li>
                            <li class=""><a href="#group" data-toggle="tab">Other's</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="personal">

                                <p>
                                <table border="0" cellspacing="15" cellpadding="5">
                                    <tr>                             
                                        <td><label>First name</label><input type="text" name="emp_f_name" placeholder ="Enter first name" class="form-control " readonly="true" value="<?php if (isset($_REQUEST['emp_f_name'])) {
                echo $_REQUEST['emp_f_name'];
            } elseif (isset($empData[0])) {
                echo $empData[0]->f_name;
            } else {
                echo '';
            } ?>"/>
                                        </td>

                                        <td><label>Middle name</label><input type="text" name="emp_m_name" placeholder ="Enter middle name" class="form-control" readonly="true" value="<?php if (isset($_REQUEST['emp_m_name'])) {
                echo $_REQUEST['emp_m_name'];
            } elseif (isset($empData[0])) {
                echo $empData[0]->m_name;
            } else {
                echo '';
            } ?>"/>

                                        </td>
                                        <td><label>Last name</label><input type="text" name="emp_l_name" placeholder ="Enter Last" class="form-control" readonly="true" value='<?php if (isset($_REQUEST['emp_f_name'])) {
                echo $_REQUEST['emp_l_name'];
            } elseif (isset($empData[0])) {
                echo $empData[0]->l_name;
            } else {
                echo '';
            } ?>'/>

                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label>Father's Name</label>
                                            <input type="text" readonly="true" name="emp_father_name" placeholder ="Enter Father's Name" class="form-control" value='<?php if (isset($_REQUEST['emp_father_name'])) {
                echo $_REQUEST['emp_father_name'];
            } elseif (isset($empData[0]->father_name)) {
                echo $empData[0]->father_name;
            } else {
                echo '';
            } ?>'/>
                                        </td>
                                        <td><label>DOB</label>
                                            <input type="date" name="emp_dob" readonly="true" placeholder="dd-mm-yyyy" class="form-control" value='<?php if (isset($_REQUEST['emp_dob'])) {
                echo $_REQUEST['emp_dob'];
            } elseif (isset($empData[0]->dob)) {
                echo $empData[0]->dob;
            } else {
                echo '';
            } ?>'/>
                                        </td>
                                        <td><label>Gender</label><br>
                                            <input type="radio" name="emp_gender" value="M" readonly="true" class=" form-group"<?php if (isset($_REQUEST['emp_gender']) && $_REQUEST['emp_gender'] == 'M') {
                echo "checked";
            } else if (isset($empData[0]) && $empData[0]->gender == 'M') {
                echo "checked";
            } ?>/>Male
                                            <input type="radio" name="emp_gender" value="F" readonly="true" style="padding:20px 0px;" <?php if (isset($_REQUEST['emp_gender']) && $_REQUEST['emp_gender'] == 'F') {
                echo "checked";
            } else if (isset($empData[0]->gender) && $empData[0]->gender == 'F') {
                echo "checked";
            } ?>/>Female
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Marital Status</label><br>
                                            <input type="radio" name="emp_marital" value="single" readonly="true" class="form-group"<?php if (isset($_REQUEST['emp_marital']) && $_REQUEST['emp_marital'] == 'single') {
                echo "checked";
            } else if (isset($empData[0]->marital) && $empData[0]->marital == 'single') {
                echo "checked";
            } ?>/> Single
                                            <input type="radio" name="emp_marital" value="married" style="padding:20px 0px;"<?php if (isset($_REQUEST['emp_marital']) && $_REQUEST['emp_marital'] == 'M') {
                echo "checked";
            } else if (isset($empData[0]->marital) && $empData[0]->marital == 'married') {
                echo "checked";
            } ?>/> Married                                    </td>
                                    </tr>

                                </table>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="contact">
                                <h4>Permanent Contact Details</h4>
                                <p>
                                <table>
                                    <tr>
                                        <td>
                                            <label>Street1</label>
                                            <input type="text" name="emp_street1" placeholder ="Enter Street1" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_street1'])) {
                echo $_REQUEST['emp_street1'];
            } else if (isset($empData[0]->street1)) {
                echo $empData[0]->street1;
            } ?>'/>

                                        </td>
                                        <td>
                                            <label>Street2</label>
                                            <input type="text" name="emp_street2" placeholder ="Enter Street2" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_street2'])) {
                echo $_REQUEST['emp_street2'];
            } else if (isset($empData[0]->street2)) {
                echo $empData[0]->street2;
            } ?>'/>

                                        </td>

                                        <td>
                                            <label>City</label>
    <!--                                        <select class="form-control" name="emp_city">
                                                <option value=""></option>
                                            </select>-->
                                            <input type="text" name="emp_city" placeholder ="City" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_city'])) {
                echo $_REQUEST['emp_city'];
            } else if (isset($empData[0]->city)) {
                echo $empData[0]->city;
            } ?>'/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>State</label>
    <!--                                        <select class="form-control" name="emp_state">
                                                <option value=""></option>
                                            </select>-->
                                            <input type="text" name="emp_state" placeholder ="State" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_state'])) {
                echo $_REQUEST['emp_state'];
            } else if (isset($empData[0]->state)) {
                echo $empData[0]->state;
            } ?>'/>
                                        </td>
                                        <td>
                                            <label>Zip Code</label>
                                            <input type="text" name="emp_zipcode" placeholder ="Enter zip code" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_zipcode'])) {
                echo $_REQUEST['emp_zipcode'];
            } else if (isset($empData[0]->zipcode)) {
                echo $empData[0]->zipcode;
            } ?>'/>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Home Telephone</label>
                                            <input type="text" name="emp_home_telephone" placeholder ="Enter Home Telephone" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_home_telephone'])) {
                echo $_REQUEST['emp_home_telephone'];
            } else if (isset($empData[0]->home_telephone)) {
                echo $empData[0]->home_telephone;
            } ?>'/>

                                        </td>
                                        <td>
                                            <label>Mobile</label>
                                            <input type="text" name="emp_mobile" placeholder ="Enter Mobile No." size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_mobile'])) {
                echo $_REQUEST['emp_mobile'];
            } else if (isset($empData[0]->mobile)) {
                echo $empData[0]->mobile;
            } ?>'/>

                                        </td>

                                        <td>
                                            <label>Personal Email</label>
                                            <input type="email" name="emp_email" placeholder ="Enter Email." size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_email'])) {
                echo $_REQUEST['emp_email'];
            } else if (isset($empData[0]->email)) {
                echo $empData[0]->email;
            } ?>'/>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3">

                                            Emergency Contact Details
                                        </th>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Name</label>
                                            <input type="text" name="emp_emer_name" placeholder ="Enter Name" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_emer_name'])) {
                echo $_REQUEST['emp_emer_name'];
            } else if (isset($empData[0]->emer_name)) {
                echo $empData[0]->emer_name;
            } ?>'/>

                                        </td>
                                        <td>
                                            <label>Relationship</label>
                                            <input type="text" name="emp_emer_relation" placeholder ="Enter Relationship" size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_emer_relation'])) {
                echo $_REQUEST['emp_emer_relation'];
            } else if (isset($empData[0]->emer_relation)) {
                echo $empData[0]->emer_relation;
            } ?>'/>

                                        </td>

                                        <td>
                                            <label>Mobile</label>
                                            <input type="text" name="emp_emer_mobile" placeholder ="Enter Mobile No." size="30" class="form-control" value='<?php if (isset($_REQUEST['emp_emer_mobile'])) {
                echo $_REQUEST['emp_emer_mobile'];
            } else if (isset($empData[0]->emer_mobile)) {
                echo $empData[0]->emer_mobile;
            } ?>'/>

                                        </td>
                                    </tr>
                                </table>
                                </p>
                            </div>
                            <div class="tab-pane fade" id="education">
                                <div id="education_inner_div">
                                    <h4>Education</h4>
                                    <p>
                                    <table id="education_tbl">
                                                <?php if (isset($_REQUEST['emp_level'])) { ?>
                                            <tr id="edu1">
                                                <td>
                                                    <label>Level</label>
                                                    <select class=" form-control" name="emp_level[]">
                                                        <option value="">--Select Level--</option>
    <?php
    foreach ($quali_list as $k => $v) {
        if ($v->is_deleted == '1')
            continue;
        ?>
                                                            <option value="<?php echo $v->id ?>" <?php if (isset($_REQUEST['emp_level']) && $_REQUEST['emp_level'] == $v->id) {
            echo "selected";
        } ?>><?php echo $v->name; ?>
    <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <label>Discipline</label>
                                                    <select class="form-control" name="emp_discipline[]">
                                                        <option value="">--Select Discipline--</option>
                                                        <option value="Full time"<?php if (isset($_REQUEST['emp_discipline']) && $_REQUEST['emp_discipline'] == "Full time") {
        echo "checked";
    } ?>>Full time</option>
                                                        <option value="Part time"<?php if (isset($_REQUEST['emp_discipline']) && $_REQUEST['emp_discipline'] == "Part time") {
        echo "checked";
    } ?>Part time</option>
                                                        <option value="Distance learning"<?php if (isset($_REQUEST['emp_discipline']) && $_REQUEST['emp_discipline'] == "Distance learning") {
        echo "checked";
    } ?>Distance learning</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <label>Institute/college</label>
                                                    <input type="text" name="emp_college[]" id="edu_college1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Specialization</label>
                                                    <input type="text" name="emp_specialization[]" id="edu_specialization1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Pass Year</label>
                                                    <input type="text" name="emp_passYear[]" id="edu_passYear1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>GPA/Score</label>
                                                    <input type="text" name="emp_gpa_score[]" id="edu_gpa_score1" class="form-control" >
                                                </td>
                                                <td><label>&nbsp;</label>
                                                    <input type="button" class="btn btn-primary" value="Add More" id="edu_add_more">
                                                </td>
                                            </tr>
<?php
} else if (isset($empQualiData) && count($empQualiData) > 0) {
    for ($i = 0; $i < sizeof($empQualiData); $i++) {
        ?>
                                                <tr id="edu<?php echo $i + 1; ?>">
                                                    <td>
                                                        <label>Level</label>
                                                        <select class=" form-control" name="emp_level[]">
                                                            <option value="">--Select Level--</option>
        <?php
        foreach ($quali_list as $k => $v) {
            if ($v->is_deleted == '1')
                continue;
            ?>
                                                                <option value="<?php echo $v->id ?>" <?php if ($empQualiData[$i]->level == $v->id) {
                echo "selected";
            } ?>><?php echo $v->name; ?>
        <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label>Discipline</label>
                                                        <select class="form-control" name="emp_discipline[]">
                                                            <option value="">--Select Discipline--</option>
                                                            <option value="Full time"<?php if (isset($empQualiData[$i]) && $empQualiData[$i]->discipline == "Full time") {
            echo "selected";
        } ?>>Full time</option>
                                                            <option value="Part time"<?php if (isset($empQualiData[$i]) && $empQualiData[$i]->discipline == "Part time") {
            echo "selected";
        } ?>>Part time</option>
                                                            <option value="Distance learning"<?php if (isset($empQualiData[$i]) && $empQualiData[$i]->discipline == "Distance learning") {
            echo "selected";
        } ?>>Distance learning</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <label>Institute/college</label>
                                                        <input type="text" name="emp_college[]" id="edu_college1" class="form-control" value="<?php if (isset($empQualiData[$i])) {
            echo $empQualiData[$i]->college;
        } ?>">
                                                    </td>
                                                    <td>
                                                        <label>Specialization</label>
                                                        <input type="text" name="emp_specialization[]" id="edu_specialization1" class="form-control" value="<?php if (isset($empQualiData[$i])) {
            echo $empQualiData[$i]->specialization;
        } ?>">
                                                    </td>
                                                    <td>
                                                        <label>Pass Year</label>
                                                        <input type="text" name="emp_passYear[]" id="edu_passYear1" class="form-control" value="<?php if (isset($empQualiData[$i])) {
            echo $empQualiData[$i]->passYear;
        } ?>">
                                                    </td>
                                                    <td>
                                                        <label>GPA/Score</label>
                                                        <input type="text" name="emp_gpa_score[]" id="edu_gpa_score1" class="form-control" value='<?php if (isset($empQualiData[$i])) {
            echo $empQualiData[$i]->gpa_score;
        } ?>'>
                                                    </td>
                                                    <td><label>&nbsp;</label><?php if($i==0){?>
                                                            <input type="button" class="btn btn-primary" value="Add More" id="edu_add_more">
                                                    <?php }else{?><br>
                                                            <input type="button" class="btn btn-danger" value="Remove" id="edu_remove" onclick="eduRemove('<?php echo $i+1;?>');">
                                                    <?php }?>
                                                    </td>
                                                </tr>    
    <?php }
}else{
?>
                                                <tr id="edu1">
                                                <td>
                                                    <label>Level</label>
                                                    <select class=" form-control" name="emp_level[]">
                                                        <option value="">--Select Level--</option>
    <?php
    foreach ($quali_list as $k => $v) {
        if ($v->is_deleted == '1')
            continue;
        ?>
                                                            <option value="<?php echo $v->id ?>"><?php echo $v->name; ?>
    <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <label>Discipline</label>
                                                    <select class="form-control" name="emp_discipline[]">
                                                        <option value="">--Select Discipline--</option>
                                                        <option value="Full time">Full time</option>
                                                        <option value="Part time">Part time</option>
                                                        <option value="Distance learning">Distance learning</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <label>Institute/college</label>
                                                    <input type="text" name="emp_college[]" id="edu_college1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Specialization</label>
                                                    <input type="text" name="emp_specialization[]" id="edu_specialization1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Pass Year</label>
                                                    <input type="text" name="emp_passYear[]" id="edu_passYear1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>GPA/Score</label>
                                                    <input type="text" name="emp_gpa_score[]" id="edu_gpa_score1" class="form-control" >
                                                </td>
                                                <td><label>&nbsp;</label>
                                                    <input type="button" class="btn btn-primary" value="Add More" id="edu_add_more">
                                                </td>
                                            </tr>
<?php }?>
                                    </table>
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="group">
                                <h4>Generate User</h4>
                                <p>
                                <table>
                                    <tr>
                                        <td><label>Assign User Group</label>
                                            <select name="emp_group_id" class="form-control">
                                                <option value="">--Select Group--</option>
<?php foreach ($user_group_list as $k => $v) {
    ?>
                                                    <option value="<?php echo $v->id; ?>"<?php if (isset($_REQUEST['emp_group_id']) && $_REQUEST['emp_group_id'] == $v->id) echo "selected";else if (isset($empData[0]) && $empData[0]->group_id == $v->id) {
        echo "selected";
    } ?>><?php echo $v->group_name; ?></option>
<?php } ?>
                                            </select>
                                        </td>

                                        <td>
                                            <label>Employee Type</label>
                                            <select name="emp_employee_type" class="form-control" onchange="employeeType(this.value);" id="emp_employee_type" readonly="true">
                                                <option value="">--Employee Type--</option>
                                                <option value="Full Time Trainer" <?php if(isset($_REQUEST['emp_employee_type']) && $_REQUEST['emp_employee_type'] == 'Full Time Trainer') {
    echo "selected";
}else if(isset($empData[0])&& $empData[0]->employee_type == "Full Time Trainer"){echo "selected";} ?>>Full Time Trainer</option>
                                                <option value="other"<?php if(isset($_REQUEST['emp_employee_type']) && $_REQUEST['emp_employee_type'] == 'other') {
    echo "selected";
}else if(isset($empData[0]) && $empData[0]->employee_type == "other"){echo "selected";} ?>>Other Employee</option>
                                            </select>
                                        </td>
                                        <td id="emp_oth" style="display:none;"><label>Please Specify</label><input type='emp_employee_type' class='form-control' id="emp_employee_type" value="<?php if(isset($_REQUEST['emp_employee_type']) && $_REQUEST['emp_employee_type'] == 'other') {
    echo $_REQUEST['emp_employee_type'];
}else if(isset($empData[0])){echo $empData[0]->employee_type;} ?>"></td>
                                        
                                        <td><label>Select Image</label>
                                            <input type="file" name="emp_image" id="emp_image">
                                            
                                        </td>
                                        
                                        <td><img src="<?php echo SITE_URL."images/emp_img/".$empData[0]->image;?>" alt="employee image" width="90px" height="80px"></td>
                                        
                                    </tr>
                                </table>
                                </p>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-warning" style=" margin-left: 450px" value="Save" name="save">
                    </div>
                </form>
            </div>
            <!-- /.panel-body -->

        </div>
        <!-- /.panel -->
        <script>
            
            $(document).ready(function(){
               
               if($("#emp_employee_type").val()=='other'){
                    $("#emp_oth").css("display", "block");
                    $("#emp_employee_type").removeAttr("disabled", "disabled");
               }
            });

            $(document).ready(function () {
                var outer = $('#education_inner_div');
                var i = $('#education_tbl').size() + 1;
                $("#edu_add_more").click(function () {

                    $('<tr id="edu' + i + '"> <td> <label>Level</label> <select class=" form-control" name="emp_level[]"> <option value="">--Select Level--</option><?php foreach ($quali_list as $k => $v) {
    if ($v->is_deleted == '1') continue; ?> <option value="<?php echo $v->id ?>"><?php echo $v->name; ?> <?php } ?>   </select> </td> <td> <label>Discipline</label> <select class="form-control" name="emp_discipline[]"> <option value="">--Select Level--</option> <option value="Full time">Full time</option> <option value="Part time">Part time</option> <option value="Distance learning">Distance learning</option> </select> </td>  <td> <label>Institute/college</label> <input type="text" name="emp_college[]" id="edu_college1" class="form-control" > </td> <td> <label>Specialization</label> <input type="text" name="emp_specialization[]" id="edu_specialization1" class="form-control" > </td> <td> <label>Pass Year</label> <input type="text" name="emp_passYear[]" id="edu_passYear1" class="form-control" > </td> <td> <label>GPA/Score</label> <input type="text" name="emp_gpa_score[]" id="edu_gpa_score1" class="form-control" > </td> <td><label>&nbsp;</label><br> <input type="button" class="btn btn-danger" value="Remove" id="edu_remove" onclick="eduRemove(' + i + ');"> </td> </tr>').appendTo("#education_tbl");
                    i++;
                    return false;
                });
//                $("#edu_remove").click(function () {
//                    alert("text");
//                    if (i >= 2) {
//                        $(this).parents('').remove();
//                        i--;
//                    }
//                });
            });
            function eduRemove(i) {
                alert(i);
//                var outer = $('#education_inner_div');
//                var i = $('#education_tbl').size() + 1;
                
                if (i >= 2) {
                    $("#edu" + i).remove();
                    i--;
                }
            }
            function employeeType(val) {

                if (val == 'other') {
                    $("#emp_oth").css("display", "block");
                    $("#emp_employee_type").removeAttr("disabled", "disabled");
                } else if (val != 'other') {
                    $("#emp_oth").css("display", "none");
                    $("#emp_employee_type").attr("disabled", "true");

                }
            }
        </script>