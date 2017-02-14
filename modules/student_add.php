<?php
//$stdntFxn = new studentFxn();
if(isset($_REQUEST['submit']) && !empty($_REQUEST['submit']))
{
    $stdntFxn->addStudentData();
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form name="frm" method="post">
    <input type="text" name='first_name'/>
    <input type="submit" value='save' name="submit">
</form>
