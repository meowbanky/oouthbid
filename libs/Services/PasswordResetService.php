<?php
namespace App\Services;

use App\Database;

class PasswordResetService {
private $database;

public function __construct(Database $database) {
$this->database = $database;
}

public function validateToken($token) {
$query = "SELECT * FROM account_token WHERE token = :token AND status = 0 AND expiry > NOW()";
return $this->database->selectOne($query, [':token' => $token]);
}

public function resetPassword($userId, $newPassword) {
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$query = "UPDATE users SET password = :password WHERE id = :user_id";
$this->database->executeNonSelect($query, [
':password' => $hashedPassword,
':user_id' => $userId,
]);
}

public function markTokenAsUsed($token) {
$query = "UPDATE account_token SET status = 1 WHERE token = :token";
$this->database->executeNonSelect($query, [':token' => $token]);
}
}
?>