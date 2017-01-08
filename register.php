<?php
require_once 'lib/includes/utilities.inc.php'; // Configuration file settings and autoloaders:

$db_options = [
    /* important! use actual prepared statements (default: emulate prepared statements) */
    PDO::ATTR_EMULATE_PREPARES => false
    /* throw exceptions on errors (default: stay silent) */
    , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    /* fetch associative arrays (default: mixed arrays)    */
    , PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
$pdo = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD, $db_options);
$submit = filter_input(INPUT_POST, submit);
if ($submit === 'register') {
    
    $password = password_hash(filter_input(INPUT_POST, password), PASSWORD_BCRYPT, ["cost" => 15]);
    
    $query = ' INSERT INTO ' . DATABASE_TABLE . ' (username, password, description) VALUES (:username, :password, :description)';
    
    $stmt = $pdo->prepare($query);
    
    $result = $stmt->execute([':username' => filter_input(INPUT_POST, username), ':password' => $password, ':description' => filter_input(INPUT_POST, description)]);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registration Tutorial</title>
        <link rel="stylesheet" href="lib/css/reset.css">
        <link rel="stylesheet" href="lib/css/grids.css">
        <link rel="stylesheet" href="lib/css/registerstyle.css">
    </head>
    <body>
        <div class="container">
            <form id="register" class="" action="register.php" method="post">
                <fieldset>
                    <legend>Registration Form</legend>
                    <label for="username">username</label>
                    <input id="username" type="text" name="username" value="" tabindex="1" autofocus>
                    <label for="password">password</label>
                    <input id="password" type="password" name="password" tabindex="2">
                    <label for="verify_password">verify password</label>
                    <input id="verify_password" type="password" name="verify_password" tabindex="3">
                    <label id="labelDescription" for="description">description</label>
                    <textarea id="description" name="description" placeholder="Enter description here...." tabindex="4"></textarea>
                    <input type="submit" name="submit" value="register" tabindex="5">
                </fieldset>
            </form>
        </div>
    </body>
</html>
