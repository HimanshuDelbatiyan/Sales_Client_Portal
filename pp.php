<?php
    








?>


<table>
    <thead>
    <tr>
        <td>
                GanduSalesMan@gmail.com
        </td>
            
        <td>
            Gandu
        </td>
            Sales Man
        <td>
            <form action="./pp.php" method="post">
            <div>
                <input type="radio" name="4-Active" id="4-Active" value="Active" checked>
                <label for="4-Active">Active</label>
            </div>
            <div>
                <input type="radio" name="4-Active" id="4-Active" value="Inactive" checked>
                <label for="4-Active">Inactive</label>
            </div>
            <input type="submit" value="Update">
            </form>
            </td>
        </tr>



    </thead>
    <tbody>
    <tr>
            <td>
                GanduSalesMan@gmail.com
            </td>
                
            <td>
                Gandu
            </td>
                Sales Man
            <td>
                <form action="./pp.php" method="post">
                <div>
                    <input type="radio" name="4-Active" id="4-Active" value="Active" checked>
                    <label for="4-Active">Active</label>
                </div>
                <div>
                    <input type="radio" name="4-Active" id="4-Active" value="Inactive" checked>
                    <label for="4-Active">Inactive</label>
                </div>
                </form>
            </td>
        </tr>
    </tbody>
    <tfoot>


    </tfoot>
</table>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through the posted data
    foreach ($_POST as $key => $value) {
        // Check if the key starts with "status_"
        if (strpos($key, 'status_') === 0) {
            // Extract the salesperson ID from the key
            $salespersonId = substr($key, strlen('status_'));

            // $value contains the selected status (Active or Inactive)
            // Perform the update in your database using $salespersonId and $value
            // Example: updateSalespersonStatus($salespersonId, $value);
        }
    }
}
?>