<?php
session_start();
ob_start();

    include("server.php");

    if(!isset($_SESSION['email'])){
        header("Location: login.php");
    }
    $id = $_SESSION['id'];
    $query = mysqli_query($conn, "SELECT * FROM usertbl WHERE id = '$id'");

    while($result = mysqli_fetch_assoc($query)){
    $res_fname = $result['first_name'];
    $res_lname = $result['last_name'];
    $res_mnum = $result['mobile_number'];
    $res_email = $result['email'];
    $res_utype = $result['user_type'];
    $res_section = $result['section'];
    $res_year = $result['year'];
    $res_id = $result['id'];
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin Form</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script>
            function toggleSectionInput() {
            var userTypeSelect = document.getElementById("user_type");
            var sectionFieldsDiv = document.getElementById("sectionFields");
            var yearFieldsDiv = document.getElementById("yearFields");
            var sectionFieldsInput = document.getElementById("section");
            var yearFieldsInput = document.getElementById("year");

            if (userTypeSelect.value === "Student") {
                sectionFieldsDiv.style.display = "block";
                yearFieldsDiv.style.display = "block";
                sectionFieldsInput.disabled = false;
                yearFieldsInput.disabled = false;
            } else {
                sectionFieldsDiv.style.display = "none";
                yearFieldsDiv.style.display = "none";
                sectionFieldsInput.value = "";
                sectionFieldsInput.disabled = true;
                yearFieldsInput.value = "";
                yearFieldsInput.disabled = true;
            }
        }

        function validatePassword() {
            var password = document.getElementById("inputPassword").value;
            var confirmPassword = document.getElementById("inputPasswordConfirm").value;
            var errorMessage = document.getElementById("error-message");

            if (password !== confirmPassword && confirmPassword == "") {
                errorMessage.style.display = "block";
            } else {
                errorMessage.style.display = "none";
            }
        }

        </script>
    </head>
    <body class="sb-nav-fixed">
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home-admin.php" >Admin UI</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><p class="dropdown-item">Welcome <?php echo $res_fname; ?></p></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="logout-func.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="home-admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="home-admin.php" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Features
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="create-admin.php">Create Room & User</a>
                                <a class="nav-link" href="read-admin.php">Read Rooms & Users List</a>
                                <a class="nav-link" href="update-admin.php">Update Room & User</a>
                                <a class="nav-link" href="delete-admin.php">Delete Room or User</a>
                                <a class="nav-link" href="request-admin.php">Request Form</a>
                            </nav>
                        </div>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $res_fname . " " . $res_lname; ?>
                </div>
            </nav>
        </div>
            <div id="layoutSidenav_content">
    <main>
            <div class="container-fluid px-4">
            <h1 class="mt-4">Create Room & User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="home-admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Create Room & User</li>
            </ol>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Users Full Detailed Table
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th>Password</th>
                                            <th>Section</th>
                                            <th>Year & Section</th>
                                            <th>Subjects</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sqlUser = "SELECT * FROM usertbl";
                                        $queryUser = mysqli_query($conn, $sqlUser);
                                        
                                        while($resultUser = mysqli_fetch_assoc($queryUser)){
                                            echo '<tr>';
                                            echo '<td>' . $resultUser['id'] . '</td>';
                                            echo '<td>' . $resultUser['first_name'] . ' ' . $resultUser['last_name'] . '</td>';
                                            echo '<td>' . $resultUser['mobile_number'] . '</td>';
                                            echo '<td>' . $resultUser['email'] . '</td>';
                                            echo '<td>' . $resultUser['user_type'] . '</td>';
                                            echo '<td>' . $resultUser['password'] . '</td>';
                                            echo '<td>' . $resultUser['section'] . '</td>';
                                            echo '<td>' . $resultUser['year'] . '</td>';
                                            echo '<td>' . $resultUser['subjects'] . '</td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <?php 
                                    if(mysqli_num_rows($queryUser) == 0) {
                                        echo "No users available yet.";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Rooms Full Detailed Table
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Schedule Code</th>
                                            <th>Teacher Name</th>
                                            <th>Start Time</th>
                                            <th>Room</th>
                                            <th>End Time</th>
                                            <th>Day</th>
                                            <th>Status</th>
                                            <th>Year & Section</th>
                                            <th>Attending Count</th>
                                            <th>Not Attending Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sqlRoom = "SELECT * FROM roomtbl ORDER BY made_at DESC";
                                        $queryRoom = mysqli_query($conn, $sqlRoom);
                                        
                                        while($resultRoom = mysqli_fetch_assoc($queryRoom)){
                                            echo '<tr>';
                                            echo '<td>' . $resultRoom['sched_code'] . '</td>';
                                            echo '<td>' . $resultRoom['prof_fname'] . ' ' . $resultRoom['prof_lname'] . '</td>';
                                            echo '<td>' . $resultRoom['start_time'] . '</td>';
                                            echo '<td>' . $resultRoom['room_type'] . $resultRoom['room_num'] .'</td>';
                                            echo '<td>' . $resultRoom['end_time'] . '</td>';
                                            echo '<td>' . $resultRoom['room_day'] . '</td>';
                                            echo '<td>' . $resultRoom['status'] . '</td>';
                                            echo '<td>' . $resultRoom['room_section'] . '</td>';
                                            echo '<td>' . $resultRoom['attend'] . '</td>';
                                            echo '<td>' . $resultRoom['not_attend'] . '</td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <?php 
                                    if(mysqli_num_rows($queryRoom) == 0) {
                                        echo "No rooms available yet.";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <p class="mb-2 h3">Create a User</p>
                        </div>
                        <div class="card-body">
                            <div class="container m-auto w-100">
                                <form action="create-admin.php" method="post">
                                    <h5 class="text-center">Create a User Window</h5>
                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                                <i class="far fa-id-card"></i> First Name
                                            </label>
                                            <input class="form-control text-center" type="text" name="first_name">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                                <i class="fas fa-id-card-alt"></i> Last Name
                                            </label>
                                            <input class="form-control text-center" type="text" name="last_name">
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                                <i class="fa-solid fa-phone"></i> Mobile Number
                                            </label>
                                            <input class="form-control text-center" name="mobile_number" type="phone">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                                <i class="fa-solid fa-envelope"></i> Email
                                            </label>
                                            <input class="form-control text-center" name="email" type="email">
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                                <i class="fa-solid fa-user-gear"></i> User Type
                                            </label>
                                            <select class="form-control text-center" name="user_type" type="text" id="user_type" onchange="toggleSectionInput()">
                                                <option value=""></option>
                                                <option value="Teacher">Teacher</option>
                                                <option value="Student">Student</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                            <div id="yearFields">
                                                <i class="fa-solid fas fa-hashtag"></i> Year
                                            </label>
                                                <select class="form-control text-center" name="year" type="text" id="year" onchange="toggleSectionInput()">
                                                    <option value=""></option>
                                                    <option value="1st">1st</option>
                                                    <option value="2nd">2nd</option>
                                                    <option value="3rd">3rd</option>
                                                    <option value="4th">4th</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                            <div id="sectionFields">
                                                <i class="fas fa-atom"></i> Section
                                            </label>
                                                <select class="form-control" name="section" type="text" id="section" onchange="toggleSectionInput()">
                                                    <option value=""></option>
                                                    <option value="Section_A">Section_A</option>
                                                    <option value="Section_B">Section_B</option>
                                                    <option value="Section_C">Section_C</option>
                                                    <option value="Section_D">Section_D</option>
                                                    <option value="Section_E">Section_E</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                                <i class="fa-solid fa-lock"></i> Password
                                            </label>
                                            <input class="form-control text-center" name="password" type="password" id="inputPassword">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label class="col-form-label">
                                                <i class="fas fa-key"></i> Confirm Password
                                            </label>
                                            <input class="form-control text-center" name="conf_password" type="password" id="inputPasswordConfirm">
                                            <div id="error-message" class="error-message" style="color:red;display:none;">Passwords do not match</div>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <button class="btn btn-primary mt-4" type="submit" style="width:150px;" name="create-user">Create User</button>
                                    </div>
                                </form>

                                <?php
                                if(isset($_POST['create-user'])){
                                    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $mobile_number = filter_input(INPUT_POST, "mobile_number", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $user_type = filter_input(INPUT_POST, "user_type", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $year  = filter_input(INPUT_POST, "year", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $section  = filter_input(INPUT_POST, "section", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $password  = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                                    $conf_password  = filter_input(INPUT_POST, "conf_password", FILTER_SANITIZE_SPECIAL_CHARS);
                                    if ($user_type == "Student"){
                                        if (!empty($first_name) && !empty($last_name) && !empty($mobile_number) && !empty($email) && !empty($user_type) && !empty($year) && !empty($section) && !empty($password) && !empty($conf_password)){
                                                    $check_email_query = "SELECT * FROM usertbl WHERE email = '$email'";
                                                    $result = mysqli_query($conn, $check_email_query);
                                                    
                                                    if (mysqli_num_rows($result) > 0) {
                                                        echo '<script>';
                                                        echo 'alert("The email address is already registered. Please use a different email.");';
                                                        echo 'window.location.href = "create-admin.php";';
                                                        echo '</script>';
                                                    } else {
                                                        if ($password == $conf_password){
                                                            $sql_num = "ALTER TABLE usertbl AUTO_INCREMENT=202400";
                                                            mysqli_query($conn, $sql_num);
                                                            $sqluser = "INSERT INTO usertbl (first_name, last_name, mobile_number, email, user_type, year,  section, password) VALUES ('$first_name', '$last_name', '$mobile_number', '$email', '$user_type', '$year', '$section', '$section', '$password')";
                                                            if (mysqli_query($conn, $sqluser)){
                                                                echo '<script>alert("Successfully created a new user as an ADMIN")</script>';
                                                                echo '<script>window.location.href = "create-admin.php";</script>';
                                                            } else {
                                                                echo '<script>alert("Error updating database")</script>';
                                                            }
                                                        } echo '<script>alert("Passwords don\'t match!")</script>';
                                                }    
                                        } else {
                                            echo '<script>alert("Must fill out all the fields first!")</script>';
                                        }
                                        
                                    } elseif ($user_type == "Teacher"){
                                        if (!empty($first_name) && !empty($last_name) && !empty($mobile_number) && !empty($email) && !empty($user_type) && !empty($password) && !empty($conf_password)){
                                                    $check_email_query = "SELECT * FROM usertbl WHERE email = '$email'";
                                                    $result = mysqli_query($conn, $check_email_query);
                                                    
                                                    if (mysqli_num_rows($result) > 0) {
                                                        echo '<script>';
                                                        echo 'alert("The email address is already registered. Please use a different email.");';
                                                        echo 'window.location.href = "create-admin.php";';
                                                        echo '</script>';
                                                    } else {
                                                        if ($password == $conf_password){
                                                            $sql_num = "ALTER TABLE usertbl AUTO_INCREMENT=202400";
                                                            mysqli_query($conn, $sql_num);
                                                            $sqluser = "INSERT INTO usertbl (first_name, last_name, mobile_number, email, user_type, password) VALUES ('$first_name', '$last_name', '$mobile_number', '$email', '$user_type', '$password')";
                                                            if (mysqli_query($conn, $sqluser)){
                                                                echo '<script>alert("Successfully created a new user as an ADMIN")</script>';
                                                                echo '<script>window.location.href = "create-admin.php";</script>';
                                                            } else {
                                                                echo '<script>alert("Error updating database")</script>';
                                                            }
                                                        } echo '<script>alert("Passwords don\'t match!")</script>';
                                                }    
                                        } else {
                                            echo '<script>alert("Must fill out all the fields first!")</script>';
                                        }
                                        
                                    }
                                    
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create a Room Card -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <p class="mb-2 h3">Create a Room</p>
                        </div>
                        <div class="card-body">
                            <form action="create-admin.php" method="post">
                                <div class="container m-auto w-100">
                                <div class="form-group row justify-content-center">
                                <div class="col-md-4 text-center">
                                    <h5 class="text-center">Prof First Name</h5>
                                        <input class="form-control text-center" type="text" name="prof_fname">
                                    </div>
                                    <div class="col-md-4 text-center">
                                    <h5 class="text-center">Prof Last Name</h5>
                                        <input class="form-control text-center mb-2" type="text" name="prof_lname">
                                    </div>
                                </div>
                                        <div class="form-group row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <label class="form-label text-center">
                                                <i class="fas fa-door-closed"></i> Room Number
                                            </label>
                                            <select class="form-control text-center m-auto mb-1" name="room_num" style="width:70px;" required>
                                                <option value="" selected></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div>
                                            <div class="col-md-4 text-center">
                                                <label class="form-label text-center">
                                                    <i class="fas fa-door-closed"></i> Room Type
                                                </label>
                                                <select class="form-control text-center m-auto mb-1" name="room_type" style="width:100px;" required>
                                                    <option value="" selected></option>
                                                    <option value="CCL">CCL</option>
                                                    <option value="DCS">DCS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <div class="col-md-4 text-center">
                                                <label class="form-label text-center">
                                                    <i class="fa-solid fa-hourglass-start"></i> Start
                                                </label>
                                                <input class="form-control text-center m-auto mb-1" name="start_time" type="time" value="" style="width:180px;" required>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label class="form-label text-center">
                                                    <i class="fa-solid fa-hourglass-end"></i> End
                                                </label>
                                                <input class="form-control text-center m-auto mb-1" name="end_time" type="time" value="" style="width:180px;" required>
                                            </div>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <div class="col-md-4 text-center">
                                                <label class="form-label text-center">
                                                    <i class="fa-solid fas fa-hashtag"></i> Year
                                                </label>
                                                <select class="form-control text-center m-auto mb-1" name="room_year" style="width:120px;margin-right:10px;" required>
                                                    <option value="" selected></option>
                                                    <option value="1st">1st</option>
                                                    <option value="2nd">2nd</option>
                                                    <option value="3rd">3rd</option>
                                                    <option value="4th">4th</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label class="form-label text-center">
                                                    <i class="fas fa-atom"></i> Section
                                                </label>
                                                <select class="form-control text-center m-auto mb-1" name="room_section" style="width:160px;margin-left:10px;" required>
                                                    <option value="" selected></option>
                                                    <option value="Section_A">Section A</option>
                                                    <option value="Section_B">Section B</option>
                                                    <option value="Section_C">Section C</option>
                                                    <option value="Section_D">Section D</option>
                                                    <option value="Section_E">Section E</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <div class="col-md-4 text-center">
                                                <label class="form-label text-center">
                                                    <i class="fas fa-exclamation" style="margin-right:10px;"></i> Room Status
                                                </label>
                                                <select class="form-control text-center m-auto mb-1" name="room_status" style="width:220px;" required>
                                                    <option value="" selected></option>
                                                    <option value="Occupied">Occupied</option>
                                                    <option value="Not_Occupied">Not Occupied</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <div class="col-md-4 text-center">
                                                <label class="form-label">
                                                        <i class="fas fa-calendar"></i> Days
                                                </label>
                                                <ul style="list-style-type: none;">
                                                    <li><input type="checkbox" name="room_day[]" value="Monday">Monday</li>
                                                    <li><input type="checkbox" name="room_day[]" value="Tuesday">Tuesday</li>
                                                    <li><input type="checkbox" name="room_day[]" value="Wednesday">Wednesday</li>
                                                    
                                                </ul>
                                            </div>
                                                <div class="col-md-4 text-center">
                                                <label class="form-label">
                                                        <i class="fas fa-calendar"></i> Days
                                                </label>
                                                <ul style="list-style-type: none;">
                                                    <li><input type="checkbox" name="room_day[]" value="Thursday">Thursday</li>
                                                    <li><input type="checkbox" name="room_day[]" value="Friday">Friday</li>
                                                    <li><input type="checkbox" name="room_day[]" value="Saturday">Saturday</li>
                                                </ul>    
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center mt-5 mb-5">
                                        <button class="btn btn-warning" type="submit" name="create-room" style="width:80px;">Create</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                            if(isset($_POST['create-room'])){
                                $prof_fname = filter_input(INPUT_POST, "prof_fname", FILTER_SANITIZE_SPECIAL_CHARS);
                                $prof_lname = filter_input(INPUT_POST, "prof_lname", FILTER_SANITIZE_SPECIAL_CHARS);
                                $room_type = filter_input(INPUT_POST, "room_type", FILTER_SANITIZE_SPECIAL_CHARS);
                                $room_num = filter_input(INPUT_POST, "room_num", FILTER_SANITIZE_SPECIAL_CHARS);
                                $start_time  = filter_input(INPUT_POST, "start_time", FILTER_SANITIZE_SPECIAL_CHARS);
                                $end_time = filter_input(INPUT_POST, "end_time", FILTER_SANITIZE_SPECIAL_CHARS);
                                $room_status  = filter_input(INPUT_POST, "room_status", FILTER_SANITIZE_SPECIAL_CHARS);
                                $room_section  = filter_input(INPUT_POST, "room_section", FILTER_SANITIZE_SPECIAL_CHARS);
                                $room_year  = filter_input(INPUT_POST, "room_year", FILTER_SANITIZE_SPECIAL_CHARS);
                                // Find the user ID based on the first name and last name
                                $sql_find_user = "SELECT id FROM usertbl WHERE first_name = '$prof_fname' AND last_name = '$prof_lname' AND user_type = 'Teacher'";
                                $result = mysqli_query($conn, $sql_find_user);

                                if (mysqli_num_rows($result) > 0) {
                                    // Fetch the user ID
                                    $row = mysqli_fetch_assoc($result);
                                    $made_by = $row['id'];
                                     // Handle checkboxes
                                    $room_days = isset($_POST['room_day']) ? $_POST['room_day'] : [];
                                    $room_day = implode(",",$room_days);  // Convert array to comma-separated string

                                    $comb = $room_type . $room_num;
                                    $sqlroom = "INSERT INTO roomtbl (prof_fname, prof_lname, room_type, room_num, comb, start_time, end_time, room_day, status, room_section, room_year, madeby, seen, prof_seen, attend, not_attend) VALUES ('$prof_fname', '$prof_lname', '$room_type', '$room_num', '$comb', '$start_time', '$end_time', '$room_day', '$room_status', '$room_section', '$room_year', '$made_by', 0, 0, 0, 0)";

                                    if (mysqli_query($conn, $sqlroom)) {
                                        // Get the auto-incremented ID of the last inserted row
                                        $room_id = mysqli_insert_id($conn);
                                    
                                        // Create a new table using the room_id
                                        $new_table_name = $room_id; // Assuming 'room_' prefix for clarity
                                    
                                        $sql_create_table = "CREATE TABLE `$new_table_name` (
                                            `id` int(10) NOT NULL AUTO_INCREMENT,
                                            `stud_id` int(255) NOT NULL,
                                            `stud_fname` varchar(100) NOT NULL,
                                            `stud_lname` varchar(100) NOT NULL,
                                            `room_type` varchar(100) NOT NULL,
                                            `room_num` bigint(20) NOT NULL,
                                            `start_time` varchar(100) NOT NULL,
                                            `end_time` varchar(100) NOT NULL,
                                            `room_day` varchar(100) NOT NULL,
                                            `status` varchar(100) DEFAULT NULL,
                                            `comb` varchar(100) NOT NULL,
                                            `room_section` varchar(100) NOT NULL,
                                            `room_year` varchar(100) NOT NULL,
                                            `room_subject` varchar(100) NOT NULL,
                                            `attend` int(100) NOT NULL,
                                            `not_attend` int(100) NOT NULL,
                                            PRIMARY KEY (`id`)
                                        )";
                                    
                                        if (mysqli_query($conn, $sql_create_table)) {
                                            echo '<script>alert("Successfully created a new room and table!")</script>';
                                            echo '<script>window.location.href = "create-admin.php";</script>';
                                        } else {
                                            echo '<script>alert("Error creating new table")</script>';
                                        }
                                    } else {
                                        echo '<script>alert("Error updating database")</script>';
                                    }
                                } else {
                                    echo '<script>alert("No user with found with ' . $prof_fname . ' ' . $prof_lname . ' as a teacher!")</script>';
                                }
                                
                            }
                                ?>
                        </div>
                    </div>
                </div>
            </div>


            </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        
    </body>
</html>