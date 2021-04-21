<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../Database.php";

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json;charset=UTF-8");

$conn = (new Database())->createConnection();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    if (isset($_GET["name"]) && isset($_GET["country"])) {
        // https://wt35.fei.stuba.sk/cv6/api/?name=Lukáš&country=SK
        $name = $_GET["name"];
        $country_code = $_GET["country"];
        $stmt = $conn->prepare("SELECT record.value, days.day, days.month, countries.title FROM record 
                            left join days on record.day_id = days.id
                            left join countries on record.country_id = countries.id
                            where record.value=:name and countries.code=:country_code and record.type='name'");
        $stmt->bindParam("name", $name);
        $stmt->bindParam("country_code", $country_code);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result != null) {
            $results[] = array(
                'value' => $result['value'],
                'day' => $result['day'],
                'month' => $result['month'],
                'title' => $result['title']
            );
            $json = json_encode($results);
        } else {
            $msg = "Nenajdene name- country kombinacia";
            $json = json_encode(false);
        }

        echo $json;
    } else if (isset($_GET["date"]) && isset($_GET["country"])) {
        // https://wt35.fei.stuba.sk/cv6/api/?date=2412&country=SK
        $find_day = substr($_GET["date"], 0, 2);
        $find_month = substr($_GET["date"], 2, 2);
        $country_code = $_GET["country"];
        $stmt = $conn->prepare("SELECT record.value FROM record 
                                    left join days on record.day_id = days.id
                                    left join countries on record.country_id = countries.id
                                    where days.day=:find_day and days.month=:find_month and countries.code=:country_code and record.type='name'");
        $stmt->bindParam("find_day", $find_day);
        $stmt->bindParam("find_month", $find_month);
        $stmt->bindParam("country_code", $country_code);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($result != null) {
            foreach ($result as $row) {
                $results[] = array(
                    'value' => $row['value']
                );
            }
            $json = json_encode($results);
        } else {
            $msg = "Nenajdene date-country komcinacia";
            $json = json_encode(false);
        }

        $json = json_encode($results);
        echo $json;
    } else if (isset($_GET["special"])) {
        // https://wt35.fei.stuba.sk/cv6/api/?special=SKdni
        $day_type = $_GET["special"];
        $stmt = $conn->prepare("SELECT record.value, days.day, days.month FROM record 
                                    left join days on record.day_id = days.id
                                    left join countries on record.country_id = countries.id
                                    where record.type=:day_type");
        $stmt->bindParam("day_type", $day_type);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($result != null) {
            foreach ($result as $row) {
                $results[] = array(
                    'value' => $row['value'],
                    'day' => $row['day'],
                    'month' => $row['month']
                );
            }
            $json = json_encode($results);
        } else {
            $msg = "Nenajdene special";
            $json = json_encode(false);
        }

        echo $json;
    } else {
        // $stmt = $conn->prepare("SELECT * FROM countries");
        // $stmt->execute();
        // $result = $stmt->fetchAll();
        // foreach ($result as $row) {
        //     $results[] = array(
        //         'title' => $row['title'],
        //         'code' => $row['code']
        //     );
        // }
        // $json = json_encode($results);
        echo json_encode(false);
    }
} else if ($method == "POST") {
    if (isset($_POST["name"]) && isset($_POST["date"])) {
        $find_day = substr($_POST["date"], 0, 2);
        $find_month = substr($_POST["date"], 2, 2);
        $name = $_POST["name"];
        $type = "name";
        $code = "SK";
        $stmt = $conn->prepare("SELECT days.id from days where day=:find_day and month=:find_month");
        $stmt->bindParam("find_day", $find_day);
        $stmt->bindParam("find_month", $find_month);
        $stmt->execute();

        $day_id = $stmt->fetch();
        $stmt = $conn->prepare("SELECT countries.id from countries where code=:code");
        $stmt->bindParam("code", $code);
        $stmt->execute();

        $country_id = $stmt->fetch();
        $stmtRecords = $conn->prepare("INSERT IGNORE INTO record (day_id, country_id, type, value) VALUES (:day_id, :country_id, :type, :value)");
        $stmtRecords->bindParam('day_id', $day_id["id"]);
        $stmtRecords->bindParam('country_id', $country_id["id"]);
        $stmtRecords->bindParam('type', $type);
        $stmtRecords->bindParam('value', $name);
        $result = $stmtRecords->execute();
        echo json_encode($result);
    } else {
        echo json_encode(false);
    }
} else if ($method == "PUT") {
    $msg = "PUT method called";
    echo json_encode($msg);
} else if ($method == "DELETE") {
    $msg = "DELETE method called";
    echo json_encode($msg);
} else {
    $result = "Wrong method call (use GET, POST, PUT, DELETE)";
    $json = json_encode($result);
}
