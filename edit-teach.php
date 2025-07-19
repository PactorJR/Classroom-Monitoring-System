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
    $res_id = $result['id'];
    }
    $sqlroom = "SELECT * FROM roomtbl WHERE madeby = '$id'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $scheduled =  mysqli_num_rows($queryroom);

    $sqlroom = "SELECT * FROM roomtbl WHERE status = 'Later'";
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
        <title>Edit Room</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home-teach.php" >Teacher UI</a>
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
                        <a class="nav-link" href="home-teach.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="home-teach.php" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Features
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="edit-teach.php">Edit Room</a>
                                <a class="nav-link" href="room-status-teach.php">Room Status</a>
                                <a class="nav-link" href="rooms-list-teach.php">Rooms List</a>
                                <a class="nav-link" href="notif-teach.php">Notifications</a>
                                <a class="nav-link" href="studlist-teach.php">Students List</a>
                                <a class="nav-link" href="request-teach.php">Request Form</a>
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
                    <h1 class="mt-4">Edit Room</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="home-teach.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Rooms List</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <p class="mb-2 h3">Edit a Room</p>
                        </div>
                        <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header ">
                                                    <p class="text-center h1">Rooms Created</p>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <?php
                                                                $room_rid = '';
                                                                $room_fname = '';
                                                                $room_lname = '';
                                                                $room_stime= '';
                                                                $room_endtime = '';
                                                                $room_status = '';
                                                                $room_year = '';
                                                                $room_section = '';
                                                                $room_rnum = '';
                                                                $room_rtype = '';
                                                                $room_attend = '';
                                                                $room_not = '';

                                                                    if (isset($_GET['roomrid'])) {
                                                                    $roomrid = $_GET['roomrid'];
                                                                    $ridgetsql = "SELECT * FROM roomtbl WHERE sched_code = '$roomrid'";
                                                                    $ridquery = mysqli_query($conn, $ridgetsql);
                                                                    $ridrows =  mysqli_num_rows($ridquery);
                                                                    
                                                                    if ($ridrows > 0) {
                                                                        $resultnotif1 = mysqli_fetch_assoc($ridquery);
                                                                        $room_rid = $resultnotif1['sched_code'];
                                                                        $room_fname = $resultnotif1['prof_fname'];
                                                                        $room_lname = $resultnotif1['prof_lname'];
                                                                        $room_stime = $resultnotif1['start_time'];
                                                                        $room_endtime = $resultnotif1['end_time'];
                                                                        $room_status = $resultnotif1['status'];
                                                                        $room_section = $resultnotif1['room_section'];
                                                                        $room_year = $resultnotif1['room_year'];
                                                                        $room_rnum = $resultnotif1['room_num'];
                                                                        $room_rtype = $resultnotif1['room_type'];
                                                                        $room_attend = $resultnotif1['attend'];
                                                                        $room_not = $resultnotif1['not_attend'];
                                                                    }
                                                                }
                                                                
                                                                // Handle form submission
                                                                if (isset($_POST['edit'])) {
                                                                    // Retrieve form data
                                                                    $room_stime1 = $_POST['start'];
                                                                    $room_endtime1 = $_POST['end'];
                                                                    $room_status1 = $_POST['roomstatus'];
                                                                    $room_year1 = $_POST['year'];
                                                                    $room_section1 = $_POST['section'];
                                                                    $room_rnum1 = $_POST['roomnum'];
                                                                    $room_rtype1 = $_POST['roomtype'];
                                                                    $room_comb1 = $room_rtype1 . $room_rnum1;
                                                                    $room_attend1 = $_POST['attend'];
                                                                    $room_not1 = $_POST['not'];
                                                                
                                                                    // Update record in the database using $roomrid
                                                                    $update_sql = "UPDATE roomtbl SET 
                                                                        start_time = '$room_stime1', 
                                                                        end_time = '$room_endtime1', 
                                                                        status = '$room_status1', 
                                                                        room_year = '$room_year1', 
                                                                        room_section = '$room_section1', 
                                                                        room_num = '$room_rnum1', 
                                                                        room_type = '$room_rtype1', 
                                                                        comb = '$room_comb1', 
                                                                        attend = '$room_attend1', 
                                                                        not_attend = '$room_not1' 
                                                                        WHERE sched_code = '$roomrid'";
                                                                    
                                                                    $update_query = mysqli_query($conn, $update_sql);
                                                                    
                                                                    if ($update_query) {
                                                                        echo '<script>alert("Successfully Edited the selected class");
                                                                        window.location.href = "edit-teach.php";</script>';
                                                                    } else {
                                                                        echo '<script>alert("Error: Failed to update record")</script>';
                                                                    }
                                                                }

                                                                // Fetch room notifications and display them
                                                                $sqlnotif = "SELECT * FROM roomtbl WHERE madeby = '$id' ORDER BY made_at DESC";
                                                                $querynotif = mysqli_query($conn, $sqlnotif);
                                                                $queryrow = mysqli_num_rows($querynotif);
                                                                
                                                                if ($queryrow == 0) {
                                                                    echo "No Rooms Made Yet.";
                                                                } else {
                                                                    while ($resultnotif = mysqli_fetch_assoc($querynotif)) {
                                                                        // Display room notifications
                                                                        $icon_color = '';
                                                                        if ($resultnotif['status'] == "Not_Occupied") {
                                                                            $icon_color = 'bg-success';
                                                                        } elseif ($resultnotif['status'] == "Occupied") {
                                                                            $icon_color = 'bg-danger';
                                                                        } 
                                                                        echo '<div class="col-md-6 m-auto m">';
                                                                        echo '<div class="card ' . $icon_color . ' p-3 mb-4 mt-4">';
                                                                        echo '<a class="text-center" style="color:black;text-decoration:none;"href="edit-teach.php?roomrid=' . $resultnotif['sched_code'] . '"> Room: ' . $resultnotif['comb'] . ' Year & Section: ' . $resultnotif['room_year'] . ' ' . $resultnotif['room_section'] .'
                                                                        <br>  Start: ' . $resultnotif['start_time'] . ' End: ' . $resultnotif['end_time'] . '
                                                                        <br> Will attend: ' . $resultnotif['attend'] . ' Will NOT attend: ' . $resultnotif['not_attend'] . '
                                                                        <br> Room Status: ' . $resultnotif['status'] . '</a>';
                                                                        echo '</div>';
                                                                        echo '</div>';
                                                                    }
                                                                }
                                                                    ?>
                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                            <div class="card-header">
                                                    <p class="text-center h1">Room Selected</p>
                                                    <div class="card">
                                                    <div class="card-header">
                                                    <form action="edit-teach.php?roomrid=<?php echo $roomrid; ?>" method="post">
                                                        <div class="container m-auto">
                                                        <h3 class="text-center">Professor : <?php echo $room_fname . " " . $room_lname; ?></h3>
                                                        <div class="form-group row justify-content-center">
                                                        <label style="font-size:25px;" class="col-form-label text-center" type="text"><i class="fas fa-door-closed"></i>Room Number </label><br>
                                                        <select style="font-size:25px;width:70px;" class="text-center m-auto" name="roomnum" required>
                                                            <option value="<?php echo $room_rnum; ?>" select><?php echo $room_rnum; ?></option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                        </select><br>
                                                        <label style="font-size:25px;" class="text-center mb-2" type="text"><i class="fas fa-door-closed"></i>Room Type </label><br>
                                                        <select style="font-size:25px;width:100px;" class="select select2" name="roomtype" required>
                                                            <option value="<?php echo $room_rtype; ?>" select><?php echo $room_rtype; ?></option>
                                                            <option value="CCL">CCL</option>
                                                            <option value="DCS">DCS</option>
                                                        </select><br>
                                                        <label style="font-size:25px;" class="text-center mb-2" name="start" id="start" type="text"><i class="fa-solid fa-hourglass-start"></i>Start</label><br>
                                                        
                                                        <input style="font-size:25px;width:180px;" class="text-center mb-2" for="label3" name="start" id="start" type="time" value="<?php echo $room_stime; ?>" required></input><br>
                                                        <label style="font-size:25px;" class="text-center mb-2" name="end" id="end" type="text"><i class="fa-solid fa-hourglass-end"></i>End</label><br>
                                                        
                                                        <input style="font-size:25px;width:180px;" class="text-center mb-2" name="end" id="end" type="time" value="<?php echo $room_endtime; ?>" required></input><br>
                                                        <label style="font-size:25px;" class="text-center mb-2" name="section" id="section" type="text"><i class="fa-solid fas fa-hashtag"></i>Year Section</label><br>
                                                        <select style="font-size:25px;width:120px;margin-right:10px;" class="select select2" name="year" required>
                                                            <option class="text-center" value="<?php echo $room_year; ?>" select><?php echo $room_year; ?></option>
                                                            <option class="text-center" value="1st">1st</option>
                                                            <option class="text-center" value="2nd">2nd</option>
                                                            <option class="text-center" value="3rd">3rd</option>
                                                            <option class="text-center" value="4th">4th</option>
                                                        </select><br>
                                                        <select style="font-size:25px;width:160px;margin-left:10px;" class="select select2" name="section" required>
                                                            <option class="text-center" value="<?php echo $room_section; ?>" select><?php echo $room_section; ?></option>
                                                            <option class="text-center" value="Section_A">Section A</option>
                                                            <option class="text-center" value="Section_B">Section B</option>
                                                            <option class="text-center" value="Section_C">Section C</option>
                                                            <option class="text-center" value="Section_D">Section D</option>
                                                            <option class="text-center" value="Section_E">Section E</option>
                                                        </select><br>
                                                        <label style="font-size:25px;" class="col-form-label text-center" type="text"><i class="fas fa-exclamation" style="margin-right:10px;"></i>Room Status </label><br>
                                                        <select style="font-size:25px;width:220px;" class="col-form-label text-center" name="roomstatus" required>
                                                            <option value="<?php echo $room_status; ?>" select><?php echo $room_status; ?></option>
                                                            <option value="Occupied">Occupied</option>
                                                            <option value="Not_Occupied">Not Occupied</option>
                                                        </select><br>
                                                        </div>
                                                        
                                                        <div class="form-group row justify-content-center">
                                                            <div class="col-md-2 m-auto text-center">
                                                                <label style="font-size:25px;" class="text-center mb-5" name="section" id="section" type="text">Attending</label><br>
                                                                <input style="font-size:25px;width:50px" class="text-center mb-4" value="<?php echo $room_attend; ?>" name="attend" type="text" required>
                                                            </div>
                                                            <div class="col-md-2 m-auto text-center">
                                                                <label style="font-size:25px;" class="m-auto mb-3" name="section" id="section" type="text">Not Attending</label><br>
                                                                <input style="font-size:25px;width:50px" class="text-center mb-4" value="<?php echo $room_not; ?>" name="not" type="text" required>
                                                            </div>
                                                            <div class="form-group row justify-content-center">
                                                            <button style="font-size:25px;width:80px;" class="btn btn-warning" type="submit" name="edit" id="edit">Edit</button>
                                                            </div>
                                                        </form>
                                                        <form action="room-status-teach.php?roomrid=<?php echo $roomrid; ?>" method="post">
                                                            <div class="form-group row justify-content-center">
                                                            <button style="font-size:25px;width:170px;margin-top:50px;margin-bottom:50px;" class="btn btn-primary" type="submit" name="view" id="edit">Attendance</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    
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
        <script src="js/scripts.js"></script>
    </body>
</html>
