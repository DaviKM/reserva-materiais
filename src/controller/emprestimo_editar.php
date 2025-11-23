<?php
require_once __DIR__ . '/../dao/EmprestimoDAO.php';
require_once __DIR__ . '/../dao/MaterialDAO.php';
require_once __DIR__ . '/../dao/AlunoDAO.php';

$dao = new EmprestimoDAO();
$mdao = new MaterialDAO();
$adao = new AlunoDAO();

$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id === '') { header('Location: ?entidade=emprestimo&acao=listar'); exit; }

$row = $dao->buscarPorId($id);
if (!$row) { echo '<p>Empréstimo não encontrado.</p>'; exit; }

$materiais = $mdao->listarTodos();
$alunos = $adao->listarTodos();

$erros = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $data_emp = trim($_POST['data_emprestimo'] ?? '');
    $data_dev = trim($_POST['data_devolucao'] ?? '');
    $aluno    = trim($_POST['id_aluno'] ?? '');
    $material = trim($_POST['id_material'] ?? '');

    if ($data_emp === '') $erros[] = 'Data de empréstimo é obrigatória.';
    if ($data_dev === '') $erros[] = 'Data de devolução é obrigatória.';
    if ($aluno === '')    $erros[] = 'Selecione um aluno.';
    if ($material === '') $erros[] = 'Selecione um material.';
    if ($data_emp !== '' && $data_dev !== '' && $data_emp > $data_dev) $erros[] = 'A data de devolução deve ser posterior à data de empréstimo.';

    if (empty($erros)) {
        try {
            $dao->atualizar($id, $aluno, $material, $data_emp, $data_dev);
            header('Location: ?entidade=emprestimo&acao=listar');
            exit;
        } catch (Exception $e) {
            $erros[] = $e->getMessage();
        }
    }
}

echo '<h2>Editar Empréstimo</h2>';
if (!empty($erros)) { echo '<div style="color:#a00">'.implode('<br>', array_map('h', $erros)).'</div>'; }

echo '<form method="post">';
csrf_input();
echo 'Data de Empréstimo: <input type="date" name="data_emprestimo" value="'.h($row['data_emprestimo']).'"><br>';
echo 'Data de Devolução: <input type="date" name="data_devolucao" value="'.h($row['data_devolucao']).'"><br>';

echo 'Aluno: <select name="id_aluno">';
foreach ($alunos as $a) {
    $sel = ($a['matricula'] == $row['id_aluno']) ? ' selected' : '';
    echo '<option value="'.h($a['matricula']).'"'.$sel.'>'.h($a['matricula']).' - '.h($a['nome']).'</option>';
}
echo '</select><br>';

echo 'Material: <select name="id_material">';
foreach ($materiais as $m) {
    $sel = ($m['id_material'] == $row['id_material']) ? ' selected' : '';
    echo '<option value="'.h($m['id_material']).'"'.$sel.'>'.h($m['nome']).' (Disponíveis: '.h($m['quantidade_disp']).')</option>';
}
echo '</select><br>';

echo '<button type="submit">Salvar</button> ';
echo '<a href="?entidade=emprestimo&acao=listar">Cancelar</a>';
echo '</form>';
