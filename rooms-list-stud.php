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
    $res_year = $result['year'];
    $res_id = $result['id'];
    }
    $sqlroom = "SELECT * FROM roomtbl WHERE madeby = '$id'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $scheduled =  mysqli_num_rows($queryroom);

    $sqlroom = "SELECT * FROM roomtbl WHERE status = 'Not_Occupied'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $available =  mysqli_num_rows($queryroom);

    $currentDay= date('l');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Rooms List</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home-stud.php" >Student UI</a>
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
                        <h1 class="mt-4">Rooms List</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="home-stud.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Rooms List</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <p class="mb-2">Rooms Available:</p>
                            </div>
                            <div class="card-body">
                                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                                    <div class="container-fluid">
                                        <form class="d-none d-md-inline-block mt-2 w-100" action="rooms-list-stud.php" method="post">
                                            <div class="row">
                                                <!-- Sort Input Group -->
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <select class="form-control" id="roomtype" name="roomtype">
                                                            <option value="ALL">ALL</option>
                                                            <option value="CCL">CCL</option>
                                                            <option value="DCS">DCS</option>
                                                            <option value="Not_Occupied">Not Occupied</option>
                                                            <option value="Occupied">Occupied</option>
                                                        </select>
                                                        <button class="btn btn-primary" name="sortbtn" id="btnNavbarSearch" type="submit">
                                                            <i class="fa-solid fa-sort"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Search Input Group -->
                                                <div class="col-md-6 text-md-right">
                                                    <div class="input-group">
                                                        <input class="form-control" name="search" type="text" placeholder="Search for...">
                                                        <button class="btn btn-primary" name="searchbtn" id="btnNavbarSearch" type="submit">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </nav>      

                                    <?php
                                    $status = '';
                                    $vis = "";
                                    if (isset($_POST['status'])){
                                        $vis = "show";
                                        $status = $_POST['status'];
                                                echo '<div class="container">';
                                                echo '<div class="row">';   
                                                $sql = "SELECT * FROM roomtbl WHERE status = '$status' AND room_year = '$res_year' AND room_section = '$res_section' AND room_day LIKE '%$currentDay'";
                                                $result = mysqli_query($conn, $sql);
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        // Set the color based on status
                                                        $icon_color = '';
                                                        if ($row['status'] == "Not_Occupied") {
                                                            $icon_color = 'bg-success';
                                                        } elseif ($row['status'] == "Occupied") {
                                                            $icon_color = 'bg-danger';
                                                        } 
                                                    echo '<div class="row col-3" style="display: ' . $vis . '">';
                                                    echo '<div class="card ' . $icon_color . ' mb-4" style="width: 300px; margin-left: 10px;">';
                                                    echo '<div class="card-body">';
                                                    echo '<p class="mb-2" style="text-align: center;">';
                                                    echo 'Schedule Code: ' . $row['sched_code'];
                                                    echo '<br>Room: ' . $row['comb'] . " " . 'Status: ' . $row['status'];
                                                    echo '<br>Start: ' . $row['start_time']  . ' ' . 'End: ' . $row['end_time'];
                                                    echo '<br>By: ' . $row['prof_fname']  . " " . $row['prof_lname'] ;
                                                    echo '</p>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        ?>
                                    <?php
                                    $vis = "";
                                        if(isset($_POST['searchbtn'])){
                                            
                                            $vis = "show";
                                                $search = mysqli_real_escape_string($conn, $_POST['search']);
                                                $sql = "SELECT * FROM roomtbl WHERE room_year = '$res_year' AND room_section = '$res_section' AND room_day LIKE '%$currentDay' AND prof_fname LIKE '%$search%' OR prof_lname LIKE '%$search%' OR room_type LIKE '%$search%' OR room_num LIKE '%$search%' OR comb LIKE '%$search%' OR status LIKE '%$search%'";
                                                $result = mysqli_query($conn, $sql);
                                                $qresults = mysqli_num_rows($result);
                                                echo '<div class="ad-div"><h4>There is/are ' .$qresults. ' result(s)!</h4></div>';
                                                if ($qresults > 0) {
                                                echo '<div class="container">';
                                                echo '<div class="row">';   
                                                if ($qresults > 0) {
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        // Set the color based on status
                                                        $icon_color = '';
                                                        if ($row['status'] == "Not_Occupied") {
                                                            $icon_color = 'bg-success';
                                                        } elseif ($row['status'] == "Occupied") {
                                                            $icon_color = 'bg-danger';
                                                        } 
                                                    echo '<div class="row col-3" style="display: ' . $vis . '">';
                                                    echo '<div class="card ' . $icon_color . ' mb-4" style="width: 300px; margin-left: 10px;">';
                                                    echo '<div class="card-body">';
                                                    echo '<p class="mb-2" style="text-align: center;">';
                                                    echo 'Schedule Code: ' . $row['sched_code'];
                                                    echo '<br>Room: ' . $row['comb'] . " " . 'Status: ' . $row['status'];
                                                    echo '<br>Start: ' . $row['start_time']  . ' ' . 'End: ' . $row['end_time'];
                                                    echo '<br>By: ' . $row['prof_fname']  . " " . $row['prof_lname'] ;
                                                    echo '</p>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                                echo '</div>';
                                                }
                                                } else { 
                                                    echo "<script>alert('NO ROOM FOUND')</script>"; 
                                                }
                                            }

                                        if(isset($_POST['sortbtn'])){
                                            if ($_POST['roomtype'] === "ALL" && !isset($_POST['searchbtn'])) {
                                                $vis = "show";
                                                $queryroom = mysqli_query($conn, "SELECT * FROM roomtbl WHERE room_year = '$res_year' AND room_section = '$res_section' AND room_day LIKE '%$currentDay'");
                                                echo '<div class="container">';
                                                echo '<div class="row">';
                                                while($resultroom = mysqli_fetch_assoc($queryroom)){
                                                    $room_rid = $resultroom['sched_code'];
                                                    $room_fname = $resultroom['prof_fname'];
                                                    $room_lname = $resultroom['prof_lname'];
                                                    $room_stime= $resultroom['start_time'];
                                                    $room_endtime = $resultroom['end_time'];
                                                    $room_status = $resultroom['status'];
                                                    $room_comb = $resultroom['comb'];
                                                    $room_section = $resultroom['room_section'];
                                                    $icon_color = '';
                                                    if ($room_status == "Not_Occupied") {
                                                        $icon_color = 'bg-success';
                                                    } elseif ($room_status == "Occupied") {
                                                        $icon_color = 'bg-danger';
                                                    } 
                                                    echo '<div class="row col-3" style="display: ' . $vis . '">';
                                                    echo '<div class="card ' . $icon_color . ' mb-4" style="width: 300px; margin-left: 10px;">';
                                                    echo '<div class="card-body">';
                                                    echo '<p class="mb-2" style="text-align: center;">';
                                                    echo 'Schedule Code: ' . $room_rid ;
                                                    echo '<br>Room: ' . $room_comb . " " . 'Status: ' . $room_status;
                                                    echo '<br>Start: ' . $room_stime . ' ' . 'End: ' . $room_endtime;
                                                    echo '<br>By: ' . $room_fname . " " . $room_lname;
                                                    echo '</p>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                                echo '</div>';
                                            } else {
                                                $vis = "show";
                                                $search = mysqli_real_escape_string($conn, $_POST['roomtype']);
                                                $sql = "SELECT * FROM roomtbl WHERE room_year = '$res_year' AND room_section = '$res_section' AND room_day LIKE '%$currentDay' AND prof_fname LIKE '%$search%' OR prof_lname LIKE '%$search%' OR room_type LIKE '%$search%' OR room_num LIKE '%$search%' OR comb LIKE '%$search%' OR status LIKE '$search%' ";
                                                $result = mysqli_query($conn, $sql);
                                                $qresults = mysqli_num_rows($result);
                                                echo '<div class="ad-div"><h4>There is/are ' .$qresults. ' result(s)!</h4></div>';
                                                if ($qresults > 0) {
                                                echo '<div class="container">';
                                                echo '<div class="row">';   
                                                if ($qresults > 0) {
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        // Set the color based on status
                                                        $icon_color = '';
                                                        if ($row['status'] == "Not_Occupied") {
                                                            $icon_color = 'bg-success';
                                                        } elseif ($row['status'] == "Occupied") {
                                                            $icon_color = 'bg-danger';
                                                        } 
                                                    echo '<div class="row col-3" style="display: ' . $vis . '">';
                                                    echo '<div class="card ' . $icon_color . ' mb-4" style="width: 300px; margin-left: 10px;">';
                                                    echo '<div class="card-body">';
                                                    echo '<p class="mb-2" style="text-align: center;">';
                                                    echo 'Schedule Code: ' . $row['sched_code'];
                                                    echo '<br>Room: ' . $row['comb'] . " " . 'Status: ' . $row['status'];
                                                    echo '<br>Start: ' . $row['start_time']  . ' ' . 'End: ' . $row['end_time'];
                                                    echo '<br>By: ' . $row['prof_fname']  . " " . $row['prof_lname'] ;
                                                    echo '</p>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                                echo '</div>';
                                                }
                                                } else { 
                                                    echo "<script>alert('NO ROOM FOUND')</script>"; 
                                                }
                                            }
                                        }

                                        if (!isset($_POST['status']) && !isset($_POST['searchbtn']) && !isset($_POST['sortbtn'])) {
                                            $vis = "show";
                                            $queryroom = mysqli_query($conn, "SELECT * FROM roomtbl WHERE room_year = '$res_year' AND room_section = '$res_section' AND room_day LIKE '%$currentDay'");
                                            $queryrow = mysqli_num_rows($queryroom);
                                            if($queryrow == 0) {
                                                echo "No Rooms Available Yet.";
                                            } else {
                                                echo '<div class="container">';  
                                                echo '<div class="row">';
                                                while($resultroom = mysqli_fetch_assoc($queryroom)){
                                                    $room_rid = $resultroom['sched_code'];
                                                    $room_fname = $resultroom['prof_fname'];
                                                    $room_lname = $resultroom['prof_lname'];
                                                    $room_stime= $resultroom['start_time'];
                                                    $room_endtime = $resultroom['end_time'];
                                                    $room_status = $resultroom['status'];
                                                    $room_comb = $resultroom['comb'];
                                                    $room_section = $resultroom['room_section'];
                                                    $icon_color = '';
                                                    if ($room_status == "Not_Occupied") {
                                                        $icon_color = 'bg-success';
                                                    } elseif ($room_status == "Occupied") {
                                                        $icon_color = 'bg-danger';
                                                    } 
                                                    echo '<div class="row col-3" style="display: ' . $vis . '">';
                                                    echo '<div class="card ' . $icon_color . ' mb-4" style="width: 300px; margin-left: 10px;">';
                                                    echo '<div class="card-body">';
                                                    echo '<p class="mb-2" style="text-align: center;">';
                                                    echo 'Schedule Code: ' . $room_rid ;
                                                    echo '<br>Room: ' . $room_comb . " " . 'Status: ' . $room_status;
                                                    echo '<br>Start: ' . $room_stime . ' ' . 'End: ' . $room_endtime;
                                                    echo '<br>By: ' . $room_fname . " " . $room_lname;
                                                    echo '</p>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        ?>
                                        </form>
                                                </p>
                    
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
