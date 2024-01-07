<!-- Name: - Himanshu
Student ID:  - 100898751
File name: - header.php
Folder name: - includes -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./includes/image/racconCompany.png">


    <title>Lab-4</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/styles.css" rel="stylesheet">
    
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="./index.php">Home Page</a>
       
       <?php
            session_start(); // Starting the session 

            // if Session variables is initialized !
            if(!isset($_SESSION['siggned'])) 
            {   
                echo
                '<ul class="navbar-nav px-3">
                    <li class="nav-item  text-white">
                        <a class="nav-link" href="./sign-in.php"><b>Sign-in</b></a>
                    </li>
                </ul>';

            }
            else if(isset($_SESSION['siggned']) || $_SESSION['siggned'] == true)
            {   
                // Display only the logout button if the session has started !
                echo '<ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                <a class="nav-link" href="./logout.php">Logout</a>
                </li>
                </ul>';
            }
        ?>
    </nav>

    <div class="container-fluid">
      <div class="row">
        
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
            <ul class="nav flex-column">
            <?php 
                // Display the Dashboard only to the logged-in users !
                if(isset($_SESSION['siggned']))
                {
                    echo 
                    '<li class="nav-item">
                    <a class="nav-link" href="./dashboard.php">
                        <span data-feather="home"></span>
                        Dashboard
                    </a>
                    </li>';
                    echo  '<li class="nav-item">
                    <a class="nav-link" href="./client.php">
                    <span data-feather="file"></span>
                    Client\'s
                    </a>
                    </li>';
                }

                // Displays the Sales Person Creation only to the Admin !
                if(isset($_SESSION['siggned']) && $_SESSION['userType'] == 'A')
                {
                    echo  '<li class="nav-item">
                    <a class="nav-link" href="./salespeople.php">
                    <span data-feather="file"></span>
                    Sales Person
                    </a>
                    </li>';
                }
                // Display the Dashboard only to the logged-in users !
                if(isset($_SESSION['siggned']))
                {
                    echo '<li class="nav-item">
                    <a class="nav-link " href="./calls.php">
                        <span data-feather="home"></span>
                        Calls
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="./reset.php">
                        <span data-feather="home"></span>
                        Reset Password
                    </a>
                    </li>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " href="./passwordUpdate.php">
                        <span data-feather="home"></span>
                        Update Password
                    </a>
                    </li>';
                }
                // Displays the For Sale Only to Sales Person!
                else if (isset($_SESSION['siggned']) && $_SESSION['userType'] == 'S')
                {
                    echo  '<li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="file"></span>
                        For Sale
                    </a>
                    </li>';
                }
                // Displays 
                if (isset($_SESSION['siggned']))
                {
                    echo  '<li class="nav-item">
                    <a class="nav-link" href="./callsDisplay.php">
                        <span data-feather="file"></span>
                        Calls Records
                    </a>
                    </li>';

                }
                
                if(isset($_SESSION['siggned']) && $_SESSION['userType'] == 'A')
                {
                    echo  '<li class="nav-item">
                    <a class="nav-link" href="./salespeopleDisplay.php">
                        <span data-feather="file"></span>
                        Sales Person\'s Records
                    </a>
                    </li>';
                }
            ?>
        
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="users"></span>
                    Customers
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Saved reports</span>
                <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
                </a>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Current month
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Last quarter
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Social engagement
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Year-end sale
                </a>
                </li>
            </ul>
            </div>
        </nav>

        <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">