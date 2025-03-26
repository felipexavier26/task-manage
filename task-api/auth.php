<?php
require 'vendor/autoload.php'; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secretKey = "secreto123"; 

function generateJWT($user) {
    global $secretKey;
    $payload = [
        'user' => $user,
        'exp' => time() + (60 * 60) 
    ];
    return JWT::encode($payload, $secretKey, 'HS256');
}

function verifyJWT($token) {
    global $secretKey;
    try {
        return JWT::decode($token, new Key($secretKey, 'HS256'));
    } catch (Exception $e) {
        return null;
    }
}
?>
