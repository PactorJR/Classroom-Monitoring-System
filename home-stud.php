<?php
session_start();
    $res_id = '';
    $res_utype = '';
    $res_email = '';
    $res_lname = '';
    $res_fname = '';
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
    $currentDay= date('l');

    include("server.php");
    $current_time = date('H:i');
    $tempOccupied = "Occupied";
    $tempNotOccupied = "Not_Occupied";
    $id = $_SESSION['id'];
    $query = mysqli_query($conn, "SELECT * FROM usertbl WHERE id = '$id'");
    if(mysqli_num_rows($query) == 0) {
      echo "None";
    } else {
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
    }
    $sqlroom = "SELECT * FROM roomtbl WHERE room_section = '$res_section' AND room_year = '$res_year' AND room_day LIKE '%$currentDay' AND status = '$tempOccupied'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $on_going =  mysqli_num_rows($queryroom);

    $sqlroom = "SELECT * FROM roomtbl WHERE room_section = '$res_section' AND room_year = '$res_year' AND room_day LIKE '%$currentDay'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $rooms_number =  mysqli_num_rows($queryroom);

    $sqlroom = "SELECT * FROM roomtbl WHERE room_section = '$res_section' AND room_year = '$res_year' AND room_day LIKE '%$currentDay' AND status = '$tempNotOccupied'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $upcoming =  mysqli_num_rows($queryroom);

    $sqlroom = "SELECT * FROM roomtbl WHERE room_section = '$res_section' AND room_year = '$res_year' AND seen = 0 AND room_day LIKE '%$currentDay'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $notification =  mysqli_num_rows($queryroom);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Student Home</title>
        <script src="js/scripts.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="home-stud.php" >Student Home</a>
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
                        <li><p class="dropdown-item">Welcome <?php echo $res_fname?></p></li>
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
                            <a class="nav-link" href="home-stud.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="home-stud.php" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Features
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="notif-stud.php">Notifications</a>
                                    <a class="nav-link" href="rooms-list-stud.php">Room List</a>
                                    <a class="nav-link" href="rooms-status-stud.php">Room Status</a>
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="col-xl-3 col-md-6 mx-auto">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <img src="cvsulogo.png" class="rounded-circle" style="width: 100px; height: 100px;" alt="User Image">
                                    </div>
                                    <div class="col-9">
                                        <p>User: <?php echo $res_fname . " " . $res_lname; ?></p>
                                        <p style="margin-top: -15px;">User Email: <?php echo $res_email ?></p>
                                        <p style="margin-top: -15px;">User type: <?php echo $res_utype ?></p>
                                        <p style="margin-top: -15px;">User ID: <?php echo $res_id ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="profile-stud.php">View Profile</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Schedule: <?php echo $rooms_number; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="rooms-list-stud.php">View More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Upcoming Schedule: <?php echo $upcoming; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <form id="statusForm" action="rooms-list-stud.php" method="POST">
                                        <input type="hidden" name="status" value="Not_Occupied">
                                        <a class="small text-white stretched-link" href="#" onclick="document.getElementById('statusForm').submit();">View More</a>
                                    </form>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">On going Schedule: <?php echo $on_going; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <form id="statusForms" action="rooms-list-stud.php" method="POST">
                                        <input type="hidden" name="status" value="Occupied">
                                        <a class="small text-white stretched-link" href="#" onclick="document.getElementById('statusForms').submit();">View More</a>
                                    </form>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-dark text-white mb-4">
                                    <div class="card-body">Notifications: <?php echo $notification; ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="notif-stud.php">View More</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Schedule Today: <?php echo $currentDay; ?>
                            </div>
                            <div class="card-body text-center">
                                <table class="datatable-table">
                                    <thead >
                                        <tr class="text-center">
                                            <th class="text-center">Schedule Code</th>
                                            <th class="text-center">Teacher Name</th>
                                            <th class="text-center">Start Time</th>
                                            <th class="text-center">Room</th>
                                            <th class="text-center">End Time</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Year & Section</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
                                        $sqlroom = "SELECT * FROM roomtbl WHERE room_section = '$res_section' AND room_year = '$res_year' ORDER BY made_at DESC";
                                        $queryroom = mysqli_query($conn, $sqlroom);
                                        
                                    
                                        while($resultroom = mysqli_fetch_assoc($queryroom)){
                                        $room_rid = $resultroom['sched_code'];
                                        $room_fname = $resultroom['prof_fname'];
                                        $room_lname = $resultroom['prof_lname'];
                                        $room_stime= $resultroom['start_time'];
                                        $room_endtime = $resultroom['end_time'];
                                        $room_status = $resultroom['status'];
                                        $room_section = $resultroom['room_section'];
                                        $room_comb = $resultroom['comb'];
                                        echo '<tr>';
                                        echo '<td>' . $room_rid . '</td>';
                                        echo '<td>' . $room_fname . ' ' . $room_lname . '</td>';
                                        echo '<td>' . $room_comb . '</td>';
                                        echo '<td>' . $room_stime . '</td>';
                                        echo '<td>' . $room_endtime . '</td>';
                                        echo '<td>' . $room_status. '</td>';
                                        echo '<td>' . $room_section. '</td>';
                                        echo '</tr>';
                                    }
                                    
                                    ?>
                                    </tbody>
                                    
                                </table>
                                <?php 
                                    if(mysqli_num_rows($queryroom) == 0) {
                                        echo "No rooms available yet.";
                                      }
                                ?>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
