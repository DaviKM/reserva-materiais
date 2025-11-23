<?php
require_once __DIR__ . '/../dao/EmprestimoDAO.php';
$dao = new EmprestimoDAO();
$rows = $dao->listarTodos();

echo '<h2>Empréstimos</h2>';
echo '<p><a href="?entidade=emprestimo&acao=criar">Novo Empréstimo</a> | <a href="/reserva-materiais/public/index.php">Home</a></p>';

echo '<table>';
echo '<tr>
        <th>ID</th>
        <th>Aluno (Matrícula)</th>
        <th>Material</th>
        <th>Data Empréstimo</th>
        <th>Data Devolução</th>
        <th>Status</th>
        <th>Ações</th>
      </tr>';

foreach ($rows as $r) {
    echo '<tr>';
    echo '<td>'.h($r["id_emprestimo"]).'</td>';
    echo '<td>'.h($r["id_aluno"]).'</td>';
    echo '<td>'.h($r["id_material"]).'</td>';
    echo '<td>'.h($r["data_emprestimo"]).'</td>';
    echo '<td>'.h($r["data_devolucao"]).'</td>';
    echo '<td>'.h($r["status"]).'</td>';

    echo '<td>';
    echo '<a href="?entidade=emprestimo&acao=editar&id=' . urlencode($r["id_emprestimo"]) . '">Editar</a> | ';

    if ($r["status"] === 'ativo') {
        echo '<a href="?entidade=emprestimo&acao=finalizar&id=' . urlencode($r["id_emprestimo"]) . '" onclick="return confirm(\'Finalizar este empréstimo?\')">Finalizar</a> | ';
    }

    echo '<a href="?entidade=emprestimo&acao=excluir&id=' . urlencode($r["id_emprestimo"]) . '" onclick="return confirm(\'Excluir?\')">Excluir</a>';
    echo '</td>';

    echo '</tr>';
}

echo '</table>';
