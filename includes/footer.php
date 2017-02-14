
          

           

        
                    <!-- /.panel -->
                   
                        <!-- /.panel-footer -->
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
<?php 

function my_error_handler($e_type,$e_message,$e_file,$e_line){
    $commonObj->insertError();
}
set_error_handler('my_error_handler');
?>