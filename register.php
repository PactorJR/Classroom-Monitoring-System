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
        <title>Register - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form action="register.php" method="post">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" name="first_name" type="text" placeholder="Enter your first name" required/>
                                                        <label for="inputFirstName">First name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" name="last_name" type="text" placeholder="Enter your last name" required/>
                                                        <label for="inputLastName">Last name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required/>
                                                <label for="inputEmail">Email Address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputmobnum" name="mobile_number" type="tel" maxlength="11" placeholder="Enter your number" required/>
                                                        <label for="inputmobnum">Mobile Number</label>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-control" id="user_type" name="user_type" onchange="toggleSectionInput()" required>
                                                            <option value="">Choose User Type</option>
                                                            <option value="Student">Student</option>
                                                            <option value="Teacher">Teacher</option>
                                                          </select>
                                                        <label for="user_type">User Type</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0" id="yearFields">
                                                        <select class="form-control" id="year" name="year" onchange="toggleSectionInput()" required>
                                                            <option value="" required>Choose Year Number</option>
                                                            <option value="1st">1st</option>
                                                            <option value="2nd">2nd</option>
                                                            <option value="3rd">3rd</option>
                                                            <option value="4th">4th</option>
                                                          </select>
                                                        <label for="year">Year</label>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0" id="sectionFields">
                                                        <select class="form-control" id="section" name="section" onchange="toggleSectionInput()" required>
                                                            <option value="" required>Choose Section</option>
                                                            <option value="Section_A">Section A</option>
                                                            <option value="Section_B">Section B</option>
                                                            <option value="Section_C">Section C</option>
                                                            <option value="Section_D">Section D</option>
                                                            <option value="Section_E">Section E</option>
                                                          </select>
                                                        <label for="section">Section</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" oninput="validatePassword()" required />
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" name="conf_pass" type="password" placeholder="Confirm password" value="" required oninput="validatePassword()"/>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                        <div id="error-message" class="error-message" style="color:red;display:none;">Passwords do not match</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><a class="btn btn-primary btn-block"><button type="submit" name="login" style="border:none;background-color: transparent;">Create Account</button></a></div>
                                            </div>
                                        </form>
                                        <?php
                                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                            $first_name = $_POST['first_name'];
                                            $last_name = $_POST['last_name'];
                                            $capitalFname = ucfirst($first_name);
                                            $capitalLname = ucfirst($last_name);
                                            $mobile_number = filter_input(INPUT_POST, "mobile_number", FILTER_SANITIZE_SPECIAL_CHARS);
                                            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
                                            $user_type = filter_input(INPUT_POST, "user_type", FILTER_SANITIZE_SPECIAL_CHARS);
                                            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                                            $conf_pass = filter_input(INPUT_POST, "conf_pass", FILTER_SANITIZE_SPECIAL_CHARS);
                                            $section = filter_input(INPUT_POST, "section", FILTER_SANITIZE_SPECIAL_CHARS);
                                            $year = filter_input(INPUT_POST, "year", FILTER_SANITIZE_SPECIAL_CHARS);

                                            if ($conf_pass === $password) {
                                                // Check if email already exists
                                                $check_email_query = "SELECT * FROM usertbl WHERE email = '$email'";
                                                $result = mysqli_query($conn, $check_email_query);
                                                
                                                if (mysqli_num_rows($result) > 0) {
                                                    echo '<script>';
                                                    echo 'alert("The email address is already registered. Please use a different email.");';
                                                    echo 'window.location.href = "/trybootstrap/register.php";';
                                                    echo '</script>';
                                                } else {
                                                    $sql_num = "ALTER TABLE usertbl AUTO_INCREMENT=202400";
                                                    mysqli_query($conn, $sql_num);
                                                    
                                                    $sql = "INSERT INTO usertbl (first_name, last_name, mobile_number, email, user_type, password, section, year) 
                                                            VALUES ('$capitalFname', '$capitalLname', '$mobile_number', '$email', '$user_type', '$password', '$section', '$year')";
                                                    
                                                    if (mysqli_query($conn, $sql)) {
                                                        echo '<script>';
                                                        echo 'if (confirm("You\'ve successfully created an account! Would you like to login now?")) {';
                                                        echo 'window.location.href = "/trybootstrap/login.php";';
                                                        echo '} else {';
                                                        echo 'window.location.href = "register.php";';
                                                        echo '}';
                                                        echo '</script>';
                                                    } else {
                                                        echo '<script>';
                                                        echo 'alert("Error updating database");';
                                                        echo 'window.location.href = "register.php";';
                                                        echo '</script>';
                                                    }
                                                }
                                            } else {
                                                echo '<script>';
                                                echo 'alert("Passwords don\'t match");';
                                                echo 'window.location.href = "/trybootstrap/register.php";';
                                                echo '</script>';
                                            }
                                        }
                                        ?>

                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
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
