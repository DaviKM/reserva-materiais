<?php
require_once __DIR__ . '/../dao/ReservaDAO.php';
require_once __DIR__ . '/../dao/SalaDAO.php';
$dao = new ReservaDAO();
$sdao = new SalaDAO();

$erros = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  $data   = trim(isset($_POST['data_reserva'])?$_POST['data_reserva']:'');
  $ini    = trim(isset($_POST['horario_inicio'])?$_POST['horario_inicio']:'');
  $fim    = trim(isset($_POST['horario_termino'])?$_POST['horario_termino']:'');
  $sala   = trim(isset($_POST['numero_sala'])?$_POST['numero_sala']:'');
  $email  = trim(isset($_POST['email_usuario'])?$_POST['email_usuario']:'');

  if ($data==='') $erros[]='Data é obrigatória (YYYY-MM-DD)';
  if ($ini==='' or $fim==='') $erros[]='Horários de início e término são obrigatórios (HH:MM)';
  if ($sala==='') $erros[]='Sala é obrigatória';
  if ($email==='') $erros[]='Email do usuário é obrigatório';
  if ($ini!=='' and $fim!=='' and $ini >= $fim) $erros[]='Horário de início deve ser menor que o término';

  if (empty($erros)) {
    try {
      $codigo = $dao->criar($data, $ini, $fim, $sala, $email);
      header('Location: ?entidade=reserva&acao=listar'); exit;
    } catch (Exception $e) { $erros[] = $e->getMessage(); }
  }
}

$salas = $sdao->listarTodos();
echo '<h2>Nova Reserva</h2>';
if (!empty($erros)) echo '<div style="color:#a00">'.implode('<br>', array_map('h',$erros)).'</div>';
echo '<form method="post">';
csrf_input();
echo 'Data (YYYY-MM-DD): <input type="text" name="data_reserva"><br>';
echo 'Início (HH:MM): <input type="text" name="horario_inicio"><br>';
echo 'Término (HH:MM): <input type="text" name="horario_termino"><br>';
echo 'Sala: <select name="numero_sala">';
foreach ($salas as $s) { echo '<option value="'.h($s['numero_sala']).'">'.h($s['numero_sala']).'</option>'; }
echo '</select><br>';
echo 'Email do usuário: <input type="text" name="email_usuario" placeholder="ex: ana.aluno@example.com"><br>';
echo '<button type="submit">Salvar</button> <a href="?entidade=reserva&acao=listar">Cancelar</a>';
echo '</form>';
