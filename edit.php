<?php
include('config.php');

$id = $_GET['id'];

if(isset($_POST['submit']))
{
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
	
	$msg = "";
	$image = $_FILES['image']['name'];
	$target = "upload_images/".basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}

	$update = "UPDATE student_data SET u_card='$u_card', u_f_name = '$u_f_name', "
                . "u_l_name = '$u_l_name',u_course = '$u_course', u_father = '$u_father',"
                . " u_mother = '$u_mother', u_aadhar = '$u_aadhar', u_birthday = '$u_birthday',"
                . " u_gender = '$u_gender', u_email = '$u_email', u_phone = '$u_phone', u_state = '$u_state', "
                . "u_dist = '$u_dist', u_village = '$u_village', u_pincode = '$u_pincode',"
                ." image = '$image' WHERE id=$id ";
	$run_update = mysqli_query($con,$update);

	if($run_update){
		header('location:index.php');
	}else{
		echo "Data not update";
	}
}

?>