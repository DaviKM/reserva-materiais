<?php
require_once __DIR__ . '/../dao/EmprestimoDAO.php';
require_once __DIR__ . '/../dao/MaterialDAO.php';

$dao = new EmprestimoDAO();
$mdao = new MaterialDAO();
$materiais = $mdao->listarTodos();

$data = isset($_GET['data']) ? $_GET['data'] : '';
$material = isset($_GET['material']) ? $_GET['material'] : '';

$rows = array();
if ($data !== '') {
    $rows = ($material !== '') 
        ? $dao->listarPorDia($data, $material)
        : $dao->listarPorDia($data, null);
}

echo '<h2>Empréstimos por dia</h2>';
echo '<form method="get">';
echo '<input type="hidden" name="entidade" value="emprestimo">';
echo '<input type="hidden" name="acao" value="por_dia">';

echo 'Data (YYYY-MM-DD): <input type="text" name="data" value="' . h($data) . '"> ';

echo 'Material (opcional): <select name="material"><option value="">(todos)</option>';
foreach ($materiais as $m) {
    $sel = ($material === (string)$m['id_material']) ? ' selected' : '';
    echo '<option value="' . h($m['id_material']) . '"' . $sel . '>'
            . h($m['nome']) . ' (ID ' . h($m['id_material']) . ')</option>';
}
echo '</select> ';

echo '<button type="submit">Listar</button>';
echo '</form>';

if ($data !== '') {
    echo '<h3>Resultados</h3>';

    if (!$rows) {
        echo '<p>Nenhum empréstimo encontrado.</p>';
    } else {
        echo '<table>';
        echo '<tr>
                <th>ID</th>
                <th>Aluno</th>
                <th>Material</th>
                <th>Data Empréstimo</th>
                <th>Data Devolução</th>
                <th>Status</th>
              </tr>';

        foreach ($rows as $r) {
            echo '<tr>';
            echo '<td>' . h($r["id_emprestimo"]) . '</td>';
            echo '<td>' . h($r["id_aluno"]) . '</td>';
            echo '<td>' . h($r["id_material"]) . '</td>';
            echo '<td>' . h($r["data_emprestimo"]) . '</td>';
            echo '<td>' . h($r["data_devolucao"]) . '</td>';
            echo '<td>' . h($r["status"]) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
}
