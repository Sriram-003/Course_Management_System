<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Database connection
include('config.php');

$added = false;

// Add new student code
if (isset($_POST['submit'])) {
    $u_card = $_POST['card_no'];
    $u_f_name = $_POST['user_first_name'];
    $u_l_name = $_POST['user_last_name'];
    $u_father = $_POST['user_father'];
    $u_aadhar = $_POST['user_aadhar'];
    $u_birthday = $_POST['user_dob'];
    $u_gender = $_POST['user_gender'];
    $u_email = $_POST['user_email'];
    $u_phone = $_POST['user_phone'];
    $u_state = $_POST['state'];
    $u_dist = $_POST['dist'];
    $u_village = $_POST['village'];
    $u_police = $_POST['police_station'];
    $u_pincode = $_POST['pincode'];
    $u_mother = $_POST['user_mother'];
    $u_family = $_POST['family'];
    $u_staff_id = $_POST['staff_id'];

    // Image upload
    $msg = "";
    $image = $_FILES['image']['name'];
    $target = "upload_images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }

    $insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name, u_father, u_aadhar, u_birthday, u_gender, u_email, u_phone, u_state, u_dist, u_village, u_police, u_pincode, u_mother, u_family, staff_id, image, uploaded) 
                    VALUES ('$u_card', '$u_f_name', '$u_l_name', '$u_father', '$u_aadhar', '$u_birthday', '$u_gender', '$u_email', '$u_phone', '$u_state', '$u_dist', '$u_village', '$u_police', '$u_pincode', '$u_mother', '$u_family', '$u_staff_id', '$image', NOW())";
    $run_data = mysqli_query($con, $insert_data);

    if ($run_data) {
        $added = true;
    } else {
        echo "Data not inserted";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD Operation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        .info-box {
            background-size: cover;
            background-position: center;
            height: 180px;
            position: relative;
            border-radius: 10px;
            color: white;
            margin-right: 5px;
            overflow: hidden;
        }
        .info-box .overlay {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        .info-box .content {
            position: relative;
            z-index: 2;
            text-align: left;
            top: 70%;
            transform: translateY(-50%);
        }
        .info-box h2, .info-box p {
            margin: 0;
        }
    </style>
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
            <!-- Buttons Section -->
            <div class="col-md-6 text-end">
                <br>
                <a href="logout.php" class="btn btn-success me-2">
                    <i class="fa fa-lock"></i> Logout
                </a>
                <br><br>
                <a href="welcome.php" class="btn btn-success me-2">
                    <i class="fa fa-user"></i> Profile
                </a>
            </div>
        </div>

        <!-- Alert Notification -->
        <?php if ($added): ?>
            <div class="btn-success" style="padding: 15px; text-align:center;">
                Your Student Data has been Successfully Added.
            </div>
            <br>
        <?php endif; ?>

        <h1>Course Details</h1>
        <div class="form-row d-flex flex-wrap gap-3">
            <?php
            // Fetch data for each department
            $departments = [
                "Computer Science and Engineering" => "cse.jpg",
                "Artificial Intelligence and Machine Learning" => "ai.jpg",
                "Electronics and Communication Engineering" => "ece.jpg",
                "Civil Engineering" => "civil.jpg",
                "Mechanical Engineering" => "mech.jpg",
                "Electrical and Electronics Engineering" => "eee.jpg"
            ];

            foreach ($departments as $dept => $image) {
                $query = $con->prepare("SELECT COUNT(*) AS total FROM student_data WHERE u_course = ?");
                $query->bind_param("s", $dept);
                $query->execute();
                $result = $query->get_result();
                $data = $result->fetch_assoc();
                $total_students = isset($data['total']) ? $data['total'] : 0;

                echo "
                <a href='show.php?name=" . urlencode($dept) . "'>
                    <div class='form-group col-md-3 info-box' style='background-image: url(images/$image);'>
                        <div class='overlay'>$dept</div>
                        <div class='content'>
                            <h2 class='fw-bold'>Total Students</h2>
                            <p class='fs-4'>Enrolled: $total_students</p>
                        </div>
                    </div>
                </a>";
            }
            ?>
        </div>
    </div>
</body>
</html>
