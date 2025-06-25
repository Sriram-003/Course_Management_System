<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Sidebar</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .info-box {
            background-size: cover;
            background-position: center;
            height: 180px;
            width: 100%;
            position: relative;
            border-radius: 10px;
            color: white;
            margin: 10px;
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

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 1rem;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            cursor: pointer;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .topbar {
            height: 60px;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            margin-left: 250px;
        }

        .content {
            margin-left: 250px;
            padding: 10px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Dashboard</h4>
        <hr class="text-white">
        <a onclick="showContent('update-profile')">Update Profile</a>
        <a onclick="showContent('join-courses')">Join Courses</a>
        <a onclick="showContent('current-courses')">Current Enrolled Courses</a>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>

    <!-- Top Bar -->
    <div class="topbar">
        <div>
            <img src="http://localhost:8080/Online_Student_Registration_System/images/logo.png" width="150" height="50" class="d-inline-block align-top fit" alt="">

        </div>
        <div class="user-icon">
            <img src="images/user.png" style="width:50px; height: 50px; marugin-right:10px" alt="user-avtar">

        </div>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div id="update-profile" class="tab-content hidden">
            <h3>Update Profile</h3>
            <p>Update your profile information here.</p>
        </div>

        <div id="join-courses" class="tab-content hidden">
            <h3>Join Courses</h3>
            <div class="form-row d-flex flex-wrap">
                <?php
                include('config.php');

                // Fetch courses dynamically
                $departments = [
                "Computer Science and Engineering" => "cse.jpg",
                "Artificial Intelligence and Machine Learning" => "ai.jpg",
                "Electronics and Communication Engineering" => "ece.jpg",
                "Civil Engineering" => "civil.jpg",
                "Mechanical Engineering" => "mech.jpg",
                "Electrical and Electronics Engineering" => "eee.jpg"
            ];
                $query = "SELECT u_course FROM student_data"; // Adjust column names
                $result = $con->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $course_name = $row['u_course'];

                        echo "
                        <a href='show.php?course=" . urlencode($course_name) . "'>
                            <div class='form-group col-md-3 info-box' style='background-image: url(images/logo.png);'>
                                <div class='overlay'>$course_name</div>
                                <div class='content'>
                                    <h2 class='fw-bold'>Join</h2>
                                </div>
                            </div>
                        </a>";
                    }
                } else {
                    echo "<p>No courses available.</p>";
                }
                ?>
            </div>
        </div>

        <div id="current-courses" class="tab-content hidden">
            <h3>Current Enrolled Courses</h3>
            <?php
            $query = "SELECT u_course FROM student_data"; // Adjust column names
            $result = $con->query($query);
            ?>
            <p>View your current enrolled courses here.</p>
        </div>
    </div>

    <script>
        // JavaScript to toggle content visibility
        function showContent(tabId) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.add('hidden'));

            // Show the selected tab
            document.getElementById(tabId).classList.remove('hidden');
        }
    </script>
</body>

</html>
