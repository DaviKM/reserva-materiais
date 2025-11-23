<?php
require_once __DIR__ . '/../dao/SalaDAO.php';
$dao = new SalaDAO();
$salas = $dao->listarTodos();

echo '<h2>Salas</h2>';
echo '<p><a href="?entidade=sala&acao=criar">Nova Sala</a> | <a href="/gestaosalas_app/public/index.php">Home</a></p>';
echo '<table><tr><th>Número</th><th>Capacidade</th><th>Recursos</th><th>Horário</th><th>Ações</th></tr>';
foreach ($salas as $s) {
  echo '<tr>';
  echo '<td>'.h($s["numero_sala"]).'</td>';
  echo '<td>'.h($s["capacidade"]).'</td>';
  echo '<td>'.h($s["recursos_disponiveis"]).'</td>';
  echo '<td>'.h($s["horario_funcionamento"]).'</td>';
  echo '<td><a href="?entidade=sala&acao=editar&numero='.urlencode($s["numero_sala"]).'">Editar</a> | 
            <a href="?entidade=sala&acao=excluir&numero='.urlencode($s["numero_sala"]).'" onclick="return confirm(\'Excluir?\')">Excluir</a></td>';
  echo '</tr>';
}
echo '</table>';
