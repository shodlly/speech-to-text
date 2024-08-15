<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "server";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$text = $_POST['text'] ?? '';

if ($text) {

    $stmt = $conn->prepare("INSERT INTO texts (text) VALUES (?)");
    $stmt->bind_param("s", $text);

    if ($stmt->execute()) {
        echo "Text saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No text provided!";
}

$conn->close();
?>
