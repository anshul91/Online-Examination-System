<?php 
    if(!defined(BASE_PATH)){
        header(SITE_URL);   
    }
    
?>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <?php
            echo $commonObj->getSuccessMsg();
            echo $commonObj->getErrorMsg();
            $commonObj->unsetMessage();
            ?>
                
                    <h1 class="page-header">Dashboard</h1>
                </div>
                
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
  
     <!--Core Scripts - Include with every page--> 
    <!--<script src="js/jquery-1.10.2.js"></script>-->
    <!--<script src="js/bootstrap.min.js"></script>-->
<!--    <script src="<?php echo JS_URL;?>/plugins/metisMenu/jquery.metisMenu.js"></script>

     Page-Level Plugin Scripts - Dashboard 
    <script src="<?php echo JS_URL;?>/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo JS_URL;?>/plugins/morris/morris.js"></script>

     SB Admin Scripts - Include with every page 
    <script src="<?php echo JS_URL;?>/sb-admin.js"></script>

     Page-Level Demo Scripts - Dashboard - Use for reference 
    <script src="<?php echo JS_URL;?>/demo/dashboard-demo.js"></script>-->

