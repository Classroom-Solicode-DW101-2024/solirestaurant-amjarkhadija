<?php
session_start();

$host = 'localhost';
$dbname = 'solirestaurant';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

function getLastIdClient() {
    global $pdo;
    $sql = "SELECT MAX(idClient) AS maxId FROM client";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['maxId'] ?? 0;
}

function tel_existe($tel) {
    global $pdo;
    $sql = "SELECT * FROM client WHERE telCl = :tel";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tel', $tel);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




?>
