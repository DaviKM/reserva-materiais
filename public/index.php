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
  <title>Empréstimo de Materiais - Primeira Versão Funcional</title>
  <link rel="stylesheet" href="assets/menu.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <header>
  <i class="fa-regular fa-futbol"></i>
    <h1>Sistema de Empréstimo de Materiais</h1>

  </header>
  <main>
    <nav>
      <a href="?entidade=material&acao=listar">Materiais</a>
      <a href="?entidade=emprestimo&acao=listar">Empréstimos</a>
      <a href="?entidade=emprestimo&acao=por_dia">Empréstimos por dia</a>
    </nav>
    <p>Bem-vindo! Utilize o menu acima para navegar.</p>
  </main>
  <p><strong>Status da Conexão:</strong> 
    <?php
      try { getPDO(); echo '<span class="ok">OK</span>'; } 
      catch (Exception $e) { echo '<span class="erro">Falhou</span>'; }
    ?>
  </p>
</body>
</html>
