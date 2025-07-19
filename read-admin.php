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
                    <h1 class="mt-4">Read Rooms & Users</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="home-admin.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Read Rooms & Users</li>
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
                                                <form action="read-admin.php" method="post">
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
                                                                    echo '<tr style="display:' . $vis . '" onclick="window.location=\'read-admin.php?selid=' . $resultUser['id'] . '\'">';
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
                                                                echo '<tr style="display:' . $vis . '" onclick="window.location=\'read-admin.php?selid=' . $resultUser['id'] . '\'">';
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
                                                            echo '<tr style="display:' . $vis . '" onclick="window.location=\'read-admin.php?selid=' . $resultUser['id'] . '\'">';
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
                                                    $clk_day = '';
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
                                                          $clk_day = $resultroom1['room_day'];
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
                                                            echo '<tr class="room-row" style="display:' . $vis . '" onclick="window.location=\'read-admin.php?selrid=' . $resultRoom['sched_code'] . '\'">';
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
                                                            echo '<tr class="room-row" style="display:' . $vis . '" onclick="window.location=\'read-admin.php?selrid=' . $resultRoom['sched_code'] . '\'">';
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
                                                    <div class="card-body">
                                                    <p style="margin-top:-2px;margin-bottom:-2px;"> User ID: <?php echo $clk_id; ?><br></p>
                                                    <p style="margin-top:-2px;margin-bottom:-2px;"> User Type: <?php echo $clk_utype; ?><br></p> 
                                                    <p style="margin-top:-2px;margin-bottom:-2px;"> First Name: <?php echo $clk_fname; ?><br></p> 
                                                    <p style="margin-top:-2px;margin-bottom:-2px;"> Last Name:  <?php echo $clk_lname; ?><br></p> 
                                                    <p style="margin-top:-2px;margin-bottom:-2px;"> Mobile Number: <?php echo $clk_mnum; ?><br>
                                                    <p style="margin-top:-2px;margin-bottom:-2px;"> Email: <?php echo $clk_email; ?><br> </p> 
                                                    <p style="margin-top:-2px;margin-bottom:-2px;" id="pass">
                                                        Password: 
                                                        <span class="password-container">
                                                            <input style="background-color:transparent;border:none;cursor:default;outline:none;display:inline-block;white-space:nowrap;width:120px;" type="password" value="<?php echo $clk_pass; ?>" id="password-field" readonly>
                                                            <button style="background-color:transparent;border:none;" onclick="togglePassword()">
                                                                <i class="fa fa-eye" id="toggle-icon"></i>
                                                            </button>
                                                        </span>
                                                        <br>

                                                    </div>
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
                                                Room Details
                                            </div>
                                            <div class="card-body">
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Schedule Code: <?php echo $clk_rid; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Room Type & Number: <?php echo $clk_rtype . ' ' . $clk_rnum; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Professor Last Name: <?php echo $clk_proffname; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Professor First Name: <?php echo $clk_proflname; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Start Time: <?php echo $clk_stime; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> End Time: <?php echo $clk_endtime; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Room Day(s): <?php echo $clk_day; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Status: <?php echo $clk_status; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Room Year & Section: <?php echo $clk_year . ' ' . $clk_section; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Attend: <?php echo $clk_attend; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Not Attend: <?php echo $clk_dont; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Made By(User ID): <?php echo $clk_madeby; ?><br></p>
                                                <p style="margin-top:-2px;margin-bottom:-2px;"> Made At: <?php echo $clk_madeat; ?><br></p>
                                            </div>
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
