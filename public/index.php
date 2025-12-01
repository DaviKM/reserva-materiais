<?php
require_once __DIR__ . '/../config/db.php';

$entidade = isset($_GET['entidade']) ? $_GET['entidade'] : 'home';
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'index';

$arquivo = __DIR__ . '/../src/controller/' . $entidade . '_' . $acao . '.php';
if (file_exists($arquivo)) {
  require $arquivo;
  exit;
}

?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Empréstimo de Materiais</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <header>
    <div>
      <i class="fa-regular fa-futbol"></i>
      <h1>Sistema de Empréstimo de Materiais Esportivos</h1>
    </div>
    
  </header>

  <section id="corpo">
    <main>
      <div>
        <h2>Bem-vindo</h2>
        <p>Reserve e gerencie empréstimos de materiais esportivos de forma simples e interativa.</p>
      </div>
      <nav>
        <a href="?entidade=aluno&acao=listar"><button type="button">Alunos</button></a>
        <a href="?entidade=material&acao=listar"><button type="button">Materiais</button></a>
        <a href="?entidade=emprestimo&acao=listar"><button type="button">Empréstimos</button></a>
        <a href="?entidade=emprestimo&acao=por_dia"><button type="button">Empréstimos por dia</button></a>
      </nav>
      <div id="conexao">
        <p><strong>Status da Conexão:</strong>
          <?php
          try {
            getPDO();
            echo '<span class="ok">OK</span>';
          } catch (Exception $e) {
            echo '<span class="erro">Falhou</span>';
          }
          ?>
      </div>
    </main>
  </section>
  </p>
</body>

</html>