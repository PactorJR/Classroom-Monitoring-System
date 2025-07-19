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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Request Form</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const requestTypeSelect = document.getElementById('request_type');
            const requestRoomDiv = document.getElementById('request_room');
            const requestSubjectDiv = document.getElementById('request_subject');
            const requestOtherDiv = document.getElementById('request_other');

            // Hide all divs initially
            requestRoomDiv.style.display = 'none';
            requestSubjectDiv.style.display = 'none';
            requestOtherDiv.style.display = 'none';

            requestTypeSelect.addEventListener('change', function() {
                const value = requestTypeSelect.value;

                requestRoomDiv.style.display = value === 'Room' ? 'block' : 'none';
                requestSubjectDiv.style.display = value === 'Subject' ? 'block' : 'none';
                requestOtherDiv.style.display = value === 'Other' ? 'block' : 'none';
            });
        });
    </script>
    <body class="sb-nav-fixed">
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home-teach.php" >Teacher UI</a>
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
                        <h1 class="mt-4">Request Form</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="home-teach.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Request Form</li>
                        </ol>
                        <div class="card mb-4">
                        <div class="card-header">
                            <p class="mb-2">Request Form</p>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Sort Input Group -->
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <div class="input-group">
                                            <form class="w-100">
                                                <select class="form-control text-center" id="request_type" name="request_type" style="font-size: 24px; height: 60px;" required>
                                                    <option value="">Request Type..</option>
                                                    <option value="Room">Request for new room</option>
                                                    <option value="Subject">Request for new subject</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="d-none d-md-inline-block mt-2 w-100" action="request-teach.php" method="post">
                            <div class="card mb-4" id="request_room">
                            <select class="form-control text-center" id="sent_to" name="sent_to"required>
                                <option value="">To Whom..</option>
                                <option value="Admin">Admin</option>
                                <option value="Super_Admin">Super Admin</option>
                            </select>
                                <div class="card-header">
                                    <h2 class="text-center mt-2">User Requesting: <?php echo $res_fname . ' ' . $res_lname ?></h2>
                                    <input type="hidden" name="prof_fname" value="<?php echo $res_fname ?>"></input>
                                    <input type="hidden" name="prof_lname" value="<?php echo $res_lname ?>"></input>
                                    <input type="hidden" name="req_type" value="Room Request"></input>
                                </div>
                                    <div class="container m-auto">
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
                                            <option class="text-center" value="<?php echo $room_year; ?>" select><?php echo $room_year; ?></option required>
                                            <option class="text-center" value="1st">1st</option>
                                            <option class="text-center" value="2nd">2nd</option>
                                            <option class="text-center" value="3rd">3rd</option>
                                            <option class="text-center" value="4th">4th</option>
                                        </select><br>
                                        <select style="font-size:25px;width:160px;margin-left:10px;" class="select select2" name="section" required>
                                            <option class="text-center" value="<?php echo $room_section; ?>" select><?php echo $room_section; ?></option required>
                                            <option class="text-center" value="Section_A">Section A</option>
                                            <option class="text-center" value="Section_B">Section B</option>
                                            <option class="text-center" value="Section_C">Section C</option>
                                            <option class="text-center" value="Section_D">Section D</option>
                                            <option class="text-center" value="Section_E">Section E</option>
                                        </select><br>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <button style="font-size:25px;width:140px;" class="btn btn-primary mt-5 mb-5" type="submit" name="request_room" id="request">Request</button>
                                        </div>
                                        <?php
                                            if (isset($_POST['request_room'])){
                                                    $sent_to = filter_input(INPUT_POST, "sent_to", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $sent_by = $res_fname . ' ' . $res_lname;
                                                    $req_type = filter_input(INPUT_POST, "req_type", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $roomnum = filter_input(INPUT_POST, "roomnum", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $roomtype = filter_input(INPUT_POST, "roomtype", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $start = filter_input(INPUT_POST, "start", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $end = filter_input(INPUT_POST, "end", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $year = filter_input(INPUT_POST, "year", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $section = filter_input(INPUT_POST, "section", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $req_title = $roomtype . ' ' . $roomnum;
                                                    $req_desc = $start . ', ' . $end . ', ' . $year . 'year , ' . $section;
                                                    
                                                    echo '<script>';
                                                    echo 'if(confirm("Are you sure you\'d like to send this request?")) {';
                                                    echo '  alert("Successfully sent the request");'; // Show success alert first
                                                    echo '  window.location.href = "process_request.php?req_type=' . urlencode($req_type) . '&req_title=' . urlencode($req_title) . '&req_desc=' . urlencode($req_desc) . '&sent_by=' . urlencode($sent_by) . '&sent_to=' . urlencode($sent_to) . '";'; // Redirect to process_request.php
                                                    echo '} else {';
                                                    echo '  alert("Request canceled");'; // Show cancellation alert
                                                    echo '}';
                                                    echo '</script>';
                                                }
                                        ?>
                                </form> 
                                </div>
                            </div>
                            <form class="d-none d-md-inline-block mt-2 w-100" action="request-teach.php" method="post">                  
                            <div class="card mb-4" id="request_subject">
                            <select class="form-control text-center" id="sent_to" name="sent_to"required>
                                <option value="">To Whom..</option>
                                <option value="Admin">Admin</option>
                                <option value="Super_Admin">Super Admin</option>
                            </select>
                                <div class="card-header">
                                    <h2 class="text-center mt-2">User Requesting: <?php echo $res_fname . ' ' . $res_lname ?></h2>
                                </div>
                                    <div class="container m-auto">
                                        <div class="form-group row justify-content-center mb-5">
                                        <input type="hidden" name="req_type_subject" value="Subject Request"></input>
                                        <label style="font-size:25px;" class="col-form-label text-center" type="text">Subject Name</label><br>
                                        <input type="text" class="col-form-label text-center" style="font-size:25px;width:200px;height:45px" name="subject_name"></input><br>

                                        <label style="font-size:25px;" class="text-center mb-2" type="text">Subject Code</label><br>
                                        <input type="text" class="col-form-label text-center" style="font-size:25px;width:200px;height:45px" name="subject_code"></input><br>

                                        <label style="font-size:25px;" class="text-center mb-2" name="section" id="section" type="text">Year Section</label><br>
                                        <select style="font-size:25px;width:120px;margin-right:10px;" class="select select2" name="year_subject" required>
                                            <option class="text-center" value="<?php echo $room_year; ?>" select><?php echo $room_year; ?></option>
                                            <option class="text-center" value="1st">1st</option>
                                            <option class="text-center" value="2nd">2nd</option>
                                            <option class="text-center" value="3rd">3rd</option>
                                            <option class="text-center" value="4th">4th</option>
                                        </select><br>
                                        <select style="font-size:25px;width:160px;margin-left:10px;" class="select select2" name="section_subject" required>
                                            <option class="text-center" value="<?php echo $room_section; ?>" select><?php echo $room_section; ?></option>
                                            <option class="text-center" value="Section_A">Section A</option>
                                            <option class="text-center" value="Section_B">Section B</option>
                                            <option class="text-center" value="Section_C">Section C</option>
                                            <option class="text-center" value="Section_D">Section D</option>
                                            <option class="text-center" value="Section_E">Section E</option>
                                        </select><br>
                                        </div>
                                        <div class="form-group row justify-content-center">
                                            <button style="font-size:25px;width:140px;" class="btn btn-primary mb-5" type="submit" name="request_subject" id="request">Request</button>
                                        </div>
                                        <?php
                                            if (isset($_POST['request_subject'])){
                                                    $sent_to = filter_input(INPUT_POST, "sent_to", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $sent_by = $res_fname . ' ' . $res_lname;
                                                    $req_type = filter_input(INPUT_POST, "req_type_subject", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $subject_name = filter_input(INPUT_POST, "subject_name", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $subject_code = filter_input(INPUT_POST, "subject_code", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $year_subject = filter_input(INPUT_POST, "year_subject", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $section_subject = filter_input(INPUT_POST, "section_subject", FILTER_SANITIZE_SPECIAL_CHARS);
                                                    $req_title = $subject_name . ' ' . $subject_code;
                                                    $req_desc = $year_subject . 'year , ' . $section_subject . $section;
                                                    
                                                    echo '<script>';
                                                    echo 'if(confirm("Are you sure you\'d like to send this request?")) {';
                                                    echo '  alert("Successfully sent the request");'; // Show success alert first
                                                    echo '  window.location.href = "process_request.php?req_type=' . urlencode($req_type) . '&req_title=' . urlencode($req_title) . '&req_desc=' . urlencode($req_desc) . '&sent_by=' . urlencode($sent_by) . '&sent_to=' . urlencode($sent_to) . '";'; // Redirect to process_request.php
                                                    echo '} else {';
                                                    echo '  alert("Request canceled");'; // Show cancellation alert
                                                    echo '}';
                                                    echo '</script>';
                                                }
                                        ?>   
                            </form>                         
                                </div>
                            </div>
                            <form class="d-none d-md-inline-block mt-2 w-100" action="request-teach.php" method="post">
                            <div class="card mb-4" id="request_other">
                                <select class="form-control text-center" id="sent_to" name="sent_to"required>
                                    <option value="">To Whom..</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Super_Admin">Super Admin</option>
                                </select>
                                <div class="card-header">
                                    <h2 class="text-center mt-2">User Requesting: <?php echo $res_fname . ' ' . $res_lname ?></h2>
                                </div>
                                <div class="container m-auto">
                                    <div class="form-group row justify-content-center mb-5">
                                    <input type="hidden" name="req_type_other" value="Other Request"></input>
                                        <label style="font-size:25px;" class="col-form-label text-center" type="text">About</label>
                                        <input type="text" class="col-form-label text-center" style="font-size:25px;width:500px;height:50px;" name="about"></input>
                                        <label style="font-size:25px;" class="col-form-label text-center" type="text">Reason </label>
                                        <input type="text" class="col-form-label text-top text-left" style="font-size:20px;width:500px;height:250px;" name="reason"></input>
                                    </div>
                                    <div class="form-group row justify-content-center">
                                        <button style="font-size:25px;width:140px;" class="btn btn-primary mb-5" type="submit" name="request_other" id="request">Request</button>
                                    </div>
                                    <?php
                                        if (isset($_POST['request_other'])){
                                                $sent_to = filter_input(INPUT_POST, "sent_to", FILTER_SANITIZE_SPECIAL_CHARS);
                                                $sent_by = $res_fname . ' ' . $res_lname;
                                                $req_type = filter_input(INPUT_POST, "req_type_other", FILTER_SANITIZE_SPECIAL_CHARS);
                                                $req_title = filter_input(INPUT_POST, "about", FILTER_SANITIZE_SPECIAL_CHARS);
                                                $req_desc = filter_input(INPUT_POST, "reason", FILTER_SANITIZE_SPECIAL_CHARS);
                                                
                                                echo '<script>';
                                                echo 'if(confirm("Are you sure you\'d like to send this request?")) {';
                                                echo '  alert("Successfully sent the request");'; // Show success alert first
                                                echo '  window.location.href = "process_request.php?req_type=' . urlencode($req_type) . '&req_title=' . urlencode($req_title) . '&req_desc=' . urlencode($req_desc) . '&sent_by=' . urlencode($sent_by) . '&sent_to=' . urlencode($sent_to) . '";'; // Redirect to process_request.php
                                                echo '} else {';
                                                echo '  alert("Request canceled");'; // Show cancellation alert
                                                echo '}';
                                                echo '</script>';
                                            }
                                    ?> 
                                </form>
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
