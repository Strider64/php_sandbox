<?php
date_default_timezone_set("America/Detroit"); // Set Default Timezone:
/*
 * START OF CREATING DATABASE AND TABLE 
 */
$db = new SQLite3('mysimpleblog.db') or die('Unable to open database');
$sql = <<<EOD
  CREATE TABLE IF NOT EXISTS mysimpleblog (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(60) NOT NULL,
        title VARCHAR(60) NOT NULL,
        message TEXT NOT NULL)
EOD;

$ret = $db->exec($sql);
if (!$ret) {
    echo $db->lastErrorMsg();
} else {
    //echo "Table created successfully\n";
}
$db->close();

/*
 * END OF CREATING DATABASE AND TABLE 
 * CAN COMMENT THE ABOVE OUT ONCE IT WAS RUN ONCE IF SO DESIRED
 */

try {
    /*
     * Connect to SQLite database
     */
    $pdo = new PDO("sqlite:mysimpleblog.db");
} catch (PDOException $e) {
    echo $e->getMessage();
}

$submit = filter_input(INPUT_POST, 'submit');

if (isset($submit) && $submit === "Submit") {
    /* Create a query using prepared statements */
    $query = 'INSERT INTO mysimpleblog( name, title, message) VALUES ( :name, :title, :message)';
    /* Prepared the Statement */
    $stmt = $pdo->prepare($query);
    /* Excute the statement with the prepared values */
    $result = $stmt->execute([':name' => filter_input(INPUT_POST, 'name'), ':title' => filter_input(INPUT_POST, 'title'), ':message' => filter_input(INPUT_POST, 'message')]);
    /* Check to see it was successfully entered into the database table. */
    if ($result) {
        header("Location: mysimpleblog.php");
        exit();
    } else {
        echo 'Error, Something went wrong';
    }
}

/*
 * Setup the query 
 */
$query = 'SELECT id, name, title, message FROM mysimpleblog ORDER BY id DESC';
/*
 * Prepare the query 
 */
$stmt = $pdo->prepare($query);
/*
 * Execute the query 
 */
$result = $stmt->execute();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Contact Form</title>
        <link rel="stylesheet" href="lib/css/reset.css">
        <link rel="stylesheet" href="lib/css/grids.css">
        <link rel="stylesheet" href="lib/css/mysimpleblog.css">
    </head>
    <body>
        <div id="mySimpleBlogForm" class="container">
            <form id="searchForm" action="mysimpleblog.php" method="post">
                <label for="name">Name</label>
                <input id="name"type="text" name="name" value="">
                <label for="title">title</label>
                <input id="title" type="text" name="title">
                <label id="labelTextarea"  for="message">Message</label>
                <textarea id="message" name="message"></textarea>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
        <?php
        /*
         * Display the output
         */
        while ($record = $stmt->fetch(PDO::FETCH_OBJ)) {
            echo '<div class = "container mySimpleBlog span6">';
            echo '<h2>' . $record->title . '<span>by ' . $record->name . ' </span></h2>';
            echo '<p>' . $record->message . '</p>';
            echo '</div>';
        }
        ?>
    </body>
</html>