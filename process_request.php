<?php
// process_request.php
include("server.php");

    $sent_by = $_GET['sent_by'];
    $sent_to = $_GET['sent_to'];
    $req_type = $_GET['req_type'];
    $req_title = $_GET['req_title'];
    $req_desc = $_GET['req_desc'];
    

    // Check if confirmation was received via GET method
    if (!empty($req_type) && !empty($req_title) && !empty($req_desc) && !empty($sent_by) && !empty($sent_to)) {
        // Perform the database insertion
        $sql = "INSERT INTO admin_request (sent_to, sent_by, req_type, req_title, req_desc) VALUES ('$sent_to', '$sent_by', '$req_type', '$req_title', '$req_desc')";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Successfully sent the request");window.location.href = "request-teach.php";</script>';
        } else {
            echo '<script>alert("Error: ' . mysqli_error($conn) . '");window.location.href = "request-teach.php";</script>';
        }
    } else {
        echo '<script>alert("Request canceled");window.location.href = "request_teach.php;</script>';
    }

    mysqli_close($conn);
?>
