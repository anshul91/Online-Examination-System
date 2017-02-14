function sendAjax(dataajx) {
    if (dataajx != '') {
        $.ajax({
            type: "POST",
            url: "index.php",
            data: dataajx,
            dataType: 'json',
            success: function (data) {
                viewOutput(data);
            }
        });
    }
    else
        return false;
}
function updateEndTime(stu_id, ppr_id, classn) {
    var sendstring = {
        page: 'ajaxFunctions',
        ajx: 'Yes',
        func_name: 'updateQuestionEndTime',
        class: classn,
        func_page: 'examFxn',
        id: stu_id,
        ppr_id: ppr_id
    };
    $.ajax({
        type: "POST",
        url: "index.php",
        data: sendstring,
        dataType: 'json',
        success: function (data) {

        },
        error: function () {
        }
    });

}
function changeExmBtnColor(attmpt_id, q_status) {
    if (q_status === 0) {
        $("#directJmp_" + attmpt_id).css("color", "");
    } else if (q_status === 1) {
        $("#directJmp_" + attmpt_id).css("background-color", "green");
        $("#directJmp_" + attmpt_id).css("color", "white");

    } else if (q_status === 2) {
        $("#directJmp_" + attmpt_id).css("background-color", "red");
        $("#directJmp_" + attmpt_id).css("color", "white");
    } else if (q_status === 3) {
        $("#directJmp_" + attmpt_id).css("background-color", "blue");
        $("#directJmp_" + attmpt_id).css("color", "white");
    } else if (q_status === 4) {
        $("#directJmp_" + attmpt_id).css("background-color", "#39b3d7");
        $("#directJmp_" + attmpt_id).css("color", "white");
    }

}
function updateAnswer(attmpt_ques, ans, q_status) {

    if (q_status === '0') {
        $("#userAns").prop("checked", false);
        $("#userAns2").prop("checked", false);
        $("#userAns3").prop("checked", false);
        $("#userAns4").prop("checked", false);

    }

    var sendstring = {
        page: 'ajaxFunctions',
        ajx: 'Yes',
        func_name: 'updateAnswer',
        class: "examFxn",
        func_page: "examFxn",
        id: attmpt_ques,
        ans: ans,
        q_status: q_status
    };
    $.ajax({
        type: "POST",
        url: "index.php",
        data: sendstring,
        dataType: 'json',
        asyc:false,
        beforeSend: function () {
            // setting a timeout
            $("#img").show();

        },
        complete: function () {
            $("#img").hide();
        },
        success: function (data) {

            if (data !== '') {

                changeExmBtnColor(attmpt_ques, data);
                $(data).each(function (i, val) {


                });
            } else {
                alert("No answer was added please try again!");
            }
            return true;
        },
        error: function () {
            alert("Error in DB!");
        }

    });
}

//fetching question by id one by one

function showAjaxQues(nxt_attmpt_id, classn, pagen, nxtNprev) {
    if (nxt_attmpt_id !== '' && classn !== '') {
        var returnstring = '';
//        console.log(nxt_attmpt_id);
        var sendstring = {
            page: 'ajaxFunctions',
            ajx: 'Yes',
            func_name: 'getNextQuestion',
            class: classn,
            func_page: pagen,
            id: nxt_attmpt_id,
            nxtNprev: nxtNprev

        };
        $.ajax({
            type: "POST",
            url: "index.php",
            data: sendstring,
            dataType: 'json',
            asyc:false,
            beforeSend: function () {
                // setting a timeout
                $("#img").show();

            },
            complete: function () {
                $("#img").hide();
            },
            success: function (data) {
//                console.log(nxt_attmpt_id);
                if (data === 0) {
                    $("#markFrReview").prop("disabled", true);
                    $("#nxtQues").prop("disabled", true);
                } else {
                    $("#nxtQues").prop("disabled", false);
                    $("#markFrReview").prop("disabled", false);
                }
                if (typeof (data) === 'object') {
//                    console.log(data);
                    $(data).each(function (i, val) {
                        //change current subject
                        $("#subject").html("<b>Subject: "+val['sub_name']+"</b>");
                        //showing options and questions
                        $.trim($("#eng_ques").html(val['eng_ques']));
                        $.trim($("#hin_ques").html(decodeURIComponent(escape(val['hin_ques']))));
                        //showing options data for above questions its label
                        $("#option1_lbl").html("(A) " + val['option1'] + "  " + $.trim(decodeURIComponent(escape(val['option1_hin']))));
                        $("#option2_lbl").html("(B) " + val['option2'] + "  " + $.trim(decodeURIComponent(escape(val['option2_hin']))));
                        $("#option3_lbl").html("(C) " + val['option3'] + "  " + $.trim(decodeURIComponent(escape(val['option3_hin']))));
                        $("#option4_lbl").html("(D) " + val['option4'] + "  " + $.trim(decodeURIComponent(escape(val['option4_hin']))));
                        //next question id setting in hidden param
                        $("#nxtQuesId").val(val['nxt_attempt_id']);

                        //below given code is updating options data 
                        var chk1 = chk2 = chk3 = chk4 = '';
                        if (val['st_ans'] === '1') {
                            chk1 = 'checked';
                        } else if (val['st_ans'] === '2') {
                            chk2 = 'checked';
                        } else if (val['st_ans'] === '3') {
                            chk3 = 'checked';
                        } else if (val['st_ans'] === '4') {
                            chk4 = 'checked';
                        }
                        console.log(val['nxt_attempt_id']);
                        $("#option1").html("<label>(A) </label> <input type='radio' name='userAns' value='" + 1 + "' id='userAns1'" + chk1 + " onclick='updateAnswer(" + val['nxt_attempt_id'] + ",1,1);'>");
                        $("#option2").html("<label>(B)</label> <input type='radio' name='userAns' value='" + 2 + "' id='userAns2'" + chk2 + " onclick='updateAnswer(" + val['nxt_attempt_id'] + ",2,1);'>");
                        $("#option3").html("<label>(C)</label> <input type='radio' name='userAns' value='" + 3 + "' id='userAns3'" + chk3 + " onclick='updateAnswer(" + val['nxt_attempt_id'] + ",3,1);'>");
                        $("#option4").html("<label>(D)</label> <input type='radio' name='userAns' value='" + 4 + "' id='userAns4'" + chk4 + " onclick='updateAnswer(" + val['nxt_attempt_id'] + ",4,1);'>");
                        chk = '';

//changing status of ans if user jst visited the ques.

                        if (typeof ($("input[name='userAns']:checked").val()) === 'undefined' && nxtNprev === 'next') {
                            updateAnswer(val['nxt_attempt_id'], '0', '4');
                        } else if (nxtNprev === 'markFrReviewNxt') {
//                            markForReview(nxt_attmpt_id, "2");//update current id color or answer also
                        } else if (typeof ($("input[name='userAns']:checked").val()) === 'undefined') {//used for previous ques
                            updateAnswer(val['exm_tkn_id'], '0', '4');
                        }
                        //options of question updating code ends here

                        //managing serial no to be shown on the top of hte page
                        var sno = parseInt($("#sno_ques").val());
                        if (nxtNprev === 'next' || nxtNprev === 'markFrReviewNxt') {
                            $("#sno_ques").val(sno + 1);
                            $("#qno").html(" " + (sno + 1));
                            changeExmBtnColor(parseInt(val['nxt_attempt_id']), val['ques_status']);
                        } else if (nxtNprev === 'prev' && sno > 0) {
                            $("#sno_ques").val(sno - 1);
                            $("#qno").html(" " + sno - 1 + " ");
                            changeExmBtnColor(parseInt(val['nxt_attempt_id']), val['ques_status']);
                        } else {
                            $("#sno_ques").val(sno);
                            $("#qno").html(" " + sno + " ");
                            changeExmBtnColor(val['nxt_attempt_id'], val['ques_status']);
                        }
//previous button disabled if value is less than 1 otherwise its enable
                        if ($("#sno_ques").val() > 1)
                        {
                            $("#prev_btn").prop("disabled", false);
                        } else {
                            $("#prev_btn").prop("disabled", true);
                        }



                        /*
                         * changing color of buttons of question to be display
                         * @1>green=>attempted finally
                         * 2>red=>used for review
                         * 3>blue=>mark for last
                         * 4>sky blue=>viewed but not attempted
                         * 
                         //                         */
//                        
//                        if (parseInt(val['ques_status']) === 0) {
//                            
//                            $("#directJmp_" + val['nxt_attempt_id']).css("color", "");
//                        } else if (parseInt(val['ques_status']) === 1) {
//                            $("#directJmp_" + val['nxt_attempt_id']).css("background-color", "green");
//
//                        } else if (parseInt(val['ques_status']) === 2) {
//                            $("#directJmp_" + val['nxt_attempt_id']).attr("class", "btn btn-danger btn-xs");
//
//                        } else if (parseInt(val['ques_status']) === 3) {
//                            $("#directJmp_" + val['nxt_attempt_id']).attr(" btn-primary btn-xs");
//
//                        } else if (parseInt(val['ques_status']) === 4) {
//                            $("#directJmp_" + val['nxt_attempt_id']).css("background-color", "#39b3d7");
//
//                        }
                    });
                } else {


//                    $("#" + divId).append("No Center Yet!");
                }
            },
            error: function () {
                alert("Error in DB!");
            }
        });
    }
}
function markForReview(attempt_id, status) {
    if (attempt_id != '' && status != '') {
        var returnstring = '';

        var sendstring = {
            page: 'ajaxFunctions',
            ajx: 'Yes',
            func_name: 'markForReviewStatusUpdate',
            class: "examFxn",
            func_page: "examFxn",
            attempt_id: attempt_id,
            status: status
        };
        $.ajax({
            type: "POST",
            url: "index.php",
            data: sendstring,
            dataType: 'json',
            success: function (data) {
                
                if (data === 1) {
                    changeExmBtnColor(attempt_id, parseInt(status));
                } else {
                    alert("answer not updated!");
                }
                if (typeof (data) === 'object') {

                }
            }
        });
    }
}

var x = 0;
function getCenterList(id, classn, pagen, divId, chk) {
    if (id != '' && classn != '') {
        var returnstring = '';

        var sendstring = {
            page: 'ajaxFunctions',
            ajx: 'Yes',
            func_name: 'getCenterList',
            class: classn,
            func_page: pagen,
            id: id
        };
        $.ajax({
            type: "POST",
            url: "index.php",
            data: sendstring,
            dataType: 'json',
            success: function (data) {
                if (typeof (data) === 'object') {

                    returnstring += '<tr id="loc_id' + id + '">';
                    $(data).each(function (i, val) {
                        returnstring += '<td id="loc' + val["id"] + '" ><label>' + val['center_name'] + '(' + val['center_code'] + ')</label> <input type="checkbox" name="per_access_center[]" value=' + val['id'] + '></td>';

                    });
                    returnstring += "</tr></table>";
                    $("#" + divId).append(returnstring);
                } else {
                    $("#" + divId).append("No Center Yet!");
                }
            },
            error: function () {
                alert("Error in DB!");
            }
        });
    }
}
function addCourse() {

}
//id=course id classn=sub course class name pagen= name of page where sub course func defined div id where to show data sub id if pre selected
function getSubCourseList(id, classn, pagen, divId, sub_id) {
    if (id != '' && classn != '') {
        var returnstring = '';

        var sendstring = {
            page: 'ajaxFunctions',
            ajx: 'Yes',
            func_name: 'getSubCourseList',
            class: classn,
            func_page: pagen,
            id: id
        };
        returnstring += '<label>Select Sub Course</label><select name="batch_sub_course_id" class="form-control" id="batch_sub_course"><option value="">--Sub-Course--</option>';
        $.ajax({
            type: "POST",
            url: "index.php",
            data: sendstring,
            dataType: 'json',
            success: function (data) {
                document.getElementById("batch_sub_course").style.display = "block";
                if (typeof (data) === 'object') {
                    $(data).each(function (i, val) {
                        if (val['id'] == sub_id) {
                            returnstring += '<option value=' + val['id'] + ' selected="true">' + val['name'] + '</option>';
                        } else
                            returnstring += '<option value=' + val['id'] + '>' + val['name'] + '</option>';
                    });
                    returnstring += '</select>'
                    $("#" + divId).html(returnstring);
                } else {
                    //$("#" + divId).html(returnstring);                    
                    $("#" + divId).html(returnstring);
                }
            },
            error: function ()
            {
                alert("Error in DB!");
            },
        });
    }
}
function getBatchListStu(id, classn, pagen, divId, sub_id) {
    alert("test");
}

function getSubCourseListStu(id, classn, pagen, divId, sub_id) {
    if (id != '' && classn != '') {
        var returnstring = '';

        var sendstring = {
            page: 'ajaxFunctions',
            ajx: 'Yes',
            func_name: 'getSubCourseList',
            class: classn,
            func_page: pagen,
            id: id
        };
        returnstring += '<label>Select Sub Course</label><select name="stu_sub_course_id" class="form-control" id="stu_sub_course" onchange="getBatchListStu(5);" multiple="true"><option value="">--Sub-Course--</option>';
        $.ajax({
            type: "POST",
            url: "index.php",
            data: sendstring,
            dataType: 'json',
            success: function (data) {

                if (typeof (data) === 'object') {

                    $(data).each(function (i, val) {
                        if (val['id'] == sub_id) {
                            returnstring += '<option value=' + val['id'] + ' selected="true">' + val['name'] + '</option>';
                        } else
                            returnstring += '<option value=' + val['id'] + '>' + val['name'] + '</option>';

                    });
                    returnstring += '</select>'
                    $("#" + divId).html(returnstring);
                } else {
                    //$("#" + divId).html(returnstring);

                    $("#" + divId).html(returnstring);
                }
            },
            error: function () {
                alert("Error in DB!");
            },
        });
    }
}
       