<?php
require_once('functions.php');  // includes function list file
getSession();   //start of session
echo makePageStart("North Events: Edit", "style.css");  //calls functions from the and dynamically creates sections of the page
echo makeHeader("Northern Events: Edit");
echo makeNavMenu(array("index.php" => "Home", "bookEventsForm.php" => "Events", "admin.php" => "Admin", "credits.php" => "Credits"));
echo loginForm();   //calls function and creates logout link
echo startMain();   //start of the main tag
if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {  //checks the login status with if else statement. if not logged in then jumps else


    $eventID = filter_has_var(INPUT_GET, 'eventID') //checks the eventID is valid and stores as a variable
        ? $_GET ['eventID'] : null;
    $eventTitle = filter_has_var(INPUT_GET, 'eventTitle')   //checks the event title is valid and stores as a variable
        ? $_GET ['eventTitle'] : null;
    $catID = filter_has_var(INPUT_GET, 'catID') //checks the category is valid and stores as a variable
        ? $_GET['catID'] : null;
    $venueID = filter_has_var(INPUT_GET, 'venueID') //checks the venue name is valid and stores as a variable
        ? $_GET['venueID'] : null;

    if (empty($eventID)) {  //Checks to see if the eventID is empty, if empty stops the user from editing any data and jumps else
        echo "<p>A event has not be selected</p>";
        echo "<a href='admin.php'>Click Here</a>";
    } else {    //else runs the following code
        try {
            $dbConn = getConnection();  //database connection

            //first SQL query to get data from the database
            $sql = "SELECT eventID, eventTitle, eventDescription, venueName, catDesc, eventStartDate, eventEndDate, eventPrice, NE_events.catID, NE_events.venueID
            FROM NE_events
            INNER JOIN NE_venue
            ON NE_venue.venueID = NE_events.venueID
            INNER JOIN NE_category
            ON NE_category.catID = NE_events.catID
            WHERE eventID = '$eventID'";
            $stmt = $dbConn->query($sql);   //runs sql query

            //second SQL query to get data from a venue table
            $sqlVenue = "SELECT venueID, venueName
                  FROM NE_venue
                  ORDER BY venueID";
            $venueOutput = $dbConn->query($sqlVenue);   //runs sql query

            //third SQL query to get data from the category table
            $sqlCategory = "SELECT catID, catDesc
                     FROM NE_category
                     ORDER BY catID";
            $categoryOutput = $dbConn->query($sqlCategory); //runs sql query


            if ($stmt === false) {
                echo "<p>Query failed: " . $dbConn->errorCode() . "</p>\n</body>\n</html>"; //if the query fails then an error message is displayed
            }   //Otherwise fetch all the rows returned by the query one by one
            else {
                while ($rowObj = $stmt->fetchObject()) {    //Fetches result and stores in $rowObj
                    echo "<section>
                    <!-- Start of edit form, and displays different date given stored in the rowObj variable  -->
                    <form id='UpdateEvent' action='update.php' method='get'>
		                <p>Title: <input type='text' name='eventTitle' value='$rowObj->eventTitle'></p>
		                <p>Event ID: <input type='number' name='eventID' value='{$eventID}' readonly></p>    <!-- Event ID as readonly to stop it from being edited -->
		                <p>Event Description: <input id=description name='eventDesc' value='$rowObj->eventDescription'></p>
		                <p>Category: <select name='catDesc'>
		                <!-- The following option tag and while if else statement displays the current category to and creates a list of the other categories for the user to select form -->
		                <option value='{$rowObj->catID}' hidden>{$rowObj->catDesc}</option>";
                    while ($category = $categoryOutput->fetchObject()) {
                        if ($catID = $category->catID) {
                            echo "<option value='{$category->catID}'>{$category->catDesc}</option>";
                        } else {
                            echo "<option hidden></option>";
                        }
                    }
                    echo "</select></p>
                    <p>Location: <select name='venueName'>
                    <!-- The following option tag and while if else statement displays the current category to and creates a list of the other categories for the user to select form -->
                        <option value='{$rowObj->venueID}' hidden>{$rowObj->venueName}</option>";
                    while ($venue = $venueOutput->fetchObject()) {
                        if ($venueID = $venue->venueID) {
                            echo "<option value='{$venue->venueID}'>{$venue->venueName}</option>";
                        } else {
                            echo "<option hidden></option>";
                        }
                    }
                    echo "</select>
                     <p>Start Date: <input type='date' name='eventStartDate' value='{$rowObj->eventStartDate}'></p>
                     <p>End Date: <input type='date' name='eventEndDate' value='{$rowObj->eventEndDate}'></p>
                     <p>Price: £<input type='text' name='eventPrice' value='{$rowObj->eventPrice}'></p>
                     <p><input type='submit' name='submit' value='update'></p>
                   </form>
                  </section>";
                }
            }
        } catch (Exception $e) {    //logs errors
            log_error($e);
            echo "<p>Query failed: " . $e->getMessage() . "</p>\n"; //Error message is displayed
        }
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
 * Date: 26/11/2019
 * Time: 07:33 PM
 */