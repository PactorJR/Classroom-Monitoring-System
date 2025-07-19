<?php
session_start();
include("server.php");

if(isset($_SESSION['confirm_delete']) && $_SESSION['confirm_delete'] === true) {
    $selrid = $_SESSION['rid_to_delete']; // Retrieve the room ID from the session
    unset($_SESSION['confirm_delete']); // Unset the session variable
    unset($_SESSION['rid_to_delete']); // Unset the room ID session variable

    // Delete the corresponding room
    $sqldelete = "DELETE FROM roomtbl WHERE sched_code = '$selrid'";
    $sql_drop_table = "DROP TABLE IF EXISTS `" . $selrid . "`";
    if (mysqli_query($conn, $sqldelete) && mysqli_query($conn, $sql_drop_table)){
        echo '<script>alert("Room and Table deleted successfully!");</script>';
    } else {
        echo '<script>alert("Error deleting room!");</script>';
    }
    
    echo '<script>window.location.href = "delete-admin.php";</script>'; // Redirect after deletion
} else {
    echo '<script>alert("Confirmation not received.");</script>'; // Handle case where confirmation wasn't received
}
?>