<?php
require_once('functions.php');  // includes function list file
getSession();   //start of session
echo makePageStart("North Events: Update", "style.css");    //calls functions from the and dynamically creates sections of the page
echo makeHeader("Northern Events: Update");
echo makeNavMenu(array("index.php" => "Home", "bookEventsForm.php" => "Events", "admin.php" => "Admin", "credits.php" => "Credits"));
echo loginForm();   //calls function and creates logout link
echo startMain();   //start of the main tag
if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {  //checks the login status with if else statement. if not logged in then jumps else

    try {
        $dbConn = getConnection();  //database connection

        //The following lines before the break/comment line are variables that are linked to the data the user has entered on the previous page (edit.php)

        $eventID = filter_has_var(INPUT_GET, 'eventID')
            ? $_GET['eventID'] : null;

        $eventTitle = filter_has_var(INPUT_GET, 'eventTitle')
            ? $_GET['eventTitle'] : null;
        $eventDesc = filter_has_var(INPUT_GET, 'eventDesc')
            ? $_GET['eventDesc'] : null;
        $venueName = filter_has_var(INPUT_GET, 'venueName')
            ? $_GET['venueName'] : null;
        $catDesc = filter_has_var(INPUT_GET, 'catDesc')
            ? $_GET['catDesc'] : null;
        $eventStartDate = filter_has_var(INPUT_GET, 'eventStartDate')
            ? $_GET['eventStartDate'] : null;
        $eventEndDate = filter_has_var(INPUT_GET, 'eventEndDate')
            ? $_GET['eventEndDate'] : null;
        $eventPrice = filter_has_var(INPUT_GET, 'eventPrice')
            ? $_GET['eventPrice'] : null;

        $errors = false;    //error check

        /*------------------------------------------------------------------------------*/

        //The following if statement is an error check to make sure the user has entered some data
        if (empty($eventTitle)) {
            echo "<p>You have not entered a Title</p>\n";
            $errors = true;
        }
        //The following if statement is an error check to make sure the data is less than 50 characters
        if (strlen($eventTitle) > 50) {
            echo "<p>The Title must be 50 characters or less</p>\n";
            $errors = true;
        }
        trim($eventTitle);  //trims down empty, blank and 'white spaces'

        /*------------------------------------------------------------------------------*/

        //The following if statement is an error check to make sure the user has entered some data
        if (empty($eventDesc)) {
            echo "<p>You have not entered a Description</p>\n";
            $errors = true;
        }
        //The following if statement is an error check to make sure the data is less than 400 characters
        if (strlen($eventDesc) > 400) {
            echo "<p>The Description must be 400 characters or less</p>\n";
            $errors = true;
        }
        trim($eventDesc);   //trims down empty, blank and 'white spaces'

        /*------------------------------------------------------------------------------*/

        //The following if statement is an error check to make sure the user has entered some data
        if (empty($venueName)) {
            echo "<p>You have not entered a Venue</p>\n";
            $errors = true;
        }

        /*------------------------------------------------------------------------------*/

        //The following if statement is an error check to make sure the user has entered some data
        if (empty($catDesc)) {
            echo "<p>You have not entered a Category</p>\n";
            $errors = true;
        }

        /*------------------------------------------------------------------------------*/

        //The following 2 if statements are an error check to make sure the user has entered some data
        if (empty($eventStartDate)) {
            echo "<p>You have not entered a Start Date</p>\n";
            $errors = true;
        }
        if (empty($eventEndDate)) {
            echo "<p>You have not entered a End Date</p>\n";
            $errors = true;
        }
        //The following if statement is an error check to make sure that the end date entered does not start before the start date
        if ($eventStartDate > $eventEndDate) {
            echo "<p>The End date cannot be before the Start date. Please select a two valid dates.</p>\n";
            $errors = true;
        }

        /*------------------------------------------------------------------------------*/

        //The following if else statement is an error check to make sure the user has entered some data and that is of a numeric value
        if (empty($eventPrice)) {
            echo "<p>You have not entered a Price</p>\n";
            $errors = true;
        } elseif (!is_numeric($eventPrice)) {
            echo "<p>You have not entered a valid Price</p>\n";
            $errors = true;
        }
        trim($eventPrice);  //trims down empty, blank and 'white spaces'

        /*------------------------------------------------------------------------------*/

        if ($errors === true) {
            echo "<a href='admin.php'>Update failed: Please try again. </a>";   //if the error check fails then an error message is displayed
            exit();
        } else {
            //SQL query to get data from the database
            $sql = "UPDATE NE_events
                SET eventTitle='$eventTitle', eventDescription='$eventDesc',venueID='$venueName', catID='$catDesc', eventStartDate='$eventStartDate', eventEndDate='$eventEndDate', eventPrice='$eventPrice'
                WHERE eventID='$eventID'";

            //preparing the sql query
            $stmt = $dbConn->prepare($sql);
            //executing the query
            $success = $stmt->execute(array('eventID'=>$eventID, 'eventTitle'=>$eventTitle, 'eventDescription'=>$eventDesc, 'venueID'=>$venueName, 'catID'=>$catDesc, 'eventStartDate'=>$eventStartDate, 'eventEndDate'=>$eventEndDate, 'eventPrice'=>$eventPrice));

            if ($stmt === false) {
                echo "<a href='admin.php'>Update Error: Please try again." . $dbConn->errorCode() . "</a>"; //if the query fails then an error message is displayed
            } else {
                echo "<a href='admin.php'>Update completed: Return</a>";
            }
        }

    } catch (Exception $e) {    //logs errors
        log_error($e);
        echo "<p>Query failed: " . $e->getMessage() . "</p>\n"; //Error message is displayed
    }
}
else {
    echo "<p>Unauthorised access is strictly prohibited! Please login to view this page.</p>";  //Message is displayed if not logged in
}
echo endMain(); //end of the main tag
echo makeFooter("Designed by Sam Johnston - W17004648");
echo makePageEnd(); //end of the page

/**
 * Created by PhpStorm.
 * User: SamJ
 * Date: 18/11/2019
 * Time: 03:50 PM
 */