<?php
require_once __DIR__ . '/../dao/MaterialDAO.php';

$dao = new MaterialDAO();
$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id !== '') {
    try {
        $dao->excluir($id);
    } catch (Exception $e) {
        echo '<p style="color:#a00">'.h($e->getMessage()).'</p>';
        echo '<p><a href="?entidade=material&acao=listar">Voltar</a></p>';
        exit;
    }
}

header('Location: ?entidade=material&acao=listar');
exit;
?>