<!-- Name: - Himanshu
Student ID:  - 100898751
File name: - logout.php
Folder name: - Lab01 -->

<?php
 
    session_start(); // Start the Session !

    // If any of session variable is not initialized then the user will be redirected to the sign-in page.
    if(!isset($_SESSION['siggned']) || $_SESSION['siggned'] != true || !isset($_SESSION['userType']) )
    {
        // Then redirect the user to the sign-in page !
        header("location: sign-in.php");
    }
    else
    {
        // Open the file as Stream !
        $file = fopen("DATA_log.txt", 'a');

        // Write data into the file !
        fwrite($file,"User ID: '".$_SESSION['userEmail']."'Log out on ".date("y-m-d").' at '.date('h:i:sa'));
        fwrite($file, "\n");

        session_unset(); // Session all variables are destroyed

        session_destroy(); // session is destroyed !
        
        // Shows the Sign-in Navbar after destroying sessions and all that !
        include "./includes/header.php";
    }
?>

<!-- A Message to the user  -->
<div class="alert alert-success form-signin" role="alert">
  <h4 class="alert-heading">Logged Out</h4>
  <p><i>You have Successfully Logged out. </i></p>
  <hr>
  <p class="mb-0">Thanks for Visiting.</p>
</div>


<?php
    // Including the Footer File !
    include "./includes/footer.php";
?>    