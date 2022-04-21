<?php
function getConnection() {  //sql PDO database connection
    try {
        $connection = new PDO("mysql:host=localhost;dbname=unn_w17004648",
            "unn_w17004648", "Sam201718");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {    //catches errors and displays a message
        echo "<P>A problem occurred please try again</P>";
        log_error($e);  //logs errors
    }
    return "";
}

/*------------------------------------------------------------------------------*/

function getSession() {
    ini_set("session.save_path", "/home/unn_w17004648/sessionData");  //start of session
    session_start();
}

/*------------------------------------------------------------------------------*/

function makePageStart($title, $css) {  //makePageStart function which passes through the title and css variable
    $pageStartContent = <<<PAGESTART
    <!-- Core HTML tags and start of the body tag -->
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>$title</title> 
            <link href="$css" rel="stylesheet" type="text/css">
        </head>
        <body>
        <div id="gridContainer">
PAGESTART;
    $pageStartContent .="\n";
    return $pageStartContent;
}

/*------------------------------------------------------------------------------*/

function makeHeader($header){   //makeHeader function which passes through the header variable
    $headContent = <<<HEAD
		<header>
			<h1>$header</h1>
		</header>
HEAD;
    $headContent .="\n";
    return $headContent;
}

/*------------------------------------------------------------------------------*/

function makeNavMenu(array $links) {    //makeNavMenu function which passes through the links in an array
    $output = "";   //variable for nav links
    foreach ($links as $file=>$text) {  //loop through array ($links) and make a li and a for link
        $output .= "<li><a href='$file'>$text</a></li>";
    }
    $navMenuContent = <<<NAVMENU
    <!-- Nav Menu -->
		<nav>
			<ul>
                $output
			</ul>	
		</nav>
NAVMENU;
    $navMenuContent .= "\n";
    return $navMenuContent;
}

/*------------------------------------------------------------------------------*/

function loginForm(){   //loginForm function
    if (isset($_SESSION['username'])) { //if session exists logout link is made and displays the username that was used to logon
        echo '<div class="logout" id="logout">';
        $username = $_SESSION['username'];
        echo "<p>Username: $username</p>";
        echo '<a href="logout.php">Logout</a>';
        echo '</div>';
    }
    else {  //else the login form is made
        $logContent = <<<FORM
        <!-- Login form -->
        <form class="login" id="login" action="login.php" method="post">
            <label>Username
                <input type="text" name="username" tabindex="1" placeholder="Enter username" required>
            </label>
            <label>Password
                <input type="password" name="password" tabindex="2" placeholder="Enter password" required>
            </label>
            <div>
                <input type="submit" value="Login" tabindex="3">  
                <input class="submit" type="reset" value="Reset" tabindex="4">
            </div>
        </form>
FORM;
        $logContent .= "\n";
        return $logContent;
    }
    return "";
}

/*------------------------------------------------------------------------------*/

function startMain() {  //startMain function which is the start of main tag
    return "<main>\n";
}

function endMain() {    //endMain function which closes the main tag
    return "</main>\n";
}

/*------------------------------------------------------------------------------*/

function makeFooter($footer) {  //makeFooter function which passes through the footer variable
    $footContent = <<<FOOT
    <!-- Footer -->
        <footer>
            <p>$footer</p>
        </footer>
FOOT;
    $footContent .="\n";
    return $footContent;
}

/*------------------------------------------------------------------------------*/

function makePageEnd() {    //makePageEnd function which closes the core HTML tags
    return "</div>\n</body>\n</html>";
}

/*------------------------------------------------------------------------------*/

function log_error($e) {    //log_errors function which creates an error file and outputs data in the specified format
    $date = date('D M J G:i:s T Y');
    $filehandle = fopen("error_log_file.log", "ab");
    fwrite($filehandle, "$date $e" | PHP_EOL);
    fclose($filehandle);
}

/**
 * Created by PhpStorm.
 * User: SamJ
 * Date: 18/11/2019
 * Time: 03:51 PM
 */

