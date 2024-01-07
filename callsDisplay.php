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

    // Variables
    $selectedAttribute = "";
    $fieldNames = ['Client ID',"Call Time"];

    // -- Conditional Variables
    $isValid = true;
    $showErrorEmpty = false;

  
?>

<form class="form-signin" action="./callsDisplay.php" method="post" >
    <h1 class="h3 mb-3 font-weight-normal text-center"><b>Client's Calls</b></h1>
    <h6><br>Select a Client to Display the Calls:</br></h6>
    <?php
        // Show error message if any field is left empty !
        ShowWarning($showErrorEmpty,"Please Select a Client From List");
        // Display the drop down according to the number of clients associated with the user !
        if($_SESSION['userType'] == "A")
        {
            SalesClient($_SESSION['id']);
        }
        else
        {
            SalesClient($_SESSION['salesperson_id']);
        }
        ?>
<?php
  // If submit method is post !
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    // Populating the variables
    if(isset($_POST['salesClient']))
    {
        $selectedAttribute = $_POST['salesClient'];
        
        // if the session variable for the selectedClient is not set or not equal to the current selected option then
        // the session variable will be initialized or its value will be set to selected option !
        if(!isset($_SESSION['selectedClient']) || $_SESSION['selectedClient'] != $selectedAttribute)
        {
            $_SESSION['selectedClient'] = $selectedAttribute;
        }
        // However, if $_SESSION variable is set or it's value it equal to the current selected option then
        // then the session variable will get it;s information from the session variable !
        else if(isset($_SESSION['selectedClient']) || $_SESSION['selectedClient'] == $selectedAttribute)
        {
            $selectedAttribute = $_SESSION['selectedClient'];
        }


    }
    
    // Data Validation !
    if(empty($selectedAttribute))
    {
        $isValid = false;
        $showErrorEmpty = true; // Error !
    }
    
    }
    // Display the clients table if the client is selected from the drop down !
    if($isValid)
    {
        // It uses the $_SESSION global variable so that when moved from one page to another selected client remain same as well as records !
        DisplayCalls($fieldNames,isset($_SESSION['selectedClient']) ? $_SESSION['selectedClient'] : $selectedAttribute);
    }
    ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Show Calls</button>
    <!-- <button class="btn btn-lg btn-primary btn-block" type="reset">Reset</button> -->
</form>

<?php
    // Including the footer file !
    include "./includes/footer.php";
?>  