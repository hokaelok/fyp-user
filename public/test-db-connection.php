<?php
try {
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=fyp_user', 'root', 'your_password');
  echo "Connected successfully to user service database";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
