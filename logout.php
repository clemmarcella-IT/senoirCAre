<?php
// 1. Start the session so the computer knows which "pass" to delete
session_start(); 

// 2. Clear all the data saved in the session (like the User ID)
session_unset(); 

// 3. Completely destroy the session
session_destroy(); 

// 4. Send the user back to the login page
header("Location: login.php"); 

// 5. Make sure the code stops here
exit(); 
?>