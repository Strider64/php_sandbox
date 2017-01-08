<?php
include 'lib/includes/connect/connect.php';

$db_options = [
    /* important! use actual prepared statements (default: emulate prepared statements) */
    PDO::ATTR_EMULATE_PREPARES => false
    /* throw exceptions on errors (default: stay silent) */
    , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    /* fetch associative arrays (default: mixed arrays)    */
    , PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
];
if (filter_input(INPUT_POST, submit)) {

    $pdo = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=world;charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD, $db_options);

    $query = 'SELECT Name, CountryCode, District, Population FROM city WHERE CountryCode=:CountryCode'; // Set the Search Query:

    $stmt = $pdo->prepare($query); // Prepare the query:

    $result = $stmt->execute([':CountryCode' => filter_input(INPUT_POST, countryCode)]); // Execute the query with the supplied user's parameter(s):
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Database Search</title>
        <link rel="stylesheet" href="lib/css/reset.css">
        <link rel="stylesheet" href="lib/css/grids.css">
        <link rel="stylesheet" href="lib/css/searchstyle.css">
    </head>
    <body>
        <div class="container seachBackground">
            <form id="searchForm" action="search.php" method="post">
                <label for="searchStyle">search</label>
                <input id="searchStyle" type="text" name="countryCode" value="" placeholder="Enter Country Code (For Exampe : USA)..." tabindex="1" autofocus>
                <input type="submit" name="submit" value="submit" tabindex="2">
            </form>
        </div>
        <div <?= $result ? 'class="turnOn" ' : 'class="turnOff" '; ?>>
            <table id="search" summary="Cities Around the World!">
                <thead>
                    <tr>
                        <th scope="col">City</th>
                        <th scope="col">Country Code</th>
                        <th scope="col">District / State</th>
                        <th scope="col">Population</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result) {
                        while ($record = $stmt->fetch()) {
                            echo "<tr>";
                            echo '<td>' . $record->Name . "</td>";
                            echo '<td>' . $record->CountryCode . "</td>";
                            echo '<td>' . $record->District . "</td>";
                            echo '<td>' . $record->Population . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </body>
</html>