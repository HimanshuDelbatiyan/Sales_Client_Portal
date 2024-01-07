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
    if(!isset($_SESSION['siggned']) || $_SESSION['siggned'] != true || !isset($_SESSION['userType']) || $_SESSION['userType'] != "A")
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

<!-- Changing the State of the User at the server and Database ! -->
<?php

    //Variables
    $postedStatus = "";
    $showSuccess = false;
    $salesPersonName = "";


    // 
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        foreach ($_POST as $key => $value) 
        {
            // Extracting the user ID
            $userString = explode("_",$key);

            $postedStatus = $value; // Updated Status of the User !

            $Updating_status = pg_execute(db_connect(),"update_status",[$postedStatus,$userString[0]]);

            $infoSalesPerson = pg_execute(db_connect(),"sales_info",[$userString[0]]);

            $assoc = pg_fetch_assoc($infoSalesPerson);

            $salesPersonName = $assoc['first_name']." ".$assoc['last_name']." ";

            if($updateStatus)
            {
                $showSuccess = true;
            }
        }
    }



?>

</div>
<h2><b>Salespeople's List: </b></h2>
<h5>For Admin's Only.</h5>
<div class="table-responsive">

        
        <?php
            if($showSuccess)
            {
                
                $message = '<div class="alert alert-success" role="alert">
                <b>Success:</b> Sales Person <b>'.$salesPersonName.' </b> Status has been set to '.$postedStatus.'. <br><br><br> ';

                if($postedStatus == "inactive")
                {
                    
                    $message .= '<b>Note:</b> User will not be able to logged In.';
                }
                else
                {
                    $message .= '<b>Note:</b> User will be able to logged In.';
                }

                $message .= '</div>';

                echo $message;
            }
            // Variables
            $perPageResults = 10;
            $rowNumber = 0;
            $totalRecords = 0;
            $records = "";
            $row = "";
            $totalPages = 0;
            $fieldsName = ["ID","Email","First Name", "Last Name", "Phone Number", "Status"];

            // As we are using the "Query String"
            // We are adding the additional information with url of the webpage 
            // Which we are getting here if any otherwise set the $page variable equal to page 1

            // Display the clients table according to the user !
            display_table_control_sales($fieldsName);
    ?>
<?php
    // Including the footer Section !
    include "./includes/footer.php";
?>    
</div>


