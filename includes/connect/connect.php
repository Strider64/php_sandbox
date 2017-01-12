<?php

$server_name = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL);
define('BASE_PATH', realpath(dirname(__FILE__)));
/* Setup constants for local server and remote server */
define('EMAIL_HOST', 'Email Host Name');
define('EMAIL_USERNAME', 'Username');
define('EMAIL_PASSWORD', 'Password');
define('EMAIL_ADDRESS', 'Email Address');
define('EMAIL_PORT', 587); // Local Port Address
define('PRIVATE_KEY', 'Private Key for ReCaptcha');

define("EMAIL_ADDRESS_ONE", "email address");
define("EMAIL_ADDRESS_TWO", "email address");
define("EMAIL_ADDRESS_THREE", "email address");
define("EMAIL_NAME", "Name");

$users = [['email' => 'email address for swift mailer']];

$email_address_one = 'email address for swiftmailer';


if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
    define('DATABASE_HOST', 'local host name');
    define('DATABASE_NAME', 'database name');
    define('DATABASE_USERNAME', 'root -> usually this');
    define('DATABASE_PASSWORD', 'password');
    define('DATABASE_TABLE', 'database table name');
} else {

}
