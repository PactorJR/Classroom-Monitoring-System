<?php
session_start();
include("server.php");
if(isset($_SESSION['confirm_delete_user']) && $_SESSION['confirm_delete_user'] === true) {
    $selid = $_SESSION['uid_to_delete']; // Retrieve the room ID from the session
    unset($_SESSION['confirm_delete_user']); // Unset the session variable
    unset($_SESSION['uid_to_delete']); // Unset the room ID session variable

    $sqldelete = "DELETE FROM usertbl WHERE id = '$selid'";
    if (mysqli_query($conn, $sqldelete)){
        echo '<script>alert("user deleted successfully!");</script>';
    } else {
        echo '<script>alert("Error deleting user!");</script>';
    }
    echo '<script>window.location.href = "delete-admin.php";</script>'; // Close the window after deletion
} else {
    echo '<script>alert("Confirmation not received.");</script>'; // Handle case where confirmation wasn't received
}
?>
