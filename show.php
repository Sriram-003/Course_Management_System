<?php

// database connection
include('config.php');

$added = false;


//Add  new student code 

if(isset($_POST['submit'])){
	$u_card = $_POST['card_no'];
	$u_f_name = $_POST['user_first_name'];
	$u_l_name = $_POST['user_last_name'];
        $u_course = $_POST['user_course'];
	$u_father = $_POST['user_father'];
	$u_aadhar = $_POST['user_aadhar'];
	$u_birthday = $_POST['user_dob'];
	$u_gender = $_POST['user_gender'];
	$u_email = $_POST['user_email'];
	$u_phone = $_POST['user_phone'];
	$u_state = $_POST['state'];
	$u_dist = $_POST['dist'];
	$u_village = $_POST['village'];
	$u_pincode = $_POST['pincode'];
	$u_mother = $_POST['user_mother'];
	


	//image upload

	$msg = "";
	$image = $_FILES['image']['name'];
	$target = "upload_images/".basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}

  	$insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name,u_course, u_father, u_aadhar, u_birthday, "
                . "u_gender, u_email, u_phone, u_state, u_dist, u_village, u_pincode, u_mother, "
                . "image,uploaded) VALUES ('$u_card','$u_f_name','$u_l_name','$u_course','$u_father','$u_aadhar',"
                . "'$u_birthday','$u_gender','$u_email','$u_phone','$u_state','$u_dist','$u_village',"
                . "'$u_pincode','$u_mother','$image',NOW())";
  	$run_data = mysqli_query($con,$insert_data);

  	if($run_data){
		  $added = true;
  	}else{
  		echo "Data not insert";
  	}
}

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container mt-3">
             <div class="row align-items-center">
        <!-- Image Section -->
        <div class="col-md-6 d-flex">
            <a href="" target="_blank">
                <img src="http://localhost:8080/Online_Student_Registration_System/images/logo.png" alt="Logo" width="350px">
            </a>
        </div>
        <?php
	if($added){
		echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Your Student Data has been Successfully Added.
			</div><br>
		";
	}

?>
        <!-- Buttons Section -->
          <div class="col-md-6 mt-5 pd-5 mb-5 justify-content-end align-items-end">
              <br>
              <a href="index.php" class="btn btn-success me-2">
                <i class="fa fa-arrow-left"></i> Back
            </a><br><br>
            <button class="btn btn-success mb-5" type="button" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus"></i> Add New Student
            </button>
        </div>
    </div>
  <hr>
  
          <!--Table-->
         <?php 
         if (isset($_GET['name'])) {
    $cname = htmlspecialchars($_GET['name']); // Sanitize input
    echo "<h1>$cname</h1>";
} else {
    echo "Name not provided.";
}
?>
            <table class="table table-bordered table-striped table-hover" id="myTable">
<thead>
        <tr>
           <th class="text-center" scope="col">S.L</th>
                <th class="text-center" scope="col">Name</th>
                <th class="text-center" scope="col">Student Id.</th>
                <th class="text-center" scope="col">Phone</th>
         
                <th class="text-center" scope="col">View</th>
                <th class="text-center" scope="col">Edit</th>
                <th class="text-center" scope="col">Delete</th>
        </tr>
</thead>
        <?php

$get_data = "SELECT * FROM student_data where u_course='$cname' order by 1 desc";
$run_data = mysqli_query($con,$get_data);
        $i = 0;
while($row = mysqli_fetch_array($run_data))
{
                $sl = ++$i;
                $id = $row['id'];
                $u_card = $row['u_card'];
                $u_f_name = $row['u_f_name'];
                $u_l_name = $row['u_l_name'];
//                $u_course=$row['u_course'];
                $u_phone = $row['u_phone'];
               

        $image = $row['image'];

        echo "

                <tr>
                <td class='text-center'>$sl</td>
                <td class='text-left'>$u_f_name   $u_l_name</td>
                <td class='text-left'>$u_card</td>
                <td class='text-left'>$u_phone</td>

                <td class='text-center'>
                        <span>
                        <a href='#' class='btn btn-success mr-3 profile' data-toggle='modal' data-target='#view$id' title='Profile'><i class='fa fa-address-card-o' aria-hidden='true'></i></a>
                        </span>

                </td>
                <td class='text-center'>
                        <span>
                        <a href='#' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#edit$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>



                        </span>

                </td>
                <td class='text-center'>
                        <span>

                                <a href='#' class='btn btn-danger deleteuser' title='Delete'>
                                     <i class='fa fa-trash-o fa-lg' data-toggle='modal' data-target='#$id' style='' aria-hidden='true'></i>
                                </a>
                        </span>

                </td>
        </tr>


        ";
}

        	?>

			
			
		</table>
          </div>
       
	</div>


	<!---Add in modal---->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<center><img src="http://localhost:8080/Online_Student_Registration_System/images/logo.png" width="300px" height="80px" alt="">   </center>
    
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
			
			<!-- This is test for New Card Activate Form  -->
			<!-- This is Address with email id  -->
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail4">Student Id.</label>
<input type="text" class="form-control" name="card_no" placeholder="Enter 12-digit Student Id." maxlength="12" required>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Mobile No.</label>
<input type="phone" class="form-control" name="user_phone" placeholder="Enter 10-digit Mobile no." maxlength="10" required>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="firstname">First Name</label>
<input type="text" class="form-control" name="user_first_name" placeholder="Enter First Name">
</div>
<div class="form-group col-md-6">
<label for="lastname">Last Name</label>
<input type="text" class="form-control" name="user_last_name" placeholder="Enter Last Name">
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="fathername">Father's Name</label>
<input type="text" class="form-control" name="user_father" placeholder="Enter First Name">
</div>
<div class="form-group col-md-6">
<label for="mothername">Mother's Name</label>
<input type="text" class="form-control" name="user_mother" placeholder="Enter Last Name">
</div>
</div>


<div class="form-row" style="color: skyblue;">
<div class="form-group col-md-6">
<label for="email">Email Id</label>
<input type="email" class="form-control" name="user_email" placeholder="Enter Email id">
</div>
<div class="form-group col-md-6">
<label for="aadharno">Aadhar No.</label>
<input type="text" class="form-control" name="user_aadhar" maxlength="12" placeholder="Enter 12-digit Aadhar no. ">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputState">Gender</label>
<select id="inputState" name="user_gender" class="form-control">
  <option selected>Choose...</option>
  <option>Male</option>
  <option>Female</option>
  <option>Other</option>
</select>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Date of Birth</label>
<input type="date" class="form-control" name="user_dob" placeholder="Date of Birth">
</div>
</div>
<div class="form-row">
        <div class="form-group">
        <label for="inputCourse">Course</label>
        <select id="inputCourse" name="user_course" class="form-control">
          <option selected>Choose...</option>
          <option>Computer Science and Engineering</option>
          <option>Electronics and Communication Engineering</option>
          <option>Electrical and Electronics Engineering</option>
          <option>Mechanical Engineering</option>
          <option>Civil Engineering</option>
          <option>Artificial Intelligence and Machine Learning</option>
          
        </select>
        </div>

        </div>
<div class="form-group">
<label for="inputAddress">Village</label>
<input type="text" class="form-control" name="village" placeholder="1234 Main St">
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputCity">District</label>
<input type="text" class="form-control" name="dist">
</div>
<div class="form-group col-md-4">
<label for="inputState">State</label>
<select name="state" class="form-control">
  <option selected>Choose...</option>
  <option value="Andhra Pradesh">Andhra Pradesh</option>
    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
    <option value="Assam">Assam</option>
    <option value="Bihar">Bihar</option>
    <option value="Chandigarh">Chandigarh</option>
    <option value="Chhattisgarh">Chhattisgarh</option>
    <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
    <option value="Daman and Diu">Daman and Diu</option>
    <option value="Delhi">Delhi</option>
    <option value="Lakshadweep">Lakshadweep</option>
    <option value="Puducherry">Puducherry</option>
    <option value="Goa">Goa</option>
    <option value="Gujarat">Gujarat</option>
    <option value="Haryana">Haryana</option>
    <option value="Himachal Pradesh">Himachal Pradesh</option>
    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
    <option value="Jharkhand">Jharkhand</option>
    <option value="Karnataka">Karnataka</option>
    <option value="Kerala">Kerala</option>
    <option value="Madhya Pradesh">Madhya Pradesh</option>
    <option value="Maharashtra">Maharashtra</option>
    <option value="Manipur">Manipur</option>
    <option value="Meghalaya">Meghalaya</option>
    <option value="Mizoram">Mizoram</option>
    <option value="Nagaland">Nagaland</option>
    <option value="Odisha">Odisha</option>
    <option value="Punjab">Punjab</option>
    <option value="Rajasthan">Rajasthan</option>
    <option value="Sikkim">Sikkim</option>
    <option value="Tamil Nadu">Tamil Nadu</option>
    <option value="Telangana">Telangana</option>
    <option value="Tripura">Tripura</option>
    <option value="Uttar Pradesh">Uttar Pradesh</option>
    <option value="Uttarakhand">Uttarakhand</option>
    <option value="West Bengal">West Bengal</option>
</select>
</div>
<div class="form-group col-md-2">
<label for="inputZip">Zip</label>
<input type="text" class="form-control" name="pincode">
</div>
</div>

<div class="form-group">
        <label>Image</label>
        <input type="file" name="image" class="form-control" >
</div>


 <input type="submit" name="submit" class="btn btn-info btn-large" value="Submit">
        	   	
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!------DELETE modal---->




<!-- Modal -->
<?php

$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	echo "

<div id='$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title text-center'>Are you want to sure??</h4>
      </div>
      <div class='modal-body'>
        <a href='delete.php?id=$id' class='btn btn-danger' style='margin-left:250px'>Delete</a>
      </div>
      
    </div>

  </div>
</div>


	";
	
}


?>


<!-- View modal  -->
<?php 

// <!-- profile modal start -->
$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	$card = $row['u_card'];
	$name = $row['u_f_name'];
	$name2 = $row['u_l_name'];
        $course = $row['u_course'];
	$father = $row['u_father'];
	$mother = $row['u_mother'];
	$gender = $row['u_gender'];
	$email = $row['u_email'];
	$aadhar = $row['u_aadhar'];
	$Bday = $row['u_birthday'];
	$phone = $row['u_phone'];
	$address = $row['u_state'];
	$village = $row['u_village'];
	$dist = $row['u_dist'];
	$pincode = $row['u_pincode'];
	$state = $row['u_state'];
	$time = $row['uploaded'];
	
	$image = $row['image'];
	echo "

		<div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='exampleModalLabel'>Profile <i class='fa fa-user-circle-o' aria-hidden='true'></i></h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</div>
			<div class='modal-body'>
			<div class='container' id='profile'> 
				<div class='row'>
					<div class='col-sm-4 col-md-2'>
						<img src='upload_images/$image' alt='' style='width: 150px; height: 150px;' ><br>
		
						<i class='fa fa-id-card' aria-hidden='true'></i> $card<br>
						<i class='fa fa-phone' aria-hidden='true'></i> $phone  <br>
						Issue Date : $time
					</div>
					<div class='col-sm-3 col-md-6'>
						<h3 class='text-primary'>$name $name2</h3>
						<h3 class='text-primary'>$course</h3>
						<p class='text-secondary'>
						<strong>S/O :</strong> $father <br>
						<strong>M/O :</strong>$mother <br>
						<strong>Aadhar :</strong> $aadhar <br>
						<i class='fa fa-venus-mars' aria-hidden='true'></i> $gender
						<br />
						<i class='fa fa-envelope-o' aria-hidden='true'></i> $email
						<br />
						
						<i class='fa fa-home' aria-hidden='true'> Address : </i> $village, <br>$state , $dist - $pincode
						<br />
						</p>
						<!-- Split button -->
					</div>
				</div>

			</div>   
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
			</div>
			</form>
			</div>
		</div>
		</div> 


    ";
}


// <!-- profile modal end -->


?>


<!----edit Data--->

<?php

$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	$card = $row['u_card'];
	$name = $row['u_f_name'];
	$name2 = $row['u_l_name'];
        $course = $row['u_course'];
	$father = $row['u_father'];
	$mother = $row['u_mother'];
	$gender = $row['u_gender'];
	$email = $row['u_email'];
	$aadhar = $row['u_aadhar'];
	$Bday = $row['u_birthday'];
	$phone = $row['u_phone'];
	$address = $row['u_state'];
	$village = $row['u_village'];
	$dist = $row['u_dist'];
	$pincode = $row['u_pincode'];
	$state = $row['u_state'];
	$time = $row['uploaded'];
	$image = $row['image'];
	echo "

<div id='edit$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
             <button type='button' class='close' data-dismiss='modal'>&times;</button>
             <h4 class='modal-title text-center'>Edit your Data</h4> 
      </div>

      <div class='modal-body'>
        <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>

		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputEmail4'>Student Id.</label>
		<input type='text' class='form-control' name='card_no' placeholder='Enter 12-digit Student Id.' maxlength='12' value='$card' required>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputPassword4'>Mobile No.</label>
		<input type='phone' class='form-control' name='user_phone' placeholder='Enter 10-digit Mobile no.' maxlength='10' value='$phone' required>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='firstname'>First Name</label>
		<input type='text' class='form-control' name='user_first_name' placeholder='Enter First Name' value='$name'>
		</div>
		<div class='form-group col-md-6'>
		<label for='lastname'>Last Name</label>
		<input type='text' class='form-control' name='user_last_name' placeholder='Enter Last Name' value='$name2'>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='fathername'>Father's Name</label>
		<input type='text' class='form-control' name='user_father' placeholder='Enter First Name' value='$father'>
		</div>
		<div class='form-group col-md-6'>
		<label for='mothername'>Mother's Name</label>
		<input type='text' class='form-control' name='user_mother' placeholder='Enter Last Name' value='$mother'>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='email'>Email Id</label>
		<input type='email' class='form-control' name='user_email' placeholder='Enter Email id' value='$email'>
		</div>
		<div class='form-group col-md-6'>
		<label for='aadharno'>Aadhar No.</label>
		<input type='text' class='form-control' name='user_aadhar' maxlength='12' placeholder='Enter 12-digit Aadhar no. ' value='$aadhar'>
		</div>
		</div>
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputState'>Gender</label>
		<select id='inputState' name='user_gender' class='form-control' value='$gender'>
		  <option selected>$gender</option>
		  <option>Male</option>
		  <option>Female</option>
		  <option>Other</option>
		</select>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputPassword4'>Date of Birth</label>
		<input type='date' class='form-control' name='user_dob' placeholder='Date of Birth' value='$Bday'>
		</div>
		</div>
		
		<div class='form-row'>
        <div class='form-group'>
        <label for='inputCours'>Course</label>
        <select id='inputCourse' name='user_course' class='form-control'>
          <option selected>$course</option>
          <option value='cse'>B.E COMPUTER SCIENCE AND ENGINEERING</option>
          <option value='ece'>B.E ELECTRONIC AND COMMUNICATION ENGINEERING</option>
          <option value='ece'>B.E ELECTRICAL AND ELECTRONICS ENGINEERING</option>
          <option value='mech'>B.E MECHANICAL ENGINEERING</option>
          <option value='civil'>B.E CIVIL ENGINEERING</option>
          <option value='ai'>B.TECH ARTIFICAL INTELLIGENCE AND MACHINE LEARNING</option>
          
        </select>
        </div>

        </div>
		
		
		<div class='form-group'>
		<label for='inputAddress'>Village</label>
		<input type='text' class='form-control' name='village' placeholder='1234 Main St' value='$village'>
		</div>

		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputCity'>District</label>
		<input type='text' class='form-control' name='dist' value='$dist'>
		</div>
		<div class='form-group col-md-4'>
		<label for='inputState'>State</label>
		<select name='state' class='form-control'>
		  <option>$state</option>
		  <option value='Andhra Pradesh'>Andhra Pradesh</option>
            <option value='Andaman and Nicobar Islands'>Andaman and Nicobar Islands</option>
            <option value='Arunachal Pradesh'>Arunachal Pradesh</option>
            <option value='Assam'>Assam</option>
            <option value='Bihar'>Bihar</option>
            <option value='Chandigarh'>Chandigarh</option>
            <option value='Chhattisgarh'>Chhattisgarh</option>
            <option value='Dadar and Nagar Haveli'>Dadar and Nagar Haveli</option>
            <option value='Daman and Diu'>Daman and Diu</option>
            <option value='Delhi'>Delhi</option>
            <option value='Lakshadweep'>Lakshadweep</option>
            <option value='Puducherry'>Puducherry</option>
            <option value='Goa'>Goa</option>
            <option value='Gujarat'>Gujarat</option>
            <option value='Haryana'>Haryana</option>
            <option value='Himachal Pradesh'>Himachal Pradesh</option>
            <option value='Jammu and Kashmir'>Jammu and Kashmir</option>
            <option value='Jharkhand'>Jharkhand</option>
            <option value='Karnataka'>Karnataka</option>
            <option value='Kerala'>Kerala</option>
            <option value='Madhya Pradesh'>Madhya Pradesh</option>
            <option value='Maharashtra'>Maharashtra</option>
            <option value='Manipur'>Manipur</option>
            <option value='Meghalaya'>Meghalaya</option>
            <option value='Mizoram'>Mizoram</option>
            <option value='Nagaland'>Nagaland</option>
            <option value='Odisha'>Odisha</option>
            <option value='Punjab'>Punjab</option>
            <option value='Rajasthan'>Rajasthan</option>
            <option value='Sikkim'>Sikkim</option>
            <option value='Tamil Nadu'>Tamil Nadu</option>
            <option value='Telangana'>Telangana</option>
            <option value='Tripura'>Tripura</option>
            <option value='Uttar Pradesh'>Uttar Pradesh</option>
            <option value='Uttarakhand'>Uttarakhand</option>
            <option value='West Bengal'>West Bengal</option>
		</select>
		</div>
		<div class='form-group col-md-2'>
		<label for='inputZip'>Zip</label>
		<input type='text' class='form-control' name='pincode' value='$pincode'>
		</div>
		</div>

        	<div class='form-group'>
        		<label>Image</label>
        		<input type='file' name='image' class='form-control'>
        		<img src = 'upload_images/$image' style='width:50px; height:50px'>
        	</div>

        	
        	
			 <div class='modal-footer'>
			 <input type='submit' name='submit' class='btn btn-info btn-large' value='Submit'>
			 <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
		 </div>


        </form>
      </div>

    </div>

  </div>
</div>


	";
}


?>

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>

    </body>
</html>

