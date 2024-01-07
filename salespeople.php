<!-- -- Name: - Himanshu
-- Student ID:   - 100898751
-- file name: - salespeople.sql
-- Folder name: - Lab01 -->


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
    if(!isset($_SESSION['siggned']) || $_SESSION['siggned'] != true || !isset($_SESSION['userType']) || $_SESSION['userType'] == 'S')
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
            'type' => 'text',
            'name' =>  'firstName',
            'value' =>  '',
            'label' =>  'First Name'
        ),
        array
        ( 
            'type' => 'text',
            'name' =>  'lastName',
            'value' =>  '',
            'label' =>  'Last Name'
        ),
        array
        ( 
            'type' => 'email',
            'name' =>  'email',
            'value' =>  '',
            'label' =>  'Email'
        ),
        array
        ( 
            'type' => 'number',
            'name' =>  'extension',
            'value' =>  '',
            'label' =>  'Extension'
        ),
        array
        ( 
            'type' => 'password',
            'name' =>  'password',
            'value' =>  '',
            'label' =>  'Password'
        )
    );


    // Variables
    $firstName = "";
    $lastName = "";
    $email = "";
    $extension = "";

        // -- Conditional Variables
    $isValid = true;
    $showErrorEmpty = false;
    $insertQuery = "";
    $exist = "";
    $wrongCredentials = false;
    $showSuccess = false;
    $errorEmailFormat = false;
    $password = ""; 
    $errorNumeric = true;
    $typeSalesPerson = "S";
    $alreadyExists = false;
    

    // If submit method is post !
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Populating the variables
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $extension = $_POST['extension'];
        $password = $_POST['password'];

        // Data Validation !
        if(empty($firstName) || empty($lastName) || empty($email) || empty($extension) || empty($password))
        {
            $isValid = false;
            $showErrorEmpty = true;
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // Server Level Email Verification !
        {
            $isValid = false;
            $errorEmailFormat = true;
        }
        else if(!is_numeric($extension))
        {
            $isValid = false;
            $errorNumeric = true;
        }

        // If everything is good !
        if($isValid)
        {
            $executeSearchQuery = pg_execute(db_connect(),"Search_salesPerson",[$email]);

            if($executeSearchQuery && pg_num_rows($executeSearchQuery) > 0)
            {
                $alreadyExists = true;
            }
            else
            {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Use a different variable for the result of pg_execute
                $result = pg_execute(db_connect(), "insert_salesperson", [$email, $firstName, $lastName, $hashedPassword, $extension, $typeSalesPerson,'active']);
                if ($result)
                {
                    $showSuccess = true;
                }
            }    
        }
    }
?>

<form class="form-signin" action="./salespeople.php" method="post" >
    <h1 class="h3 mb-3 font-weight-normal text-center"><b>Sales Person Creation</b></h1>
    <?php
        
        
        // Show error message if any field is left empty !
        ShowWarning($showErrorEmpty,"None of the field can be left empty");

        // Show error if wrong credentials are entered by the user !
        ShowWarning($wrongCredentials, "Please enter valid Credentials");

        
        // Show Error Message if the user enter non valid format of the email !
        ShowWarning($errorEmailFormat, "Please enter valid Email Address");
        
        // 
        ShowWarning($alreadyExists, "Looks like user already Exists <br> Try using another Email");
        
        
        // Adding the Stickiness to the form !
        if(isset($firstName))
        {
            $arrayAssocArray[0]['value']  = $firstName;
        }
        
        if(isset($lastName))
        {
            $arrayAssocArray[1]['value']  = $lastName;
        }
        
        if(isset($email))
        {
            $arrayAssocArray[2]['value']  = $email;
        }
        
        if(isset($extension))
        {
            $arrayAssocArray[3]['value']  = $extension;
        }
    
        // Shows a Message to the user Showing success !
        SuccessCreation($showSuccess, "A new Sales Person is created with");
        
        // Using the function to display the input fields to the user.
        display_form($arrayAssocArray);
        ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Create Sales Person</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset">Reset</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset" onclick="window.location.href=window.location.href">New Sales Person</button>
</form>

<?php
    // Including the footer file !
    include "./includes/footer.php";
?>  