<?php
require_once __DIR__ . '/../dao/AlunoDAO.php';

$dao = new AlunoDAO();
$matricula = isset($_GET['matricula']) ? $_GET['matricula'] : '';
if ($matricula !== '') {
    try {
        $dao->excluir($matricula);
    } catch (Exception $e) {
        echo '<p style="color:#a00">'.h($e->getMessage()).'</p>';
        echo '<p><a href="?entidade=aluno&acao=listar">Voltar</a></p>';
        exit;
    }
}

header('Location: ?entidade=aluno&acao=listar');
exit;

