<!-- Name: - Himanshu
Student ID:  - 100898751
File name: - calls.php
Folder name: - Lab04 -->

<?php
    // Including the db functions File !
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
    $callDateTime = "";
    
    // Conditional Variables
    $isValid = true;
    $showErrorEmpty = false;
    $showSuccess = false;

    
    // Submit method is post !
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $clientId = $_POST['clientList'];
        $callDateTime = $_POST['call'];

        if(empty($clientId) || empty ($callDateTime)) // If any of the field is empty then it will display the error !
        {
            $isValid =  false;
            $showErrorEmpty = true;
        }
        
        // When everything is good !
        if($isValid) 
        {
            // execute the prepared query: -
            $executePrepared = pg_execute(db_connect(), "Insert_call", [$clientId, $callDateTime]);

            if($executePrepared)
            {
                $showSuccess = true;
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
            'type' => 'datetime-local',
            'name' =>  'call',
            'value' =>  '',
            'label' =>  'Call Time'
        )
    );
?>   

<form class="form-signin" action="../Lab04/calls.php" method="post">
<h1 class="h3 mb-3 font-weight-normal text-center"><b>Call's Creation</b></h1>
    <?php
        // Show error message if any field is left empty !
        ShowWarning($showErrorEmpty,"None of the field can be left empty");

        // Shows a Message to the user Showing success !
        SuccessCreation($showSuccess, "A Record has been inserted using");
       
        // Adding the Stickiness to the form !
        // Setting the value for the array element if the variables are
        // set !
        if(isset($callDateTime))
        {
            $arrayAssocArray[0]['value']  = $callDateTime;
        }
        // Displaying the Clients Dropdown to the user !
        ClientList($_SESSION['userType'], isset($_SESSION['salesperson_id'])? $_SESSION['salesperson_id'] : $_SESSION['id']);

        // Using the function to display the input fields to the user.
        display_form($arrayAssocArray);
        
    ?>

    <!-- Login button  -->
    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit Call</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset" >Reset</button>
    <button class="btn btn-lg btn-primary btn-block" type="reset" onclick="window.location.href=window.location.href">New Call</button>
</form>


<?php
    // Including the Footer File !
    include "./includes/footer.php";
?>    