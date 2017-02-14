<?php
if (!defined('BASE_PATH')) {
    die("Access Denied!");
}
if (!$commonObj->canUpdate("student_student_list") || !$commonObj->canAccess("student_student_list")) {
    $commonObj->setErrorMsg("Sorry you dont have rights to access this page!");
    $commonObj->redirectUrl();
    exit();
}

$commonObj->autoload("studentFxn");
$commonObj->autoload("courseFxn");
$commonObj->autoload("masterFxn");
$commonObj->autoload("examFxn");
$studentFxn = new studentFxn();
$courseFxn = new courseFxn();
$masterFxn = new masterFxn();
$examFxn = new examFxn();
$studyCenterList = json_decode($masterFxn->getCenterListByAccess());

$batchList = json_decode($courseFxn->getBatchList(array("status" => '1')));
$exmPackageList = json_decode($examFxn->getPackageList());
$quali_list = json_decode($studentFxn->getQualification());


if (isset($_REQUEST['id']))
    $userId = $studentFxn->decode($_REQUEST['id']);

if (isset($_REQUEST['save']) && $_REQUEST['save'] == 'Save' && $_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['id'])) {
    if ($studentFxn->addStudent()) {
        header("location:" . SITE_URL . "?page=student_studentDesc");
        exit;
    }
} else if (isset($_REQUEST['save']) == 'Save' && isset($_REQUEST['id'])) {

    $studentFxn->updateStudent($userId);
    header("location:" . SITE_URL . "?page=student_studentDesc&id=" . $studentFxn->encode($userId));
    exit;
} else if (isset($_REQUEST['id'])) {
    $stuData = json_decode($studentFxn->getStudentList(array('id' => $userId)));
    $stuQualiData = json_decode($studentFxn->getStuQualification(array("emp_id" => $userId)));
    $stuPkgSelected = json_decode($studentFxn->getStudentOptPaper(array("stu_id" => $userId,"tblcolumns"=>array("pkg_id"))));
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
            echo $studentFxn->getSuccessMsg();
            echo $studentFxn->getErrorMsg();
            $studentFxn->unsetMessage();
            ?>
            <h3 class="page-header">Student Data</h3>
            <div class="panel panel-default">
                <form name="student_frm" id="student_frm" enctype="multipart/form-data" method="post" novalidate="novalidate">
                    <div class="panel-heading">
                        Student Detail's
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
                            <li class=""><a href="#group" data-toggle="tab">Course</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="personal">

                                <p>
                                <table border="0" cellspacing="15" cellpadding="5">
                                    <tr>                             
                                        <td><label>First name</label><input type="text" name="stu_f_name" placeholder ="Enter first name" class="form-control " id="stu_f_name" value="<?php
                                            if (isset($_REQUEST['stu_f_name'])) {
                                                echo $_REQUEST['stu_f_name'];
                                            } elseif (isset($stuData[0])) {
                                                echo $stuData[0]->f_name;
                                            } else {
                                                echo '';
                                            }
                                            ?>"/>
                                        </td>

                                        <td><label>Middle name</label><input type="text" name="stu_m_name" placeholder ="Enter middle name" class="form-control"  value="<?php
                                            if (isset($_REQUEST['stu_m_name'])) {
                                                echo $_REQUEST['stu_m_name'];
                                            } elseif (isset($stuData[0])) {
                                                echo $stuData[0]->m_name;
                                            } else {
                                                echo '';
                                            }
                                            ?>"/>

                                        </td>
                                        <td><label>Last name</label><input type="text" name="stu_l_name" placeholder ="Enter Last" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_l_name'])) {
                                                echo $_REQUEST['stu_l_name'];
                                            } elseif (isset($stuData[0])) {
                                                echo $stuData[0]->l_name;
                                            } else {
                                                echo '';
                                            }
                                            ?>'/>

                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label>Father's Name</label>
                                            <input type="text" name="stu_father_name" placeholder ="Enter Father's Name" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_father_name'])) {
                                                echo $_REQUEST['stu_father_name'];
                                            } elseif (isset($stuData[0]->father_name)) {
                                                echo $stuData[0]->father_name;
                                            } else {
                                                echo '';
                                            }
                                            ?>'/>
                                        </td>
                                        <td><label>DOB</label>
                                            <input type="date" name="stu_dob" placeholder="dd-mm-yyyy" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_dob'])) {
                                                echo $_REQUEST['stu_dob'];
                                            } elseif (isset($stuData[0]->dob)) {
                                                echo $stuData[0]->dob;
                                            } else {
                                                echo '';
                                            }
                                            ?>'/>
                                        </td>
                                        <td><label>Gender</label><br>
                                            <input type="radio" name="stu_gender" value="M" class=" form-group"<?php
                                            if (isset($_REQUEST['stu_gender']) && $_REQUEST['stu_gender'] == 'M') {
                                                echo "checked";
                                            } else if (isset($stuData[0]) && $stuData[0]->gender == 'M') {
                                                echo "checked";
                                            }
                                            ?>/>Male
                                            <input type="radio" name="stu_gender" value="F"style="padding:20px 0px;" <?php
                                            if (isset($_REQUEST['stu_gender']) && $_REQUEST['stu_gender'] == 'F') {
                                                echo "checked";
                                            } else if (isset($stuData[0]->gender) && $stuData[0]->gender == 'F') {
                                                echo "checked";
                                            }
                                            ?>/>Female
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Marital Status</label><br>
                                            <input type="radio" name="stu_marital" value="single" class=" form-group"<?php
                                            if (isset($_REQUEST['stu_marital']) && $_REQUEST['stu_marital'] == 'single') {
                                                echo "checked";
                                            } else if (isset($stuData[0]->marital) && $stuData[0]->marital == 'single') {
                                                echo "checked";
                                            }
                                            ?>/> Single
                                            <input type="radio" name="stu_marital" value="married" style="padding:20px 0px;"<?php
                                            if (isset($_REQUEST['stu_marital']) && $_REQUEST['stu_marital'] == 'M') {
                                                echo "checked";
                                            } else if (isset($stuData[0]->marital) && $stuData[0]->marital == 'married') {
                                                echo "checked";
                                            }
                                            ?>/> Married                                    </td>
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
                                            <input type="text" name="stu_street1" placeholder ="Enter Street1" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_street1'])) {
                                                echo $_REQUEST['stu_street1'];
                                            } else if (isset($stuData[0]->street1)) {
                                                echo $stuData[0]->street1;
                                            }
                                            ?>'/>

                                        </td>
                                        <td>
                                            <label>Street2</label>
                                            <input type="text" name="stu_street2" placeholder ="Enter Street2" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_street2'])) {
                                                echo $_REQUEST['stu_street2'];
                                            } else if (isset($stuData[0]->street2)) {
                                                echo $stuData[0]->street2;
                                            }
                                            ?>'/>

                                        </td>

                                        <td>
                                            <label>City</label>
    <!--                                        <select class="form-control" name="stu_city">
                                                <option value=""></option>
                                            </select>-->
                                            <input type="text" name="stu_city" placeholder ="City" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_city'])) {
                                                echo $_REQUEST['stu_city'];
                                            } else if (isset($stuData[0]->city)) {
                                                echo $stuData[0]->city;
                                            }
                                            ?>'/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>State</label>
    <!--                                        <select class="form-control" name="stu_state">
                                                <option value=""></option>
                                            </select>-->
                                            <input type="text" name="stu_state" placeholder ="State" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_state'])) {
                                                echo $_REQUEST['stu_state'];
                                            } else if (isset($stuData[0]->state)) {
                                                echo $stuData[0]->state;
                                            }
                                            ?>'/>
                                        </td>
                                        <td>
                                            <label>Zip Code</label>
                                            <input type="text" name="stu_zipcode" placeholder ="Enter zip code" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_zipcode'])) {
                                                echo $_REQUEST['stu_zipcode'];
                                            } else if (isset($stuData[0]->zipcode)) {
                                                echo $stuData[0]->zipcode;
                                            }
                                            ?>'/>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Home Telephone</label>
                                            <input type="text" name="stu_home_telephone" placeholder ="Enter Home Telephone" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_home_telephone'])) {
                                                echo $_REQUEST['stu_home_telephone'];
                                            } else if (isset($stuData[0]->home_telephone)) {
                                                echo $stuData[0]->home_telephone;
                                            }
                                            ?>'/>

                                        </td>
                                        <td>
                                            <label>Mobile</label>
                                            <input type="text" name="stu_mobile" placeholder ="Enter Mobile No." size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_mobile'])) {
                                                echo $_REQUEST['stu_mobile'];
                                            } else if (isset($stuData[0]->mobile)) {
                                                echo $stuData[0]->mobile;
                                            }
                                            ?>'/>

                                        </td>

                                        <td>
                                            <label>Personal Email</label>
                                            <input type="email" name="stu_email" placeholder ="Enter Email." size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_email'])) {
                                                echo $_REQUEST['stu_email'];
                                            } else if (isset($stuData[0]->email)) {
                                                echo $stuData[0]->email;
                                            }
                                            ?>'/>

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
                                            <input type="text" name="stu_emer_name" placeholder ="Enter Name" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_emer_name'])) {
                                                echo $_REQUEST['stu_emer_name'];
                                            } else if (isset($stuData[0]->emer_name)) {
                                                echo $stuData[0]->emer_name;
                                            }
                                            ?>'/>

                                        </td>
                                        <td>
                                            <label>Relationship</label>
                                            <input type="text" name="stu_emer_relation" placeholder ="Enter Relationship" size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_emer_relation'])) {
                                                echo $_REQUEST['stu_emer_relation'];
                                            } else if (isset($stuData[0]->emer_relation)) {
                                                echo $stuData[0]->emer_relation;
                                            }
                                            ?>'/>

                                        </td>

                                        <td>
                                            <label>Mobile</label>
                                            <input type="text" name="stu_emer_mobile" placeholder ="Enter Mobile No." size="30" class="form-control" value='<?php
                                            if (isset($_REQUEST['stu_emer_mobile'])) {
                                                echo $_REQUEST['stu_emer_mobile'];
                                            } else if (isset($stuData[0]->emer_mobile)) {
                                                echo $stuData[0]->emer_mobile;
                                            }
                                            ?>'/>

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
                                        <?php if (isset($_REQUEST['stu_level'])) { ?>
                                            <tr id="edu1">
                                                <td>
                                                    <label>Level</label>
                                                    <select class=" form-control" name="stu_level[]">
                                                        <option value="">--Select Level--</option>
                                                        <?php
                                                        foreach ($quali_list as $k => $v) {
                                                            if ($v->is_deleted == '1')
                                                                continue;
                                                            ?>
                                                            <option value="<?php echo $v->id ?>" <?php
                                                            if (isset($_REQUEST['stu_level']) && $_REQUEST['stu_level'] == $v->id) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $v->name; ?>
                                                                    <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <label>Discipline</label>
                                                    <select class="form-control" name="stu_discipline[]">
                                                        <option value="">--Select Discipline--</option>
                                                        <option value="Full time"<?php
                                                        if (isset($_REQUEST['stu_discipline']) && $_REQUEST['stu_discipline'] == "Full time") {
                                                            echo "checked";
                                                        }
                                                        ?>>Full time</option>
                                                        <option value="Part time"<?php
                                                        if (isset($_REQUEST['stu_discipline']) && $_REQUEST['stu_discipline'] == "Part time") {
                                                            echo "checked";
                                                        }
                                                        ?>Part time</option>
                                                        <option value="Distance learning"<?php
                                                        if (isset($_REQUEST['stu_discipline']) && $_REQUEST['stu_discipline'] == "Distance learning") {
                                                            echo "checked";
                                                        }
                                                        ?>Distance learning</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <label>Institute/college</label>
                                                    <input type="text" name="stu_college[]" id="edu_college1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Specialization</label>
                                                    <input type="text" name="stu_specialization[]" id="edu_specialization1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Pass Year</label>
                                                    <input type="text" name="stu_passYear[]" id="edu_passYear1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>GPA/Score</label>
                                                    <input type="text" name="stu_gpa_score[]" id="edu_gpa_score1" class="form-control" >
                                                </td>
                                                <td><label>&nbsp;</label>
                                                    <input type="button" class="btn btn-primary" value="Add More" id="edu_add_more">
                                                </td>
                                            </tr>
                                            <?php
                                        } else if (isset($stuQualiData) && count($stuQualiData) > 0) {
                                            for ($i = 0; $i < sizeof($stuQualiData); $i++) {
                                                ?>
                                                <tr id="edu<?php echo $i + 1; ?>">
                                                    <td>
                                                        <label>Level</label>
                                                        <select class=" form-control" name="stu_level[]">
                                                            <option value="">--Select Level--</option>
                                                            <?php
                                                            foreach ($quali_list as $k => $v) {
                                                                if ($v->is_deleted == '1')
                                                                    continue;
                                                                ?>
                                                                <option value="<?php echo $v->id ?>" <?php
                                                                if ($stuQualiData[$i]->level == $v->id) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?php echo $v->name; ?>
                                                                        <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label>Discipline</label>
                                                        <select class="form-control" name="stu_discipline[]">
                                                            <option value="">--Select Discipline--</option>
                                                            <option value="Full time"<?php
                                                            if (isset($stuQualiData[$i]) && $stuQualiData[$i]->discipline == "Full time") {
                                                                echo "selected";
                                                            }
                                                            ?>>Full time</option>
                                                            <option value="Part time"<?php
                                                            if (isset($stuQualiData[$i]) && $stuQualiData[$i]->discipline == "Part time") {
                                                                echo "selected";
                                                            }
                                                            ?>>Part time</option>
                                                            <option value="Distance learning"<?php
                                                            if (isset($stuQualiData[$i]) && $stuQualiData[$i]->discipline == "Distance learning") {
                                                                echo "selected";
                                                            }
                                                            ?>>Distance learning</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <label>Institute/college</label>
                                                        <input type="text" name="stu_college[]" id="edu_college1" class="form-control" value="<?php
                                                        if (isset($stuQualiData[$i])) {
                                                            echo $stuQualiData[$i]->college;
                                                        }
                                                        ?>">
                                                    </td>
                                                    <td>
                                                        <label>Specialization</label>
                                                        <input type="text" name="stu_specialization[]" id="edu_specialization1" class="form-control" value="<?php
                                                        if (isset($stuQualiData[$i])) {
                                                            echo $stuQualiData[$i]->specialization;
                                                        }
                                                        ?>">
                                                    </td>
                                                    <td>
                                                        <label>Pass Year</label>
                                                        <input type="text" name="stu_passYear[]" id="edu_passYear1" class="form-control" value="<?php
                                                        if (isset($stuQualiData[$i])) {
                                                            echo $stuQualiData[$i]->passYear;
                                                        }
                                                        ?>">
                                                    </td>
                                                    <td>
                                                        <label>GPA/Score</label>
                                                        <input type="text" name="stu_gpa_score[]" id="edu_gpa_score1" class="form-control" value='<?php
                                                        if (isset($stuQualiData[$i])) {
                                                            echo $stuQualiData[$i]->gpa_score;
                                                        }
                                                        ?>'>
                                                    </td>
                                                    <td><label>&nbsp;</label><?php if ($i == 0) { ?>
                                                            <input type="button" class="btn btn-primary" value="Add More" id="edu_add_more">
                                                        <?php } else { ?><br>
                                                            <input type="button" class="btn btn-danger" value="Remove" id="edu_remove" onclick="eduRemove('<?php echo $i + 1; ?>');">
                                                        <?php } ?>
                                                    </td>
                                                </tr>    
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr id="edu1">
                                                <td>
                                                    <label>Level</label>
                                                    <select class=" form-control" name="stu_level[]">
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
                                                    <select class="form-control" name="stu_discipline[]">
                                                        <option value="">--Select Discipline--</option>
                                                        <option value="Full time">Full time</option>
                                                        <option value="Part time">Part time</option>
                                                        <option value="Distance learning">Distance learning</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <label>Institute/college</label>
                                                    <input type="text" name="stu_college[]" id="edu_college1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Specialization</label>
                                                    <input type="text" name="stu_specialization[]" id="edu_specialization1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>Pass Year</label>
                                                    <input type="text" name="stu_passYear[]" id="edu_passYear1" class="form-control" >
                                                </td>
                                                <td>
                                                    <label>GPA/Score</label>
                                                    <input type="text" name="stu_gpa_score[]" id="edu_gpa_score1" class="form-control" >
                                                </td>
                                                <td><label>&nbsp;</label>
                                                    <input type="button" class="btn btn-primary" value="Add More" id="edu_add_more">
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="group">
                                <h4>Course Details</h4>
                                <p>
                                <table>
                                    <tr>

                                        <td>
                                            <label>Select Batch</label>
                                            <select name="batch_join[]" class="form-control" id="stu_batch_id" multiple="true">
                                                <?php
                                                $i = 0;
                                                if (isset($stuData[0])) {
                                                    $batch = explode(",", $stuData[0]->batch_join);
                                                    $x = sizeof($batch);
                                                }
                                                foreach ($batchList as $k => $v) {
                                                    if (isset($stuData[0]) && $i >= $x)
                                                        $i = 0;
                                                    ?>
                                                    <option value="<?php echo $v->id; ?>"<?php
                                                    if (isset($_REQUEST['batch_join']) && in_array($v->id, $_REQUEST['batch_join']))
                                                        echo "selected";else if (isset($stuData[0]) && in_array($v->id, $batch)) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $v->name; ?></option>
                                                        <?php }
                                                        ?>
                                            </select>
                                        </td>
                                        <td>
                                            <label>Study Center</label>
                                            <select name="stu_study_center_id" class="form-control">
                                                <option value="">Study Center</option>
                                                <?php for ($i = 0; $i < count($studyCenterList); $i++) { ?>
                                                    <option value="<?php echo $studyCenterList[$i]->id ?>" <?php if (isset($_REQUEST['stu_study_center_id'])) echo "selected";else if (isset($stuData[0]) && $stuData[0]->study_center_id == $studyCenterList[$i]->id) echo "selected"; ?>><?php echo $studyCenterList[$i]->center_name; ?>
                                                    <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <label>Select Image</label>
                                            <input type="file" name="stu_image" id="stu_image">
                                        </td>
                                        <?php if (isset($stuData[0]->image)) { ?>
                                            <td><img src="<?php echo SITE_URL . "images/stu_img/" . $stuData[0]->image; ?>" alt="student image" width="90px" height="80px"></td>
                                            
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        
                                        <td>
                                            <label>Want to opt Exam Package?</label>
                                            <select name="stu_pkg_opt" id="stu_pkg_opt" class="form-control">
                                                <option value="">--select--</option>
                                                <option value="1" <?php if (isset($_REQUEST['stu_pkg_opt']) && $_REQUEST['stu_pkg_opt'] == '1') echo "selected";else if (isset($stuData[0]) && $stuData[0]->pkg_opt == 1) echo "selected"; ?>>Yes</option>
                                                <option value="0"<?php if (isset($_REQUEST['stu_pkg_opt']) && $_REQUEST['stu_pkg_opt'] == '0') echo "selected";else if (isset($stuData[0]) && $stuData[0]->pkg_opt == 0) echo "selected"; ?>>No</option>
                                            </select>
                                        </td>
                                        <td id="exm_pkg_select" style="display:none;" colspan='2'>
                                            <label>Select Exam Package</label>
                                            <select name="sel_pkg_id[]" class="form-control" multiple="true" size="6">

                                                <?php {
                                                    
                                                }$j = 0;
                                                
                                                for ($i = 0; $i < count($exmPackageList); $i++) {
                                                    if ($j >= count(@$stuPkgSelected))
                                                        $j = 0;
                                                    ?>
                                                    <option value="<?php echo $exmPackageList[$i]->id ?>" <?php if (isset($_REQUEST['sel_pkg_id']) && $_REQUEST['sel_pkg_id'] == $exmPackageList[$i]) echo "selected";else if (isset($stuPkgSelected[$j]) && count(@$stuPkgSelected) > 0 && $stuPkgSelected[$j]->pkg_id == $exmPackageList[$i]->id) {
                                                    echo "selected";
                                                    $j++;
                                                } else if ($i == 0) echo "selected"; ?>><?php echo $exmPackageList[$i]->name; ?>
<?php } ?>
                                            </select>
                                        </td>
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

            $(document).ready(function () {

                if ($('#stu_pkg_opt').val() == '1') {
                    
                    $('#exm_pkg_select').css('display', "block");
                } else {
                    $('#exm_pkg_select').css('display', "none");
                }
                $('#stu_pkg_opt').change(function () {

                    if ($('#stu_pkg_opt').val() == '1') {
                    $('#exm_pkg_select').show(500);
                    //            $('#exm_pkg_select').css('display', "block");
                    } else {
                        $('#exm_pkg_select').hide(500);
//                        $('#exm_pkg_select').css('display', "none");
                    }
                });
            });
            $(document).ready(function () {
                var outer = $('#education_inner_div');
                var i = $('#education_tbl').size() + 1;
                $("#edu_add_more").click(function () {

                    $('<tr id="edu' + i + '"> <td> <label>Level</label> <select class=" form-control" name="stu_level[]"> <option value="">--Select Level--</option><?php
foreach ($quali_list as $k => $v) {
    if ($v->is_deleted == '1')
        continue;
    ?> <option value="<?php echo $v->id ?>"><?php echo $v->name; ?> <?php } ?>   </select> </td> <td> <label>Discipline</label> <select class="form-control" name="stu_discipline[]"> <option value="">--Select Level--</option> <option value="Full time">Full time</option> <option value="Part time">Part time</option> <option value="Distance learning">Distance learning</option> </select> </td>  <td> <label>Institute/college</label> <input type="text" name="stu_college[]" id="edu_college1" class="form-control" > </td> <td> <label>Specialization</label> <input type="text" name="stu_specialization[]" id="edu_specialization1" class="form-control" > </td> <td> <label>Pass Year</label> <input type="text" name="stu_passYear[]" id="edu_passYear1" class="form-control" > </td> <td> <label>GPA/Score</label> <input type="text" name="stu_gpa_score[]" id="edu_gpa_score1" class="form-control" > </td> <td><label>&nbsp;</label><br> <input type="button" class="btn btn-danger" value="Remove" id="edu_remove" onclick="eduRemove(' + i + ');"> </td> </tr>').appendTo("#education_tbl");
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

//                var outer = $('#education_inner_div');
//                var i = $('#education_tbl').size() + 1;

                if (i >= 2) {
                    $("#edu" + i).remove();
                    i--;
                }
            }
            function stuloyeeType(val) {

                if (val == 'other') {
                    $("#stu_oth").css("display", "block");
                    $("#stu_stuloyee_type").removeAttr("disabled", "disabled");
                } else if (val != 'other') {
                    $("#stu_oth").css("display", "none");
                    $("#stu_stuloyee_type").attr("disabled", "true");
                }
            }
        </script>
        <script>
            $(function () {
                var validate = $("#student_frm").validate({
                    errorClass: "error",
                    validClass: "valid",
                    rules: {
                        stu_f_name: "required",
                        stu_l_name: "required",
                        stu_father_name: "required",
                        stu_dob: "required",
                        stu_gender: "required",
                        stu_marital: "required",
                    },
                    // Specify the validation error messages
                    messages: {
                        stu_f_name: "Please enter first name",
                        stu_l_name: "Please Enter last name",
                        stu_father_name: "Please Enter father's name",
                        stu_dob: " Please Enter Date of birth",
                        stu_gender: "Please Select Gender",
                        stu_marital: "Please Select Marital Status",
                    },
                });
            });
        </script>
        <script src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
        <style type="text/css">
            .error{color:red;}
        </style>