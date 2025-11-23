<?php
require_once __DIR__ . '/../dao/SalaDAO.php';
$dao = new SalaDAO();

$erros = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  $numero = trim(isset($_POST['numero_sala'])?$_POST['numero_sala']:'');
  $cap    = trim(isset($_POST['capacidade'])?$_POST['capacidade']:'');
  $rec    = trim(isset($_POST['recursos_disponiveis'])?$_POST['recursos_disponiveis']:'');
  $hor    = trim(isset($_POST['horario_funcionamento'])?$_POST['horario_funcionamento']:'');

  if ($numero==='') $erros[]='Número é obrigatório';
  if ($cap!=='' && !ctype_digit($cap)) $erros[]='Capacidade deve ser numérica';
  if ($hor==='') $erros[]='Horário de funcionamento é obrigatório';

  if (empty($erros)) {
    try {
      $dao->criar($numero, ($cap===''?None:$cap), $rec, $hor);
      header('Location: ?entidade=sala&acao=listar'); exit;
    } catch (Exception $e) { $erros[] = $e->getMessage(); }
  }
}

echo '<h2>Nova Sala</h2>';
if (!empty($erros)) echo '<div style="color:#a00">'.implode('<br>', array_map('h', $erros)).'</div>';
echo '<form method="post">';
csrf_input();
echo '<label>Número: <input type="text" name="numero_sala"></label><br>';
echo '<label>Capacidade: <input type="text" name="capacidade"></label><br>';
echo '<label>Recursos: <input type="text" name="recursos_disponiveis"></label><br>';
echo '<label>Horário de funcionamento (ex: 08:00-18:00): <input type="text" name="horario_funcionamento"></label><br>';
echo '<button type="submit">Salvar</button> <a href="?entidade=sala&acao=listar">Cancelar</a>';
echo '</form>';
