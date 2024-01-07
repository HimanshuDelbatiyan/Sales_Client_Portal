<!-- Name: - Himanshu
Student ID:  - 100898751
File name: - dashboard.php
Folder name: - Lab01 -->

<?php
    // Including the database file !
    include "./includes/db.php";
    // Starting the output buffering or
    // Storing the data somewhere until if else statements make sure user is signed in and all required session variables are set     
    ob_start(); 
    // I have buffered the header because it has multiple session variables which must be defined otherwise it will show error.
    include "./includes/header.php"; 

    // If any of session variables are not initialized then the user will be redirected to the sign-in page !
    if(!isset($_SESSION['siggned']) || $_SESSION['siggned'] != true || !isset($_SESSION['userType']))
    {
        // Then redirect the user to the sign-in page !
        header("location: sign-in.php");
    }
    else
    {
        // Else end the flush and display the buffered output to the user !
        ob_flush();
    };
?> 
<h1 class="h2" >Dashboard</h1>
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group mr-2">
    <button class="btn btn-sm btn-outline-secondary">Share</button>
    <button class="btn btn-sm btn-outline-secondary">Export</button>
    </div>
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
    <span data-feather="calendar"></span>
    This week
    </button>
</div>
</div>
<!-- Setting the user name and last time they accessed the dashboard ! -->
<h2>Welcome <?php echo $_SESSION['username'] ?></h2>
<!-- Something still remains ! -->
<p>You were last logged in on <?php echo isset($_SESSION['lastLogin'])?$_SESSION['lastLogin']: "Looks Like It's First Time."?></p>
<br>
<h2>Your Client's List: </h2>
<div class="table-responsive">
    
        <?php
            // Variables
            $perPageResults = 10;
            $rowNumber = 0;
            $totalRecords = 0;
            $records = "";
            $row = "";
            $totalPages = 0;
            $fieldsName = ["ID","First Name", "Last Name", "Phone Number", "Email Address",'Client Logo'];

            // As we are using the "Query String"
            // We are adding the additional information with url of the webpage 
            // Which we are getting here if any otherwise set the $page variable equal to page 1

            // Display the clients table according to the user !
            display_table($fieldsName);
           
    ?>

<?php
    // Including the footer Section !
    include "./includes/footer.php";
?>    
</div>

