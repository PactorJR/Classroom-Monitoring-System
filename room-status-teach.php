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
        <title>Room Status</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home-teach.php" >Teacher UI</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" ><i class="fas fa-bars"></i></button>
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
                    <h1 class="mt-4">Room Status</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="home-teach.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Room</li>
                        <li class="breadcrumb-item active">Room Status</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <p class="mb-2 h3">Room Status</p>
                        </div>
                        <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header ">
                                                    <p class="text-center h1">Rooms Available</p>
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <?php
                                                                $room_rid = '';
                                                                $room_fname = '';
                                                                $room_lname = '';
                                                                $room_stime= '';
                                                                $room_endtime = '';
                                                                $room_status = '';
                                                                $room_section = '';
                                                                $room_rnum = '';
                                                                $room_rtype = '';
                                                                $room_attend = '';
                                                                $room_not = '';
                                                                $room_year = '';
                                                                $roomrid = '0';

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
                                                                        echo '<a class="text-center" style="color:black;text-decoration:none;"href="room-status-teach.php?roomrid=' . $resultnotif['sched_code'] . '"> Room: ' . $resultnotif['comb'] . ' Year & Section: ' . $resultnotif['room_year'] . ' ' . $resultnotif['room_section'] .'
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
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <div class="row">
                                                            <div class="col-md-6">
                                                                    <p>Room Code: <?php echo $room_rid; ?></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Status: <?php echo $room_status; ?></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Room Type & Number: <?php echo $room_rtype . ' ' . $room_rnum; ?><br><br>
                                                                        Start: <?php echo $room_stime; ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Year & Section: <?php echo $room_year . ' ' . $room_section; ?><br><br>
                                                                        End: <?php echo $room_endtime; ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Will Attend: <?php echo $room_attend; ?></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Will NOT Attend <?php echo $room_not; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                    <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-6">
                                    <table class="datatable-table text-center">
                                    <div class="card-header">
                                        <p class="text-center h6">Attending</p>
                                    </div>
                                        <thead>
                                            <tr>
                                                <th class="text-center">User ID</th>
                                                <th class="text-center">Full Name</th>
                                                <th class="text-center">Year</th>
                                                <th class="text-center">Section</th>
                                                <th class="text-center">Subjects</th>
                                            </tr>
                                        </thead>
                                        <?php
                                                $sqlroom = "SELECT * FROM `$roomrid` WHERE attend = 1";
                                                $queryroom = mysqli_query($conn, $sqlroom);
                                                
                                                if (!$queryroom) {
                                                    die('');
                                                }
                                                
                                                $queryrow = mysqli_num_rows($queryroom);
                                                if ($queryrow == 0) {
                                                    echo '<p style="text-align:center">No Students Available Yet.</p>';
                                                } else {
                                                    while ($resultuser1 = mysqli_fetch_assoc($queryroom)) {
                                                        $user_id = $resultuser1['stud_id'];
                                                        $user_fname = $resultuser1['stud_fname'];
                                                        $user_lname = $resultuser1['stud_lname'];
                                                        $user_section = $resultuser1['room_section'];
                                                        $user_year = $resultuser1['room_year'];
                                                        $user_subjects = $resultuser1['room_subject'];
                                                        echo '<tbody>';
                                                        echo '<tr onclick="window.location=\'room-status-teach.php?selid=' . $user_id . '\'">';
                                                        echo '<td>' . $user_id . '</td>';
                                                        echo '<td>' . $user_fname . ' ' . $user_lname . '</td>';
                                                        echo '<td>' . $user_year . '</td>';
                                                        echo '<td>' . $user_section . '</td>';
                                                        echo '<td>' . $user_subjects . '</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                            
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            <div class="col-md-6">
                                    <table class="datatable-table text-center">
                                    <div class="card-header">
                                        <p class="text-center h6">Not Attending</p>
                                    </div>
                                        <thead>
                                            <tr>
                                                <th class="text-center">User ID</th>
                                                <th class="text-center">Full Name</th>
                                                <th class="text-center">Year</th>
                                                <th class="text-center">Section</th>
                                                <th class="text-center">Subjects</th>
                                            </tr>
                                        </thead>
                                        <?php
                                                $sqlroom = "SELECT * FROM `$roomrid` WHERE not_attend = 1";
                                                $queryroom = mysqli_query($conn, $sqlroom);
                                                
                                                if (!$queryroom) {
                                                    die('');
                                                }
                                                
                                                $queryrow = mysqli_num_rows($queryroom);
                                                if ($queryrow == 0) {
                                                    echo '<p style="text-align:center">No Students Available Yet.</p>';
                                                } else {
                                                    while ($resultuser1 = mysqli_fetch_assoc($queryroom)) {
                                                        $user_id = $resultuser1['stud_id'];
                                                        $user_fname = $resultuser1['stud_fname'];
                                                        $user_lname = $resultuser1['stud_lname'];
                                                        $user_section = $resultuser1['room_section'];
                                                        $user_year = $resultuser1['room_year'];
                                                        $user_subjects = $resultuser1['room_subject'];
                                                        echo '<tbody>';
                                                        echo '<tr onclick="window.location=\'room-status-teach.php?selid=' . $user_id . '\'">';
                                                        echo '<td>' . $user_id . '</td>';
                                                        echo '<td>' . $user_fname . ' ' . $user_lname . '</td>';
                                                        echo '<td>' . $user_year . '</td>';
                                                        echo '<td>' . $user_section . '</td>';
                                                        echo '<td>' . $user_subjects . '</td>';
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
