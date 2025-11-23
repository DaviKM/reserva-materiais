<?php
require_once __DIR__ . '/../dao/SalaDAO.php';
$dao = new SalaDAO();

$numero = isset($_GET['numero'])?$_GET['numero']:'';
$sala = $dao->buscarPorNumero($numero);
if (!$sala) { echo 'Sala não encontrada'; exit; }

$erros = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  $cap = trim(isset($_POST['capacidade'])?$_POST['capacidade']:'');
  $rec = trim(isset($_POST['recursos_disponiveis'])?$_POST['recursos_disponiveis']:'');
  $hor = trim(isset($_POST['horario_funcionamento'])?$_POST['horario_funcionamento']:'');

  if ($cap!=='' && !ctype_digit($cap)) $erros[]='Capacidade deve ser numérica';
  if ($hor==='') $erros[]='Horário de funcionamento é obrigatório';

  if (empty($erros)) {
    $dao->atualizar($numero, ($cap===''?NULL:$cap), $rec, $hor);
    header('Location: ?entidade=sala&acao=listar'); exit;
  }
} else {
  $_POST = $sala;
}

echo '<h2>Editar Sala</h2>';
if (!empty($erros)) echo '<div style="color:#a00">'.implode('<br>', array_map('h',$erros)).'</div>';
echo '<form method="post">';
csrf_input();
echo '<label>Número: <input type="text" value="'.h($numero).'" disabled></label><br>';
echo '<label>Capacidade: <input type="text" name="capacidade" value="'.h(isset($_POST['capacidade'])?$_POST['capacidade']:'').'"></label><br>';
echo '<label>Recursos: <input type="text" name="recursos_disponiveis" value="'.h(isset($_POST['recursos_disponiveis'])?$_POST['recursos_disponiveis']:'').'"></label><br>';
echo '<label>Horário: <input type="text" name="horario_funcionamento" value="'.h(isset($_POST['horario_funcionamento'])?$_POST['horario_funcionamento']:'').'"></label><br>';
echo '<button type="submit">Salvar</button> <a href="?entidade=sala&acao=listar">Cancelar</a>';
echo '</form>';
