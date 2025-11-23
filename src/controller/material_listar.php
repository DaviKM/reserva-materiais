<?php
require_once __DIR__ . '/../dao/MaterialDAO.php';
$dao = new MaterialDAO();
$materiais = $dao->listarTodos();

echo '<h2>Materiais Esportivos</h2>';
echo '<p><a href="?entidade=material&acao=criar">Novo Material</a> | <a href="/reservamateriais_app/public/index.php">Home</a></p>';

echo '<table>';
echo '<tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Total</th>
        <th>Disponível</th>
        <th>Estado</th>
        <th>Ações</th>
      </tr>';

foreach ($materiais as $m) {
    echo '<tr>';
    echo '<td>'.h($m["id_material"]).'</td>';
    echo '<td>'.h($m["nome"]).'</td>';
    echo '<td>'.h($m["categoria"]).'</td>';
    echo '<td>'.h($m["quantidade_total"]).'</td>';
    echo '<td>'.h($m["quantidade_disp"]).'</td>';
    echo '<td>'.h($m["estado"]).'</td>';

    echo '<td>
            <a href="?entidade=material&acao=editar&id=' . urlencode($m["id_material"]) . '">Editar</a> |
            <a href="?entidade=material&acao=excluir&id=' . urlencode($m["id_material"]) . '" onclick="return confirm(\'Excluir este material?\')">Excluir</a>
          </td>';

    echo '</tr>';
}

echo '</table>';
