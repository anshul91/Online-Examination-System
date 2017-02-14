<?php include("top.php");?>
<?php include("leftbar1.php");?>

<?php 

	$msg="";
	$message="";
	$sc_id = "";
	$name="";
	$father_name="";
	$dob="";
    $qualification="";
	$address="";
	$city="";
	$state="";
	$doc_details="";
	$joining_date="";
	$job_type="";
	$email_id="";
	$mobile="";
	$gender="";
    $password="";
	
	$valid_name="";
	$valid_father_name="";
	$valid_dob="";
	$valid_address="";
	$valid_city="";
	$valid_state="";
	$valid_doc_details="";
	$valid_joining_date="";
	$valid_job_type="";
	$valid_email_id="";
	$valid_mobile="";
	$valid_gender="";
	$valid_image="";
	
	
	$insstatus=1;
	
	if(!empty($_REQUEST['msg']))
	{
		$message=$_REQUEST('msg');
	}
	
?>
<?php
if($_POST)
{
	$sc_id = $_SESSION['USERDATA']['id'];//taking study center's id and savind in database
	$name = mysql_real_escape_string($_REQUEST['name']);
	$father_name = mysql_real_escape_string($_REQUEST['father_name']);
	
	
	$dob = mysql_real_escape_string($_REQUEST['dob']);
	//echo "<center>".$dob;
	
	$address = mysql_real_escape_string($_REQUEST['address']);
	$city = mysql_real_escape_string($_REQUEST['city']);
	$state = mysql_real_escape_string($_REQUEST['state']);
    $qualification = mysql_real_escape_string($_REQUEST['qualification']);
	$doc_details = mysql_real_escape_string($_REQUEST['doc_details']);

	$joining_date= mysql_real_escape_string($_REQUEST['joining_date']);
	
	$job_type = mysql_real_escape_string($_REQUEST['job_type']);
	$email_id = mysql_real_escape_string($_REQUEST['email_id']);
	$mobile = mysql_real_escape_string($_REQUEST['mobile']);
	$gender = mysql_real_escape_string($_REQUEST['gender']);
	
	
		
	$image=$_FILES['image']['name'];
	
//--------------------checking for blanks in field--------------------
	if(empty($name))
	{
		$valid_name="<font color='red'>Enter Valid Name</font>";
		$insstatus=0;
	}
		if(empty($father_name))
	{
		$valid_father_name="<font color='red'>Enter Valid Father Name</font>";
		$insstatus=0;
	}
	if(empty($dob))
	{
		$valid_date="<font color='red'>Enter valid Date</font>";
		$insstatus=0;
	}
    if(empty($qualification))
    {
        $valid_qualification ="<font color='red'>Enter qualification</font>";
        $insstatus=0;
    }
	if(empty($gender))
	{
		$valid_gender="<font color='red'>Select Gender</font>";
		$insstatus=0;
	}
	if(empty($mobile))
	{
		$valid_mobile="<font color='red'>Enter valid Mobile</font>";
		$insstatus=0;
	}
	
	if(empty($email_id))
	{
		$valid_email_id="<font color='red'>Enter valid Email</font>";
		$insstatus=0;
	}	
	if(empty($address))
	{
		$valid_address="<font color='red'>Enter valid Address</font>";
		$insstatus=0;
	}
	if(empty($joining_date))
	{
		$valid_joining_date="<font color='red'>Enter joining Date</font>";
		$insstatus=0;
	}
	if(empty($doc_details))
	{
		$valid_doc_details="<font color='red'>Enter Document Details</font>";
		$insstatus=0;
	}
	if(empty($job_type))
	{
		$valid_job_type="<font color='red'>Enter Job Type</font>";
		$insstatus=0;
	}
	if(empty($city))
	{
		$valid_city="<font color='red'>Enter City</font>";
		$insstatus=0;
	}
	if(empty($state))
	{
		$valid_state="<font color='red'>Enter State</font>";
		$insstatus=0;
	}
	
	//-----------------
	
	if($insstatus == 1){
		$titleCount = mysql_num_rows(mysql_query("select * from trainer where email_id = '$email_id' or mobile='$mobile'"));
			if($titleCount>0){
				$message = "<font color='red'>Trainer Already Exist</font>";
				$insstatus = 0;
			}
		}		
		$imageNewName = "";
		if(($insstatus == 1)){
				if($_FILES['image']['error']==0){
					if(($_FILES['image']['type']=='image/jpeg')||($_FILES['image']['type']=='image/png')||($_FILES['image']['type']=='image/gif')){
						if($_FILES['image']['size']<=1000000){
								//$imageNewName = time().".jpg";//to get timestamp
								$imageNewName = md5(rand(0,99999).time())."_".$_FILES['image']['name'];
								
								
								
						}else{
							$valid_image = "File size cannot exeed 50 KB.";	
							$insstatus = 0;								
						}						
						
					}else{
							$valid_image = "Invalid File Type";	
							$insstatus = 0;							
						}				
				}else{
						$valid_image = "Uploading Error....";	
						$insstatus = 0;							
				}		
	}

	if($insstatus == 1){
            $name=trim(stripslashes($name));
            $password=str_replace(" ","_",ucfirst($name))."_".rand(0,9999);
            $p_id=$_SESSION['USERDATA']['period_id'];
			mysql_query("insert into trainer set sc_id=$sc_id,
			name = '$name',
            p_id='$p_id',
			father_name='$father_name',
			dob='$dob',
			address='$address',
			doc_detail='$doc_details',
			qualification='$qualification',
            joining_date='$joining_date',
			job_type='$job_type',
			email_id='$email_id',
			mobile='$mobile',
			gender='$gender',
			city='$city',
			state='$state',
            password='$password',
			image='$imageNewName',
			created = now(), 
			modified = now()")
			or
			die("<center>".mysql_error());
			move_uploaded_file($_FILES['image']['tmp_name'], "../trainer_image/".$imageNewName);							
			//include("image_thumbnail.php");
            $email_msg="Congratulations! you are successfully registered with Gita Mittal Career Development Centre as Professional Trainer your login detail is as:\nUsername: $email_id \nPassword: $password";
            $email_msg=wordwrap($email_msg,70);
            $b = mail($email_id,"GMCDC Trainer Registration details",$email_msg);    	
			$message = "<font color='green'>Record Added Successfully!</font>";
            if($b)
			{
				$message=$message."and Mail sent!";
			}
            else
            {
                $message=$message."mail not sent!";
            }
			
		}
}

?>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Trainer Manager</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <center>ADD NEW TRAINER<br />
							<?php echo $message;?></center>
                        </div>
						
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
	<center>
		<table width="80%" border="0" cellspacing="5" cellpadding="5">
			 
			 <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter Name </th>
				<td width="50%"><input type="text" name="name" placeholder ="Enter Name" size="30" class="form-control" />
					<?php echo $valid_name;?>
				</td>
			  </tr>
			  
			 
			 <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter Father's Name </th>
				<td width="50%">
					<input type="text" name="father_name" placeholder ="Enter Father's Name" size="30" class="form-control" />
					<?php echo $valid_father_name;?>
				</td>
			  </tr>
			 
			<tr id="txtHint">
			</tr>
			  <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">DOB </th>
				<td width="50%">
                <input type="date" name="dob" placeholder="dd-mm-yyyy" class="form-control"/>
                <?php echo $valid_date; ?>		
				</td>
			  </tr>
			  
			  <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Gender </th>
				<td width="50%">
					Male<input type="radio" name="gender" value="M"/>
					Female<input type="radio" name="gender" value="F"style="padding:20px 0px;"/>
			<?php echo $valid_gender;  ?>
                </td>
			  </tr>
			  
			  <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Mobile No. </th>
				<td width="50%">
					<input type="text" name="mobile" placeholder ="Enter Mobile No." size="30" class="form-control" />
                   <?php echo $valid_mobile;  ?>
				</td>
			  </tr>
			  
			  <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Email ID </th>
				<td width="50%">
					<input type="email" name="email_id" placeholder ="Enter Email ID" size="30" class="form-control" />
                    <?php echo $valid_email_id;  ?>
				</td>
			  </tr>
			  
			  <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Address
				</th>
				<td width="50%">
					<textarea  rows="3" cols="60" name="address" placeholder =" Enter Complete Address" style="resize:none"></textarea>
					<?php echo $valid_address;?>
				</td>
			  </tr>
               <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">City</th>
				<td width="50%">
               <select name="city" value="" style="width:230">
<option selected="selected">-Select-</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#999999"><i>-Top Metropolitan Cities-</i></font></option>
				<option>Ahmedabad</option> 
				<option>Bengaluru/Bangalore</option>
				<option>Chandigarh</option>
				<option>Chennai</option>
				<option>Delhi</option>
				<option>Gurgaon</option>
				<option>Hyderabad/Secunderabad</option>
				<option>Kolkatta</option>
				<option>Mumbai</option>
				<option>Noida</option>
				<option>Pune</option>
				<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Andhra Pradesh-</i></font></option>
				<option>Anantapur</option>
				<option>Guntakal</option>
				<option>Guntur</option>
				<option>Hyderabad/Secunderabad</option>
				<option>kakinada</option>
				<option>kurnool</option>
				<option>Nellore</option>
				<option>Nizamabad</option>
				<option>Rajahmundry</option>
				<option>Tirupati</option>
				<option>Vijayawada</option>
				<option>Visakhapatnam</option>
				<option>Warangal</option>
				<option>Andra Pradesh-Other</option>
				<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Arunachal Pradesh-</i></font></option>
				<option>Itanagar</option>
				<option>Arunachal Pradesh-Other</option>
				<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Assam-</i></font></option>
				<option>Guwahati</option>
				<option>Silchar</option>
				<option>Assam-Other</option>
				<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Bihar-</i></font></option>
				<option>Bhagalpur</option>
				<option>Patna</option>
				<option>Bihar-Other</option>
				<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Chhattisgarh-</i></font></option>
				<option>Bhillai</option>
				<option>Bilaspur</option>
				<option>Raipur</option>
				<option>Chhattisgarh-Other</option>
				<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Goa-</i></font></option>
				<option>Panjim/Panaji</option>
				<option>Vasco Da Gama</option>
				<option>Goa-Other</option>
				<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Gujarat-</i></font></option>
				<option>Ahmedabad</option>
				<option>Anand</option>
				<option>Ankleshwar</option>
				<option>Bharuch</option>
				<option>Bhavnagar</option>
				<option>Bhuj</option>
				<option>Gandhinagar</option>
				<option>Gir</option>
				<option>Jamnagar</option>
				<option>Kandla</option>
                <option>Porbandar</option>
                <option>Rajkot</option>
                <option>Surat</option>
                <option>Vadodara/Baroda</option>
                <option>Valsad</option>
                <option>Vapi</option>
                <option>Gujarat-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Haryana-</i></font></option>
                <option>Ambala</option>
                <option>Chandigarh</option>
                <option>Faridabad</option>
                <option>Gurgaon</option>
                <option>Hisar</option>
                <option>Karnal</option>
                <option>Kurukshetra</option>
                <option>Panipat</option>
                <option>Rohtak</option>
                <option>Haryana-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Himachal Pradesh-</i></font></option>
                <option>Dalhousie</option>
                <option>Dharmasala</option>
                <option>Kulu/Manali</option>
                <option>Shimla</option>
                <option>Himachal Pradesh-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Jammu and Kashmir-</i></font></option>
                <option>Jammu</option>
                <option>Srinagar</option>
                <option>Jammu and Kashmir-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Jharkhand-</i></font></option>
                <option>Bokaro</option>
                <option>Dhanbad</option>
                <option>Jamshedpur</option>
                <option>Ranchi</option>
                <option>Jharkhand-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Karnataka-</i></font></option>
                <option>Bengaluru/Bangalore</option>
                <option>Belgaum</option>
                <option>Bellary</option>
                <option>Bidar</option>
                <option>Dharwad</option>
                <option>Gulbarga</option>
                <option>Hubli</option>
                <option>Kolar</option>
                <option>Mangalore</option>
                <option>Mysoru/Mysore</option>
                <option>Karnataka-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Kerala-</i></font></option>
                <option>Calicut</option>
                <option>Cochin</option>
                <option>Ernakulam</option>
                <option>Kannur</option>
                <option>Kochi</option>
                <option>Kollam</option>
                <option>Kottayam</option>
                <option>Kozhikode</option>
                <option>Palakkad</option>
                <option>Palghat</option>
                <option>Thrissur</option>
                <option>Trivandrum</option>
                <option>Kerela-Other</option>
  <option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Madhya Pradesh-</i></font></option>
                <option>Bhopal</option>
                <option>Gwalior</option>
                <option>Indore</option>
                <option>Jabalpur</option>
                <option>Ujjain</option>
                <option>Madhya Pradesh-Other</option>
    <option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Maharashtra-</i></font></option>
                <option>Ahmednagar</option>
                <option>Aurangabad</option>
                <option>Jalgaon</option>
                <option>Kolhapur</option>
                <option>Mumbai</option>
                <option>Mumbai Suburbs</option>
                <option>Nagpur</option>
                <option>Nasik</option>
                <option>Navi Mumbai</option>
                <option>Pune</option>
                <option>Solapur</option>
                <option>Maharashtra-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Manipur-</i></font></option>
                <option>Imphal</option>
                <option>Manipur-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Meghalaya-</i></font></option>
                <option>Shillong</option>
                <option>Meghalaya-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Mizoram-</i></font></option>
                <option>Aizawal</option>
                <option>Mizoram-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Nagaland-</i></font></option>
                <option>Dimapur</option>
                <option>Nagaland-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Orissa-</i></font></option>
                <option>Bhubaneshwar</option>
                <option>Cuttak</option>
                <option>Paradeep</option>
                <option>Puri</option>
                <option>Rourkela</option>
                <option>Orissa-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Punjab-</i></font></option>
                <option>Amritsar</option>
                <option>Bathinda</option>
                <option>Chandigarh</option>
                <option>Jalandhar</option>
                <option>Ludhiana</option>
                <option>Mohali</option>
                <option>Pathankot</option>
                <option>Patiala</option>
                <option>Punjab-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Rajasthan-</i></font></option>
                <option>Ajmer</option>
                <option>Jaipur</option>
                <option>Jaisalmer</option>
                <option>Jodhpur</option>
                <option>Kota</option>
                <option>Udaipur</option>
                <option>Rajasthan-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Sikkim-</i></font></option>
                <option>Gangtok</option>
                <option>Sikkim-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Tamil Nadu-</i></font></option>
                <option>Chennai</option>
                <option>Coimbatore</option>
                <option>Cuddalore</option>
                <option>Erode</option>
                <option>Hosur</option>
                <option>Madurai</option>
                <option>Nagerkoil</option>
                <option>Ooty</option>
                <option>Salem</option>
                <option>Thanjavur</option>
                <option>Tirunalveli</option>
                <option>Trichy</option>
                <option>Tuticorin</option>
                <option>Vellore</option>
                <option>Tamil Nadu-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Tripura-</i></font></option>
                <option>Agartala</option>
                <option>Tripura-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Union Territories-</i></font></option>
                <option>Chandigarh</option>
                <option>Dadra & Nagar Haveli-Silvassa</option>
                <option>Daman & Diu</option>
                <option>Delhi</option>
                <option>Pondichery</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Uttar Pradesh-</i></font></option>
                <option>Agra</option>
                <option>Aligarh</option>
                <option>Allahabad</option>
                <option>Bareilly</option>
                <option>Faizabad</option>
                <option>Ghaziabad</option>
                <option>Gorakhpur</option>
                <option>Kanpur</option>
                <option>Lucknow</option>
                <option>Mathura</option>
                <option>Meerut</option>
                <option>Moradabad</option>
                <option>Noida</option>
                <option>Varanasi/Banaras</option>
                <option>Uttar Pradesh-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Uttaranchal-</i></font></option>
                <option>Dehradun</option>
                <option>Roorkee</option>
                <option>Uttaranchal-Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-West Bengal-</i></font></option>
                <option>Asansol</option>
                <option>Durgapur</option>
                <option>Haldia</option>
                <option>Kharagpur</option>
                <option>Kolkatta</option>
                <option>Siliguri</option>
                <option>West Bengal - Other</option>
<option disabled="disabled" style="background-color:#3E3E3E"><font color="#FFFFFF"><i>-Other-</i></font></option>
				<option>Other</option>
</select>
		<?php echo $valid_city; ?>
					<!--<input type="text" name="state" placeholder="Enter State" size="20">-->
                </td>
			 </tr>

              
			  <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">State</th>
				<td width="50%">
                <input type="text" name="state" placeholder=" Enter State" size="30" class="form-control">
                <?php echo $valid_state; ?>
                </td>
			 </tr>
                           
    		  <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Enter qualification</th>
				<td width="50%">
                <input type="text" name="qualification" placeholder=" Enter qualification" size="30" class="form-control">
                <?php echo $valid_qualification; ?>
                </td>
			 </tr>
              
              
              
              
			 <tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;"> Date of Joining</th>
				<td width="50%">
                
                <input type="date" name="joining_date" placeholder="dd-mm-yyyy"/>
                <?php echo $valid_joining_date; ?>
                </td>
			 </tr>
			
			<tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Documents Submitted</th>
				<td width="50%">
                <textarea  rows="3" cols="60" name="doc_details" placeholder =" Enter Document submitted" style="resize:none"></textarea>
               <?php echo $valid_doc_details; ?>
					<!--<input type="text" name="doc_details" />-->
				</td>
			</tr>
			
			<tr>
				<th width="50%" align="left" valign="top" style="padding:20px 0px;">Job Type</th>
				<td width="50%">
					<select name="job_type">
						<option value="">Select Job Type</option>
						<option value="1">Full Time</option>
						<option value="2">Part Time</option>
                        </select>
                      <?php echo  $valid_job_type; ?>
				</td>
			</tr>
			 
			  <tr>
			    <th align="left" valign="top" style="padding:20px 0px;">Upload Image</td>
			    <td><input type="file" name="image" id="image" class="form-control"/>
                <?php echo $valid_image;?>
                </td>
		      </tr>	  
			
			  
			  
			  
			  
			  <tr>
				<td colspan="2" align="center" style="padding:20px 0px;">
					<input type="submit" name="Submit" value="Save"/><br/>
				</td>
			</tr>
			</table>
	  </form>
<?php include("bottom.php");?>
