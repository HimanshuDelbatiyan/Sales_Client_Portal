<!-- -- Name: - Himanshu
-- Student ID:   - 100898751
-- file name: - resetPass.sql
-- Folder name: - Lab04 -->


<?php
    // Including the db.php file !
    include "./includes/db.php";

    // Including the functions file
    include "./functions.php";

    // Again, i have buffered the header file because it again has some session variables which need to be initialized.
    ob_start();

    // Including the header File !
    include "./includes/header.php";

    // If any of session variable is not initialized then the user will be redirected to the sign-in page.
    if(!isset($_SESSION['siggned']) || $_SESSION['siggned'] != true || !isset($_SESSION['userType']))
    {
        // Then redirect the user to the sign-in page !
        header("location: sign-in.php");
    }
    else
    {
        // Else end the flush and display the buffered output to the user !
        ob_flush();
    }


    
    // Declaring an Array of Associative Array !
    $arrayAssocArray = array 
    (
        array
        ( 
            'type' => 'password',
            'name' =>  'newPassword',
            'value' =>  '',
            'label' =>  'New Password'
        ),
        array
        ( 
            'type' => 'password',
            'name' =>  'confirmPassword',
            'value' =>  '',
            'label' =>  'Confirm Password'
        )
    );

    // Variables
    $newPassword = "";
    $confirmPassword = "";
    $isValid = true;

    // Error Message: -
    $showErrorEmpty = false;
    $showErrorMatch = false;
    $updateSuccess = false;
    $wrongExistPass = false;

  
    // If submit method is post !
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $newPassword = trim($_POST['newPassword']);
        $confirmPassword = trim($_POST['confirmPassword']);

        // Some Validations !
        if(empty($newPassword) || empty ($newPassword))
        {
            $isValid = false;
            $showErrorEmpty = true;
        }
        else if($newPassword != $confirmPassword)
        {
            $isValid = false;
            $showErrorMatch = true;
        }


        if($isValid)
        {
            // Hashing the password using the password bcrypt !
            $hashedPassword = password_hash($confirmPassword,PASSWORD_BCRYPT);

            // Updating the Password in the Records !
            if(pg_execute(db_connect(), "Update_Password",[$hashedPassword, $_SESSION['userType'] == 'A'? $_SESSION['id'] : $_SESSION['salesperson_id']]))
            {
                $updateSuccess = true;
            }
        }
    }
?>

<form class="form-signin" action="./resetPass.php" method="post" >
    <h1 class="h3 mb-3 font-weight-normal text-center"><b>Password Reset</b></h1>
    <?php

        ShowWarning($showErrorEmpty,"None of the field can be left empty");

        ShowWarning($showErrorMatch,"Please enter same password in both fields");
        
        SuccessUpdatesPass($updateSuccess,"Password has been Reset successfully !");


        // Using the function to display the input fields to the user.
        display_form($arrayAssocArray);
        ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset">Reset</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset" onclick="window.location.href=window.location.href">Clear All</button>
</form>

<?php
    // Including the footer file !
    include "./includes/footer.php";
?>  