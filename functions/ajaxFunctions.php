<?php

if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
// For Ajax Requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ajx']) && ($_POST['ajx'] == 'Yes') && isset($_POST['func_name']) && !empty($_POST['func_name']) && isset($_POST['class']) && !empty($_POST['class']) && !empty($_POST['func_page'])) {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $class = $_POST['class'];
        $page = $_POST['func_page'];
        $commonObj->autoload($page);
        if (class_exists($class)) {
            $obj = new $class();
            $func_name = $_POST['func_name'];
            if (method_exists($obj, $func_name)) {
                switch ($func_name) {
                    case "getCenterList":                        
                        $return_array = $obj->$func_name(array('center_loc_id'=>$_POST['id']));                        
                        echo is_array(json_decode($return_array))? $return_array : '0';
                        break;
                    case "getSubCourseList":
                        $return_array = $obj->$func_name(array('course_id'=>$_POST['id']));
                        echo is_array(json_decode($return_array))? $return_array : '0';
                        break;
                    
                    case "updateQuestionEndTime":
                        $return_array = $obj->$func_name($_POST['id'],$_POST['ppr_id']);
                        if($return_array=='1')echo"1";else echo "0";
                        break;
                    case "getNextQuestion":
                        $return_array = $obj->$func_name($_POST['id'],$_POST['nxtNprev']);
                        echo is_array(json_decode($return_array))? $return_array : '0';
                        break;
                    case "updateAnswer":
                        $return_array = $obj->$func_name($_POST['id'],$_POST['ans'],$_POST['q_status']);
                        echo $return_array;
                        break;
                    case "markForReviewStatusUpdate":
                        $return_array = $obj->$func_name($_POST['attempt_id'],$_POST['status']);
                        if($return_array === "1"){
                            echo "1";
                        }else{
                            echo "0";
                        }
                        break;
                }
            } else
                echo "Class: $class method $func_name not exists.";
        }
        else {
            echo 'class not exists.';
        }
    } else
        echo 'Proper Values not Sent.';
}


