<?php
require 'vendor/autoload.php';
// Function to sanitize inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Spawn Connection Object
function make_connection() {
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        exit();
    }
    return $conn;
}

// SQL function
// You need to pass in a connection object and close the object at the end of the page
// Statement creation and closing is handled in this function
function payload_deliver($conn, $query, $types = null, $params = null) {
    // Prepare the statement:
    $stmt = $conn->prepare($query);

    // Bind the query statement:
    if ($types != null && $params != null) {
        $stmt->bind_param($types, ...$params);
    }

    // Execute the query statement:
    if (!$stmt->execute()) {
        echo "Failed while executing query: Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        $conn->close();
        exit();
    }

    // Get Result
    $result = $stmt->get_result();
    $stmt->close();

    return $result;
}

function payload_deliver_verbose($conn, $query, $types = null, $params = null) {
    
    $errorMsg = "";
    
    // Prepare the statement:
    $stmt = $conn->prepare($query);

    // Bind the query statement:
    if ($types != null && $params != null) {
        $stmt->bind_param($types, ...$params);
    }

    // Execute the query statement:
    if (!$stmt->execute()) {
        $errorMsg .= "Failed while executing query: Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        $conn->close();
        return array("success" => false, "data" => $errorMsg);
    } 

    // Get Result
    $result = $stmt->get_result();
    $stmt->close();

    return array("success" => true, "data" => $result);
}


// Print Page Selector
function print_page($page, $total_pages) {
    if ($total_pages == 0) {
        echo '<span style="font-size:1.4rem;">Page 0 of 0</span>';
    } else {
        echo '<span style="font-size:1.4rem;">Page ';
        if ($page > 1) {
            echo '<span><a class="prev-page" href="#" style="color: #0000ff;"><-</a></span>';
        }
        echo '<span class="current-page">' . $page . '</span> of <span class="pages">' . $total_pages . '</span>';
        if ($page < $total_pages) {
            echo '<span><a class="next-page" href="#" style="color: #0000ff;">-></a></span>';
        }
        echo '</span>';
    }
}

$delivery_charge_actual = 5;
$service_charge_multiplier = 0.05;

function make_mongo_connection() {
    $config = parse_ini_file('../../private/mongo-config.ini');
    $client = new MongoDB\Client("mongodb://" . $config['username'] . ":" . $config['password'] . "@localhost:27017");
    $db = $client->SMart;
    
    return $db;
}
?>

