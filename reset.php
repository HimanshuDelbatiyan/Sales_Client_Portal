<!-- -- Name: - Himanshu
-- Student ID:   - 100898751
-- file name: - salespeople.sql
-- Description: This is the Sign in Page of Sales Client Portal where Email and Password is used to login into the website.
-->


<?php
    // Including the db.php file !
    include "./includes/db.php";

    // Including the functions file
    include "./functions.php";

    // Starting the buffering !
    ob_start();

    // Including the header File !
    include "./includes/header.php";

    // If any of session variable is not initialized then the user will be redirected to the sign-in page.
    if(!isset($_SESSION['siggned']) || $_SESSION['siggned'] != true || !isset($_SESSION['userType']))
    {
        // Then redirect the user to the sign-in page !
        header("location: sign-in.php");
        exit; // No more Content sent to the user
    }
    else
    {}


    
    // Declaring an Array of Associative Array !
    $arrayAssocArray = array 
    (
        array
        ( 
            'type' => 'email',
            'name' =>  'emailReset',
            'value' =>  '',
            'label' =>  'Email'
        )
    );

    // Variables
    $sentEmailTo = "";
    $isValid = true;

    // Error Message: -
    $showErrorEmpty = false;
    $showInvalidEmail = false;
    $updateSuccess = false;
    $emailNotExists = false;

  
    // If submit method is post !
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sentEmailTo = trim($_POST['emailReset']);

        // Some Validations !
        if(empty($sentEmailTo))
        {
            $isValid = false;
            $showErrorEmpty = true;
        }
        else if(!filter_var($sentEmailTo,FILTER_VALIDATE_EMAIL))
        {
            $isValid = false;
            $showInvalidEmail = true;
        }

        // If Everything is fine !
        if($isValid)
        {
            // Checking if the User Email Exist in the data base.
            if($sentEmailTo == $_SESSION['userEmail'])
            {
                header("Location: EmailMessagePasswordUpdate.php");
    
                $_SESSION['emailSent'] = "Yes";
                 // Else end the flush and display the buffered output to the user !
                ob_flush();
            }
            else
            {
                $emailNotExists = true; 
            }
        }
    }
?>

<form class="form-signin" action="./reset.php" method="post" >
    <h1 class="h3 mb-3 font-weight-normal text-center"><b>Password Reset</b></h1>
    <h5><b>Please enter your Email here:</b></h5>
    <?php
        // Some Messages to the user !
        ShowWarning($showErrorEmpty,"None of the field can be left empty");

        ShowWarning($showInvalidEmail,"Please enter a valid Email");
        
        SuccessCreation($updateSuccess,"Password Reset Details has been sent to your Email Successfully");

        ShowWarning($emailNotExists,"Please enter the email you used to register.");
        
        // Using the function to display the input fields to the user.
        display_form($arrayAssocArray);
        ?>
        <h7><b>Note: </b>Reset Details will be sent to this Email.</h7>
        <br>
        <br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sent Mail</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset" onclick="window.location.href=window.location.href">Clear</button>
</form>

<?php
    // Including the footer file !
    include "./includes/footer.php";
?>  
