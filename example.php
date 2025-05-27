<?php
require_once __DIR__ . '/vendor/autoload.php';

use RomDomain\UserDomain;

$user = new UserDomain();
$user->name = '';
$user->age = 15;
$user->email = 'not-an-email';
$user->username = 'usr';
$user->phoneNumber = 'abc';
$user->website = 'not-a-url';
$user->password = '123456';
$user->confirmPassword = '654321';

$isValid = $user->isValidDomain();
$errors = $user->getValidationErrors();

$response = [
    'success' => $isValid,
    'errors' => array_map(fn($e) => ['field' => $e->field, 'message' => $e->message], $errors)
];

header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
