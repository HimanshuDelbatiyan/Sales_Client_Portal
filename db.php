<!-- Name: - Himanshu
Student ID:  - 100898751
File name: - db.php
Folder name: - includes -->

<?php 

    // Including the constants File
    include "../Lab04/includes/constants.php";

    // Function - 1
    // Connect to the database !----------------------------------------
    function db_connect()
    {
        return pg_connect("host= ".DB_HOST." dbname= ".DB_NAME." user= ".DB_USERNAME. " password= ".DB_PASSWORD."");
    }
    
    // Prepared Database Queries for Salespeople.php=====================================================
    $searchSalesPerson = pg_prepare(db_connect(),"Search_salesPerson", "SELECT * FROM users WHERE user_email = $1;");

    $insertSalesPerson = pg_prepare(db_connect(), "insert_salesperson", "INSERT INTO users (user_email, first_name, last_name, password_hash, phone_extension, user_type, user_status)
    VALUES ($1, $2, $3, $4, $5, $6, $7);");

    // Prepared Database Query for client.php================================================
    
    $searchClient = pg_prepare(db_connect(),"search_client","SELECT * From clients where clientId = $1;");
    
    $insertClient = pg_prepare(db_connect(),"Insert_client", "INSERT INTO clients Values ( $1, $2, $3, $4, $5, $6,$7);");

    
    // Prepared Database Query for calls.php==================================================

    $insertCall =  pg_prepare(db_connect(), "Insert_call", "INSERT INTO calls values ($1, $2);");

    // Prepared Query for the Updating dashboard and showing the results
    // Inner join will select all
    $selectAllClients = pg_prepare(db_connect(),"Select_all","SELECT * FROM clients
    LIMIT $1 OFFSET $2;"); // For admin
    $selectClientsSalesPerson = pg_prepare(db_connect(),"relatedSalesPerson","SELECT * FROM clients where created_by_userid = $1
    LIMIT $2 OFFSET $3;");
    $recordsCount = pg_prepare(db_connect(),"Client_Count","SELECT COUNT(clientid) FROM clients Where clientid = $1;");
    $defaultCount = pg_prepare(db_connect(),"default_Count","SELECT COUNT(clientid) FROM clients;");
  

    //===================================> Query for the Password Update (passwordUpdate.php)

    $passwordUpdate = pg_prepare(db_connect(), "Update_Password", "UPDATE users SET password_hash = $1 WHERE id = $2;");

    // ===================> Query for the display calls page
    $showSelected = pg_prepare(db_connect(), "showCalls",
    " SELECT * FROM calls Where clientid = $1 LIMIT $2 OFFSET $3;");
    $selectedclientCount = pg_prepare(db_connect(), "callsCount",
    " SELECT COUNT(*) FROM calls Where clientid = $1;;");


    //=================================> Queries for the SalesPeople table: - ()

    $adminSalesPeople = pg_prepare(db_connect(), "admin_salesperson", 
    "SELECT * FROM users where user_type = 'S' LIMIT $1 OFFSET $2;");

    $admin_salesperson_count =  pg_prepare(db_connect(), "admin_salesperson_count", "SELECT COUNT(*) FROM users where user_type = $1");

    // ====================> Update Status Query for the User SalesPerson
    $updateStatus = pg_prepare(db_connect(), "update_status", "UPDATE users SET user_status = $1 WHERE id = $2;");

    $salesPeopleInfo = pg_prepare(db_connect(), "sales_info", "SELECT * from users where id = $1");




    

    // ------------------------------------------------------------------------------------------------------------
    // Function - 2
    // Returns an Associative Array if the user exist otherwise false !
    function user_select($id)
    {
        // Check if the user email is in a valid format
        if (!filter_var($id, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
        
        $searchingQuery = "SELECT user_email FROM users WHERE user_email = $1";  // Creating the Searching Query

        $result = pg_prepare(db_connect(), "search_user", $searchingQuery); // Preparing the Query !
  
        $result = pg_execute(db_connect(), "search_user", [$id]); // Executing the Query !

        if (pg_num_rows($result) > 0) // Making sure that result has some rows in it !
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
    
    function user_authenticate($id, $password)
    {
        // Check if the user email is in a valid format
        if (!filter_var($id, FILTER_VALIDATE_EMAIL)) 
        {
            return false;
        }
        
        // Creating the Searching Query
        $searchingQuery = "SELECT * FROM users WHERE user_email = $1";
    
        $resource = pg_prepare(db_connect(), "authenticate_user", $searchingQuery); // Preparing the query
    
        $result = pg_execute(db_connect(), "authenticate_user", [$id]); // Executing the query
    
        if (pg_num_rows($result) > 0) // Making sure the result got row
        {
            $resultArray = pg_fetch_assoc($result); // Storing the row as associative array in variable !
    
            if (password_verify($password, $resultArray['password_hash'])) // Verifying the stored hash with the password entered by the user !
            {
                $updateQuery = "UPDATE users SET last_login_time = CURRENT_TIMESTAMP WHERE user_email = $1"; // Set the Last Login Time

                $updateResource = pg_prepare(db_connect(), "update_last_login", $updateQuery); // Prepare the update login time query
                
                $updateResult = pg_execute(db_connect(), "update_last_login", [$id]); // Execute the update login time query
                
                if ($updateResult)
                {
                        // Log the successful login into the file !
                        $file = fopen("DATA_log.txt", 'a');
                        fwrite($file, "User ID: '$id' Successfully Logged-in on " . date("y-m-d") . ' at ' . date('h:i:sa') . "\n");
                        fclose($file);
                        return $resultArray; // Return the array !
                }
            } 
            else 
            {
                // Log the failed login
                $file = fopen("DATA_log.txt", 'a');
                fwrite($file, "User ID: '$id' Login failed on " . date("y-m-d") . ' at ' . date('h:i:sa') . "\n");
                fclose($file);
                return false;
            }
        }
    
        // Log the failed login
        $file = fopen("DATA_log.txt", 'a');
        fwrite($file, "User ID: '$id' Login failed on " . date("y-m-d") . ' at ' . date('h:i:sa') . "\n");
        fclose($file);
        return false;
    }
    

    //=============Display Form===============
    function display_form($arrayAssocArray)
    {

        // Run for each element of the array and each element of the array is an Associative Array !
        foreach($arrayAssocArray as $singleArray)
        {
            // Storing the associative array values into the variables.
            $type = $singleArray['type'];
            $name = $singleArray['name'];
            $value = $singleArray['value'];
            $label = $singleArray['label'];

            // Check the type of input Field !
            if($type == "text")
            {
                echo "<input type='text' name='$name' class='form-control' placeholder= '$label' value='$value'>";
            }
            else if($type == "email")
            {
                echo "<input type='email' name='$name' class='form-control' placeholder= '$label' value='$value'>";
            }
            else if($type == "number")
            {
                echo "<input type='number' name='$name'class='form-control'  placeholder= '$label' value='$value' min='000000000' max='9999999999'>";
            }
            else if($type == "password")
            {
                echo "<input type='password' name='$name'class='form-control'  placeholder= '$label' value='$value'>";
            }
            else if($type == "datetime-local")
            {
                echo "<input type='datetime-local'' name='$name' class='form-control'  placeholder= '$label' value='$value'>";
            }
            else if($type == "file")
            {
                echo "<input type='file' name='$name' class='form-control'  placeholder= '$label' accept='image/png, image/jpeg, image/jpg' size='3072'>";
            }

            echo "<br>";
        }
    }


    // ------------------ DROPDOWN LIST ------------------------

    function UsersList()
    {
        // Initialize the selected option 
        // Note: -This will retrieve the selected option and store it into a variable
        // If selected option is none then it will pass the empty string to the variable
        $selectedUser = isset($_POST['userList']) ? $_POST['userList'] : ''; // Using ternary Operator !
    
        // Creating an Selection Query !
        $selectionQuery = "SELECT id, first_name, last_name FROM users;";
    
        $preparedQuery = pg_prepare(db_connect(), "Select_users", $selectionQuery); // Preparing the Query
        $executedQuery = pg_execute(db_connect(), "Select_users", []); // Executing the query !
    
        if ($executedQuery && pg_num_rows($executedQuery) > 0) {
            // Fetching all the rows as associative array
            $users = pg_fetch_all($executedQuery);
    
            // Echoing the Select tag
            echo '<form method="POST">'; // Add a form element for submitting the selection
            echo '<select name="userList" class="form-control form-control-lg mb-6" aria-label=".form-select-lg ">
                <option value="" selected >Select a User</option>';
    
            foreach ($users as $user)
            {
                // Storing the user id and full name in variables !
                $userId = $user['id'];
                $userName = $user['first_name'] . " " . $user['last_name'];
    
                // Set 'selected' attribute for the option that matches the selectedUser
                $selectedAttribute = ($selectedUser == $userId) ? 'selected' : '';
                // When the form reloads if it will fetch and check if the user selected something or not !
                echo '<option value="' . $userId . '" ' . $selectedAttribute . '>' . $userName . '</option>';
            }
            echo '</select><br>';
        }
    }
    

    function ClientList($userType, $salesId)
    {

        // Getting the Selected option from the user using the $_POST[];
        $selectedClient = isset($_POST['clientList']) ? $_POST['clientList'] : "";


        if($userType == 'A')
        {
            $selectionQuery = "SELECT clientId, firstname, lastname FROM clients ;"; // I did not use the placeholders as it was not giving me the accurate results !
            $preparedQuery = pg_prepare(db_connect(), "Select_clients", $selectionQuery); // Preparing the SQL statement
    
            $executedQuery = pg_execute(db_connect(), "Select_clients", []); // Executing the Prepared Statement
        }
        else
        {
            $selectionQuery = "SELECT clientId, firstname, lastname FROM clients Where created_by_userID = $1 ;"; // I did not use the placeholders as it was not giving me the accurate results !
            $preparedQuery = pg_prepare(db_connect(), "Select_clients", $selectionQuery); // Preparing the SQL statement
    
            $executedQuery = pg_execute(db_connect(), "Select_clients", [$salesId]); // Executing the Prepared Statement
        }
        

        if($executedQuery && pg_num_rows($executedQuery) > 0) // Checking if the query is executed successfully !
        {
            // Fetching all the rows as associative array !
            $clients = pg_fetch_all($executedQuery);

            // Echoing the Select tag !
            echo '<select name="clientList" class=" form-control form-control-lg mb-6" aria-label=".form-select-lg ">
                <option value="" selected >Select a Client</option>';
            
            // Using the for each to iterate through each of the index of the associative array!
            foreach ($clients as $client) 
            {
                // Storing the client information into the variables: - 
                $clientID = $client['clientid']; 
                $clientName =  $client['firstname']." ".$client['lastname'];

                $selectedAttribute = ($selectedClient == $clientID) ? 'Selected': '';

                echo'<option value="' . $clientID .'"'.$selectedAttribute.'>' .$clientName. '</option>';
            }
            echo '</select><br>' ;
        }
    }


    // ===================================> Display the table : - 
function display_table($fieldsNames)
{
    // Variables
    $totalRecordsCount = "";

    echo '<table class="table table-striped table-sm">';
    echo '<thead><tr>';
    // Displaying the header for the table
    foreach ($fieldsNames as $key => $value) {
        echo '<th>' . $value . '</th>';
    }
    echo '</tr></thead>';

    // Variable for the pagination !
    $page = "";

    // if the query string page variable is set then the 
    // $page variable value will be equal to that !
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    // Otherwise, we will suppose it is our first page !
    else {
        $page = 1;
    }

    // Setting the starting point for the database records !
    $start = ($page - 1) * PER_PAGE_RESULT;

    if ($_SESSION['userType'] != "S") {
        $records = pg_execute(db_connect(), "Select_all", [PER_PAGE_RESULT, $start]);

        $totalRecordsCount = pg_execute(db_connect(), "default_Count", []);

        $totalRecordsCount = pg_fetch_assoc($totalRecordsCount);
    } else {
        $records = pg_execute(db_connect(), "relatedSalesPerson", [$_SESSION['salesperson_id'],PER_PAGE_RESULT, $start]);

        $totalRecordsCount = pg_execute(db_connect(), "Client_Count", [$_SESSION['salesperson_id']]);

        $totalRecordsCount = pg_fetch_assoc($totalRecordsCount);
    }

    // Showing the table to the user !
    if ($totalRecordsCount > 0) {
        // While loop will execute for each of the row
        // fetched from the database !
        echo "<tbody>";
        while ($row = pg_fetch_assoc($records)) {
            echo '<tr>
                    <td><br>' . $row["clientid"] . '</td>
                    <td><br>' . $row["firstname"] . '</td>
                    <td><br>' . $row["lastname"] . '</td>
                    <td><br>' . $row["phonenumber"] . '</td>
                    <td><br>' . $row["emailaddress"] . '</td>
                    <td>' .'<br><img src="' . $row["logo_path"] . '" alt="N/A" srcset="" style="height:40px; width:40px; float:top;">' . '</td>
                  </tr>';
        }
        echo "</tbody>";
        echo '</table>';
    }

    // ceil() function round the given number to the nearest integer !
    $totalPages = ceil((int) $totalRecordsCount['count'] / PER_PAGE_RESULT);

    // Using the for loop to print the defined number of
    // Pages needed to show all the records !
    echo '<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">';
    echo '<li class="page-item"><a class="page-link" href="dashboard.php?page=' .( $page > 1 ? $page - 1 : $page). '">Previous</a></li>';
    
    
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item">
        <a class="page-link" href="dashboard.php?page=' . $i . '">' . $i . '</a>
        </li>';
    }
    echo '<li class="page-item"><a class="page-link" href="dashboard.php?page=' . ($page < $totalPages ? $page + 1 : $page). '">Next</a></li>
    </ul> 
    </nav>';

}


// ===========================================> Client List according to the salesPeople

function SalesClient($salesPersonID)
{
    // Getting the Selected option from the user using the $_POST[];
    $selectedClient = isset($_SESSION['selectedClient']) ? $_SESSION['selectedClient'] : "";
    

    // Execute the query according to the number of clients associated with the user !
    if($_SESSION['userType'] != "A")
    {
        pg_prepare(db_connect(), "Select_clients", "SELECT clientId, firstname, lastname FROM clients WHERE created_by_userID = $1;"); // Preparing the SQL statement
        $executedQuery = pg_execute(db_connect(), "Select_clients", [$salesPersonID]); // Executing the Prepared Statement
    }
    else
    {
        pg_prepare(db_connect(), "Select_clients", "SELECT clientId, firstname, lastname FROM clients;"); // Preparing the SQL statement
        $executedQuery = pg_execute(db_connect(), "Select_clients", []); // Executing the Prepared Statement
    }


    // Ensuring the query executed successfully and return something !
    if($executedQuery && pg_num_rows($executedQuery) > 0) // Checking if the query is executed successfully !
    {
        // Fetching all the rows as associative array !
        $clients = pg_fetch_all($executedQuery);

        // Echoing the Select tag !
        echo '<select name="salesClient" class=" form-control form-control-lg mb-6" aria-label=".form-select-lg ">
            <option value="" selected >Select a Client</option>';
        
        // Using the for each to iterate through each of the index of the associative array!
        foreach ($clients as $client) 
        {
            // Storing the client information into the variables: - 
            $clientID = $client['clientid']; 
            $clientName =  $client['firstname']." ".$client['lastname'];

            // Prints the "Selected" Keyword if the option is stored in the SESSION variable !
            $selectedClient = ($selectedClient == $clientID) ? 'Selected': '';

            echo'<option value="' . $clientID .'"'.$selectedClient.'>' .$clientName. '</option>';
        }
        echo '</select><br>' ;
    }
}

//====================================> Display Calls

function DisplayCalls ($fieldsNames, $id)
{

    // Variables
    $totalRecordsCount = "";

    echo '<table class="table table-striped table-sm">';
    echo '<thead><tr>';
    // Displaying the header for the table
    foreach ($fieldsNames as $key => $value) 
    {
        echo '<th>' . $value . '</th>';
    }
    echo '</tr></thead>';

    // Variable for the pagination !
    $page = "";

    // if the query string page variable is set then the 
    // $page variable value will be equal to that !
    if (isset($_GET['page'])) 
    {
        $page = $_GET['page'];
    }
    // Otherwise, we will suppose it is our first page !
    else {
        $page = 1;
    }

    // Setting the starting point for the database records !
    $start = ($page - 1) * PER_PAGE_RESULT;

    // Finds the total number of calls associated with the particular Client !
    $records = pg_execute(db_connect(), "showCalls", [$id,PER_PAGE_RESULT, $start]);

    // Also, Finds the number of calls associated with the client !
    $totalRecordsCount = pg_execute(db_connect(), "callsCount", [$id]);

    // Then fetch the total count Column !
    $totalRecordsCount = pg_fetch_assoc($totalRecordsCount);


    // Showing the table to the user !
    if ($totalRecordsCount > 0)
    {
        // While loop will execute for each of the row
        // fetched from the database !
        echo "<tbody>";
        while ($row = pg_fetch_assoc($records)) 
        {
            echo '<tr>
                    <td>' . $row["clientid"] . '</td>
                    <td>' . $row["calltime"] . '</td>
                  </tr>';
        }
        echo "</tbody>";
        echo '</table>';

    }
    // ceil() function round the given number to the highest integer !
    $totalPages = ceil((int) $totalRecordsCount['count'] / PER_PAGE_RESULT);

    echo "<br><br>";
    // Using the for loop to print the defined number of
    // Pages needed to show all the records !
    echo '<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">';
    // Print the Previous which subtract 1 from the page number present in the query string 
    echo '<li class="page-item"><a class="page-link" href="callsDisplay.php?page=' .( $page > 1 ? $page - 1 : $page). '">Previous</a></li>';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item">
        <a class="page-link" href="./callsDisplay.php?page=' . $i . '">' . $i . '</a>
        </li>';
    }
    // Print the Previous which adds 1 to the page number present in the query string 
    echo '<li class="page-item"><a class="page-link" href="callsDisplay.php?page=' . ($page < $totalPages ? $page + 1 : $page). '">Next</a></li>
    </ul> 
    </nav>';
}


function display_table_sales($fieldsNames)
{
    // Variables
    $totalRecordsCount = "";

    echo '<table class="table table-striped table-sm">';
    echo '<thead><tr>';
    // Displaying the header for the table
    foreach ($fieldsNames as $key => $value) {
        echo '<th>' . $value . '</th>';
    }
    echo '</tr></thead>';

    // Variable for the pagination !
    $page = "";

    // if the query string page variable is set then the 
    // $page variable value will be equal to that !
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    // Otherwise, we will suppose it is our first page !
    else {
        $page = 1;
    }

    // Setting the starting point for the database records !
    $start = ($page - 1) * PER_PAGE_RESULT;

    $records = pg_execute(db_connect(), "admin_salesperson", [PER_PAGE_RESULT, $start]);

    $totalRecordsCount = pg_execute(db_connect(), "admin_salesperson_count", ['S']);

    $totalRecordsCount = pg_fetch_assoc($totalRecordsCount);

    // Showing the table to the user !
    if ($totalRecordsCount > 0) {
        // While loop will execute for each of the row
        // fetched from the database !
        echo "<tbody>";
        while ($row = pg_fetch_assoc($records)) {
            echo '<tr>
                    <td><br>' . $row["id"] . '</td>
                    <td><br>' . $row["user_email"] . '</td>
                    <td><br>' . $row["first_name"] . '</td>
                    <td><br>' . $row["last_name"] . '</td>
                    <td><br>' . $row["phone_extension"] . '</td>
                    <td><br>' . $row["user_type"] . '</td>
                  </tr>';
        }
        echo "</tbody>";
        echo '</table>';
    }

    // ceil() function round the given number to the nearest integer !
    $totalPages = ceil((int) $totalRecordsCount['count'] / PER_PAGE_RESULT);

    // Using the for loop to print the defined number of
    // Pages needed to show all the records !
    echo '<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">';
    echo '<li class="page-item"><a class="page-link" href="salespeopleDisplay.php?page=' .( $page > 1 ? $page - 1 : $page). '">Previous</a></li>';
    
    
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item">
        <a class="page-link" href="salespeopleDisplay.php?page=' . $i . '">' . $i . '</a>
        </li>';
    }
    echo '<li class="page-item"><a class="page-link" href="salespeopleDisplay.php?page=' . ($page < $totalPages ? $page + 1 : $page). '">Next</a></li>
    </ul> 
    </nav>';

}
// function Controller($pagePath, $salesPersonId)
// {
//     echo'<form action="./'.$pagePath.'" method="post">
//     <div>
//         <input type="radio" name="'.$salesPersonId.'" id="'.$salesPersonId.'" value="Active" checked>
//         <label for="'.$salesPersonId.'_Active">Active</label>
//     </div>
//     <div>
//         <input type="radio" name="'.$salesPersonId.'" id="'.$salesPersonId.'" value="Inactive">
//         <label for="'.$salesPersonId.'_Inactive">Inactive</label>
//     </div>
//     <input type="submit" value="Update">
//     </form>';
// }



// This function is used to Disable and Enable the SalesPerson in the website !
// This function will only be accessed by the Admin User !
function display_table_control_sales($fieldsNames)
{
    // Variables 
    $totalRecordsCount = "";
    // Starting of the table !
    echo '<table class="table table-striped table-sm">';
    // Table header tag !
    echo '<thead><tr>';

    // Displaying the header for the table
    foreach ($fieldsNames as $key => $value) {
        echo '<th>' . $value . '</th>';
    }
    echo '</tr></thead>'; // Closing the thead !

    // Variable for the pagination !
    $page = "";

    // if the "query string page" variable is set then the 
    // $page variable value will be equal to that !
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    // Otherwise, we will suppose it is our first page !
    else {
        $page = 1;
    }

    // Setting the starting point for the database records !
    $start = ($page - 1) * PER_PAGE_RESULT;

    $records = pg_execute(db_connect(), "admin_salesperson", [PER_PAGE_RESULT, $start]);  // Executing the Query !

    $totalRecordsCount = pg_execute(db_connect(), "admin_salesperson_count", ['S']); // Getting the total numbers of records fetched by the query !

    $totalRecordsCount = pg_fetch_assoc($totalRecordsCount); // Storing the fetched records in associative array !

    // Showing the table to the user !
    if ($totalRecordsCount > 0) 
    {
        // While loop will execute for each of the row
        // fetched from the database !
        echo "<tbody>";
        while ($row = pg_fetch_assoc($records)) 
        {
            echo '<tr>
                    <td><br><br>' . $row["id"] . '</td>
                    <td><br><br>' . $row["user_email"] . '</td>
                    <td><br><br>' . $row["first_name"] . '</td>
                    <td><br><br>' . $row["last_name"] . '</td>
                    <td><br><br>' . $row["phone_extension"] . '</td>
                    <td><br>' . '<form action="./salespeopleDisplay.php" method="post"> 
                    <div>
                        <input type="radio" name="'.$row["id"].'_status" id="'.$row["id"].'_active" value="active" '.($row['user_status'] == 'active' ?  "checked": "").'>
                        <label for="'.$row["id"].'_active">Active</label>
                    </div>
                    <div>
                        <input type="radio" name="'.$row["id"].'_status" id="'.$row["id"].'_inactive" value="inactive" '.($row['user_status'] == 'inactive' ?  "checked": "").'>
                        <label for="'.$row["id"].'_inactive">Inactive</label>
                    </div>
                    <input type="submit" value="Update">
                    </form>'
                    . '</td>
                  </tr>';
        }
        echo "</tbody>";
        echo '</table>';
    }
    // ceil() function round the given number to the nearest integer !
    $totalPages = ceil((int) $totalRecordsCount['count'] / PER_PAGE_RESULT);

    // Using the for loop to print the defined number of
    // Pages needed to show all the records !
    echo '<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">';
    echo '<li class="page-item"><a class="page-link" href="salespeopleDisplay.php?page=' .( $page > 1 ? $page - 1 : $page). '">Previous</a></li>';
    
    
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item">
        <a class="page-link" href="salespeopleDisplay.php?page=' . $i . '">' . $i . '</a>
        </li>';
    }
    echo '<li class="page-item"><a class="page-link" href="salespeopleDisplay.php?page=' . ($page < $totalPages ? $page + 1 : $page). '">Next</a></li>
    </ul> 
    </nav>';
}















?>