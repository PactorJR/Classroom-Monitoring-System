<?php
session_start();
ob_start();

    include("server.php");

    if(!isset($_SESSION['email'])){
        header("Location: login.php");
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
        $_SESSION['status'] = $_POST['status'];
    } else {
        $_SESSION['status'] = '';
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
    $res_id = $result['id'];
    }
    $sqlroom = "SELECT * FROM roomtbl WHERE madeby = '$id'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $scheduled =  mysqli_num_rows($queryroom);

    $sqlroom = "SELECT * FROM roomtbl WHERE status = 'Not_Occupied'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $available =  mysqli_num_rows($queryroom);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin UI</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script>
            function toggleProfileEdit() {
                var profileDiv = document.getElementById('profile-div');
                var editDiv = document.getElementById('edit-div');

                if (profileDiv.style.display === 'block') {
                    profileDiv.style.display = 'none';
                    editDiv.style.display = 'block';
                } else {
                    editDiv.style.display = 'none';
                    profileDiv.style.display = 'block';
                }
            }

            // Function to toggle password visibility
            function togglePassword() {
                var passwordField = document.getElementById('password-field');
                var toggleIcon = document.getElementById('toggle-icon');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    toggleIcon.className = 'fa fa-eye-slash';
                } else {
                    passwordField.type = 'password';
                    toggleIcon.className = 'fa fa-eye';
                }
            }
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

        // Attach event listeners to buttons
        document.getElementById('show-edit-btn').addEventListener('click', toggleProfileEdit);
        document.getElementById('back-btn').addEventListener('click', toggleProfileEdit);
        </script>
    </head>
    <body class="sb-nav-fixed">
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home-admin.php" >Admin UI</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"  ><i class="fas fa-bars"></i></button>
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
                    <h1 class="mt-4">Delete Rooms & Users</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="home-admin.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Delete Rooms & Users</li>
                    </ol>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table me-1"></i>
                                            Users Full Detailed Table
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <form action="delete-admin.php" method="post">
                                                    <!-- Search Input Group -->
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" name="user_search" type="text" placeholder="Search users...">
                                                        <button class="btn btn-primary" name="user_searchbtn" type="submit">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Sort Input Group -->
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="user_sort">
                                                            <option value="ALL">ALL</option>
                                                            <option value="Admin">Admin</option>
                                                            <option value="Teacher">Teacher</option>
                                                            <option value="Student">Student</option>
                                                        </select>
                                                        <button class="btn btn-primary" name="user_sortbtn" type="submit">
                                                            <i class="fa-solid fa-sort"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                                <table style="cursor:pointer;" class="table table-bordered table-hover text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>User ID</th>
                                                            <th>User Name</th>
                                                            <th>Mobile Number</th>
                                                            <th>Email</th>
                                                            <th>User Type</th>
                                                            <th>Year & Section</th>
                                                            <th>Subjects</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $clk_id = '';
                                                    $clk_fname = '';
                                                    $clk_lname = '';
                                                    $clk_mnum = '';
                                                    $clk_email = '';
                                                    $clk_utype = '';
                                                    $clk_pass = '';
                                                    $clk_yr = '';
                                                    $clk_sec = '';
                                                    $clk_subjects = '';
                                                    if (isset($_GET['selid'])) {
                                                        $selid = $_GET['selid'];
                                                        $ridgetsql = "SELECT * FROM usertbl WHERE id = '$selid'";
                                                        $ridquery = mysqli_query($conn, $ridgetsql);
                                                        $ridrows =  mysqli_num_rows($ridquery);
                                                       
                                                        if ($ridrows > 0) {
                                                          $resultnotif1 = mysqli_fetch_assoc($ridquery);
                                                            $clk_id = $resultnotif1['id'];
                                                            $clk_fname = $resultnotif1['first_name'];
                                                            $clk_lname = $resultnotif1['last_name'];
                                                            $clk_mnum = $resultnotif1['mobile_number'];
                                                            $clk_email = $resultnotif1['email'];
                                                            $clk_utype = $resultnotif1['user_type'];
                                                            $clk_pass = $resultnotif1['password'];
                                                            $clk_yr = $resultnotif1['year'];
                                                            $clk_sec = $resultnotif1['section'];
                                                            $clk_subjects = $resultnotif1['subjects'];
                                                          }
                                                        }
                                                    $vis = "";
                                                    if(isset($_POST['user_searchbtn'])){
                                                        
                                                            $vis = "show";
                                                            $search = mysqli_real_escape_string($conn, $_POST['user_search']);
                                                            $sql = "SELECT * FROM usertbl WHERE id LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR mobile_number LIKE '%$search%' OR year LIKE '%$search%' OR section LIKE '%$search%' OR subjects LIKE '%$search%' OR user_type LIKE '%$search%'";
                                                            $result = mysqli_query($conn, $sql);
                                                            $qresults = mysqli_num_rows($result);

                                                            if ($qresults > 0) {
                                                                while($resultUser = mysqli_fetch_assoc($result)){
                                                                    echo '<tr style="display:' . $vis . '" onclick="window.location=\'delete-admin.php?selid=' . $resultUser['id'] . '\'">';
                                                                    echo '<td>' . $resultUser['id'] . '</td>';
                                                                    echo '<td>' . $resultUser['first_name'] . ' ' . $resultUser['last_name'] . '</td>';
                                                                    echo '<td>' . $resultUser['mobile_number'] . '</td>';
                                                                    echo '<td>' . $resultUser['email'] . '</td>';
                                                                    echo '<td>' . $resultUser['user_type'] . '</td>';
                                                                    echo '<td>' . $resultUser['year'] . ' ' . $resultUser['section'] . '</td>';
                                                                    echo '<td>' . $resultUser['subjects'] . '</td>';
                                                                    echo '</tr>';
                                                                }
                                                            } else { 
                                                                echo "<script>alert('NO ROOM FOUND')</script>"; 
                                                            }
                                                        } 
                                                    if(isset($_POST['user_sortbtn'])){
                                                        $sort = mysqli_real_escape_string($conn, $_POST['user_sort']);
                                                        if ($sort == "ALL") {
                                                            $vis = "show";
                                                            $sql = "SELECT * FROM usertbl";
                                                            $result = mysqli_query($conn, $sql);
                                                        } else {
                                                            $vis = "show";
                                                            $sql = "SELECT * FROM usertbl WHERE user_type = '$sort'";
                                                            $result = mysqli_query($conn, $sql);
                                                        }
                                                    
                                                        if ($result) {
                                                            while($resultUser = mysqli_fetch_assoc($result)){
                                                                echo '<tr style="display:' . $vis . '" onclick="window.location=\'delete-admin.php?selid=' . $resultUser['id'] . '\'">';
                                                                echo '<td>' . $resultUser['id'] . '</td>';
                                                                echo '<td>' . $resultUser['first_name'] . ' ' . $resultUser['last_name'] . '</td>';
                                                                echo '<td>' . $resultUser['mobile_number'] . '</td>';
                                                                echo '<td>' . $resultUser['email'] . '</td>';
                                                                echo '<td>' . $resultUser['user_type'] . '</td>';
                                                                echo '<td>' . $resultUser['year'] . ' ' . $resultUser['section'] . '</td>';
                                                                echo '<td>' . $resultUser['subjects'] . '</td>';
                                                                echo '</tr>';
                                                            }
                                                        } else {
                                                            echo "<script>alert('No users found');</script>";
                                                        }
                                                    }
                                                    if (!isset($_POST['user_searchbtn']) && !isset($_POST['user_sortbtn'])){
                                                        $sqlUser = "SELECT * FROM usertbl";
                                                        $queryUser = mysqli_query($conn, $sqlUser);

                                                        while($resultUser = mysqli_fetch_assoc($queryUser)){
                                                            echo '<tr style="display:' . $vis . '" onclick="window.location=\'delete-admin.php?selid=' . $resultUser['id'] . '\'">';
                                                            echo '<td>' . $resultUser['id'] . '</td>';
                                                            echo '<td>' . $resultUser['first_name'] . ' ' . $resultUser['last_name'] . '</td>';
                                                            echo '<td>' . $resultUser['mobile_number'] . '</td>';
                                                            echo '<td>' . $resultUser['email'] . '</td>';
                                                            echo '<td>' . $resultUser['user_type'] . '</td>';
                                                            echo '<td>' . $resultUser['year'] . ' ' . $resultUser['section'] . '</td>';
                                                            echo '<td>' . $resultUser['subjects'] . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                    ?>

                                                    </tbody>
                                                </table>
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
                                                <form action="read-admin.php" method="post">
                                                    <!-- Search Input Group -->
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" name="room_search" type="text" placeholder="Search rooms...">
                                                        <button class="btn btn-primary" name="room_searchbtn" type="submit">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Sort Input Group -->
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="room_sort">
                                                            <option value="ALL">ALL</option>
                                                            <option value="CCL">CCL</option>
                                                            <option value="DCS">DCS</option>
                                                            <option value="Not_Occupied">Not Occupied</option>
                                                            <option value="Occupied">Occupied</option>
                                                        </select>
                                                        <button class="btn btn-primary" name="room_sortbtn" type="submit">
                                                            <i class="fa-solid fa-sort"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                                <table style="cursor:pointer;" class="table table-bordered table-hover text-center">
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
                                                    $clk_rid = '';
                                                    $clk_proffname = '';
                                                    $clk_proflname = '';
                                                    $clk_rtype = '';
                                                    $clk_rnum = '';
                                                    $clk_stime = '';
                                                    $clk_endtime = '';
                                                    $clk_day = array();
                                                    $clk_status = '';
                                                    $clk_comb = '';
                                                    $clk_year = '';
                                                    $clk_section = '';
                                                    $clk_attend = '';
                                                    $clk_dont = '';
                                                    $clk_madeby = '';
                                                    $clk_madeat = '';
                                                    if (isset($_GET['selrid'])) {
                                                        $selrid = $_GET['selrid'];
                                                        $ridgetsql = "SELECT * FROM roomtbl WHERE sched_code = '$selrid'";
                                                        $ridquery = mysqli_query($conn, $ridgetsql);
                                                        $ridrows =  mysqli_num_rows($ridquery);
                                                        
                                                        if ($ridrows > 0) {
                                                          $resultroom1 = mysqli_fetch_assoc($ridquery);
                                                          $clk_rid = $resultroom1['sched_code'];
                                                          $clk_proffname = $resultroom1['prof_fname'];
                                                          $clk_proflname = $resultroom1['prof_lname'];
                                                          $clk_rtype = $resultroom1['room_type'];
                                                          $clk_rnum = $resultroom1['room_num'];
                                                          $clk_stime= $resultroom1['start_time'];
                                                          $clk_endtime = $resultroom1['end_time'];
                                                          $days_from_db = $resultroom1['room_day'];
                                                          $days_from_db = trim($days_from_db);
                                                          $clk_day = explode(',', $days_from_db); 
                                                          $clk_status = $resultroom1['status'];
                                                          $clk_comb = $resultroom1['comb'];
                                                          $clk_year = $resultroom1['room_year'];
                                                          $clk_section = $resultroom1['room_section'];
                                                          $clk_attend = $resultroom1['attend'];
                                                          $clk_dont = $resultroom1['not_attend'];
                                                          $clk_madeby = $resultroom1['madeby'];
                                                          $clk_madeat = $resultroom1['made_at'];
                                                          }
                                                        }

                                                    // PHP Code to handle search and sort
                                                    $vis = "show";
                                                    $conditions = array();
                                                    
                                                    if(isset($_POST['room_searchbtn'])) {
                                                        $search = mysqli_real_escape_string($conn, $_POST['room_search']);
                                                        $conditions[] = "(sched_code LIKE '%$search%' OR prof_fname LIKE '%$search%' OR prof_lname LIKE '%$search%' OR room_type LIKE '%$search%' OR room_num LIKE '%$search%' OR start_time LIKE '%$search%' OR end_time LIKE '%$search%' OR room_day LIKE '%$search%' OR status LIKE '%$search%' OR room_section LIKE '%$search%' OR room_year LIKE '%$search%')";
                                                    }
                                                    
                                                    if(isset($_POST['room_sortbtn'])) {
                                                        $sort = mysqli_real_escape_string($conn, $_POST['room_sort']);
                                                        if ($sort != "ALL") {
                                                            // Depending on the selected sort option, add conditions
                                                            if ($sort == "CCL" || $sort == "DCS") {
                                                                $conditions[] = "room_type = '$sort'";
                                                            } elseif ($sort == "Occupied" || $sort == "Not_Occupied") {
                                                                $conditions[] = "status = '$sort'";
                                                            }
                                                        } 
                                                    }
                                                    
                                                    $sql = "SELECT * FROM roomtbl";
                                                    if (count($conditions) > 0) {
                                                        $sql .= " WHERE " . implode(' AND ', $conditions);
                                                    }
                                                    
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    if ($result) {
                                                        while($resultRoom = mysqli_fetch_assoc($result)){
                                                            echo '<tr class="room-row" style="display:' . $vis . '" onclick="window.location=\'delete-admin.php?selrid=' . $resultRoom['sched_code'] . '\'">';
                                                            echo '<td>' . $resultRoom['sched_code'] . '</td>';
                                                            echo '<td>' . $resultRoom['prof_fname'] . ' ' . $resultRoom['prof_lname'] . '</td>';
                                                            echo '<td>' . $resultRoom['start_time'] . '</td>';
                                                            echo '<td>' . $resultRoom['room_type'] . ' ' . $resultRoom['room_num'] . '</td>';
                                                            echo '<td>' . $resultRoom['end_time'] . '</td>';
                                                            echo '<td>' . $resultRoom['room_day'] . '</td>';
                                                            echo '<td>' . $resultRoom['status'] . '</td>';
                                                            echo '<td>' . $resultRoom['room_year'] . ' ' . $resultRoom['room_section'] . '</td>';
                                                            echo '<td>' . $resultRoom['attend'] . '</td>';
                                                            echo '<td>' . $resultRoom['not_attend'] . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        echo "<script>alert('No rooms found');</script>";
                                                    }
                                                    
                                                    // Default view if no search or sort is applied
                                                    if (!isset($_POST['room_searchbtn']) && !isset($_POST['room_sortbtn'])) {
                                                        $sql = "SELECT * FROM roomtbl";
                                                        $result = mysqli_query($conn, $sql);
                                                    
                                                        while($resultRoom = mysqli_fetch_assoc($result)){
                                                            echo '<tr class="room-row" style="display:' . $vis . '" onclick="window.location=\'delete-admin.php?selrid=' . $resultRoom['sched_code'] . '\'">';
                                                            echo '<td>' . $resultRoom['sched_code'] . '</td>';
                                                            echo '<td>' . $resultRoom['prof_fname'] . ' ' . $resultRoom['prof_lname'] . '</td>';
                                                            echo '<td>' . $resultRoom['start_time'] . '</td>';
                                                            echo '<td>' . $resultRoom['room_type'] . ' ' . $resultRoom['room_num'] . '</td>';
                                                            echo '<td>' . $resultRoom['end_time'] . '</td>';
                                                            echo '<td>' . $resultRoom['room_day'] . '</td>';
                                                            echo '<td>' . $resultRoom['status'] . '</td>';
                                                            echo '<td>' . $resultRoom['room_year'] . ' ' . $resultRoom['room_section'] . '</td>';
                                                            echo '<td>' . $resultRoom['attend'] . '</td>';
                                                            echo '<td>' . $resultRoom['not_attend'] . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4" id="selected-user-div">
                                    <div class="card-header">
                                        <i class="far fa-address-card"></i>
                                            Selected User
                                        </div>
                                    <div class="card-body text-center">
                                    <h4><?php echo $clk_fname . ' ' . $clk_lname; ?></h4>
                                            <p>User type: <?php echo $clk_utype; ?></p>
                                            <div class="input-group d-flex justify-content-center">
                                                <img src="cvsulogo.png" class="rounded-circle" style="width: 150px; height: 150px;" alt="User Image">
                                            </div>
                                            <div class="card mt-5 mb-4">
                                                <div class="card-header">
                                                    Details of the user
                                                </div>
                                                    <form action="delete-admin.php?selid=<?php echo $selid; ?>" method="post">
                                                        <h5 class="text-center">Create a User Window</h5>
                                                        <div class="form-group row justify-content-center">
                                                            <div class="col-md-4 text-center">
                                                                <label class="col-form-label">
                                                                    <i class="far fa-id-card"></i> First Name
                                                                </label>
                                                                <input class="form-control text-center" type="text" name="first_name" value="<?php echo $clk_fname; ?>">
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <label class="col-form-label">
                                                                    <i class="fas fa-id-card-alt"></i> Last Name
                                                                </label>
                                                                <input class="form-control text-center" type="text" name="last_name" value="<?php echo $clk_lname; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row justify-content-center">
                                                            <div class="col-md-4 text-center">
                                                                <label class="col-form-label">
                                                                    <i class="fa-solid fa-phone"></i> Mobile Number
                                                                </label>
                                                                <input class="form-control text-center" name="mobile_number" type="phone" value="<?php echo $clk_mnum; ?>">
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <label class="col-form-label">
                                                                    <i class="fa-solid fa-envelope"></i> Email
                                                                </label>
                                                                <input class="form-control text-center" name="email" type="email" value="<?php echo $clk_email; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row justify-content-center">
                                                            <div class="col-md-4 text-center">
                                                                <label class="col-form-label">
                                                                    <i class="fa-solid fa-user-gear"></i> User Type
                                                                </label>
                                                                <select class="form-control text-center" name="user_type" type="text" id="user_type" onchange="toggleSectionInput()">
                                                                    <option value="<?php echo $clk_utype; ?>"><?php echo $clk_utype; ?></option>
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
                                                                        <option value="<?php echo $clk_yr; ?>"><?php echo $clk_yr; ?></option>
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
                                                                        <option value="<?php echo $clk_sec; ?>"><?php echo $clk_sec; ?></option>
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
                                                                <input class="form-control text-center" name="password" type="password" value="<?php echo $clk_pass; ?>" id="inputPassword">
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
                                                            <button class="btn btn-danger mt-4 mb-5" type="submit" style="width:150px;" name="delete-user">Delete User</button>
                                                        </div>
                                                    </form>
                                                    <?php
                                                    if (isset($_POST['delete-user'])){
                                                        $_SESSION['confirm_delete_user'] = true; // Set session variable to confirm deletion
                                                        $_SESSION['uid_to_delete'] = $selid; // Store the room ID to be deleted
                                                        echo '<script>';
                                                        echo 'if(confirm("Are you sure you want to delete user ' . $clk_id . '?")) {';
                                                        echo 'window.location.href = "delete_user.php";'; // Redirect to the PHP script for deletion
                                                        echo '} else {';
                                                        echo 'alert("Canceled!");';
                                                        echo '}';
                                                        echo '</script>';
                                                    }
                                                    ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4" id="selected-roon-div">
                                    <div class="card-header">
                                        <i class="fas fa-door-closed"></i>
                                        Selected Room
                                    </div>
                                    <div class="card-body text-center">
                                        <h4>Sched Code: <?php echo $clk_rid; ?></h4>
                                        <p>Room: <?php echo $clk_rtype . ' ' . $clk_rnum; ?></p>
                                        <div class="input-group d-flex justify-content-center">
                                            <img src="cvsulogo.png" class="rounded-circle" style="width: 150px; height: 150px;" alt="Room Image">
                                        </div>
                                        <div class="card mt-5 mb-4">
                                            <div class="card-header">
                                                <p class="mb-2 h3">Delete Room</p>
                                            </div>
                                            <div class="card-body">
                                                <form action="delete-admin.php?selrid=<?php echo $selrid; ?>" method="post">
                                                    <div class="container m-auto w-100">
                                                    <div class="form-group row justify-content-center">
                                                    <div class="col-md-4 text-center">
                                                        <h5 class="text-center">Prof First Name</h5>
                                                            <input class="form-control text-center" type="text" name="prof_fname" value="<?php echo $clk_proffname; ?>">
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                        <h5 class="text-center">Prof Last Name</h5>
                                                            <input class="form-control text-center mb-2" type="text" name="prof_lname" value="<?php echo $clk_proflname; ?>">
                                                        </div>
                                                    </div>
                                                            <div class="form-group row justify-content-center">
                                                            <div class="col-md-4 text-center">
                                                                <label class="form-label text-center">
                                                                    <i class="fas fa-door-closed"></i> Room Number
                                                                </label>
                                                                <select class="form-control text-center m-auto mb-1" name="room_num" style="width:70px;" value="<?php echo $clk_rnum; ?>" required>
                                                                    <option value="<?php echo $clk_rnum; ?>" selected><?php echo $clk_rnum; ?></option>
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
                                                                    <select class="form-control text-center m-auto mb-1" name="room_type" style="width:100px;" value="<?php echo $clk_rtype; ?>" required>
                                                                        <option value="<?php echo $clk_rtype; ?>" selected><?php echo $clk_rtype; ?></option>
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
                                                                    <input class="form-control text-center m-auto mb-1" name="start_time" type="time" style="width:180px;" value="<?php echo $clk_stime; ?>" required>
                                                                </div>
                                                                <div class="col-md-4 text-center">
                                                                    <label class="form-label text-center">
                                                                        <i class="fa-solid fa-hourglass-end"></i> End
                                                                    </label>
                                                                    <input class="form-control text-center m-auto mb-1" name="end_time" type="time" style="width:180px;" value="<?php echo $clk_endtime; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-4 text-center">
                                                                    <label class="form-label text-center">
                                                                        <i class="fa-solid fas fa-hashtag"></i> Year
                                                                    </label>
                                                                    <select class="form-control text-center m-auto mb-1" name="room_year" style="width:120px;margin-right:10px;" value="<?php echo $clk_year; ?>" required>
                                                                        <option value="<?php echo $clk_year; ?>" selected><?php echo $clk_year; ?></option>
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
                                                                    <select class="form-control text-center m-auto mb-1" name="room_section" style="width:160px;margin-left:10px;" value="<?php echo $clk_section; ?>" required>
                                                                        <option value="<?php echo $clk_section; ?>" selected><?php echo $clk_section; ?></option>
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
                                                                        <option value="<?php echo $clk_status; ?>" selected><?php echo $clk_status; ?></option>
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
                                                                        <li><input type="checkbox" name="room_day[]" value="Monday" <?php if (in_array('Monday', $clk_day)) echo 'checked'; ?>> Monday</li>
                                                                        <li><input type="checkbox" name="room_day[]" value="Tuesday" <?php if (in_array('Tuesday', $clk_day)) echo 'checked'; ?>> Tuesday</li>
                                                                        <li><input type="checkbox" name="room_day[]" value="Wednesday" <?php if (in_array('Wednesday', $clk_day)) echo 'checked'; ?>> Wednesday</li>
                                                                    </ul>
                                                                </div>
                                                                    <div class="col-md-4 text-center">
                                                                    <label class="form-label">
                                                                            <i class="fas fa-calendar"></i> Days
                                                                    </label>
                                                                    <ul style="list-style-type: none;">
                                                                        <li><input type="checkbox" name="room_day[]" value="Thursday" <?php if (in_array('Thursday', $clk_day)) echo 'checked';?>> Thursday</li>
                                                                        <li><input type="checkbox" name="room_day[]" value="Friday" <?php if (in_array('Friday', $clk_day)) echo 'checked'; ?>> Friday</li>
                                                                        <li><input type="checkbox" name="room_day[]" value="Saturday" <?php if (in_array('Saturday', $clk_day)) echo 'checked';?>> Saturday</li>
                                                                    </ul>    
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row justify-content-center mt-5 mb-5">
                                                            <button class="btn btn-danger" type="submit" name="delete-room" style="width:150px;">Delete Room</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <?php
                                                if (isset($_POST['delete-room'])) {
                                                    $_SESSION['confirm_delete'] = true; // Set session variable to confirm deletion
                                                    $_SESSION['rid_to_delete'] = $selrid; // Store the room ID to be deleted
                                                    echo '<script>';
                                                    echo 'if(confirm("Are you sure you want to delete room ' . $clk_rid . '?")) {';
                                                    echo 'window.location.href = "delete_room.php";'; // Redirect to the PHP script for deletion
                                                    echo '} else {';
                                                    echo 'alert("Canceled!");';
                                                    echo '}';
                                                    echo '</script>';
                                                }
                                                ?>
                                        </div>
                                    </div>
                                </div>
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
