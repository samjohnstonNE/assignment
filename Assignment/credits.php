<?php
require_once('functions.php');  // includes function list file
getSession();   //start of session
echo makePageStart("North Events: Credits", "style.css");   //calls functions from the and dynamically creates sections of the page
echo makeHeader("Northern Events: Credits");
if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {  //checks the login status
    echo makeNavMenu(array("index.php" => "Home", "bookEventsForm.php" => "Events", "admin.php" => "Admin", "credits.php" => "Credits"));   //when logged in will display the link to the admin page
    echo loginForm();   //calls function and creates logout link
}
else{
    echo makeNavMenu(array("index.php" => "Home", "bookEventsForm.php" => "Events", "credits.php" => "Credits"));
    echo loginForm();   //calls function and creates login form
}
echo startMain();   //start of the main tag
?>
<p>Student Name: Sam Johnston</p>
<p>Student Email: sam3.johnston@northumbria.ac.uk</p>
<p>Student ID: W17004648</p>
<p>Northumbria University</p>
<h2>Resources:</h2>
<p><a href="https://www.w3schools.com/" target="_blank">W3 schools</a></p>
<?php
echo endMain(); //end of the main tag
echo makeFooter("Designed by Sam Johnston - W17004648");
echo makePageEnd(); //end of the page

/**
 * Created by PhpStorm.
 * User: SamJ
 * Date: 18/11/2019
 * Time: 04:04 PM
 */

