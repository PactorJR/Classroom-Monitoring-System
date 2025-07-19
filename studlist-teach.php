<?php
session_start();

    include("server.php");

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
      $res_id = $result['id'];
      }
    }

    $sqlroom = "SELECT * FROM roomtbl WHERE madeby = '$id'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $scheduled =  mysqli_num_rows($queryroom);

    $sqlroom = "SELECT * FROM roomtbl WHERE status = 'Later'";
    $queryroom = mysqli_query($conn, $sqlroom);
    $available =  mysqli_num_rows($queryroom);
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Students List</title>
        <script src="js/scripts.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="home-teach.php">Teacher UI</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
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
                    <h1 class="mt-4">Students List</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="home-teach.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Students List</li>
                    </ol>  
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Students List
                                </div>
                                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                                    <div class="container-fluid">
                                        <form class="d-none d-md-inline-block mt-2 w-100" action="studlist-teach.php" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <select class="form-control" name="usersort">
                                                            <option value="ALL">ALL</option>
                                                            <option value="1st">1st</option>
                                                            <option value="2nd">2nd</option>
                                                            <option value="3rd">3rd</option>
                                                            <option value="4th">4th</option>
                                                            <option value="Section_A">Section A</option>
                                                            <option value="Section_B">Section B</option>
                                                            <option value="Section_C">Section C</option>
                                                            <option value="Section_D">Section D</option>
                                                            <option value="Section_E">Section E</option>
                                                        </select>
                                                        <button class="btn btn-primary" name="sortbtn" id="btnNavbarSearch" type="submit">
                                                            <i class="fa-solid fa-sort"></i>
                                                        </button>
                                                    </div>
                                                </div>
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
                                <div class="card-body">
                                    <table class="datatable-table text-center">
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
                                            $clk_id="";
                                            $clk_fname="";
                                            $clk_lname="";
                                            $clk_mnum="";
                                            $clk_email="";
                                            $clk_utype="";
                                            $clk_pass="";
                                            $clk_uid="";
                                            $clk_year="";
                                            $clk_section="";
                                            $clk_subjects="";
                                            $responsive="";
                                            $selid = "";
                                            $vis = "";
                                            if(isset($_POST['searchbtn'])){
                                                if ($_POST['search'] !== ''){
                                                $vis = "show";
                                                $search = mysqli_real_escape_string($conn, $_POST['search']);
                                                $sql = "SELECT * FROM usertbl WHERE user_type = 'Student' AND (id LIKE '%$search%' OR year LIKE '%$search%' OR section LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR subjects LIKE '%$search%')";
                                                $result = mysqli_query($conn, $sql);
                                                $qresults = mysqli_num_rows($result);
                                                echo '<div class="ad-div"><h4>There is/are ' .$qresults. ' result(s)!</h4></div>';
                                                if ($qresults > 0) {
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        if ($row['user_type'] != 'Teacher'){
                                                        echo '<tbody style="' . $vis . '">';
                                                        echo '<tr onclick="window.location=\'studlist-teach.php?selid=' . $row['id'] . '\'">';
                                                        echo '<td>' . $row['id'] . '</td>';
                                                        echo '<td>' . $row['first_name'] . ' ' . $row['last_name']  . '</td>';
                                                        echo '<td>' . $row['year']  . '</td>';
                                                        echo '<td>' . $row['section'] . '</td>';
                                                        echo '<td>' . $row['subjects'] . '</td>';
                                                        echo '</tr>';
                                                        } else {
                                                            echo "<script>alert('NO STUDENT FOUND')</script>"; 
                                                        }
                                                }
                                                } else { 
                                                    echo "<script>alert('NO STUDENT FOUND')</script>"; 
                                                }
                                            } else {
                                                echo "<script>alert('Must input something first!')</script>"; 
                                            }
                                        }
                                            if(isset($_POST['sortbtn'])){
                                                if ($_POST['usersort'] === "ALL" && !isset($_POST['searchbtn'])) {
                                                    $vis = "show";
                                                    $sqlroom = "SELECT * FROM usertbl WHERE user_type = 'Student'";
                                                $queryroom = mysqli_query($conn, $sqlroom);
                                                $queryrow =  mysqli_num_rows($queryroom);
                                                if($queryrow == 0) {
                                                    echo "No Students Available Yet.";
                                                } else {
                                                    while($resultuser1 = mysqli_fetch_assoc($queryroom)){
                                                    $user_id = $resultuser1['id'];
                                                    $user_fname = $resultuser1['first_name'];
                                                    $user_lname = $resultuser1['last_name'];
                                                    $user_section = $resultuser1['section'];
                                                    $user_year = $resultuser1['year'];
                                                    $user_subjects = $resultuser1['subjects'];
                                                    echo '<tbody style="' . $vis . '">';
                                                    echo '<tr onclick="window.location=\'studlist-teach.php?selid=' . $user_id . '\'">';
                                                    echo '<td>' . $user_id . '</td>';
                                                    echo '<td>' . $user_fname . ' ' . $user_lname . '</td>';
                                                    echo '<td>' . $user_year. '</td>';
                                                    echo '<td>' . $user_section. '</td>';
                                                    echo '<td>' . $user_subjects. '</td>';
                                                    echo '</tr>';
                                                    }
                                                }
                                            
                                                   
                                                } else {
                                                    $vis = "show";
                                                    $search = mysqli_real_escape_string($conn, $_POST['usersort']);
                                                    $sql = "SELECT * FROM usertbl WHERE user_type = 'Student' AND (id LIKE '%$search%' OR year LIKE '%$search%' OR section LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR subjects LIKE '%$search%')";
                                                    $result = mysqli_query($conn, $sql);
                                                    $qresults = mysqli_num_rows($result);
                                                    echo '<div class="ad-div"><h4>There is/are ' .$qresults. ' result(s)!</h4></div>';
                                                    if ($qresults > 0) {
                                                        while($row = mysqli_fetch_assoc($result)) {
                                                            echo '<tbody style="' . $vis . '">';
                                                            echo '<tr onclick="window.location=\'studlist-teach.php?selid=' . $row['id'] . '\'">';
                                                            echo '<td>' . $row['id'] . '</td>';
                                                            echo '<td>' . $row['first_name'] . ' ' . $row['last_name']  . '</td>';
                                                            echo '<td>' . $row['year']  . '</td>';
                                                            echo '<td>' . $row['section'] . '</td>';
                                                            echo '<td>' . $row['subjects'] . '</td>';
                                                            echo '</tr>';
                                                    }
                                                    } else { 
                                                        echo "<script>alert('NO STUDENT FOUND')</script>"; 
                                                    }
                                                }
                                            }

                                            if (!isset($_POST['searchbtn']) && !isset($_POST['sortbtn'])) {
                                                $vis = "";
                                                $sqlroom = "SELECT * FROM usertbl WHERE user_type = 'Student'";
                                                $queryroom = mysqli_query($conn, $sqlroom);
                                                $queryrow =  mysqli_num_rows($queryroom);
                                                if($queryrow == 0) {
                                                    echo "No Students Available Yet.";
                                                } else {
                                            while($resultuser1 = mysqli_fetch_assoc($queryroom)){
                                            $user_id = $resultuser1['id'];
                                            $user_fname = $resultuser1['first_name'];
                                            $user_lname = $resultuser1['last_name'];
                                            $user_section = $resultuser1['section'];
                                            $user_year = $resultuser1['year'];
                                            $user_subjects = $resultuser1['subjects'];
                                            echo '<tbody style="' . $vis . '">';
                                            echo '<tr onclick="window.location=\'studlist-teach.php?selid=' . $user_id . '\'">';
                                            echo '<td>' . $user_id . '</td>';
                                            echo '<td>' . $user_fname . ' ' . $user_lname . '</td>';
                                            echo '<td>' . $user_year. '</td>';
                                            echo '<td>' . $user_section. '</td>';
                                            echo '<td>' . $user_subjects. '</td>';
                                            echo '</tr>';
                                                    }
                                                }
                                            }
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
                                                $clk_section = $resultnotif1['section'];
                                                $clk_year = $resultnotif1['year'];
                                                $clk_subjects = $resultnotif1['subjects'];
                                                }
                                            }
                                            
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-user-alt"></i>
                                    User Selected
                                </div>  
                                    <div class="card-body">
                                        Student ID: <?php echo $clk_id; ?> <br>
                                        <br>
                                        Student Name: <?php echo $clk_fname . ' ' . $clk_lname; ?> <br>
                                        <br>
                                        Year & Section: <?php echo $clk_year .' ' . $clk_section; ?> <br>
                                        <br>
                                        Subjects Enrolled: <?php echo $clk_subjects; 
                                            $ridgetsql = "SELECT * FROM usertbl WHERE id = '$selid'";
                                            $ridquery = mysqli_query($conn, $ridgetsql);
                                            $ridrows =  mysqli_num_rows($ridquery);
                                            if ($ridrows > 0) {
                                                $resultnotif1 = mysqli_fetch_assoc($ridquery);
                                                $clk_subjects = $resultnotif1['subjects'];
                                                if ($clk_subjects == ''){
                                                    echo 'Not enrolled to any subjects yet.';   
                                                }
                                            }
                                            
                                        ?> <br>
                                        <form action="studlist-teach.php?selid=<?php echo $selid; ?>" method="post">
                                            <select style="font-size:15px;width:130px" class="text-center mb-4" name="assign_subj" type="text" required>
                                                <option value=""></option>
                                                <option value=" DCIT21">DCIT 21</option>
                                                <option value=" DCIT22">DCIT 22</option>
                                                <option value=" DCIT24">DCIT 24</option>
                                                <option value=" DCIT25">DCIT 25</option>
                                                <option value=" ITEC50">ITEC 50</option>
                                                <option value=" ITEC55">ITEC 55</option>
                                                <option value=" ITEC60">ITEC 60</option>
                                                <option value=" ITEC65">ITEC 65</option>
                                                <option value=" ITEC70">ITEC 70</option>
                                                <option value=" INSY55">INSY 55</option>
                                            </select><br>
                                            <button style="font-size:20;width:80px" class="btn btn-primary" type="submit" name="assign">Assign</button>
                                        </form>
                                        <?php
                                            if (isset($_POST['assign'])) {
                                                $ass_subj = $_POST['assign_subj'];
                                                $selid = $_GET['selid'];
                                                
                                                // Fetch current subjects assigned to the user
                                                $check_sql = "SELECT subjects FROM usertbl WHERE id = '$selid'";
                                                $check_result = mysqli_query($conn, $check_sql);
                                                
                                                if ($check_result) {
                                                    $row = mysqli_fetch_assoc($check_result);
                                                    $current_subjects = $row['subjects'];
                                                    
                                                    if (!empty($current_subjects)) {
                                                        $subjects_array = explode(',', $current_subjects);
                                                        
                                                        if (in_array($ass_subj, $subjects_array)) {
                                                            echo '<script>alert("The subject is already assigned to the selected student."); window.location.href = "studlist-teach.php";</script>';
                                                        } else {
                                                            // Append new subject to existing subjects
                                                            $new_subjects = $current_subjects . ' ' . $ass_subj;
                                                            
                                                            // Update the user's subjects
                                                            $update_sql = "UPDATE usertbl SET subjects = '$new_subjects' WHERE id = '$selid'";
                                                            $update_query = mysqli_query($conn, $update_sql);
                                                            
                                                            if ($update_query) {    
                                                                echo '<script>alert("Successfully assigned a new class to the selected student"); window.location.href = "studlist-teach.php";</script>';
                                                            } else {
                                                                echo '<script>alert("Error: Failed to update record")</script>';
                                                            }
                                                        }
                                                    } else {
                                                        // No subjects currently assigned, just use the new subject
                                                        $new_subjects = $ass_subj;
                                                        
                                                        // Update the user's subjects
                                                        $update_sql = "UPDATE usertbl SET subjects = '$new_subjects' WHERE id = '$selid'";
                                                        $update_query = mysqli_query($conn, $update_sql);
                                                        
                                                        if ($update_query) {
                                                            echo '<script>alert("Successfully assigned a new class to the selected student"); window.location.href = "studlist-teach.php";</script>';
                                                        } else {
                                                            echo '<script>alert("Error: Failed to update record")</script>';
                                                        }
                                                    }
                                                } else {
                                                    echo '<script>alert("Error: Failed to fetch current subjects")</script>';
                                                }
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
