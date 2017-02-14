<div class="navbar-default navbar-static-side" role="navigation" style='<?php if($_REQUEST['page'] ==='exam_startExam') echo "display:none;";?>'>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu" style="overflow-y:scroll;">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <?php
                    include(BASE_PATH . "functions/employeeFxn.php");
                    include(BASE_PATH . "functions/studentFxn.php");
                    $commonObj->autoload("employeeFxn");
                    $commonObj->autoload("studentFxn");
                    $empFxn = new employeeFxn();
                    $stuFxn = new studentFxn();
                    if (isset($_SESSION['id'])) {
                        $emp_data = json_decode($empFxn->getEmployeeList(array("id" => $_SESSION['id'])));
                        $emp_id = $_SESSION['id'];
                        if ($emp_data[0]->image != '') {
                            $imageUrl = IMAGE_URL . "emp_img/" . $emp_data[0]->image;
                        } else {
                            $imageUrl = IMAGE_URL . "no_profile.png";
                        }
                    } else if (isset($_SESSION['student_id'])) {
                        $st_data = json_decode($stuFxn->getStudentList(array("student_id" => $_SESSION['student_id'])));
                        $student_id = $_SESSION['student_id'];
                        $st_id = $_SESSION['st_id'];
                        if ($st_data[0]->image != '') {
                            $imageUrl = IMAGE_URL . "stu_img/" . $st_data[0]->image;
                        } else {
                            $imageUrl = IMAGE_URL . "no_profile.png";
                        }
                    }
                    ?>

                    <img src="<?php echo $imageUrl; ?>" width="220px" height="280px" style="border: #000 groove">  
<!--                        <img src="<?php echo $imageUrl; ?>" width="220px" height="300px" style="border: #000 groove">-->                    
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <?php
                if (isset($_SESSION['id'])) {
                    $page = "employee_myDetailDesc";
                    $id = $empFxn->encode($_SESSION['id']);
                } else {
                    $page = "student_myDetailDesc";
                    $id = $empFxn->encode($st_id);
                }
                ?>
                <a href="<?php echo SITE_URL . "?page=" . $page . "&id=" . $id; ?>"><i class="fa fa-dashboard fa-won"></i> Personal Details</a>
                <?php if (isset($_SESSION['st_id']) && !empty($_SESSION['st_id'])) { ?>

                    <a href="<?php echo SITE_URL . "?page=student_myExamPackage&st_id=" . $empFxn->encode($_SESSION['st_id']); ?>"><i class="fa fa-dashboard fa-bell-o"></i> My Exams Package's</a>

                   <a href="<?php echo SITE_URL . "?page=results_exam_result_list";?>"><i class="fa fa-dashboard fa-anchor"></i> My Exams Result's</a>

                <?php } ?>

            </li>






        </ul>
        </li>
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>
