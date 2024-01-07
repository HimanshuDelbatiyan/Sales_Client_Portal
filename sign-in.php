<!-- Name: - Himanshu
Student ID:  - 100898751
File name: - sign-in.php
Folder name: - Lab01 -->

<?php
    // Including the functions File !
    include "../Lab04/includes/db.php";

    // Including the functions files
    include "./functions.php";
?>

<?php
    // Variables
    $userEmail = "";
    $password = "";
    $isValid = true;
    $showErrorEmpty = false;
    $insertQuery = "";
    $exist = "";
    $wrongCredentials = false;
    $statusInactive = false;
    
    // Submit method is post !
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Populating the variables
        $userEmail = $_POST['id'];
        $password = $_POST['password'];
        
        // Data Validation !
        if(empty($userEmail) || empty($password))
        {
            $isValid = false;
            $showErrorEmpty = true;
        }
        if($isValid)
        {
            // Finding the user in the database !
            $exist = user_authenticate($userEmail, $password);
            
            // No user found
            if($exist == false)
            {
                $wrongCredentials = true;
                $isValid = false;
            }
            else if($exist == true && $exist['user_status'] == "inactive")
            {
                $statusInactive = true;
                $isValid = false;
            }
            else
            {
                //Starting the session !
                session_start();
                
                // Initializing the session variables !
                $_SESSION['siggned'] = true;
                $_SESSION['username'] = $exist['first_name'].' '.$exist['last_name'];
                $_SESSION['lastLogin'] = $exist['last_login_time'];
                $_SESSION['userEmail'] = $userEmail;
                // This session variable will help us in identifying the Admin and Salesperson !
                
                $_SESSION['userType'] = $exist['user_type'];   
                
                // Doing some stuff for clients page !
                if( $_SESSION['userType'] != 'A')
                {
                    $_SESSION['salesperson_id'] = $exist['id'];
                    
                }
                else
                {
                    $_SESSION['id'] = $exist['id'];
                }

                // Redirecting the user to the dashboard_page !
                header("location: dashboard.php");
            }
        }
    }
?>

<?php
    // Including the header File !
    include "./includes/header.php";    
?>   

<form class="form-signin" action="../Lab04/sign-in.php" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <?php
        // Displays an  Error message if any of the field is left empty !
        ShowWarning($showErrorEmpty, "None of the fields can be Left empty");
        ShowWarning($wrongCredentials,"Please enter Valid Credentials");
        ShowWarning($statusInactive,"Please Contact the Admin \n Your Login Status has been disabled by Admin");
    ?>
    <label for="inputEmail" class="sr-only">User Email: </label>
    <input type="text" id="inputEmail" class="form-control" placeholder="User Email" name="id"  autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>


<?php
    // Including the Footer File !
    include "./includes/footer.php";
?>    