<!-- Name: - Himanshu
Student ID:  - 100898751
File name: - client.php
Folder name: - Lab01 -->

<?php
    // Including the functions File !
    include "../Lab04/includes/db.php";

    // Including the functions files
    include "./functions.php";

    // Again, i have buffered the header file because it again has some session variables which need to be initialized.
    ob_start();

    // Including the header File !
    include "./includes/header.php";

    // If any of session variable is not initialized then the user will be redirected to the sign-in page.
    if(!isset($_SESSION['siggned']) || $_SESSION['siggned'] != true || !isset($_SESSION['userType']) )
    {
        // Then redirect the user to the sign-in page !
        header("location: sign-in.php");
    }
    else
    {
        // Else end the flush and display the buffered output to the user !
        ob_flush();
    }
?>

<?php
    // Variables: - 
    $clientId = "";
    $firstName = "";
    $lastName = "";
    $email = "";
    $phoneNumber = "";
    $selectedUser = "";
    $file = "";
    $fileErrorCode = "";
    $filePath = "";
    $fileSize = "";
    $executeInsertion = ""; 
    
    // Conditional Variables
    $isValid = true;
    $errorExist = false;
    $showErrorEmpty = false;
    $wrongCredentials = false;
    $showSuccess = false;
    $errorEmailFormat = false;
    $errorNumeric = false;
    $errorFileUpload = false;
    $noUpload = false;
    $idSizeExceed = false;
    $fileSizeExceed = false;
    $emptyFile = false;
    $fileTypeError = false;

    
    // Submit method is post !
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $clientId = $_POST['clientId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $file = $_FILES['file'];

        if($_SESSION['userType'] != 'S')
        {
            $selectedUser = $_POST['userList'];
            if(empty($selectedUser))
            {
                $isValid = false;
                $showErrorEmpty = true;
            }
        }

        // if any of the field is empty !
        if(empty($clientId) || empty($firstName)|| empty($lastName)|| empty($email)|| empty($phoneNumber))
        {
            $isValid = false;
            $showErrorEmpty = true;
        }
        else if(strlen($clientId) > 10)
        {
            $isValid = false;
            $idSizeExceed = true;
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validating the Email Format !
        {
            $isValid = false;
            $errorEmailFormat = true;
        }
        else if (!is_numeric($phoneNumber)) // If phoneNumber is not numeric.
        {
            $isValid = false;
            $errorNumeric = true;
        }
        
        //=========File Validation
        else if(isset($_FILES['file']['error']) && $_FILES['file']['error'] != 0) // Validation of the file input !
        {
            $isValid = false;

            if($_FILES['file']['error'] == UPLOAD_ERR_NO_FILE)
            {
                $noUpload = true;
            }
            else if($_FILES['file']['type'] != 'image/pjpeg'
            || $_FILES['file']['type'] != 'image/jpeg'
            ||$_FILES['file']['type'] != 'image/png'
            )
            {
                $fileTypeError = true;
            }
            else
            {
                // Storing the temporary file and path provided by the php at the server in the variable ! 
                $filePath = $_FILES['file']['tmp_name'];
                
                // Finding the size of the file at located at the specified location in the server !
                $fileSize = $_FILES['file']['size'];
                
                //==============> Checking the size of the file !
            
                if($fileSize > MAX_FILE_SIZE) // Making sure the size is less than 3MB
                {
                    $fileSizeExceed = true;
                }
                else if($fileSize == 0) // Empty File !
                {
                    $emptyFile = true;
                }
            }
        }
        else
        {
            // Uploading the file to the Specified Place !
            $fileName = basename($_FILES['file']['name']); // Return the filename from specified path ! 
        }
 

            

        if($isValid && $_FILES['file']['error'] == UPLOAD_ERR_OK) // If none of the problems occurred !
        {
           

            // Execute the prepared query !
            $executeQuerySearch = pg_execute(db_connect(),"search_client", [$clientId]);

            // Checking the user already exist or not !
            if($executeQuerySearch && pg_num_rows($executeQuerySearch) > 0)
            {
                $errorExist = true;
            }
            else // If the user does not exist then create the new record of the user !
            {
                if($_SESSION['userType'] == 'A' || $_SESSION['userType'] != 'S' )
                {
                    $executeInsertion = pg_execute(db_connect(),"Insert_client", [$clientId, $firstName, $lastName, $phoneNumber, $email, $selectedUser,"../Lab04/includes/image/".$fileName.""]);
                }
                else
                {
                    $executeInsertion = pg_execute(db_connect(),"Insert_client", [$clientId, $firstName, $lastName, $phoneNumber, $email,$_SESSION['salesperson_id'],"../Lab04/includes/image/".$fileName.""]);
                }
                
                if($executeInsertion)
                {
                
                    $showSuccess = $executeInsertion;
                    // Moving the file to the proper folder !
                    move_uploaded_file($_FILES['file']['tmp_name'], "../Lab04/includes/image/".$fileName."");
                }
            }
        }
    }
?>

<?php
    
    // Declaring an Array of Associative Array !
    $arrayAssocArray = array 
    (
        array
        ( 
            'type' => 'text',
            'name' =>  'clientId',
            'value' =>  '',
            'label' =>  'Client ID'
        ),
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
            'name' =>  'phoneNumber',
            'value' =>  '',
            'label' =>  'Phone Number'
        ),
        array
        ( 
            'type' => 'file',
            'name' =>  'file',
            'value' =>  '',
            'label' =>  'clientLogo'
        )
    );
?>   

<form class="form-signin" action="../Lab04/client.php" method="post" enctype="multipart/form-data">
<h1 class="h3 mb-3 font-weight-normal text-center"><b>Client's Creation</b></h1>
    <?php
        // Show error message if any field is left empty !
        ShowWarning($showErrorEmpty,"None of the field can be left empty");

        // Show error if wrong credentials are entered by the user !
        ShowWarning($wrongCredentials, "Please enter valid Credentials");

        // Shows a Message to the user Showing success !
        SuccessCreation($showSuccess, "A new Client is created with");

        // Show Error Message if the user enter non valid format of the email !
        ShowWarning($errorEmailFormat, "Please enter valid Email Address");

        ShowWarning($idSizeExceed, "Id for Client is too long");
        
        ShowWarning($emptyFile, "Empty File is not acceptable");
        
        ShowWarning($errorExist, "Looks like Client already Exists <br> Try using another Client ID !");

        ShowWarning($errorNumeric, "Please enter valid Phone Number"); // Show error if the phone number is not numeric !

        ShowWarning($fileSizeExceed, "Logo File size can't be greater than".ini_get("upload_max_filesize")."B."); // Show error if the phone number is not numeric !
        
        ShowWarning($noUpload, "File Field cannot be left empty"); // Show error if the phone number is not numeric !
        ShowWarning($fileTypeError, "Your profile picture must be of types JPEG, PNG");
        
        
        // Adding the Stickiness to the form !
        // Setting the value for the array element if the variables are
        // set !
        if(isset($clientId))
        {
            $arrayAssocArray[0]['value']  = $clientId;
        }

        if(isset($firstName))
        {
            $arrayAssocArray[1]['value']  = $firstName;
        }
        
        if(isset($lastName))
        {
            $arrayAssocArray[2]['value']  = $lastName;
        }
        
        if(isset($email))
        {
            $arrayAssocArray[3]['value']  = $email;
        }
        
        if(isset($phoneNumber))
        {
            $arrayAssocArray[4]['value']  = $phoneNumber;
        }
        if(isset($file))
        {
            $arrayAssocArray[5]['value'] = $file;
        }
       
        // Using the function to display the input fields to the user.
        display_form($arrayAssocArray);
        if($_SESSION['userType'] != 'S')
        {
            UsersList($selectedUser);
        }
        ?>

    <br>
    <!--  button's  -->
    <button class="btn btn-lg btn-primary btn-block" type="submit">Create Client</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset">Reset</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset" onclick="window.location.href=window.location.href">New Client</button>
</form>


<?php
    // Including the Footer File !
    include "./includes/footer.php";
?>    