<?php
require_once('functions.php');  // includes function list file
getSession();   //start of session
echo makePageStart("North Events: Admin", "style.css"); //calls functions from the and dynamically creates sections of the page
echo makeHeader("Northern Events: Admin");
echo makeNavMenu(array("index.php" => "Home", "bookEventsForm.php" => "Events", "admin.php" => "Admin", "credits.php" => "Credits"));
echo loginForm();   //calls function and creates logout link
echo startMain();   //start of the main tag
if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {  //checks the login status with if else statement. if not logged in then jumps else


    try {
        $dbConn = getConnection();  //database connection

        //SQL query to get data from the database
        $sql = "SELECT eventID, eventTitle, venueName, catDesc, location, eventStartDate, eventEndDate, eventPrice
                FROM NE_events
                INNER JOIN NE_venue
                ON NE_venue.venueID = NE_events.venueID
                INNER JOIN NE_category
                ON NE_category.catID = NE_events.catID
                ORDER BY eventTitle";
        $stmt = $dbConn->prepare($sql); //preparing the sql query
        $stmt->execute();   //executing the query

        if ($stmt === false) {
            echo "<p>Query failed: " . $dbConn->errorCode() . "</p>\n</body>\n</html>"; //if the query fails then an error message is displayed
            exit;
        }   //Otherwise fetch all the rows returned by the query one by one
        else {
            while ($rowObj = $stmt->fetchObject()) {    //Fetches result and stores in $rowObj
                echo "<div class='records'>   
                    <table class='data'>
                        <tr>
                        <!-- Heading for the table -->
                          <th class='eventTitle'>Title</th>
                          <th class='eventID'>Event ID</th>
                          <th class='venueName'>Venue</th>
                          <th class='catDesc'>Category</th>
                          <th class='location'>Location</th>
                          <th class='eventStartDate'>Start Date</th>
	                      <th class='eventEndDate'>End Date</th>
	                      <th class='eventPrice'>Event Price</th>
                        </tr>
                        <tr>
                          <td class='eventTitle'><a href='edit.php?eventID={$rowObj->eventID}'>{$rowObj->eventTitle}</a></td>    <!-- Link to edit page is through the eventID while displaying the event title -->
                          <td class='eventID'>{$rowObj->eventID}</td>
                          <td class='venueName'>{$rowObj->venueName}</td>
                          <td class='catDesc'>{$rowObj->catDesc}</td>
                          <td class='location'>{$rowObj->location}</td>
                          <td class='eventStartDate'>{$rowObj->eventStartDate}</td>
                          <td class='eventEndDate'>{$rowObj->eventEndDate}</td>
	                      <td class='eventPrice'>{$rowObj->eventPrice}</td>
                        </tr>
                    </table>
                   </div>\n";
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