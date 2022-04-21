<?php
require_once('functions.php');  // includes function list file
getSession();   //start of session

$username = filter_has_var(INPUT_POST, 'username')
    ? $_POST['username']: null;
$username = trim($username);    //trims down username of empty, blank and 'white spaces'
$password = filter_has_var(INPUT_POST, 'password')
    ? $_POST['password']: null;
$password = trim($password);    //trims down password of empty, blank and 'white spaces'


if (empty($username) || empty($password)) { //if username or password is empty then displays a message and link back to main page
    echo "<p>No username or password has been entered. Please try again.</p>";
    echo "<a href='index.php'>Click Here</a>";
    $errors = true; //error check
}

if (strlen($username)>50 || (strlen($password)>50)) { //if username or password is above 50 characters then displays a message and link back to main page
    echo "<p>The username and password must be 50 characters or less. Please try again.</p>";
    echo "<a href='index.php'>Click Here</a>";
    $errors = true; //error check
}


else $errors = false;{  //else error check successful then try following code
    try {


        unset($_SESSION['username']);   //remove any existing username from the session
        unset($_SESSION['logged-in']);  //remove any existing password from the session

        require_once("functions.php");
        $dbConn = getConnection();  //database connection

        //SQL query
        $querySQL = "SELECT passwordHash FROM NE_users 
                         WHERE username = :username";
        $stmt = $dbConn->prepare($querySQL);    //prepare sql query
        $stmt->execute(array(':username' => $username)); //runs sql query

        $user = $stmt->fetchObject();   //Fetches result and stores in $rowObj
        if ($user) {
            if (password_verify($password, $user->passwordHash)) {
                $_SESSION['logged-in'] = true;  //a session variable is created called 'logged-in' and is set to true to show the user login was successful
                $_SESSION['username'] = $username;  //a session variable is created called 'username' and is set to the same value as the users username
                header('location: ' .$_SERVER['HTTP_REFERER']);
            } else {
                echo "<p>The username or password entered was incorrect. Please try again.</p>\n";
                echo "<a href='index.php'>Click Here</a>";
            }
        } else {
            echo "<p>The username or password entered was incorrect. Please try again.</p>\n";
            echo "<a href='index.php'>Click Here</a>";
        }
    } catch (Exception $e) {
        echo "There was a problem: " . $e->getMessage();
    }
}

/**
 * Created by PhpStorm.
 * User: SammyJ
 * Date: 25/11/2019
 * Time: 07:54 PM
 */