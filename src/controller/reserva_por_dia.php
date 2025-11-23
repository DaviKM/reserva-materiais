<?php
require_once __DIR__ . '/../dao/ReservaDAO.php';
require_once __DIR__ . '/../dao/SalaDAO.php';
$dao = new ReservaDAO();
$sdao = new SalaDAO();
$salas = $sdao->listarTodos();

$data = isset($_GET['data'])?$_GET['data']:'';
$sala = isset($_GET['sala'])?$_GET['sala']:'';
$rows = array();
if ($data!=='') {
  $rows = ($sala!=='') ? $dao->listarPorDia($data, $sala) : $dao->listarPorDia($data, null);
}

echo '<h2>Reservas por dia</h2>';
echo '<form method="get">';
echo '<input type="hidden" name="entidade" value="reserva">';
echo '<input type="hidden" name="acao" value="por_dia">';
echo 'Data (YYYY-MM-DD): <input type="text" name="data" value="'.h($data).'"> ';
echo 'Sala (opcional): <select name="sala"><option value="">(todas)</option>';
foreach ($salas as $s) {
  $sel = ($sala===$s['numero_sala'])?' selected':'';
  echo '<option value="'.h($s['numero_sala']).'"'.$sel.'>'.h($s['numero_sala']).'</option>';
}
echo '</select> ';
echo '<button type="submit">Listar</button>';
echo '</form>';

if ($data!=='') {
  echo '<h3>Resultados</h3>';
  if (!$rows) {
    echo '<p>Nenhuma reserva encontrada.</p>';
  } else {
    echo '<table><tr><th>Código</th><th>Data</th><th>Início</th><th>Término</th><th>Status</th><th>Sala</th><th>Usuário</th></tr>';
    foreach ($rows as $r) {
      echo '<tr>';
      echo '<td>'.h($r["codigo_reserva"]).'</td>';
      echo '<td>'.h($r["data_reserva"]).'</td>';
      echo '<td>'.h($r["horario_inicio"]).'</td>';
      echo '<td>'.h($r["horario_termino"]).'</td>';
      echo '<td>'.h($r["status"]).'</td>';
      echo '<td>'.h($r["numero_sala"]).'</td>';
      echo '<td>'.h($r["email_usuario"]).'</td>';
      echo '</tr>';
    }
    echo '</table>';
  }
}
