<?php
require_once __DIR__ . '/../dao/ReservaDAO.php';
$dao = new ReservaDAO();
$rows = $dao->listarTodos();

echo '<h2>Reservas</h2>';
echo '<p><a href="?entidade=reserva&acao=criar">Nova Reserva</a> | <a href="/gestaosalas_app/public/index.php">Home</a></p>';
echo '<table><tr><th>Código</th><th>Data</th><th>Início</th><th>Término</th><th>Status</th><th>Sala</th><th>Usuário (email)</th><th>Ações</th></tr>';
foreach ($rows as $r) {
  echo '<tr>';
  echo '<td>'.h($r["codigo_reserva"]).'</td>';
  echo '<td>'.h($r["data_reserva"]).'</td>';
  echo '<td>'.h($r["horario_inicio"]).'</td>';
  echo '<td>'.h($r["horario_termino"]).'</td>';
  echo '<td>'.h($r["status"]).'</td>';
  echo '<td>'.h($r["numero_sala"]).'</td>';
  echo '<td>'.h($r["email_usuario"]).'</td>';
  echo '<td>';
  echo '<a href="?entidade=reserva&acao=editar&codigo='.urlencode($r["codigo_reserva"]).'">Editar</a> | ';
  if ($r["status"]==='ativa') {
    echo '<a href="?entidade=reserva&acao=cancelar&codigo='.urlencode($r["codigo_reserva"]).'" onclick="return confirm(\'Cancelar?\')">Cancelar</a> | ';
  }
  echo '<a href="?entidade=reserva&acao=excluir&codigo='.urlencode($r["codigo_reserva"]).'" onclick="return confirm(\'Excluir?\')">Excluir</a>';
  echo '</td>';
  echo '</tr>';
}
echo '</table>';
