<?php
// config/db.php - conexão PDO centralizada (PHP 5.x)
function getPDO() {
  $host = '127.0.0.1';
  $db   = 'reservamateriais';
  $user = 'root';   // ajuste usuário/senha conforme seu XAMPP
  $pass = '';       // em XAMPP padrão costuma ser vazio
  $dsn  = "mysql:host=$host;dbname=$db;charset=utf8";

  try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  } catch (PDOException $e) {
    die('Erro de conexão: ' . $e->getMessage());
  }
}

function h($s) {
  return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

// CSRF helpers (mínimo)
if (session_id() === '') { session_start(); }
if (!isset($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(16));
}
function csrf_input() {
  echo '<input type="hidden" name="csrf" value="'.h($_SESSION['csrf']).'">';
}
function csrf_check() {
  if (!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
    die('Falha de verificação CSRF.');
  }
}
