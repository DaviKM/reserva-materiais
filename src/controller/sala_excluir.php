<?php
require_once __DIR__ . '/../dao/SalaDAO.php';
$dao = new SalaDAO();
$numero = isset($_GET['numero'])?$_GET['numero']:'';

try {
  if ($numero!=='') { $dao->excluir($numero); }
  header('Location: ?entidade=sala&acao=listar');
  exit;
} catch (Exception $e) {
  echo '<h2>Exclusão de Sala</h2>';
  echo '<div class="error">'.h($e->getMessage()).'</div>';
  echo '<p><a href="?entidade=sala&acao=listar">Voltar para a lista de salas</a></p>';
}
