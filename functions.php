<!-- Name: - Himanshu
Student ID: - 100898751
File Name: - functions.php
Folder Name: - Lab04
Date: - 29 Sep 2023 -->
<?php

function ShowWarning($variable, $textMessage)
{
    if($variable)
    {
        echo '<div class="alert alert-primary" role="alert">
            <b>Warning:</b><br>'.$textMessage.'!
            </div>';
    }
}

function SuccessCreation($variable, $textMessage)
{
    if($variable)
    {
        // An Error message will be displayed to the user !
        echo '<div class="alert alert-primary" role="alert">
        <b>Success</b><br> '.$textMessage.' <br>Following Details:</b>.
        </div>';
    }
}
function SuccessUpdatesPass($variable, $textMessage)
{
    if($variable)
    {
        // An Error message will be displayed to the user !
        echo '<div class="alert alert-primary" role="alert">
        <b>Success</b><br> '.$textMessage.'.
        </div>';
    }
}



?>