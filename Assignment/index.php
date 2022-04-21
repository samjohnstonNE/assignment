<?php
require('functions.php');   // includes function list file
getSession();   //start of session
echo makePageStart("North Events", "style.css");    //calls functions from the and dynamically creates sections of the page
echo makeHeader("Northern Events");
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
<span class="special">Special Offers</span>
<aside id="offers"> <!-- Aside tag with ids of 'offers' -->
</aside>

<script>    //start of the javascript tag
window.addEventListener('load', function () {   //Adds an event listener on the window
    "use strict";

    const URL_Offers = 'getOffers.php'; //Declares a constant called URL_OFFERS and...
                                            //link to a file containing more code that will be used with the code below
    function fetchOffers() {    //Function called fetchOffers which will display information about the special offers
        fetch(URL_Offers)           //the function will also log any data in the console
            .then(
                function (response) {
                    return response.text(); //returns the response as text
                })
            .then(
                function (data) {
                    console.log(data);  //logs data
                    document.getElementById('offers').innerHTML = "<p>" + data + "</p>";    //displays data provided from the 'getOffers.php' function in id='offers' inside the <aside> tag of the page
                })
            .catch(
                function (err) {
                    console.log("Something went wrong!", err);  //if else statement logs error and displays message in console
                });
    }
    fetchOffers();  //calls function
    setInterval(function () { fetchOffers() }, 5000);   //reloads the function fetchOffers every 5 seconds displaying a new offer
});
</script>

<h3>XML Offers</h3>
<aside id="XMLoffers">  <!-- Aside tag with ids of 'XMLoffers' -->
</aside>

<script>    //start of the javascript tag
window.addEventListener('load', function () {   //Adds an event listener on the window
    "use strict";

    const URL_XMLOffers = 'getOffers.php?useXML';   //Declares a constant called URL_XMLOFFERS and...
                                                        //link to a file containing more code that will be used with the code below
    function fetchXMLOffers() {     //Function called fetchXMLOffers which will display information about the XML offers
        fetch(URL_XMLOffers)            //the function will also log any data in the console
            .then(
                function (response) {
                    return response.text(); //returns the response as text
                })
            .then(
                function (data) {
                    console.log(data);  //logs data
                    let parser = new DOMParser();   //Creates a parser for the XML to be put into DOC form
                    let xmlDoc = parser.parseFromString(data,"text/xml");   //Creates a variable called xmlDoc which the value will be the parsed version of the data in text/xml
                    let xmlAside = document.getElementById('XMLoffers');    //Create a variable which allow me to select the area to display data
                    let eventTitle = xmlDoc.getElementsByTagName("eventTitle")[0].innerHTML;    //The next 3 lines will get 3 different sets of data and input them using innerHTML
                    let catDesc = xmlDoc.getElementsByTagName("catDesc")[0].innerHTML;
                    let eventPrice = xmlDoc.getElementsByTagName("eventPrice")[0].innerHTML;
                    xmlAside.innerHTML ='<p>Event: <b>"' + eventTitle  + '"</b><br>Category: ' + catDesc + '<br>Price: £' + eventPrice + '<p>'; //uses the variable from before to use the 'getOffers.php' function and...
                })                                                                                                                                  //display the data in id='XMLoffers' inside the <aside> tag of the page
            .catch(
                function (err) {
                    console.log("Something went wrong!", err);  //if else statement logs error and displays message in console
                });
    }
    fetchXMLOffers();   //calls function
});
</script>
<?php
echo endMain(); //end of the main tag
echo makeFooter("Designed by Sam Johnston - W17004648");
echo makePageEnd(); //end of the page

/**
 * Created by PhpStorm.
 * User: SamJ
 * Date: 18/11/2019
 * Time: 03:50 PM
 */
?>
