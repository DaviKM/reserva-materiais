<?php
require_once __DIR__ . '/../config/db.php';

$entidade = isset($_GET['entidade']) ? $_GET['entidade'] : 'home';
$acao     = isset($_GET['acao']) ? $_GET['acao'] : 'index';

$arquivo = __DIR__ . '/../src/controller/' . $entidade . '_' . $acao . '.php';
if (file_exists($arquivo)) {
  require $arquivo;
  exit;
}

?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Reserva de Salas - Primeira Versão Funcional</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    nav a { margin-right: 12px; }
    table { border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 6px 8px; }
    .ok { color: #0a0; }
    .erro { color: #a00; }
  </style>
</head>
<body>
  <h1>Sistema de Reserva de Salas</h1>
  <nav>
    <a href="?entidade=sala&acao=listar">Salas</a>
    <a href="?entidade=reserva&acao=listar">Reservas</a>
    <a href="?entidade=reserva&acao=por_dia">Reservas por dia</a>
  </nav>
  <p>Bem-vindo! Utilize o menu acima para navegar.</p>
  <p><strong>Status da Conexão:</strong> 
    <?php
      try { getPDO(); echo '<span class="ok">OK</span>'; } 
      catch (Exception $e) { echo '<span class="erro">Falhou</span>'; }
    ?>
  </p>
</body>
</html>
