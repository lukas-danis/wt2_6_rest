<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "Database.php";

$xml = simplexml_load_file("meniny.xml");

$countries = [
    "SK" => "Slovensko",
    "CZ" => "Česká republika",
    "AT" => "Rakúsko",
    "HU" => "Maďarsko",
    "PL" => "Poľsko",
];

$conn = (new Database())->createConnection();

// $day = "";
// $month = "";
// $stmtDays = $conn->prepare("INSERT IGNORE INTO days (day, month) VALUES (:day, :month)");
// $stmtDays->bindParam(':day', $day);
// $stmtDays->bindParam(':month', $month);

// $code = "";
// $title = "";
// $stmtCountries = $conn->prepare("INSERT IGNORE INTO countries (code, title) VALUES (:code, :title)");
// $stmtCountries->bindParam(':code', $code);
// $stmtCountries->bindParam(':title', $title);

// $day_id = "";
// $country_id = "";
// $type = "";
// $value = "";
// $stmtRecords = $conn->prepare("INSERT IGNORE INTO record (day_id, country_id, type, value) VALUES (:day_id, :country_id, :type, :value)");
// $stmtRecords->bindParam(':day_id', $day_id);
// $stmtRecords->bindParam(':country_id', $country_id);
// $stmtRecords->bindParam(':type', $type);
// $stmtRecords->bindParam(':value', $value);


// foreach ($xml->children() as $row) {
//     $day = substr($row->den, 2, 2);
//     $month = substr($row->den, 0, 2);
//     $stmtDays->execute();

//     $getDay = $conn->prepare("SELECT id FROM days where day=$day and month=$month");
//     $getDay->execute();
//     $day_id = $getDay->fetchColumn();

//     foreach (array_keys(((array) $row)) as $item) {
//         if (array_key_exists($item, $countries)) {
//             $code = $item;
//             $title = $countries[$item];
//             $stmtCountries->execute();

//             $getCountry = $conn->prepare("SELECT id FROM countries where code='$code'");
//             $getCountry->execute();
//             $country_id = $getCountry->fetchColumn();
//             $type = "name";

//             foreach (explode(",", $row->$item) as $name) {
//                 $value = trim($name);
//                 $stmtRecords->execute();
//             }
//         }
//     }
//     if ($row->SKd) {
//         $type = "name";
//         $code = "SK";
//         $title = $countries[$code];
//         $stmtCountries->execute();
//         $getCountry = $conn->prepare("SELECT id FROM countries where code='$code'");
//         $getCountry->execute();
//         $country_id = $getCountry->fetchColumn();
//         foreach (explode(",", $row->SKd) as $name) {
//             $value = trim($name);
//             $stmtRecords->execute();
//         }
//     }
//     if ($row->SKsviatky) {
//         $type = "SKsviatky";
//         $code = "SK";
//         $title = $countries[$code];
//         $stmtCountries->execute();
//         $getCountry = $conn->prepare("SELECT id FROM countries where code='$code'");
//         $getCountry->execute();
//         $country_id = $getCountry->fetchColumn();
//         foreach (explode(",", $row->SKsviatky) as $name) {
//             $value = trim($name);
//             $stmtRecords->execute();
//         }
//     }
//     if ($row->CZsviatky) {
//         $type = "CZsviatky";
//         $code = "CZ";
//         $title = $countries[$code];
//         $stmtCountries->execute();
//         $getCountry = $conn->prepare("SELECT id FROM countries where code='$code'");
//         $getCountry->execute();
//         $country_id = $getCountry->fetchColumn();
//         foreach (explode(",", $row->CZsviatky) as $name) {
//             $value = trim($name);
//             $stmtRecords->execute();
//         }
//     }
//     if ($row->SKdni) {
//         $type = "SKdni";
//         $code = "SK";
//         $title = $countries[$code];
//         $stmtCountries->execute();
//         $getCountry = $conn->prepare("SELECT id FROM countries where code='$code'");
//         $getCountry->execute();
//         $country_id = $getCountry->fetchColumn();
//         foreach (explode(",", $row->SKdni) as $name) {
//             $value = trim($name);
//             $stmtRecords->execute();
//         }
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="center">
        <h1 class="title">REST</h1>
        <h2 class="subtitle">Find by name and country code</h2>
        <form id="myFormName">
            <label for="name">Name</label><br>
            <input name="name" type="text" id="name"><br>

            <label for="country1">Country code</label><br>
            <input name="country" type="text" id="country1"><br>

            <input class="btn-submit" name="submit" type="submit" value="Submit">
        </form>

        <h2 class="subtitle">Find by date and name</h2>
        <form id="myFormDate">
            <label for="date">Date (format DDMM)</label><br>
            <input name="date" type="text" id="date"><br>

            <label for="country2">Country code</label><br>
            <input name="country" type="text" id="country2"><br>

            <input class="btn-submit" name="submit" type="submit" value="Submit">
        </form>
        <h2 class="subtitle">Find special days</h2>
        <form id="mySpecialDay">
            <label for="special">Type: SKsviatky, CZsviatky, SKdni</label><br>
            <input name="special" type="text" id="special"><br>
            <input class="btn-submit" name="submit" type="submit" value="Submit">
        </form>


        <h2 class="subtitle">Add name for chosen date</h2>
        <form id="myInsertForm">
            <label for="name">Name</label><br>
            <input name="name" type="text" id="name1"><br>

            <label for="date">Date (format DDMM)</label><br>
            <input name="date" type="text" id="date2"><br>

            <input class="btn-submit" name="submit" type="submit" value="Submit">
        </form>
        <div>
            <h2 class="subtitle">Delete and put calls</h2>
            <button class="btn-submit bottom-btn" id="myDELETE">DELETE method call</button><br>
            <button class="btn-submit bottom-btn" id="myPUT">PUT method call</button>
        </div>
        <h2 class="subtitle">Received data</h2>
        <span>-------------------------------------------------------------------------------------------------</span>
        <div id="myDiv"></div>
        <span>-------------------------------------------------------------------------------------------------</span>
        <p class="info">
            Tlačidlo na submit zavolá js funkciu, v nej pomocou ajax-u odošlem požadovaný request a dátami. Na strane servera prečítam dáta s ktorými nájdem 
            alebo pridam do databazy údaje, na základe type metódy a vrátim json. Json chytám v ajax-e v ćasti success, kde zobrazujem jeho údaje na stránku.
        </p>
    </div>

</body>

</html>