<?php
//	if(!isset($_SESSION['USERDATA'])){
//		header("location:index.php?msg=Unauthorised Action");	
//	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?php echo SITE_TITLE; ?></title>

        <!-- Core CSS - Include with every page -->
        <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo FONT_URL; ?>font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Page-Level Plugin CSS - Dashboard -->
        <link href="<?php echo CSS_URL; ?>plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
        <link href="<?php echo CSS_URL; ?>plugins/timeline/timeline.css" rel="stylesheet">

        <!-- SB Admin CSS - Include with every page -->
        <link href="<?php echo CSS_URL; ?>sb-admin.css" rel="stylesheet">
        
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js">
</script>
        
    <center>
        <noscript><div style="width:100%; height:100%; position:relative;"><div style="width:1400px; height: 40px; z-index: 1000; align:center; position:fixed; background-color: grey; color:white;">Javascript must enable to run program efficiently!</div></div></noscript></center>
        <!-- common function js to call ajax functions-->
        <script src="<?php echo JS_URL;?>commonjs.js"></script>
        <!-- Core Scripts - Include with every page -->
    <script src="<?php echo JS_URL;?>jquery-1.10.2.js"></script>
    <script src="<?php echo JS_URL;?>bootstrap.min.js"></script>
    <script src="<?php echo JS_URL;?>plugins/metisMenu/jquery.metisMenu.js"></script>
	
 <!-- Page-Level Plugin Scripts - Tables -->
    <script src="<?php echo JS_URL;?>plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo JS_URL;?>plugins/dataTables/dataTables.bootstrap.js"></script>
	
    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="<?php echo JS_URL;?>plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo JS_URL;?>plugins/morris/morris.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?php echo JS_URL;?>sb-admin.js"></script>
<script src="<?php echo JS_URL;?>plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
    <script src="<?php echo JS_URL;?>demo/dashboard-demo.js"></script>
<script src="<?php echo JS_URL;?>jquery-1.10.2.js"></script>
                <!--<script src="<?php echo JS_URL;?>bootstrap.min.js"></script>-->
                <script src="<?php echo JS_URL;?>plugins/metisMenu/jquery.metisMenu.js"></script>

                <!-- Page-Level Plugin Scripts - Tables -->
                <script src="<?php echo JS_URL;?>plugins/dataTables/jquery.dataTables.js"></script>
                <script src="<?php echo JS_URL;?>plugins/dataTables/dataTables.bootstrap.js"></script>
<!--CK EDITOR-->
<script type="text/javascript" src="<?php echo JS_URL;?>ckeditor/ckeditor.js"></script>                
                
                 <!--SB Admin Scripts - Include with every page--> 
                <script src="<?php echo JS_URL;?>sb-admin.js"></script>
      
      
<?php // Make sure you are using a correct path here.

include BASE_PATH.'js/ckeditor/ckeditor_php5.php';

$ckeditor = new CKEditor();
$ckeditor->basePath = JS_URL.'/ckeditor/';
$ckeditor->config['filebrowserBrowseUrl'] = JS_URL.'/ckfinder/ckfinder.html';
$ckeditor->config['filebrowserImageBrowseUrl'] = JS_URL.'/ckfinder/ckfinder.html?type=Images';
$ckeditor->config['filebrowserFlashBrowseUrl'] = JS_URL.'/ckfinder/ckfinder.html?type=Flash';
$ckeditor->config['filebrowserUploadUrl'] = JS_URL.'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
$ckeditor->config['filebrowserImageUploadUrl'] = JS_URL.'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
$ckeditor->config['filebrowserFlashUploadUrl'] = JS_URL.'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';?>

    </head>

    <body>

        <div id="wrapper">

            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo SITE_URL;?>">IMS <span style="color:#F00"><?php //echo strtoupper($_SESSION['USERDATA']['administrator']); ?></span></a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-left">
            <?php if($commonObj->canAccess("master_mstr_location_list") || $commonObj->canAccess("master_mstr_center_list") || $commonObj->canAccess("course_batch_list")){?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Master  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <?php if($commonObj->canAccess("master_mstr_location_list")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=master_mstr_location_list";?>">
                                    <div>
                                        Location
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>
                            <?php }?>
                            
                            
                            <?php if($commonObj->canAccess("master_mstr_center_list")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=master_mstr_center_list"?>">
                                        <div>
                                            Center
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>                                
                            </li>
                            <?php }?>
                            
                            <?php if($commonObj->canAccess("course_batch_list")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=course_batch_list"?>">
                                        <div>
                                            Batch
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>                                
                            </li>
                            <?php }?>


                        </ul>
                        
                        
                        <!-- /.dropdown-alerts -->
                    </li>
            <?php }?>
                    
                    
                                  
<?php if($commonObj->canAccess("users_user_group_list")){?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            User  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            
                            <?php if($commonObj->canAccess("users_user_group_list")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=users_user_group_list";?>">
                                    <div>
                                        User Group
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>
                            <?php }?>



                        </ul>
<?php }?>
                    
                    
            <?php if($commonObj->canAccess("master_mstr_qualification_list") || $commonObj->canAccess("employee_employeeList")){?>        
            <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Employee  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            
                            
                            <?php if($commonObj->canAccess("master_mstr_qualification_list")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=master_mstr_qualification_list"?>">
                                        <div>
                                            Qualification
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>                                
                            </li>
                            <?php }?>   
                            <?php if($commonObj->canAccess("employee_employeeList")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=employee_employeeList"?>">
                                        <div>
                                            Employee List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>                                
                            </li>
                            <?php }?>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
            <?php }?>
                    <!-- /.dropdown -->
                    <?php if($commonObj->canAccess("course_courseList") || $commonObj->canAccess("course_subCourseList")){?>
<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Student<i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <?php // if($commonObj->canAccess("student_student_list")){?>
                                <?php if($commonObj->canAccess("course_courseList")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=course_courseList"?>">
                                        <div>
                                            course List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>                                
                            </li>
                            <?php }?>
                            
                            <?php if($commonObj->canAccess("course_subCourseList")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=course_subCourseList"?>">
                                        <div>
                                            Sub-course List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>                                
                            </li>
                            <?php }?>
                            
                        <?php if($commonObj->canAccess("student_student_list")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=student_student_list";?>">
                                    <div>
                                        Student List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>
                            <?php  }?>
                            

                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                    <?php }?>
                    <!-- /.dropdown -->
                    
                              
                        <?php if($commonObj->canAccess("exam_subjectList") || $commonObj->canAccess("exam_packageList") || $commonObj->canAccess("exam_paperList") || $commonObj->canAccess("exam_questionList")){?>
                        <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Exam  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            
                            <?php if($commonObj->canAccess("exam_subjectList")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=exam_subjectList";?>">
                                    <div>
                                        Subjects List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>
                            <?php }?>
                            <?php if($commonObj->canAccess("exam_packageList")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=exam_packageList";?>">
                                    <div>
                                        Package List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>
                            <?php }?>
                            <?php if($commonObj->canAccess("exam_paperList")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=exam_paperList";?>">
                                    <div>
                                        Paper's List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>
                            <?php }?>
                            <?php if($commonObj->canAccess("exam_questionList")){?>
                            <li>
                                <a href="<?php echo SITE_URL."?page=exam_questionList";?>">
                                    <div>
                                        Question's List
                                        <span class="pull-right text-muted small"></span>
                                    </div>
                                </a>
                            </li>
                            <?php }?>


                        </ul>
                        <?php }?>
                        <!-- /.dropdown-alerts -->
                    
                        <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                            <ul class="dropdown-menu dropdown-user" style="right:-115px;">
                            <li>
                                <a href="<?php echo SITE_URL."?page=master_mstr_changePassword"?>"><i class="fa fa-user fa-fw"></i>Change Password</a>
                            </li>
<!--                            <li><a href="edit_detail.php"><i class="fa fa-gear fa-fw"></i>Edit Details</a>
                            </li>
                            <li class="divider"></li>-->
                            <li><a href="<?php SITE_URL."/modules/";?>logout.php?msg=logout successfully!"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
