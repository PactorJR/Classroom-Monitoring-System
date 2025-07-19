<?php
session_start();

include("server.php");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="login.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <a class="btn btn-primary"><button type="submit" name="login" style="border:none;background-color: transparent;">Login</button></a>
                                            </div>
                                        </form>
                                        <?php 
                                            
                                            $row = "";
                                            $email = "";
                                            $password = "";
                                            
                                            if(isset($_POST['login'])){
                                                    $email = mysqli_real_escape_string($conn,$_POST['email']);
                                                    $password = mysqli_real_escape_string($conn,$_POST['password']);
                                                    $result = mysqli_query($conn,"SELECT * FROM usertbl WHERE email='$email' AND password='$password' ") or die("Select Error");
                                                    $row = mysqli_fetch_assoc($result);
                                                
                                                if(is_array($row) && !empty($row)){
                                                    $_SESSION['id'] = $row['id'];
                                                    $_SESSION['first_name'] = $row['first_name'];
                                                    $_SESSION['last_name'] = $row['last_name'];
                                                    $_SESSION['mobile_number'] = $row['mobile_number'];
                                                    $_SESSION['email'] = $row['email'];
                                                    $_SESSION['user_type'] = $row['user_type'];
                                                    $_SESSION['password'] = $row['password'];
                                                    $_SESSION['section'] = $row['section'];
                                                    $_SESSION['year'] = $row['year'];
                                                    echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
                                                }else{
                                                    echo '<script>alert("Wrong Email or Password!");window.location.href = "login.php";</script>';
                                                }
                                            if(isset($_SESSION['email'])){
                                                if ($row['user_type'] == "Student"){
                                                    echo '<script>alert("Welcome ' . $row['first_name'] . " " . $row['last_name'] . '");window.location.href = "home-stud.php";</script>';

                                                    }
                                                }
                                            if(isset($_SESSION['email'])){
                                                if ($row['user_type'] == "Teacher"){
                                                    echo '<script>alert("Welcome ' . $row['first_name'] . " " . $row['last_name'] . '");window.location.href = "home-teach.php";</script>';
                                                    }
                                                }
                                            if(isset($_SESSION['email'])){
                                                    if ($row['user_type'] == "Admin"){
                                                        echo '<script>alert("Welcome ' . $row['first_name'] . " " . $row['last_name'] . '");window.location.href = "home-admin.php";</script>';
                                                    }             
                                                }    
                                            }     
                                        ?>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
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