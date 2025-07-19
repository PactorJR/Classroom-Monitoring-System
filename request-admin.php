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
            <h1 class="mt-4">Request Form</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="home-admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Request Form</li>
            </ol>
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Users Full Detailed Table
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="request-admin.php" method="post">
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
                                            <option value="Room Request">Room Request</option>
                                            <option value="Subject Request">Subject Request</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <button class="btn btn-primary" name="user_sortbtn" type="submit">
                                            <i class="fa-solid fa-sort"></i>
                                        </button>
                                    </div>
                                </form>
                                <table style="cursor:pointer;" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Request ID</th>
                                            <th>Sent To</th>
                                            <th>Sent By</th>
                                            <th>Request Type</th>
                                            <th>Request Title</th>
                                            <th>Request Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $clk_id = '';
                                    $clk_to = '';
                                    $clk_by = '';
                                    $clk_type = '';
                                    $clk_title = '';
                                    $clk_desc = '';
                                    if (isset($_GET['selreq'])) {
                                        $selreq = $_GET['selreq'];
                                        $ridgetsql = "SELECT * FROM admin_request WHERE id = '$selreq'";
                                        $ridquery = mysqli_query($conn, $ridgetsql);
                                        $ridrows =  mysqli_num_rows($ridquery);
                                        
                                        if ($ridrows > 0) {
                                            $resultnotif1 = mysqli_fetch_assoc($ridquery);
                                            $clk_id = $resultnotif1['id'];
                                            $clk_to = $resultnotif1['sent_to'];
                                            $clk_by = $resultnotif1['sent_by'];
                                            $clk_type = $resultnotif1['req_type'];
                                            $clk_title = $resultnotif1['req_title'];
                                            $clk_desc = $resultnotif1['req_desc'];
                                            }
                                        }
                                    $vis = "";
                                    if(isset($_POST['user_searchbtn'])){
                                        
                                            $vis = "show";
                                            $search = mysqli_real_escape_string($conn, $_POST['user_search']);
                                            $sql = "SELECT * FROM admin_request WHERE id LIKE '%$search%' OR sent_to LIKE '%$search%' OR sent_by LIKE '%$search%' OR req_type LIKE '%$search%' OR req_title LIKE '%$search%' OR year LIKE '%$search%' OR req_desc LIKE '%$search%'";
                                            $result = mysqli_query($conn, $sql);
                                            $qresults = mysqli_num_rows($result);

                                            if ($qresults > 0) {
                                                while($resultUser = mysqli_fetch_assoc($result)){
                                                    echo '<tr style="display:' . $vis . '" onclick="window.location=\'request-admin.php?selreq=' . $resultUser['id'] . '\'">';
                                                    echo '<td>' . $resultUser['id'] . '</td>';
                                                    echo '<td>' . $resultUser['sent_to'] . '</td>';
                                                    echo '<td>' . $resultUser['sent_by'] . '</td>';
                                                    echo '<td>' . $resultUser['req_type'] . '</td>';
                                                    echo '<td>' . $resultUser['req_title'] . '</td>';
                                                    echo '<td>' . $resultUser['req_desc'] . '</td>';
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
                                            $sql = "SELECT * FROM admin_request";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $vis = "show";
                                            $sql = "SELECT * FROM admin_request WHERE req_type = '$sort'";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                    
                                        if ($result) {
                                            while($resultUser = mysqli_fetch_assoc($result)){
                                                echo '<tr style="display:' . $vis . '" onclick="window.location=\'request-admin.php?selreq=' . $resultUser['id'] . '\'">';
                                                echo '<td>' . $resultUser['id'] . '</td>';
                                                echo '<td>' . $resultUser['sent_to'] . '</td>';
                                                echo '<td>' . $resultUser['sent_by'] . '</td>';
                                                echo '<td>' . $resultUser['req_type'] . '</td>';
                                                echo '<td>' . $resultUser['req_title'] . '</td>';
                                                echo '<td>' . $resultUser['req_desc'] . '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo "<script>alert('No users found');</script>";
                                        }
                                    }
                                    if (!isset($_POST['user_searchbtn']) && !isset($_POST['user_sortbtn'])){
                                        $sqlUser = "SELECT * FROM admin_request";
                                        $queryUser = mysqli_query($conn, $sqlUser);

                                        while($resultUser = mysqli_fetch_assoc($queryUser)){
                                            echo '<tr style="display:' . $vis . '" onclick="window.location=\'request-admin.php?selreq=' . $resultUser['id'] . '\'">';
                                            echo '<td>' . $resultUser['id'] . '</td>';
                                            echo '<td>' . $resultUser['sent_to'] . '</td>';
                                            echo '<td>' . $resultUser['sent_by'] . '</td>';
                                            echo '<td>' . $resultUser['req_type'] . '</td>';
                                            echo '<td>' . $resultUser['req_title'] . '</td>';
                                            echo '<td>' . $resultUser['req_desc'] . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <?php 
                                    if(mysqli_num_rows($queryUser) == 0) {
                                        echo '<p class="text-center">No users available yet.';
                                    }
                                ?>
                                </div>
                            </div>                           
                        </div>
                    </div>
                    <div class="card mb-4" id="selected-user-div">
                        <div class="card-header">
                            <i class="far fa-address-card"></i>
                                Selected Request
                            </div>
                        <div class="card-body text-center">
                        <h4><?php echo $clk_title ?></h4>
                                <p>Request type: <?php echo $clk_type; ?></p>
                                <div class="input-group d-flex justify-content-center">
                                    <img src="cvsulogo.png" class="rounded-circle" style="width: 150px; height: 150px;" alt="User Image">
                                </div>
                                <div class="card mt-5 mb-4">
                                    <div class="card-header">
                                        Details of the Request
                                    </div>
                                        <div class="card-body">
                                        <div class="card-columns" style="column-count: 2;column-gap: 20px; ">
                                        <p style="margin-top:-2px;margin-bottom:-2px;"> Request ID: <?php echo $clk_id; ?><br></p>
                                        <p style="margin-top:-2px;margin-bottom:-2px;"> Request Type: <?php echo $clk_type; ?><br></p> 
                                        <p style="margin-top:-2px;margin-bottom:-2px;"> Request Title: <?php echo $clk_title; ?><br></p> 
                                        <p style="margin-top:-2px;margin-bottom:-2px;"> Request Description <br></p> 
                                        <?php
                                        if ($clk_type == "Room Request"){
                                            $desc_components = explode(', ', $clk_desc);

                                            if (count($desc_components) == 6) {
                                                $start_time = $desc_components[0];
                                                $end_time = $desc_components[1];
                                                $year = $desc_components[2];
                                                $section = $desc_components[3];
                                                $status = $desc_components[4];
                                                $day = $desc_components[5];
                                            
                                                // Display each component
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">Start Time: ' . $start_time . '<br></p>';
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">End Time: ' . $end_time . '<br></p>';
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">Year: ' . $year . '<br></p>';
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">Section: ' . $section . '<br></p>';
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">Section: ' . $status . '<br></p>';
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">Section: ' . $day . '<br></p>';
                                            } else {
                                                // Handle case where the description format is not as expected
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">Invalid request description format.</p>';
                                            }
                                        } elseif ($clk_type == "Subject Request") {
                                            $desc_components = explode(', ', $clk_desc);

                                            if (count($desc_components) == 3) {
                                                $year_subject = $desc_components[0];
                                                $section_subject = $desc_components[1];
                                                $subject_code = $desc_components[2];

                                            echo '<p style="margin-top: -2px; margin-bottom: -2px;">Subject Name: ' . $clk_title . '<br></p>';
                                            echo '<p style="margin-top: -2px; margin-bottom: -2px;">Subject Code: ' . $subject_code . '<br></p>';
                                            echo '<p style="margin-top: -2px; margin-bottom: -2px;">Subject Year: ' . $year_subject . '<br></p>';
                                            echo '<p style="margin-top: -2px; margin-bottom: -2px;">Subject Section: ' . $subject_code . '<br></p>';
                                            } else {
                                                // Handle case where the description format is not as expected
                                                echo '<p style="margin-top: -2px; margin-bottom: -2px;">Invalid request description format.</p>';
                                            }
                                        } elseif ($clk_type == "Other Request") {
                                            echo '<p style="margin-top: -2px; margin-bottom: -2px;">Request Description: ' . $clk_desc . '<br></p>';
                                        } else {
                                            echo '<p style="margin-top: -2px; margin-bottom: -2px;">Invalid request description format.</p>';
                                        }
                                        ?>
                                        <p style="margin-top: -2px; margin-bottom: -2px;">Sent by: <?php echo $clk_by; ?><br></p> 
                                        <p style="margin-top: -2px; margin-bottom: -2px;">Sent to: <?php echo $clk_to; ?><br></p>
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
